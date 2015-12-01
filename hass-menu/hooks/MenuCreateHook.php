<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\menu\hooks;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;

use yii\validators\UrlValidator;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class MenuCreateHook implements ListenerProviderInterface
{

    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener(\hass\menu\Module::EVENT_MENU_LINK_CREATE, [
            $this,
            "onCreateLink"
        ]);
    }

    public function onCreateLink($event)
    {
        $event->parameters->set("menu", [
            $this,
            "createLink"
        ]);
    }

    public function createLink($name,$original)
    {
        $url = $original;

        $validator = new UrlValidator();

        if ($validator->validate($url) == false) {
            $url = '/' . ltrim($url, '/');
            $value =  parse_url($url);
            if(isset($value["path"]))
            {
                $config = [];
                if(isset($value["query"]))
                {
                    parse_str($value["query"],$config);
                }
                array_unshift($config, $value["path"]);
                $url =$config ;
            }
        }
        return [
            $name,
            $url
        ];
    }
}
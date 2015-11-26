<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\page\hooks;

use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class SearchModel implements ListenerProviderInterface
{

    public function provideListeners(ListenerAcceptorInterface $acceptor)
    {
        $acceptor->addListener(\hass\search\Module::EVENT_SEARCH_CONFIG, [
            $this,
            "onEvent"
        ]);
    }

    public function onEvent($event)
    {
      $event->parameters->set("page", [
           "like"=>[
               "class"=>'\hass\page\models\Page',
               "fields"=>[
                   "title",
                   "content"
               ]
           ],
          "sphinx"=>"pagert",
          "xunsearch"=>"@hass/page/xsconfig/page.ini"
        ]);
    }
}
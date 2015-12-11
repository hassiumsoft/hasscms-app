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

use hass\page\models\Page;
use hass\base\helpers\Util;
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
        $event->parameters->set("page", [
            $this,
            "createLink"
        ]);
    }

    public function createLink($name, $original)
    {
        
        $appDefaultPage = Page::getAppDefaultPage();
        
        if ($original == $appDefaultPage["id"]) {

            if (empty($name)) {
                $name = $appDefaultPage["title"];
            }
            
            $urlManager = HASS_APP_BACKEND == true ? \Yii::$app->get("appUrlManager") : \Yii::$app->getUrlManager();
            
            if ($urlManager->showScriptName) {
                $url = $urlManager->getScriptUrl();
            } else {
                $url =  $urlManager->getBaseUrl() . '/';
            }
            
            return [
                $name,
                $url
            ];
        }
        
        $model = Page::findOne($original);
        if (empty($name)) {
            $name = $model->title;
        }
        
        return [
            $name,
            Util::getEntityUrl($model)
        ];
    }
}
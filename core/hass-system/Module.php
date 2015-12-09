<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\system;

use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;
use yii\web\Application;
use hass\base\helpers\Util;
use yii\helpers\Url;
use hass\base\components\UrlManager;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Module extends \hass\module\BaseModule implements BootstrapInterface
{

    const EVENT_SYSTEM_GROUPNAV = "EVENT_SYSTEM_GROUPNAV";

    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ], 100000);
        
        Hook::on(\hass\backend\Module::EVENT_ADMIN_NAVBAR, [
            $this,
            "onSetNavbar"
        ], 100000);
        
        \Yii::$app->on(Application::EVENT_BEFORE_ACTION, [
            $this,
            "onSetLeftNav"
        ]);
        
        \Yii::$app->getUrlManager()->on(UrlManager::EVENT_CREATE_PARAMS, function ($event) {
            $event->urlParams = array_merge([
                "menu-group" => \Yii::$app->getRequest()
                    ->get("menu-group")
            ], (array) $event->urlParams);
        });
    }

    /**
     *
     * @param \yii\base\ActionEvent $event            
     */
    public function onSetLeftNav($event)
    {
        $group = \Yii::$app->getRequest()->get("menu-group", null);
        
        if ($group == null) {
            return \Yii::$app->getResponse()->redirect(Url::to([
                "/$this->id/default/controlpanel",
                "menu-group" => ModuleGroupEnmu::SYSTEM
            ]));
        } else {
            $parameters = Hook::trigger(static::EVENT_SYSTEM_GROUPNAV)->parameters;
            $navs = $parameters->get($group, []);
            
            $groupParams = [
                "menu-group" => $group
            ];
            
            // 根据控制器重定向导航第一个页面
            if (\Yii::$app->controller->getRoute() == ltrim(\Yii::$app->defaultRoute, "/")) {
                $nav = Util::getFirstNav($navs);
                if ($nav) {
                    return \Yii::$app->getResponse()->redirect(Url::to(array_merge($nav["url"], $groupParams)));
                }
            }
            
            Hook::on(\hass\backend\Module::EVENT_ADMIN_LEFTNAV, function ($event) use($navs) {
                $event->parameters->fromArray($navs);
            });
        }
    }

    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetNavbar($event)
    {
        $groups = ModuleGroupEnmu::listData();
        foreach ($groups as $id => $name) {
            $event->parameters->set($id, [
                'url' => [
                    \Yii::$app->defaultRoute,
                    "menu-group" => $id
                ],
                'label' => $name
            ]);
        }
    }
    
   

    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::SYSTEM, [
            [
                'url' => [
                    "/$this->id/default/controlpanel"
                ],
                'icon' => "fa-circle-o",
                'label' => '控制面板'
            ],
            [
                'url' => [
                    "/$this->id/cache/index"
                ],
                'icon' => "fa-circle-o",
                'label' => '缓存清理'
            ]
        ]);
    }
}
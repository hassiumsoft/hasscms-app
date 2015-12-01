<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\menu;

use hass\module\BaseModule;
use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\menu\hooks\MenuCreateHook;
use hass\base\helpers\Util;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{

    //menu
    const EVENT_MENU_MODULE_LINKS = "EVENT_MENU_MODULE_LINKS";
    const EVENT_MENU_LINK_CREATE = "EVENT_MENU_LINK_CREATE";//和cofig分开..因为在前台可能会用到

    public function init()
    {
        parent::init();
    }



    public function bootstrap($app)
    {

        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
        
        Hook::on(\hass\menu\Module::EVENT_MENU_MODULE_LINKS, [
            $this,
            "onMenuConfig"
        ]);
        Hook::on(new MenuCreateHook());
    }

    /**
     * @param \hass\base\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $item = [
            'label' => "菜单",
            'icon' =>  "fa-circle-o" ,
            'url' => [
                "/$this->id/default/index"
            ]
        ];
    
        $event->parameters->set(ModuleGroupEnmu::STRUCTURE,[$item]);
    }
    
    /**
     *
     * @param \hass\base\helpers\Event $event
     */
    public function onMenuConfig($event)
    {
        $event->parameters->set($this->id, [
            "name" => "自定义链接",
            "id" => $this->id,
            "tree" => null
        ]);
    }

    public static function isCurrentModule($name)
    {
        return "menu" == $name;
    }

}

?>
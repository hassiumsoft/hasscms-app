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

use hass\backend\BaseModule;
use yii\base\BootstrapInterface;
use hass\helpers\Hook;
use hass\menu\hooks\MenuCreateHook;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
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

    public function behaviors()
    {
        return [
            '\hass\system\behaviors\MainNavBehavior'
        ];
    }

    public function bootstrap($backend)
    {
        Hook::on(\hass\menu\Module::EVENT_MENU_MODULE_LINKS, [
            $this,
            "onMenuConfig"
        ]);
        Hook::on(new MenuCreateHook());
    }

    /**
     *
     * @param \hass\helpers\Event $event
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
        $model = Util::getModuleManager()->getModuleModelByClass(static::className());
        return $model->name == $name;
    }

}

?>
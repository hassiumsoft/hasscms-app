<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac;

use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;
use hass\module\BaseModule;
use hass\base\helpers\Util;

/**
 *
 * @package hass\rbac
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Module extends BaseModule implements BootstrapInterface
{

    const EVENT_RBAC_PERMISSION = "EVENT_RBAC_PERMISSION";
    
    const SUPER_PERMISSION = "*";

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
        
        Util::setComponent("authManager", [
            "class" => "\\hass\\rbac\\components\\DbManager"
        ]);
        
        Hook::on(new  \hass\rbac\hooks\Permission());
    }

    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::PEOPLE, [
            [
                'label' => "用户组",
                'icon' => "fa-users",
                'url' => [
                    "/rbac/role/index"
                ]
            ],
//             [
//                 'label' => "权限生成",
//                 'icon' => "fa-users",
//                 'url' => [
//                     "/rbac/tool/index"
//                 ]
//             ]
        ]);
    }
}
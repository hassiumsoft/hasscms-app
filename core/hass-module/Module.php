<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\module;

use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Module extends \hass\module\BaseModule implements BootstrapInterface
{

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
    }
    
    
    /**
     *
     * @param \hass\base\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::MODULE, [
            [
                'url' => [
                    "/$this->id/default/index"
                ],
                'icon' => "fa-circle-o",
                'label' => '模块管理'
            ]
        ]);
    }
}
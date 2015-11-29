<?php
/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\urlrule;

use hass\module\BaseModule;
use yii\base\BootstrapInterface;
use hass\system\enums\ModuleGroupEnmu;
use hass\base\classes\Hook;

/**
 *
 * @author zhepama <zhepama@gmail.com>
 *        
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{

    const EVENT_URLRULE_PREFIX_ENTITY = "EVENT_URLRULE_PREFIX_ENTITY";

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
    }

    /**
     *
     * @param \hass\base\helpers\Event $event            
     */
    public function onSetGroupNav($event)
    {
        $item = [
            'label' => "短Url",
            'icon' => "fa-circle-o",
            'url' => [
                "/$this->id/default/index"
            ]
        ];
        
        $event->parameters->set(ModuleGroupEnmu::STRUCTURE, [
            $item
        ]);
    }
}

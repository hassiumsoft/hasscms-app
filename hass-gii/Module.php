<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\gii;

use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\gii
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends \yii\gii\Module
{

    public $controllerNamespace = 'hass\gii\controllers';

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
            'url' => [
                '/gii/default/index'
            ],
            'icon' => "fa-circle-o",
            'label' => 'GII ',
            "activeItems" => [
                "/gii/default/view"
            ]
        ];
        
        $event->parameters->set(ModuleGroupEnmu::SYSTEM, [
            $item
        ]);
    }

    /**
     * Returns the list of the core code generator configurations.
     * 
     * @return array the list of the core code generator configurations.
     */
    protected function coreGenerators()
    {
        return [
            'model' => [
                'class' => 'hass\gii\generators\model\Generator'
            ],
            'crud' => [
                'class' => 'hass\gii\generators\crud\Generator'
            ],
            'controller' => [
                'class' => 'hass\gii\generators\controller\Generator'
            ],
            'form' => [
                'class' => 'hass\gii\generators\form\Generator'
            ],
            'module' => [
                'class' => 'hass\gii\generators\module\Generator'
            ],
            'extension' => [
                'class' => 'hass\gii\generators\extension\Generator'
            ]
        ];
    }
}

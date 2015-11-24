<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace hass\search;

use hass\backend\BaseModule;
use hass\helpers\Hook;
use hass\helpers\Util;
use hass\system\enums\ModuleGroupEnmu;
use yii\base\BootstrapInterface;

/**
 * Site search example module.
 *
 * @author HimikLab
 * @package app\modules\search
 */
class Module extends BaseModule implements BootstrapInterface
{
        
    const EVENT_SEARCH_MODELS = "EVENT_SEARCH_MODELS"; 
    
    public function bootstrap($backend)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    
        Util::setComponent("search", [
            "class"=>"\\hass\\search\\components\\Search"
        ]);
    }

    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::STRUCTURE, [
            [
                'label' => "搜索",
                'icon' => "fa-users",
                'url' => [
                    "/search/default/index"
                ]
            ]
        ]);
    }
}

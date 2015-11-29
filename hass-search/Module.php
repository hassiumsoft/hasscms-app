<?php
/**
 * @link https://github.com/himiklab/yii2-search-component-v2
 * @copyright Copyright (c) 2014 HimikLab
 * @license http://opensource.org/licenses/MIT MIT
 */

namespace hass\search;

use hass\module\BaseModule;
use hass\base\classes\Hook;
use hass\base\helpers\Util;
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
        
    const EVENT_SEARCH_CONFIG = "EVENT_SEARCH_CONFIG"; 
    
    public function bootstrap($app)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    
//         Util::setComponent("search", [
//             "class"=>"\\hass\\search\\components\\Search"
//         ]);
            
//            Util::setComponent("sphinx", [
//                'class' => 'yii\sphinx\Connection',
//                'dsn' => 'mysql:host=127.0.0.1;port=9306;',
//                'username' => '',
//                'password' => '',
//            ]);
    }

    /**
     *
     * @param \hass\base\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
//         $event->parameters->set(ModuleGroupEnmu::STRUCTURE, [
//             [
//                 'label' => "搜索",
//                 'icon' => "fa-users",
//                 'url' => [
//                     "/search/default/index"
//                 ]
//             ]
//         ]);
    }
}

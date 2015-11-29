<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\migration;

use yii\base\BootstrapInterface;
use hass\helpers\Hook;

use hass\backend\BaseModule;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Module extends BaseModule implements BootstrapInterface
{


    public function init()
    {
        parent::init();
    }

    public function bootstrap($backend)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }

    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $model = \Yii::$app->get("moduleManager")->getModuleModel($this->id);


        $event->parameters->set($model->group, [
      
                [
                    'label' => $model->title,
                    'icon' => $model->icon == "" ? "fa-circle-o" : $model->icon,
                    'url' => [
                        "/$model->name/default/index"
                    ]
                ]
 
        ]);
    }
}

?>
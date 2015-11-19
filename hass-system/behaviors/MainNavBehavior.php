<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\system\behaviors;
use yii\base\Behavior;
use hass\helpers\Hook;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class MainNavBehavior extends Behavior
{
    public function attach($owner)
    {
        $this->owner = $owner;
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }

    /**
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $model = \Yii::$app->get("moduleManager")->getModuleModel($this->owner->id);
        $item = [
            'label' => $model->title,
            'icon' => $model->icon == "" ? "fa-circle-o" : $model->icon,
            'url' => [
                "/$model->name/default/index"
            ]
        ];

        $event->parameters->set($model->group,[$item]);
    }
}
<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\revolutionslider;

use hass\base\classes\Hook;
use hass\system\enums\ModuleGroupEnmu;
use hass\base\helpers\ArrayHelper;
use hass\revolutionslider\models\Revolutionslider;
use yii\base\BootstrapInterface;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Module extends \hass\module\BaseModule implements BootstrapInterface
{

    public function bootstrap($app)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
        
        \Yii::$app->controllerMap = ArrayHelper::merge(\Yii::$app->controllerMap, [
            "revolutionslider" => 'hass\revolutionslider\controllers\RevolutionsliderController'
        ]);
    }
    
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::MODULE, [
            [
                'label' => "幻灯片",
                'icon' => "fa-cog",
                'url' => [
                    "/revolutionslider/index"
                ]
            ]
        ]);
    }

    public function install()
    {
        $sql = "CREATE TABLE " . Revolutionslider::tableName() . "(
	`revolutionslider_id` INT(11) NOT NULL AUTO_INCREMENT,
	`captions` TEXT NULL,
	`url` TEXT NULL,
	`weight` TINYINT(4) NULL DEFAULT NULL,
	PRIMARY KEY (`revolutionslider_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB";
        
        $command = \Yii::$app->getDb()->createCommand($sql);
        $command->execute();
        return true;
    }

    public function uninstall()
    {
        $models = Revolutionslider::find()->all();
        
        foreach ($models as $model) {
            $model->delete();
        }
        
        \Yii::$app->getDb()
            ->createCommand()
            ->dropTable(Revolutionslider::tableName())
            ->execute();
        
        return true;
    }

    public function upgrade()
    {
        return true;
    }
}
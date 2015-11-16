<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\backend\models;


use hass\helpers\Util;
use hass\backend\enums\StatusEnum;
/**
* This is the model class for table "{{%modules}}".
*
* @property integer $module_id
* @property string $name
* @property string $class
* @property string $title
* @property string $icon
* @property string $settings
* @property integer $notice
* @property integer $weight
* @property integer $status
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class Module extends \hass\backend\ActiveRecord
{
    const CACHE_KEY = 'hass_system_modules';

    public static function tableName()
    {
        return '{{%modules}}';
    }

    public static function findAllActive()
    {
        return Util::cache(self::CACHE_KEY,function(){
            $result = [];
            try {
                /**
                 * 这里是asc..按照从小到大的顺序加载.因为最后添加的weight是最大的
                 */
                foreach (self::find()->where(['status' => StatusEnum::STATUS_ON])->orderBy('weight ASC')->all() as $module) {
                    //$module->trigger(self::EVENT_AFTER_FIND);
                    $result[$module->name] = (object)$module->attributes;
                }
            }catch(\yii\db\Exception $e){}

            return $result;
        },3600);
    }
}
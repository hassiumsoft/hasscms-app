<?php

/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\system\models;
use Yii;
use hass\backend\behaviors\CacheFlushModel;
use hass\backend\behaviors\SetMaxSortableModel;
use hass\backend\enums\StatusEnum;
/**
* This is the model class for table "{{%modules}}".
*
* @property integer $module_id
* @property string $name
* @property string $class
* @property string $title
* @property string $group
* @property string $icon
* @property integer $notice
* @property integer $weight
* @property integer $status
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */
class Module extends  \hass\backend\models\Module
{
    public function rules()
    {
        return [
            [['name', 'class', 'title'], 'required'],
            [['name', 'class', 'title', 'icon','group'], 'trim'],
            ['name',  'match', 'pattern' => '/^[a-z]+$/'],
            ['name', 'unique'],
            ['class',  'match', 'pattern' => '/^[\w\\\]+$/'],
            ['class',  'checkExists'],
            ['icon', 'string'],
            [['status'], 'in', 'range' => [0,1]],
        ];
    }

    public function checkExists($attribute)
    {
        if(!class_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('hass/system', 'Class does not exist'));
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hass/system', 'Name'),
            'class' => Yii::t('hass/system', 'Class'),
            'title' => Yii::t('hass/system', 'Title'),
            'icon' => Yii::t('hass/system', 'Icon'),
            'group'=>Yii::t('hass/system', 'Group'),
            'weight' => Yii::t('hass/system', 'Order'),
        ];
    }

    public function behaviors()
    {
        return [
            'cache'=>[
               "class"=>CacheFlushModel::className(),
               "key"=>static::CACHE_KEY
            ],
            SetMaxSortableModel::className()
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert) == false) {
            return false;
        }
        if($insert == true)
        {
            $this->status = StatusEnum::STATUS_ON;
        }
        return true;
    }

}
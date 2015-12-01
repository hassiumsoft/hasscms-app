<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\urlrule\models;

use Yii;
use hass\base\enums\StatusEnum;

/**
 * This is the model class for table "{{%url_rule}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $pattern
 * @property string $host
 * @property string $route
 * @property string $defaults
 * @property string $suffix
 * @property string $verb
 * @property integer $mode
 * @property integer $encodeParams
 * @property integer $status
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class UrlRule extends \hass\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%url_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pattern', 'route'], 'required'],
            [['mode', 'encodeParams', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['pattern', 'host', 'route', 'defaults', 'suffix', 'verb'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('hass', 'ID'),
            'name' => Yii::t('hass', 'Name'),
            'pattern' => Yii::t('hass', 'Pattern'),
            'host' => Yii::t('hass', 'Host'),
            'route' => Yii::t('hass', 'Route'),
            'defaults' => Yii::t('hass', 'Defaults'),
            'suffix' => Yii::t('hass', 'Suffix'),
            'verb' => Yii::t('hass', 'Verb'),
            'mode' => Yii::t('hass', 'Mode'),
            'encodeParams' => Yii::t('hass', 'Encode Params'),
            'status' => Yii::t('hass', 'Status'),
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)== false)
        {
            return false;
        }

        if($insert == true)
        {
            $this->mode = 0;//0,1,2 分别代表适用于创建和解析.只能创建,只能解析
            $this->encodeParams = StatusEnum::STATUS_ON;
            $this->status = StatusEnum::STATUS_ON;
        }
        return true;
    }

    public static function getRuleByRoute($route,$params)
    {
        return static::findOne(["route"=>$route,"defaults"=>http_build_query($params),"status"=>StatusEnum::STATUS_ON]);
    }

    public static function getRuleByPattern($pattern)
    {
        return static::findOne(["pattern"=>$pattern,"status"=>StatusEnum::STATUS_ON]);
    }
}

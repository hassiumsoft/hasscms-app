<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\area\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use hass\base\enums\BooleanEnum;

/**
 * This is the model class for table "{{%area_block}}".
 *
 * @property integer $block_id
 * @property string $title
 * @property string $slug
 * @property integer $type
 * @property integer $widget
 * @property integer $config
 * @property integer $template
 * @property integer $cache
 * @property integer $used
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Block extends \hass\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area_block}}';
    }

    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
        $this->cache =  0;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['cache', 'used'], 'integer'],
            [['title', 'config', 'template', 'slug',"type","widget"], 'string'],
        ];
    }


    public function behaviors()
    {
        $behaviors = [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                "immutable"=>true,
                'ensureUnique' => true
            ]
        ];
        return $behaviors;
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert == true) {
                $this->used = BooleanEnum::FLASE;
                return true;
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'block_id' => Yii::t('hass', 'Block ID'),
            'title' => Yii::t('hass', 'Title'),
            'slug' => Yii::t('hass', 'Slug'),
            'config' => Yii::t('hass', 'Config'),
            'template' => Yii::t('hass', 'Template'),
            'cache' => Yii::t('hass', 'Cache'),
            "type"=>Yii::t('hass', 'Type'),
            'used' => Yii::t('hass', 'used'),
            'widget' => Yii::t('hass', 'Widget'),
        ];
    }


}

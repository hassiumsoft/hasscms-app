<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\revolutionslider\models;

use Yii;
use hass\base\behaviors\SetMaxSortableModel;

/**
 * This is the model class for table "{{%revolutionslider}}".
 *
 * @property integer $revolutionslider_id
 * @property string $captions
 * @property string $url
 * @property integer $weight
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Revolutionslider extends \hass\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%revolutionslider}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'safe'],
            [['weight'], 'integer'],
            ['captions',"safe"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'revolutionslider_id' => Yii::t('hass', 'Revolutionslider ID'),
            'captions' => Yii::t('hass', 'Captions'),
            'url' => Yii::t('hass', 'Url'),
            'weight' => Yii::t('hass', 'Weight'),
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) == false)
        {
            return false;
        }
        $this->captions = serialize($this->captions);
        return true;
    }

    public function afterFind()
    {
        parent::afterFind();

        $captions = unserialize($this->captions);

        $result = [];

        if(!empty($captions))
        {
            foreach ($captions as $caption)
            {
                $result[] = new CaptionForm($caption);
            }
        }

        $this->setAttribute("captions", $result);
    }

    public function behaviors()
    {
        $behaviors = [
            SetMaxSortableModel::className()
        ];

        $behaviors["thumbnailFile"] = [
            'class' => \hass\attachment\behaviors\UploadBehavior::className(),
            'attribute' => 'thumbnail'
        ];
        return $behaviors;
    }
}

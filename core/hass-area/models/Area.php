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
use hass\base\helpers\Serializer;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property integer $area_id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $blocks
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Area extends \hass\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'slug', 'description'], 'required'],
            [['title', 'slug', 'description'], 'string'],
            ["blocks","safe"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'area_id' => Yii::t('hass', 'Area ID'),
            'title' => Yii::t('hass', 'Title'),
            'slug' => Yii::t('hass', 'Slug'),
            'description' => Yii::t('hass', 'Description'),
            'blocks' => Yii::t('hass', 'Blocks'),
        ];
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert) == false) {
            return false;
        }
        $this->blocks = Serializer::serialize($this->blocks);
        return true;

    }

    public function afterFind()
    {
        parent::afterFind();
        $this->blocks = Serializer::unserialize($this->blocks);
    }

    public function getBlocks() {
        if(!empty($this->blocks))
        {
            $query =   Block::find()->where(['block_id' => $this->blocks])->orderBy([new \yii\db\Expression('FIELD (block_id, ' . implode(', ', $this->blocks) . ')')]);
            return $query->all();
        }
        return [];
    }
}

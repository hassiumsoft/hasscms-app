<?php

namespace hass\taxonomy\models;

use hass\base\traits\GetEntityObject;
use Yii;

/**
 * This is the model class for table "{{%taxonomy_index}}".
 *
 * @property string $taxonomy_index_id
 * @property string $entity
 * @property string $entity_id
 * @property string $taxonomy_id
 */
class TaxonomyIndex extends \yii\db\ActiveRecord
{
    use GetEntityObject;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%taxonomy_index}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'taxonomy_id'], 'required'],
            [['entity_id', 'taxonomy_id'], 'integer'],
            [['entity'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity_id' => Yii::t('hass\taxonomy', 'Object ID'),
            'taxonomy_id' => Yii::t('hass\taxonomy', 'Taxonomy ID'),
            'entity' => Yii::t('hass\taxonomy', 'entity'),
        ];
    }



}

<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\attachment\models;

use Yii;

/**
* This is the model class for table "{{%attachment_index}}".
*
* @property integer $attachment_id
* @property string $entity_id
* @property string $entity
* @property string $attribute
*
* @property Attachment $attachment
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class AttachmentIndex extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%attachment_index}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attachment_id', 'entity_id'], 'integer'],
            [['entity', 'attribute'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => Yii::t('hass\attachment', 'attachment_id'),
            'entity_id' => Yii::t('hass\attachment', 'Item ID'),
            'entity' => Yii::t('hass\attachment', 'Model'),
            'attribute' => Yii::t('hass\attachment', 'Attribute'),
        ];
    }

}

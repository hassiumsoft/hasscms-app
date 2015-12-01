<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\comment\models;

use hass\base\traits\GetEntityObject;
use Yii;
/**
* This is the model class for table "{{%comment_status}}".
*
* @property string $entity
* @property integer $entity_id
* @property integer $status
* @property integer $total
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class CommentInfo extends \yii\db\ActiveRecord
{
    use GetEntityObject;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'status',"total"], 'integer'],
            [['entity'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'entity' => Yii::t('hass\comment', 'Model'),
            'entity_id' => Yii::t('hass\comment', 'Object ID'),
            'status' => Yii::t('hass\comment', 'Status'),
            'total' => Yii::t('hass\comment', 'Total'),
        ];
    }

    public static function primaryKey()
    {
        return ["entity_id","entity"];
    }

    public static function getEntityOrderByTotal($entity="",$limit = 10)
    {
        $query = static::find()->orderBy(["total"=>SORT_DESC])->limit($limit);
        if($entity)
        {
            $query->where(["entity"=>$entity]);
        }
        $models =$query->all();
        $result = [];
        foreach ($models as $model) {
            $result[] = $model->entityObject;
        }
        return $result;
    }
}

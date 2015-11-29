<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\meta\behaviors;

use hass\meta\models\Meta;
use Yii;
use yii\db\ActiveRecord;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class MetaBehavior extends \yii\base\Behavior
{
    use \hass\base\traits\EntityRelevance;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterSave()
    {
        $model = $this->getMetaModel();
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
        }
    }

    public function afterDelete()
    {
        $this->getMetaModel()->delete();
    }

    public function getMetaModel()
    {
        $model = $this->owner->meta;
        
        if ($model == null) {
            $model = new Meta([
                'entity' => $this->getEntityClass(),
                'entity_id' => $this->getEntityId()
            ]);
        }
        return $model;
    }

    public function getMeta()
    {
        return $this->owner->hasOne(Meta::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])
            ->where([
            "entity" => $this->getEntityClass()
        ]);
    }
}
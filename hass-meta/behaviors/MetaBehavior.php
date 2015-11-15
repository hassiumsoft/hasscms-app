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
 * @since 1.0
 */
class MetaBehavior extends \yii\base\Behavior
{
    private $_model;
    use \hass\helpers\traits\EntityRelevance;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterInsert()
    {
        if ($this->meta->load(Yii::$app->request->post())) {
            if (!$this->meta->isEmpty()) {
                $this->meta->save();
            }
        }
    }

    public function afterUpdate()
    {
        if ($this->meta->load(Yii::$app->request->post())) {
            if (!$this->meta->isEmpty()) {
                $this->meta->save();
            } else {
                if ($this->meta->primaryKey) {
                    $this->meta->delete();
                }
            }
        }
    }

    public function afterDelete()
    {
        if (!$this->meta->isNewRecord) {
            $this->meta->delete();
        }
    }

    public function getMeta_h1()
    {
        return $this->meta->h1;
    }

    public function getMeta_title()
    {
        return $this->meta->title;
    }

    public function getMeta_keywords()
    {
        return $this->meta->keywords;
    }

    public function getMeta_description()
    {
        return $this->meta->description;
    }

    public function getMeta()
    {
        if (!$this->_model) {
            if ($this->owner && $this->getEntityId()) {
                $itemModel = $this->getEntityClass();
                $this->_model = Meta::findOne(['entity' => $itemModel, 'entity_id' => $this->getEntityId()]);
                if (!$this->_model) {
                    $this->_model = new Meta([
                        'entity' => $itemModel,
                        'entity_id' => $this->getEntityId()
                    ]);
                }
            } else {
                $this->_model = new Meta();
            }
        }

        return $this->_model;
    }
}
<?php
/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\behaviors;

use hass\comment\models\Comment;
use yii\base\Behavior;
use hass\comment\models\CommentInfo;
use hass\base\ActiveRecord;

/**
 * Comments Behavior.
 *
 * Render comments and form for owner model
 *   <?= $form->field($model, 'CommentInfo')->dropDownList(CommentInfoEnum::listdata(), ['class' => '']) ?>
 *
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
class CommentBehavior extends Behavior
{
    use \hass\base\traits\EntityRelevance;

    public $defaultStatus;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }


    public function getComments()
    {
        return $this->owner->hasMany(Comment::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])
            ->where([
                "entity" => $this->getEntityClass()
            ]);
    }

    public function getCommentInfo()
    {
        return $this->owner->hasOne(CommentInfo::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])
            ->where([
                "entity" => $this->getEntityClass()
            ]);
    }

    public function getCommentEnabled()
    {
        $model = $this->owner->commentInfo;
        if ($model == null || $model->status == null) {
            return $this->defaultStatus;
        }
        return $model->status;
    }

    public function getCommentTotal()
    {
        $model = $this->owner->commentInfo;
        if ($model == null) {
            return 0;
        }
        return $model->total;
    }

    public function afterInsert()
    {
        $postData = \Yii::$app->request->post($this->owner->formName());
        $status = $postData['commentEnabled'];
        if ($status == $this->defaultStatus) {
            return;
        }
        $model = new CommentInfo();
        $model->entity = $this->getEntityClass();
        $model->entity_id = $this->getEntityId();
        $model->status = $status;
        $model->save();
    }

    public function afterUpdate()
    {
        $postData = \Yii::$app->request->post($this->owner->formName());
        $status = $postData['commentEnabled'];

        /* @var $model \hass\comment\models\CommentInfo */
        $model = $this->owner->commentInfo;
        if ($model == null) {
            if ($status == $this->defaultStatus) {
                return;
            }
            $this->afterInsert();
            return;
        }
        $entity = $this->getEntityClass();
        $entity_id = $this->getEntityId();

        if ($status == $this->defaultStatus && $model->total == 0) {
            CommentInfo::deleteAll(['entity' => $entity, 'entity_id' => $entity_id]);
        }
        else
        {
            $model->status = $status;
            $model->save();
        }
    }

    public function afterDelete()
    {
        $entity = $this->getEntityClass();
        $entity_id = $this->getEntityId();
        CommentInfo::deleteAll(['entity' => $entity, 'entity_id' => $entity_id]);
        Comment::deleteAll(['entity' => $entity, 'entity_id' => $entity_id]);
    }
}

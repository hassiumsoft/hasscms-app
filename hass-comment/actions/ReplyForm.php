<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\actions;

use yii\base\Action;

use Yii;
use hass\comment\widgets\CommentsForm;
use hass\comment\models\Comment;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class ReplyForm extends Action
{

    public function run()
    {
        $model = new  Comment();
        $model->parent_id=(int)Yii::$app->getRequest()->post('parent_id');
        $model->entity=(string)Yii::$app->getRequest()->post('entity');
        $model->entity_id=(int)Yii::$app->getRequest()->post('entity_id');
        $content = CommentsForm::widget(["model"=>$model]);
        return $this->controller->renderJsonMessage(true,$content);
    }
}
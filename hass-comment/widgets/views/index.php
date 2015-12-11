<?php
use hass\comment\widgets\CommentsForm;
use hass\comment\widgets\CommentsList;

/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */

?>

<div class="panel">
	<div class="panel-body">
       <?=CommentsForm::widget(['entity' =>$entity,"entity_id" => $entity_id,"commentUrl" => $commentUrl]);?>
    </div>
</div>
<?=CommentsList::widget(['entity' =>$entity,"entity_id" => $entity_id,"replyFormUrl" => $replyFormUrl]);?>
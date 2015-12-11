<?php
use hass\comment\widgets\CommentsList;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\timeago\TimeAgo;
use hass\comment\widgets\assets\CommentsAsset;
use hass\comment\Module;
/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */
CommentsAsset::register($this);

?>


<?php if($nestedLevel == 1):?>
<div id="comment-list">
<?php endif;?>

<?php
$containerClass = (ArrayHelper::getValue($dataProvider->query->where,
    'parent_id')) ? 'sub-comments' : 'comments';
?>
<?php foreach ($dataProvider->getModels() as $model):?>

<?php
list($avatar,$username) = Module::getUserInfo($model);


?>


<div class="media <?=$containerClass?>" id="comment-<?=$model->comment_id?>">
  <div class="media-left">

      <img class="media-object" style ="width: 54px; height: 54px;" src="<?= $avatar ?>" >

  </div>
  <div class="media-body">
    <div class="media-heading">
        <span class="author"><?= HtmlPurifier::process($username); ?></span>
        <span class="time dot-left dot-right"><?= TimeAgo::widget(['timestamp' => $model->created_at]); ?></span>
    </div>

    <div class="comment-content">
        <?= HtmlPurifier::process($model->content); ?>
    </div>
     <?php if ($nestedLevel < $maxNestedLevel): ?>
    <div class="comment-footer">
         <a class="reply-button" data-parent-id="<?= $model->comment_id; ?>" data-entity="<?= $model->entity; ?>" data-entity-id="<?= $model->entity_id; ?>" href="#">回复</a>
    </div>
     <div class="reply-form" data-nestedLevel="<?=$nestedLevel?>">

     </div>
     <?php
     if ($model->isReplied()) {
         echo CommentsList::widget(['entity' =>$entity,"entity_id" => $entity_id,"parent_id"=>$model->comment_id,"nestedLevel"=>$nestedLevel+1]);
     }
     ?>
    <?php endif; ?>
  </div>
</div>
<?php endforeach;?>

<?php if($nestedLevel == 1):?>
</div>
<div class="box-tools pull-right">
		<?=yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination,'options'=>['class' => 'pagination pagination-sm inline']])?>
</div>
<?php endif;?>

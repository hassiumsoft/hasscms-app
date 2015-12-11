<?php
$this->title = Yii::t('hass', 'Create news');
?>

<?php $this->beginBlock('content-header'); ?>
<h1>新建页面  </h1>
<?php $this->endBlock(); ?>


<div class="row">
<?= $this->render('_form', ['model' => $model]) ?>
</div>



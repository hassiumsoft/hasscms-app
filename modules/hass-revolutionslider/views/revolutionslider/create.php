<?php
$this->title = Yii::t('hass', 'Create news');
?>

<?php $this->beginBlock('content-header'); ?>
<h1>添加新幻灯片  </h1>
<?php $this->endBlock(); ?>



<?= $this->render('_form', ['model' => $model]) ?>



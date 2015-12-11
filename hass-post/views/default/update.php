<?php
use yii\helpers\Url;
$this->title = Yii::t('hass', 'Create news');
$module = $this->context->module->id;
?>

<?php $this->beginBlock('content-header'); ?>
<h1>修改文章 <a class="btn bg-purple btn-flat btn-xs " href="<?= Url::to(['create']) ?>"><?= Yii::t('hass', '写文章') ?></a> </h1>
<?php $this->endBlock(); ?>


<div class="row">
<?= $this->render('_form', ['model' => $model]) ?>
</div>



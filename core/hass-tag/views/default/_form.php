<?php
use yii\helpers\Html;
use hass\meta\widgets\MetaForm;
use hass\base\misc\adminlte\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true
]); ?>

<div class="box box-solid">
<?php if($model->isNewRecord):?>
    <div class="box-header with-border" >
        <h3 class="box-title"> 创建新Tag</h3>
    </div>
<?php endif;?>

<div class="box-body">
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'frequency') ?>
</div>
</div>
<?= $form->boxField($model, 'meta',["collapsed"=>true])->widget(MetaForm::className())->header("SEO"); ?>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('hass', 'Create') : Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>
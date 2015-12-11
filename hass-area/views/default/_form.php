<?php
use yii\helpers\Html;
use hass\base\misc\adminlte\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true
]); ?>

<div class="box box-solid">
<?php if($model->isNewRecord):?>
    <div class="box-header with-border" >
        <h3 class="box-title"> 创建新区域</h3>
    </div>
<?php endif;?>

<div class="box-body">
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'slug') ?>
<?= $form->field($model, 'description')->textarea() ?>
</div>
</div>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('hass', 'Create') : Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>
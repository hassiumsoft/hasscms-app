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
        <h3 class="box-title"> 创建新配置</h3>
    </div>
<?php endif;?>

<div class="box-body">
<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'value') ?>
</div>
</div>
<?= Html::submitButton(Yii::t('hass', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
<?php ActiveForm::end(); ?>
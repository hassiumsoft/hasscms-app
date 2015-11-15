<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hass\system\enums\ModuleGroupEnmu;
?>

<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title"><?php echo $model->isNewRecord ? Yii::t('hass', '引入新模块') : Yii::t('hass', '修改模块')?></h3>
	</div>
	<div class="box-body">
<?= $form->field($model, 'name')?>
<?= $form->field($model, 'class')?>
<?= $form->field($model, 'title')?>
<?= $form->field($model, 'group')->dropDownList(ModuleGroupEnmu::listdata())?>
<?= $form->field($model, 'icon')?>
</div>
</div>

<div class="form-group">
   <?= Html::submitButton($model->isNewRecord ? Yii::t('hass', 'Create') : Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>
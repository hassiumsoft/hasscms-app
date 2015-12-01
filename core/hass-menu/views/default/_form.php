<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model hass\menu\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<div class="box box-solid">
<?php if($model->isNewRecord):?>
    <div class="box-header with-border">创建新菜单</div>
<?php endif;?>
	<div class="box-body">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'title')->textarea(['rows' => 3])?>
</div>
</div>
<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('hass', 'Create') : Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block '])?>
</div>

<?php ActiveForm::end(); ?>

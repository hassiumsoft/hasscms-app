<?php

use hass\theme\assets\ThemeAsset;
use hass\base\misc\adminlte\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $theme hass\theme\models\Theme */
$this->title = Yii::t('hass', '自定义css');
$this->params['breadcrumbs'][] = $this->title;

ThemeAsset::register($this);
?>

<div id="template">

<?php $form = ActiveForm::begin()?>

<?php echo $form->field($model,"text")->textarea(['rows' => 30,'cols'=>70])?>

<div class="form-group">
        <?= Html::submitButton("保存CSS", ['class' => 'btn bg-maroon btn-flat btn-block '])?>
</div>

<?php ActiveForm::end()?>

</div>
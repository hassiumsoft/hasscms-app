<?php
/* @var $this yii\web\View */
/* @var $model hass\menu\models\Menu */

$this->title = Yii::t('hass/menu', 'Update {modelClass}: ', [
    'modelClass' => 'Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('hass/menu', 'Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('hass/menu', 'Update');
?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>

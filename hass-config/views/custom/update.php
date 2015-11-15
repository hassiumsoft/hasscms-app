<?php


/* @var $this yii\web\View */
/* @var $model hass\modules\taxonomy\models\Taxonomy */

$this->title = 'Update Config: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Config', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Config';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>


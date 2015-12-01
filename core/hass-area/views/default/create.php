<?php


/* @var $this yii\web\View */
/* @var $model hass\bases\taxonomy\models\Taxonomy */

$this->title = 'Create Area ';
$this->params['breadcrumbs'][] = ['label' => 'Areas', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'create Area';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>


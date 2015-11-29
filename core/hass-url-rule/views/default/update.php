<?php


/* @var $this yii\web\View */
/* @var $model hass\modules\taxonomy\models\Taxonomy */

$this->title = 'Update Rule';
$this->params['breadcrumbs'][] = ['label' => 'rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Rule';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>


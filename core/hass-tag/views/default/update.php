<?php


/* @var $this yii\web\View */
/* @var $model hass\bases\taxonomy\models\Taxonomy */

$this->title = 'Update Tag';
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Tag';
?>


<?= $this->render('_form', [
    'model' => $model
]) ?>


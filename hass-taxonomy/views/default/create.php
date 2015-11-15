<?php


/* @var $this yii\web\View */
/* @var $model hass\taxonomy\models\Taxonomy */

$this->title = 'Update Taxonomy: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Taxonomies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->primaryKey]];
$this->params['breadcrumbs'][] = 'Update';
?>


	<?= $this->render('_form', [
    'model' => $model,
	    'parentId'=>$parentId
]) ?>



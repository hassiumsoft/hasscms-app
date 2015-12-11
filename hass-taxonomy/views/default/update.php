<?php


/* @var $this yii\web\View */
/* @var $model hass\taxonomy\models\Taxonomy */

$this->title = '分类修改';
$this->params['breadcrumbs'][] = ['label' => 'Taxonomies', 'url' => ['index']];
$this->params['breadcrumbs'][] = '分类修改';
?>


	<?= $this->render('_form', [
    'model' => $model,
	    'parentId'=>$parentId
]) ?>


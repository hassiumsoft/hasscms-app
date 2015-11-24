<?php


/* @var $this yii\web\View */
/* @var $model hass\taxonomy\models\Taxonomy */

$this->title = '用户组修改';
$this->params['breadcrumbs'][] = ['label' => '用户组', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


	<?= $this->render('_form', [
    'model' => $model
]) ?>


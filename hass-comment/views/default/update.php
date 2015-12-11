<?php


/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */

$this->title = '修改评论';
$this->params['breadcrumbs'][] = ['label' => '评论首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = '修改评论';
?>
 <?= $this->render('_form', compact('model')) ?>
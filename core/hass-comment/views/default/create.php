<?php


/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */

$this->title = '添加评论';
$this->params['breadcrumbs'][] = ['label' => '评论首页', 'url' => ['index']];
$this->params['breadcrumbs'][] = '添加评论';
?>
 <?= $this->render('_form', compact('model')) ?>
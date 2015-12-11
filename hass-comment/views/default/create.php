<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model hass\comment\models\Comment */

$this->title = Yii::t('hass/comment', 'Create Comment');
$this->params['breadcrumbs'][] = ['label' => Yii::t('hass/comment', 'Comments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

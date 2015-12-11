<?php

/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View 					$this
 * @var dektrium\user\models\User 		$user
 * @var dektrium\user\models\Profile 	$profile
 */

?>

<?php $this->beginContent('@hass/user/views/admin/update.php', ['user' => $user]) ?>

<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'enableClientValidation' => false
]); ?>

<?= $form->field($profile, 'name') ?>
<?= $form->field($profile, 'public_email') ?>
<?= $form->field($profile, 'website') ?>
<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'bio')->textarea() ?>


<div class="form-group">
   <?= Html::submitButton( Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>

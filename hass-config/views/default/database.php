<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\widgets\ActiveForm;

use yii\helpers\Html;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
?>

	<?php

$form = ActiveForm::begin([
    'id' => 'db-setting-form',
    'enableAjaxValidation' => true
]);
?>


	<?=$form->field($model, 'hostname')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])->hint('You should be able to get this info from your web host, if localhost does not work.')?>


	<?=$form->field($model, 'username')->textInput(['autocomplete' => 'off','class' => 'form-control'])->hint('Your MySQL username')?>


	<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])->hint('Your MySQL password')?>


	<?=$form->field($model, 'database')->textInput(['autocomplete' => 'off','class' => 'form-control'])->hint('The name of the database you want to run your application in.')?>
<?= Html::submitButton(Yii::t('hass', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block'])?>


	<?php $form::end(); ?>
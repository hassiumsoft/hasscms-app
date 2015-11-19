<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
?>
<?php

$form = \yii\widgets\ActiveForm::begin([
    'id' => 'database-form',
    'enableAjaxValidation' => FALSE,
    "options" => [
        "class" => "install-form"
    ]
]);
?>

<h2>Input mysqli info</h2>
<?=$form->field($model, 'username')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'password')->passwordInput(['class' => 'form-control'])?>
<?=$form->field($model, 'database')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>

<div class="desc">
	<p>
		Please check <strong>database information</strong> to server master.
	</p>
</div>
<p style="text-align: right">
	<a href="#advanced" role="button" data-toggle="collapse"
		aria-expanded="false" aria-controls="advanced"
		style="text-decoration: underline">Advanced Setup</a>
</p>
<div id="advanced" class="collapse">
<?=$form->field($model, 'hostname')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'port')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'prefix')->textInput(['autofocus' => 'on','autocomplete' => 'off','class' => 'form-control'])?>

	<div class="desc">
		<p>
			Please check <strong>database information</strong> to server master.
		</p>
		<p>
			You can modify database <strong>table prefix</strong>, and can use
			small letters(small letter is recommended), and numbers, but you can
			not use special letters.
		</p>
	</div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>
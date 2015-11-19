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
*/

?>
	<?php

$form = ActiveForm::begin([
    'id' => 'mail-setting-form',
    'enableAjaxValidation' => true
]);
?>

					<?=$form->field($model, 'mailHost')->textInput(['autocomplete' => 'off'])?>



					<?=$form->field($model, 'mailUsername')->textInput(['autocomplete' => 'off'])?>


					<?=$form->field($model, 'mailPassword')->passwordInput(['autocomplete' => 'off'])?>



					<?=$form->field($model, 'mailPort')->textInput(['autocomplete' => 'off'])?>


					<?=$form->field($model, 'mailEncryption')->dropDownList(['' => 'Default','ssl' => 'SSL','tls' => 'TLS'], ['class' => 'form-control'])?>



	<?= $form->field($model, 'mailUseTransport')->checkbox()?>





<?= Html::submitButton(Yii::t('hass', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block'])?>


<?php $form::end(); ?>
<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use hass\base\enums\BooleanEnum;



/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
?>
	<?php

$form = ActiveForm::begin([
    'id' => 'comment-config-form',
    'enableAjaxValidation' => true
]);
?>


<?=$form->field($model, 'maxNestedLevel')->textInput(['autofocus' => TRUE,'autocomplete' => 'off'])?>

<?=$form->field($model, 'onlyRegistered')->dropDownList(BooleanEnum::listData(), ['class' => 'form-control'])?>


<hr />

	<?=$form->field($model, 'orderDirection')->dropDownList([SORT_ASC=>"正序",SORT_DESC=>"倒叙"], ['class' => 'form-control'])?>

<?=$form->field($model, 'nestedOrderDirection')->dropDownList([SORT_ASC=>"正序",SORT_DESC=>"倒叙"], ['class' => 'form-control'])?>

	<?= Html::submitButton(Yii::t('hass', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>

	<?php $form::end(); ?>
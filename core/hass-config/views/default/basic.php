<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use yii\widgets\ActiveForm;
use hass\config\helpers\BackendThemesEnum;
use yii\caching\FileCache;
use yii\caching\DbCache;

use yii\helpers\Html;
use hass\attachment\widgets\SingleMediaWidget;
use hass\config\enums\TimeZoneEnum;
use hass\config\enums\I18nEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
hass\config\assets\ConfigAsset::register($this);
?>
	<?php

$form = ActiveForm::begin([
    'id' => 'basic-setting-form',
    'enableAjaxValidation' => true,
    'options' => [
        "enctype" => "multipart/form-data"
    ]
]);
?>
<h4>Application Settings</h4>


<?=$form->field($model, 'appName')->textInput(['autofocus' => TRUE,'autocomplete' => 'off'])?>

<?=$form->field($model, 'appDescription')->textInput(['autocomplete' => 'off'])?>
<?=$form->field($model, 'adminMail')->textInput(['autocomplete' => 'off'])?>
<?=$form->field($model, 'appTimezone')->dropDownList(TimeZoneEnum::$timezoneList,['autocomplete' => 'off'])?>
<?=$form->field($model, 'appLanguage')->dropDownList(I18nEnum::$i18nList,['autocomplete' => 'off'])?>

	<?php
echo $form->field($model, 'appLogo')->widget(SingleMediaWidget::className(), [
    "multiple" => false
])?>
<hr />

<h4>Theme Settings</h4>


<?=$form->field($model, 'appBackendTheme')->dropDownList(BackendThemesEnum::listData(), ['class' => 'form-control'])?>

					<?=$form->field($model, 'appFrontendThemePath')->textInput()?>



<?= Html::submitButton(Yii::t('hass', 'Save'), ['class' => 'btn bg-maroon btn-flat btn-block'])?>

	<?php $form::end(); ?>
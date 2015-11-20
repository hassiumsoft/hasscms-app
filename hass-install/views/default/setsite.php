<?php
use hass\config\enums\TimeZoneEnum;
use hass\config\enums\I18nEnum;
$form = \yii\widgets\ActiveForm::begin([
    'id' => 'site-form',
    'enableAjaxValidation' => FALSE,
    "options" => [
        "class" => "install-form"
    ]
]);
?>
<?=$form->field($model, 'appName')->textInput(['autocomplete' => 'off','class' => 'form-control'])?>
<?=$form->field($model, 'appDescription')->textarea(['class' => 'form-control'])?>
<?=$form->field($model, 'appTimezone')->dropDownList(TimeZoneEnum::$timezoneList,['autocomplete' => 'off'])?>
<?=$form->field($model, 'appLanguage')->dropDownList(I18nEnum::$i18nList,['autocomplete' => 'off'])?>

<?php \yii\widgets\ActiveForm::end(); ?>
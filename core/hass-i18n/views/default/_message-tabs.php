<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use hass\i18n\Module;

$items = [];
foreach ( Module::getInstallLanguages() as $lang ) {
    $message = Yii::t($model->category, $model->message, [], $lang);
    $message = ($model->message == $message && $lang != Module::getInstallLanguages()[0])
             ? '' : $message;
    $items[] = [
        'label' => '<b>' . strtoupper($lang) . '</b>',
        'content' => Html::textInput('Message[' . $lang . '][translation]', $message, [
            'id'    => 'message-' . $lang . '-translation',
            'class' => 'form-control',
            'rel'   => $lang,
            'dir'   => (in_array($lang, ['ar', 'fa']) ? 'rtl' : 'ltr'),
            'rows'  => 3,
        ]) . Html::hiddenInput('categories[' . $lang . ']', $model->category),
        'active' => ($lang == Yii::$app->language) ? true : false,
    ];
}

echo Html::beginForm("","post",["class"=>"translation-save-form"]);

echo Tabs::widget([
    'encodeLabels' => false,
    'items' => $items,
]) ;

echo Html::endForm();

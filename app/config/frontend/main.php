<?php
$params = array_merge(
    require(__DIR__ . '/../params.php'),
    require(__DIR__ . '/../params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'hassium-frontend',
    'bootstrap' => ['frontend'],
    'modules' => [
        'frontend' => 'hass\frontend\Module',
    ],
    'components' => [
        "urlManager"=>[
            "class" => '\hass\backend\components\UrlManager',//主题预览中会用到
        ],
        'view'=>[
            'class' => '\hass\frontend\components\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    // set cachePath to false in order to disable template caching
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        "string"=> '\yii\helpers\StringHelper',
                        "array"=>"\yii\helpers\ArrayHelper"
                    ],
                    'extensions'=>[
                        '\hass\frontend\twig\Extension'
                    ]
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ]
    ],
    'params' => $params,
];

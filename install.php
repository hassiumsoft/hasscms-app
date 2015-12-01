<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require (__DIR__ . '/vendor/autoload.php');
require (__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require (__DIR__ . '/core/HassClassLoader.php');
require (__DIR__ . '/app/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(require (__DIR__ . '/app/config/main.php'), require (__DIR__ . '/app/config/main-local.php'), [
    'id' => "hassium-install",
    "defaultRoute" => "/install/default/index",
    "modules" => [
        "install" => [
            'class' => "\\hass\\install\\Module"
        ],
        "user" => [
            'class' => "\\hass\\user\\Module"
        ]
    ],
    "components" => [
        'user' => [
            'identityClass' => 'hass\user\models\User'
        ],
        "cache" => [
            "class" => "\\yii\\caching\\FileCache"
        ],
        "i18n" => [
            "translations" => [
                "user*" => [
                    'class' => "\\yii\\i18n\\PhpMessageSource",
                    'basePath' => '@dektrium/user/messages'
                ]
            ]
        ]
    ],
    'params' => array_merge(require (__DIR__ . '/app/config/params.php'), require (__DIR__ . '/app/config/params-local.php'))
]);

$application = new yii\web\Application($config);
$application->run();

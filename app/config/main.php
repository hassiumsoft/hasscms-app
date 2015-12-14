<?php

define("APP_INSTALLED_NAME", "installed");

$basePath = dirname(__DIR__);
$config = [
    'language' => 'en-US',
    'sourceLanguage' => 'en-US',
    'basePath' => $basePath,
    'runtimePath' => '@storage/runtime',
    'vendorPath' => '@root/vendor',
    'bootstrap' => [
        'log',
        'packageLoader'
    ],
    'components' => [
        'assetManager' => [
            "basePath" => "@webroot/storage/assets",
            "baseUrl" => "@web/storage/assets",
            'linkAssets' => true,
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_DEBUG ? 'jquery.js' : 'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_DEBUG ? 'css/bootstrap.css' : 'css/bootstrap.min.css'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_DEBUG ? 'js/bootstrap.js' : 'js/bootstrap.min.js'
                    ]
                ]
            ]
        ],
        'cache' => [
            'class' => '\yii\caching\FileCache'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => [
                        'error',
                        'warning'
                    ]
                ]
            ]
        ],
        'moduleManager' => [
            "class" => 'hass\module\components\ModuleManager'
        ],
        'themeManager' => [
            "class" => 'hass\theme\components\ThemeManager'
        ],
        'packageLoader' => [
            "class" => 'hass\base\components\PackageLoader'
        ],
        "composerConfigurationReader" => [
            'class' => 'hass\base\components\ComposerConfigurationReader'
        ],
        "i18n" => [
            "translations" => [
                "*" => [
                    'class' => "yii\\i18n\\DbMessageSource",
                    'on missingTranslation' => [
                        '\hass\i18n\Module',
                        "missingTranslation"
                    ]
                ],
                "app*" => [
                    'class' => "yii\\i18n\\DbMessageSource",
                    'on missingTranslation' => [
                        '\hass\i18n\Module',
                        "missingTranslation"
                    ]
                ],
                "hass*" => [
                    'class' => "yii\\i18n\\DbMessageSource",
                    'on missingTranslation' => [
                        '\hass\i18n\Module',
                        "missingTranslation"
                    ]
                ]
            ]
        ],
        'db'=>[
            'class' => 'yii\db\Connection',
            'enableSchemaCache' => true,
            // Duration of schema cache.
            'schemaCacheDuration' => 3600,
            // Name of the cache component used to store schema information
            'schemaCache' => 'cache',
        ],
        'config' => [
            'class' => '\hass\config\components\Config', // Class (Required)
            'db' => 'db', // Database Connection ID (Optional)
            'tableName' => '{{%config}}', // Table Name (Optioanl)
            'cacheId' => 'cache', // Cache Id. Defaults to NULL (Optional)
            'cacheKey' => 'hass.config', // Key identifying the cache value (Required only if cacheId is set)
            'cacheDuration' => 100
        ],
        "fileStorage" => [
            'class' => '\hass\attachment\components\FileStorage',
            'filesystem' => [
                'class' => 'creocoder\flysystem\LocalFilesystem',
                'path' => '@webroot/storage/uploads'
            ],
            'baseUrl' => '@web/storage/uploads'
        ],
    ],
    "modules"=>[
        "install"=>"\\hass\\install\\Module"
    ]
];

if (YII_ENV_DEV) {
    require __DIR__ . DIRECTORY_SEPARATOR . 'dev.php';
}

//卸载dektrium的用户模块的引导
$file = Yii::getAlias('@root/vendor/yiisoft/extensions.php');
$extensions = is_file($file) ? include($file) : [];
unset($extensions['dektrium/yii2-user']['bootstrap']);
$config['extensions'] = $extensions;

return $config;
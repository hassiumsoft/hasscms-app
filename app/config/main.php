<?php
$basePath =  dirname(__DIR__);
$webroot = dirname($basePath);
$config =  [
    'language' => 'zh-CN',
    'sourceLanguage' => 'en-US',
    'basePath' => $basePath,
    'runtimePath' => $webroot . '/runtime',
    'vendorPath' => $webroot . '/vendor',
    'bootstrap' => [
        'log',
    ],
    'components' => [
       'assetManager' => [
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
            'class' => '\yii\caching\DbCache'
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
        ]
    ],
];

if (YII_ENV_DEV) {
    require __DIR__ . DIRECTORY_SEPARATOR . 'dev.php';
}
return $config;
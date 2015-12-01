<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
define('HASS_APP', 'backend');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/core/HassClassLoader.php');
require(__DIR__ . '/app/config/bootstrap.php');
require(__DIR__ . '/app/config/backend/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/app/config/main.php'),
    require(__DIR__ . '/app/config/main-local.php'),
    require(__DIR__ . '/app/config/backend/main.php'),
    require(__DIR__ . '/app/config/backend/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();

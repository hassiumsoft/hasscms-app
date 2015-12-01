<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');
define('HASS_APP', 'frontend');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/core/HassClassLoader.php');
require(__DIR__ . '/app/config/bootstrap.php');
require(__DIR__ . '/app/config/frontend/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/app/config/main.php'),
    require(__DIR__ . '/app/config/main-local.php'),
    require(__DIR__ . '/app/config/frontend/main.php'),
    require(__DIR__ . '/app/config/frontend/main-local.php')
);
$application = new yii\web\Application($config);
$application->run();

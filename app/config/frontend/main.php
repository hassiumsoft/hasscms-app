<?php
use hass\base\components\UrlManager;

$params = array_merge(require (__DIR__ . '/../params.php'), require (__DIR__ . '/../params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php'));

return [
    'id' => 'hassium-frontend',
    'bootstrap' => [
        'install',
        'frontend'
    ],
    'modules' => [
        'frontend' => 'hass\frontend\Module',
        "user" => [
            'enableUnconfirmedLogin' => true,
            'confirmWithin' => 21600,
            'cost' => 12,
            'as frontend' => 'dektrium\user\filters\FrontendFilter',
            'controllerMap' => [
                'recovery' => 'hass\frontend\controllers\user\RecoveryController',
                'profile' => 'hass\frontend\controllers\user\ProfileController',
                'registration' => 'hass\frontend\controllers\user\RegistrationController',
                'settings' => 'hass\frontend\controllers\user\SettingsController',
                "security" => 'hass\frontend\controllers\user\SecurityController'
            ]
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'hass\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendIdentity',
                'httpOnly' => true
            ]
        ],
        'session' => [
            'name' => 'FRONTENDSESSID'
        ],
        'authClientCollection' => [
            'class' => \yii\authclient\Collection::className(),
            'clients' => [
                'qq' => [
                    'class' => 'hass\authclient\clients\QqOAuth',
                    'clientId' => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],
                'weibo' => [
                    'class' => 'hass\authclient\clients\WeiboAuth',
                    'clientId' => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],
                'weixin' => [
                    'class' => 'hass\authclient\clients\WeixinAuth',
                    'clientId' => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],
                'renren' => [
                    'class' => 'hass\authclient\clients\RenrenAuth',
                    'clientId' => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ],
                'douban' => [
                    'class' => 'hass\authclient\clients\DoubanAuth',
                    'clientId' => 'CLIENT_ID',
                    'clientSecret' => 'CLIENT_SECRET'
                ]
            ]
        ],
        "urlManager" => [
            "class" => '\hass\base\components\UrlManager', // 主题预览中会用到
            'enablePrettyUrl' => false,
            'showScriptName' => true,
            'rules' => [
                [
                    "class" => 'hass\urlrule\components\UrlRule'
                ],
                '<controller:(post|page|cat|tag)>/<id>' => '<controller>/read',
                '<controller:(post|page|cat|tag)>s' => '<controller>/list'
            ],
            'on ' . UrlManager::EVENT_INIT_RULECACHE => function ($event) {
                if(isset(\Yii::$app->params[APP_INSTALLED_NAME]) == false)
                {
                    return;
                }
            
                $dbrule = null;
                foreach ($event->urlManager->rules as $rule) {
                    if ($rule instanceof \hass\urlrule\components\UrlRule) {
                        $dbrule = $rule;
                    }
                }
                $ruleCache = [];
                if ($dbrule) {
                    // @hass-todo 可以缓存
                    $models = \hass\urlrule\models\UrlRule::find()->all();
                    foreach ($models as $model) {
                        $params = [];
                        parse_str($model->defaults, $params);
                        $cacheKey = $model->route . '?' . implode('&', array_keys($params));
                        $ruleCache[$cacheKey][] = $dbrule;
                    }
                }
                $event->ruleCache = array_merge($ruleCache, (array) $event->ruleCache);
            }
        ],
        'view' => [
            'class' => '\hass\frontend\components\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    // set cachePath to false in order to disable template caching
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        "string" => '\yii\helpers\StringHelper',
                        "array" => "\\yii\\helpers\\ArrayHelper"
                    ],
                    'extensions' => [
                        '\hass\frontend\twig\Extension'
                    ]
                ]
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        "search" => [
            "class" => 'hass\search\components\LikeSearch'
        ]
    ],
    'params' => $params
];

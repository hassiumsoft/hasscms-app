<?php
$params = array_merge(require (__DIR__ . '/../params.php'), require (__DIR__ . '/../params-local.php'), require (__DIR__ . '/params.php'), require (__DIR__ . '/params-local.php'));

return [
    'id' => 'hassium-backend',
    'bootstrap' => [
        'install',
        'backend'
    ],
    'modules' => [
        'backend' => 'hass\backend\Module'
    ],
    'components' => [
        "urlManager" => [
            "class" => '\hass\base\components\UrlManager'
        ],
        'user' => [
            'identityClass' => 'hass\user\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_backendIdentity',
                'httpOnly' => true
            ]
        ],
        'request' => [ // 避免前台的csrf和后台的冲突
            'csrfParam' => "_backendCsrf"
        ],
        'session' => [
            'name' => 'BACKENDSESSID'
        ],
        'errorHandler' => [
            'errorAction' => 'system/default/error'
        ]
    ],
    'params' => $params
];

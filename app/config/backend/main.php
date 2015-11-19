<?php
$params = array_merge(
    require(__DIR__ . '/../params.php'),
    require(__DIR__ . '/../params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'hassium-backend',
    'bootstrap' => ['backend'],
    'modules' => [
        'backend' => 'hass\backend\Module'
    ],
    'components' => [
        "urlManager"=>[
            "class" => '\hass\backend\components\UrlManager',
        ],
        'errorHandler' => [
            'errorAction' => 'system/default/error'
        ]
    ],
    'params' => $params,
];

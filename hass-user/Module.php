<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\user;

use hass\helpers\Hook;
use yii\base\BootstrapInterface;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\user
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends \dektrium\user\Module implements BootstrapInterface
{
    public $modelMap = [
        'User' => 'hass\user\models\User'
    ];

    public $controllerMap = [
        "settings" => '\dektrium\user\controllers\SettingsController'
    ];

    public function init()
    {
        parent::init();
        \Yii::$app->getUser()->loginUrl = [
            "/user/security/login"
        ];
    }

    public function bootstrap($app)
    {
        /**
         *
         * @var $boot \dektrium\user\Bootstrap
         */
        $boot = \Yii::createObject('\dektrium\user\Bootstrap');
        $boot->bootstrap(\Yii::$app);

        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);

        Hook::on(new  \hass\user\hooks\EntityUrlPrefix());
    }
    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::PEOPLE,[[
            'label' => "用户",
            'icon' => "fa-user",
            'url' => [
                "/user/admin/index"
            ]
        ]]);
    }
}
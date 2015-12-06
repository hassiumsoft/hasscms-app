<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config;

use yii\base\BootstrapInterface;
use hass\base\classes\Hook;
use hass\base\helpers\Util;
use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends \hass\module\BaseModule implements BootstrapInterface
{
    const DEFAULT_CONFIG_TYPE = "basic";

    public function init()
    {
        parent::init();
    }

    public function bootstrap($app)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
        Hook::on(\hass\backend\Module::EVENT_ADMIN_THEME, function ($event) {
            $event->parameters->set(\hass\backend\Module::EVENT_ADMIN_THEME, \Yii::$app->get('config')
                ->get("app.backendTheme"));
        });
    }

    /**
     *
     * @param \hass\base\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {

        $event->parameters->set(ModuleGroupEnmu::CONFIG, [
            [
                'url' => [
                    "/$this->id/default/basic"
                ],
                'icon' => "fa-circle-o",
                'label' => '基本配置'
            ],
            [
                'url' => [
                    "/$this->id/default/mail"
                ],
                'icon' => "fa-circle-o",
                'label' => '邮箱设置'
            ],
            [
                'url' => [
                    "/$this->id/default/database"
                ],
                'icon' => "fa-circle-o",
                'label' => '数据库配置'
            ],
            [
                'url' => [
                    "/$this->id/custom/index"
                ],
                'icon' => "fa-circle-o",
                'label' => '自定配置'
            ]
        ]);
    }

    public static function getLocalConfigPath()
    {
        return \Yii::getAlias("@app/config") . DIRECTORY_SEPARATOR . "main-local.php";
    }
}
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
use hass\helpers\Hook;
use hass\config\models\BasicConfigForm;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *
 */
class Module extends \hass\backend\BaseModule implements BootstrapInterface
{
    const DEFAULT_CONFIG_TYPE = "basic";

    public function init()
    {
        parent::init();
    }

    public function bootstrap($backend)
    {
        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);

        Util::setComponent("config", [
            'class' => '\hass\config\components\Config', // Class (Required)
            'db' => 'db', // Database Connection ID (Optional)
            'tableName' => '{{%config}}', // Table Name (Optioanl)
            'cacheId' => 'cache', // Cache Id. Defaults to NULL (Optional)
            'cacheKey' => 'hass.config', // Key identifying the cache value (Required only if cacheId is set)
            'cacheDuration' => 100
        ]);

        // 数据库里定义的.大于配置文件里定义的
        Util::setComponent("cache", [
            'class' => \Yii::$app->get("config")->get("cache.class")
        ], true);

        Hook::on(\hass\admin\Module::EVENT_ADMIN_THEME, function ($event) {
            $event->parameters->set(\hass\admin\Module::EVENT_ADMIN_THEME, \Yii::$app->get('config')
                ->get("app.backendTheme"));
        });
    }

    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $model = \Yii::$app->get("moduleManager")->getModuleModel($this->id);

        $event->parameters->set($model->group, [
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
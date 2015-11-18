<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend;

use yii\base\BootstrapInterface;
use hass\helpers\ArrayHelper;
use hass\helpers\Hook;
use hass\urlrule\components\UrlRule;
use yii\i18n\PhpMessageSource;
use hass\helpers\Util;
use hass\backend\components\UrlManager;
use yii\helpers\Html;
define('ISFRONTEND', true);

/**
 * 该模块主要为前台提供基本服务使用
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    private $_modules = [];

    public function __construct($id, $parent = null, $config = [])
    {
        $this->preInit($config);
        parent::__construct($id, $parent, $config);
    }

    public function preInit(&$config)
    {
        foreach ($this->coreComponents() as $name => $component) {
            Util::setComponent($name, $component);
        }

        // merge core modules with custom modules
        foreach ($this->coreModules() as $id => $module) {
            if (! isset($config['modules'][$id])) {
                $config['modules'][$id] = $module;
            } elseif (is_array($config['modules'][$id]) && ! isset($config['modules'][$id]['class'])) {

                $config['modules'][$id]['class'] = $module['class'];

                if (isset($config['modules'][$id]['settings'])) {
                    $config['modules'][$id]['settings'] = array_merge($module['settings'], $config['modules'][$id]['settings']);
                } else {
                    $config['modules'][$id]['settings'] = $module['settings'];
                }
            }
        }
    }

    public function setModules($modules)
    {
        \Yii::$app->setModules($modules);
        foreach ($modules as $id => $module) {
            $this->_modules[$id] = $module;
        }
    }

    /**
     * 1.在这里加载配置等..通过配置对应用做一些修改
     * 2.在这里注册常用的组件
     *
     * @param \yii\web\Application $app
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        $app->setTimeZone(Util::getConfig()->get("app.timezone"));
        $app->language = Util::getConfig()->get("app.language");
        $app->name = Util::getConfig()->get("app.name");

        $this->initCoreHooks();
        $this->initControllerMap($app);
        $this->initTheme($app);
        $this->initPlugin($app);


        $this->initUserModule($app);
    }

    /**
     *
     * @param \yii\web\Application $app
     */
    public function initControllerMap($app)
    {
        $app->controllerMap = ArrayHelper::merge([
            "attachment" => 'hass\frontend\controllers\AttachmentController',
            "comment" => 'hass\frontend\controllers\CommentController',
            "offline" => 'hass\frontend\controllers\OfflineController',
            "page" => 'hass\frontend\controllers\PageController',
            "post" => 'hass\frontend\controllers\PostController',
            "search" => 'hass\frontend\controllers\SearchController',
            "tag" => 'hass\frontend\controllers\TagController',
            "cat" => 'hass\frontend\controllers\TaxonomyController'
        ], $app->controllerMap);
    }

    public function initUserModule($app)
    {
        $boot = \Yii::createObject('\dektrium\user\Bootstrap');
        $boot->bootstrap(\Yii::$app);

        $definitions = $app->getComponents();
        $themePath = $definitions["view"]["theme"]["pathMap"][\Yii::$app->getViewPath()][0];
        Util::setComponent("view", [
            'theme' => [
                'pathMap' => [
                    "@dektrium/user/views" => [
                        $themePath . "/user",
                        "@app/views/user",
                        "@dektrium/user/views"
                    ]
                ]
            ]
        ], true);
    }

    public function initCoreHooks()
    {
        Hook::on(new \hass\menu\hooks\MenuCreateHook());
        Hook::on(new \hass\page\hooks\MenuCreateHook());
        Hook::on(new \hass\taxonomy\hooks\MenuCreateHook());

        Hook::on(new  \hass\taxonomy\hooks\EntityUrlPrefix());
        Hook::on(new  \hass\user\hooks\EntityUrlPrefix());
    }

    /**
     *
     * @param \yii\web\Application $app
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function initTheme($app)
    {
        /**
         *
         * @var $theme \hass\theme\helpers\Theme
         */
        if (($param = $app->getRequest()->get("theme", null)) != null) {
            $theme = Util::getThemeLoader()->findOne($param);

            \Yii::$app->getUrlManager()->on(UrlManager::EVENT_CREATE_PARAMS, function ($event) use($param) {
                $event->urlParams = array_merge([
                    "theme" => $param
                ], (array) $event->urlParams);
            });
        } else {
            $theme = Util::getThemeLoader()->getDefaultTheme();
        }

        $package = $theme->getPackage();

        $config = [];
        if (! empty($css = Util::getThemeLoader()->getCustomCss($package))) {
            $config["css"] = [
                md5($css) => Html::style($css)
            ];
        }
        $config["theme"] = [
            'package' => $package,
            'class' => '\hass\frontend\components\Theme',
            'assetClass' => $theme->getAssetClass(),
            'pathMap' => $theme->getPathMap()
        ];
        Util::setComponent("view", $config, true);

        if ($theme instanceof BootstrapInterface) {
            $theme->bootstrap($app);
        }
    }

    public function initPlugin($app)
    {
        $plugins = Util::getPluginLoader()->findEnabledPlugins();
        foreach ($plugins as $plugin) {
            if ($plugin instanceof BootstrapInterface) {
                $plugin->bootstrap($app);
            }
        }
    }



    public function coreModules()
    {
        return [
            "user" => [
                'class' => 'dektrium\user\Module',
                'enableUnconfirmedLogin' => true,
                'confirmWithin' => 21600,
                'cost' => 12,
                'as frontend' => 'dektrium\user\filters\FrontendFilter',
                'modelMap' => [
                    'User' => 'hass\user\models\User'
                ],
                'controllerMap' => [
                    'recovery' => 'hass\frontend\controllers\user\RecoveryController',
                    'profile' => 'hass\frontend\controllers\user\ProfileController',
                    'registration' => 'hass\frontend\controllers\user\RegistrationController',
                    'settings' => 'hass\frontend\controllers\user\SettingsController',
                    "security" => 'hass\frontend\controllers\user\SecurityController'
                ]
            ]
        ];
    }

    public function coreComponents()
    {
        return [
            'config' => [
                'class' => '\hass\config\components\Config', // Class (Required)
                'db' => 'db', // Database Connection ID (Optional)
                'tableName' => '{{%config}}', // Table Name (Optioanl)
                'cacheId' => 'cache', // Cache Id. Defaults to NULL (Optional)
                'cacheKey' => 'hass.config', // Key identifying the cache value (Required only if cacheId is set)
                'cacheDuration' => 100
            ],
            'i18n' => [
                'translations' => [
                    'hass*' => [
                        'class' => PhpMessageSource::className(),
                        'basePath' => '@hass/backend/messages'
                    ]
                ]
            ],
            'user' => [
                'identityClass' => 'hass\user\models\User',
                'enableAutoLogin' => true,
                'identityCookie' => [
                    'name' => '_frontendIdentity',
                    'httpOnly' => true
                ]
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
            'session' => [
                'name' => 'FRONTENDSESSID'
            ],
            'moduleManager' => [
                "class" => 'hass\backend\components\ModuleManager'
            ],
            'urlManager' => [
                'enablePrettyUrl' => true,
                'showScriptName' => true,
                'rules' => [
                    '<controller:(post|page|cat|tag)>/<id>' => '<controller>/read',
                    '<controller:(post|page|cat|tag)>s' => '<controller>/list',
                    [
                        "class" => UrlRule::className()
                    ]
                ]
            ],
            "fileStorage" => [
                'class' => '\hass\attachment\components\FileStorage',
                'filesystem' => [
                    'class' => 'creocoder\flysystem\LocalFilesystem',
                    'path' => '@webroot/uploads'
                ],
                'baseUrl' => '@web/uploads'
            ],
            "composerConfigurationReader" => [
                'class' => 'hass\helpers\ComposerConfigurationReader'
            ],
            "pluginLoader" => [
                "class" => 'hass\plugin\components\PluginLoader'
            ],
            "themeLoader" => [
                "class" => 'hass\theme\components\ThemeLoader'
            ]
        ];
    }
}
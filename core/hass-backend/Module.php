<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\backend;

use yii\base\BootstrapInterface;
use yii\i18n\PhpMessageSource;
use hass\helpers\Util;

/**
 *
 * @package hass\backend
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends \yii\base\Module implements BootstrapInterface
{

    const HASS_CMS_NAME = "HASSIUM";

    const HASS_CMS_VERSION = "0.1.0";

    public $state;

    const STATE_BEGIN = 0;

    const STATE_INIT = 1;

    const STATE_BEFORE_BOOTSTRAP = 2;

    const STATE_AFTER_BOOTSTRAP = 3;

    const STATE_END = 4;

    private $_modules = [];

    public $layout = "@hass/backend/views/layouts/main";

    public $adminDefaultRoute = "/system/default/index";

    public function __construct($id, $parent = null, $config = [])
    {
        $this->state = self::STATE_BEGIN;
        $this->preInit($config);
        parent::__construct($id, $parent, $config);
    }

    public function preInit(&$config)
    {
        \Yii::$app->layout = $this->layout;
        \Yii::$app->defaultRoute = $this->adminDefaultRoute;

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

    public function init()
    {
        parent::init();
        $this->state = self::STATE_INIT;
    }

    /**
     * !CodeTemplates.overridecomment.nonjd!
     *
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        $this->state = self::STATE_BEFORE_BOOTSTRAP;

        /**
         * 后台实例化所有开启的模块,并进行引导
         */
        foreach ($this->_modules as $id => $config) {
            /**
             *
             * @var $module \hass\backend\BaseModule
             */
            $module = null;
            if ($app->hasModule($id)) {
                $module = $app->getModule($id);
            } elseif (strpos($id, '\\') === false) {
                throw new \InvalidArgumentException("Unknown bootstrapping component ID: $id");
            }

            // 为所有模块附加行为--添加钩子
            $module->ensureBehaviors();

            if ($module instanceof BootstrapInterface) {
                \Yii::trace("Bootstrap with " . get_class($module) . '::bootstrap()', __METHOD__);
                $module->bootstrap($this);
            } else {
                \Yii::trace("Bootstrap with " . get_class($module), __METHOD__);
            }
        }
        $this->state = self::STATE_AFTER_BOOTSTRAP;
    }

    public function coreModules()
    {
        $modules = [];

        foreach (\Yii::$app->get("moduleManager")->getActiveModules() as $name => $module) {
            $modules[$name]['class'] = $module->class;
        }

        $modules = array_merge([
            "admin" => [
                'class' => '\hass\admin\Module'
            ],
            "system" => [
                'class' => '\hass\system\Module'
            ],
            "user" => [
                'class' => '\hass\user\Module',
                'as backend' => 'dektrium\user\filters\BackendFilter'
            ],
            "rbac" => [
                'class' => '\hass\rbac\Module'
            ],
            "install"=>[
                "class"=>'hass\install\Module'
            ]
        ], $modules);

        return $modules;
    }

    public function coreComponents()
    {
        return [
            'moduleManager' => [
                "class" => 'hass\backend\components\ModuleManager'
            ],
            'i18n' => [
                'translations' => [
                    'hass*' => [
                        'class' => PhpMessageSource::className(),
                        'basePath' => '@hass/backend/messages'
                    ]
                ]
            ],
            'appUrlManager' => [
                "class" => '\yii\web\UrlManager',
                "scriptUrl" => \Yii::$app->getRequest()->getBaseUrl() . '/index.php'
            ],
            'user' => [
                'identityClass' => 'hass\user\models\User',
                'enableAutoLogin' => true,
                'identityCookie' => [
                    'name' => '_backendIdentity',
                    'httpOnly' => true
                ]
            ],
            'request' => [
                'csrfParam' => "_backendCsrf"
            ] // 避免前台的csrf和后台的冲突
,
            'session' => [
                'class' => 'yii\web\DbSession',
                'name' => 'BACKENDSESSID'
            ],
            "composerConfigurationReader" => [
                'class' => 'hass\helpers\ComposerConfigurationReader'
            ]
        ];
    }
}
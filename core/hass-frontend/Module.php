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
use hass\base\helpers\ArrayHelper;
use hass\base\classes\Hook;
use hass\base\helpers\Util;
use hass\base\components\UrlManager;
use yii\helpers\Html;
use hass\base\ApplicationModule;
use hass\module\components\ModuleManager;

/**
 * 该模块主要为前台提供基本服务使用
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Module extends ApplicationModule
{

    public function loadModules()
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $moduleManager->loadBootstrapModules(ModuleManager::BOOTSTRAP_FRONTEND);
    }

    public function afterBootstrap()
    {
        parent::beforeBootstrap();
        \Yii::$app->setTimeZone(\Yii::$app->get("config")
            ->get("app.timezone",\Yii::$app->getTimeZone()));
        \Yii::$app->language = \Yii::$app->get("config")->get("app.language")?:\Yii::$app->language;
        \Yii::$app->name = \Yii::$app->get("config")->get("app.name")?:\Yii::$app->name;
        
        $this->initCoreHooks();
        $this->initControllerMap();
        $this->initTheme();
        $this->initUserModule();
    }

    public function initCoreHooks()
    {
        Hook::on(new \hass\menu\hooks\MenuCreateHook());
        Hook::on(new \hass\page\hooks\MenuCreateHook());
        Hook::on(new \hass\taxonomy\hooks\MenuCreateHook());
        
        Hook::on(new \hass\taxonomy\hooks\EntityUrlPrefix());
        Hook::on(new \hass\user\hooks\EntityUrlPrefix());
        
        Hook::on(new \hass\post\hooks\SearchModel());
        Hook::on(new \hass\page\hooks\SearchModel());
    }

    /**
     *
     * @param \yii\web\Application $app            
     */
    public function initControllerMap()
    {
        \Yii::$app->controllerMap = ArrayHelper::merge([
            "site" => 'hass\frontend\controllers\SiteController',
            "attachment" => 'hass\frontend\controllers\AttachmentController',
            "comment" => 'hass\frontend\controllers\CommentController',
            "offline" => 'hass\frontend\controllers\OfflineController',
            "page" => 'hass\frontend\controllers\PageController',
            "post" => 'hass\frontend\controllers\PostController',
            "search" => 'hass\frontend\controllers\SearchController',
            "tag" => 'hass\frontend\controllers\TagController',
            "cat" => 'hass\frontend\controllers\TaxonomyController'
        ], \Yii::$app->controllerMap);
    }

    /**
     *
     * @param \yii\web\Application $app            
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function initTheme()
    {
        if (($themeId = \Yii::$app->getRequest()->get("theme", null)) != null) {
            \Yii::$app->getUrlManager()->on(UrlManager::EVENT_CREATE_PARAMS, function ($event) use($themeId) {
                $event->urlParams = array_merge([
                    "theme" => $themeId
                ], (array) $event->urlParams);
            });
        } else {
            $themeId = \Yii::$app->get("themeManager")->getDefaultThemeId();
        }
        
        /** @var \hass\theme\classes\ThemeInfo $themeInfo */
        $themeInfo = \Yii::$app->get("themeManager")->findOne($themeId);
        $package = $themeInfo->getPackage();
        
        $config = [];
        if (! empty($css = \Yii::$app->get("themeManager")->getCustomCss($package))) {
            $config["css"] = [
                md5($css) => Html::style($css)
            ];
        }
        $config["theme"] = [
            'package' => $package,
            'class' => '\hass\frontend\components\Theme',
            'assetClass' => $themeInfo->getAssetClass(),
            'pathMap' => $themeInfo->getPathMap()
        ];
        Util::setComponent("view", $config, true);
        
        $theme = $themeInfo->createEntity();
        
        if ($theme instanceof BootstrapInterface) {
            $theme->bootstrap(\Yii::$app);
        }
    }

    public function initUserModule()
    {
        $boot = \Yii::createObject('\dektrium\user\Bootstrap');
        $boot->bootstrap(\Yii::$app);
        
        $definitions = \Yii::$app->getComponents();
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
}

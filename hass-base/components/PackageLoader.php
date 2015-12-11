<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\components;

use yii\base\Component;
use yii\base\BootstrapInterface;
use yii\web\Application;
use creocoder\flysystem\LocalFilesystem;
use hass\module\components\ModuleManager;
use hass\theme\components\ThemeManager;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class PackageLoader extends Component implements BootstrapInterface
{

    public function init()
    {
        parent::init();
    }

    /**
     *
     * {@inheritDoc}
     *
     * @param Application $app
     * @see \yii\base\BootstrapInterface::bootstrap()
     */
    public function bootstrap($app)
    {
        $moduleFilemtime = \Yii::$app->getCache()->get(ModuleManager::HASS_PACKAGE_MODULE . "-filemtime");
        $themeFilemtime = \Yii::$app->getCache()->get(ThemeManager::HASS_PACKAGE_THEME . "-filemtime");

        $modulePath =\Yii::getAlias(\Yii::$app->get("moduleManager")->getModulePath());
        $themePath =\Yii::getAlias(\Yii::$app->get("themeManager")->getThemePath());

        if (LOAD_PACKAGE == true && $moduleFilemtime == filemtime($modulePath) && $themeFilemtime == filemtime($themePath)) {
            return;
        }

        $this->generatePackageClassmaps();

        \Yii::$app->getCache()->set(ModuleManager::HASS_PACKAGE_MODULE . "-filemtime", filemtime($modulePath));
        \Yii::$app->getCache()->set(ThemeManager::HASS_PACKAGE_THEME . "-filemtime", filemtime($themePath));

        \Yii::$app->getResponse()->refresh();
        \Yii::$app->end();
    }

    public function generatePackageClassmaps()
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");

        /** @var \hass\theme\components\ThemeManager $themeManager */
        $themeManager = \Yii::$app->get("themeManager");

        $corePath = $moduleManager->getCorePath();
        $modulePath = $moduleManager->getModulePath();
        $themePath = $themeManager->getThemePath();

        $packages = $moduleManager->findAll();
        $packages = array_merge($packages, $themeManager->findAll());
        $classMaps = [];


        /** @var \hass\module\classes\ModuleInfo $package */
        foreach ($packages as $package) {
            $classMap = $package->configuration->autoloadPsr4();
            foreach ($classMap as $namespace => $paths) {
                foreach ($paths as $path) {
                    $path = str_replace("\\", "/", rtrim($package->getPath() . DIRECTORY_SEPARATOR . $path, "/\\"));

                    switch ($package->configuration->type()) {
                        case ModuleManager::HASS_PACKAGE_CORE:
                            $path = $corePath . str_replace(str_replace("\\", "/", \Yii::getAlias($corePath)), "", $path);
                            break;
                        case ModuleManager::HASS_PACKAGE_MODULE:
                            $path = $modulePath . str_replace(str_replace("\\", "/", \Yii::getAlias($modulePath)), "", $path);
                            break;
                        case ThemeManager::HASS_PACKAGE_THEME:
                            $path = $themePath . str_replace(str_replace("\\", "/", \Yii::getAlias($themePath)), "", $path);
                            break;
                    }

                    $classMaps[$namespace][] = $path;
                }
            }
        }

        $this->writeFile($classMaps);
    }

    public function writeFile($classMaps)
    {
        /** @var LocalFilesystem $filesystem **/
        $filesystem = \Yii::createObject([
            "class" => LocalFilesystem::className(),
            "path" => "@core"
        ]);

        if($filesystem->has("autoload_psr4.php"))
        {
            $filesystem->delete("autoload_psr4.php");
        }

        $classMapsString = "<?php\n\n return " . var_export($classMaps, true) . ";";
        $filesystem->write("autoload_psr4.php", $classMapsString);
    }
}
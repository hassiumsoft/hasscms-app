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

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class PackageAlias extends Component implements BootstrapInterface
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
        if (LOAD_PACKAGE == true) {
            return;
        }
        
        $this->generatePackageClassmaps();
        
        \Yii::$app->getResponse()->refresh();
        \Yii::$app->end();
    }

    public function generatePackageClassmaps()
    {
        $moduleManager = \Yii::$app->get("moduleManager");
        
        $packages = $moduleManager->findAll();
        
        $classMaps = [];
        
        /** @var \hass\module\classes\ModuleInfo $package */
        foreach ($packages as $package) {
            $classMap = $package->configuration->autoloadPsr4();            
            foreach ($classMap as $namespace => $paths) {
                foreach ($paths as $path) {
                    $path = str_replace("\\", "/", rtrim($package->getPath() . DIRECTORY_SEPARATOR . $path, "/\\"));
                    if($package->isCoreModule())
                    {
                        $path = "@core".str_replace( str_replace("\\", "/",\Yii::getAlias("@core")), "", $path);
                    }
                    else 
                    {
                        $path = "@root/modules".str_replace( str_replace("\\", "/",\Yii::getAlias("@root/modules")), "", $path);
                    }
                    
                    $classMaps[$namespace][] = $path;
                }
            }
        }
        
        $this->writeFile($classMaps);
    }

    public function writeFile($classMaps)
    {
        $filesystem = \Yii::createObject([
            "class" => LocalFilesystem::className(),
            "path" => "@core"
        ]);
        
        $classMapsString = "<?php\n\n return " . var_export($classMaps, true) . ";";
        $filesystem->write("autoload_psr4.php", $classMapsString);
    }
}
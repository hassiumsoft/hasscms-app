<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use creocoder\flysystem\LocalFilesystem;
use Eloquent\Composer\Configuration\ConfigurationReader;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class HassClassLoader
{
    public static function registerAlias()
    {
        $root = dirname(__DIR__);
        Yii::setAlias("@root", $root);
        Yii::setAlias("@core", '@root/core');
        Yii::setAlias("@storage", '@root/storage');
        
        $packageClassMaps = __DIR__ . DIRECTORY_SEPARATOR . "autoload_psr4.php";
        if (file_exists($packageClassMaps) == false) {
            $coreClassmaps = static::getHassCoreFile();
            
            foreach ($coreClassmaps as $namespace => $path) {
                \Yii::setAlias(rtrim(str_replace('\\', '/', $namespace), "/"), $path);
            }
            
            define("LOAD_PACKAGE", false);            
            return;
        }
        
        $classMaps = require $packageClassMaps;
        
        foreach ($classMaps as $namespace => $paths) {
            foreach ($paths as $path) {
                \Yii::setAlias(rtrim(str_replace('\\', '/', $namespace), "/"), $path);
            }
        }
        
        define("LOAD_PACKAGE", true);
    }

    /**
     * 1.启用的模块
     * 2.当前的前台主题
     */
    public static function getHassCoreFile()
    {
        $filesystem = \Yii::createObject([
            "class" => LocalFilesystem::className(),
            "path" => __DIR__
        ]);
        $classMaps = [];
        foreach ($filesystem->listContents() as $item) {
            if ($item["type"] == "dir") {
                $path = $filesystem->getAdapter()->applyPathPrefix($item["path"]);
                
                if (! file_exists($path . DIRECTORY_SEPARATOR . 'composer.json')) {
                    continue;
                }
                
                $reader = new ConfigurationReader();
                
                $configuration = $reader->read($path . DIRECTORY_SEPARATOR . 'composer.json');
                
                foreach (array_keys($configuration->autoloadPsr4()) as $namespace) {
                    
                    $classMaps[$namespace] = $path;
                }
            }
        }
        
        return $classMaps;
    }
}
HassClassLoader::registerAlias();
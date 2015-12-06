<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\classes;

use yii\base\Component;
use yii\base\InvalidConfigException;
use creocoder\flysystem\LocalFilesystem;
use yii\helpers\FileHelper;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class PackageManager extends Component
{

    public $paths;

    public $type;

    public $infoClass;

    public $packages;
    
    public $packgeConfigName = "hass-package-config";
    
    /**
     * Looks for packages in the specified directories and creates the objects
     */
    public function findAll()
    {
        if(!empty($this->packages))
        {
            return $this->packages;
        }
        
        $this->packages = [];
        foreach ($this->paths as $path) {
            /** @var \creocoder\flysystem\LocalFilesystem $fileSystem */
            $fileSystem = new LocalFilesystem([
                "path" => $path
            ]);
            
            foreach ($fileSystem->listContents() as $item) {
                if ($item["type"] == "dir") {
                    $path = $fileSystem->getAdapter()->applyPathPrefix($item["path"]);
                    if (! file_exists($path . DIRECTORY_SEPARATOR . 'composer.json') || ($package = $this->findByPath($path)) == null) {
                        continue;
                    }
                    
                    if ($package instanceof PackageInfo) {
                        $this->packages[$package->getPackage()] = $package;
                    } else {
                  
                        $this->packages[$package['configuration']->name()] = $package;
                    }
                }
            }
        }
        return $this->packages;
    }

    /**
     *
     * @param unknown $path            
     * @return Package
     */
    public function findByPath($path)
    {
        /** @var \hass\base\helpers\ComposerConfigurationReader $reader */
        $reader = \Yii::$app->get("composerConfigurationReader");
        
        if (! file_exists($path . DIRECTORY_SEPARATOR . 'composer.json')) {
            throw new InvalidConfigException("composer.json no exist");
        }
        /**
         *
         * @var $configuration \Eloquent\Composer\Configuration\Element\Configuration
         */
        $configuration = $reader->read($path . DIRECTORY_SEPARATOR . 'composer.json');
        
        if (! empty($this->type) && $this->type != $configuration->type()) {
            return null;
        }
        // 从扩展中获得包的文件名...
        $extra = $configuration->extra();
        
        if (! $extra || ! property_exists($extra, $this->packgeConfigName)) {
            return null;
        }
        
        $config = (array) $extra->{$this->packgeConfigName};
        $config["path"] = $path;
        $config['configuration'] = $configuration;
        
        if ($this->infoClass != null) {
            $config["class"] = $this->infoClass;
            $package = \Yii::createObject($config);
        } else {
            $package = $config;
        }
        
        return $package;
    }

    /**
     *
     * @param \hass\base\classes\Package $package            
     */
    public function deletePackage($package)
    {
        FileHelper::removeDirectory($package->getPath());
        /**
         *
         * @hass-todo 从composer 中卸载 ..速度太慢需要更改方式
         */
        $name = $package->getPackage();
        $rootDir = \Yii::getAlias("@root");
        $reader = \Yii::$app->get("composerConfigurationReader");
        /**
         *
         * @var $configuration \Eloquent\Composer\Configuration\Element\Configuration
         */
        $configuration = $reader->read($rootDir . DIRECTORY_SEPARATOR . 'composer.json');
        if (array_key_exists($name, $configuration->dependencies())) {
            chdir($rootDir);
            exec("composer remove $name");
        }
    }

    /**
     *
     * @param unknown $id            
     * @return Package
     */
    public function findOne($id)
    {
        $packages = $this->findAll();
        if (isset($packages[$id])) {
            return $packages[$id];
        }
        return null;
    }
}
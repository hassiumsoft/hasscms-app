<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\helpers;

use creocoder\flysystem\LocalFilesystem;
use yii\base\Component;
use yii\base\InvalidConfigException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class PackageLoader extends Component
{

    /**
     * The packages found
     *
     * @var null|array as first key the dir name, as second key the slug
     */
    public $packages = null;

    /**
     *
     * @var creocoder\flysystem\LocalFilesystem
     */
    public $fileSystem;

    public $path;

    public $type;

    public function init()
    {
        $this->fileSystem = new LocalFilesystem([
            "path" => $this->path
        ]);
    }

    /**
     * Looks for packages in the specified directories and creates the objects
     */
    public function findAll()
    {
        if ($this->packages != null) {
            return $this->packages;
        }
        $this->packages = [];
        foreach ($this->fileSystem->listContents() as $item) {
            if ($item["type"] == "dir") {
                $path = $this->fileSystem->getAdapter()->applyPathPrefix($item["path"]);

                if(!file_exists($path . DIRECTORY_SEPARATOR . 'composer.json'))
                {
                    continue;
                }

                if (! isset($this->packages[$path])) {
                   $package = $this->findByPath($path);
                    if($package)
                    {
                        $this->packages[$path] = $package;
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
       $reader = \Yii::$app->get("composerConfigurationReader");

        if(!file_exists($path . DIRECTORY_SEPARATOR . 'composer.json'))
        {
            throw new InvalidConfigException("composer.json不存在");
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


        if ($extra&&property_exists($extra, "packageClass")) {
            $class = $extra->packageClass;
        }
        else{
            throw new InvalidConfigException("包的类未配置");
        }

        $classMap = $configuration->autoloadPsr4();
        foreach($classMap as $namespace =>$paths)
        {
            \Yii::setAlias(rtrim(str_replace("\\", "/", $namespace),"/"), $path);
        }


        $package = \Yii::createObject([
            "class" => $class,
            "path" => $path,
            "configuration" => $configuration
        ]);

        return $package;
    }

    /**
     *
     * @param unknown $id
     * @return Package
     */
    public function findOne($id)
    {
        $packages = $this->findAll();
        foreach ($packages as $package) {
            if ($package->getPackage() == $id) {
                return $package;
            }
        }
        return null;
    }
}
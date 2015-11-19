<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\helpers;
use yii\base\Object;
use Distill\Exception\InvalidArgumentException;
use yii\helpers\FileHelper;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class Package extends Object
{
    /**
     * The path to this package
     *
     * @var string
     */
    protected  $path;

    /**
     *
     * @var  \Eloquent\Composer\Configuration\Element\Configuration
     */
    protected $configuration;


    public function getNamespace()
    {
        $class = get_class($this);
        if (($pos = strrpos($class, '\\')) !== false) {
            return substr($class, 0, $pos) ;
        }
    }

    public function init()
    {

    }


    public function deletePackage()
    {
        FileHelper::removeDirectory($this->getPath());
        /**
         * @todo-hass 从composer 中卸载  ..速度太慢需要更改方式
         */
        $package = $this->getPackage();
        $appDir = \Yii::getAlias("@app");
        $reader = \Yii::$app->get("composerConfigurationReader");
        /**
         *
         * @var $configuration  \Eloquent\Composer\Configuration\Element\Configuration
         */
        $configuration = $reader->read($appDir.DIRECTORY_SEPARATOR.'composer.json');
        if(array_key_exists($package, $configuration->dependencies()))
        {
            chdir($appDir);
            exec("composer remove $package");
        }
    }

    public function getConfiguration()
    {
        if($this->configuration == null)
        {
            $reader = \Yii::$app->get("composerConfigurationReader");
            $this->configuration = $reader->read($this->getPath().DIRECTORY_SEPARATOR.'composer.json');
        }
        return $this->configuration;
    }

    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
    }


    public function setPath($path)
    {
        $path = rtrim($path, '/');
        if (!file_exists($path.DIRECTORY_SEPARATOR.'composer.json')) {
            throw new \DomainException('Directory not found.');
        }
        $this->path = $path;
    }


    /**
     * Gets the path to the package
     *
     * @return  string
     */
    public function getPath()
    {
        if($this->path == null)
        {
            throw new InvalidArgumentException('path is null.');
        }
        return $this->path;
    }


    public function getPackage()
    {
        return $this->configuration->name();
    }

    public function getHomepage()
    {

        return  $this->configuration->homepage();
    }

    public function getAuthors()
    {

        return $this->configuration->authors();
    }

    /**
     *
     * @return \Eloquent\Composer\Configuration\Element\SupportInformation
     */
    public function getSupport()
    {
        return $this->configuration->support();
    }

    public function getKeyWords()
    {
        return $this->configuration->keywords();
    }

    public function getFormatAuthors()
    {
        $authors = $this->getAuthors();
        $result = "";

        foreach ($authors as $author) {
            /**
             *
             * @var $author \Eloquent\Composer\Configuration\Element\Author
             */
            if ($author->homepage() != null) {
                $result .= Html::a($author->name(), $author->homepage());
            } else {
                $result .= $author->name();
            }
            $result .= "&nbsp;&nbsp;";
        }

        return $result;
    }

    public function getDescription()
    {
        return $this->configuration->description();
    }


}
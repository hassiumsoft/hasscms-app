<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\classes;

use yii\base\Object;

use yii\helpers\Html;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class PackageInfo extends Object
{
    public $name;
    public $version;

    protected $path;

    protected $configuration;

    protected  $entityClass;

    
    public function createEntity()
    {
        $class = $this->getEntityClass();
        $entity = \Yii::createObject([
            "class" => $class,
            "packageInfo" => $this
        ]);
        return $entity;
    }
    
    public function getEntityClass()
    {
        return $this->entityClass;
    }
    
    public function setEntityClass($class)
    {
        $this->entityClass = $class;
    }
    
    public function getNamespace()
    {
       $prs4 = $this->configuration->autoloadPsr4();
       $result = "";
       foreach ($prs4 as $namespce =>$paths)
       {
           foreach ($paths as $path)
           {
               if(empty($path))
               {
                   $result = $namespce;
                   break;
               }
           }
           
           if(!empty($result))
           {
               break;
           }
       }
       return $result;
    }
    
    public function getName()
    {
        if ($this->name !== null) {
            return $this->name;
        }
        return $this->configuration->name();
    }

    /**
     *
     * @return string
     */
    public function getVersion()
    {
        if ($this->version !== null) {
            return $this->version;
        }
        return $this->configuration->version();
    }

    public function getConfiguration()
    {
        if ($this->configuration == null) {
            $reader = \Yii::$app->get("composerConfigurationReader");
            $this->configuration = $reader->read($this->getPath() . DIRECTORY_SEPARATOR . 'composer.json');
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
        if (! file_exists($path . DIRECTORY_SEPARATOR . 'composer.json')) {
            throw new \DomainException('Directory not found.');
        }
        $this->path = $path;
    }

    /**
     * Gets the path to the package
     *
     * @return string
     */
    public function getPath()
    {
        if ($this->path == null) {
            throw new \InvalidArgumentException('path is null.');
        }
        return $this->path;
    }

    public function getPackage()
    {
        return $this->configuration->name();
    }

    public function getHomepage()
    {
        return $this->configuration->homepage();
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
<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\module\classes;
use hass\helpers\Package;
use hass\module\models\Module as Model;
use hass\base\enums\BooleanEnum;
use hass\base\enums\StatusEnum;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class ModuleInfo extends Package
{
    
    const MODULE_TYPE_CORE="hass-core";
    
    public $id;
    public $moduleClass;
    public $bootstrap;
    
    /**
     *
     * @var \hass\module\models\Module
     */
    private $_model = null;

    /**
     * @return \hass\module\models\Module
     */
    public function getModel()
    {
        if($this->_model==null)
        {
            $model =  Model::findOne($this->getPackage());
            if($model == null)
            {
                $model = new Model();
                $model->loadDefaultValues();
                $model->package = $this->getPackage();
                $model->id= $this->id;
                $model->class=$this->moduleClass;
            }
            $this->_model = $model;
        }
        return  $this->_model;
    }
    
    /**
     * 
     * @param \hass\module\models\Module $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }
    
    public function enabled()
    {
        return $this->getModel()->status;
    }
    
    public function installed()
    {
        return $this->getModel()->installed;
    }
    
    
    public function canUninstall()
    {
        return $this->getModel()->installed == BooleanEnum::TRUE &&
        $this->getModel()->status == StatusEnum::STATUS_OFF &&
        $this->configuration->type()!=static::MODULE_TYPE_CORE;
    }
    
    public function canInstall()
    {
        return $this->getModel()->installed == BooleanEnum::FLASE;
    }
    
    public function canDelete()
    {
        return $this->getModel()->installed == BooleanEnum::FLASE &&  $this->configuration->type()!=static::MODULE_TYPE_CORE;
    }
}
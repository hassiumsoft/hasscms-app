<?php

/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\module\components;

use yii\base\BootstrapInterface;
use hass\module\BaseModule;
use hass\base\helpers\Util;
use hass\base\enums\BooleanEnum;
use Distill\Exception\Method\Exception;
use hass\base\classes\PackageManager;

/**
 *
 * @author zhepama <zhepama@gmail.com>
 *        
 * @since 0.1.0
 */
class ModuleManager extends PackageManager
{
    const HASS_PACKAGE_CORE = "hass-core";
    
    const HASS_PACKAGE_MODULE = "hass-module";
    
    const BOOTSTRAP_FRONTEND = 1;

    const BOOTSTRAP_BACKEND = 2;

    public $paths = [
        "@root/modules",
        "@core"
    ];

    public $infoClass = "\\hass\\module\\classes\\ModuleInfo";

    public function init()
    {
        parent::init();
    }
    
    public function getModulePath()
    {
        return $this->paths[0];
    }
    
    public function getCorePath()
    {
        return $this->paths[1];
    }
    
    public function findNoCoreModules()
    {
        return parent::findAll([$this->getModulePath()]);
    }
    
    public function findCoreModules()
    {
        return parent::findAll([$this->getCorePath()]);
    }

    public function loadBootstrapModules($bootstrapType)
    {
        $modules = \hass\module\models\Module::findEnabledModules();
        $regModules = \Yii::$app->getModules();
        
        /** @var \hass\module\models\Module $model */
        foreach ($modules as $model) {
            $model = (object)$model;
            
            $class = null;
            if (isset($regModules[$model->id])) {
                //是对象的话，说明绝对引导过了,配置高于程序中定义的
                if(is_object($regModules[$model->id]))
                {
                    continue;
                }
                // 如果有模块,而且模块的类存在,配置文件优先
                if(isset($regModules[$model->id]['class']))
                {
                    $class = $regModules[$model->id]['class'];
                }
            }
            //模块类未设置的话
            if($class == null)
            {
                if (empty($model->class)) {
                    continue;
                }
                
                Util::setModule($model->id, [
                    'class' => $model->class
                ]);
            }
            
            $bootstraps = explode("|", $model->bootstrap);
            if (in_array($bootstrapType, $bootstraps)) {
                /** @var \hass\module\BaseModule $module */
                $module = \Yii::$app->getModule($model->id);
                
                if ($module instanceof BootstrapInterface) {
                    $module->bootstrap(\Yii::$app);
                }
            }
        }
    }
    

    public function enabled($module, $value)
    {
        try {
            $model = $module->getPackageInfo()->getModel();
            $model->setAttribute("status", $value);
            $model->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param \hass\module\BaseModule $module            
     */
    public function delete($module)
    {
        try {
            $model = $module->getPackageInfo()->getModel();
            $model->delete();
            $this->deletePackage($module->getPackageInfo());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param \hass\module\BaseModule $module            
     */
    public function install($module)
    {
        try {
            $module->install();
            $model = $module->getPackageInfo()->getModel();
            $model->setAttribute("installed", BooleanEnum::TRUE);
            $model->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param \hass\module\BaseModule $module            
     */
    public function uninstall($module)
    {
        try {
            $module->uninstall();
            $model = $module->getPackageInfo()->getModel();
            $model->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function findModule($id)
    {
        /** @var \hass\module\classes\ModuleInfo $moduleInfo */
        $moduleInfo = $this->findOne($id);
        return $moduleInfo->createEntity();
    }
}

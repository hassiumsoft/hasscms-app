<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\module\traits;
use hass\module\classes\ModuleInfo;
/**
* 因为有一些模块需要继承从composer拉下来的Module
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


trait BaseModuleTrait
{
    /** @var \hass\module\classes\ModuleInfo $moduleInfo */
    public $moduleInfo;
    
    /**
     *
     * @param \hass\module\models\Module $model
     */
    public function setModuleInfoModel($model) {
    
        if($this->moduleInfo == null)
        {
            $this->moduleInfo = new ModuleInfo();
        }
    
        $this->moduleInfo->setModel($model);
    }
    
    public function install()
    {
        return true;
    }
    
    public function uninstall()
    {
        return true;
    }
    
    public function upgrade()
    {
        return true;
    }
}

?>
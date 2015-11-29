<?php

/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\backend\components;

use yii\base\Component;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
class ModuleManager extends Component
{
    private $_activeModules = [];

    public function init()
    {
        parent::init();
    }

    public function getModuleModel($id)
    {
        foreach ($this->activeModules as $module) {
            if ($module->name == $id) {
                return $module;
            }
        }

        return false;
    }

    /**
     *
     * @param unknown $class
     * @return \hass\backend\models\Module
     */
    public function getModuleModelByClass($class)
    {
        foreach ($this->activeModules as $module) {
            if ($module->class == $class) {
                return $module;
            }
        }

        return false;
    }

    public function getActiveModules()
    {
        if ($this->_activeModules == null) {
            $this->_activeModules = \hass\backend\models\Module::findAllActive();
        }

        return $this->_activeModules;
    }
}

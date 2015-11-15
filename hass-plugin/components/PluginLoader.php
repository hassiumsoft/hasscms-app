<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\plugin\components;

use hass\helpers\PackageLoader;
use hass\backend\enums\StatusEnum;
use hass\backend\enums\BooleanEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *       
 */
class PluginLoader extends PackageLoader
{

    public $pluginPath = "@app/plugins";

    public function init()
    {
        $this->path = $this->getPluginPath();
        parent::init();
    }

    public function getPluginPath()
    {
        if (\Yii::$app->get("config", false) != null) {
            return \Yii::$app->get("config")->get("plugin.pluginPath", $this->pluginPath);
        }
        
        return $this->pluginPath;
    }

    /**
     *
     * @todo-hass 此处可以有缓存
     * @return NULL[]
     */
    public function findEnabledPlugins()
    {
        $result = [];
        $plugins = $this->findAll();
        foreach ($plugins as $plugin) {
            $model = $plugin->getModel();
            if ($model->status == StatusEnum::STATUS_ON && $model->installed == BooleanEnum::TRUE) {
                $result[] = $plugin;
            }
        }
        return $result;
    }
}
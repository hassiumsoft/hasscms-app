<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\plugin;

use yii\base\BootstrapInterface;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 *       
 */
class Module extends \hass\backend\BaseModule implements BootstrapInterface
{

    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        return [
            '\hass\system\behaviors\MainNavBehavior'
        ];
    }

    public function bootstrap($backend)
    {
        Util::setComponent("pluginLoader", [
            "class" => 'hass\plugin\components\PluginLoader'
        ]);
        $pluginLoader = Util::getPluginLoader();
        $plugins = $pluginLoader->findEnabledPlugins();
        foreach ($plugins as $plugin) {
            $plugin->bootstrapInBackend($backend);
        }
    }
}
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base;

use yii\base\BootstrapInterface;
defined('HASS_APP') or define('HASS_APP', 'frontend');
defined('HASS_APP_FRONTEND') or define('HASS_APP_FRONTEND', HASS_APP === 'frontend');
defined('HASS_APP_BACKEND') or define('HASS_APP_BACKEND', HASS_APP === 'backend');

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class ApplicationModule extends \yii\base\Module implements BootstrapInterface
{

    const EVENT_INIT = "EVENT_INIT";

    const EVENT_BEFORE_BOOTSTRAP = "EVENT_BEFORE_BOOTSTRAP";

    const EVENT_AFTER_BOOTSTRAP = "EVENT_AFTER_BOOTSTRAP";

    public function init()
    {
        parent::init();
        $this->trigger(static::EVENT_INIT);
    }

    public function bootstrap($app)
    {
        $this->beforeBootstrap();
        
        $this->loadModules();
        
        $this->afterBootstrap();
    }

    public function loadModules()
    {}

    public function beforeBootstrap()
    {
        $this->trigger(static::EVENT_BEFORE_BOOTSTRAP);
    }

    public function afterBootstrap()
    {
        $this->trigger(static::EVENT_AFTER_BOOTSTRAP);
    }
}
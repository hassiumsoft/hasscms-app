<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2014-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\classes;

use yii\base\Object;
use hass\base\classes\HookEvent;
use League\Event\ListenerProviderInterface;

/**
 * @package hass\base\helpers
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Hook extends Object
{
    private static $_instance;

    public static $eventList = [];

    /**
     *
     * @return \League\Event\Emitter
     */
    public static function instance()
    {
        if (static::$_instance == null) {
            static::$_instance = new \League\Event\Emitter();
        }
        return static::$_instance;
    }

    /**
     * @param unknown $event
     * @return \hass\base\classes\HookEvent
     */
    public static function trigger($event, $reload = false)
    {
        $name = is_string($event) ? $event : $event->getName();
        if (!array_key_exists($name, static::$eventList) || $reload == true) {
            if (is_string($event)) {
                $event = HookEvent::named($event);
            }
            static::$eventList[$name] = call_user_func_array([
                static::instance(),
                "emit"
            ], [
                    $event
                ] + func_get_args());
        }
        return static::$eventList[$name];
    }

    /**
     * @hass-todo hook可以监听类...触发的时候再实例化
     * @param unknown $event
     * @param unknown $listener
     * @param unknown $priority
     */
    public static function on($event, $listener = null, $priority = \League\Event\Emitter::P_NORMAL)
    {
        if ($event instanceof ListenerProviderInterface) {
            return static::instance()->useListenerProvider($event);
        }

        return static::instance()->addListener($event, $listener, $priority);
    }

    public static function off($event, $listener)
    {
        return static::instance()->removeListener($event, $listener);
    }

}

?>
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\traits;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */

trait Singleton
{
    protected static $instance;

    /**
     * Create a new instance of this singleton.
     */
    final public static function instance()
    {
        return isset(static::$instance)
            ? static::$instance
            : static::$instance = new static;
    }

    /**
     * Constructor.
     */
    final protected function __construct()
    {
        $this->init();
    }

    /**
     * Initialize the singleton free from constructor parameters.
     */
    protected function init() {}

    public function __clone()
    {
        trigger_error('Cloning '.__CLASS__.' is not allowed.', E_USER_ERROR);
    }

    public function __wakeup()
    {
        trigger_error('Unserializing '.__CLASS__.' is not allowed.', E_USER_ERROR);
    }
}
<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\classes;
use hass\base\classes\ArrayObject;
use yii\helpers\ArrayHelper;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class Parameters extends ArrayObject
{
    /**
     * Constructor
     *
     * Enforces that we have an array, and enforces parameter access to array
     * elements.
     *
     * @param  array $values
     */
    public function __construct(array $values = null)
    {
        if (null === $values) {
            $values = [];
        }
        parent::__construct($values, ArrayObject::ARRAY_AS_PROPS);
    }
    /**
     * Populate from native PHP array
     *
     * @param  array $values
     * @return void
     */
    public function fromArray(array $values)
    {
        $this->exchangeArray($values);
    }
    /**
     * Populate from query string
     *
     * @param  string $string
     * @return void
     */
    public function fromString($string)
    {
        $array = [];
        parse_str($string, $array);
        $this->fromArray($array);
    }
    /**
     * Serialize to native PHP array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getArrayCopy();
    }
    /**
     * Serialize to query string
     *
     * @return string
     */
    public function toString()
    {
        return http_build_query($this);
    }
    /**
     * Retrieve by key
     *
     * Returns null if the key does not exist.
     *
     * @param  string $name
     * @return mixed
     */
    public function offsetGet($name)
    {
        if ($this->offsetExists($name)) {
            return parent::offsetGet($name);
        }
        return;
    }
    /**
     * @param string $name
     * @param mixed $default optional default value
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if ($this->offsetExists($name)) {
            return parent::offsetGet($name);
        }
        return $default;
    }
    /**
     * @param string $name
     * @param mixed $value
     * @param bool $override
     * @return Parameters
     */
    public function set($name, $value,$override = false)
    {
        if ($this->offsetExists($name) && $override ==false) {
           $value =  ArrayHelper::merge($this->get($name), $value);
        }
        $this->offsetUnset($name);
        $this->offsetSet($name, $value);
        return $this;
    }

    public function insertAfter($name, $value, $position, $override =false)
    {
        if ($this->offsetExists($name) && $override ==false) {
            $value =  ArrayHelper::merge( $this->get($name), $value);
        }
        $this->offsetUnset($name);
        return  parent::insertAfter($name, $value, $position);
    }

    public function insertBefore($name, $value, $position, $override =false)
    {
        if ($this->offsetExists($name) && $override ==false) {
            $value =  ArrayHelper::merge( $this->get($name), $value);
        }
        unset($this[$name]);
        return parent::insertBefore($this, $position, $name, $value);;
    }
}
<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\behaviors;
use yii\base\Behavior;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class BaseAttachAttribute extends Behavior
{

    /**
     *
     * @var yii\db\ActiveRecord
     */
    public $owner;


    /**
     * 该值要和widget中的name值一致
     *
     * @var unknown
     */
    public $attribute;

    /**
     *
     * @var 特性值
     */
    protected $value;


    public function canGetProperty($name, $checkVars = true)
    {
        if ($this->attribute == $name) {
            return true;
        }
        return false;
    }

    // 根据特性返回这个值
    public function __get($name)
    {
        if ($name != $this->attribute) {
            return parent::__get($name);
        }
        if ($this->value == null) {
            $this->value = $this->getValue();
        }
        return $this->value;
    }

    protected function getValue()
    {

    }

}
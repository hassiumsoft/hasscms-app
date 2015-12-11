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
use hass\base\ActiveRecord;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class StrToTimeBehavior extends Behavior
{
    public $attribute;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
        ];
    }

    public function beforeSave()
    {
        $value = $this->owner->{$this->attribute};

        if(empty($value))
        {
            $value = "now";
        }
        $this->owner->{$this->attribute} = strtotime($value);
    }
}
<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\enums;
use hass\base\classes\Enmu;
/**
*
* @package hass\base
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class BooleanEnum extends Enmu
{
    const TRUE = 1;
    const FLASE = 0;

    public static $list = [
        self::TRUE => '是',
        self::FLASE => '否'
    ];
}
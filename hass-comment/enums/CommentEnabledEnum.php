<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\comment\enums;
use hass\base\classes\Enmu;
/**
*
* @package hass\comment
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class CommentEnabledEnum extends Enmu
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public static $list = [
            self::STATUS_ON => '开启评论',
            self::STATUS_OFF => '关闭评论'
     ];

}
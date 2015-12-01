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
 * 常量里存储的是值.
 * list里存储的是显示的label
 * 使用PostStatusEnum::listData()放在下拉菜单里
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class EntityStatusEnum extends Enmu
{
    const STATUS_PENDING = 0; //待定
    const STATUS_PUBLISHED = 1; //发布
    const STATUS_DELETED = 2; //删除


    public static $list = [
            self::STATUS_PUBLISHED => 'Published',
            self::STATUS_PENDING => 'Pending'
     ];

}
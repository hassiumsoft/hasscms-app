<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config\helpers;

use hass\base\classes\Enmu;

/**
 * 常量里存储的是值.
 * list里存储的是显示的label
 * 使用PostStatusEnum::listData()放在下拉菜单里
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class BackendThemesEnum extends Enmu
{

    const SKIN_BLUE = "skin-blue";

    const SKIN_BLUE_LIGHT = "skin-blue-light";

    const SKIN_YELLOW = "skin-yellow";

    const SKIN_YELLOW_LIGHT = "skin-yellow-light";

    const SKIN_GREEN = "skin-green";

    const SKIN_GREEN_LIGHT = "skin-green-light";

    const SKIN_PURPLE = "skin-purple";

    const SKIN_PURPLE_LIGHT = "skin-purple-light";

    const SKIN_RED = "skin-red";

    const SKIN_RED_LIGHT = "skin-red-light";

    const SKIN_BLACK = "skin-black";

    const SKIN_BLACK_LIGHT = "skin-black-light";


    public static $list = [
        self::SKIN_BLUE => 'skin-blue',
        self::SKIN_BLUE_LIGHT => 'skin-blue-light',
        self::SKIN_YELLOW => 'skin-yellow',
        self::SKIN_YELLOW_LIGHT => 'skin-yellow-light',
        self::SKIN_GREEN => 'skin-green',
        self::SKIN_GREEN_LIGHT => 'skin-green-light',
        self::SKIN_PURPLE => 'skin-purple',
        self::SKIN_PURPLE_LIGHT => 'skin-purple-light',
        self::SKIN_RED => 'skin-red',
        self::SKIN_RED_LIGHT => 'skin-red-light',
        self::SKIN_BLACK => 'skin-black',
        self::SKIN_BLACK_LIGHT => 'skin-black-light',

    ];

}
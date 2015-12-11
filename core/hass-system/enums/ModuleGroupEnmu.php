<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\system\enums;

use hass\base\classes\Enmu;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class ModuleGroupEnmu extends Enmu
{
    const CONTENT ="content";
    const STRUCTURE="structure";
    const APPEARANCE="appearance";
    const PEOPLE="people";
    const SYSTEM="system";
    const MODULE="module";
    const CONFIG="config";

    public static $list = [
        self::SYSTEM => '系统',
        self::CONTENT => '内容',
        self::STRUCTURE => '结构',
        self::CONFIG => '配置',
        self::MODULE => '模块',
        self::APPEARANCE => '外观',
        self::PEOPLE => '用户',
    ];
}
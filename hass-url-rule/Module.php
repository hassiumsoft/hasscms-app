<?php
/**
* HassCMS (http://www.hassium.org/).
*
* @link http://github.com/hasscms for the canonical source repository
*
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\urlrule;

use hass\backend\BaseModule;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 1.0
 */
class Module extends BaseModule
{
    const EVENT_URLRULE_PREFIX_ENTITY = "EVENT_URLRULE_PREFIX_ENTITY";

    public function init()
    {
        parent::init();
    }

    public function behaviors()
    {
        return [
            '\hass\system\behaviors\MainNavBehavior',
        ];
    }
}

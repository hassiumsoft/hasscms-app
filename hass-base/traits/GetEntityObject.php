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

trait GetEntityObject
{

    public function getEntityObject()
    {
        $primaryKey = call_user_func([$this->entity,"primaryKey"]);
        return $this->hasOne($this->entity,[
            $primaryKey[0] => 'entity_id'
        ]);
    }
}
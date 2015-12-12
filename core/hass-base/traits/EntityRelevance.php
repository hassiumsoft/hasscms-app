<?php
/**
* HassCMS (http://www.hassium.org/).
*
* @link http://github.com/hasscms for the canonical source repository
*
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\traits;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
trait EntityRelevance
{
    public $entityClass;
    public $entityId;

    public function getEntityId()
    {
        if ($this->entityId == null) {
            $this->entityId = $this->owner->getPrimaryKey();
        }

        return $this->entityId;
    }

    public function getEntityClass()
    {
        if ($this->entityClass == null) {
            $this->entityClass = get_class($this->owner);
        }

        return ltrim($this->entityClass,"\\");
    }
}

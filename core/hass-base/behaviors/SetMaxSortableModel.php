<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\behaviors;
use yii\db\ActiveRecord;
/**
* 每次insert查找排序值最大的值.然后+1
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class SetMaxSortableModel extends \yii\base\Behavior
{
    public $sortKey = "weight";
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'findMaxOrderNum',
        ];
    }

    public function findMaxOrderNum()
    {
        if(!$this->owner->getAttribute($this->sortKey)) {
            $maxOrderNum = (int)(new \yii\db\Query())
                ->select('MAX(`'.$this->sortKey.'`)')
                ->from($this->owner->tableName())
                ->scalar();
            $this->owner->setAttribute($this->sortKey,++$maxOrderNum);
        }
    }
}
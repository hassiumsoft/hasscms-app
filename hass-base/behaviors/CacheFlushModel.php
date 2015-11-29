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
use Yii;
use yii\db\ActiveRecord;
/**
*
* @package hass\base
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class CacheFlushModel extends \yii\base\Behavior
{
    public $key;

    public function attach($owner)
    {
        parent::attach($owner);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'flush',
            ActiveRecord::EVENT_AFTER_UPDATE => 'flush',
            ActiveRecord::EVENT_AFTER_DELETE => 'flush',
        ];
    }

    public function flush()
    {
        if($this->key) {
            $this->key = (array)$this->key;
            foreach ($this->key as $key)
            {
                Yii::$app->cache->delete($key);
            }
        }
        else{
            Yii::$app->cache->flush();
        }
    }
}
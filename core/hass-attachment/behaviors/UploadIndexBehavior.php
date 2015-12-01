<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\attachment\behaviors;


use yii\db\ActiveRecord;
use yii\base\Behavior;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class UploadIndexBehavior extends Behavior
{
    use UploadBehaviorTrait;

    public $file;

    public $attribute;

    /**
     *
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }


    public function afterInsert()
    {
        $file = $this->owner->{$this->file};
          if ($file["id"] == - 1) {
            $attachment = $this->attachFile($file);
            $this->saveIndex($attachment->primaryKey);
        } elseif ($file["id"] > 0) {
            $this->saveIndex($file["id"]);
        }
    }


}
<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\tag\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use hass\tag\models\Tag;
use hass\tag\models\TagIndex;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class Taggable extends Behavior
{
    use \hass\base\traits\EntityRelevance;
    private $_tags;

    public static $formName = "tagItems";

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function getTagIndex()
    {
        return $this->owner->hasMany(TagIndex::className(), ['entity_id' => $this->owner->primaryKey()[0]])->where(['entity' => $this->getEntityClass()]);
    }

    public function getTags()
    {
        return $this->owner->hasMany(Tag::className(), ['tag_id' => 'tag_id'])->via('tagIndex');
    }

    public function getTagItems()
    {
        if($this->_tags === null){
            $this->_tags = [];
            foreach($this->owner->tags as $tag) {
                $this->_tags[] = $tag->name;
            }
        }
        return $this->_tags;
    }

    public function afterSave()
    {
        if(!$this->owner->isNewRecord) {
            $this->beforeDelete();
        }

        $data = \Yii::$app->request->post($this->owner->formName());
        
        if(isset($data[static::$formName]) && !empty($data[static::$formName])) {
            $tags = $data[static::$formName];
            $tagIndexs = [];
            
            foreach ($tags as $name) {
                if (!($tag = Tag::findOne(['name' => $name]))) {
                    $tag = new Tag(['name' => $name]);
                }
                $tag->frequency++;
                if ($tag->save()) {
                    $updatedTags[] = $tag;
                    $tagIndexs[] = [$this->getEntityClass(), $this->getEntityId(), $tag->tag_id];
                }
            }

            if(count($tagIndexs)) {
                \Yii::$app->db->createCommand()->batchInsert(TagIndex::tableName(), ['entity', 'entity_id', 'tag_id'], $tagIndexs)->execute();
                $this->owner->populateRelation('tags', $updatedTags);
            }
        }
    }

    public function beforeDelete()
    {
        $pks = [];

        foreach($this->owner->tags as $tag){
            $pks[] = $tag->primaryKey;
        }

        if (count($pks)) {
            Tag::updateAllCounters(['frequency' => -1], ['in', 'tag_id', $pks]);
        }
        Tag::deleteAll(['frequency' => 0]);
        TagIndex::deleteAll(['entity' => $this->getEntityClass(), 'entity_id' => $this->getEntityId()]);
    }


}

?>
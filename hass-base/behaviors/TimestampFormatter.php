<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\behaviors;
use yii\base\Behavior;
use Yii;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class TimestampFormatter extends Behavior
{

    /**
     * createdDate
     */

    public function getCreatedDate()
    {
        return Yii::$app->getFormatter()->asDate( $this->getCreatedTimestamp());
    }

    public function getCreatedTime()
    {
        return Yii::$app->getFormatter()->asTime($this->getCreatedTimestamp());
    }

    public function getCreatedDateTime()
    {
        return Yii::$app->getFormatter()->asDatetime($this->getCreatedTimestamp());
    }

    public function getCreatedTimestamp()
    {
        return  ($this->owner->isNewRecord) ? time() : $this->owner->created_at;
    }

    /**
     *updatedDate
     */

    public function getUpdatedDate()
    {
        return Yii::$app->getFormatter()->asDate($this->getUpdatedTimestamp());
    }

    public function getUpdatedTime()
    {
        return Yii::$app->getFormatter()->asTime($this->getUpdatedTimestamp());
    }

    public function getUpdatedDateTime()
    {
        return Yii::$app->getFormatter()->asDatetime($this->getUpdatedTimestamp());
    }

    public function getUpdatedTimestamp()
    {
        return  ($this->owner->isNewRecord) ? time() : $this->owner->updated_at;
    }

    /**
     * publishedDate
     */

    public function getPublishedDate()
    {
        return Yii::$app->getFormatter()->asDate( $this->getPublishedTimestamp());
    }

    public function getPublishedTime()
    {
        return Yii::$app->getFormatter()->asTime($this->getPublishedTimestamp());
    }

    public function getPublishedDateTime()
    {
        return Yii::$app->getFormatter()->asDatetime($this->getPublishedTimestamp());
    }

    public function getPublishedTimestamp()
    {
        return  ($this->owner->isNewRecord) ? time() : $this->owner->published_at;
    }

    /**
     * attribute
     */
    public function getAttributeDate($attribute)
    {
        return Yii::$app->getFormatter()->asDate( $this->getAttributeTimestamp($attribute));
    }

    public function getAttributeTime($attribute)
    {
        return Yii::$app->getFormatter()->asTime($this->getAttributeTimestamp($attribute));
    }

    public function getAttributeDateTime($attribute)
    {
        return Yii::$app->getFormatter()->asDatetime($this->getAttributeTimestamp($attribute));
    }

    public function getAttributeTimestamp($attribute)
    {
        return  ($this->owner->isNewRecord) ? time() : $this->owner->{$attribute};
    }

}
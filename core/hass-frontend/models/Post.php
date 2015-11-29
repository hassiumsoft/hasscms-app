<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\models;
use hass\backend\behaviors\TimestampFormatter;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class Post extends \hass\post\models\Post
{
    public function behaviors()
    {
        $behaviors = [];
        $behaviors["thumbnailFile"] = [
            'class' => \hass\attachment\behaviors\UploadBehavior::className(),
            'attribute' => 'thumbnail',
            'entityClass'=>'hass\post\models\Post'
        ];
        $behaviors['taxonomy'] = [
            'class' => \hass\taxonomy\behaviors\TaxonomyBehavior::className(),
            'root' => 'xin-wen',
            'entityClass'=>'hass\post\models\Post'
        ];
        $behaviors['taggabble'] = [
            'class'=>\hass\tag\behaviors\Taggable::className(),
            'entityClass'=>'hass\post\models\Post'
        ];
        $behaviors['commentEnabled'] = [
            'class' => \hass\comment\behaviors\CommentBehavior::className(),
            'defaultStatus' => \hass\comment\enums\CommentEnabledEnum::STATUS_ON,
            'entityClass'=>'hass\post\models\Post'
        ];
        $behaviors["TimestampFormatter"] = TimestampFormatter::className();
        return $behaviors;
    }



    public function addViewsNumber($num = 1)
    {
        $this->detachBehaviors();
        $this->views +=$num;
        $this->save();
        $this->attachBehaviors($this->behaviors());
    }

}
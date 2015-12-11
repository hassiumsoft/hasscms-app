<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\models;

use yii\helpers\StringHelper;
use hass\base\behaviors\TimestampFormatter;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class Page extends \hass\page\models\Page
{

    public static function tableName()
    {
        return '{{%page}}';
    }
    
    
    public function behaviors()
    {
        $behaviors = [];
        $behaviors['commentEnabled'] = [
            'class' => \hass\comment\behaviors\CommentBehavior::className(),
            'defaultStatus' => \hass\comment\enums\CommentEnabledEnum::STATUS_ON,
            'entityClass'=>'hass\page\models\Page'
        ];
        $behaviors['meta'] = [
            'class'=>\hass\meta\behaviors\MetaBehavior::className(),
              'entityClass'=>'hass\page\models\Page'
        ];
        $behaviors["TimestampFormatter"] = TimestampFormatter::className();
        return $behaviors;
    }
    

    public function getMetaData()
    {
        $model = $this->getMetaModel();
        
        $title = $model->title ?  : $this->title;
        
        $description = $model->description ?  : StringHelper::truncate(strip_tags($this->content), 200);
        
        return [
            $title,
            $description,
            $model->keywords
        ];
    }
}
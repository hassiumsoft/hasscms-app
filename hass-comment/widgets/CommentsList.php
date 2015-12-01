<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\comment\widgets;

use hass\comment\models\Comment;
use yii\data\ActiveDataProvider;
use hass\base\enums\EntityStatusEnum;
use yii\web\View;
use yii\helpers\Url;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class CommentsList extends \yii\base\Widget
{

    public $entity;
    public $entity_id;
    public $parent_id;
    public $nestedLevel;

    public $dataProvider;

    public $replyFormUrl;
    public $maxNestedLevel;
    public function init()
    {
        parent::init();
        if($this->replyFormUrl)
        {
            $this->view->registerJs('var replyFormUrl = "'.Url::to($this->replyFormUrl). '";',View::POS_HEAD);
        }

        if($this->nestedLevel == null)
        {
            $this->nestedLevel = 1; //代表第一层
        }

        $this->maxNestedLevel = 5;
    }

    public function run()
    {
        $order = ($this->parent_id) ? SORT_ASC : SORT_DESC;


        if($this->dataProvider == null)
        {
            $this->dataProvider = new ActiveDataProvider([
                'query' => Comment::find()->where([
                    'entity' =>$this->entity,
                    'entity_id' =>$this->entity_id,
                    'parent_id' => $this->parent_id,
                    'status' => EntityStatusEnum::STATUS_PUBLISHED,
                ])->orderBy(['comment_id' => $order]),

                'pagination' => [
                    'pageSize' =>10
                ]
            ]);
        }


        return $this->render('list',
            [
                'entity' =>$this->entity,
                'entity_id' =>$this->entity_id,
                'dataProvider' => $this->dataProvider,
                'nestedLevel' => $this->nestedLevel,
                "maxNestedLevel"=>$this->maxNestedLevel
            ]);
    }

}
<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\actions;

use yii\base\Action;
use hass\comment\models\Comment;
use Yii;
use yii\web\Cookie;
use hass\comment\widgets\CommentsList;
use yii\data\ActiveDataProvider;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class AjaxCreate extends Action
{

    public function run()
    {
        $model = new Comment();
        $model->scenario = (Yii::$app->user->isGuest) ? Comment::SCENARIO_GUEST : Comment::SCENARIO_USER;

        $model->load(Yii::$app->getRequest()
            ->post());

        if ( $model->save()) {

            if (Yii::$app->user->isGuest) {

                $cookie = new Cookie([
                    'name' => "username",
                    'value' => $model->username,
                    'expire' => time() + 86400 * 365
                ]);
                Yii::$app->getResponse()
                    ->getCookies()
                    ->add($cookie);

                $cookie = new Cookie([
                    'name' => "email",
                    'value' => $model->email,
                    'expire' => time() + 86400 * 365
                ]);

                Yii::$app->getResponse()
                    ->getCookies()
                    ->add($cookie);
            }

            $content = CommentsList::widget([
                "entity"=>$model->entity,
                "entity_id"=>$model->entity_id,
                "dataProvider"=>new ActiveDataProvider([
                'query' => Comment::find()->where([
                    'comment_id' => $model->comment_id
                    ])
                ]),
                "nestedLevel"=>Yii::$app->getRequest()->post("nestedLevel")+1
            ]);
            return $this->controller->renderJsonMessage(true,$content);
        }
        return $this->controller->renderJsonMessage(false,$model->formatErrors());
    }
}
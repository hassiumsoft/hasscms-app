<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\controllers;


use yii\web\Controller;
use yii\data\ActiveDataProvider;
use hass\frontend\models\Post;


/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction'
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->orderBy([
                'id' => SORT_DESC
            ]),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        
        $this->getView()->setMetaData("",\Yii::$app->get("config")->get("app.description"),\Yii::$app->get("config")->get("app.keywords"));
        return $this->render('index', [
            "posts" => $dataProvider->getModels(),
            "pagination" => $dataProvider->getPagination()
        ]);
    }
}

<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\tag\controllers;

use Yii;
use yii\base\Response;
use hass\tag\models\Tag;
use hass\base\BaseController;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class DefaultController extends BaseController
{

    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\tag\models\Tag'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => 'hass\tag\models\Tag',
                "query"=>[
                    "orderBy"=>['frequency' => SORT_DESC]
                ],
                'sort'=>["attributes"=>["frequency"]],
                "filters"=>["%name"]
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\tag\models\Tag'
            ]
        ];
    }


    public function actionList($query)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $items = [];
        $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        foreach (Tag::find()->where(['like', 'name', $query])->asArray()->all() as $tag) {
            $items[] = ['name' => $tag['name']];
        }

        return $items;
    }



}

?>
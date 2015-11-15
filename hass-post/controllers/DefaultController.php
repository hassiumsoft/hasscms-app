<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\post\controllers;

use hass\backend\BaseController;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class DefaultController extends BaseController
{
    public function actions()
    {
        return [
            "switcher" => [
                "class" => '\hass\extensions\grid\actions\SwitcherAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "delete" => [
                "class" => '\hass\backend\actions\DeleteAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "index" => [
                "class" => '\hass\backend\actions\IndexAction',
                'modelClass' => 'hass\post\models\Post',
                "query"=>[
                    "orderBy"=>['created_at' => SORT_DESC]
                ],
                "filters"=>["%title","status","id"],
            ],
            "update" => [
                "class" => '\hass\backend\actions\UpdateAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "create" => [
                "class" => '\hass\backend\actions\CreateAction',
                'modelClass' => 'hass\post\models\Post'
            ]
        ];
    }
}
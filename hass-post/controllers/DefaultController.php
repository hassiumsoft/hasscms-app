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
            "switcher" => [
                "class" => '\hass\base\misc\grid\actions\SwitcherAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => 'hass\post\models\Post',
                "query"=>[
                    "orderBy"=>['created_at' => SORT_DESC]
                ],
                "filters"=>["%title","status","id"],
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\post\models\Post'
            ],
            "create" => [
                "class" => '\hass\base\actions\CreateAction',
                'modelClass' => 'hass\post\models\Post'
            ]
        ];
    }
}
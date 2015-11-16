<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\page\controllers;

use Yii;
use hass\backend\BaseController;
use hass\backend\enums\DirectionEnum;
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
                "class" => '\hass\extensions\grid\actions\SwitcherAction',
                'modelClass' => 'hass\page\models\Page'
            ],
            "up" => [
                "class" => '\hass\extensions\grid\actions\SortableAction',
                'modelClass' => 'hass\page\models\Page',
                'direction' => DirectionEnum::DIRECTION_UP
            ],
            "down" => [
                "class" => '\hass\extensions\grid\actions\SortableAction',
                'modelClass' => 'hass\page\models\Page',
                'direction' => DirectionEnum::DIRECTION_DOWN
            ],
            "delete" => [
                "class" => '\hass\backend\actions\DeleteAction',
                'modelClass' => 'hass\page\models\Page'
            ],
            "index" => [
                "class" => '\hass\backend\actions\IndexAction',
                'modelClass' => 'hass\page\models\Page',
                "query"=>[
                    "orderBy"=>['weight' => SORT_DESC]
                ],
                "filters"=>["%title"]
            ],
            "update" => [
                "class" => '\hass\backend\actions\UpdateAction',
                'modelClass' => 'hass\page\models\Page'
            ],
            "create" => [
                "class" => '\hass\backend\actions\CreateAction',
                'modelClass' => 'hass\page\models\Page'
            ]
        ];
    }
}
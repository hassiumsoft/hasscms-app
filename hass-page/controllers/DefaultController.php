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
use hass\base\BaseController;
use hass\base\enums\DirectionEnum;
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
                'modelClass' => 'hass\page\models\Page'
            ],
            "up" => [
                "class" => '\hass\base\misc\grid\actions\SortableAction',
                'modelClass' => 'hass\page\models\Page',
                'direction' => DirectionEnum::DIRECTION_UP
            ],
            "down" => [
                "class" => '\hass\base\misc\grid\actions\SortableAction',
                'modelClass' => 'hass\page\models\Page',
                'direction' => DirectionEnum::DIRECTION_DOWN
            ],
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\page\models\Page'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => 'hass\page\models\Page',
                "query"=>[
                    "orderBy"=>['weight' => SORT_DESC]
                ],
                "filters"=>["%title"]
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\page\models\Page'
            ],
            "create" => [
                "class" => '\hass\base\actions\CreateAction',
                'modelClass' => 'hass\page\models\Page'
            ]
        ];
    }
}
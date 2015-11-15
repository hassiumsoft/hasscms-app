<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\system\controllers;

use hass\backend\enums\DirectionEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class ModulesController extends \hass\backend\BaseController
{

    public function actions()
    {
        return [
            "switcher" => [
                "class" => '\hass\extensions\grid\actions\SwitcherAction',
                'modelClass' => 'hass\system\models\Module'
            ],
            "up" => [
                "class" => '\hass\extensions\grid\actions\SortableAction',
                'modelClass' => 'hass\system\models\Module',
                'direction' => DirectionEnum::DIRECTION_UP
            ],
            "down" => [
                "class" => '\hass\extensions\grid\actions\SortableAction',
                'modelClass' => 'hass\system\models\Module',
                'direction' => DirectionEnum::DIRECTION_DOWN
            ],
            "delete" => [
                "class" => '\hass\backend\actions\DeleteAction',
                'modelClass' => 'hass\system\models\Module'
            ],
           "index" => [
                "class" => '\hass\backend\actions\IndexAction',
                'modelClass' => 'hass\system\models\Module',
                "query"=>[
                   "orderBy"=>['weight' => SORT_DESC]
                ]
            ],
            "update" => [
                "class" => '\hass\backend\actions\UpdateAction',
                'modelClass' => 'hass\system\models\Module'
            ],
        ];
    }

}
<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\config\controllers;

use hass\base\BaseController;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class CustomController extends BaseController
{

    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\config\models\Config'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => 'hass\config\models\Config',
                "sort" => [
                    'attributes' => [
                        "name"
                    ]
                ],
                "filters"=>["%name"]
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\config\models\Config'
            ]
        ]
        ;
    }
}

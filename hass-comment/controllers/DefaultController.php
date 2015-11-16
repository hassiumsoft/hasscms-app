<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\comment\controllers;

use hass\backend\BaseController;

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
                "class" => '\hass\backend\actions\DeleteAction',
                'modelClass' => 'hass\comment\models\Comment'
            ],
            "index" => [
                "class" => '\hass\backend\actions\IndexAction',
                'modelClass' => 'hass\comment\models\Comment',
                "query"=>[
                    "orderBy"=>['created_at' => SORT_DESC]
                ],
                "filters"=>["%username","author_id"]
            ],
            "update" => [
                "class" => '\hass\backend\actions\UpdateAction',
                'modelClass' => 'hass\comment\models\Comment'
            ],
            "create" => [
                "class" => '\hass\backend\actions\CreateAction',
                'modelClass' => 'hass\comment\models\Comment'
            ],
            "config" => [
                "class" => 'hass\config\actions\ConfigAction',
                'modelClass' => "\\hass\\comment\\models\\CommentConfigForm"
            ]
        ];
    }


}

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
class DefaultController extends BaseController
{
    public function actions()
    {
        return [
            "basic" => [
                "class" => 'hass\config\actions\ConfigAction',
                'modelClass' => "\\hass\\config\\models\\BasicConfigForm"
            ],
            "database" => [
                "class" => 'hass\config\actions\ConfigAction',
                'modelClass' => "\\hass\\config\\models\\DatabaseConfigForm"
            ],
            "mail" => [
                "class" => 'hass\config\actions\ConfigAction',
                'modelClass' => "\\hass\\config\\models\\MailConfigForm",
            ]
        ];
    }
}
<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\models;


use yii\base\Model;

/**
 *
 * @id hass\id_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class ThemezipForm extends Model
{
    public $themezip;


    public function rules()
    {
        return [
            ["themezip","file","extensions"=>"zip"]
        ];
    }

}
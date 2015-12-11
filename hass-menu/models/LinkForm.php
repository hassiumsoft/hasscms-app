<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\menu\models;
use yii\base\Model;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class LinkForm extends Model
{
    public $url = "";

    public $name ="";

    public function rules()
    {
        return [
            [['url', 'name'], 'required'],
            [['url', 'name'], 'string'],

        ];
    }


    public function attributeLabels()
    {
        return [];
    }


}

?>
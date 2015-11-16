<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\config\models;
use yii\base\Model;
use Yii;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class BaseConfig extends Model
{

    /**
     * @return \hass\config\components\Config
     */
    public function getConfig() {
       return \Yii::$app->get("config");
    }

}
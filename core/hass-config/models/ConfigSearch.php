<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\config\models;

use hass\base\traits\SearchModelTrait;


/**
* This is the model class for table "{{%config}}".
*
* @property integer $id
* @property string $name
* @property string $value
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ConfigSearch extends Config
{
    use SearchModelTrait;
}

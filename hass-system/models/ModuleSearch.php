<?php

/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\system\models;
use Yii;
use hass\backend\traits\SearchModelTrait;
/**
* This is the model class for table "{{%modules}}".
*
* @property integer $module_id
* @property string $name
* @property string $class
* @property string $title
* @property string $icon
* @property integer $notice
* @property integer $weight
* @property integer $status
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
 */
class ModuleSearch extends  Module
{
    use SearchModelTrait;

}
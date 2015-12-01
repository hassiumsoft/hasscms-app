<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\tag\models;

use hass\base\ActiveRecord;
use hass\base\traits\GetEntityObject;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class TagIndex extends ActiveRecord
{
    use GetEntityObject;
    
    public static function tableName()
    {
        return '{{%tag_index}}';
    }
}

?>
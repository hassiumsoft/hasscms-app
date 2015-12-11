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


use hass\meta\behaviors\MetaBehavior;
use hass\base\ActiveRecord;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['frequency', 'integer'],
            ['frequency', 'default', 'value' => 1],
            ['name', 'string', 'max' => 64],
        ];
    }

    public function behaviors()
    {
        return [
            'metaBehavior' => MetaBehavior::className()
        ];
    }


    public function afterDelete()
    {
        TagIndex::deleteAll(['tag_id' => $this->primaryKey]);
    }

}

?>
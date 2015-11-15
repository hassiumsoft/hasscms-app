<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\backend\traits;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 1.0
*/
trait ModelTrait
{

    /**
     * 将所有错误转换成字符窜并用空格隔开,或者只获得其中的一个错误
     * @return string
     */
    public function formatErrors($all = true)
    {
        $result = '';
        foreach($this->getErrors() as $attribute => $errors) {
            if($all == false)
            {
                $result = array_pop($errors);
                break;
            }
            $result .= implode(" ", $errors)." ";
        }
        return $result;
    }

    public static function findByIdOrSlug($id)
    {
        $id = intval($id);
        $condition = ["id"=>$id];
        if($id == 0)
        {
            $condition = ["slug"=>$id];
        }

        return static::findOne($condition);

    }

}
<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\traits;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
trait ModelTrait
{

    /**
     * 将所有错误转换成字符窜并用空格隔开,或者只获得其中的一个错误
     * 
     * @return string
     */
    public function formatErrors($all = true)
    {
        $result = '';
        foreach ($this->getErrors() as $errors) {
            if ($all == false) {
                $result = array_pop($errors);
                break;
            }
            $result .= implode("=_=", $errors) . "=_=";
        }
        return $result;
    }

    public static function findByIdOrSlug($id)
    {
        $id = intval($id);
        $condition = [
            $id
        ];
        if ($id == 0) {
            $condition = [
                "slug" => $id
            ];
        }
        
        return static::findOne($condition);
    }
}
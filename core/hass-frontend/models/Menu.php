<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\models;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class Menu extends \hass\menu\models\Menu
{

    //@hass-todo 未作缓存,没有反序列化options
    public static function findBySlug($slug)
    {
        $model = Menu::findOne([
            'slug' => $slug
        ]);

        $collection = $model->children()->select(["name","title","original","module","depth","options"])
        ->asArray()
        ->all();
        return $collection;
    }
}
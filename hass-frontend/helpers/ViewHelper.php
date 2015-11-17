<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\helpers;

use hass\frontend\widgets\MenuRenderWidget;
use hass\helpers\Util;
use yii\helpers\Url;
use hass\area\widgets\Area;
use hass\area\widgets\Block;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class ViewHelper
{

    public static function menu($slug = "", $config = [])
    {
        $config["slug"] = $slug;
        
        return MenuRenderWidget::widget($config);
    }

    public static function config($name, $default = null)
    {
        return Util::getConfig()->get($name, $default);
    }

    public static function area($slug, $config = [])
    {
        $config["slug"] = $slug;
        return Area::widget($config);
    }

    public static function areaBlock($slug, $config = [])
    {
        $config["slug"] = $slug;
        return Block::widget($config);
    }

    public static function tags()
    {}

    public static function entityToUrl($entity)
    {
        return Url::to(Util::getEntityUrl($entity));
    }
    
    public static function call($callback,$paramArr=[])
    {
        return call_user_func_array($callback, $paramArr);
    }
}
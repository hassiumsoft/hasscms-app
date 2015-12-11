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
use hass\base\helpers\Util;
use yii\helpers\Url;
use hass\area\widgets\Area;
use hass\area\widgets\Block;
use hass\frontend\models\Tag;

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
        return \Yii::$app->get("config")->get($name, $default);
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

    public static function tags($limit = 10)
    {
        return Tag::find()->orderBy(['frequency' => SORT_DESC])->limit($limit)->all();
    }

    public static function entityToUrl($entity)
    {
        return Url::to(Util::getEntityUrl($entity));
    }
    
    public static function breadcrumb($entity)
    {
        return Util::getBreadcrumbs($entity);
    }
    
    public static function call($className, $method, $arguments = null)
    {
        $callable = [$className, $method];
        if ($arguments === null) {
            return call_user_func($callable);
        } else {
            return call_user_func_array($callable, $arguments);
        }
    }
    
}
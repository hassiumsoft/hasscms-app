<?php
/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\helpers;

use Yii;
use yii\helpers\StringHelper;
use hass\base\classes\Hook;

/**
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
class Util
{


    public static function substr($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length === null ? mb_strlen($string, '8bit') : $length);
    }

    public static function cache($key, $callable, $duration = 0)
    {
        $cache = Yii::$app->cache;
        if ($cache->exists($key)) {
            $data = $cache->get($key);
        } else {
            $data = $callable();

            if ($data) {
                $cache->set($key, $data, $duration);
            }
        }

        return $data;
    }

    /**
     * 配置文件中的配置，要高于模块中定义的配置。。。所以override默认是false
     * 
     * @param unknown $id
     * @param unknown $config
     * @param string $override
     */
    public static function setComponent($id, $config, $override = false)
    {
        $definitions = \Yii::$app->getComponents();
        if ($override == false) {
            \Yii::$app->set($id, ArrayHelper::merge($config, array_key_exists($id, $definitions) ? $definitions[$id] : []));
        } else {
            \Yii::$app->set($id, ArrayHelper::merge(array_key_exists($id, $definitions) ? $definitions[$id] : [], $config));
        }
    }

    public static function setModule($id, $config, $override = false)
    {
        $definitions = \Yii::$app->getModules();
        if ($override == false) {
            \Yii::$app->setModule($id, ArrayHelper::merge($config, array_key_exists($id, $definitions) ? $definitions[$id] : []));
        } else {
            \Yii::$app->setModule($id, ArrayHelper::merge(array_key_exists($id, $definitions) ? $definitions[$id] : [], $config));
        }
    }

    /**
     * @param unknown $email
     *
     * @return string
     */
    public static function getEmailLoginUrl($email)
    {
        $host = substr($email, strpos($email, '@') + 1);

        if ($host == 'hotmail.com') {
            return 'http://www.' . $host;
        }

        if ($host == 'gmail.com') {
            return 'http://mail.google.com';
        }

        return 'http://mail.' . $host;
    }

    /**
     * 获取navs中第一个有url的nav.
     *
     * @param unknown $navs
     */
    public static function getFirstNav($navs)
    {
        foreach ($navs as $nav) {
            if (array_key_exists('url', $nav)) {
                return $nav;
            }

            if (array_key_exists('items', $nav) && count($nav['items']) > 0) {
                $nav = static::getFirstNav($nav['items']);
                if ($nav != null) {
                    return $nav;
                }
            }
        }

        return;
    }

    /**
     * 为navs中的所有url附加参数.
     *
     * @param unknown $navs
     * @param unknown $params
     */
    public static function navAttachParams(&$navs, $params)
    {
        foreach ($navs as &$nav) {
            if (array_key_exists('url', $nav)) {
                $nav['url'] = array_merge($nav['url'], $params);
            }

            if (array_key_exists('items', $nav) && count($nav['items']) > 0) {
                static::navAttachParams($nav['items'], $params);
            }
        }
    }

    /**
     * 根据实体返回这个实体的url地址.
     *
     * @param \hass\base\ActiveRecord $model
     * @param unknown $type
     */
    public static function getEntityUrl($model, $type = "read")
    {
        $alias = static::getEntityPrefix($model);
        if (is_string($alias)) {
            $route = "$alias/$type";
        } else if (is_array($alias)) {
            if (array_key_exists($type, $alias)) {
                $route = $alias[$type];
            } else {
                $alias = $alias[0];
                $route = "$alias/$type";
            }
        }
        return [$route, "id" => $model->primaryKey];
    }


    public static function getEntityPrefix($model)
    {
        $parameters = Hook::trigger(\hass\urlrule\Module::EVENT_URLRULE_PREFIX_ENTITY)->parameters;
        $alias = null;
        foreach ($parameters as $class => $prefix) {
            if ($model instanceof $class) {
                $alias = $prefix;
                break;
            }
        }
        if ($alias == null) {
            $alias = strtolower(StringHelper::basename(get_class($model)));
        }
        return $alias;
    }

    /**
     * 获取面包屑
     * @param $model
     * @return array
     */
    public static function getBreadcrumbs($model)
    {
        $result = [\Yii::$app->get("config")->get("app.name") => Yii::$app->getHomeUrl()];
        if ($model->hasMethod("getParentsAndSelf")) {
            $nodes = $model->getParentsAndSelf();
            foreach ($nodes as $node) {
                $name = isset($node->name)?$node->name:$node->title;
                $result[$name] = static::getEntityUrl($node);
            }
        } elseif (isset($model->taxonomys)) {
            $taxonomys = $model->taxonomys;
            $nodes = [];
            if (!empty($taxonomys)) {
                $taxonomy = array_shift($taxonomys);//可能有多个分类只取其中一个
                $nodes = $taxonomy->parents()->all();
                array_push($nodes, $taxonomy);
            }
            foreach ($nodes as $node) {
                $result[$node->name] = static::getEntityUrl($node);
            }
        }
        return $result;
    }
}

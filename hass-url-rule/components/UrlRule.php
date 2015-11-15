<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\urlrule\components;

use Yii;
use hass\helpers\Util;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class UrlRule extends \yii\web\UrlRule
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->name === null) {
            $this->name = static::className();
        }
    }

    /**
     *
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|mixed
     */
    public function createUrl($manager, $route, $params)
    {

        $rule = $this->getRuleByRouteOrPattern($route, $params);

        if ($rule) {
            return $rule->pattern;
        }

        return false;
    }

    public function getRuleByRouteOrPattern($route, $params)
    {

        if(!is_array($params))
        {
            $pattern = $route;

            $rule = Util::cache($this->name.md5($pattern), function () use($pattern) {
                $rule = \hass\urlrule\models\UrlRule::getRuleByPattern($pattern);
                return $rule;
            });

            if(!$rule)
            {
                return $rule;
            }

            parse_str($rule->defaults, $params);
            \Yii::$app->getCache()->set($this->name.md5($rule->route . serialize($params)), $rule);
        }
        else
        {
            $rule =  Util::cache($this->name.md5($route . serialize($params)), function () use($route, $params) {
                $rule = \hass\urlrule\models\UrlRule::getRuleByRoute($route, $params);
                return $rule;
            });

            if(!$rule)
            {
                return $rule;
            }
            \Yii::$app->getCache()->set($this->name.md5($rule->pattern), $rule);
        }

       return $rule;
    }

    /**
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        $rule = $this->getRuleByRouteOrPattern($request->getPathInfo(),null);
        if ($rule) {
            parse_str($rule->defaults, $params);
            return [
                $rule->route,
                $params
            ];
        }

        return false;
    }
}
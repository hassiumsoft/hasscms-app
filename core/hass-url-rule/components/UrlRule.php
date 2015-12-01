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

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class UrlRule extends \yii\web\UrlRule
{

    /**
     * @inheritdoc
     */
    public function init()
    {}

    /**
     *
     * @param \yii\web\UrlManager $manager            
     * @param string $route            
     * @param array $params            
     * @return bool|mixed
     */
    public function createUrl($manager, $route, $params)
    {
        $rule = $this->getRuleByRoute($route, $params);
        
        if ($rule) {
            return $rule->pattern;
        }
        
        return false;
    }

    public function getRuleByRoute($route, $params)
    {
        $ruleCache = \Yii::$app->getCache()->get(UrlRule::className());
        if ($ruleCache == null) {
            $ruleCache = [];
        }
        
        $params = (array) $params;
        
        $cacheKey = $route . '?' . serialize($params);
        
        if (isset($ruleCache[$cacheKey])) {
            return $ruleCache[$cacheKey];
        }

        $rule = \hass\urlrule\models\UrlRule::getRuleByRoute($route, $params);
        if (! $rule) {
            return null;
        }
        
        $ruleCache[$cacheKey] = $rule;        
        \Yii::$app->getCache()->set(UrlRule::className(), $ruleCache);
        
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
        $rule = $this->getRuleByPattern($request->getPathInfo(), null);
        if ($rule) {
            $params = [];
            parse_str($rule->defaults, $params);
            return [
                $rule->route,
                $params
            ];
        }
        
        return false;
    }
    
    
    public function getRuleByPattern($pattern)
    {
        $ruleCache = \Yii::$app->getCache()->get(UrlRule::className());
        if ($ruleCache == null) {
            $ruleCache = [];
        }
        
        $cacheKey = $pattern;
        
        if (isset($ruleCache[$cacheKey])) {
            return $ruleCache[$cacheKey];
        }
        
        $rule = \hass\urlrule\models\UrlRule::getRuleByPattern($pattern);
        if (! $rule) {
            return null;
        }
        
        $ruleCache[$cacheKey] = $rule;
        \Yii::$app->getCache()->set(UrlRule::className(), $ruleCache);
        
        return $rule;
    }
}
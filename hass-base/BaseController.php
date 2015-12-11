<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base;
use hass\base\traits\BaseControllerTrait;
use hass\rbac\components\AccessControl;
/**
 *
 * @package hass\base
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class BaseController extends  \yii\web\Controller
{
    use BaseControllerTrait;
    
    public function behaviors()
    {
        return [
            'rbac' => [
                'class' => AccessControl::className()
            ]
        ];
    }

    /**
     * 检查用户是否登录,未登录则跳转到登录页面
     * @see \yii\base\Controller::beforeAction()
     */
    public function beforeAction($action)
    {
        if(!parent::beforeAction($action))
            return false;

        if(\Yii::$app->getUser()->getIsGuest() == false){
            return true;
        }

        \Yii::$app->getUser()->loginRequired();
        return false;
    }
}
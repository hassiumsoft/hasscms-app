<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\components;

use Yii;
use yii\web\User;
use yii\di\Instance;
use yii\base\Module;
use yii\base\ActionFilter;
use yii\web\ForbiddenHttpException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class AccessControl extends ActionFilter
{

    /**
     *
     * @var User User for check access.
     */
    private $_user = 'user';

    /**
     *
     * @var array List of action that not need to check access.
     */
    public $allowActions = [];

    /**
     * Get user
     * 
     * @return User
     */
    public function getUser()
    {
        if (! $this->_user instanceof User) {
            $this->_user = Instance::ensure($this->_user, User::className());
        }
        return $this->_user;
    }

    /**
     * Set user
     * 
     * @param User|string $user            
     */
    public function setUser($user)
    {
        $this->_user = $user;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $user = $this->getUser();
        
        
        if ($user->can(\hass\rbac\Module::SUPER_PERMISSION)) {
            return true;
        }
        
        $route = \Yii::$app->requestedRoute;
        
        if ($user->can($route)) {
            return true;
        }
        
        $count = substr_count($route, "/");
        for ($i = 0; $i < $count; $i ++) {
            $route = substr($route, 0, strrpos($route, "/"));
            $item = $route . "/*";
            if ($user->can($item)) {
                return true;
            }
        }
        
        $this->denyAccess($user);
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * 
     * @param yii\web\User $user
     *            the current user
     * @throws yii\web\ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        if ($user->getIsGuest()) {
            $user->loginRequired();
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }

    /**
     * @inheritdoc
     */
    protected function isActive($action)
    {
        $uniqueId = $action->getUniqueId();
        if ($uniqueId === Yii::$app->getErrorHandler()->errorAction) {
            return false;
        }
        
        $user = $this->getUser();
        if ($user->getIsGuest() && is_array($user->loginUrl) && isset($user->loginUrl[0]) && $uniqueId === trim($user->loginUrl[0], '/')) {
            return false;
        }
        
        if ($this->owner instanceof Module) {
            // convert action uniqueId into an ID relative to the module
            $mid = $this->owner->getUniqueId();
            $id = $uniqueId;
            if ($mid !== '' && strpos($id, $mid . '/') === 0) {
                $id = substr($id, strlen($mid) + 1);
            }
        } else {
            $id = $action->id;
        }
        
        foreach ($this->allowActions as $route) {
            if (substr($route, - 1) === '*') {
                $route = rtrim($route, "*");
                if ($route === '' || strpos($id, $route) === 0) {
                    return false;
                }
            } else {
                if ($id === $route) {
                    return false;
                }
            }
        }
        
        if ($action->controller->hasMethod('allowAction') && in_array($action->id, $action->controller->allowAction())) {
            return false;
        }
        
        return true;
    }
}
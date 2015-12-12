<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\user\controllers;
use Yii;
use hass\user\models\LoginForm;
/**
*
* @package hass\user
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class SecurityController extends \dektrium\user\controllers\SecurityController
{
    public $layout = '@hass/backend/views/layouts/main-login';
    private $_viewPath;
    
    /**
     * 将后台的登录模板文件设置到admin目录。security目录下的模板文件供给前台使用
     * {@inheritDoc}
     * @see \yii\base\Controller::getViewPath()
     */
    public function getViewPath()
    {
        if ($this->_viewPath === null) {
            $this->_viewPath = $this->module->getViewPath() . DIRECTORY_SEPARATOR . "admin";
        }
        return $this->_viewPath;
    }
    
    public function actionIn()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = Yii::createObject(LoginForm::className());

        if ($model->load(Yii::$app->getRequest()->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
    }


}
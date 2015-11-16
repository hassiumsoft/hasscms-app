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
    public $layout = '@hass/admin/views/layouts/main-login';

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
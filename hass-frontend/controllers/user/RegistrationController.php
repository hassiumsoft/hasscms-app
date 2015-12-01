<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\frontend\controllers\user;
use dektrium\user\models\ResendForm;

use Yii;

use yii\web\NotFoundHttpException;
use hass\base\helpers\Util;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class RegistrationController extends \dektrium\user\controllers\RegistrationController
{
    /**
     * Displays page where user can request new confirmation token. If resending was successful, displays message.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionResend()
    {
        if ($this->module->enableConfirmation == false) {
            throw new NotFoundHttpException();
        }
    
        /** @var ResendForm $model */
        $model = Yii::createObject(ResendForm::className());
        $event = $this->getFormEvent($model);
    
        $this->trigger(self::EVENT_BEFORE_RESEND, $event);
    
        $this->performAjaxValidation($model);
    
        if ($model->load(Yii::$app->request->post()) && $model->resend()) {
    
            $this->trigger(self::EVENT_AFTER_RESEND, $event);
    
            return $this->render('/loginEmail', [
                'title'  => Yii::t('user', 'A new confirmation link has been sent'),
                'module' => $this->module,
                "email"=>$model->email,
                "emailFacilitator"=>Util::getEmailLoginUrl($model->email)
            ]);
        }
    
        return $this->render('resend', [
            'model' => $model,
        ]);
    }
}

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

use dektrium\user\models\RecoveryForm;

use Yii;

use yii\web\NotFoundHttpException;
use hass\base\helpers\Util;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */

class RecoveryController extends \dektrium\user\controllers\RecoveryController
{
    /**
     * Shows page where user can request password recovery.
     *
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRequest()
    {
        if (!$this->module->enablePasswordRecovery) {
            throw new NotFoundHttpException();
        }
    
        /** @var RecoveryForm $model */
        $model = Yii::createObject([
            'class'    => RecoveryForm::className(),
            'scenario' => 'request',
        ]);
        $event = $this->getFormEvent($model);
    
        $this->performAjaxValidation($model);
        $this->trigger(self::EVENT_BEFORE_REQUEST, $event);
    
        if ($model->load(Yii::$app->request->post()) && $model->sendRecoveryMessage()) {
            $this->trigger(self::EVENT_AFTER_REQUEST, $event);
            return $this->render('/loginEmail', [
                'title'  => Yii::t('user', 'Recovery message sent'),
                'module' => $this->module,
                "email"=>$model->email,
                "emailFacilitator"=>Util::getEmailLoginUrl($model->email)
            ]);
        }
    
        return $this->render('request', [
            'model' => $model,
        ]);
    }
    

    
}

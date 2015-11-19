<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\install\controllers;

use yii\web\Controller;
use hass\backend\traits\BaseControllerTrait;
use hass\install\helpers\EnvCheck;
use hass\install\models\DatabaseForm;
use Yii;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends Controller
{
    use BaseControllerTrait;
    
    
    public function init(){
        parent::init();
        
        Yii::$app->getRequest()->enableCookieValidation = false;
    }

    /**
     * Lists all Menu models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLanguage()
    {
        return $this->render('index');
    }

    public function actionLicenseAgreement()
    {
        if (\Yii::$app->getRequest()->isPost) {
            
            if (\Yii::$app->getRequest()->post("license") == "on") {
                return $this->renderJsonMessage(true);
            } else {
                return $this->renderJsonMessage(false, "同意安装协议才能继续安装!");
            }
        }
        
        return $this->render('license');
    }

    public function actionCheckEnv()
    {
        $check = new EnvCheck();
        
        // Render template
        return $this->render('checkenv', [
            "data" => $check->getResult()
        ]);
    }

    public function actionSelectDb()
    {
        return $this->render('index');
    }

    public function actionSetDb()
    {
        $model = new DatabaseForm();
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->validate() && $model->save()) {
                return $this->renderJsonMessage(true);
            } else {
                return $this->renderJsonMessage(false, $model->formatErrors());
            }
        }
        
        return $this->render('setdb', [
            "model" => $model
        ]);
    }

    public function actionSetEnv()
    {
        return $this->render('index');
    }

    public function actionSetAdmin()
    {
        // 设置前台和后台的cookie验证
        // 设置数据库的地址
        return $this->render('index');
    }
}

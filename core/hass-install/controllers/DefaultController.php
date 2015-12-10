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
use hass\base\traits\BaseControllerTrait;
use hass\install\helpers\EnvCheck;
use hass\install\models\DatabaseForm;
use Yii;
use hass\install\models\SiteForm;
use hass\install\models\AdminForm;
use hass\install\Module;
use hass\config\models\Config;
use hass\user\models\User;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends Controller
{
    use BaseControllerTrait;

    public function init()
    {
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
        
        $model->loadDefaultValues();
        
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

    public function actionSetSite()
    {
        $model = new SiteForm();
        
        $model->loadDefaultValues();
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->validate() && $model->save()) {
                return $this->renderJsonMessage(true);
            } else {
                return $this->renderJsonMessage(false, $model->formatErrors());
            }
        }
        
        return $this->render('setsite', [
            "model" => $model
        ]);
    }

    public function actionSetAdmin()
    {
        $model = new AdminForm();
        
        $model->loadDefaultValues();
        
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->validate() && $model->save()&&$this->install($model)) {
                return $this->renderJsonMessage(true);
            } else {
                return $this->renderJsonMessage(false, $model->formatErrors());
            }
        }
        
        return $this->render('setadmin', [
            "model" => $model
        ]);
    }

    public function install($model)
    {
        $class = "m151209_185057_migration";
        require Yii::getAlias("@hass/install/migrations/" . $class . ".php");


        $migration = new $class();

  
        try {
            //yii2 迁移是在命令行下操作的。。会输出很多垃圾信息
            ob_start();
            if ($migration->up() == false) {
                ob_end_clean();
                $model->addError("username","数据库迁移失败");
                return false;
            }
        } catch (\Exception $e) {
             ob_end_clean();
             $model->addError("username","数据表已经存在，或者其他错误！");
             return false;
        }
        ob_end_clean();

        $data = \Yii::$app->getCache()->get("install-site-form");
        
        foreach ($data as $name => $value) {
            $config = new Config();
            
            $config->name = preg_replace_callback('/([a-z]*)([A-Z].*)/', function ($matches) {
                return $matches[1] . "." . strtolower($matches[2]);
            }, $name);
            $config->value = $value;
            $config->save();
        }
        
        $data = \Yii::$app->getCache()->get("install-admin-form");
        
        $user = new User();
        $user->setScenario("create");
        $user->email = $data['email'];
        $user->username = $data['username'];
        $user->password = $data['password'];
        
        $user->create();
        
        $connection = \Yii::$app->getDb();
        $connection->createCommand()
            ->insert('{{%auth_assignment}}', [
            'item_name' => 'admin',
            'user_id' => $user->id,
            "created_at" => time()
        ])
            ->execute();
        
        Module::getInstance()->setCookieValidationKey();
        Module::getInstance()->setInstalled();
        \Yii::$app->getCache()->flush();
        return true;
    }

}

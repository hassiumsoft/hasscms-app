<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\module\controllers;

use hass\base\BaseController;
use yii\data\ArrayDataProvider;
use hass\base\enums\BooleanEnum;
use hass\module\BaseModule;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends BaseController
{

    /**
     * Lists all Module models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $packages = $moduleManager->findNoCoreModules();
        $dataProvider = new ArrayDataProvider([
            "allModels" => $packages,
            "key" => function ($model) {
                return $model->package;
            }
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 切换插件
     *
     * @param unknown $id            
     * @param unknown $value            
     */
    public function actionSwitcher($id, $value)
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $module = $moduleManager->findModule($id);
        if ($module != null) {
            if ($moduleManager->enabled($module, $value) == true) {
                return $this->renderJsonMessage(true, \Yii::t("hass", "更新成功"));
            } else {
                return $this->renderJsonMessage(false, \Yii::t("hass", "更新失败"));
            }
        }
    }

    /**
     * 删除插件
     *
     * @param unknown $id            
     */
    public function actionDelete($id)
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $module = $moduleManager->findModule($id);
        if ($module != null) {
            if ($moduleManager->delete($module) == true) {
                $this->flash("success", "删除模块成功");
            } else {
                $this->flash("error", "删除模块失败");
            }
        }
        
        return $this->redirect([
            "index"
        ]);
    }

    /**
     * 安装插件
     *
     * @param unknown $id            
     */
    public function actionInstall($id)
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $module = $moduleManager->findModule($id);
        if ($module != null) {
            if ($moduleManager->install($module) == true) {
                $this->flash("success", "安装成功");
            } else {
                $this->flash("error", "安装失败");
            }
        }
        return $this->redirect([
            "index"
        ]);
    }

    /**
     * 卸载插件
     *
     * @param unknown $id            
     */
    public function actionUninstall($id)
    {
        /** @var \hass\module\components\ModuleManager $moduleManager */
        $moduleManager = \Yii::$app->get("moduleManager");
        $module = $moduleManager->findModule($id);
        if ($module != null) {
            if ($moduleManager->uninstall($module) == true) {
                $this->flash("success", "卸载成功");
            } else {
                $this->flash("error", "卸载失败");
            }
        }
        
        return $this->redirect([
            "index"
        ]);
    }
}

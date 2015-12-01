<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\theme\controllers;

use Yii;
use hass\base\BaseController;
use yii\web\UploadedFile;
use hass\theme\models\ThemezipForm;
use Distill\Distill;
use yii\helpers\FileHelper;
use yii\data\ArrayDataProvider;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends BaseController
{

    public function actions()
    {
        return [
            "custom" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\theme\models\CustomForm',
                "template" => "custom-css"
            ]
        ];
    }

    /**
     * Lists all Module models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $packages = \Yii::$app->get("themeManager")->findAll();
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

    public function actionEnabled($id)
    {
        /** @var \hass\theme\components\ThemeManager $themeManager */
        $themeManager = \Yii::$app->get("themeManager");
        $theme = $themeManager->findTheme($id);
        if ($theme != null) {
            if ($themeManager->setDefaultTheme($theme) == true) {
                $this->flash("success", "设置主题成功,当前主题为" . $id);
            } else {
                $this->flash("error", "设置主题失败");
            }
        }
        
        return $this->redirect([
            "index"
        ]);
    }

    public function actionView($id)
    {
        $theme = \Yii::$app->get("themeManager")->findOne($id);
        return $this->render("view", [
            "model" => $theme
        ]);
    }



    public function actionDelete($id)
    {
        /** @var \hass\theme\components\ThemeManager $themeManager */
        $themeManager = \Yii::$app->get("themeManager");
        $theme = $themeManager->findTheme($id);
        
        if ($theme != null) {
            if ($themeManager->delete($theme) == true) {
                $this->flash("success", "删除主题成功");
            } else {
                $this->flash("error", "删除主题失败");
            }
        }
        return $this->redirect([
            "index"
        ]);
    }
    
    
    public function actionDemo($id)
    {
        $url = Yii::$app->get("appUrlManager")->createUrl([
            "",
            "theme" => $id
        ]);
        return $this->redirect($url);
    }

    /**
     * Lists all Module models.
     *
     * @return mixed
     */
    public function actionUpload()
    {
        $model = new ThemezipForm();
        
        if (\Yii::$app->getRequest()->getIsPost() == true && ($uploaded = UploadedFile::getInstance($model, "themezip")) != null) {
            
            $distill = new Distill();
            
            $extractFileName = dirname($uploaded->tempName) . DIRECTORY_SEPARATOR . $uploaded->name;
            
            if (move_uploaded_file($uploaded->tempName, $extractFileName) == true) {
                $target = dirname($uploaded->tempName) . DIRECTORY_SEPARATOR . md5($extractFileName . time());
                mkdir($target);
                
                if ($distill->extract($extractFileName, $target)) {
                    $newTheme = \Yii::$app->get("themeManager")->findByPath($target.DIRECTORY_SEPARATOR.$uploaded->getBaseName());
                    
                    if (count($newTheme) === 1) {
                        $theme = \Yii::$app->get("themeManager")->findOne($newTheme->getPackage());
                        if ($theme == null) {
                            $themePath = Yii::getAlias(\Yii::$app->get("themeManager")->getThemePath());
                            if ($distill->extract($extractFileName, $themePath)) {
                                $this->flash("success", "上传主题文件成功");
                            }
                        } else {
                            $this->flash("error", "主题路径已经存在该主题ID");
                        }
                    } else {
                        $this->flash("error", "上传主题配置文件不存在或者上传主题有错误");
                    }
                } else {
                    $this->flash("error", "解压文件失败");
                }
            } else {
                $this->flash("error", "移动文件失败,请确定你的临时目录是可写的");
            }
            
            if (file_exists($uploaded->tempName)) {
                unlink($uploaded->tempName);
            }
            
            if (file_exists($extractFileName)) {
                unlink($extractFileName);
            }
            
            FileHelper::removeDirectory($target);
            return $this->refresh();
        }
        
        return $this->render('upload', [
            "model" => $model
        ]);
    }
}

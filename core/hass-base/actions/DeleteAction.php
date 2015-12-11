<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\actions;

use yii\web\NotFoundHttpException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class DeleteAction extends \yii\base\Action
{

    public $modelClass;

    public function run($id)
    {
        if (($model = $this->findModel($id)) != null && $model->delete()) {
            
            if (\Yii::$app->getRequest()->getIsAjax() == true) {
                return $this->controller->renderJsonMessage(true, \Yii::t("hass", "删除成功"));
            } else {
                $this->controller->flash("success", "删除成功");
                return $this->controller->redirect([
                    "index"
                ]);
            }
        } else {
            $error = $model->formatErrors();
            if (\Yii::$app->getRequest()->getIsAjax() == true) {
                return $this->controller->renderJsonMessage(false, $error);
            }
        }
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\grid\actions;
use yii\web\NotFoundHttpException;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class NestedSetsDeleteAction extends \yii\base\Action
{

    public $modelClass;

    public function run($id)
    {
        if(($model = $this->findModel($id))!=null){
            $children = $model->children()->all();
            $model->deleteWithChildren();
            foreach ($children as $child) {
                $child->afterDelete();
            }
        }

        if(count($model->errors) >0)
        {
            $error = $model->formatErrors();
            $this->controller->flash("error",\Yii::t("hass", $error));
        }
        else
        {
            $this->controller->flash("success",\Yii::t("hass", "删除成功"));
        }

        return $this->controller->goReferrer();
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
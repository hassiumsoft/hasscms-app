<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\grid\actions;

use Yii;
use yii\web\NotFoundHttpException;

/**
* 使用在控制器中,添加方法
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class SwitcherAction extends \yii\base\Action
{
    public $modelClass;

    public function run($id, $attribute,$value)
    {
        if(($model = $this->findModel($id))!=null){
            $model->setAttribute($attribute,intval($value));
            $model->update();
        }

        if(count($model->errors) >0)
        {
            $error = $model->formatErrors();
            return $this->controller->renderJsonMessage(false,$error);
        }
        else
        {
            return $this->controller->renderJsonMessage(true,\Yii::t("hass", "更新成功"));
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
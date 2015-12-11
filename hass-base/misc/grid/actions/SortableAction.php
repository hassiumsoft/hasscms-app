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
use hass\base\enums\DirectionEnum;


/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class SortableAction extends \yii\base\Action
{
    /* @var $model yii\db\ActiveRecord */
    public $modelClass;

    public $attribute = "weight";

    public $direction;

    public $condition = [];

    public function run($id)
    {


        if(($model = $this->findModel($id)) != null){
            if($this->direction === DirectionEnum::DIRECTION_UP){
                $eq = '>';
                $orderDir = 'ASC';
            } elseif($this->direction === DirectionEnum::DIRECTION_DOWN){
                $eq = '<';
                $orderDir = 'DESC';
            }

            $modelClass = $this->modelClass;
            $query = $modelClass::find()->orderBy($this->attribute." ".$orderDir)->limit(1);

            $where = [$eq, $this->attribute, $model->getAttribute($this->attribute)];
            if(count($this->condition)){
                $where = ['and', $where];
                foreach($this->condition as $key => $value){
                    $where[] = [$key => $value];
                }
            }
            $modelSwap = $query->where($where)->one();

            if(!empty($modelSwap))
            {
                $newOrderNum = $modelSwap->getAttribute($this->attribute);

                $modelSwap->setAttribute($this->attribute,$model->getAttribute($this->attribute));
                $modelSwap->update();

                $model->setAttribute($this->attribute,$newOrderNum);
                $model->update();
            }
        }

        if(count($model->errors) >0)
        {
            $error = $model->formatErrors();
            return $this->controller->renderJsonMessage(false,$error);
        }
        else
        {

            if($modelSwap)
            {
                return $this->controller->renderJsonMessage(true,\Yii::t("hass", "排序成功"),['swap_id' => $modelSwap->primaryKey]);
            }
            else
            {
                return $this->controller->renderJsonMessage(true,\Yii::t("hass", "排序成功 已是最边缘"));
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
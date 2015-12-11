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
 *
 */
class NestedSetsSortableAction extends \yii\base\Action
{

    /* @var $model yii\db\ActiveRecord */
    public $modelClass;

    public $attribute = "weight";

    public $direction;

    public $condition = [];

    public function run($id)
    {
        if (($model = $this->findModel($id)) != null) {
            if ($this->direction === DirectionEnum::DIRECTION_UP) {
                $eq = '<';
                $orderDir = SORT_DESC;
            } elseif ($this->direction === DirectionEnum::DIRECTION_DOWN) {
                $eq = '>';
                $orderDir = SORT_ASC;
            }

            $modelClass = $this->modelClass;

            $where = [
                'and',
                [
                    'tree' => $model->tree
                ],
                [
                    'depth' => $model->depth
                ],
                [
                    $eq,
                    'lft',
                    $model->lft
                ]
            ];

            $modelSwap = $modelClass::find()->where($where)
                ->orderBy([
                'lft' => $orderDir
            ])
                ->one();
            if ($modelSwap) {

                if ($this->direction === DirectionEnum::DIRECTION_UP) {
                    $model->insertBefore($modelSwap);
                } elseif ($this->direction === DirectionEnum::DIRECTION_DOWN) {

                    $model->insertAfter($modelSwap);
                }

                $modelSwap->update();
                $model->update();
            }
        }

        if (count($model->errors) > 0) {
            $error = $model->formatErrors();
            $this->controller->flash("error",\Yii::t("hass", $error));
        } else {
            if ($modelSwap) {
                $this->controller->flash("success",\Yii::t("hass", "排序成功"));
            } else {
                $this->controller->flash("success",\Yii::t("hass", "排序成功 已是最边缘"));
            }
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
<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\area\controllers;

use Yii;
use hass\base\BaseController;
use hass\area\models\Area;
use yii\web\NotFoundHttpException;
use hass\area\models\Block;
use hass\base\enums\BooleanEnum;

/**
 * DefaultController implements the CRUD actions for Area model.
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
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\area\models\Area'
            ],
            "create" => [
                "class" => '\hass\base\actions\CreateAction',
                'modelClass' => 'hass\area\models\Area'
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\area\models\Area'
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render("index", [
            "blocks" => Block::find()->where(["used"=>BooleanEnum::FLASE])->all(),
            "areas" => Area::find()->all()
        ]);
    }

    public function actionUpdateBlocks()
    {
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        if($model->save())
        {
            return $this->renderJsonMessage(true,"更新成功");
        }
        else
        {
            return $this->renderJsonMessage(true,"更新失败");
        }
    }

    public function actionUpdateBlocksDelete()
    {
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");

        $block = \Yii::$app->getRequest()->post("block");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        $block = Block::findOne($block);

        $block->used = BooleanEnum::FLASE;

        if($model->save() && $block->save())
        {
            return $this->renderJsonMessage(true,"更新成功");
        }
        else
        {
            return $this->renderJsonMessage(true,"更新失败");
        }
    }

    public function actionUpdateBlocksCreate()
    {
        $id = \Yii::$app->getRequest()->post("id");
        $blocks = \Yii::$app->getRequest()->post("blocks");

        $block = \Yii::$app->getRequest()->post("block");
        $model = $this->findModel($id);

        $model->blocks = $blocks;

        $block = Block::findOne($block);

        $block->used = BooleanEnum::TRUE;

         if($model->save() && $block->save())
        {
            return $this->renderJsonMessage(true,"更新成功");
        }
        else
        {
            return $this->renderJsonMessage(true,"更新失败");
        }
    }

    /**
     * Finds the Area model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Area the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Area::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

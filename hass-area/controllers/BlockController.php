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
use hass\area\Module;
use hass\area\models\Block;

use yii\web\NotFoundHttpException;
use hass\base\helpers\ArrayHelper;
use hass\area\helpers\AreaHelp;

/**
 * DefaultController implements the CRUD actions for Area model.
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class BlockController extends BaseController
{
    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\area\models\Block'
            ],
            "index" => [
                "class" => '\hass\base\actions\IndexAction',
                'modelClass' => 'hass\area\models\Block',
                "query"=>[
                    "orderBy"=>['block_id' => SORT_DESC]
                ],
                "filters"=>["%title"]
            ]
        ];
    }


    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type=null)
    {
        if($type == null)
        {
            $type = Module::DEFAULT_BLOCK_TYPE;
        }

        list($title,$model,$view,$widget) = AreaHelp::getBlockHook($type);

        $model = \Yii::createObject($model);
        $model->loadDefaultValues();
        $model->type = $type;
        $model->widget = $widget;
        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'created success'));
            } else {
                $this->flash('error', Yii::t('hass', 'created error. {0}', $model->formatErrors()));
            }
            return  $this->refresh();
        }

        return $this->render('create',["items"=> AreaHelp::getBlockNav($type),"title"=>$title,"view"=>$view,"model"=>$model]);
    }




    /**
     * Creates a new Area model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $base = $this->findModel($id);
        $type = $base->type;
        list($title,$model,$view) =  AreaHelp::getBlockHook($type);
        $model = \Yii::createObject(array_merge(ArrayHelper::toArray($base),["class"=>$model]));

        $model->setIsNewRecord(false);

        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'updated success'));
            } else {
                $this->flash('error', Yii::t('hass', 'updated error. {0}', $model->formatErrors()));
            }
            return  $this->refresh();
        }


        return $this->render('update',["items"=> AreaHelp::getBlockNav($type),"title"=>$title,"view"=>$view,"model"=>$model]);

    }


    protected function findModel($id)
    {
        if (($model = Block::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


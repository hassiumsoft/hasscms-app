<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\taxonomy\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use hass\base\BaseController;
use hass\taxonomy\models\Taxonomy;
use hass\base\enums\DirectionEnum;
use yii\data\ActiveDataProvider;
use hass\taxonomy\models\TaxonomySearch;

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
            "switcher" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsSwitcherAction',
                'modelClass' => 'hass\taxonomy\models\Taxonomy'
            ],
            "up" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsSortableAction',
                'modelClass' => 'hass\taxonomy\models\Taxonomy',
                'direction' => DirectionEnum::DIRECTION_UP
            ],
            "down" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsSortableAction',
                'modelClass' => 'hass\taxonomy\models\Taxonomy',
                'direction' => DirectionEnum::DIRECTION_DOWN
            ],
            "delete" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsDeleteAction',
                'modelClass' => 'hass\taxonomy\models\Taxonomy'
            ]
        ];
    }

    /**
     * Lists all Taxonomy models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Taxonomy();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {

            $parent = (int) Yii::$app->request->post('parent', null);
            if ($parent > 0 && ($parent = Taxonomy::findOne($parent))) {
                $model->appendTo($parent);
            } else {
                $model->makeRoot();
            }

            if ($model->hasErrors()) {
                $this->flash('error', Yii::t('hass', 'Create error. {0}', $model->formatErrors()));
            } else {
                $this->flash('success', Yii::t('hass', 'created success'));
            }
            return $this->refresh();
        }


        $searchModel = Yii::createObject([
            "class" => TaxonomySearch::className()
        ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel->search(["%name"])->sort(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            "searchModel"=>$searchModel
        ]);
    }

    /**
     * Lists all Taxonomy models.
     *
     * @return mixed
     */
    public function actionAddChild($id)
    {
        $model = new Taxonomy();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            $parent = (int) Yii::$app->request->post('parent', null);
            if ($parent > 0 && ($parentCategory = Taxonomy::findOne($parent))) {
                $model->appendTo($parentCategory);
            } else {
                $model->makeRoot();
            }

            if ($model->hasErrors()) {
                $this->flash('error', Yii::t('hass', 'create error. {0}', $model->formatErrors()));
                return $this->refresh();
            } else {
                $this->flash('success', Yii::t('hass', 'create success'));
                return $this->redirect([
                    'update',
                    'id' => $model->primaryKey
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'parentId' => $id
        ]);
    }

    /**
     * Updates an existing Taxonomy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {

            $parent = (int) Yii::$app->request->post('parent', null);
            if ($parent > 0 && ($parentCategory = Taxonomy::findOne($parent))) {
                $model->appendTo($parentCategory);
            } else {
                $model->save();
            }

            if (! $model->hasErrors()) {
                $this->flash('success', Yii::t('hass', 'update success'));
            } else {
                $this->flash('error', Yii::t('hass', 'update error. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }

        $parent = $model->parents(1)->one();

        return $this->render('update', [
            'model' => $model,
            'parentId' => $parent ? $parent->primaryKey : null
        ]);
    }

    /**
     * Finds the Taxonomy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     * @return Taxonomy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Taxonomy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}

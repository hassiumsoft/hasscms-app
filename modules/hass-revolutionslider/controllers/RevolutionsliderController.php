<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\revolutionslider\controllers;
use Yii;
use hass\base\BaseController;
use hass\revolutionslider\models\Revolutionslider;
use hass\revolutionslider\models\CaptionForm;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class RevolutionsliderController extends BaseController
{

    public function behaviors()
    {
        return [
        ];
    }
    
    public function init()
    {
        parent::init();
    }

    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\module\actions\DeleteAction',
                'modelClass' => 'hass\revolutionslider\models\Revolutionslider'
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Revolutionslider::find(),
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        return $this->render("index", [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())) {

            $model->captions = Yii::$app->request->post("CaptionForm");

            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'update success'));
            } else {
                $this->flash('error', Yii::t('hass', 'update error. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }

        return $this->render("update", [
            'model' => $model
        ]);
    }

    public function actionCreate()
    {
        $model = new Revolutionslider();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            $model->captions = Yii::$app->request->post("CaptionForm");
            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'create success'));
                return $this->redirect([
                    'update',
                    "id" => $model->primaryKey
                ]);
            } else {
                $this->flash('error', Yii::t('hass', 'create error. {0}', $model->formatErrors()));
                return $this->refresh();
            }
        }

        return $this->render("create", [
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Revolutionslider::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAddcaption()
    {
       $index = \Yii::$app->getRequest()->post("index");
       $content =  $this->renderAjax("_caption",["model"=>new CaptionForm(),"index"=>$index]);
        return $this->renderJsonMessage(true,$content);
    }

    public function getViewPath()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $this->id;
    }
}
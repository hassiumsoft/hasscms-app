<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\i18n\controllers;

use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use hass\i18n\models\SourceMessageSearch;
use hass\i18n\models\SourceMessage;
use hass\i18n\Module;
use hass\base\BaseController;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends BaseController
{

    public function actionIndex()
    {
        $searchModel = new SourceMessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()
            ->get());
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     *
     * @param integer $id            
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        /** @var SourceMessage $model */
        $model = $this->findModel($id);
        $model->initMessages();
        
        if (Model::loadMultiple($model->messages, Yii::$app->getRequest()->post())) {
            
            if (Model::validateMultiple($model->messages) && $model->saveMessages()) {
                if (\Yii::$app->getRequest()->isAjax) {
                    return $this->renderJsonMessage(true, "修改成功");
                }
                
                $this->flash('success', Module::t('修改成功'));
            } 

            else {
                if (\Yii::$app->getRequest()->isAjax) {
                    return $this->renderJsonMessage(true, "修改失败");
                }
                $this->flash("error", "修改失败");
            }
            
            return $this->refresh();
        }
        
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     *
     * @param array|integer $id            
     * @return SourceMessage|SourceMessage[]
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $query = SourceMessage::find()->where('id = :id', [
            ':id' => $id
        ]);
        $models = is_array($id) ? $query->all() : $query->one();
        if (! empty($models)) {
            return $models;
        } else {
            throw new NotFoundHttpException(Module::t('The requested page does not exist'));
        }
    }
}

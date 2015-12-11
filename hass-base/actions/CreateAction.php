<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace  hass\base\actions;
use \Yii;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
class CreateAction extends \yii\base\Action
{

    public $modelClass;

    public $template;

    public function run()
    {
        $model =  \Yii::createObject(["class"=>$this->modelClass]);

        $this->controller->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                 $this->controller->flash('success', Yii::t('hass', 'create success'));
                return $this->controller->redirect(['update',"id"=>$model->primaryKey]);
            } else {
                 $this->controller->flash('error', Yii::t('hass', 'create error. {0}', $model->formatErrors()));
                 return  $this->controller->refresh();
            }

        }

        return  $this->controller->render($this->getTemplate(), [
            'model' => $model
        ]);
    }

    public function getTemplate()
    {
        if($this->template !=null)
        {
            return $this->template;
        }

       return $this->id;
    }
}
<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\system\controllers;


/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class DefaultController extends \hass\backend\BaseController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => '\yii\web\ErrorAction'
            ]
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == "index"&&\Yii::$app->hasModule("install") && \Yii::$app->getModule("install")->getIsInstalled() == false) {
            \Yii::$app->getModule("install")->goInstall();
            return false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionControlpanel()
    {
        return $this->render('controlpanel');
    }
}
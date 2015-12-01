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
class DefaultController extends \hass\base\BaseController
{

    public function actions()
    {
        return [
            'error' => [
                'class' => '\yii\web\ErrorAction'
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('controlpanel');
    }
    
    public function actionControlpanel()
    {
        return $this->render('controlpanel');
    }
}
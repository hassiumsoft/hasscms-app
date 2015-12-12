<?php
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\gii\controllers;
use hass\rbac\components\AccessControl;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class DefaultController extends \yii\gii\controllers\DefaultController
{
    
    public function behaviors()
    {
        return [
            'rbac' => [
                'class' => AccessControl::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $this->layout = '@hass/backend/views/layouts/main.php';

        return $this->render('index');
    }
}

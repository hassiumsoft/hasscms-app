<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\user\controllers;

use yii\filters\VerbFilter;
use yii\helpers\Url;
use hass\base\traits\BaseControllerTrait;
use hass\rbac\components\AccessControl;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class AdminController extends \dektrium\user\controllers\AdminController
{
    
    use BaseControllerTrait;

    /**
     * @hass-todo 记住给其他模块也添加上verbs过滤
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'rbac' => [
                'class' => AccessControl::className()
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => [
                        'post'
                    ],
                    'confirm' => [
                        'post'
                    ],
                    'block' => [
                        'post'
                    ]
                ]
            ]
        ];
    }

    /**
     * If "dektrium/yii2-rbac" extension is installed, this page displays form
     * where user can assign multiple auth items to user.
     *
     * @param int $id            
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionAssignments($id)
    {
        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        
        return $this->render('_assignments', [
            'user' => $user
        ]);
    }
}
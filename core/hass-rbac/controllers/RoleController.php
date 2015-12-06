<?php
/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac\controllers;

use hass\base\BaseController;
use hass\rbac\models\AuthItem;
use Yii;
use yii\rbac\Item;
use yii\data\ArrayDataProvider;
use hass\base\classes\Hook;
use hass\rbac\Module;
use hass\base\helpers\ArrayHelper;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class RoleController extends BaseController
{
    public function actions()
    {
        return [
            "delete" => [
                "class" => '\hass\base\actions\DeleteAction',
                'modelClass' => 'hass\rbac\models\AuthItem'
            ],
            "update" => [
                "class" => '\hass\base\actions\UpdateAction',
                'modelClass' => 'hass\rbac\models\AuthItem'
            ]
        ];
    }
    
    
    public function actionIndex()
    {
        $manager = Yii::$app->getAuthManager();
        
        $items = $manager->getRoles();
        $model = new AuthItem();
        
        $this->performAjaxValidation($model);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->type = Item::TYPE_ROLE;
            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'created success'));
            } else {
                $this->flash('error', Yii::t('hass', 'Create error. {0}', $model->formatErrors()));
            }
            
            return $this->refresh();
        }
        
        return $this->render("index", [
            "dataProvider" => new ArrayDataProvider([
                "allModels" => $items
            ]),
            "model" => $model
        ]);
    }
    
    /**
     * 1.获取所有模块配置的权限(前台模块...怎么办?)
     */
    public function actionPermissions($id)
    {
        $authManager = \Yii::$app->getAuthManager();
        
        if (\Yii::$app->getRequest()->getIsPost())
        {
            $oldPermissions = ArrayHelper::getColumn($authManager->getChildren($id), "name");
            
            $postPermissions = array_keys(\Yii::$app->getRequest()->post("permissions",[]));
  
            $newChildren = array_diff($postPermissions, $oldPermissions);
            $delChildren = array_diff($oldPermissions,$postPermissions);

            $parent = $authManager->getRole($id);
            
            //@hass-todo 这里最好是用sql使用批量删除和添加..但是为了兼容phpmanager
            
            foreach ($delChildren  as $name)
            {
                $authManager->removeChild($parent, $authManager->createPermission($name));
            }
            
            foreach ($newChildren  as $name)
            {
                $authManager->addChild($parent, $authManager->createPermission($name));
            }
            return $this->refresh();
        }
        $permissions = Hook::trigger(Module::EVENT_RBAC_PERMISSION)->parameters;
        
        
        return $this->render("permissions",["permissions"=>$permissions,"children"=>$authManager->getChildren($id)]);
    }
}
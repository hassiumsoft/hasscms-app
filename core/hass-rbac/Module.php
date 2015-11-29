<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\rbac;

use yii\base\BootstrapInterface;
use hass\helpers\Hook;

use hass\system\enums\ModuleGroupEnmu;

/**
 *
 * @package hass\rbac
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class Module extends \mdm\admin\Module implements BootstrapInterface
{

    public $controllerMap = [
        'assignment' => '\mdm\admin\controllers\AssignmentController',
        'default' => '\mdm\admin\controllers\DefaultController',
        'menu' => '\mdm\admin\controllers\MenuController',
        'permission' => '\mdm\admin\controllers\PermissionController',
        'role' => '\mdm\admin\controllers\RoleController',
        'route' => '\mdm\admin\controllers\RouteController',
        'rule' => '\mdm\admin\controllers\RuleController'
    ];

    public function init()
    {
        parent::init();
        
        $this->layout = \Yii::$app->layout;
        
        $component = \Yii::$app->get("authManager", false);
        if ($component == null) {
            \Yii::$app->set("authManager", [
                'class' => 'yii\rbac\DbManager',
                'defaultRoles' => [
                    "guest"
                ]
            ]);
        }

        $view = \Yii::$app->getView();

        if ($view->theme == null) {
            $theme['class'] = 'yii\base\Theme';
            $view->theme = \Yii::createObject($theme);
        }

        if ($view->theme->pathMap == null) {
            $view->theme->pathMap = [];
        }

        $view->theme->pathMap = array_merge($view->theme->pathMap, [
            "@hass/rbac/views" => [
                "@hass/rbac/views",
                "@mdm/admin/views"
            ]
        ]);
    }

    public function bootstrap($backend)
    {
        \Yii::$app->attachBehavior("access", [
            'class' => 'mdm\admin\classes\AccessControl',
            'allowActions' => [
                '*'
            ]
        ]);

        parent::bootstrap(\Yii::$app);

        Hook::on(\hass\system\Module::EVENT_SYSTEM_GROUPNAV, [
            $this,
            "onSetGroupNav"
        ]);
    }

    /**
     *
     * @param \hass\helpers\Event $event
     */
    public function onSetGroupNav($event)
    {
        $event->parameters->set(ModuleGroupEnmu::PEOPLE,[ [
            'label' => "RBAC",
            'icon' => "fa-users",
            'url' => [
                "/rbac/default/index"
            ]
        ]]);
    }
}
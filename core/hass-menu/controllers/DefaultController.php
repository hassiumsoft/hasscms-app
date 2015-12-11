<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\menu\controllers;

use hass\base\classes\Tree;
use Yii;
use hass\menu\models\Menu;
use yii\web\NotFoundHttpException;
use hass\base\classes\Hook;
use yii\web\HttpException;
use hass\base\helpers\NestedSetsTree;
use hass\base\BaseController;
use hass\menu\models\MenuSearch;
use yii\data\ActiveDataProvider;

use hass\base\enums\StatusEnum;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */


/**
 * DefaultController implements the CRUD actions for Menu model.
 */
class DefaultController extends BaseController
{

    public function actions()
    {
        return [
            "switcher" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsSwitcherAction',
                'modelClass' => 'hass\menu\models\Menu'
            ],
            "delete" => [
                "class" => '\hass\base\misc\grid\actions\NestedSetsDeleteAction',
                'modelClass' => 'hass\menu\models\Menu'
            ]
        ];
    }

    /**
     * Lists all Menu models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Menu();

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->makeRoot()) {
                $this->flash('success', Yii::t('hass', 'created success'));
            } else {
                $this->flash('error', Yii::t('hass', 'Create error. {0}', $model->formatErrors()));
            }
            return $this->refresh();
        }

        $searchModel = Yii::createObject([
            "class" => MenuSearch::className()
        ]);

        /**
         * 首页只获取深度为0的顶级菜单
         * @var $dataProvider
         */
        $dataProvider = new ActiveDataProvider([
            'query' => $searchModel->search(["%name"])->where("depth=0")->sort(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            "searchModel" => $searchModel
        ]);
    }

    /**
     * 更新root菜单.只要保存就可以了
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $this->flash('success', Yii::t('hass', 'update success'));
            } else {
                $this->flash('error', Yii::t('hass', 'update error. {0}', $model->formatErrors()));
            }
            return $this->redirect(["update", "id" => $model->slug]);
        }

        return $this->render('update', [
            'model' => $model
        ]);

    }

    /**
     * Displays a single Menu model.
     *
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $menuModuleId = $this->module->id;
        $parameters = Hook::trigger(\hass\menu\Module::EVENT_MENU_MODULE_LINKS)->parameters;
        $linkModuleName = $parameters[$menuModuleId]["name"];
        unset($parameters[$menuModuleId]);

        $linkForm = new \hass\menu\models\LinkForm();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'linkForm' => $linkForm,
            'moduleLinks' => $parameters,
            "linkModuleName" => $linkModuleName
        ]);
    }


    /**
     * 根据rootid返回所有子链接
     * @param unknown $id
     */
    public function actionViewLinks($id)
    {
        $countries = Menu::findOne($id);

        $collection = $countries->children()
            ->asArray()
            ->all();

        $controller = $this;
        $trees = NestedSetsTree::generateTree($collection, function ($item) use ($controller) {
            //根据模块ID 获取模型
            if ($item['module'] == $controller->module->id) {
                $item['islink'] = true;
            }
            $node = $controller->ensureNode($item, $item['module']);
            return $node;
        });


        if (\Yii::$app->getRequest()->getIsAjax() == true) {
            return $this->renderJsonMessage(true, $trees);
        }
    }


    /**
     * 添加模块的链接到菜单里
     * @throws HttpException
     */
    public function actionCreateLinksFromModule()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException("这里只允许ajax");
        }
        $items = Yii::$app->request->post("menu-item", null);
        $module = Yii::$app->request->post("module");
        if (!$items) {
            return;
        }
        $nodes = [];
        foreach ($items as $item) {
            $item = $this->ensureNode($item, $module);
            $item['id'] = $item['original'];
            $nodes[] = $item;
        }


        $tree = new Tree($nodes);
        $nodes = [];
        foreach ($tree->getRootNodes() as $node) {

            $nodes[] = $node->toArray();
        }

        return $this->renderJsonMessage(true, $nodes);
    }


    /**
     * 添加链接到菜单
     * @throws HttpException
     */
    public function actionCreateLink()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException("这里只允许ajax");
        }

        $model = new \hass\menu\models\LinkForm();
        $model->load(Yii::$app->request->post());
        if ($model->validate()) {
            $item = [];
            $item['name'] = $model->name;
            $item['original'] = $model->url;
            $menu = $this->ensureNode($item, $this->module->id);
            $menu['islink'] = true;
            return $this->renderJsonMessage(true, [$menu]);
        }
        return $this->renderJsonMessage(false, array_values($model->errors)[0][0]);
    }

    /**
     * 将菜单保存到数据库
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax) {
            throw new HttpException("这里只允许ajax");
        }

        $items = Yii::$app->request->post("menu-item", null);
        $rootId = Yii::$app->request->post("menu-root", null);

        $root = $this->findModel($rootId);
        $root->deleteChildren();

        if ($items != null) {
            foreach ($items as &$item) {
                if ($item['name'] == $item['originalName'] && $item['module'] != $this->module->id) {
                    $item['name'] = "";
                }
                $item['tree'] = $root['tree'];
                $item['status'] = StatusEnum::STATUS_ON;
            }
            $root->batchInsertMenu($items);
        }

        return $this->renderJsonMessage(true, $items);
    }

    /**
     *
     * @param unknown $item
     * @param unknown $module
     */
    protected function ensureNode($item, $module)
    {
        $createCallbacks = Hook::trigger(\hass\menu\Module::EVENT_MENU_LINK_CREATE)->parameters;

        list($name, $url) = call_user_func($createCallbacks[$module], $item['name'], $item['original']);

        $parameters = Hook::trigger(\hass\menu\Module::EVENT_MENU_MODULE_LINKS)->parameters;
        $item["name"] = $name;
        $item['originalName'] = $item["name"];
        $item['title'] = "";
        $item["module"] = $module;
        $item["children"] = [];
        $item["url"] = $this->createUrl($url);
        $item["moduleName"] = $parameters[$module]["name"];
        return $item;
    }

    /**
     * url::to()使用了appUrlManager创建前台url
     * @param unknown $url
     * @param string $scheme
     */
    public function createUrl($url, $scheme = false)
    {
        if (is_array($url)) {
            return \Yii::$app->get("appUrlManager")->createAbsoluteUrl($url, is_string($scheme) ? $scheme : null);
        }

        $url = Yii::getAlias($url);
        if ($url === '') {
            $url = Yii::$app->getRequest()->getUrl();
        }

        if (($pos = strpos($url, ':')) === false || !ctype_alpha(substr($url, 0, $pos))) {
            // turn relative URL into absolute
            $url = \Yii::$app->get("appUrlManager")->getHostInfo() . '/' . ltrim($url, '/');
        }

        return $url;
    }


    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

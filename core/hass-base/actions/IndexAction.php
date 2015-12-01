<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\base\actions;

use \Yii;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
class IndexAction extends \yii\base\Action
{
    public $template;
    public $modelClass;

    public $searchModelClass;

    /**
     * 是个数组类似
     * [
     * "where" => " `id` = 5"
     * ]
     *
     * @var array
     */
    public $query = [];

    /**
     *
     * @var \yii\data\Sort
     */
    public $sort = [];

    /**
     * 如果是字符窜使用%
     *
     * @var array
     */
    public $filters = [];

    public $pageSize = 10;

    public function __construct($id, $controller, $config = [])
    {
        parent::__construct($id, $controller, $config);

        if (is_array($this->sort) && ! isset($this->sort["class"])) {
            $this->sort["class"] = Sort::className();
            $this->sort = \Yii::createObject($this->sort);
        }

        if ($this->sort == null) {
            $this->sort = \Yii::createObject(Sort::className());
        }

        if($this->searchModelClass == null && class_exists($this->modelClass."Search"))
        {
            $this->searchModelClass = $this->modelClass."Search";
        }
    }

    public function run()
    {
        $model = Yii::createObject([
            "class" => $this->modelClass
        ]);
        $this->controller->performAjaxValidation($model);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $this->controller->flash('success', Yii::t('hass', ' created success'));
            } else {
                $this->controller->flash('error', Yii::t('hass', 'Create error. {0}', $model->formatErrors()));
            }

            return $this->controller->refresh();
        }

        $searchModel = Yii::createObject([
            "class" => $this->searchModelClass
        ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getQuery($searchModel),
            'pagination' => [
                'pageSize' => $this->pageSize
            ]
        ]);

        return $this->controller->render($this->getTemplate(), [
            'model' => $model,
            'searchModel'=>$searchModel,
            'dataProvider' => $dataProvider,
            'sort' => $this->sort
        ]);
    }

    /**
     *
     * @param \yii\db\ActiveRecord $model
     */
    public function getQuery($model)
    {
        $query = $model->search($this->filters);

        foreach ($this->query as $key => $value) {
            call_user_func([
                $query,
                $key
            ], $value);
        }

        /**
         * sort过滤
         */
        $query->addOrderBy($this->sort->orders);

        return $query;
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
<?php

/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\search\actions;

use yii\base\Action;
use \Yii;
use yii\data\ArrayDataProvider;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *       
 */
class SearchAction extends Action
{

    public $template;

    public $pageSize = 15;

    public function run($q)
    {
        $search = Yii::$app->search;
        $searchData = $search->search($q);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $searchData,
            'pagination' => [
                "pageSize"=>$this->pageSize
            ]
        ]);

        return $this->controller->render($this->getTemplate(), [
            'models' => $dataProvider->getModels(),
            'pagination' => $dataProvider->getPagination()
        ]);
    }

    public function getTemplate()
    {
        if ($this->template != null) {
            return $this->template;
        }
        return $this->id;
    }
}
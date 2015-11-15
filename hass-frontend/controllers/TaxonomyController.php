<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\frontend\controllers;

use hass\frontend\BaseController;
use hass\helpers\ArrayHelper;
use hass\taxonomy\models\Taxonomy;
use hass\taxonomy\models\TaxonomyIndex;
use yii\data\ActiveDataProvider;
use hass\frontend\models\Post;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 1.0
 */
class TaxonomyController extends BaseController
{

    public function actionList()
    {
        $query = Post::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->from("post"),
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionRead($id)
    {
        $taxonomy = Taxonomy::findOne($id);
        $children = $taxonomy->children()->all();
        $ids =  ArrayHelper::getColumn($children,"taxonomy_id");
        array_unshift($ids,$id);
        $dataProvider = new ActiveDataProvider([
            'query' => TaxonomyIndex::find()->select(['entity', 'entity_id'])->distinct()->where(["taxonomy_id"=>$ids])->orderBy(['taxonomy_index_id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);
        return $this->render('view', ['dataProvider' => $dataProvider, "model" => $taxonomy]);
    }

}

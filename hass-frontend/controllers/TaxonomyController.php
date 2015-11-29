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
use hass\base\helpers\ArrayHelper;
use hass\taxonomy\models\TaxonomyIndex;
use yii\data\ActiveDataProvider;
use hass\frontend\models\Taxonomy;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class TaxonomyController extends BaseController
{


    public function actionRead($id)
    {
        $taxonomy = Taxonomy::findByIdOrSlug($id);
        $children = $taxonomy->children()->all();
        $ids = ArrayHelper::getColumn($children, "taxonomy_id");
        array_unshift($ids, $taxonomy->getPrimaryKey());
        $dataProvider = new ActiveDataProvider([
            'query' => TaxonomyIndex::find()->select([
                'entity',
                'entity_id'
            ])
                ->distinct()
                ->where([
                "taxonomy_id" => $ids
            ])
                ->orderBy([
                'taxonomy_index_id' => SORT_DESC
            ]),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);
        
        list($title,$desc,$keys) = $taxonomy->getMetaData();
        $this->getView()->setMetaData($title,$desc,$keys);
        
        return $this->render('view', [
            'taxonomyIndexs' => $dataProvider->getModels(),
            "pagination" => $dataProvider->getPagination(),
            "taxonomy" => $taxonomy
        ]);
    }
}

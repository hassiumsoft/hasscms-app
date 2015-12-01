<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\taxonomy\behaviors;

use hass\taxonomy\models\Taxonomy;
use yii\db\ActiveRecord;
use hass\taxonomy\models\TaxonomyIndex;
use yii\helpers\ArrayHelper;
use yii\base\Behavior;
use hass\base\helpers\NestedSetsTree;
use yii\base\InvalidConfigException;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class TaxonomyBehavior extends Behavior
{
    use \hass\base\traits\EntityRelevance;

    public static $formName = "taxonomytree";

    public $root;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete'
        ];
    }

    public function afterInsert()
    {
        $data = \Yii::$app->request->post($this->owner->formName());
        if (!isset($data[static::$formName]) || empty($data[static::$formName])) {
            return;
        }

        $indexs = [];
        $modelClass = $this->getEntityClass();

        foreach ($data[static::$formName] as $id) {
            $indexs[] = [
                $modelClass,
                $this->getEntityId(),
                $id
            ];
        }

        if (count($indexs)) {
            \Yii::$app->db->createCommand()
                ->batchInsert(TaxonomyIndex::tableName(), [
                    'entity',
                    'entity_id',
                    'taxonomy_id'
                ], $indexs)
                ->execute();
        }
    }

    public function afterUpdate()
    {
        if (!$this->owner->isNewRecord) {
            $this->beforeDelete();
        }
        $this->afterInsert();
    }

    /**
     * 文章删除后,只是删除关系
     *
     * @see \creocoder\nestedsets\NestedSetsBehavior::afterDelete()
     */
    public function beforeDelete()
    {
        TaxonomyIndex::deleteAll([
            'entity' => $this->getEntityClass(),
            'entity_id' => $this->getEntityId()
        ]);
    }

    /**
     * Get cached tree structure of category objects
     *
     * @return array
     */
    public function getTaxonomys()
    {
        return $this->owner->hasMany(Taxonomy::className(), [
            'taxonomy_id' => 'taxonomy_id'
        ])->via("taxonomyIndex");
    }

    public function getTaxonomyIndex()
    {
        return $this->owner->hasMany(TaxonomyIndex::className(), [
            'entity_id' => $this->owner->primaryKey()[0]
        ])
            ->where([
                "entity" => $this->getEntityClass()
            ]);
    }

    /**
     * Get cached tree structure of category objects
     *
     * @return array
     */
    public function getTaxonomytree()
    {


        if ($this->root != null) {
            $countries = Taxonomy::findOne([
                'slug' => $this->root
            ]);

            $collection = $countries->children()
                ->asArray()
                ->all();
        } else {
            $collection = Taxonomy::find()
                ->sort()
                ->asArray()
                ->all();
        }


        $indexs = TaxonomyIndex::find()->where([
            "entity_id" => $this->getEntityId(),
            "entity" => $this->getEntityClass()
        ])
            ->asArray()
            ->all();
        $indexs = ArrayHelper::getColumn($indexs, "taxonomy_id");

        $trees = NestedSetsTree::generateTree($collection, function ($item) use ($indexs) {
            $item["checked"] = false;

            if (in_array($item["taxonomy_id"], $indexs)) {
                $item["checked"] = true;
            }
            return $item;
        });

        return $trees;
    }
}

?>
<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\taxonomy\models;

use Yii;
use hass\meta\behaviors\MetaBehavior;
use yii\behaviors\SluggableBehavior;
use creocoder\nestedsets\NestedSetsBehavior;
use hass\base\enums\StatusEnum;

/**
 * This is the model class for table "{{%taxonomy}}".
 *
 * @property string $taxonomy_id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $weight
 * @property integer $status
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Taxonomy extends \hass\base\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%taxonomy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'tree',
                    'lft',
                    'rgt',
                    'depth',
                    'status'
                ],
                'integer'
            ],
            [
                [
                    'name',
                    'slug',
                    'description'
                ],
                'string',
                'max' => 128
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'taxonomy_id' => Yii::t('hass\taxonomy', 'Taxonomy ID'),
            'name' => Yii::t('hass\taxonomy', 'Name'),
            'slug' => Yii::t('hass\taxonomy', 'Slug'),
            'tree' => Yii::t('hass\taxonomy', 'Tree'),
            'description' => Yii::t('hass\taxonomy', '分类描述'),
            'lft' => Yii::t('hass\taxonomy', 'Lft'),
            'rgt' => Yii::t('hass\taxonomy', 'Rgt'),
            'depth' => Yii::t('hass\taxonomy', 'Depth'),
            'status' => Yii::t('hass\taxonomy', 'Status')
        ];
    }

    /**
     * @inheritdoc
     *
     * @return TaxonomyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TaxonomyQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            'metaBehavior' => MetaBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true,
                "immutable"=>true,
            ],
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree'
            ]
        ];
    }

    public function getParentsAndSelf()
    {
        $nodes = $this->parents()->all();
        array_push($nodes, $this);
        return $nodes;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert) == false) {
            return false;
        }
        if ($insert == true) {
            $this->status = StatusEnum::STATUS_ON;
        }
        return true;
    }
}

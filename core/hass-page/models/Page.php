<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\page\models;


use hass\base\classes\Tree;
use Yii;
use yii\behaviors\SluggableBehavior;
use hass\meta\behaviors\MetaBehavior;
use yii\behaviors\TimestampBehavior;
use hass\base\enums\StatusEnum;
use hass\base\behaviors\TimestampFormatter;
use hass\comment\behaviors\CommentBehavior;
use hass\comment\enums\CommentEnabledEnum;
use hass\base\behaviors\SetMaxSortableModel;


/**
 * This is the model class for table "{{%page}}".
 *
 * @property integer $id
 * @property integer $parent
 * @property string $title
 * @property string $content
 * @property string $slug
 * @property integer $status
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $weight
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Page extends \hass\base\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'parent',
                    'status',
                    'weight'
                ],
                'integer'
            ],
            [
                [
                    'title',
                    'content'
                ],
                'required'
            ],
            [
                [
                    'content'
                ],
                'string'
            ],
            [
                [
                    'title',
                    'slug'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'slug'
                ],
                'unique'
            ],
            [
                [
                    'published_at',
                    'created_at',
                    'updated_at'
                ],
                'safe'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('hass', 'ID'),
            'parent' => Yii::t('hass', 'Parent ID'),
            'title' => Yii::t('hass', 'Title'),
            'content' => Yii::t('hass', 'Content'),
            'slug' => Yii::t('hass', 'Slug'),
            'status' => Yii::t('hass', 'Status'),
            'published_at' => Yii::t('hass', 'Published At'),
            'created_at' => Yii::t('hass', 'Created At'),
            'updated_at' => Yii::t('hass', 'Updated At'),
            'weight' => Yii::t('hass', 'Weight')
        ];
    }

    public function behaviors()
    {
        $behaviors = [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
                "immutable" => true
            ],
            SetMaxSortableModel::className(),
        ];
        $behaviors['timestamp'] = TimestampBehavior::className();
        $behaviors['published_at'] = [
            'class' => \hass\base\behaviors\StrToTimeBehavior::className(),
            "attribute" => "published_at"
        ];
        $behaviors["meta"] = MetaBehavior::className();
        $behaviors["thumbnailFile"] = [
            'class' => \hass\attachment\behaviors\UploadBehavior::className(),
            'attribute' => 'thumbnail'
        ];
        $behaviors["textEditor"] = [
            'class' => \hass\base\misc\editor\EditorBehavior::className(),
            'attribute' => 'content'
        ];
        $behaviors["TimestampFormatter"] = TimestampFormatter::className();
        $behaviors["commentEnabled"] = [
            'class' => CommentBehavior::className(),
            'defaultStatus' => CommentEnabledEnum::STATUS_ON
        ];
        return $behaviors;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            if(empty($this->parent))
            {
                $this->parent = 0;
            }
  
            if ($insert == true) {
                $this->status = StatusEnum::STATUS_ON;
            }
            return true;
        } else {
            return false;
        }
    }
    
    // 还需要卸载掉当前节点和子节点
    public function getCanParentNodes()
    {
        $models = Page::find()->select([
            "id",
            "parent",
            "title"
        ])
            ->asArray()
            ->all();
        
        $tree = new Tree($models);
        $nodes = $tree->getNodes();
        // 去处当前节点和子节点
        if ($this->primaryKey) {
            $node = $tree->getNodeById($this->primaryKey);
            $ancestors = $node->getDescendantsAndSelf();
            $nodes = array_diff($nodes, $ancestors);
        }
        $result = [];
        foreach ($nodes as $node) {
            $result[$node->get("id")] = str_repeat("--", $node->getLevel() - 1) . $node->get("title");
        }
        return $result;
    }

    public function getParents($includeSelf = false)
    {
        $ancestors = $includeSelf ? array(
            $this
        ) : array();
        if ($this->parent == 0) {
            return $ancestors;
        }
        $parent = static::findOne($this->parent);
        return array_merge($parent->getParents(true), $ancestors);
    }

    public function getParentsAndSelf()
    {
        return $this->getParents(true);
    }

    public static function getAppDefaultPage()
    {
        return [
            "id" => - 1,
            "parent" => 0,
            "title" => "首页",
            "depth" => 0,
            "children" => []
        ];
    }
}

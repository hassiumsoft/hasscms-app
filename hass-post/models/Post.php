<?php
/**
 * HassCMS (http://www.hassium.org/).
 *
 * @link http://github.com/hasscms for the canonical source repository
 *
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\post\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use hass\meta\behaviors\MetaBehavior;
use hass\tag\behaviors\Taggable;
use yii\helpers\StringHelper;
use hass\taxonomy\behaviors\TaxonomyBehavior;
use yii\behaviors\TimestampBehavior;
use hass\base\enums\StatusEnum;
use yii\behaviors\BlameableBehavior;
use hass\base\behaviors\TimestampFormatter;
use hass\comment\behaviors\CommentBehavior;
use hass\comment\enums\CommentEnabledEnum;
use hass\base\behaviors\StrToTimeBehavior;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property int $author_id
 * @property string $title
 * @property string $short
 * @property string $content
 * @property string $slug
 * @property int $views
 * @property int $status
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $revision
 *
 * @author zhepama <zhepama@gmail.com>
 *
 * @since 0.1.0
 */
class Post extends \hass\base\ActiveRecord
{
    public static function tableName()
    {
        return '{{%post}}';
    }

    public function rules()
    {
        return [
            [
                [
                    'title',
                    'content',
                ],
                'required',
            ],
            [
                [
                    'author_id',
                    'status',
                    'revision',
                ],
                'integer',
            ],
            [
                [
                    'title',
                    'short',
                    'content',
                ],
                'string',
            ],
            [
                [
                    'created_at',
                    'updated_at',
                    'published_at',
                ],
                'safe',
            ],
            [
                [
                    'slug',
                ],
                'string',
                'max' => 200,
            ],
            [
                'slug',
                'default',
                'value' => null,
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('hass', 'ID'),
            'author_id' => Yii::t('hass', 'Author ID'),
            'title' => Yii::t('hass', 'Title'),
            'short' => Yii::t('hass', 'Short'),
            'content' => Yii::t('hass', 'Content'),
            'slug' => Yii::t('hass', 'Slug'),
            'views' => Yii::t('hass', 'Views'),
            'status' => Yii::t('hass', 'Status'),
            'published_at' => Yii::t('hass', 'Published At'),
            'created_at' => Yii::t('hass', 'Created At'),
            'updated_at' => Yii::t('hass', 'Updated At'),
            'revision' => Yii::t('hass', 'Revision'),
        ];
    }

    public function behaviors()
    {
        $behaviors = [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
                "immutable"=>true,
            ],
        ];
        $behaviors['author_id'] = [
            'class' => BlameableBehavior::className(),
            'attributes' => [
                static::EVENT_BEFORE_INSERT => 'author_id',
            ],
        ];
        $behaviors['timestamp'] = TimestampBehavior::className();
        $behaviors['published_at'] = [
            'class' => StrToTimeBehavior::className(),
            'attribute' => 'published_at',
        ];
        $behaviors['taggabble'] = Taggable::className();
        $behaviors['meta'] = MetaBehavior::className();
        $behaviors['thumbnailFile'] = [
            'class' => \hass\attachment\behaviors\UploadBehavior::className(),
            'attribute' => 'thumbnail',
        ];
        $behaviors['taxonomy'] = [
            'class' => TaxonomyBehavior::className()
        ];
        $behaviors['textEditor'] = [
            'class' => \hass\base\misc\editor\EditorBehavior::className(),
            'attribute' => 'content',
        ];
        $behaviors['TimestampFormatter'] = TimestampFormatter::className();
        $behaviors['commentEnabled'] = [
            'class' => CommentBehavior::className(),
            'defaultStatus' => CommentEnabledEnum::STATUS_ON,
        ];

        return $behaviors;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert == true) {
                $this->status = StatusEnum::STATUS_ON;
            }
            $this->updateRevision();
            $this->short = StringHelper::truncate(empty($this->short) ? strip_tags($this->content) : $this->short, 200);

            return true;
        } else {
            return false;
        }
    }

    public function updateRevision()
    {
        $this->updateCounters([
            'revision' => 1,
        ]);
    }

    public function getRevision()
    {
        return ($this->isNewRecord) ? 1 : $this->revision;
    }

    /**
     * [getAuthor description]
     * @return \hass\user\models\User
     */
    public function getAuthor()
    {
        $userClass = \Yii::$app->getUser()->identityClass;

        return $this->hasOne($userClass::className(), [
            'id' => 'author_id',
        ]);
    }

    public static function findOrderByViews($limit = 10)
    {
        $query = static::find()->orderBy(["views"=>SORT_DESC])->limit($limit);
        $models = $query->all();
        return $models;
    }
}

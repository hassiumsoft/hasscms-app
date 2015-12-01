<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\comment\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use hass\base\behaviors\TimestampFormatter;
use hass\base\ActiveQuery;
use yii\behaviors\BlameableBehavior;

/**
 *
 * @property integer $comment_id
 * @property string $entity
 * @property integer $entity_id
 * @property integer $author_id
 * @property string $username
 * @property string $email
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $content
 * @property string $user_ip
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Comment extends \hass\base\ActiveRecord
{

    const SCENARIO_GUEST = 'guest';

    const SCENARIO_USER = 'user';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%comment}}';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            TimestampFormatter::className(),
            [
                "class" => BlameableBehavior::className(),
                "attributes" => [
                    static::EVENT_BEFORE_INSERT => "author_id"
                ]
            ]
        ];
    }

    /**
     * 注册用户只存储用户id,游客存储用户名和邮箱
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'content'
                ],
                'required'
            ],
            [
                [
                    'username',
                    'email'
                ],
                'required',
                'on' => self::SCENARIO_GUEST
            ],
            [
                [
                    'parent_id',
                    'author_id'
                ],
                'integer'
            ],
            [
                [
                    'content'
                ],
                'string'
            ],
            [
                [
                    'username'
                ],
                'string',
                'max' => 128
            ],
            [
                [
                    'username',
                    'content'
                ],
                'string',
                'min' => 4
            ],
            [
                [
                    'email'
                ],
                'email'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_USER] = [
            'content',
            'parent_id',
            "entity",
            "entity_id"
        ];
        $scenarios[self::SCENARIO_GUEST] = [
            'username',
            'email',
            'content',
            'parent_id',
            "entity",
            "entity_id"
        ];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'ID',
            'entity' => 'Model',
            'entity_id' => 'entity_id ',
            'author_id' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'parent_id' => 'Parent Comment',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'content' => 'Content',
            'user_ip' => 'User Ip'
        ];
    }

    /**
     * @inheritdoc
     *
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert == true) {
                $this->user_ip = Yii::$app->getRequest()->getUserIP();
                return true;
            }

            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (parent::beforeSave($insert) == false) {
            return false;
        }

        if ($insert == true) {
            $this->updateCommentTotal();
            return true;
        }

        return true;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $this->updateCommentTotal();
    }

    public function updateCommentTotal()
    {
        $model = CommentInfo::find()->where(["entity"=>$this->entity,"entity_id"=>$this->entity_id])->one();
        $total = Comment::activeCount($this->entity,$this->entity_id);
        if($model == null && $total !=0)
        {
            $model = new CommentInfo();
            $model->entity =$this->entity;
            $model->entity_id = $this->entity_id;
            $model->total =$total;
            $model->save();
        }
        else
        {
            $model->total = $total;
            $model->save();
        }
    }

    /**
     * Check whether comment has replies
     *
     * @return int nubmer of replies
     */
    public function isReplied()
    {
        return Comment::find()->where([
            'parent_id' => $this->comment_id,
            "status"=>1
        ])
            ->count();
    }

    /**
     * Get count of active comments by $model and $entity_id
     *
     * @param string $model
     * @param int $entity_id
     * @return int
     */
    public static function activeCount($entity, $entity_id = NULL)
    {
        return Comment::find()->where([
            'entity' => $entity,
            'entity_id' => $entity_id,
            "status"=>1
        ])
            ->count();
    }
}
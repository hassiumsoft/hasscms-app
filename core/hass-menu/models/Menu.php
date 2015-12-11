<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\menu\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use hass\base\enums\StatusEnum;

/**
* This is the model class for table "{{%menu}}".
*
* @property string $name
* @property string $title
* @property string $module
* @property string $original
* @property string $slug
* @property integer $tree
* @property integer $lft
* @property integer $rgt
* @property integer $depth
* @property integer $status
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class Menu extends \hass\base\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'original'], 'string'],
            [['tree', 'lft', 'rgt', 'depth','status'], 'integer'],
            [['name', 'module', 'slug'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('hass\menu', 'Name'),
            'title' => Yii::t('hass\menu', 'title'),
            'module' => Yii::t('hass\menu', 'Module'),
            'original' => Yii::t('hass\menu', 'original'),
            'slug' => Yii::t('hass\menu', 'Slug'),
            'tree' => Yii::t('hass\menu', 'Tree'),
            'lft' => Yii::t('hass\menu', 'Lft'),
            'rgt' => Yii::t('hass\menu', 'Rgt'),
            'depth' => Yii::t('hass\menu', 'Depth'),
            'status' => Yii::t('hass\menu', 'Status'),
        ];
    }

    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                "immutable"=>true,
                'ensureUnique' => true
            ],
            'tree' => [
                'class' => \hass\menu\behaviors\NestedSetsBehavior::className(),
                'treeAttribute' => 'tree'
            ]
        ];
    }


    /**
     * @inheritdoc
     * @return MenuQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert) == false) {
            return false;
        }
        if($insert == true)
        {
            $this->status = StatusEnum::STATUS_ON;
        }
        return true;
    }


    
    public $originalName;
    
    /**
     * 插入多个菜单
     * @param unknown $data
     */
    public  function batchInsertMenu($data)
    {
        foreach ($data as  $value)
        {
            $model = new self();
            $model->detachBehaviors();
            $model->attachBehavior("sluggable",  [
                'class' => SluggableBehavior::className(),
                'attribute' => 'originalName',
                'ensureUnique' => true,
                "immutable"=>true,
            ]);
            $model->originalName = $value["originalName"];
            $model->setAttributes($value);
            $model->save();
        }
        $this->rgt = (count($data)+1)*2;
        $this->save();
    }
}

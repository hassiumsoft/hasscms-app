<?php

/**
 * 
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\search\behaviors;

use yii\db\ActiveRecord;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use hass\base\traits\EntityRelevance;

/**
 *
*            'rtSphinxBehavior' => [
            'class' => RtSphinxBehavior::className(),
            'rtIndex' => "postrt",
            'idAttributeName' => 'id',
            'rtFieldNames' => ['title', 'content'],
            'rtAttributeNames' => ["author_id","published_at"]
        ],
 *
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class RtSphinxBehavior extends Behavior
{
    
    use EntityRelevance;

    /**
     *
     * @var string provide the name of realtime index from you sphinx.conf file
     */
    public $rtIndex = null;

    /**
     *
     * @var integer the name of document ID from main document fetch query (sphinx.conf)
     */
    public $idAttributeName = null;

    /**
     *
     * @var array the set of rt_field names (sphinx.conf)
     */
    public $rtFieldNames = [];

    /**
     *
     * @var array the set of rt attributes
     */
    public $rtAttributeNames = [];

    public function init()
    {
        parent::init();
        
        if ($this->idAttributeName === null) {
            throw new InvalidConfigException('The "idAttributeName" property must be set.');
        }
        
        if ($this->rtIndex === null) {
            throw new InvalidConfigException('The "rtIndex" property must be set.');
        }
        
        if (! count($this->rtFieldNames)) {
            throw new InvalidConfigException('The "rtFieldNames" property must be set.');
        }
        
        if (! count($this->rtAttributeNames)) {
            throw new InvalidConfigException('The "rtAttributeNames" property must be set.');
        }
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterSave()
    {
        $params = [];
        
        $sql = \Yii::$app->sphinx->getQueryBuilder()->replace($this->rtIndex, $this->getColumns(), $params);
        return \Yii::$app->sphinx->createCommand($sql, $params)->execute();
    }

    public function afterDelete()
    {
        $params = [];
        $sql = \Yii::$app->sphinx->getQueryBuilder()->delete($this->rtIndex, $this->idAttributeName . '=' . $this->owner->getAttribute($this->idAttributeName), $params);
        
        return \Yii::$app->sphinx->createCommand($sql, $params)->execute();
    }

    protected function getColumns()
    {
        $columns = [
            $this->idAttributeName => $this->owner->getAttribute($this->idAttributeName),
            "entity" => $this->getEntityClass()
        ];
        $columns = $this->addColumns($columns, $this->rtFieldNames);
        $columns = $this->addColumns($columns, $this->rtAttributeNames);
        return $columns;
    }

    protected function addColumns($columns, $fieldNames)
    {
        foreach ($fieldNames as $name) {
            $value = $this->owner->getAttribute($name);
            if (! is_string($value)) {
                $value = strval($value);
            }
            $columns[$name] = $value;
        }
        return $columns;
    }
}
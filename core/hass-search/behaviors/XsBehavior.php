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
use hightman\xunsearch\Database;
use hass\base\traits\EntityRelevance;

/**
 *            'xsBehavior' => [
                'class' => XsBehavior::className(),
                'iniFile' => "@hass/post/xsconfig/post.ini",
            ],
 *
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class XsBehavior extends Behavior
{
    use EntityRelevance;
    
    
    public $iniFile;

    public $charset ='utf-8';

    /** @var \hightman\xunsearch\Database $db */
    public $db;

    function init()
    {
        parent::init();
        
        $this->db = \Yii::createObject([
            'class' => Database::className(),
            'charset' => $this->charset,
            'iniFile' =>\Yii::getAlias($this->iniFile)
        ]);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete'
        ];
    }

    public function afterInsert()
    {
        $this->db->add(new \XSDocument($this->getColumns()));
    }

    public function afterUpdate()
    {        
        $this->db->update(new \XSDocument($this->getColumns()));
    }

    public function afterDelete()
    {
        $this->db->xs->index->del($this->owner->primaryKey);
    }

    protected function getColumns()
    {
        $columns = [
            "entity"=>$this->getEntityClass()
        ];
        foreach ($this->db->xs->getAllFields() as $field) {
            
            if ($field->name == "entity")
            {
                continue;
            }
            $value = $this->owner->getAttribute($field->name);
            if (! is_string($value)) {
                $value = strval($value);
            }
            $columns[$field->name] = $value;
        }
        return $columns;
    }
}
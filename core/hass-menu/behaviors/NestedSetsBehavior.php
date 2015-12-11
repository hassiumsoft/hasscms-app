<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\menu\behaviors;

use hass\base\ActiveRecord;
use yii\db\Exception;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class NestedSetsBehavior extends \creocoder\nestedsets\NestedSetsBehavior
{
    /**
     * 移除root节点下所有子节点,不包含自己
     * @throws Exception
     */
    public function deleteChildren()
    {
        $this->operation = self::OPERATION_DELETE_WITH_CHILDREN;

        if (! $this->owner->isTransactional(ActiveRecord::OP_DELETE)) {
            return $this->deleteChildrenInternal();
        }

        $transaction = $this->owner->getDb()->beginTransaction();

        try {
            $result = $this->deleteChildrenInternal();

            if ($result === false) {
                $transaction->rollBack();
            } else {
                $transaction->commit();
            }

            return $result;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     *
     * @return integer|false the number of rows deleted or false if
     *         the deletion is unsuccessful for some reason.
     */
    protected function deleteChildrenInternal()
    {
        if (! $this->owner->beforeDelete()) {
            return false;
        }

        $condition = [
            'and',
            [
                '>',
                $this->leftAttribute,
                $this->owner->getAttribute($this->leftAttribute)
            ],
            [
                '<',
                $this->rightAttribute,
                $this->owner->getAttribute($this->rightAttribute)
            ]
        ];

        $this->applyTreeAttributeCondition($condition);
        $result = $this->owner->deleteAll($condition);
        $this->owner->setAttribute($this->rightAttribute, 2);
        $this->owner->save();
        // $this->owner->setOldAttributes(null);
        // $this->owner->afterDelete();

        return $result;
    }
    
    
    /**
     * @throws Exception
     */
    public function afterInsert()
    {
        if ($this->operation === self::OPERATION_MAKE_ROOT && $this->treeAttribute !== false) {
       
            $primaryKey = $this->owner->primaryKey();
    
            if (!isset($primaryKey[0])) {
                throw new Exception('"' . get_class($this->owner) . '" must have a primary key.');
            }
            
            $maxOrderNum = (int)(new \yii\db\Query())
            ->select('MAX(`'.$this->treeAttribute.'`)')
            ->from($this->owner->tableName())
            ->scalar();
    
            $this->owner->updateAll(
                [$this->treeAttribute => ++$maxOrderNum],
                [$primaryKey[0] => $this->owner->primaryKey]
                );
        }
    
        $this->operation = null;
        $this->node = null;
    }
}

?>
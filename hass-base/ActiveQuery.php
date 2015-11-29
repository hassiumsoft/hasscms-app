<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base;
/**
*
* @package hass\base
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ActiveQuery extends \yii\db\ActiveQuery
{

    public function desc()
    {
        $model = $this->modelClass;
        $this->orderBy($model::primaryKey()[0].' DESC');
        return $this;
    }

    public function asc()
    {
        $model = $this->modelClass;
        $this->orderBy($model::primaryKey()[0].' ASC');
        return $this;
    }
}
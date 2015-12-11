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
use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class MenuQuery extends \yii\db\ActiveQuery
{
  public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }

    public function sort()
    {
        $this->orderBy('tree ASC, lft ASC');
        return $this;
    }

}
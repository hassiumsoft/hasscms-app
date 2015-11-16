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

use creocoder\nestedsets\NestedSetsQueryBehavior;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class TaxonomyQuery extends \yii\db\ActiveQuery
{

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    /**
     * 同一tree下的weigh是一样的..weight只针对不同tree下的排序
     *lft针对同一tree下的排序
     */
    public function sort()
    {
        $this->orderBy('tree ASC, lft ASC');
        return $this;
    }

}
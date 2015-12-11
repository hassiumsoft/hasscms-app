<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace hass\base\traits;
use Yii;
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
trait SearchModelTrait
{

    public function search($filters)
    {
        /**
         * @var $query \yii\db\ActiveQuery
         */
        $query = static::find();
        /**
         * 查询过滤
        */
        $params = Yii::$app->getRequest()->getQueryParams();

        if(count($filters) == 0 || !isset($params[$this->formName()]))
        {
            return $query;
        }
        $this->load($params);

        foreach ($filters as $filter) {
            if (strncmp($filter, "%", 1) == 0) {
                $filter = substr($filter, 1);
                $query->andFilterWhere([
                    'like',
                    $filter,
                    $this->{$filter}
                ]);
            } else {
                $query->andFilterWhere([
                    $filter => $this->{$filter}
                ]);
            }
        }


        return $query;
    }
}

?>
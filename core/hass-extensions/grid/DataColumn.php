<?php
/**
 * 
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\extensions\grid;

use Closure;
use yii\helpers\Html;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class DataColumn extends  \yii\grid\DataColumn
{
    public $cellVisible = true;
    /**
     * Renders a data cell.
     * @param mixed $model the data model being rendered
     * @param mixed $key the key associated with the data model
     * @param integer $index the zero-based index of the data item among the item array returned by [[GridView::dataProvider]].
     * @return string the rendering result
     */
    public function renderDataCell($model, $key, $index)
    {
        
        if($this->cellVisible instanceof  Closure)
        {
            $this->cellVisible = call_user_func($this->cellVisible,$model, $key, $index, $this);
        }
        
        if($this->cellVisible === true)
        {
            return parent::renderDataCell($model, $key, $index);
        }
        return Html::tag('td',$this->cellVisible);
    }
   
}

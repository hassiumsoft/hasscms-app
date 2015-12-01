<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\meta\widgets;

use yii\widgets\InputWidget;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class MetaForm extends InputWidget
{

    public function init()
    {
        parent::init();

        if ($this->hasModel()) {
            // 这里不使用. Html::getAttributeValue($model, $attribute)因为返回的是model,使用只能返回主键
            $this->value = $this->model->getMetaModel();
        }
    }

    public function run()
    {
        return $this->render('meta_form', [
            'model' => $this->value
        ]);
    }
}
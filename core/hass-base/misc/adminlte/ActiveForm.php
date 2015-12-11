<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\adminlte;

use yii\helpers\ArrayHelper;

/**
* @package hass\backend
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    public $boxFieldClass = '\hass\base\misc\adminlte\BoxField';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    public function field($model, $attribute, $options = [])
    {
        return parent::field($model, $attribute, $options);
    }

    public function boxField($model, $attribute, $options = [])
    {
        $config = $this->fieldConfig;
        if ($config instanceof \Closure) {
            $config = call_user_func($config, $model, $attribute);
        }
        if (!isset($config['class'])) {
            $config['class'] = $this->boxFieldClass;
        }
        return \Yii::createObject(ArrayHelper::merge($config, $options, [
            'model' => $model,
            'attribute' => $attribute,
            'form' => $this,
        ]));
    }

}

?>
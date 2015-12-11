<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace hass\base\misc\grid;

use Yii;
use Closure;
use yii\helpers\Url;
use yii\helpers\Html;
use hass\base\misc\grid\assets\ActionAsset;
use hass\base\helpers\ArrayHelper;
/**
 * ActionColumn is a column for the [[GridView]] widget that displays buttons for viewing and manipulating the items.
 *
 * To add an ActionColumn to the gridview, add it to the [[GridView::columns|columns]] configuration as follows:
 *
 * ```php
 * 'columns' => [
 *     // ...
 *     [
 *         'class' => ActionColumn::className(),
 *         // you may configure additional properties here
 *     ],
 * ]
 * ```
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ActionColumn extends  \yii\grid\ActionColumn
{
    public $buttonOptions = ["class"=>"btn btn-default btn-xs"];
    public $template = '{view} {update} {delete}';


    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        ActionAsset::register($this->grid->view);

        parent::initDefaultButtons();

        if (!isset($this->buttons['up'])) {
            $this->buttons['up'] = function ($url) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('hass', 'Up'),
                    'aria-label' => Yii::t('hass', 'Up'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);

                Html::addCssClass($options, "move-up");

                return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['down'])) {
            $this->buttons['down'] = function ($url) {
                $options = ArrayHelper::merge([
                    'title' => Yii::t('hass', 'Down'),
                    'aria-label' => Yii::t('hass', 'Down'),
                    'data-pjax' => '0'
                ], $this->buttonOptions);

                Html::addCssClass($options, "move-down");

                return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, $options);
            };
        }

    }

    /**
     * Creates a URL for the given action and model.
     * This method is called for each button and each row.
     * @param string $action the button name (or action ID)
     * @param \yii\db\ActiveRecord $model the data model
     * @param mixed $key the key associated with the data model
     * @param integer $index the current row index
     * @return string the created URL
     */
    public function createUrl($action, $model, $key, $index)
    {
        $url = null;

        if ($this->urlCreator instanceof Closure) {
            $url =  call_user_func($this->urlCreator, $action, $model, $key, $index,$this);
        }
        if($url !=null)
        {
            return $url;
        }

        $params = is_array($key) ? $key : ['id' => (string) $key];
        $params[0] = $this->controller ? $this->controller . '/' . $action : $action;

        return Url::toRoute($params);
    }


}

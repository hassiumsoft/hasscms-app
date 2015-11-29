<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\tag\widgets;

use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */


class TagsInput extends Select2
{

    public  $options =  ['placeholder' => 'Select a tag ...', 'multiple' => true];

    public $pluginOptions =  [
        'tags' => true,
        'maximumInputLength' => 10
    ];

    public $data = [];

    public function init()
    {

        \kartik\base\InputWidget::init();
        $this->pluginOptions['theme'] = $this->theme;
        if (!empty($this->addon) || empty($this->pluginOptions['width'])) {
            $this->pluginOptions['width'] = '100%';
        }
        $multiple = ArrayHelper::getValue($this->pluginOptions, 'multiple', false);
        unset($this->pluginOptions['multiple']);
        $multiple = ArrayHelper::getValue($this->options, 'multiple', $multiple);
        $this->options['multiple'] = $multiple;
        if ($this->hideSearch) {
            $css = ArrayHelper::getValue($this->pluginOptions, 'dropdownCssClass', '');
            $css .= ' kv-hide-search';
            $this->pluginOptions['dropdownCssClass'] = $css;
        }
        $this->initPlaceholder();
        if ( $this->data == null) {
            if (!isset($this->value) && !isset($this->initValueText)) {
                $this->data = [];
            } else {
                $key = isset($this->value) ? $this->value : ($multiple ? [] : '');
                $val = isset($this->initValueText) ? $this->initValueText : $key;
                $this->data = $multiple ? array_combine($key, $val) : [$key => $val];
            }
        }
        Html::addCssClass($this->options, 'form-control');
        $this->initLanguage('language', true);
        $this->registerAssets();
        $this->renderInput();
    }
}

?>
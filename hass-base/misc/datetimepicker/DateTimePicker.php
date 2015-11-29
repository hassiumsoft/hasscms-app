<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2014-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
namespace hass\base\misc\datetimepicker;


use hass\base\misc\datetimepicker\DateTimePickerAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use hass\base\helpers\FormatConverter;

/**
* @package package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class DateTimePicker extends InputWidget
{ /**
     * @var array
     * Full list of available client options see here:
     * @link http://eonasdan.github.io/bootstrap-datetimepicker/#options
     */
    public $clientOptions = [];
    /**
     * @var array
     */
    public $containerOptions = [];
    /**
     * @var array
     */
    public $inputAddonOptions = [];
    /**
     * 将时间戳转换为指定的格式,
     * 1.主要用于首次数据显示
     * 2.将其转化为对应的moment格式.供js使用
     * @var string
     */
    protected  $phpDatetimeFormat;
    /**
     * 设置js使用的格式
     * @var
     */
    public $momentDatetimeFormat = "YYYY-MM-DD HH:mm:ss";
    /**
     * @var bool
     */
    public $showInputAddon = true;
    /**
     * @var string
     */
    public $inputAddonContent;


    public $language;
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        $value = $this->hasModel() ? Html::getAttributeValue($this->model, $this->attribute) : $this->value;
        $this->phpDatetimeFormat = FormatConverter::convertDateMomentToPhp($this->momentDatetimeFormat);


        // Init default clientOptions
        $this->clientOptions = ArrayHelper::merge([
            'useCurrent' => true,
            'locale' => $this->language?:\Yii::$app->language,
            'format' => $this->momentDatetimeFormat,
            "showTodayButton"=>true
        ], $this->clientOptions);
        // Init default options
        $this->options = ArrayHelper::merge([
            'class' => 'form-control',
        ], $this->options);
        if ($value !== null) {
            $this->options['value'] = array_key_exists('value', $this->options)
                ? $this->options['value']
                : \Yii::$app->formatter->asDatetime($value, "php:".$this->phpDatetimeFormat);
        }

        DateTimePickerAsset::register($this->getView());
        $clientOptions = Json::encode($this->clientOptions);
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = $this->getId();
        }
        $this->view->registerJs("$('#{$this->containerOptions['id']}').datetimepicker({$clientOptions})");
    }
    /**
     * @return string
     */
    public function run()
    {
        $content = [];
        if ($this->showInputAddon) {
            Html::addCssClass($this->containerOptions, 'input-group');
        }
        Html::addCssStyle($this->containerOptions, 'position: relative');
        $content[] = Html::beginTag('div', $this->containerOptions);
        $content[] = $this->renderInput();
        if ($this->showInputAddon) {
            $content[] = $this->renderInputAddon();
        }
        $content[] = Html::endTag('div');
        return implode("\n", $content);
    }
    /**
     * @return string
     */
    protected function renderInput()
    {
        if ($this->hasModel()) {
            $content = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $content = Html::textInput($this->name, $this->value, $this->options);
        }
        return $content;
    }
    /**
     * @return string
     */
    protected function renderInputAddon()
    {
        $content = [];
        if (!array_key_exists('class', $this->inputAddonOptions)) {
            Html::addCssClass($this->inputAddonOptions, 'input-group-addon');
        }
        if (!array_key_exists('style', $this->inputAddonOptions)) {
            Html::addCssStyle($this->inputAddonOptions, ['cursor' => 'pointer']);
        }
        $content[] = Html::beginTag('span', $this->inputAddonOptions);
        if ($this->inputAddonContent) {
            $content[] = $this->inputAddonContent;
        } else {
            $content[] = Html::tag('span', '', ['class' => 'glyphicon glyphicon-calendar']);
        }
        $content[] = Html::endTag('span');
        return implode("\n", $content);
    }


}

?>
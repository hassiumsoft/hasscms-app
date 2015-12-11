<?php

/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/
use yii\helpers\Html;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
?>

<div class="box box-solid field-revolutionslider-url has-success" id="caption_<?=$index?>">
<div class="box-body" >

<div class="row form-group">
<div class="col-md-2"><?php echo Html::activeTextInput($model, "[$index]x",["class"=>"form-control","placeholder"=>"x"])?></div>


<div class="col-md-2"><?php echo Html::activeTextInput($model, "[$index]y",["class"=>"form-control","placeholder"=>"y"])?></div>

<div class="col-md-2"><?php echo Html::activeTextInput($model, "[$index]speed",["class"=>"form-control","placeholder"=>"speed"])?></div>
<div class="col-md-2"><?php echo Html::activeTextInput($model, "[$index]start",["class"=>"form-control","placeholder"=>"start"])?></div>

<div class="col-md-2"><?php echo Html::activeTextInput($model, "[$index]hoffset",["class"=>"form-control","placeholder"=>"hoffset"])?></div>

<div class="col-md-2">
<?=Html::button('删除', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block delCaption',"data-id"=>"$index"])?>

</div>
</div>

<div class="row form-group">
<div class="col-md-6">
<label>位置</label>
<?php echo Html::activeDropDownList($model, "[$index]align",["align-left"=>"居左","align-center"=>"居中","align-right"=>"居右"],["class"=>"form-control"])?>
</div>
<div class="col-md-6">
<label>动画</label>
<?php echo Html::activeDropDownList($model, "[$index]easing",["easeOutBack"=>"easeOutBack","easeInBack"=>"easeInBack"],["class"=>"form-control"])?>
</div>
</div>

<div class="form-group">
<label>内容</label>
<?php echo Html::activeTextarea($model, "[$index]content",["class"=>"form-control"])?>
</div>
</div>
</div>
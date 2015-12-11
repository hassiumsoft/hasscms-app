<?php
use yii\helpers\Html;
use hass\rbac\assets\RbacAsset;
/**
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

RbacAsset::register($this);
/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
*/
?>

<div class="row">

<?php echo Html::beginForm()?>

<?php foreach ($permissions as $permission):?>
<div class="col-md-6">
<div class="box">
<div class="box-header with-border">
<?php echo $permission['module']?>

<div class="box-tools pull-right">
<button class="btn btn-box-tool btn-xs select-all" type="button">全选</button>
</div>
</div>
<div class="box-body">
<?php foreach ($permission["permissions"] as $name=>$data):?>

<?php echo Html::checkbox("permissions[".$name."]",isset($children[$name]),["label"=>$data["description"]])?>

<?php endforeach;?>
</div>

</div>

</div>
<?php endforeach;?>
</div>
<div class="form-group">
    <?= Html::submitButton( Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php echo  Html::endForm()?>
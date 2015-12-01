<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\theme\assets\ThemeAsset;
use hass\base\misc\adminlte\ActiveForm;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */

/* @var $this yii\web\View */
/* @var $theme hass\theme\models\Theme */
$this->title = Yii::t('hass', '添加主题');
$this->params['breadcrumbs'][] = $this->title;

ThemeAsset::register($this);
?>

<div class="upload-theme row">
	<p class="install-help">如果您有.zip格式的主题，可以在这里通过上传的方式安装。</p>

<?php $form = ActiveForm::begin(["options"=>["class"=>"wp-upload-form clearfix","enctype"=>"multipart/form-data"]])?>

<?php echo $form->field($model, "themezip",["options"=>["class"=>"pull-left"]])->fileInput()->label(false);?>

<input type="submit"
		name="install-theme-submit" id="install-theme-submit" class="button"
		value="现在安装" />
	<?php  ActiveForm::end();?>
</div>
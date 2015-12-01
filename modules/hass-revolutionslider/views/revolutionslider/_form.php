<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


use yii\helpers\Html;

use hass\base\misc\adminlte\ActiveForm;
use hass\attachment\widgets\SingleMediaWidget;
use hass\revolutionslider\assets\RevolutionsliderAsset;
use yii\helpers\Url;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
RevolutionsliderAsset::register($this);
/*@var $model \hass\revolutionslider\models\Revolutionslider */
?>
<?php
$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'model-form'
    ]
]);
?>

	<div class="row">
		<div class="col-md-6">


			<?php
echo $form->boxField($model, 'thumbnail')
    ->widget(SingleMediaWidget::className())
    ->header("幻灯图片");
?>


<?=Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block' ])?>
		</div>
		<div class="col-md-6">
			<div id="caption-list">
			<?php if(!empty($model->captions)):?>
			<?php foreach ($model->captions as $index=>$caption):?>
				<?php echo $this->render("_caption",["model"=>$caption,'index'=>$index])?>
			<?php endforeach;?>
			<?php endif;?>
			</div>
			<?=Html::button('添加文字', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block' ,"id"=>"addCaption","data-url"=>Url::to(["addcaption"])])?>
		</div>
	</div>


<?php ActiveForm::end(); ?>

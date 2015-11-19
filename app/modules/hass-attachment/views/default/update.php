<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 *
 */
use yii\helpers\Html;
use hass\extensions\adminlte\ActiveForm;
use hass\attachment\assets\AttachmentUpdateAsset;
use yii\helpers\Url;
use yii\web\View;
use hass\attachment\enums\CropType;
/* @var $this yii\web\View */
/* @var $searchModel \hass\attachment\models\AttachmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model yii\db\ActiveRecord */

$this->title = Yii::t('hass/attachment', '编辑附件');
$this->params['breadcrumbs'][] = [
    "label" => "附件首页",
    "url" => [
        "index"
    ]
];
$this->params['breadcrumbs'][] = $this->title;

AttachmentUpdateAsset::register($this);


$this->registerJs("var cropUrl = '".Url::to(["crop","id"=>Yii::$app->getRequest()->get("id")])."'",View::POS_HEAD);

?>

<div class="row">
	<div class="col-md-9">

		<div class="row wp_attachment_image">
			<div class="col-md-9" id="interface">

				<?php echo  Html::img($model->getUrl(),["class"=>"original-image"])?>

			</div>
			<div class="col-md-3">
				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">当前缩略图</h3>
					</div>
					<div class="box-body">
						<?php echo Html::img($model->getThumb(264,148))?>
					</div>
				</div>

				<div class="box box-solid">
					<div class="box-body">
						<form onsubmit="return false;" id="text-inputs">
							<div class="row">
								<div class="col-md-6 form-group">
									<label for="cx" class="col-sm-2 control-label">X</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cx" id="crop-x"
											placeholder="X">
									</div>

								</div>
								<div class="col-md-6 form-group">

									<label for="cy" class="col-sm-2 control-label">Y</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cy" id="crop-y"
											placeholder="Y">
									</div>
								</div>
								<div class="col-md-6 form-group">
									<label for="cw" class="col-sm-2 control-label">W</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="cw" id="crop-w"
											placeholder="W">
									</div>
								</div>
								<div class="col-md-6 form-group">
									<label for="ch" class="col-sm-2 control-label">H</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" name="ch" id="crop-h"
											placeholder="H">

									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="box box-solid">
					<div class="box-header">
						<h3 class="box-title">裁剪设置</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<strong>将裁剪应用于：</strong>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::ALL?>"> 所有图像大小
								</label>
							</div>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::THUMBNAIL?>" checked=""> 只应用于缩略图
								</label>
							</div>
							<div class="radio">
								<label> <input type="radio" name="crop-apply-type"
									value="<?php echo CropType::ORIGINAL?>"> 只应用于原图
								</label>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<?= Html::button("裁剪", ['class' => 'btn bg-maroon margin btn-flat', "id"=>"setSelectButton"])?>
						<?= Html::button("保存", ['class' => 'btn bg-maroon margin btn-flat hide', "id"=>"cropButton"])?>
						<?= Html::button("取消", ['class' => 'btn bg-maroon margin btn-flat hide', "id"=>"releaseButton"])?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<?php
		$form = ActiveForm::begin([
		    'options' => [
		        'enctype' => 'multipart/form-data',
		        'class' => 'model-form'
		    ]
		]);
		?>
		<div class="box box-solid">
			<div class="box-body">
				<?php echo $this->render("_info",["model"=>$model]);?>
				<?= $form->field($model, 'title')->textInput(['class' => 'form-control']); ?>
				<?= $form->field($model, 'description')->textarea(['class' => 'form-control']); ?>
			</div>
			<div class="box-footer">
				<?= Html::submitButton("更新附件", ['class' => 'btn bg-maroon margin btn-flat'])?>
				<?=Html::a("删除附件", ['delete','id' => $model->primaryKey], ['class' => 'btn bg-default margin  btn-flat','data-item-id'=>$model->primaryKey,'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),'role' => 'delete'])?>
			</div>
		</div>
		<?php ActiveForm::end(); ?>
	</div>
</div>


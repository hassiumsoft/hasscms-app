<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
use hass\base\misc\datetimepicker\DateTimePicker;

use yii\helpers\Html;
use yii\helpers\Url;
use hass\meta\widgets\MetaForm;
use hass\tag\widgets\TagsInput;

use hass\base\misc\adminlte\ActiveForm;
use hass\tag\behaviors\Taggable;
use hass\taxonomy\widgets\TaxonomySelect;
use hass\taxonomy\behaviors\TaxonomyBehavior;
use hass\attachment\widgets\SingleMediaWidget;
use hass\base\enums\EntityStatusEnum;
use hass\base\misc\editor\EditorWidget;
use hass\comment\enums\CommentEnabledEnum;
use hass\post\Module;

/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
?>
<?php

$form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'model-form'
    ]
]);
?>
<div class="col-md-9">
	<?= $form->field($model, 'title')->label(false)?>
	<?= $form->boxField($model, 'short')->textarea()->header("文章摘要")->hint("摘要是可选的手工创建的内容总结，并可在您的主题中使用。")?>
	<?=$form->field($model, 'content')->label(false)->widget(EditorWidget::className(), ["config" => ["class" => '\vova07\imperavi\Widget','settings' => ['lang' => 'zh_cn','minHeight' => 200,'imageManagerJson' => Url::to(['/attachment/upload/images-get']),'imageUpload' => Url::to(['/attachment/upload/create-imperavi']),'fileUpload' => Url::to(['/attachment/upload/create-imperavi']),'plugins' => ['clips','fullscreen','imagemanager','filemanager']]]]);?>
	<?= $form->boxField($model, 'meta',["collapsed"=>true])->widget(MetaForm::className())->header("SEO"); ?>
</div>
<div class="col-md-3">
	<div class="box box-solid">
		<div class="box-body">
			<div class="form-group">
				<label class="control-label"
					style="float: left; padding-right: 5px;"> <?= $model->attributeLabels()['created_at']?>
					:
				</label> <span> <?= $model->getCreatedDate();?>
				</span>
			</div>
			<div class="form-group">
				<label class="control-label"
					style="float: left; padding-right: 5px;"> <?= $model->attributeLabels()['updated_at']?>
					:
				</label> <span> <?= $model->getUpdatedDate()?>
				</span>
			</div>
			<div class="form-group">
				<label class="control-label"
					style="float: left; padding-right: 5px;"> <?= $model->attributeLabels()['revision']?>
					:
				</label> <span> <?= $model->getRevision()?>
				</span>
			</div>

			<?=Html::submitButton($model->isNewRecord ? '发布' : '更新', ['class' => 'btn bg-maroon btn-flat margin-bottom btn-block' ])?>

		</div>
	</div>

	<div class="box box-solid">
		<div class="box-body">
			<?= $form->field($model, 'slug');?>
			<?= $form->field($model, 'published_at')->widget(DateTimePicker::className()); ?>

			<?= $form->field($model, 'status')->dropDownList(EntityStatusEnum::listData())?>

			 <?= $form->field($model, 'commentEnabled')->dropDownList(CommentEnabledEnum::listdata())?>

			<?php if (!$model->isNewRecord): ?>
			<?= $form->field($model, 'author_id')->dropDownList( Module::getUserList()  )?>
			<?php endif; ?>

		</div>
	</div>
	<?= $form->boxField($model, TaxonomyBehavior::$formName)->widget(TaxonomySelect::className())->header("选择分类"); ?>
	<?php
echo $form->boxField($model, Taggable::$formName)
    ->widget(TagsInput::className())
    ->header("TAG");
?>
	<?php
echo $form->boxField($model, 'thumbnail')
    ->widget(SingleMediaWidget::className())
    ->header("特色图片");
?>
</div>

<?php ActiveForm::end(); ?>

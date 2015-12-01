<?php
use yii\helpers\Html;
use hass\taxonomy\models\Taxonomy;
use hass\meta\widgets\MetaForm;
use hass\base\misc\adminlte\ActiveForm;
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => true,
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<div class="box box-solid">
<?php if($model->isNewRecord):?>
    <div class="box-header with-border" >
        创建新分类
    </div>
<?php endif;?>

	<div class="box-body">
<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'slug') ?>

<div class="form-group field-category-title required">
    <label for="category-parent" class="control-label"><?= Yii::t('hass', 'Parent category') ?></label>
    <select class="form-control" id="category-parent" name="parent">
        <option value="" class="smooth"><?= Yii::t('hass', 'No') ?></option>
        <?php foreach(Taxonomy::find()->sort()->asArray()->all() as $node) : ?>
            <option
                value="<?= $node['taxonomy_id'] ?>"
                <?php if($parentId == $node['taxonomy_id']) echo 'SELECTED' ?>
            ><?= str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $node['depth'])." ".$node['name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>


<?= $form->field($model, 'description')->textarea() ?>
	</div>
</div>

<?= $form->boxField($model, 'meta',["collapsed"=>true])->widget(MetaForm::className())->header("SEO"); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('hass', 'Create') : Yii::t('hass', 'Update'), ['class' => 'btn bg-maroon btn-flat btn-block']) ?>
</div>
<?php ActiveForm::end(); ?>
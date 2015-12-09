<?php
use hass\base\misc\adminlte\ActiveForm;
use yii\helpers\Html;
use hass\migration\assets\MigrationAsset;
use hass\migration\models\MigrationUtility;

/** @var $model hass\migration\models\MigrationUtility */
/** @var $output String */
/** @var $output_drop String */
/** @var $tables Array */
/** @var \hass\base\misc\adminlte\ActiveForm $form */
MigrationAsset::register($this);
$array = [
    'CASCADE' => 'CASCADE',
    'NO ACTION' => 'NO ACTION',
    'RESTRICT' => 'RESTRICT',
    'SET NULL' => 'SET NULL'
];
?>
<?php $form = ActiveForm::begin(['id' => 'form-submit']); ?>
<div class="box">
	<div class="box-body">
	  <?= $form->field($model, 'migrationName')->textInput()?>
	  <?= $form->field($model, 'migrationPath')->textInput()?>
	  
	  		<div class="row">
			<div class="col-md-6">
			  <?= $form->field($model, 'foreignKeyOnUpdate')->dropDownList($array)->hint('')?>
			</div>
			<div class="col-md-6">
			  <?= $form->field($model, 'foreignKeyOnDelete')->dropDownList($array)->hint('')?>
			</div>
		</div>
	</div>
</div>


  
<?= $form->boxField($model, "tableSchemas")->checkboxList(MigrationUtility::getTableNames())->header("迁移表结构")->hint(Html::a("全选",'javascript:void(0)',['class'=>"select-all"]))?>
<?= $form->boxField($model, "tableDatas")->checkboxList(MigrationUtility::getTableNames())->header("迁移表数据")->hint(Html::a("全选",'javascript:void(0)',['class'=>"select-all"]))?>


<div class="form-group">
     <?= Html::submitButton('迁移', ['class' => 'btn bg-maroon btn-flat btn-block ', 'name' => 'button-submit', 'id' => 'button-submit'])?>
</div>

<?php ActiveForm::end()?>



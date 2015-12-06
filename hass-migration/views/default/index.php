<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use hass\migration\assets\MigrationAsset;

/** @var $model hass\migration\models\MigrationUtility */
/** @var $output String */
/** @var $output_drop String */
/** @var $tables Array */

MigrationAsset::register($this);
$array = ['CASCADE' => 'CASCADE', 'NO ACTION' => 'NO ACTION', 'RESTRICT' => 'RESTRICT', 'SET NULL' => 'SET NULL'];
?>


<div class="form">
    <?php $form = ActiveForm::begin(['id' => 'form-submit',]); ?>

    <div class="inline-elements">
        <div>
            <?= $form->field($model, 'mysql')->dropDownList(['0' => 'No', '1' => 'Yes']) ?>
        </div>
        <div>
            <?= $form->field($model, 'mysql_options') ?>
        </div>
    </div>

    <div class="inline-elements">
        <div>
            <?= $form->field($model, 'mssql')->dropDownList(['0' => 'No', '1' => 'Yes']) ?>
        </div>
        <div>
            <?= $form->field($model, 'mssql_options') ?>
        </div>
    </div>

    <div class="inline-elements">
        <div>
            <?= $form->field($model, 'pgsql')->dropDownList(['0' => 'No', '1' => 'Yes']) ?>
        </div>
        <div>
            <?= $form->field($model, 'pgsql_options') ?>
        </div>
    </div>

    <div class="inline-elements">
        <div>
            <?= $form->field($model, 'sqlite')->dropDownList(['0' => 'No', '1' => 'Yes']) ?>
        </div>
        <div>
            <?= $form->field($model, 'sqlite_options') ?>
        </div>
    </div>

    <div class="inline-elements">
        <div style="width: 80%">
            <?= $form->field($model, 'databaseTables')->dropDownList(['00' => ' '] + $tables)->label('Tables') ?>
        </div>
        <div style="width: 20%; vertical-align: middle; text-align: right">
            <?= Html::button('Add All Tables', ['class' => 'btn btn-success', 'id' => 'button-add-all']) ?>
        </div>
    </div>

    <div class="inline-elements">
        <div style="width: 80%">
            <?= $form->field($model, 'tables')
                ->label('Tables to Process')
                ->hint('Change to textarea and back to easily view tables') ?>
        </div>
        <div style="width: 20%; vertical-align: middle; text-align: right">
            <?= Html::button('Change View', ['class' => 'btn btn-success', 'id' => 'button-tables-convert']) ?>
        </div>
    </div>


    <div class="inline-elements">
        <div style="width: 50%">
            <?= $form->field($model, 'ForeignKeyOnUpdate')->dropDownList($array)->hint('') ?>
        </div>
        <div style="width: 50%; vertical-align: middle; text-align: right">
            <?= $form->field($model, 'ForeignKeyOnDelete')->dropDownList($array)->hint('') ?>
        </div>
    </div>

    <?= $form->field($model, 'addTableInserts')->dropDownList(['0' => 'No', '1' => 'Yes'])->hint('Add table data to migration') ?>


    <div class="form-group">
        <?= Html::submitButton('Run', ['class' => 'btn btn-primary', 'name' => 'button-submit', 'id' => 'button-submit']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>





<?php if ($output) : ?>
    <div class="title" style="margin-top:10px; padding-top: 10px; border-top: 1px dotted #CCCCCC"">Up()
    <?= Html::button('Select All Text', ['class' => 'btn btn-success', 'id' => 'button-select-all']) ?>
    </div>
    <div style="display: block; position: relative;">
        <pre id="code-output" style="margin-top: 20px;"><?= $output ?></pre>
    </div>

    <div class="title" style="margin-top:10px; padding-top: 10px; border-top: 1px dotted #CCCCCC">Down()
    <?= Html::button('Select All Text', ['class' => 'btn btn-success', 'id' => 'button-select-all-drop']) ?>
    </div>
    <div style="display: block; position: relative;">
        <pre id="code-output-drop" style="margin-top: 20px;"><?= $output_drop ?></pre>
    </div>

<?php endif ?>


<?php
/**
 * @var View $this
 * @var SourceMessage $model
 */

use yii\helpers\Html;
use yii\web\View;
use hass\i18n\models\SourceMessage;
use hass\i18n\Module;
use yii\widgets\ActiveForm;

$this->title = Module::t('Update') . ': ' . $model->message;
?>
<div class="message-update">
    <div class="message-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="field">
            <div class="ui grid">
                <?php foreach ($model->messages as $language => $message) : ?>
                    <div class="four wide column">
                        <?= $form->field($model->messages[$language], '[' . $language . ']translation')->label($language) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?= Html::submitButton(Module::t('Update'), ['class' => 'ui primary button']) ?>
        <?php $form::end(); ?>
    </div>
</div>

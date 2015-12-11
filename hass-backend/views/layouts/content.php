<?php
use yii\widgets\Breadcrumbs;
use hass\backend\widgets\Alert;

/** @var \yii\web\View $this */
/** @var string $content */
?>
<div class="content-wrapper">
    <section class="content-header">

        <?php if (isset($this->blocks['content-header'])) { ?>
            <?= $this->blocks['content-header'] ?>
        <?php } else { ?>
            <h1>
                <?php
                if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                } ?>
            </h1>
        <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>

   <section class="content">
        <?= Alert::widget(["options"=>["class"=>"flat"]]) ?>
        <?= $content ?>
    </section>
</div>


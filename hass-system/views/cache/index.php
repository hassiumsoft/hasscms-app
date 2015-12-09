<?php
use yii\helpers\Url;
use yii\helpers\Html;

/** @var \yii\web\View $this */
$this->title = \Yii::t('hass', "清除缓存");
?>

<div class="box">
	<div class="box-body">
		<div class="row">
			<div class="col-md-6 text-center">
				<a href="<?= Url::to(['cache/flush-cache']) ?>"
					class="btn btn-default"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('hass', 'Flush cache') ?></a>

			</div>
			<div class="col-md-6 text-center"  >
				<a href="<?= Url::to(['cache/clear-assets']) ?>"
					class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> <?= Yii::t('hass', 'Clear assets') ?></a>
			</div>


		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-5">
				<h4><?php echo Yii::t('hass', '删除一个缓存') ?></h4>
            <?php
\yii\bootstrap\ActiveForm::begin([
                'action' => \yii\helpers\Url::to(['flush-cache-key']),
                'method' => 'get',
                'layout' => 'inline'
            ])?>
 
                <?php echo Html::input('string', 'key', null, ['class'=>'form-control', 'placeholder' => Yii::t('backend', 'Key')])?>
                <?php echo Html::submitButton(Yii::t('hass', 'Flush'), ['class'=>'btn btn-danger'])?>
            <?php \yii\bootstrap\ActiveForm::end()?>
        </div>
		</div>

	</div>
</div>


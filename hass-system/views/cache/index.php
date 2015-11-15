<?php
use yii\helpers\Url;

$this->title = Yii::t('hass', 'System');
?>

<p>
    <a href="<?= Url::to(['cache/flush-cache']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('hass', 'Flush cache') ?></a>
</p>

<br>

<p>
    <a href="<?= Url::to(['cache/clear-assets']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> <?= Yii::t('hass', 'Clear assets') ?></a>
</p>
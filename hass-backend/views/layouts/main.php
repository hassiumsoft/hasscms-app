<?php
use yii\helpers\Html;
use hass\backend\Module;

/** @var \yii\web\View $this */
/** @var string $content */
hass\backend\assets\AdminAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags()?>
        <title><?= Html::encode($this->title) ?></title>
	    <?php $this->head()?>
    </head>
<body class="sidebar-mini <?php echo Module::getInstance()->getTheme();?>" id="admin-body">
    <?php $this->beginBody()?>
    <div class="wrapper">
        <?=$this->render('header.php')?>

        <?=$this->render('left.php')?>


        <?=$this->render('content.php', ['content' => $content])?>

       <?=$this->render('footer.php')?>

    </div>
    <?php $this->endBody()?>
    </body>
</html>
<?php $this->endPage()?>

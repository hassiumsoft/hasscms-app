<?php
use yii\helpers\Url;
use hass\theme\assets\ThemeAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ArrayDataProvider */
/* @var $theme hass\theme\helpers\Theme */
$this->title = Yii::t('hass', '主题');
$this->params['breadcrumbs'][] = $this->title;

ThemeAsset::register($this);
?>



<?php $this->beginBlock('content-header'); ?>
<h1>
	<?php echo $this->title?> <a class="btn bg-purple btn-flat btn-xs "
		href="<?= Url::to(['upload']) ?>"> <?= Yii::t('hass', '上传新主题')?>
	</a>
</h1>
<?php $this->endBlock(); ?>


<div class="row">

<?php foreach ($dataProvider->getModels() as $theme):?>
    <div class="col-md-3">
		<div class="theme <?php echo $theme->isActive()?"active":"";?>">


              <?php if(!empty($screenshot = $theme->getScreenshot())):?>
			<div class="theme-screenshot">
				<a href="<?php echo Url::to(["view","id"=>$theme->getPackage()])?>"> <img
					src="<?php echo $screenshot ?>" alt="" /> <span
					class="more-details">主题详情</span>
				</a>
			</div>
            <?php else :?>
		<div class="theme-screenshot blank">
				<a href="<?php echo Url::to(["view","id"=>$theme->getPackage()])?>"> <span
					class="more-details">主题详情</span>
				</a>
			</div>
            <?php endif;?>



			<h3 class="theme-name">
				<span><?php echo $theme->isActive()?"默认:":"";?></span><?php echo $theme->getName()?>
			</h3>

			<div class="theme-actions">
			     <?php if( $theme->isActive() == true):?>
                    <a class="btn bg-maroon btn-flat btn-sm"
					href="<?php echo Url::to(["custom","id"=>$theme->getPackage()])?>"> 自定义 </a>
                <?php else:?>
                   <a class="btn bg-purple btn-flat btn-sm"
					href="<?php echo Url::to(["enabled","id"=>$theme->getPackage()])?>">启用</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a class="btn bg-maroon btn-flat btn-sm"
					href="<?php echo Url::to(["demo","id"=>$theme->getPackage()])?>"
					target="_blank"> 预览 </a>

                <?php endif;?>
			</div>
		</div>
	</div>
<?php endforeach;?>
</div>
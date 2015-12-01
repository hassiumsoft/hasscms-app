<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
?>
<div class="container">
	<div class="page-header">
		<h1><?php echo $model->title?></h1>
	</div>
</div>
<section class="main-section paddind" id="Portfolio">
	<!--main-section-start-->
	<div class="container">
		<div class="portfolioFilter">
			<ul class="Portfolio-nav">
				<li><a href="#" data-filter="*" class="current">All</a></li>
        	 <?php foreach ($groups as $key =>$name):?>
            <li><a href="#" data-filter=".<?php echo $key ?>"><?php echo $name ?></a></li>
            <?php endforeach;?>
        </ul>
		</div>

	</div>
	<div class="portfolioContainer clearfix">
            <?php foreach ($photos as $photo):?>
          	<div class=" Portfolio-box  <?php echo $photo["groupKey"] ?>">
			<a href="#"><img src="<?php echo $photo["url"]?>" alt=""></a>
			<h3><?php echo $photo["description"] ?></h3>
			<p><?php echo $photo["group"] ?></p>
		</div>
            <?php endforeach;?>
    </div>
</section>
<!--main-section-end-->

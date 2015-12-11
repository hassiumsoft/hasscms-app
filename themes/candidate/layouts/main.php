<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use hass\base\helpers\Util;
use hass\frontend\widgets\MenuRenderWidget;

$this->theme->publicBundle($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body class="sticky-header-on tablet-sticky-header">
<?php $this->beginBody()?>
<div class="container">
		<header id="header" class="animate-onscroll">

			<!-- Main Header -->
			<div id="main-header">

				<div class="container">

					<div class="row">



						<!-- Logo -->
						<div id="logo" class="col-lg-3 col-md-3 col-sm-3">

							<a href="<?= Yii::$app->getHomeUrl()?>"><img
								src="<?php echo \Yii::$app->get("config")->get("app.logo",$this->theme->getUrl("img/logo.png"))?>"
								alt="Logo"></a>

						</div>
						<!-- /Logo -->



						<!-- Main Quote -->
						<div class="col-lg-5 col-md-4 col-sm-4">

							<blockquote><?php echo \Yii::$app->get("config")->get("app.description")?></blockquote>

						</div>
						<!-- /Main Quote -->



						<!-- Newsletter -->
						<div class="col-lg-4 col-md-5 col-sm-5">

							<div class="yp-header-user-box">
								<div class="yp-header-user">

									<?php if (Yii::$app->getUser()->isGuest):?>

									<div class="user-main">
										<div class="avatar">
											<img width="36" height="36"
												src="http://www.leiphone.com/resWeb/home/images/member/noLogin.jpg"
												alt="">
										</div>
										<span class="nickname">用户</span><span class="arrow"></span>
									</div>
									<div class="user-link">
										<ul>
											<li class="l1"><a
												href="<?php echo Url::to(['/user/security/login'])?>"><i></i>登录</a></li>
											<li class="l2"><a
												href="<?php echo Url::to(['/user/registration/register'])?>"><i></i>注册</a></li>
										</ul>
									</div>
									<?php else:?>
									<div class="user-main user-haslg">
										<div class="avatar">
											<img
												src="<?php echo Yii::$app->getUser()->getIdentity()->getAvatar() ?>"
												alt="">
										</div>
										<span class="nickname"><a
											href="<?php echo Url::to(['/user/profile/show',"id"=>Yii::$app->getUser()->getId()])?>"
											rel="nofollow"><?php echo Yii::$app->getUser()->getIdentity()->username ?></a></span><span
											class="arrow"></span>

									</div>
									<div class="user-link">
										<ul>
											<li class="l3"><a
												href="<?php echo Url::to(['/user/settings/profile'])?>"
												rel="nofollow"><i></i>个人设置</a></li>
											<li class="l4"><a
												href="<?php echo Url::to(['/user/security/logout'])?>"
												rel="nofollow" data-method='post'><i></i>退出</a></li>
										</ul>
									</div>
									<?php endif;?>
								</div>
							</div>

						</div>
						<!-- /Newsletter -->



					</div>

				</div>

			</div>
			<!-- /Main Header -->


			<!-- Lower Header -->
			<div id="lower-header">
				<div class="container">
					<div id="menu-button">
						<div>
							<span></span> <span></span> <span></span>
						</div>
						<span>Menu</span>
					</div>
					<?php echo MenuRenderWidget::widget(["slug"=>"main-menu","options"=>["id"=>"navigation"],'showParentUrl'=>true,'activeCssClass' => 'current-menu-item',"labelTemplate"=>'<span>{label}</span>'])?>
				</div>
			</div>
			<!-- /Lower Header -->


		</header>
		<!-- /Header -->
		<section id="content">
			<?php echo $content;?>
		</section>

		<!-- Footer -->
		<footer id="footer">

			<!-- Main Footer -->

			<!-- Lower Footer -->
			<div id="lower-footer">

				<div class="row">

					<div class="col-lg-4 col-md-4 col-sm-4 animate-onscroll">

						<p class="copyright">Copyright © 2011-2015 www.hassium.org</p>

					</div>

					<div class="col-lg-8 col-md-8 col-sm-8 animate-onscroll">

						<div class="social-media">
							<ul class="social-icons">
								<li class="facebook"><a href="#" class="tooltip-ontop"
									title="Facebook"><i class="icons icon-facebook"></i></a></li>
								<li class="twitter"><a href="#" class="tooltip-ontop"
									title="Twitter"><i class="icons icon-twitter"></i></a></li>
								<li class="google"><a href="#" class="tooltip-ontop"
									title="Google Plus"><i class="icons icon-gplus"></i></a></li>
								<li class="youtube"><a href="#" class="tooltip-ontop"
									title="Youtube"><i class="icons icon-youtube-1"></i></a></li>
								<li class="flickr"><a href="#" class="tooltip-ontop"
									title="Flickr"><i class="icons icon-flickr-4"></i></a></li>
								<li class="email"><a href="#" class="tooltip-ontop"
									title="Email"><i class="icons icon-mail"></i></a></li>
							</ul>
							<ul class="social-buttons">
								<li></li>
								<li>
									<div class="fb-share-button"
										data-href="https://developers.facebook.com/docs/plugins/"
										data-type="button_count"></div>
								</li>

							</ul>
						</div>

					</div>

				</div>

			</div>
			<!-- /Lower Footer -->


		</footer>
		<!-- /Footer -->



		<!-- Back To Top -->
		<a href="#" id="button-to-top"><i class="icons icon-up-dir"></i></a>

	</div>
<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>

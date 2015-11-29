<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
?>

<div class="container">
	<div class="page-header">
		<h1>联系我们</h1>
	</div>
</div>

<section class="main-section contact" id="contact">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-sm-7">
				<div class="contact-info-box address clearfix">
					<h3>
						<i class=" icon-map-marker"></i>Address:
					</h3>
					<span>308 Negra Arroyo Lane<br>Albuquerque, New Mexico, 87111.
					</span>
				</div>
				<div class="contact-info-box phone clearfix">
					<h3>
						<i class="fa fa-phone"></i>Phone:
					</h3>
					<span>1-800-BOO-YAHH</span>
				</div>
				<div class="contact-info-box email clearfix">
					<h3>
						<i class="fa fa-pencil"></i>email:
					</h3>
					<span>hello@knightstudios.com</span>
				</div>
				<div class="contact-info-box hours clearfix">
					<h3>
						<i class="fa fa-clock-o"></i>Hours:
					</h3>
					<span><strong>Monday - Thursday:</strong> 10am - 6pm<br>
					<strong>Friday:</strong> People work on Fridays now?<br>
					<strong>Saturday - Sunday:</strong> Best not to ask.</span>
				</div>
				<ul class="social-link">
					<li class="twitter"><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li class="facebook"><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li class="pinterest"><a href="#"><i class="fa fa-pinterest"></i></a></li>
					<li class="gplus"><a href="#"><i class="fa fa-google-plus"></i></a></li>
					<li class="dribbble"><a href="#"><i class="fa fa-dribbble"></i></a></li>
				</ul>
			</div>
			<div class="col-lg-6 col-sm-5 ">
				<div class="form">
					<input class="input-text" type="text" name="" value="Your Name *"
						onfocus="if(this.value==this.defaultValue)this.value='';"
						onblur="if(this.value=='')this.value=this.defaultValue;"> <input
						class="input-text" type="text" name="" value="Your E-mail *"
						onfocus="if(this.value==this.defaultValue)this.value='';"
						onblur="if(this.value=='')this.value=this.defaultValue;">
					<textarea class="input-text text-area" cols="0" rows="0"
						onfocus="if(this.value==this.defaultValue)this.value='';"
						onblur="if(this.value=='')this.value=this.defaultValue;">Your Message *</textarea>
					<input class="input-btn" type="submit" value="send message">
				</div>
			</div>
		</div>
	</div>
</section>



<section class="business-talking">
	<!--business-talking-start-->
	<div class="container">
		<h2>Let’s Talk Business.</h2>
	</div>
</section>
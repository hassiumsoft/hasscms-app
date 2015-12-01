$(document).ready(function(){

	"use strict";


	/* Global Variables */

	var window_w = $(window).width(); // Window Width
	var window_h = $(window).height(); // Window Height
	var window_s = $(window).scrollTop(); // Window Scroll Top

	var $html = $('html'); // HTML
	var $body = $('body'); // Body
	var $header = $('#header');	// Header
	var $footer = $('#footer');	// Footer



//	$("body").queryLoader2({
//		backgroundColor: '#f2f4f9',
//		barColor: '#63b2f5',
//		barHeight: 4,
//		percentage:false,
//		deepSearch:true,
//		minimumTime:1000,
//		onComplete: function(){
//
//			$('.animate-onscroll').filter(function(index){
//
//				return this.offsetTop < (window_s + window_h);
//
//			}).each(function(index, value){
//
//				var el = $(this);
//				var el_y = $(this).offset().top;
//
//				if((window_s) > el_y){
//					$(el).addClass('animated fadeInDown').removeClass('animate-onscroll');
//					setTimeout(function(){
//						$(el).css('opacity','1').removeClass('animated fadeInDown');
//					},2000);
//				}
//
//			});
//
//		}
//	});


	// On Resize
	$(window).resize(function(){

		window_w = $(window).width();
		window_h = $(window).height();
		window_s = $(window).scrollTop();

	});

	// On Scroll
	$(window).scroll(function(){

		window_s = $(window).scrollTop();

	});


	/* Modernizr Fix */

	var supportPerspective = Modernizr.testAllProps('perspective');
	if(supportPerspective)
		$html.addClass('csstransforms3d');
	else
		$html.addClass('notcsstransforms3d');





	/* Main Functions */


	/* Layout Options */

	enableStickyHeader(); // Sticky Header

	enableFullWidth(); // Full Width Section

	enableTooltips(); // Tooltips

	//enableContentAnimation(); // Content Animation

	//enableSpecialCssEffects(); // CSS Animations

	enableBackToTop(); // Back to top button

	enableMobileNav(); // Mobile Navigation

	enableCustomInput(); // Custom Input Styles



	/* Sliders */

	enableFlexSlider(); // FlexSlider

	enableOwlCarousel(); // Owl Carousel

	enableRevolutionSlider(); // Revolution Slider



	/* Social Media Feeds */

	//enableFlickrFeed(); // Flickr Feed

	//enableInstagramFeed(); // Instagram Feed

	//enableTwitterFeed(); // Twitter Feed



	/* Elements */

	//enableAccordions(); // Accordion

	//enableTabs(); // Tabs

	//enableAlertBoxes(); // Alert Boxes

	//enableProgressbars(); // Progress Bars

	//enableCustomAudio(); // Custom Audio Player

	//enableShoppingCart(); // Shopping Cart

	//enableSocialShare(); // Social Share Buttons




	/* Other Plugins */

	//enableJackBox(); // JackBox Plugin

	//enableCalendar(); // Full Calendar

	//enableStarRating(); // Star Rating

	//enableMixItup(); // MixItUp (Filtering and Sorting)

	//enableProductSlider(); // ClouZoom Products Slider




	/* AJAX forms */

	//enableContactForm(); // AJAX Contact Form

	//enableNewsletterForm(); // AJAX Newsletter Form








	/* ============================== */
	/* 			FUNCTIONS		      */
	/* ============================== */



	/* Sticky Header */
	function enableStickyHeader(){

		var stickyHeader = $body.hasClass('sticky-header-on');

		var resolution = 991;
		if($body.hasClass('tablet-sticky-header'))
			resolution = 767

		if(stickyHeader && window_w > resolution){
			$header.addClass('sticky-header');
			var header_height = $header.innerHeight();
			$body.css('padding-top', header_height+'px');
		}

		$(window).scroll(function(){
			animateHeader();
		});

		$(window).resize(function(){

			animateHeader();

			if(window_w < resolution){

				$header.removeClass('sticky-header').removeClass('animate-header');
				$body.css('padding-top', 0+'px');

			}else{

				$header.addClass('sticky-header');
				var header_height = $header.innerHeight();
				$body.css('padding-top', header_height+'px');

			}

		});

		function animateHeader(){

			if(window_s>100){

				$('#header.sticky-header').addClass('animate-header');

			}else{

				$('#header.sticky-header').removeClass('animate-header');

			}

		}

	}










	function enableFullWidth(){

		// Full Width Elements
		var $fullwidth_el = $('.full-width, .full-width-slider');


		// Set Full Width on resize
		$(window).resize(function(){

			setFullWidth();

		});

		// Fix Full Width at Window Load
		$(window).load(function(){

			setFullWidth();

		});

		// Set Full Width Function
		function setFullWidth(){

			$fullwidth_el.each(function(){

				var element = $(this);

				// Reset Styles
				element.css('margin-left', '');
				element.css('width', '');


				if(!$body.hasClass('boxed-layout')){

					var element_x = element.offset().left;

					// Set New Styles
					element.css('margin-left', -element_x+'px');
					element.css('width', window_w+'px');

				}

			});

		}

	}










	/* Flex Slider */
	function enableFlexSlider(){



		// Main Flexslider
		$('.main-flexslider').flexslider({
			animation: "slide",
			controlNav: false,
			prevText: "",
			nextText: "",
		});




		// Banner Rotator
		$('.banner-rotator-flexslider').flexslider({
			animation: "slide",
			controlNav: true,
			directionNav: false,
			prevText: "",
			nextText: "",
		});



		// Portfolio Slideshow
		$('.portfolio-slideshow').flexslider({
			animation: "fade",
			controlNav: false,
			slideshowSpeed: 4000,
			prevText: "",
			nextText: "",
		});

	}






	/* Revolution Slider */
	function enableRevolutionSlider(){

		/* Revolution Slider */
		$('.tp-banner').not('.full-width-revolution').revolution({
			delay:9000,
			startwidth:1170,
			startheight:500,
			hideThumbs:10,
			navigationType:"none"
		});

		/* Revolution Slider Fullwidth */
		$('.tp-banner.full-width-revolution').revolution({
			delay:9000,
			startwidth:1170,
			startheight:500,
			hideThumbs:10,
			navigationType:"none",
			fullWidth:"on",
			forceFullWidth:"on"
		});

	}







	/* Owl Carousel */
	function enableOwlCarousel(){

		$('.owl-carousel').each(function(){

			/* Number Of Items */
			var max_items = $(this).attr('data-max-items');
			var tablet_items = max_items;
			if(max_items > 1){
				tablet_items = max_items - 1;
			}
			var mobile_items = 1;


			/* Initialize */
			$(this).owlCarousel({
				items:max_items,
				pagination : false,
				itemsDesktop : [1600,max_items],
				itemsDesktopSmall : [1170,max_items],
				itemsTablet: [991,tablet_items],
				itemsMobile: [767,mobile_items],
				slideSpeed:400
			});


			var owl = $(this).data('owlCarousel');

			// Left Arrow
			$(this).parent().find('.carousel-arrows span.left-arrow').click(function(e){
				owl.prev();
			});

			// Right Arrow
			$(this).parent().find('.carousel-arrows span.right-arrow').click(function(e){
				owl.next();
			});

		});


	}





	/* Tooltips */
	function enableTooltips(){

		// Tooltip on TOP
		$('.tooltip-ontop').tooltip({
			placement: 'top'
		});

		// Tooltip on BOTTOM
		$('.tooltip-onbottom').tooltip({
			placement: 'bottom'
		});

		// Tooltip on LEFT
		$('.tooltip-onleft').tooltip({
			placement: 'left'
		});

		// Tooltip on RIGHT
		$('.tooltip-onright').tooltip({
			placement: 'right'
		});

	}





	/* Flickr Feed */
	function enableFlickrFeed(){

		$('.flickr-feed').jflickrfeed({
			limit: 6,
			qstrings: {
				id: '76745153@N04'
			},
			itemTemplate:
			'<li>' +
				'<a href="{{link}}" target="_blank"><img src="{{image_s}}" alt="{{title}}" /></a>' +
			'</li>'
		});

	}







	/* Instagram Feed */
	function enableInstagramFeed(){

		if($('#instagram-feed').length){
			var instagram_feed = new Instafeed({
				get: 'popular',
				clientId: '0ce2a8c0d92248cab8d2a9d024f7f3ca',
				target: 'instagram-feed',
				template: '<li><a target="_blank" href="{{link}}"><img src="{{image}}" /></a></li>',
				resolution: 'standard_resolution',
				limit: 6
			});
			instagram_feed.run();
		}

	}








	/* Twitter Feed */
	function enableTwitterFeed(){

		/* Twitter WIdget */
		$('.twitter-widget').tweet({
			modpath: 'php/twitter/',
			count: 1,
			loading_text: 'Loading twitter feed...',
		})

		/* Twitter Share Button */
		!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

	}







	/* Content Animation */
	function enableContentAnimation(){

		if($html.hasClass('cssanimations')){

			$('.animate-onscroll').animate({opacity:0},0);


			$(window).load(function(){

				$('.animate-onscroll').filter(function(index){

					return this.offsetTop < (window_s + window_h);

				}).each(function(index, value){

					var el = $(this);
					var el_y = $(this).offset().top;

					if((window_s) > el_y){
						$(el).addClass('animated fadeInDown').removeClass('animate-onscroll').removeClass('animated fadeInDown');
					}

				});

				animateOnScroll();

			});

			$(window).resize(function(){
				animateOnScroll();
			});

			$(window).scroll(function(){
				animateOnScroll();
			});

		}

		// Start Animation When Element is scrolled
		function animateOnScroll(){

			$('.animate-onscroll').filter(function(index){

				return this.offsetTop < (window_s + window_h);

			}).each(function(index, value){

				var el = $(this);
				var el_y = $(this).offset().top;

				if((window_s + window_h) > el_y){

					setTimeout(function(){

						$(el).addClass('animated fadeInDown');

						setTimeout(function(){
							$(el).removeClass('animate-onscroll');
						}, 500);

						setTimeout(function(){
							$(el).css('opacity','1').removeClass('animated fadeInDown');
						},2000);

					},index*200);

				}

			});

		}

	}







	/* Special CSS Effects */
	function enableSpecialCssEffects(){

		/* Sidebar Banner Hover Effect */
		$('.banner').each(function(){

			var new_icon = $(this).find('.icons').clone().addClass('icons-fadeout');
			$(this).prepend($(new_icon));

		});


		/* Firefox Pricing Tables Height Fix */
		$(window).load(function(){
			fixPricingTables();
		});

		$(window).resize(function(){
			fixPricingTables();
		});

		/* Fix Pricing Tables */
		function fixPricingTables(){

			$('.pricing-tables').each(function(){

				$(this).find('.pricing-table').attr('style', '');

				if(window_w > 767){
					var pricing_tables_h = $(this).height();
					$(this).find('.pricing-table').innerHeight(pricing_tables_h);
				}

			});

		}



		/* Sorting Float Fix */

		$(window).load(function(){
			mediaSortFix();
		});

		$(window).resize(function(){
			mediaSortFix();
		});

		function mediaSortFix(){
			if(window_w > 767){
				var media_item_height = 0;
				$('.media-items .mix').css('height','');

				$('.media-items .mix').each(function(){
					if($(this).height() > media_item_height)
						media_item_height = $(this).height();
				});
				$('.media-items .mix').height(media_item_height);
			}else{
				$('.media-items .mix').css('height','');
			}
		}

	}







	/* Back To Top Button */
	function enableBackToTop(){

		$('#button-to-top').hide();

		/* Show/Hide button */
		$(window).scroll(function(){

			if(window_s > 100 && window_w > 991){
				$('#button-to-top').fadeIn(300);
			}else{
				$('#button-to-top').fadeOut(300);
			}

		});

		$('#button-to-top').click(function(e){

			e.preventDefault();
			$('body,html').animate({scrollTop:0}, 600);

		});

	}






	/* Mobile Navigation */
	function enableMobileNav(){

		/* Menu Button */
		$('#menu-button').click(function(){

			if(!$('#navigation').hasClass('navigation-opened')){

				$('#navigation').slideDown(500).addClass('navigation-opened');

			}else{

				$('#navigation').slideUp(500).removeClass('navigation-opened');

			}

		});


		/* On Resize */
		$(window).resize(function(){

			if(window_w > 991){

				$('#navigation').show().attr('style','').removeClass('navigation-opened');

			}

		});


		/* Dropdowns */
		$('#navigation li').each(function(){

			if($(this).find('ul').length > 0){
				$(this).append('<div class="dropdown-button"></div>');
			}

		});

		$('#navigation .dropdown-button').click(function(){

			$(this).parent().toggleClass('dropdown-opened').find('>ul').slideToggle(300);

		});


	}








	/* Custom Input Styles */
	function enableCustomInput(){

		/* Chosen Select Box */
		var config = {
		  '.chosen-select'             : {disable_search_threshold:10, width:'100%'}
		}
		for (var selector in config) {

		  $(selector).chosen(config[selector]);

		}


		/* Numeric Input */
		$('.numeric-input').each(function(){

			$(this).wrap('<div class="numeric-input-holder"></div>');
			$(this).parent().prepend('<div class="decrease-button"></div>');
			$(this).parent().append('<div class="increase-button"></div>');

			// Decrease Button
			$(this).parent().find('.decrease-button').click(function(){

				var value = parseInt($(this).parent().find('.numeric-input').val());
				value--;
				$(this).parent().find('.numeric-input').val(value);

			});

			// Increase Button
			$(this).parent().find('.increase-button').click(function(){

				var value = parseInt($(this).parent().find('.numeric-input').val());
				value++;
				$(this).parent().find('.numeric-input').val(value);

			});

			// Prevent Not A Number(NaN) Value
			$(this).keypress(function(e){

				var value = parseInt(String.fromCharCode(e.which));
				if(isNaN(value)){
					e.preventDefault();
				}

			});

		});

	}







	/* JackBox Plugin */
	function enableJackBox(){

		$(window).load(function(){

			jQuery(".jackbox[data-group]").jackBox("init", {
				deepLinking: false
			});

		});

	}









	/* Accordions */
	function enableAccordions(){

		$('.accordions').each(function(){

			// Set First Accordion As Active
			$(this).find('.accordion-content').hide();
			if(!$(this).hasClass('toggles')){
				$(this).find('.accordion:first-child').addClass('accordion-active');
				$(this).find('.accordion:first-child .accordion-content').show();
			}

			// Set Accordion Events
			$(this).find('.accordion-header').click(function(){

				if(!$(this).parent().hasClass('accordion-active')){

					// Close other accordions
					if(!$(this).parent().parent().hasClass('toggles')){
						$(this).parent().parent().find('.accordion-active').removeClass('accordion-active').find('.accordion-content').slideUp(300);
					}

					// Open Accordion
					$(this).parent().addClass('accordion-active');
					$(this).parent().find('.accordion-content').slideDown(300);

				}else{

					// Close Accordion
					$(this).parent().removeClass('accordion-active');
					$(this).parent().find('.accordion-content').slideUp(300);

				}

			});

		});



		/* Link Toggles */
		$('.toggle-link').each(function(){

			var target = $(this).attr('href');
			$(target).hide();

			$(this).click(function(e){

				e.preventDefault();

				var target = $(this).attr('href');
				$(target).slideToggle(300);

			});

		});



		/* Payment Options Accordion */
		$('.payment-options').each(function(){

			$(this).find('.payment-content').hide();
			$(this).find('input[type="radio"]:checked').parent().parent().addClass('active').find('.payment-content').show();

			$(this).find('.payment-header').click(function(){

				if($(this).find('input[type="radio"]').is(':checked')){

					$(this).parent().parent().find('.payment-content').slideUp(300);
					$(this).parent().parent().find('li.active').removeClass('active');
					$(this).parent().addClass('active').find('.payment-content').slideDown(300);

				}

			});

		});


	}






	/* Tabs */
	function enableTabs(){

		$('.tabs').each(function(){

			// Set Active Tab
			$(this).find('.tab').hide();
			$(this).find('.tab:first-child').show();
			$(this).find('.tab-header ul li:first-child').addClass('active-tab');


			// Prevent Default
			$(this).find('.tab-header li a').click(function(e){
				e.preventDefault();
			});


			// Tab Navigation
			$(this).find('.tab-header li').click(function(){

				var target = $(this).find('a').attr('href');

				$(this).parent().parent().parent().find('.tab').fadeOut(200);
				$(this).parent().parent().parent().find(target).delay(200).fadeIn(200);

				$(this).parent().find('.active-tab').removeClass('active-tab');
				$(this).addClass('active-tab');


			});


		});

	}








	/* Alert Boxes */
	function enableAlertBoxes(){

		$('.alert-box .icons').click(function(){

			$(this).parent().slideUp(300, function(){

				$(this).remove();

			});

		});

	}










	/* Progressbars */
	function enableProgressbars(){

		$('.progressbar').each(function(){
			$(this).attr('data-current', 0);
		});

		$(window).load(function(){

			animateProgressBars();

		});

		$(window).scroll(function(){

			animateProgressBars();

		});


		/* Animate Progress BArs */
		function animateProgressBars(){

			var pr_offset = window_h/8;

			$('.progressbar').each(function(){

				var bar = $(this);
				var bar_y = $(bar).offset().top;

				if((bar_y < (window_s + window_h - pr_offset))){

					barStartAnimation(bar);

				}

			});


			/* Bar FillIn Animation */
			function barStartAnimation(el){

				var bar = el;
				var bar_progress = el.find('.progress-width');
				var bar_percent = el.find('.progress-percent');

				$(bar).addClass('progressbar-animating').addClass('progessbar-start');
				$(bar_percent).fadeIn(200);
				var percent = parseInt($(bar).attr('data-percent'));

				var animationDuration = 2000;
				var intervalDuration = animationDuration / percent;

				var barInterval = setInterval(function(){

					var current = $(bar).attr('data-current');

					if(current <= percent){

						$(bar_progress).css('width', current+'%');
						$(bar_percent).text(current+'%');
						current++;
						$(bar).attr('data-current', current);

					}else{

						clearInterval(barInterval);
						$(bar).removeClass('progessbar-start');

					}

				}, intervalDuration);

			}

		}

	}










	// Custom Audio Player
	function enableCustomAudio(){

		$('audio').each(function(){

			/* Setup Audio Player */
			$(this).wrap('<div class="audio-player"></div>');
			$(this).parent().append('<div class="audio-play-button"></div>'); // Play Button
			$(this).parent().append('<div class="audio-current-time">00:00</div>'); // Current Time
			$(this).parent().append('<div class="audio-progress" data-mousedown=""><div class="audio-progress-wrapper"><div class="audio-buffer-bar"></div><div class="audio-progress-bar"></div></div></div>'); // Progress bar
			$(this).parent().append('<div class="audio-time">00:00</div>'); // Time
			$(this).parent().append('<div class="audio-volume"><div class="volume-bar"><div class="audio-volume-progress"></div></div></div>'); // Volume


			/* Set Volume */
			var audio_volume = 0.5;
			$(this)[0].volume = audio_volume;
			$(this).parent().find('.audio-volume-progress').css('width', (audio_volume*100)+'%');


			/* Initialize */
			$(this).bind('canplay', function(){

				/* Set Track Time */
				var audio_length = Math.floor($(this)[0].duration);
				var audio_length_m = Math.floor(audio_length/60);
				var audio_length_s = Math.floor(audio_length%60);

				if(audio_length_m < 10){
					audio_length_m = '0'+audio_length_m;
				}

				if(audio_length_s < 10){
					audio_length_s = '0'+audio_length_s;
				}

				audio_length = audio_length_m + ':' + audio_length_s;
				$(this).parent().find('.audio-time').text(audio_length);

			});



			/* Play/Pause Button */
			$(this).parent().find('.audio-play-button').click(function(){

				if($(this).hasClass('pause')){

					$(this).removeClass('pause');
					$(this).parent().find('audio')[0].pause();

				}else{

					$(this).addClass('pause');
					$(this).parent().find('audio')[0].play();

				}

			});




			/* Progress Bar */
			$(this).bind('timeupdate', function(){

				var audio = $(this)[0];
				var progress_bar = $(this).parent().find('.audio-progress-bar');
				var track_current = $(this).parent().find('.audio-current-time');

				var audio_length = audio.duration;
				var audio_current = audio.currentTime

				/* Progress bar */
				var progress = (audio_current / audio_length)*100;
				$(progress_bar).css('width', progress+'%');

				/* Current Time */
				var audio_current_m = Math.floor(audio_current/60);
				var audio_current_s = Math.floor(audio_current%60);

				if(audio_current_m < 10){
					audio_current_m = '0'+audio_current_m;
				}

				if(audio_current_s < 10){
					audio_current_s = '0'+audio_current_s;
				}

				audio_current = audio_current_m + ':' + audio_current_s;
				$(this).parent().find('.audio-current-time').text(audio_current);

			});


			/* Progress Change */
			$('.audio-progress-wrapper').mousedown(function(e){

				$(this).attr('data-mousedown', 'true');

				var audio_x = $(this).offset().left;
				var audio_w = $(this).width();
				var mouse_x = e.pageX;

				var progress = (mouse_x - audio_x) / audio_w * 100;

				var track_length = $(this).parent().parent().find('audio')[0].duration;
				var update_time = track_length / (100 / progress);

				$(this).parent().parent().find('audio')[0].currentTime = update_time;

			});

			$(document).mouseup(function(){

				$('.audio-progress-wrapper').attr('data-mousedown', '');
				$('.volume-bar').attr('data-mousedown', '');

			});

			$('.audio-progress-wrapper').mousemove(function(e){

				if($(this).attr('data-mousedown') == 'true'){

					var audio_x = $(this).offset().left;
					var audio_w = $(this).width();
					var mouse_x = e.pageX;

					var progress = (mouse_x - audio_x) / audio_w * 100;

					var track_length = $(this).parent().parent().find('audio')[0].duration;
					var update_time = track_length / (100 / progress);

					$(this).parent().parent().find('audio')[0].currentTime = update_time;

				}

			});





			/* Buffering Bar */
			$(this).bind('progress', function(){

			});




			/* Volume Bar */
			$(this).bind('volumechange', function(){

				var audio = $(this)[0];
				var volume_bar = $(this).parent().find('.audio-volume-progress');
				var audio_volume = audio.volume;

				/* Volume Progress bar */
				var progress = audio_volume*100;
				$(volume_bar).css('width', progress+'%');

				if(audio_volume >= 0.5){
					$(volume_bar).parent().parent().removeClass('volume-down').removeClass('volume-off');
				}

				if(audio_volume < 0.5){
					$(volume_bar).parent().parent().addClass('volume-down').removeClass('volume-off');
				}

				if(audio_volume == 0){
					$(volume_bar).parent().parent().addClass('volume-off');
				}

			});

			$('.volume-bar').mousedown(function(e){

				$(this).attr('data-mousedown', 'true');

				var audio_x = $(this).offset().left;
				var audio_w = $(this).width();
				var mouse_x = e.pageX;

				var update_volume = (mouse_x - audio_x) / audio_w;
				$(this).parent().parent().find('audio')[0].volume = update_volume;

			});

			$('.volume-bar').mousemove(function(e){

				if($(this).attr('data-mousedown') == 'true'){

					var audio_x = $(this).offset().left;
					var audio_w = $(this).width();
					var mouse_x = e.pageX;

					var update_volume = (mouse_x - audio_x) / audio_w;
					$(this).parent().parent().find('audio')[0].volume = update_volume;

				}

			});



		});

	}










	/* Full Calendar */
	function enableCalendar(){

		/* Sidebar Calendar */
		$('.sidebar-calendar').responsiveCalendar({
			events: {
				"2014-03-03": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
				"2014-03-05": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
				"2014-03-08": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
				"2014-03-12": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
				"2014-03-18": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
				"2014-03-22": {"number": 1, "class": "calendar-event", "url": "event-post-v1.php"},
			}
		});

	}









	/* MixItUp (Filtering and Sorting) */
	function enableMixItup(){

		// Mix It Up
		$('.media-items').mixItUp();
		$('.shop-items').mixItUp();



		/* Filtering Dropdown */
		$('.filter-dropdown>li').click(function(){

			$(this).parent().toggleClass('opened');

		});
		$('.filter-dropdown ul li').click(function(){

			var value = $(this).text();
			$(this).parent().find('.active-filter').removeClass('active-filter');
			$(this).addClass('active-filter');
			$(this).parent().parent().find('>span').text(value);

		});


		/* Sorting Options */
		$('.order-group>button:last-child').hide();
		$('.order-group.ascending-sort>button:first-child').hide();
		$('.order-group.ascending-sort>button:last-child').show();
		$('.order-group.descending-sort>button:last-child').hide();
		$('.order-group.descending-sort>button:first-child').show();

		$('.filter-sorting button').click(function(){

			if(!$(this).parent().hasClass('active-sort')){

				$(this).parent().parent().find('.active-sort').removeClass('active-sort');

				$(this).parent().addClass('active-sort');

			}

			$(this).hide();
			$(this).parent().find('button').not($(this)).show();

		});

	}










	/* Start Rating */
	function enableStarRating(){

		// Read Only Rating
		$('.shop-rating.read-only').raty({
			readOnly: true,
			path:'img/rating',
			score: function() {
				return $(this).attr('data-score');
			}
		 });

		 // Rate Only Rating
		$('.shop-rating.rate-only').raty({
			readOnly: false,
			path:'img/rating',
			score: function() {
				return $(this).attr('data-score');
			}
		 });

		 // Read Only Rating Small
		$('.shop-rating.read-only-small').raty({
			readOnly: true,
			path:'img/rating/small',
			score: function() {
				return $(this).attr('data-score');
			}
		 });

	}







	/* Shopping Cart */
	function enableShoppingCart(){

		$('.shopping-cart-table .remove-shopping-item').click(function(){

			$(this).parent().parent().fadeOut(300, function(){
				$(this).remove();
			});

		});


		$('.shopping-cart-dropdown .remove-shopping-item').click(function(){

			$(this).parent().parent().parent().fadeOut(300, function(){
				$(this).remove();
			});

		});

	}



	/* Social Share Buttons */
	function enableSocialShare(){

		$('.social-share').each(function(){

			var page_url = encodeURIComponent(document.URL);

			$(this).find('.facebook>a').attr('href', 'http://www.facebook.com/sharer/sharer.php?u='+page_url).attr('target','_blank');
			$(this).find('.twitter>a').attr('href', 'https://twitter.com/home?status='+page_url).attr('target','_blank');
			$(this).find('.google>a').attr('href', 'https://plus.google.com/share?url='+page_url).attr('target','_blank');
			$(this).find('.pinterest>a').attr('href', 'http://pinterest.com/pin/create/button/?url='+page_url).attr('target','_blank');

		});

	}







	/* AJAX Contact Form */
	function enableContactForm(){

		$('#contact-form>*').wrap('<div class="form-content"></div>');
		$('#contact-form').append('<div class="form-report"></div>');

		$('#contact-form').submit(function(e){

			e.preventDefault();

			var form = $(this);
			var action = $(this).attr('action');
			var data = $(this).serialize();

			$.ajax({
				type: "POST",
				url: action,
				data: data,
				beforeSend: function(){
					form.css('opacity', '0.5');
				},
				success: function(data){

					// Display returned data
					form.css('opacity', '1');
					form.find('.form-report').html(data);

					// Hide Form on Success
					if (data.indexOf('class="success"') >= 0){
						form.find('.form-content').slideUp(300);
					}

				}
			});

		});

	}




	/* AJAX Newsletter Form */
	function enableNewsletterForm(){

		$('#newsletter>*').wrap('<div class="form-content"></div>');
		$('#newsletter').append('<div class="form-report"></div>');


		$('#newsletter').submit(function(e){

			e.preventDefault();

			$('#newsletter .newsletter-email input').tooltip('destroy');
			$('#newsletter .newsletter-zip input').tooltip('destroy');

			var form = $(this);
			var action = $(this).attr('action');
			var data = $(this).serialize();

			var error = false;
			var email_val = form.find('.newsletter-email input').val();
			var zip_val = form.find('.newsletter-zip input').val();

			if(email_val == '' || email_val == ' '){

				error = true;
				form.find('.newsletter-email input').tooltip({title:'Required', trigger: 'manual'});
				form.find('.newsletter-email input').tooltip('show');

			}else{

				var email_re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

				if(!email_re.test(email_val)){
					error = true;
					form.find('.newsletter-email input').tooltip({title:'Email not valid', trigger: 'manual'});
					form.find('.newsletter-email input').tooltip('show');

				}else{
					form.find('.newsletter-email input').tooltip('hide');
				}

			}

			if(zip_val == '' || zip_val == ' '){

				error = true;
				form.find('.newsletter-zip input').tooltip({title:'Required', trigger: 'manual'});
				form.find('.newsletter-zip input').tooltip('show');

			}else{
				form.find('.newsletter-zip input').tooltip('hide');
			}


			if(!error){
				$.ajax({
					type: "POST",
					url: action,
					data: data,
					beforeSend: function(){
						form.css('opacity', '0.5');
					},
					success: function(data){

						// Display returned data
						form.css('opacity', '1');
						form.find('.form-report').html(data);

						// Hide Form on Success
						if (data.indexOf('class="success"') >= 0){
							form.find('.form-content').slideUp(300);
						}
					}
				});
			}

		});

	}






	/* ClouZoom Products Slider */
	function enableProductSlider(){

		if($('.shop-product-gallery').length > 0){

			var current_img = $('.shop-product-gallery .main-image img').attr('src');
			$('.shop-product-gallery .slider-navigation li').find('a[href="'+current_img+'"]').parent().addClass('active');

		}

		/* Slider Navigation */
		$('.shop-product-gallery .slider-navigation li').click(function(e){

			var image = $(this).find('a').attr('href');
			$(this).parent().find('.active').removeClass('active');
			$(this).addClass('active');

			$('.shop-product-gallery .main-image img').animate({opacity:0},300,function(){
				$(this).attr('src',image).animate({opacity:1}, 300);
			});

		});


		/* JackBox */
		$('.shop-product-gallery .main-image .fullscreen-icon').click(function(){

			var image = $(this).parent().find('>img').attr('src');
			$('.shop-product-gallery .slider-navigation li').find('a[href="'+image+'"]').trigger('click');

		});


		/* Cloud Zoom */
		$(".cloud-zoom-image").imagezoomsl({
			zoomrange: [3, 3]
		});

		$('.tracker').click(function(){
			alrt('a');
		});


	}





});

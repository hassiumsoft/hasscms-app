/*
 *	全局部分
 */

/*
 *	公用模块(顶部、尾部、右侧栏、左侧文章列表)
 */

//---------------------------------
// 1.全局变量----------------------
//---------------------------------

//---------------------------------
// 1.顶部模块----------------------
//---------------------------------
var lphHeader = function() {

	// 顶部fixed
	$(window).scroll(function() {
		if ($(this).scrollTop() >= 85) {
			$(".header-nav.nav-static").css("visibility", "hidden");
			$(".header-nav.nav-fixed").css("display", "block");
		} else {
			$(".header-nav.nav-static").css("visibility", "visible");
			$(".header-nav.nav-fixed").css("display", "none");
		}
	});
	
	(function($) {
		var menu = $('.header-nav');
		var liAttr = [];
		if (menu.length > 0) {
			menu.each(function() {
				if (!$(this).is(':hidden')) {
					var list = $(this).find('ul:not(".news-menu")>li');
					list.each(function(i, li) {
						var l = $(li).position().left + $(li).width() / 2 - 10
								/ 2 - 1;
						liAttr.push(l);
					});
				}
			});
			menu.each(function() {
				var ul = $(this).find('ul:not(".news-menu")');
				var arrow = $(this).find('.arrow');
				var menuList = ul.children('li');
				var activeIndex = ul.children('li.active').index();
				var duration = 250;
				activeIndex = activeIndex == -1 ? 0 : activeIndex;
				arrow.css({
					'left' : liAttr[activeIndex],
					'display' : 'block'
				});
				$(this).on('mouseenter', 'ul:not(".news-menu")>li', function() {
					var l = liAttr[$(this).index()];
					arrow.stop().animate({
						left : l
					}, duration);
				}).on('mouseleave', function() {
					arrow.stop().animate({
						left : liAttr[activeIndex]
					}, duration);
				});
			});

			menu.each(function() {
				var ej = $(this).find('.has-children');
				ej.hover(function() {
					clearTimeout(this.t);
					$(this).addClass('ej-hover');
				}, function() {
					var self = this;
					self.t = setTimeout(function() {
						$(self).removeClass('ej-hover');
					}, 100);
				});
			});
		}
	})(jQuery);

};
lphHeader();

// ---------------------------------
// 2.左侧模块----------------------
// ---------------------------------
var lphLeft = function() {

};
lphLeft();

// ---------------------------------
// 3.右侧模块----------------------
// ---------------------------------
var lphRight = function() {
	var rightKxLis = $(".right .kuaixun .kx-ul li");
	rightKxLis.mouseenter(function(e){
		rightKxLis.removeClass("hov");
		$(this).addClass("hov");
	});
};
lphRight();

// ---------------------------------
// 4.尾部模块----------------------
// ---------------------------------
var lphFooter = function() {
	// 上下滚动块
	var footerGotoBtns = $("#footer-gotoBar a"), docHig = $('body')
			.height(), winHig = $(window).height(), ajustTop = 50;
	footerGotoBtns.click(function() {
		gotoPosition($(this).attr("data-goto"));
	});

	$(window).scroll(function() {

		if ($(window).scrollTop() > 200) {
			$(".gotoBar .top").css("display", "block").fadeIn(400);
		} else {
			$(".gotoBar .top").css("display", "none");
		}
	});

	function gotoPosition(jqObj) {
		var count = 0;
		if (!isNaN(jqObj)) {
			count = jqObj;
		} else {
			count = $(jqObj).offset().top - 50;
		}
		$("html, body").animate({
			scrollTop : count
		}, {
			duration : 400,
			easing : 'linear'
		});
	}
};
$(function() {
	lphFooter();
});

$(window).trigger("scroll");

function getCookie(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=");
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(";", c_start);
			if (c_end == -1)
				c_end = document.cookie.length;
			return unescape(document.cookie.substring(c_start, c_end));
		}
	}
	return "";
}
function setCookie(c_name, value, expiredays) {
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + expiredays);
	document.cookie = c_name + "=" + escape(value)
			+ ((expiredays == null) ? "" : ";expires=" + exdate.toGMTString());
}

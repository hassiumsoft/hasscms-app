$(function() {

	$('#basicsettingform-appbackendtheme').change(function() {

		var skinName = $(this).val();
		$('body').removeClass();
		$('body').addClass(skinName + " sidebar-mini");

	});

});
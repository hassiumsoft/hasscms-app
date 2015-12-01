$(function() {
	var body = $('body');
	body.on('click', '.move-up, .move-down', function(event) {
		event.preventDefault();
		event.stopImmediatePropagation();
		
		var button = $(this).addClass('disabled');
		$.getJSON(button.attr('href'), function(response) {
			button.removeClass('disabled');
			if (response.status) {
				notify.success(response.content);
				if(response.swap_id)
				{
					var current = button.closest('tr');
					var swap = $('tr[data-key=' + response.swap_id + ']', current
							.parent());

					if (swap.get(0)) {
						if (button.hasClass('move-up')) {
							swap.before(current);
						} else {
							swap.after(current);
						}
					} else {
						location.reload();
					}
				}
			} else {
				alert(response.content);
			}
		});
		return false;
	});

});
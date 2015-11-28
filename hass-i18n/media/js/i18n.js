$(document).ready(function() {

    $(".btn-translation-copy-from-source").click(function() {
        var $element = $(this);
        var $row = $element.closest('tr'),
            $textarea = $row.find('.tab-pane.active input:text'),
            sourceMessage = $row.find('.source-message .source-message-content').text();

        if (sourceMessage) {
            $textarea.val(sourceMessage.replace(/@@/g, '')).focus();
        }
    });


    $(".btn-translation-save").click(function() {

        var $element = $(this);
        var $row = $element.closest('tr'),
            $form = $row.find('form.translation-save-form'),
            url = $element.data('url');
	    	$.ajax({
				type : "POST",
				url : url,
				data :$form.serialize(),
				success : function(msg) {
					if (msg.status == true) {
						notify.success(msg.content);
					} else {
						notify.error(msg.content);
					}
				}
			});
        
    });
});

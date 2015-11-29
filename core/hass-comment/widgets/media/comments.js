var displayFormDuration = 300;

$(document).ready(function() {
	//添加回复框..这个该用js处理
	$(document).on('click', '.reply-button', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();
		var replyForm = $(this).parent().next('.reply-form');
		$.post(replyFormUrl, {
			parent_id: $(this).attr('data-parent-id'),
			entity: $(this).attr('data-entity'),
			entity_id: $(this).attr('data-entity-id')
		}).done(function(msg) {
			if (msg.status == true) {
				$('.reply-form').not(replyForm).hide(displayFormDuration);
				replyForm.show(displayFormDuration);
				replyForm.hide().html(msg.content).show(displayFormDuration);
			}
		});
		return false;
	});

	/**
	 * ajax发布评论
	 */
	$(document).on("submit", '.comment-form', function(e) {
		e.preventDefault();
		e.stopImmediatePropagation();

		var commentForm = $(this);
		var data = $(this).serializeArray()
		var isReply = false;
		
		if (commentForm.parent(".reply-form").length > 0) {
			data.push({
						"name":"nestedLevel",
						"value":commentForm.parent(".reply-form").attr("data-nestedLevel")
					});
			isReply = true;
		}
		$.ajax({
			type: "POST",
			url: commentUrl,
			data: data,
			success: function(msg) {
				if (msg.status == true) {
					commentForm.find("textarea").val("");
					if (isReply == false) {
						var content = $(msg.content)
						$("#comment-list").prepend(content);
						content.hide().show(displayFormDuration);
					} else if (isReply == true) {
						commentForm.hide(displayFormDuration)
						var content = $(msg.content)
						commentForm.parent(".reply-form").after(content);
						content.hide().show(displayFormDuration);
					}
				} else {
					alert(msg.content.split("=_=")[0]);
				}
			}
		});

		return false;
	})

	/**
	 * 显示主评论框下的作者和回复按钮
	 */
	$('#comment-form .comment-form-content').on('click', function(event) {
		event.preventDefault();
		$(this).next('.comment-form-footer').show(displayFormDuration);
		$('.reply-form').hide(displayFormDuration);
	});

	/**
	 * 隐藏回复表单
	 */
	$(document).on('click', '.reply-cancel', function() {
		$(this).closest('.reply-form').hide(displayFormDuration);
	});

});
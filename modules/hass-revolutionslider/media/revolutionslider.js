$(document).ready(function() {
	  $('#addCaption').click(function(event) {
	        event.preventDefault();
	        event.stopImmediatePropagation();

	        var url = $(this).data("url");
	       
	        
	        var index = $(".delCaption").last().data("id");
	        
	        if(!index)
        	{
        		index = 0;
        	}
	        
	        $.ajax({
	            type: "POST",
	            url: url,
	            data: {
	            	index:index+1
	            },
	            success: function(msg) {
	                if (msg.status == true) {
	                		$("#caption-list").append(msg.content);
	                } else {
	                    console.log(msg);
	                    //alert(msg.error);
	                }
	            }
	        });
	        return false;
	    });
	  $(document).on("click",".delCaption",function(){//修改成这样的写法
		   var id = $(this).data("id");
		   $("#caption_"+id).remove();
	  });

	  
});

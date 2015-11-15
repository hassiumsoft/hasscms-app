$(document).ready(function() {
	var menuTemplate = function(menu,index)
	{
		var output = "";
		output += '<div class="box box-default box-solid flat collapsed-box" ><div class="box-header with-border"><h5 class="box-title">';
		output += menu.name;
		output +='</h5><div class="box-tools pull-right"><span class="text-muted small ">';
		output += menu.moduleName;
		output += '</span> <button class="btn btn-box-tool" data-widget="collapse">  <i class="fa fa-plus"></i></button></div></div>';
		output += '<div class="box-body"><div class="form-group"><label for="exampleInputEmail1">导航标签</label> ';
		output +=  '<input name="menu-item['+index+'][name]" type="text" class="form-control" value="'+menu.name+'" />';
		output +='</div><div class="form-group"><label for="exampleInputEmail1">标题属性</label>';
		output +=  '<input name="menu-item['+index+'][title]" type="text" class="form-control" value="'+menu.title+'" />';
		output += "</div>"
		       
	
		if(menu.islink)
		{
			output += '<div class="form-group">';
			output += '<label for="exampleInputEmail1">URL</label>';  
			output += '<input name="menu-item['+index+'][original]" type="text" class="form-control" value="'+menu.original+'" />';
			output += "</div>"
		}
		else
		{
			output += '<input name="menu-item['+index+'][original]" type="hidden" class="form-control" value="'+menu.original+'" />';
		}
		
		output +='<p class="link-to-original">';
		output +='Url：<a href="'+menu.url+'">'+menu.name+'</a>';
	
		output +='</p>';
		output += '<input name="menu-item['+index+'][originalName]" type="hidden" class="form-control" value="'+menu.originalName+'" />';
		output += '<input name="menu-item['+index+'][module]" type="hidden" class="form-control" value="'+menu.module+'" />';
		
		output +=  ' <button class="btn btn-box-tool btn-xs delete-box"  ><i class="fa fa-trash"></i> 删除</button>';
		output +=  ' <button class="btn btn-box-tool btn-xs docollapse-box" ><i class="fa fa-arrow-circle-up"></i> 取消</button>';
		output +=  '</div></div>';

		 
		if(menu.children.length>0)
		{
			output +=  '<ol>';
			menu.children.forEach(function(item){
				index++;
				output+='<li id="menu-item-'+index+'">';
				output +=menuTemplate(item,index);
				output+='</li>';
			});
			output +=  '</ol>';
		}
		return output;
	}
	
	//获取当前菜单下所有子菜单...
	$.ajax({
		type : "GET",
		url : getmenusUrl,
		success : function(msg) {

			if (msg.status == true) {
				
				var index = $(".sortable").find("li").length+1;//避免ID为0
				var output = "";
				msg.content.forEach(function(menu){
					output+='<li id="menu-item-'+index+'">';
					output +=menuTemplate(menu,index);
					output+='</li>';
					index +=menu.children.length+1;
				});
				$(".sortable").append(output);
			} else {
				console.log(msg);
				//alert(msg.error);
			}
		}
	});
	
	$("form.menu-item-form").submit(function(event) {
		event.preventDefault();
		event.stopImmediatePropagation();
		var data;
		if ($(this).hasClass("module-form")) {
			data = $(this).find("input:checked" ).parent().children("input").serializeArray();
			var module = $(this).find("input[name=module]").serializeArray();
			data.push(module[0]);
		} else {
			data = $(this).serializeArray()
		}

		var url = $(this).attr("action");
		
		 form = $(this)[0];
		
		$.ajax({
			type : "POST",
			url : url,
			data : data,
			success : function(msg) {
				if (msg.status == true) {
					form.reset();
					var index = $(".sortable").find("li").length+1;//避免ID为0
					var output = "";
					msg.content.forEach(function(menu){
						output+='<li id="menu-item-'+index+'">';
						output +=menuTemplate(menu,index);
						output+='</li>';
						index +=menu.children.length+1;
					});
					$(".sortable").append(output);
				} else {
					console.log(msg);
					//alert(msg.content);
				}
			}
		});

		return false;
	})

	$("#save-menu-form .box-body").on("click", ".delete-box", function() {
		$(this).closest("li").remove();
	});
	
	$("#save-menu-form .box-body").on("click", ".docollapse-box", function() {
		var box = $(this).parents(".box").first();
		$.AdminLTE.boxWidget.collapse(box.find('[data-widget="collapse"]'));
		event.preventDefault();
		event.stopImmediatePropagation();
		return false;
	});
	
	

	$(".select-all").on("click",function() {
		var box = $(this).parents(".box").first();
		var selectall = box.data("selectall");
	
		if(selectall == true)
		{
			box.find("input:checkbox").prop("checked",false);  
			box.data("selectall",false);
		}
		else
		{
			box.find("input:checkbox").prop("checked",true);  
			box.data("selectall",true);
		}
	});
	
	//$(".select-all").click();

	
	function initMenu(e)
	{
		var item = {};
		var index = e.item_id;
	
		
		//console.log("-------start "+index+"--------");
		
		item.name = $("#save-menu-form input[name='menu-item["+index+"][name]']").val();
		item.originalName = $("#save-menu-form input[name='menu-item["+index+"][originalName]']").val();
		item.title =$("#save-menu-form input[name='menu-item["+index+"][title]']").val();
		item.module=$("#save-menu-form input[name='menu-item["+index+"][module]']").val();
		item.original =$("#save-menu-form input[name='menu-item["+index+"][original]']").val();
		item.lft = e.left;
		item.rgt = e.right;
		item.depth = e.depth;
		
		
//		item.children = [];
//		if(e.children)
//		{
//			e.children.forEach(function(v){
//				item.children.push(initMenu(v));
//			});
//		}
		//console.log(item);
		//console.log("-------end "+index+"--------");
		return item;
	}
	
	
	$('#save-menu-form').submit(function(event){
		
		event.preventDefault();
		event.stopImmediatePropagation();
		var temp = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
		var data = [];
		temp.shift()		
		temp.forEach(function(e){
			data.push(initMenu(e));
		})
	
		var url = $(this).attr("action");
		
		$.ajax({
			type : "POST",
			url : url,
			data : {"menu-item":data,"menu-root":$(this).find("input[name=menu-root]").val()},
			success : function(msg) {
				if (msg.status == true) {
					notify.success("菜单保存成功!!");
				} else {
					console.log(msg);
				}
			}
		});

		return false;
	})


	
	
});
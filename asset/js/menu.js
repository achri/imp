function logout() {
	var $dlg_btn = {
		"LOGOUT" : function() {
			location.href = 'index.php/mod_core/core_app/log_out';
			$dlg_content.dialog('close');
		},
		"CANCEL" : function() {
			$(this).dialog('close');
		}
	}
		
	$('div.dialog-content').dialog('destroy')
	.html("Are you sure want to logout ???")
	.dialog({
		title: 'CONFIRMATION',
		autoOpen: false,
		bgiframe: true,
		width: 'auto',
		height: 'auto',
		resizable: false,
		draggable: false,
		modal:true,
		/*position:['right','top'],*/
		position:'center',
		buttons: $dlg_btn,
		close: function() {
			$(this).dialog('destroy');
		}
	}).dialog('open');
	return false;
}

$(document).ready(function(){
	/* SIDEBAR MENU AND NAVIGATION MENU */
	var menu = $('ul.art-menu, ul.art-vmenu'),
		sub_menu = $('div.art-submenu ul li a');
	
	// ROUTINE - AJAX LOAD MODULE
	function menu_ajax(module)
	{
		cek_offline();
		var controller,mod_class;
		
		if (module == 'home') {
			controller = 'index.php/mod_core/core_app/home';
		}else if (module == 'logout') {
			controller = 'null';
			logout();
		}else if(module) {
			mod_class = module.split('_');
			controller = 'index.php/mod_'+mod_class[0]+'/'+module;
		}
		
		// LOAD AJAX CONTENT
		$("#content-ajax").load(controller,function(data){
			// DEBUG FUTURE PLANING
			//$('#debug-imp').text(data);
		});
				
		return false;
	}
		
	// ROUTINE - MENU PARENT
	menu.selectable({
		filter: 'li a',
		selected: function(event,ui) {
			var item_selected = $(".ui-selected", this),
				item_deactive = $("li a",this),
				item_subs = item_selected.next(),
				module = item_selected.attr("module");
		
			// CALL FUNC MENU AJAX
			if (module != '')
				menu_ajax(module);
		
			// REMOVE ALL CLASS ACTIVE AND ADD SELECTED CLASS ACTIVE
			menu.each(function(i){ 
				var this_item = $("> li a",this);
				
				if (this_item.hasClass('active'))
					this_item.removeClass('active');
			});
			
			// SELECTED ITEM
			item_selected.addClass('active')
			.next().toggleClass('active');
			
			return false;
		}
	});
	
	// ROUTINE - SUB MENU
	sub_menu.click(function() {
		var item_selected = $(this),
			module = item_selected.attr("module");
		
		// CALL FUNC MENU AJAX
		if (module != '')
			menu_ajax(module);
		
		//alert(item_selected);
		return false;
	});
	
	// LOAD THE FIRST CONTENT
	menu_ajax('home');
});
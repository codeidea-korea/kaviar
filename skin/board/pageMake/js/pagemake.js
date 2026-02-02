



//document ready - start
$(document).ready(function(){
	
	

	$('.myTip.useTag').each(function() {
		var tag = typeof $(this).attr('data-tag') !== typeof undefined && $(this).attr('data-tag') !== '' ? $(this).attr('data-tag') : '';
		if(tag){
			$(this).append('<span class="tipCon">' + tag + '</span>');			
		}
	});

	if($('#pagemake-tabmenu.floating').length) {
		var pagemake_tabmenu = $('#pagemake-tabmenu.floating');
		$(window).scroll(function() {
			ypos = $(window).scrollTop() + $(window).height();
			if(ypos >= $(document).height() - $('#footer').outerHeight(true)) {
				pagemake_tabmenu.removeClass('auto-fixed');
			} else {
				pagemake_tabmenu.addClass('auto-fixed');
			}
		});
	}
	
});



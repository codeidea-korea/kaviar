



$(document).ready(function(){
	
	
	$(window).scroll(function() {
		if( $(this).scrollTop() >= 250 ) {
			$("#header").addClass('scroll');
			$('#header').animate({"top": 0}, 900, 'easeInOutExpo');
		}
		if( $(this).scrollTop() < 5 ){
			$("#header").removeClass('scroll');
			$('#header').css({'top':''});
			//$('#header').removeAttr("style");
			$('#header').clearQueue();
		}
	});


	//매뉴(shop 카테고리) 토글
	$('.topGnbOpener').click(function() {
		$('#_shopCateMenuContainer').toggleClass('open');
	});
	$('html').click(function(e) {   
		if(!$(e.target).hasClass("_shopCateContainer") && !$(e.target).hasClass("topGnbOpener")) {
			$('#_shopCateMenuContainer').removeClass('open');
		}
	});

});




 //콘텐츠영역 최소 높이값
$container_min_height = function(el) {
	var wh = $(window).outerHeight(true),
		fh = $("#footer").outerHeight();
	$(el).css({"min-height":wh - fh});
}


//------------------------------- Start Ready Function
$(document).ready(function(){

	if( $(window).scrollTop() >= 120 ) {
		$("#header.scrollfixed").addClass('scroll');
		$('#header.scrollfixed').animate({"top": 0}, 700, 'easeInOutExpo');
	}
	$(window).scroll(function() {
		if( $(this).scrollTop() >= 120 ) {
			$("#header.scrollfixed").addClass('scroll');
			$('#header.scrollfixed').animate({"top": 0}, 700, 'easeInOutExpo');
		}
		if( $(this).scrollTop() < 55 ){
			$("#header.scrollfixed").removeClass('scroll');
			$('#header.scrollfixed').removeAttr("style");
			$('#header.scrollfixed').clearQueue();
		}
	});

	$container_min_height('#container');


});
//------------------------------- End Ready Function

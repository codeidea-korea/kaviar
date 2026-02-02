

$(document).ready(function(){

	var winWidth = $(window).width(),
		winHeight = $(window).height(),
		topSection_h =  $("#header .topSection").outerHeight(true),
		boTopImgWidth = $(".bo_top_img .bgImg").outerWidth(),
		boTopImgHeight = $(".bo_top_img .bgImg").outerHeight();
	
	$("#container, #outerContainer").css({"min-height":winHeight - topSection_h}); //콘텐츠영역 최소 높이값
	

	/*──────────────────────────────────
						게시판 상단 이미지
	───────────────────────────────────*/
	if ($(".bo_top_img").length) {
		$(".bo_top_img").css({"height":boTopImgHeight, "max-height":winHeight});//상단이미지(고정형) 높이값
		$(".bo_top_img .bgImg").css({"width":boTopImgWidth, "height":boTopImgHeight, "margin-left":- boTopImgWidth/2}); //상단이미지 가운데 정렬
		$(".boCover").css({"height":winHeight}); //상단이미지(커버형) 높이값
		$(".boCoverSpacer").css({"height":winHeight}); //상단이미지만큼 콘텐츠를 밀어준다.
		$(window).scroll(function() {
			var coverBg_height = $(".coverBg").innerHeight();
			var mainSlogan_top = (coverBg_height / 2);
			if( $(this).scrollTop() >= mainSlogan_top ) { //게시판 커버형 이미지
				$(".mainSlogan").stop().animate({ "opacity": "0" }, 240);
				$(".icon_mouseWheel").stop().animate({ "opacity": "0" }, 240);
			} else {
				$(".mainSlogan").stop().animate({ "opacity": "1" }, 240);
				$(".icon_mouseWheel").stop().animate({ "opacity": "1" }, 240);
			}
		});
	}


});

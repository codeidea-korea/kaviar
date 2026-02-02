


//------------------------------- Start Ready Function
$(document).ready(function(){
	
	/*────────────────────────────────────────────
					목록페이지 카테고리 swiper 및 스크롤고정
	─────────────────────────────────────────────*/
	if ($("#bo_cate").length) {
		var clone = $("#bo_cate").children().clone();
		$('#header').append(clone);
		//window_popup(); //.popWin 리플래시
		$('.boCateContainer .boCateCon-inner').each(function() {
			var swiperCate = $(this);
			var mySwiper = new Swiper(this, {
				  slidesPerView: 'auto',
				  freeMode: true
			});	
			if(swiperCate.find('.active')) {
				var i = $('.swiper-slide.active').index();
				mySwiper.slideTo(i,0,true);
			}
		});
		//var ypos = $("#bo_cate").next().offset().top;
		var ypos = $("#bo_cate").offset().top;
		$(window).scroll(function() {
			if($(this).scrollTop() > ypos) {
				$("#header .boCateContainer").addClass('show');
				$("#bo_cate .boCateContainer").addClass('hidden');
			} else {
				$("#header .boCateContainer").removeClass('show');
				$("#bo_cate .boCateContainer").removeClass('hidden');
			}
		});
	}


	/*──────────────────────────────────
						상세페이지 첨부파일
	───────────────────────────────────*/
	if ($("#bo_v_file").length) {
		var clone = $("#bo_v_file").clone();
		$('#header').append(clone);
		$("#bo_v #bo_v_file").remove();
	}

	
	/*──────────────────────────────────
						쓰기페이지 저장버튼
	───────────────────────────────────*/
	$("#header .btnSubmit").click(function() {
		$('.bo_btnSet .btn_submit').click();
	});
	

});
//------------------------------- End Ready Function
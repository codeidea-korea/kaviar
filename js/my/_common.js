/*──────────────────────────────────────────────────────────────────────
														document ready - start
───────────────────────────────────────────────────────────────────────*/
$(document).ready(function(){
	
	//동영상 리사이즈
	resizeVideo();	
	$(window).resize(function(){
		resizeVideo();
	});

	
	//Swiper ──────────────────────────────────────────────────────
	// bigBanner, _gall_slide, mix-08 은 해당페이지에 별도로 적용했음.
	$('.mySwiper').each(function(index) {
		var mySwiper = $(this),
			swiperContainer = $(this).find('.swiper-container'),
			itemPer = $(this).attr('data-per') ? $(this).attr('data-per') : 1,
			itemGroup = $(this).attr('data-group') ? $(this).attr('data-group') : 1,
			itemGap = $(this).attr('data-gap') ? $(this).attr('data-gap') : 0,
			slideLoop = $(this).attr('data-loop') == 'false' ? false : true,
			slideCenter = $(this).attr('data-center') == 'true' ? true : false,
			slidePlayTime = $(this).attr('data-timer') ? $(this).attr('data-timer') * 1000 : 0,
			slideAutoHeight = $(this).attr('data-autoheight') == 'true' ? true : false;

		var active = $(this).find('.swiper-slide').index($('.swiper-slide.active')),
			active = active == -1 ? 0 : active;

		$(this).addClass('num'+index);
		
		var swiper =  new Swiper( '.mySwiper.num' + index + ' .swiper-container', {
			spaceBetween: parseInt(itemGap),
			slidesPerView: itemPer == 'auto' ? "auto" : itemPer,
			slidesPerGroup: itemGroup,
			pagination: {
				el: '.mySwiper.num' + index + ' .pagination',
				clickable: true,
				type:  $('.mySwiper.num' + index + ' .pagination').hasClass('fraction') ? "fraction" : "bullets",
			},
			navigation: {
				nextEl: '.mySwiper.num' + index + ' .next',
				prevEl: '.mySwiper.num' + index + ' .prev'
			},
			centeredSlides: slideCenter,
			autoplay: slidePlayTime ? {delay: parseInt(slidePlayTime),disableOnInteraction:false} : false,
			initialSlide: active, //active된 슬라이드로 이동
			loop: slideLoop,
			autoHeight : slideAutoHeight			
		});
	/*	
		if($(this).attr('data-slideto') == '1') {
			$(slideWrapper.find('.swiper-slide')).click(function() {
				var i = $(this).index();
				swiper.slideTo(i,700,false);
			});
		}
*/
		
	});
	
	$('.mySwiper.itemsContainer:not(.itemShadow):not(.itemOutline)').each(function(index) {
		let img_height = $(this).find('.swiper-slide .thumb').outerHeight();
		$(this).find('.next, .prev').css({'top':img_height / 2});
	});


	// 엘럿메시지 팝업 ──────────────────────────────────────────────────────
	$('.pop-alert').click(function() {
		let text = $(this).attr('data-text');
		popup_alert(text);
	});
	

	// html 레이어 팝업 컨트롤 ──────────────────────────────────────────────────
	$('.pop-inline').click(function() {
		var target = $(this).attr('data-href'),
			url = $(this).attr('data-url');
		$(target).addClass('open');
		if(url) {
			$(target).find('.btnSubmit').prop('href', url);
		}
		$('body, html').css('overflow', 'hidden');
	});
	$('.pop-closer, .layer-popup .popClose, .pop-bg').click(function() {
		var el = $(this).closest('.layer-popup');
		el.removeClass('open');
		$('body, html').css('overflow', '');
	});	


	// 윈도우 팝업 ──────────────────────────────────────────────────────
	$('.popWin').click(function(event){
		var href = $(this).attr('href'),
		winWidth = $(this).attr('data-width'),
		winHeight = $(this).attr('data-height'),
		board = $(this).attr('title'),
		data_top = $(this).attr('data-top'),
		data_left = $(this).attr('data-left');

		if(typeof data_top !== typeof undefined && data_top !== false && data_top)
			var top = $(this).attr('data-top');
		else
			var top = Math.ceil((window.screen.height - winHeight)/2);
		
		if(typeof data_left !== typeof undefined && data_left !== false && data_left)
			var left = $(this).attr('data-left');
		else
			var left = Math.ceil((window.screen.width - winWidth)/2);

		popup = window.open(href,board,'width='+winWidth+',height='+winHeight+',top='+top+',left='+left+',scrollbars=yes, toolbar=no, menubar=no, location=no, statusbar=no, status=no, resizable=yes');
		event.preventDefault();
	});
	

	//금액출력
	$('.comma').each(function() {
		$(this).text($(this).text().replace(/\,/g, '').replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,'));
	});

	// 셀렉트 옵션 클릭시 페이지 이동(링크) ─────────────────────────────────
	if($('select.select-link').length) {
		$('select.select-link').change(function (){
			var val = $(this).val(),
				target = $(this).attr('data-target');
			if(target=='_blank')
				window.open(val,'_blank');
			else
				window.open(val,'_self');
		});
	}


	//페이드 아웃 처리..
	$('.fadeOut').each(function() {
		var duration = typeof $(this).attr('data-duration') !== typeof undefined && $(this).attr('data-duration') !== '' ? $(this).attr('data-duration') * 1000 : 1000,
			delay = typeof $(this).attr('data-delay') !== typeof undefined && $(this).attr('data-delay') !== '' ? $(this).attr('data-delay') * 1000 : 1000;
		$(this).delay(delay).fadeOut(duration);
	});


	$('.historyback, ._historyback').click(function() {
		window.history.back();
	});
	


	// ─────────────────────────────────────────────────────────────────────────────────────────
	//관리자를 위한 ...(관리자메뉴토글)
	if($('#adminSet').length) {
		var tpw = $('#adminSet').outerWidth();
		$('#adminSet').css({ "right":  - tpw });
		$('.adminMenu_opener').click(function() {
			$(this).toggleClass("on")
			if($(this).hasClass("on")){
				$(this).parent().css({ "right": "0" });
			} else {
				$(this).parent().css({ "right":  - tpw });
			}
		});
	}
	//관리자를 위한 ...(관리자관련 버튼 호버시 표시해주기)
	$('.btnSetting, .blockSetting, .mainSetting, .data-area').hover(function() {
		var area = $(this).attr('data-area');
		$(area).addClass('area-pointer');
	}, function(){
		var area = $(this).attr('data-area');
		$(area).removeClass('area-pointer');
	});
	//자동 클릭..
	if($('.myClick').length) {
		$('.myClick').click();
	}
	// ─────────────────────────────────────────────────────────────────────────────────────────

});
//document ready - end




/*──────────────────────────────────────────────
					브라우저 안쪽 높이(모바일기기포함) 구하기
───────────────────────────────────────────────*/
function setScreenSize() {
	//let vh = window.innerHeight * 0.01;
	let vh = window.innerHeight;
	document.documentElement.style.setProperty('--vh', `${vh}px`);
}


/*──────────────────────────────────────────────
								리사이즈 이벤트 후처리
───────────────────────────────────────────────*/
$(window).resize(function() {
	if(this.resizeTO) clearTimeout(this.resizeTO);
	this.resizeTO = setTimeout(function() {
		$(this).trigger('resizeEnd');
	}, 100);
});


/*──────────────────────────────────────────────
										쿠기 저장
───────────────────────────────────────────────*/
function Set_Cookie(name, value, expires) {
	var expdate = new Date();
	expdate.setTime(expdate.getTime() + 1000 * 3600 * expires); // 1일
	document.cookie = name + "=" + escape (value) + "; path=/; expires=" + expdate.toGMTString();
}
function Get_Cookie(Name) {
	var search = Name + "=";
	if(document.cookie.length > 0) {   // 쿠키가 설정되어 있다면
		offset = document.cookie.indexOf(search);

		if(offset != -1) {    // 쿠키가 존재하면
			offset += search.length;
			// set index of beginning of value
			end = document.cookie.indexOf(";", offset);
			// 쿠키 값의 마지막 위치 인덱스 번호 설정
			if(end == -1) {
				end = document.cookie.length;
			}
			return unescape(document.cookie.substring(offset, end));
		}
	}
}


/*──────────────────────────────────────────────
										동영상 리사이즈
───────────────────────────────────────────────*/
function resizeVideo() {
	$("iframe").each(function(){
		if( /^https?:\/\/www.youtube.com\/embed\//g.test($(this).attr("src")) ) {
			$(this).css("width","100%");
			$(this).css("height",Math.ceil( parseInt($(this).css("width")) * 480 / 850 ) + "px");
		}
		if( /^https?:\/\/player.vimeo.com\/video\//g.test($(this).attr("src")) ) {
			$(this).css("width","100%");
			$(this).css("height",Math.ceil( parseInt($(this).css("width")) * 450 / 800 ) + "px");
		}
	});	
}


/*──────────────────────────────────────────────
							이미지 에러는 display:none
───────────────────────────────────────────────*/
function imgCheck() {
	$("img").each( function(i, ele){
		 var uri = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
		if( ele.src != '' && ele.complete == true && ele.naturalWidth == 0 ){ //이미 load된 이미지 처리
			$(this).css({"display":"none"});
		}
		$(this).load( function(n){ //load되지 않은 이미지들은 load와 error 이벤트를 추가
			//do nothing
		})
		.error( function(){
			$(this).css({"display":"none"});
		});
	});
}


/*───────────────────────────────────────────────────────────
													엘럿메시지 팝업
───────────────────────────────────────────────────────────*/
function popup_alert(text, url) {
	let pop_alert_closer = url ? '<a href="'+url+'" class="pop_alert_closer">확인</a>' : '<span class="pop_alert_closer">확인</span>';
	let pop_alertContainer = '<div id="pop_alertContainer">';
		pop_alertContainer += '<div class="pop-inner">';
		pop_alertContainer += text;
		pop_alertContainer += '<div class="pop_btnSet">'+pop_alert_closer+'</div>';
		pop_alertContainer += '</div>';
		pop_alertContainer += '<div class="pop-bg"></div>';			
		pop_alertContainer += '</div>';
	$('body').prepend(pop_alertContainer);
	$('body, html').css('overflow', 'hidden');
	$('.pop_alert_closer').click(function() {
		$('#pop_alertContainer').remove();
		$('body, html').css('overflow', '');
	});
}



/*───────────────────────────────────────────────────────────
										엘리먼트 온·오프 (select)
───────────────────────────────────────────────────────────*/
function matchOnOff(elm, match, target, standard, visibility) {
	$(document).ready(function(){
		var val = $(elm).val();
		var arrMatch = match.split(",");
		if(standard == "hide") {
			if(visibility == 'visibility')
				$(target).removeClass('hidden');
			else
				$(target).show();
			for(var i in arrMatch) {
				if(val == arrMatch[i]) {
					if(visibility == 'visibility')
						$(target).addClass('hidden');
					else
						$(target).hide();
				}
			}
		} else {
			$(target).hide();
			for(var i in arrMatch) {
				if(val == arrMatch[i]) {		
					if(visibility == 'visibility')
						$(target).removeClass('hidden');
					else
						$(target).show();
				}
			}
		}
	});
	$(elm).change(function (){
		var val = $(this).val();
		var arrMatch = match.split(",");
		if(standard == "hide") {
			if(visibility == 'visibility')
				$(target).removeClass('hidden');
			else
				$(target).show();
			for(var i in arrMatch) {
				if(val == arrMatch[i]) {		
					if(visibility == 'visibility')
						$(target).addClass('hidden');
					else
						$(target).hide();	
				}
			}
		} else {
			$(target).hide();
			for(var i in arrMatch) {
				if(val == arrMatch[i]) {
					if(visibility == 'visibility')
						$(target).removeClass('hidden');
					else
						$(target).show();
				}
			}
		}
	});
}


/*───────────────────────────────────────────────────────────
											채크시 온·오프 (checkbox)
───────────────────────────────────────────────────────────*/
function matchOnOff_checkbox(elm, on_target, off_target, visibility) {
	$(document).ready(function(){
		var checked = $(elm).is(":checked");
		if(visibility == 'visibility') {
			if(checked) {
				$(on_target).removeClass('hidden');
				$(off_target).addClass('hidden');
			} else {
				$(on_target).addClass('hidden');
				$(off_target).removeClass('hidden');
			}
		} else {
			if(checked) {
				$(on_target).show();
				$(off_target).hide();
			} else {
				$(on_target).hide();
				$(off_target).show();
			}
		}
	});
	$(elm).change(function (){
		var checked = $(this).is(":checked");
		if(visibility == 'visibility') {
			if(checked) {
				$(on_target).removeClass('hidden');
				$(off_target).addClass('hidden');
			} else {
				$(on_target).addClass('hidden');
				$(off_target).removeClass('hidden');
			}
		} else {
			if(checked) {
				$(on_target).show();
				$(off_target).hide();
			} else {
				$(on_target).hide();
				$(off_target).show();
			}
		}
	});
}


/*───────────────────────────────────────────────────────────
											텝메뉴 온오프 처리
───────────────────────────────────────────────────────────*/
function _tabsContainer(el, containers, visibility) {
	let activeContainer = $(el+'.active').attr('data-target');
	if(visibility == 'visibility') {
		$(containers).not(activeContainer).addClass('hidden');		
	} else {
		$(containers).not(activeContainer).addClass('none').removeClass('open');
	}
	$(activeContainer).show().addClass('open').removeClass('none');


	$(el).click(function() {
		let activeContainer = $(this).attr('data-target');		
		$(this).addClass('active');
		$(this).siblings(el).removeClass('active');
		
		if(visibility == 'visibility') {
			$(containers).not(activeContainer).addClass('hidden');		
		} else {
			$(containers).not(activeContainer).addClass('none').removeClass('open');
		}
		$(activeContainer).show().addClass('open').removeClass('none');	
	});
}



/*──────────────────────────────────────────────
								masonry 벽돌갤러리
───────────────────────────────────────────────*/
function my_masonry(name, num) {
	var $masonry_wrap = $(name);
	$masonry_wrap.masonry({
		itemSelector: '.gall_li',
		columnWidth: '.gall_li:not(.hide_li)',
		gutter : num,
		percentPosition : true,
		horizontalOrder : true
	});
 }
function masonry_update(name, num) {
	$(window).load(function(){
		my_masonry(name, num);
	});
};
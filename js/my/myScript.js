



/*──────────────────────────────────────────────
										퀵뉴스 토글
───────────────────────────────────────────────*/
function quickNews_toggle(opener, closer, target, start) {
	var total_width = $(target).outerWidth();
	var qn_cookie = Get_Cookie( "qn_cookie" );

	if(qn_cookie == 1 || start == 'absolute') {
		$(target).css({'transform':'translateX(0)'});
		$(target).parent().css({'z-index':99});
		$(target).addClass('open');
	} else if(qn_cookie == 0){
		$(target).css({'transform':'translateX('+total_width+'px)'});
		$(target).parent().css({'z-index':''});
	} else if(!qn_cookie) {
		if(start) {
			$(target).css({'transform':'translateX(0)'});
			$(target).parent().css({'z-index':99});
			$(target).addClass('open');
		} else {
			$(target).css({'transform':'translateX('+total_width+'px)'});
			$(target).parent().css({'z-index':''});
		}
	}
	$(opener).click(function() {
		Set_Cookie('qn_cookie', '1', 1 );
		$(target).animate({'transform':'translateX(0)'}, 600, 'easeInOutExpo');
		$(target).addClass('open');
		$(target).parent().css({'z-index':99});
		//$('body, html').css('overflow', 'hidden');
	});
	$(closer).click(function() {
		Set_Cookie('qn_cookie', '0', 1 );
		$(target).animate({'transform':'translateX('+total_width+'px)'}, 400, 'easeInOutExpo');
		$(target).removeClass('open');
		//$('body, html').css('overflow', '');
		$(target).parent().delay(400).queue(function (next) {
			 $(this).css('z-index', '');
			 next();
		 });
	});
}


/*──────────────────────────────────────────────
										토글
───────────────────────────────────────────────*/
function toggleClass(opener, closer, target, classname) {
	var classname = classname ? classname : 'on';
	if(opener == closer) {		
		$(opener).click(function() {
			$(target).toggleClass(classname);
		});
		$('.body-area').click(function() {
			$(target).removeClass(classname);
		});
	} else {
		$(opener).click(function() {
			$(target).addClass(classname);
		});
		$(closer).click(function() {
			$(target).removeClass(classname);
		});
		$('.body-area').click(function() {
			$(target).removeClass(classname);
		});
	}
}





/*──────────────────────────────────
						fadeUp 모션
───────────────────────────────────*/
function scrollMotionTrigger(){
	$(".scrollMotion").each(function(q){
		gsap.to($(this), {
			scrollTrigger: {
				trigger: $(this),
				start: "top bottom",
				end:"bottom center",
				toggleClass: {targets: $(".scrollMotion").eq(q), className: "active"},
				once: true,
				//markers: true,
			}
		});
	});
};


/*──────────────────────────────────
						탑 스크롤 애니메이션
───────────────────────────────────*/
function top_scrollTrigger(el) {
	const showAnim = gsap.from(el, { 
		yPercent: -100,
		paused: true,
		duration: 0.2
	}).progress(1);

	ScrollTrigger.create({
		start: "top top",
		end: 99999,
		markers: true,
		onUpdate: (self) => {
			self.direction === -1 ? showAnim.play() : showAnim.reverse()
		}
	});
};

/*──────────────────────────────────
						버텀 스크롤 애니메이션
───────────────────────────────────*/
function bottom_scrollTrigger(el) {
	var footer_height = $('#footer').height();
	const gotopAnim = gsap.from(el, {
		yPercent: 100,
		paused: true,
		duration: 0.2
	}).progress(1);
	ScrollTrigger.create({
		start: "top top",
		end: "bottom bottom+="+footer_height+"px",
		toggleClass:{targets:el, className:'scrollShow'},
		onLeave: function() {
			gotopAnim.play()
		},
		onUpdate: (self) => {
			self.direction === -1 ? gotopAnim.play() : gotopAnim.reverse()
		}	
	});
};




/*──────────────────────────────────────────────────────────────────────
														document ready - start
───────────────────────────────────────────────────────────────────────*/
$(document).ready(function(){
	
	//이미지에러는 display:none
	imgCheck();
	
	//fadeUp 모션
	scrollMotionTrigger();	
	
	
	//비디오 플레이바 사이즈
	$('.video-container.play-btn').each(function() {
		//var video = $(this).children('.video');
		$(this).append('<span class="btnController"></span>');
		if($(this).width() >= 720) {
			$(this).children('.btnController').addClass('large');
		}
	});

	//비디오 컨트롤
	$('.video-container.play-btn').click(function() {
		var video = $(this).children('.video'),
			btnController = $(this).children('.btnController');
		
		//$(this).toggleClass('controls');
		//$(this).children('.video').toggleClass('play');
		if(video.get(0).paused) {
			video.get(0).play();
			video.addClass('play');			
			//$(this).removeClass('play-btn');
			//$(this).addClass('pause-btn');
		} else {
			video.get(0).pause();
			video.removeClass('play');
			//$(this).removeClass('pause-btn');
			//$(this).addClass('play-btn');
		}
		btnController.addClass('click');
		setTimeout(function() {
			btnController.removeClass('click');
		}, 800 );
	});
	$('.youtube-wrap .video_thumb').on('click', function(e) {
		var video = $(this).parent().find("iframe");
		var video_src = $(this).parent().find("iframe").attr("src");
		$(this).hide();
		video.attr("src",video_src + "?autoplay=1");
	});

	



	/*───────────────────────────────────────────────────────────
													parallax
	───────────────────────────────────────────────────────────*/
	/*$(".parallax").each(function(q){
		if($(this).hasClass('start-bottom')) {
			var from_ypos = $(this).height() / 1.5 + "px";
			var ypos = - $(this).height() / 1.5 + 'px';
			var startset = 'top bottom';
		} else if($(this).hasClass('bo_top_img')) {
			var from_ypos = "0px";
			var ypos = - $(this).height() / 1.6 + 'px';			
			var startset = '-=100px top top';
		} else if($(this).closest('.swiper-slide').length) {
			var from_ypos = "0px";
			var ypos = $(this).height() / 1.7 + 'px';			
			var startset = 'top top';
		} else {
			var from_ypos = "0px";
			var ypos = - $(this).height() / 1.7 + 'px';
			var startset = 'top top';
		}
		gsap.fromTo($(this), {
			backgroundPosition: "center "+from_ypos
		},
		{
			backgroundPosition:"center "+ypos,
			ease: "none",
			scrollTrigger: {
				trigger: $(this),
				start: startset,
				end:"bottom top",
				scrub: true,
				invalidateOnRefresh: true
				//toggleClass: {targets: $(".scrollMotion").eq(q), className: "active"},
				//once: true,
				//markers: true,
			}
		});
	});*/

	$(".video-parallax").each(function(q){
		if($(this).hasClass('start-bottom')) {
			var startset = 'top bottom';
		} else {
			var startset = 'top top';
		}
		gsap.fromTo($(this), {
			yPercent: 0,
		},
		{
			yPercent: 50,
			ease: "none",
			scrollTrigger: {
				trigger: $(this),
				start: startset,
				end:"bottom top",
				scrub: true,
				invalidateOnRefresh: true
			}
		});
	});




	
	


	
	


	/*───────────────────────────────────────────────────────────
													magnific-Popup
	───────────────────────────────────────────────────────────*/


	//magnific-Popup
	$('.popup-admin').magnificPopup({
		type: 'inline',
		closeOnContentClick: false, 
		closeOnBgClick: false,
		overflowY: 'auto',
		fixedContentPos: true,
		fixedBgPos: true
	});
	$('.popup-inline').magnificPopup({
		type: 'inline',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
        closeOnBgClick: true,
		overflowY: 'auto',
		closeBtnInside: false,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	$('.popup-view').magnificPopup({
		type: 'ajax',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
		closeOnBgClick: false,
		gallery: {
		  enabled: true,
		  navigateByImgClick: true,
		  preload: [0,1]
		},
		overflowY: 'auto',
		closeBtnInside: false,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	$('.popup-view-img').magnificPopup({
		type: 'ajax',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
		closeOnBgClick: false,
		gallery: {
		  enabled: true,
		  navigateByImgClick: true,
		  preload: [0,1]
		},
		overflowY: 'auto',
		closeBtnInside: false,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});
	$('.popup-view-txt').magnificPopup({
		type: 'ajax',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
		closeOnBgClick: false,
		gallery: {
		  enabled: true,
		  navigateByImgClick: true,
		  preload: [0,1]
		},
		overflowY: 'auto',
		closeBtnInside: false,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	$('.popup-login').magnificPopup({
		type: 'ajax',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
		closeOnBgClick: false,
		overflowY: 'auto',
		closeBtnInside: false,
		preloader: false,
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	$(document).on('click', '.popClose', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	
	
	

	//퀵뉴스 텝
	$(".qn_tabs .tab").click(function() {
		var other = $(this).siblings('.tab').not(this);
		var other_target = $('#quickNewsWrap').find('.quickNews');
		var target = $(this).data("target");
		other.removeClass('active');
		$(this).addClass('active');
		$(other_target).removeClass("open");
		$(target).addClass("open");
	});

	


	$('._historyback').click(function() {
		window.history.back();
	});

	
	

});
//document ready - end
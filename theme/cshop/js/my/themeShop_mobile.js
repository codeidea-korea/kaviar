



$(document).ready(function(){
	
	
	//shop header 스크롤 이벤트 ──────────────────────────────────────────────────────
	if($('#header.scrollTrigger').length) {
		const showAnim = gsap.from('#header.scrollTrigger #header_inwrap', {
			yPercent: -100,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top-=100",
			//end: 99999,
			end: "bottom bottom+=10px",
			toggleClass: {targets: "#header", className: "scroll"},
			//toggleClass: {targets: "#header.scrollTrigger", className: "scrollTriggerActive"},
			onLeave: function() {
				showAnim.play();
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse()
			}	
		});
	}
	if($('#header.scrollTrigger2').length) {
		let headerCon_height = $('#header .headerContainer').height();
		const showAnim = gsap.from('#header.scrollTrigger2 #header_inwrap', {
			y: -headerCon_height,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top-=100",
			end: "bottom bottom+=10px",
			toggleClass: {targets: "#header", className: "scroll"},
			onLeave: function() {
				showAnim.play();
				$('#header').addClass('end');
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse();
				$('#header').removeClass('end');
			}	
		});
	}

	//하단 메뉴 스크롤 이벤트 ──────────────────────────────────────────────────────
	if($('#bottomTabMenu.scrollTrigger').length) {
		const showAnim = gsap.from('#bottomTabMenu.scrollTrigger', {
			yPercent: 100,
			paused: true,
			duration: 0.2
		}).progress(1);
		ScrollTrigger.create({
			start: "top top",
			//end: 99999,
			end: "bottom bottom+=10px",
			onLeave: function() {
				showAnim.play()
			},
			onUpdate: (self) => {
				self.direction === -1 ? showAnim.play() : showAnim.reverse()
			}	
		});
	}


	//매뉴(shop 카테고리) 토글
	$('.topGnbOpener').click(function() {
		$('#_shopCateMenuContainer').toggleClass('open');
	});
	$('html').click(function(e) {   
		if(!$(e.target).hasClass("_shopCateContainer") && !$(e.target).hasClass("topGnbOpener")) {
			$('#_shopCateMenuContainer').removeClass('open');
		}
	});
	

	$('#_item_filter_opner').click(function() {
		$('#_items_filter').addClass('open');
		$('#_items_filter_bodyCover').fadeIn();
		$('body, html').css('overflow', 'hidden');		
	});
	$('#_items_filter .closer').click(function() {
		$('#_items_filter').removeClass('open');
		$('#_items_filter_bodyCover').fadeOut();
		$('body, html').css('overflow', '');
	});
	


	//장바구니 토글
	$('.topCatOpener').click(function() {
		$('#_sideCart').addClass('open');
		$('#_sideCart').removeClass('ready');
		$('body, html').css('overflow', 'hidden');
	});
	$('#_sideCart .topCatCloser').click(function() {
		$('#_sideCart').removeClass('open');
		$('body, html').css('overflow', '');
		setTimeout(function() {
			$('#_sideCart').addClass('ready');
		},1000);
	});

});
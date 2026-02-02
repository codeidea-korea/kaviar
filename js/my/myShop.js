

//화면 높이를 body에 --vh로 지정
setScreenSize();
window.addEventListener('resize', setScreenSize);



/*──────────────────────────────────────────────────────────────────────
														document ready - start
───────────────────────────────────────────────────────────────────────*/
$(document).ready(function(){
	
	//이미지에러는 display:none
	imgCheck();

	
	//타임특가 카운트 다운(날짜, 시간 구분) ──────────────────────────────────────────────────────
	$('.buy-timer').each(function() {
		var d = $(this).attr('data-timer');
		var layout = '	<span class="d d-{dn}">{dn} 일</span>';
			layout += '<div class="tm">';
			layout += '<span class="h">{hnn}</span>';
			layout += '<span class="m">{mnn}</span>';
			layout += '<span class="s">{snn}</span>';
			layout += '</div>';
		  $(this).countdown({until: d, format: 'dHMS', labels:['','','','','','',''],layout:layout}); 
	});

	//타임특가 카운트 다운 ──────────────────────────────────────────────────────
	/*$('.item-timer').each(function() {
		var myTimer = $(this);
		var end_date = $(this).attr('data-end-date');
		var countDownDate = new Date(end_date).getTime();
		//var countDownDate = new Date("2022-12-29 11:20:00").getTime();

		function timePart(val) {
			val = val < 10 ? '0' + val : val;
			return '<span>' + val + '</span>';
		}

		var x = setInterval(function () {
			var now = new Date().getTime();
			var distance = countDownDate - now;
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);
			let res = timePart(hours + days*24) + timePart(minutes) + timePart(seconds);

			myTimer.html(res);
			//console.log(distance);
			if (distance < 0) {
				clearInterval(x);
				let res = timePart(0) + timePart(0) + timePart(0);
				myTimer.html(res);
			}
		}, 30);
	});*/


	//상품 상세 tab메뉴 스크롤시 상단 고정 ──────────────────────────────────────────────────────
	/*if($('#v_tabContainer').length) {
		var tab_pos = $("#v_tabContainer").offset(),
			tab_height = $("#v_tabContainer").height(),
			header_height = $("#header").height();	 
		$(window).scroll(function(){
			var docScrollY = $(document).scrollTop() + header_height;
			var barThis = $("#v_tabContainer ul"); 
			if( docScrollY > tab_pos.top) {
				barThis.addClass("fixed");
				barThis.css({"top":header_height});
			}else{
				barThis.removeClass("fixed");
				barThis.removeAttr('style');
			}	 
		});
	}*/

	//상품 상세 정보 펼치기/가리기 ──────────────────────────────────────────────────────
	$('.v_itemCon-toggle').click(function() {
		$(this).parent().toggleClass('open');
	});



	// magnific-popup ──────────────────────────────────────────────────────
	$('.pop-modal').magnificPopup({
		type: 'ajax',
		fixedContentPos: true,
		fixedBgPos: true,
		closeOnContentClick: false, 
		closeOnBgClick: false,
		overflowY: 'auto',
		closeBtnInside: true,
	});
	$(document).on('click', '.modalClose', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});

	



	

});
//document ready - end
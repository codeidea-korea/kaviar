
$(document).ready(function(){
	
	//select api 적용
	$('select').selectpicker();


	$('.mybox-title.toggle').click(function() {
		if($(this).parent().hasClass('mybox-header')) {
			$(this).parent().parent().toggleClass('hide');
		} else {
			$(this).parent().toggleClass('hide');
		}
	});

	$('.fontSizeControl').each(function() {
		var ta = $(this).attr('data-target'),
			input = $(this).attr('data-target-input'),
			up = $(this).find('.up'),
			down = $(this).find('.down');
		up.click(function() {
			var currentFontSize = parseInt($(ta).css('fontSize'));
			var targetFont = currentFontSize + 1;
			$(ta).css("fontSize", targetFont + "px");
			$(input).val(targetFont);
		});
		down.click(function() {
			var currentFontSize = parseInt($(ta).css('fontSize'));
			var targetFont = currentFontSize - 1;
			$(ta).css("fontSize", targetFont + "px");
			$(input).val(targetFont);
		});
	});
	

	//타임특가 카운트 다운(날짜, 시간 구분) ──────────────────────────────────────────────────────
	$('.buy-timer').each(function() {
		var d = $(this).attr('data-timer');
		var layout = '	<div class="d d-{dn}">{dn}일</div>';
			layout += '<div class="tm">';
			layout += '<div class="h">{hnn}</div>';
			layout += '<div class="m">{mnn}</div>';
			layout += '<div class="s">{snn}</div>';
			layout += '</div>';
		  $(this).countdown({until: d, format: 'dHMS', labels:['','','','','','',''],layout:layout}); 
	});	
	
	
	//관리자 페이지 폼 필드네임 보기..
	$('input[name="viewfield"]').click(function() {
		if($(this).is(":checked")) {
			field_name_show('input:not([name="viewfield"]):not([type="submit"]):not([type="hidden"]):not([type="file"]):not(.upload-name)');
			field_name_show('select');
			field_name_show('textarea');
		} else {
			$('.field_name_visible').remove();
		}
	});

});


//관리자 페이지 폼 필드네임 보기..
function field_name_show(el) {
	$(el).each(function() {
		var name = $(this).attr('name');
		
		if($(this).attr('type')=='checkbox' || $(this).attr('type')=='radio') {
			$(this).parent().after('<span class="field_name_visible">'+name+'</span>');
		} else {
			$(this).after('<span class="field_name_visible">'+name+'</span>');
		}
	});
}


$(document).ready(function(){
	
	//input label ──────────────────────────────────────────
	$('input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="range"])').each(function() {
		var label =  typeof $(this).attr('data-sm-label') !== typeof undefined && $(this).attr('data-sm-label') !== '' ? $(this).attr('data-sm-label') : '',
			label_right =  typeof $(this).attr('data-sm-label-right') !== typeof undefined && $(this).attr('data-sm-label-right') !== '' ? $(this).attr('data-sm-label-right') : '',
			label_inline =  typeof $(this).attr('data-sm-label-inline') !== typeof undefined && $(this).attr('data-sm-label-inline') !== '' ? $(this).attr('data-sm-label-inline') : '';

		if(label || label_right || label_inline) {
			if(!$(this).closest('.labelInput').length) {
				$(this).wrap('<label class="labelInput"></label>');
			}
			if(label) $(this).before('<span class="label">' + label + '</span>');
			if(label_right) $(this).after('<span class="label">' + label_right + '</span>');
			if(label_inline) {
				$(this).after('<span class="label-inline">' + label_inline + '</span>');
				var labelWidth = $(this).next('.label-inline').outerWidth();
				$(this).css({"padding-right":labelWidth});
			}
		}
	});

	$('select').each(function() {
		var label =  typeof $(this).attr('data-sm-label') !== typeof undefined && $(this).attr('data-sm-label') !== '' ? $(this).attr('data-sm-label') : '',
			label_right =  typeof $(this).attr('data-sm-label-right') !== typeof undefined && $(this).attr('data-sm-label-right') !== '' ? $(this).attr('data-sm-label-right') : '';

		if(label || label_right) {
			if(!$(this).closest('.labelInput').length) {
				$(this).closest('.bootstrap-select').wrap('<label class="labelInput labelSelect"></label>');
			}
		}		
		if(label) {
			$(this).parent().before('<span class="label">' + label + '</span>');
		}
		if(label_right) {
			$(this).parent().after('<span class="label">' + label_right + '</span>');
		}
	});

	colorpicker('.colorpicker', 'right');

	//댓글 버튼 모음
	$(".re_btnSetOpenner").click(function() {
		$('.re_btnSetOpenner').not(this).removeClass('on');
		$(this).toggleClass('on');
	});
	$(".re_btnSet li").click(function() {
		$('.re_btnSetOpenner').removeClass('on');
	});


	

});
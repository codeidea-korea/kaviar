
$(document).ready(function(){

	//input label ──────────────────────────────────────────
	$('input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="range"])').each(function() {
		var label =  typeof $(this).attr('data-lg-label') !== typeof undefined && $(this).attr('data-lg-label') !== '' ? $(this).attr('data-lg-label') : '',
			label_right =  typeof $(this).attr('data-lg-label-right') !== typeof undefined && $(this).attr('data-lg-label-right') !== '' ? $(this).attr('data-lg-label-right') : '',
			label_inline =  typeof $(this).attr('data-lg-label-inline') !== typeof undefined && $(this).attr('data-lg-label-inline') !== '' ? $(this).attr('data-lg-label-inline') : '';

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
		var label =  typeof $(this).attr('data-lg-label') !== typeof undefined && $(this).attr('data-lg-label') !== '' ? $(this).attr('data-lg-label') : '',
			label_right =  typeof $(this).attr('data-lg-label-right') !== typeof undefined && $(this).attr('data-lg-label-right') !== '' ? $(this).attr('data-lg-label-right') : '';

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

	colorpicker('.colorpicker');
	
	// textarea 라벨 ──────────────────────────────────────────
	$('textarea.label').each(function() {
		var label = $(this).attr('data-label'),
			thisClass = typeof $(this).attr('data-class') !== typeof undefined && $(this).attr('data-class') !== '' ? $(this).attr('data-class') : '';
		$(this).parent().parent().find('.wrConTabs').css({'top':36});
		$(this).wrap('<div class="textareaContainer '+thisClass+'"></div>');
		$(this).after('<span class="textarea-label" data-label="' + label + '"><i class="label-icon"></i></span>');
	});
	

	

});
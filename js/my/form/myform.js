
// 쓰기페이지 버튼 달기 ──────────────────────────────────────────
function btn_target(el) {
	$(el).each(function() {
		var val = $(this).val(),
			elm = $(this).parent().siblings('.btnPopupOption');			
		elm.hide();
		if(val == 'popup') elm.show().css('display','inline-flex');
	});
	$(el).change(function (){			
		var val = $(this).val(),
			elm = $(this).parent().siblings('.btnPopupOption'),
			link = $(this).parent().siblings('.btn-link');	
		if(val == 'popup') {
			$(elm).show().css('display','inline-flex');
		} else {
			$(elm).hide();
		}
		if(val == 'alert') {
			link.attr( 'placeholder', '엘럿 메시지를 입력해 주세요.' );
		} else {
			link.attr( 'placeholder', 'http://' );
		}
	});
}



// color ──────────────────────────────────────────
function colorpicker(el, position='bottom') {
	$(el).each( function() {
		$(this).minicolors({
			control: $(this).attr('data-control') || 'hue',
			defaultValue: $(this).attr('data-defaultValue') || '',
			format: $(this).attr('data-format') || 'hex',
			keywords: $(this).attr('data-keywords') || '',
			inline: $(this).attr('data-inline') === 'true',
			letterCase: $(this).attr('data-letterCase') || 'lowercase',
			opacity: $(this).attr('data-opacity'),
			position: $(this).attr('data-position') || position,
			swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
			change: function(hex, opacity) {
			var log;
			try {
				log = hex ? hex : 'transparent';
				if( opacity ) log += ', ' + opacity;
				console.log(log);
				} catch(e) {}
			},
			theme: 'default'
		});
	});
}


function btnSubmit_active(el) {
	$(el).addClass('active');
}
function btnSubmit_cancel(el) {
	$(el).removeClass('active');
}

$(document).ready(function(){

	//input label ──────────────────────────────────────────
	$('input:not([type="checkbox"]):not([type="radio"]):not([type="file"]):not([type="range"])').each(function() {
		var label =  typeof $(this).attr('data-label') !== typeof undefined && $(this).attr('data-label') !== '' ? $(this).attr('data-label') : '',
			label_right =  typeof $(this).attr('data-label-right') !== typeof undefined && $(this).attr('data-label-right') !== '' ? $(this).attr('data-label-right') : '',
			label_inline =  typeof $(this).attr('data-label-inline') !== typeof undefined && $(this).attr('data-label-inline') !== '' ? $(this).attr('data-label-inline') : '',
			label_id =  typeof $(this).attr('data-id') !== typeof undefined && $(this).attr('data-id') !== '' ? $(this).attr('data-id') : '',
			thisClass = typeof $(this).attr('data-class') !== typeof undefined && $(this).attr('data-class') !== '' ? ' ' + $(this).attr('data-class') : '',
			icon =  typeof $(this).attr('data-icon') !== typeof undefined && $(this).attr('data-icon') !== '' ? $(this).attr('data-icon') : '';

		if(label || label_right || label_inline || icon) {
			var label_id = label_id ? 'id="' + label_id + '"' : '';
			if(!$(this).closest('.labelInput').length) {
				$(this).wrap('<label ' + label_id + ' class="labelInput' + thisClass + '"></label>');
			} else {
				$(this).closest('.labelInput').addClass(thisClass);
			}
			if(label) $(this).before('<span class="label">' + label + '</span>');
			if(label_right) $(this).after('<span class="label">' + label_right + '</span>');
			if(label_inline) {
				$(this).after('<span class="label-inline">' + label_inline + '</span>');
				var labelWidth = $(this).next('.label-inline').outerWidth();
				$(this).css({"padding-right":labelWidth});
			}
			if(icon) $(this).before('<span class="icon-' + icon  + '"></span>');
			if($(this).hasClass('w-full')) {
				$(this).parent('.labelInput').addClass('w-full');
			}			
		}
	});	

	$('.labelInput input').blur(function() {
		$(this).parent().removeClass("focus");
	}).focus(function() {
		$(this).parent().addClass("focus");
	});

	$('select').each(function() {
		var label =  typeof $(this).attr('data-label') !== typeof undefined && $(this).attr('data-label') !== '' ? $(this).attr('data-label') : '',
			label_right =  typeof $(this).attr('data-label-right') !== typeof undefined && $(this).attr('data-label-right') !== '' ? $(this).attr('data-label-right') : '',
			label_id =  typeof $(this).attr('data-id') !== typeof undefined && $(this).attr('data-id') !== '' ? 'id="'+$(this).attr('data-id')+'" ' : '',
			thisClass = typeof $(this).attr('data-class') !== typeof undefined && $(this).attr('data-class') !== '' ? ' ' + $(this).attr('data-class') : '',
			icon =  typeof $(this).attr('data-icon') !== typeof undefined && $(this).attr('data-icon') !== '' ? $(this).attr('data-icon') : '';
		var $select = $(this).parent('.bootstrap-select').length ? $(this).parent('.bootstrap-select') : $(this);

		if(label || label_right || label_id || icon) {
			if(!$(this).closest('.labelInput').length) {
				$select.wrap('<label class="labelInput labelSelect' + thisClass + '"></label>');				
			} else {
				$select.closest('.labelInput').addClass(thisClass);
			}
		}
		if(label) {
			$select.before('<span class="label">' + label + '</span>');
		}
		if(label_right) {
			$select.after('<span class="label">' + label_right + '</span>');
		}
		if(icon) $select.before('<span class="label selectcon-' + icon  + '"></span>');
	});


	// checkbox ──────────────────────────────────────────
	$('input[type="checkbox"]').each(function() {
		var wrap = $(this).parent('label'),
			thisClass = typeof $(this).attr('data-class') !== typeof undefined && $(this).attr('data-class') !== '' ? $(this).attr('data-class') : '';

		if($(this).hasClass('circle')) thisClass += ' circle';
		if($(this).hasClass('line')) thisClass += ' line';
		if($(this).hasClass('button')) thisClass += ' button';
		
		
		if($(this).hasClass('toggle-light')) {
			var label_on = typeof $(this).attr('data-on') !== typeof undefined && $(this).attr('data-on') !== '' ? $(this).attr('data-on') : '';
				label_off = typeof $(this).attr('data-off') !== typeof undefined && $(this).attr('data-off') !== '' ? $(this).attr('data-off') : '';
			$(this).removeClass('toggle-light');
			if(wrap.length == 0) {
				$(this).wrap('<label class="toggle-light '+thisClass+'"></label>');
			}
			if($(this).next('span').length == 0) {
				$(this).after('<span class="bg-circle"></span><span class="labelOn">' + label_on + '</span><span class="labelOff">' + label_off + '</span>');
			}
		} else {
			var label = typeof $(this).attr('data-label') !== typeof undefined && $(this).attr('data-label') !== '' ? $(this).attr('data-label') : '';
			if(wrap.length == 0) {
				$(this).wrap('<label class="checkbox-wrap"></label>');
			} else {
				wrap.addClass('checkbox-wrap');
			}
			if($(this).next('span').length == 0) {
				if($(this).hasClass('button')) {
					$(this).after('<span>' + label + '</span>');
				} else {
					$(this).after('<span></span>' + label);
				}
			}
		}
		if(thisClass) $(this).parent('.checkbox-wrap').addClass(thisClass);
	});
	
	// radio ──────────────────────────────────────────
	$('input[type="radio"]').each(function() {		
		var wrap = $(this).parent('label'),
			thisClass = typeof $(this).attr('data-class') !== typeof undefined && $(this).attr('data-class') !== '' ? $(this).attr('data-class') : '',
			label = typeof $(this).attr('data-label') !== typeof undefined && $(this).attr('data-label') !== '' ? $(this).attr('data-label') : '';

		if($(this).hasClass('circle')) thisClass += ' circle';
		if($(this).hasClass('line')) thisClass += ' line';
		if($(this).hasClass('button')) thisClass += ' button';
		if($(this).hasClass('radio-btn')) thisClass += ' radio-btn';
		
		if(wrap.length == 0) {
			$(this).wrap('<label class="radio-wrap"></label>');
		} else {
			wrap.addClass('radio-wrap');
		}

		if($(this).hasClass('radio-btn') || $(this).hasClass('button')) {
			if($(this).next('span').length == 0) {
				$(this).after('<span>' + label + '</span>');
			}
			$(this).removeClass('radio-btn');
			$(this).removeClass('button');
		} else {
			if($(this).next('span').length == 0) {
				$(this).after('<span></span>' + label);
			}
		}
		if(thisClass) $(this).parent('.radio-wrap').addClass(thisClass);
	});
	
	
	//모두선택 (채크박스) ──────────────────────────────────────────
	$('.chkall').each(function() {
		let chkall = $(this);
		let chk_name = chkall.attr('data-group');
		let chk = $('.' + chk_name);
		let btnsubmit = chkall.attr('data-active-btn');
		chkall.click(function() {
			if(chkall.is(":checked")) {
				chk.prop("checked", true);
				if(btnsubmit)
					btnSubmit_active(btnsubmit);
			} else {
				chk.prop("checked", false);
				if(btnsubmit)
					btnSubmit_cancel(btnsubmit);
			}
		});
		chk.click(function() {
			let total = chk.length;
			let checked = $('.' + chk_name + ':checked').length;
			
			if(total != checked) {
				chkall.prop("checked", false);
				if(btnsubmit)
					btnSubmit_cancel(btnsubmit);
			} else {
				chkall.prop("checked", true);
				if(btnsubmit)
					btnSubmit_active(btnsubmit);
			}
		});
	});
	
	// colorpicker
	colorpicker('.colorpicker');

	// datepicker ──────────────────────────────────────────
	$('input.datepicker').each(function() {
		var is_autoPick = typeof $(this).attr('placeholder') !== typeof undefined && $(this).attr('placeholder') !== '' ? false : true;		
		$(this).datepicker({
			language: 'ko-KR',
			autoPick: is_autoPick,
			format: 'yyyy.mm.dd'
		});
	});
	
	
	
	// 숫자만 입력 ──────────────────────────────────────────
	$("input.number").bind("keyup", function() {
		$(this).val($(this).val().replace(/[^0-9]/g,""));
	});

	// 휴대폰 번호 입력 ──────────────────────────────────────────
	function phoneFomatter(num,type) {
		var formatNum = '';
		if(num.length==11) {
			if(type==0) {
				formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-****-$3');
			} else {
				formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');
			}
		} else if(num.length==8) {
			formatNum = num.replace(/(\d{4})(\d{4})/, '$1-$2');
		} else {
			if(num.indexOf('02')==0) {
				if(type==0) {
					formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-****-$3');
				} else {
					formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-$2-$3');
				}
			} else {
				if(type==0){
					formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-***-$3');
				} else {
					formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');
				}
			}
		}
		return formatNum;
	}
	$("input.phone").bind("keyup", function(event) {
		$(this).val(phoneFomatter($(this).val().replace(/[^0-9]/g,"")));
	});


	// 날짜 입력 ──────────────────────────────────────────
	function dateFomatter(num,type) {
		var formatNum = '';
		formatNum = num.replace(/(\d{4})(\d{2})(\d{2})/, '$1-$2-$3');		

		return formatNum;
	}
	$("input.timer_date").bind("keyup", function(event) {
		$(this).val(dateFomatter($(this).val().replace(/[^0-9]/g,"")));
	});


	// 시간 입력 ──────────────────────────────────────────
	function timeFomatter(num,type) {
		var formatNum = '';
		formatNum = num.replace(/(\d{2})(\d{2})(\d{2})/, '$1:$2:$3');		

		return formatNum;
	}
	$("input.timer_time").bind("keyup", function(event) {
		$(this).val(timeFomatter($(this).val().replace(/[^0-9]/g,"")));
	});

	// PX or % 단위 자동변경 ──────────────────────────────────────────
	$('input.percent, input.per100').each( function() {
		var thisValue = $(this).val();
		var label = $(this).next('span');
		if(thisValue <= 100 && thisValue > 0) {
			label.html('%');
		} else {
			label.html('PX');
		}		
	});
	$('input.percent, input.per100').bind("keyup", function(event) {
		var thisValue = $(this).val();
		var label = $(this).next('span');
		if(thisValue <= 100 && thisValue > 0) {
			label.html('%');
		} else {
			label.html('PX');
		}
	});

	// PX or % 단위 자동변경 ──────────────────────────────────────────
	$('input.textlength').each( function() {
		var thisValue = $(this).val();
		var label = $(this).next('span');
		if(thisValue == 1) {
			label.html('줄 자르기');
		} else {
			label.html('글자');
		}		
	});
	$('input.textlength').bind("keyup", function(event) {
		var thisValue = $(this).val();
		var label = $(this).next('span');
		if(thisValue == 1) {
			label.html('줄 자르기');
		} else {
			label.html('글자');
		}
	});


	//textarea label ──────────────────────────────────────────
	/*$('textarea').each(function() {
		var label =  typeof $(this).attr('data-label') !== typeof undefined && $(this).attr('data-label') !== '' ? $(this).attr('data-label') : '',
			icon =  typeof $(this).attr('data-icon') !== typeof undefined && $(this).attr('data-icon') !== '' ? $(this).attr('data-icon') : '';

		if(label || icon) {
			if(!$(this).closest('.labelTextarea').length) {
				$(this).wrap('<label class="labelTextarea"></label>');
			}
			if(label) $(this).before('<span class="textare-label">' + label + '</span>');
			if(icon) $(this).before('<span class="textare-label icon-' + icon  + '"></span>');

			if($(this).hasClass('w-full')) {
				$(this).parent('.labelTextarea').addClass('w-full');
			}			
		}
	});
	$('.labelTextarea textarea').blur(function() {
		$(this).parent().removeClass("focus");
	}).focus(function() {
		$(this).parent().addClass("focus");
	});*/
	
	// textarea 자동조절 ──────────────────────────────────────────
	function textareaResize(obj) {
		obj.style.height = "1px";
		obj.style.height = (2+obj.scrollHeight)+"px";
	}
	$("textarea.autosize").bind("keypress", function(event) {
		textareaResize(this);
	});
	$("textarea.autosize").bind("keyup", function(event) {
		textareaResize(this);
	});
	

	
	
	// 글자수 제한 ──────────────────────────────────────────
	$('.limited').keyup(function () {
		let content = $(this).val();
		let max = $(this).attr('data-maxlength');
		if (content.length == 0 || content == '') {
			$('.textCount').text('0');
		} else {
			$('.textCount').text(content.length);
		}
		if (content.length > max) {			
			$(this).val($(this).val().substring(0, max));
			alert('글자수는 ' + max + '자까지 입력 가능합니다.');
		};
	});


	//pc,mobile Tabs ──────────────────────────────────────────
	$(".wrConTabs li").click(function(){
		$(this).siblings("li").removeClass('active');
		$(this).addClass('active');
		var target = $(this).attr('data-target');
		var $this = $(this).parent().parent();
		var $thisTarget = $this.find(".tabEditor." + target);
		$this.find(".tabEditor").removeClass('active');
		$thisTarget.addClass('active');
	});
	
	
	// 쓰기페이지 링크관련 ──────────────────────────────────────────
	matchOnOff('#wr_link_target', 'attach', '#link-name');
	matchOnOff('#wr_link_target', 'popup', '#popup-option');
	$('#wr_link_target').change(function (){
		var val = $(this).val();
		if(val == 'alert') {
			$('#wr_link1').attr( 'placeholder', '엘럿 메시지를 입력해 주세요.' );
		} else {
			$('#wr_link1').attr( 'placeholder', 'http://' );
		}
	});
	

	btn_target('select.btn-target');

	/*$('select.btn-target').each(function() {
		var val = $(this).val(),
			elm = $(this).parent().siblings('.btnPopupOption');			
		elm.hide();
		if(val == 'popup') elm.show();
	});
	$('select.btn-target').change(function (){
		//elm.css({'border':'1px solid red'});
		var val = $(this).val(),
			elm = $(this).parent().siblings('.btnPopupOption'),
			link = $(this).parent().siblings('.btn-link');	
		if(val == 'popup') {
			$(elm).show();
		} else {
			$(elm).hide();
		}
		if(val == 'alert') {
			link.attr( 'placeholder', '엘럿 메시지를 입력해 주세요.' );
		} else {
			link.attr( 'placeholder', 'http://' );
		}
	});*/
	
	// 이메일 유효성 채크 ──────────────────────────────────────────
	function email_check( email ) {
		let regex=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		return (email != '' && email != 'undefined' && regex.test(email)); 
	}
	function emailCheck(el) {
		let email = el.val();
		if( email == '' || email == 'undefined') {
			$(".emailCheck-msg").text('').removeClass('checked');
			return;
		}
		if(! email_check(email) ) {
			$(".emailCheck-msg").text('※ 이메일 형식으로 적어주세요').removeClass('checked');
			$(this).focus();
			return false;
		} else {
			$(".emailCheck-msg").text('').addClass('checked');
		}
	}
	emailCheck($('input.emailCheck'));
	//$("input.emailCheck").blur(function(){
	$("input.emailCheck").bind("keyup", function(event) {
		emailCheck($(this));
	});



	// file ──────────────────────────────────────────
	$('input[type="file"].myfile').each(function(index) {
		let className = $(this).attr('data-class') ? $(this).attr('data-class') : '',
			btnName = $(this).attr('data-btn-name') ? $(this).attr('data-btn-name') : '파일찾기',
			maxSize = typeof $(this).attr('data-maxSize') !== typeof undefined && $(this).attr('data-maxSize') !== '' ? $(this).attr('data-maxSize') : '',
			fileMaxSize = maxSize * 1024 * 1024,
			upload = $(this)[0],
			upImg = $(this).siblings('.upImg'),
			upfile = $(this).siblings('.upfile');

		if($(this).closest('.fileImgSet').length) {
			$(this).wrap('<label class="labelImg uploadSet"></label>');
			$(this).parent('label').append(upImg);
			$(this).addClass('upload-hidden').attr('id', 'upload_' + index);
		} else {		
			if(!$(this).closest('.filebox').length) {
				$(this).wrap('<div class="filebox ' + className + '"></div>');		
			} else {
				$(this).closest('.filebox').addClass(className);
			}
			$(this).addClass('upload-hidden').attr('id', 'upload_' + index);

			if($(this).hasClass('btnfile')) {
				$(this).after('<div class="uploadSet btnfile"><label for="upload_' + index + '" class="filebutton">' + btnName + '</label></div>');
			} else if($(this).hasClass('btnImg')) {
				$(this).after('<div class="uploadSet btnfile"><label for="upload_' + index + '" class="filebutton">' + btnName + '</label></div>');
			} else {
				$(this).after('<div class="uploadSet"><input type="text" value="선택된 파일이 없습니다." class="upload-name" disabled="disabled"><label for="upload_' + index + '" class="upload-btn">' + btnName + '</label></div>');
			}

			if(upfile.length) {
				upfile.insertAfter($(this).next('.uploadSet')).attr('id', 'holder_' + index);
			}
		}

		$(this).on('change', function(){ // 값이 변경되면
			let uploadSize = $(this)[0].files[0].size;
			upfile = $(this).siblings('.upfile');
			if(maxSize && uploadSize > fileMaxSize) {
				alert("첨부할 수 있는 파일은 " + maxSize + "MB 이하여야 합니다.");
				$(this).val('');
				return false;
			}
			if(window.FileReader){ // modern browser
				var filename = $(this)[0].files[0].name;
			} else { // old IE
				var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출
			} // 추출한 파일명 삽입
			
			if(!$(this).closest('.fileImgSet').length) {
				if($(this).hasClass('btnfile')) {
					if(upfile.length) {
						upfile.html('<span class="info">' + filename + '</span>');
					} else {
						$(this).siblings('.uploadSet').after('<div class="upfile"><span class="info">' + filename + '</span></div>');
					}
				} else {
					$(this).siblings('.uploadSet').find('.upload-name').val(filename);
				}
			}
		});

		if(upImg.length) {
			let upload = $(this)[0];
			if($(this).closest('.fileImgSet').length) {
				upImg.attr('id', 'holder_' + index);
			} else {
				upImg.insertAfter($(this).next('.uploadSet')).attr('id', 'holder_' + index);
			}
			let holder = document.getElementById('holder_' + index);
			upload.onchange = function (e) {
				e.preventDefault();
				var file = upload.files[0],
				reader = new FileReader();
				reader.onload = function (event) {
					var img = new Image();
					img.src = event.target.result;
					holder.innerHTML = '';
					holder.appendChild(img);
				};
				reader.readAsDataURL(file);
				return false;
			};
		}

	});

	$('.rangeContainer').each(function() {
		var slider = $(this).find("input"),
			fill = $(this).find(".range-track-fill");
			val = slider.val(),
			per = Math.floor((100 / (slider.attr('max') - slider.attr('min'))) * (val - 1));
		fill.css({'width':per + '%'});

		slider.on('input', function() {
		//slider.change(function (){
			var val = $(this).val(),
				per = Math.floor((100 / (slider.attr('max') - slider.attr('min'))) * (val - 1));
			fill.css({'width':per + '%'});
		});		
	});


	// 새로운 파일 업로드 처리를 위한 스크립트 추가
	$('input[type="file"].myfile1').each(function(index) {
		let className = $(this).attr('data-class') ? $(this).attr('data-class') : '',
			btnName = $(this).attr('data-btn-name') ? $(this).attr('data-btn-name') : '파일찾기',
			maxSize = typeof $(this).attr('data-maxSize') !== typeof undefined && $(this).attr('data-maxSize') !== '' ? $(this).attr('data-maxSize') : '',
			fileMaxSize = maxSize * 1024 * 1024,
			upload = $(this)[0],
			upImg = $(this).siblings('.upImg1'),
			upfile = $(this).siblings('.upfile');

		if($(this).closest('.fileImgSet').length) {
			$(this).wrap('<label class="labelImg uploadSet"></label>');
			$(this).parent('label').append(upImg);
			$(this).addClass('upload-hidden').attr('id', 'upload1_' + index);
		} else {        
			if(!$(this).closest('.filebox').length) {
				$(this).wrap('<div class="filebox ' + className + '"></div>');        
			} else {
				$(this).closest('.filebox').addClass(className);
			}
			$(this).addClass('upload-hidden').attr('id', 'upload1_' + index);
			if($(this).hasClass('btnfile')) {
				$(this).after('<div class="uploadSet btnfile"><label for="upload1_' + index + '" class="filebutton">' + btnName + '</label></div>');
			} else if($(this).hasClass('btnImg')) {
				$(this).after('<div class="uploadSet btnfile"><label for="upload1_' + index + '" class="filebutton">' + btnName + '</label></div>');
			} else {
				$(this).after('<div class="uploadSet"><input type="text" value="선택된 파일이 없습니다." class="upload-name" disabled="disabled"><label for="upload1_' + index + '" class="upload-btn">' + btnName + '</label></div>');
			}
			if(upfile.length) {
				upfile.insertAfter($(this).next('.uploadSet')).attr('id', 'holder1_' + index);
			}
		}

		$(this).on('change', function(){ // 값이 변경되면
			let uploadSize = $(this)[0].files[0].size;
			upfile = $(this).siblings('.upfile');
			if(maxSize && uploadSize > fileMaxSize) {
				alert("첨부할 수 있는 파일은 " + maxSize + "MB 이하여야 합니다.");
				$(this).val('');
				return false;
			}
			if(window.FileReader){ // modern browser
				var filename = $(this)[0].files[0].name;
			} else { // old IE
				var filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출
			}
			
			if(!$(this).closest('.fileImgSet').length) {
				if($(this).hasClass('btnfile')) {
					if(upfile.length) {
						upfile.html('<span class="info">' + filename + '</span>');
					} else {
						$(this).siblings('.uploadSet').after('<div class="upfile"><span class="info">' + filename + '</span></div>');
					}
				} else {
					$(this).siblings('.uploadSet').find('.upload-name').val(filename);
				}
			}
		});

		if(upImg.length) {
			let upload = $(this)[0];
			if($(this).closest('.fileImgSet').length) {
				upImg.attr('id', 'holder1_' + index);
			} else {
				upImg.insertAfter($(this).next('.uploadSet')).attr('id', 'holder1_' + index);
			}
			let holder = document.getElementById('holder1_' + index);
			upload.onchange = function (e) {
				e.preventDefault();
				var file = upload.files[0],
				reader = new FileReader();
				reader.onload = function (event) {
					// 파일 타입에 따라 다르게 처리
					if(file.type.startsWith('video/')) {
						var video = document.createElement('video');
						video.src = event.target.result;
						video.controls = true;
						video.muted = true;
						video.autoplay = true;
						video.loop = true;
						video.style.width = '100%';
						video.style.height = '100%';
						video.style.objectFit = 'cover';
						video.style.position = 'absolute';
						video.style.top = '0';
						video.style.left = '0';
						video.style.zIndex  = '999';
						holder.innerHTML = '';
						holder.appendChild(video);
					} else {
						var img = new Image();
						img.src = event.target.result;
						holder.innerHTML = '';
						holder.appendChild(img);
					}
				};
				reader.readAsDataURL(file);
				return false;
			};
		}
	});
	
	
	

});



//엘리먼트오프 //match값은 ,구분 여러개 가능
function matchOff(elm, match, target) {
	var val = $(elm).val();
	var arrMatch = match.split(",");
	for(var i in arrMatch) {
		if(val == arrMatch[i]) {
			$(target).hide();			
		}
	}
	$(elm).change(function (){
		var val = $(this).val();
		for(var i in arrMatch) {
			if(val == arrMatch[i]) {		
				$(target).hide();		
			}
		}
	});
}
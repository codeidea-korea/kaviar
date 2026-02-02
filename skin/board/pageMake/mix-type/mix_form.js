
$(document).ready(function(){
	
	$('select').selectpicker('refresh');
	

	//file - bgImg
	$('input[type="file"].bgImg').each(function(index) {
		let upload = $(this)[0];
		$(this).parent('.mix-thumb').attr('id', 'bgImg-holder-' + index);
		let holder = document.getElementById('bgImg-holder-' + index);
		upload.onchange = function (e) {
			e.preventDefault();
			let file = upload.files[0],
			reader = new FileReader();
			reader.onload = function (event) {
				let img = new Image();
				img.src = event.target.result;
				//holder.style.backgroundImage = '';
				holder.style.backgroundImage = "url("+event.target.result+")";  
			};
			reader.readAsDataURL(file);
			return false;
		};
	});

	//file - img
	$('input[type="file"].img').each(function(index) {
		let upload = $(this)[0];
		//let holder = $(this).siblings('.img-holder');
		$(this).siblings('.img-holder').attr('id', 'img-holder-' + index);
		let holder = document.getElementById('img-holder-' + index);
		//let holder = document.getElementById('holder_' + index);
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
	});

	//file - myfile
	$('input[type="file"].myfile').each(function(index) {
		let className = $(this).attr('class') ? $(this).attr('class') : '',
			btnName = $(this).attr('data-btn-name') ? $(this).attr('data-btn-name') : '파일찾기',
			maxSize = typeof $(this).attr('data-maxSize') !== typeof undefined && $(this).attr('data-maxSize') !== '' ? $(this).attr('data-maxSize') : '',
			fileMaxSize = maxSize * 1024 * 1024,
			upDiv = $(this).siblings('.upImg, .upFile'),
			upload = $(this)[0];
		$(this).next('.upImg').attr('id', 'holder_' + index);
		let holder = document.getElementById('holder_' + index);

		$(this).wrap('<div class="filebox ' + className + '"></div>');
		if(upDiv.length) upDiv.insertAfter($(this));
		//$(this).parent().siblings('.upImg, .upFile').insertAfter($(this));
		$(this).attr('id', 'upload_' + index);
		$(this).addClass('upload-hidden');

		if($(this).hasClass('btnFile') || $(this).hasClass('btnImg')) {
			$(this).before('<div class="uploadSet"><label for="upload_' + index + '" class="upload-btn">' + btnName + '</label></div>');
			if($(this).hasClass('btnFile')) $(this).after('<div class="upFile"></div>');
		} else {
			$(this).before('<div class="uploadSet"><input type="text" value="선택된 파일이 없습니다." class="upload-name" disabled="disabled"><label for="upload_' + index + '" class="upload-btn">' + btnName + '</label></div>');
		}
		
		$(this).on('change', function(e){ // 값이 변경되면
			let uploadSize = $(this)[0].files[0].size;
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

			if($(this).hasClass('btnFile')) {
				$(this).siblings('.upFile').html('<span class="info">' + filename + '</span>');
			} else if(!$(this).hasClass('btnImg')){
				$(this).siblings('.uploadSet').find('.upload-name').val(filename);
			}

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
		});
	});

	$('.fillCheck').each( function() {
		var val = $(this).val();
		if(val == '') {
			$(this).removeClass('fill');
		} else {
			$(this).addClass('fill');
		}
	});
	$(".fillCheck").bind("keyup", function(event) {
		var val = $(this).val();
		if(val == '') {
			$(this).removeClass('fill');
		} else {
			$(this).addClass('fill');
		}
	});
	//textarea 자동조절
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

	

	




});
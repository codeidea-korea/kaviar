<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);
?>

<div id="qa-form" class="_modal_popup">
	
	<div class="form-head">
		<div class="title">상품문의</div>
	</div>

    <form name="fitemqa" method="post" action="<?php echo G5_SHOP_URL;?>/itemqaformupdate.php" onsubmit="return fitemqa_submit(this);" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
    <input type="hidden" name="is_mobile_shop" value="1">
	<div class="form-body">
		
		<div class="item-subject border-bottom"><?=$it['it_name']?></div>		
		
		<ul class="formContainer">
			<li>
				<select name="iq_subject" class="selectpicker w-full" required>
					<?php					
					echo option_selected("",  $qa['iq_subject'], "상품문의 유형 선택");
					echo option_selected("상품문의",  $qa['iq_subject'], "상품문의");
					echo option_selected("배송 문의",  $qa['iq_subject'], "배송 문의");
					echo option_selected("교환 반품 문의",  $qa['iq_subject'], "교환 반품 문의");
					echo option_selected("환불 문의",  $qa['iq_subject'], "환불 문의");
					echo option_selected("기타",  $qa['iq_subject'], "기타");
					?>
				</select>
			</li>
			
			<li>
				<label for="iq_question" class="sound_only">질문</label>
				<?php echo $editor_html; ?>
			</li>
			<li>
				<label class="checkbox-wrap fs13 color-gray2"><input type="checkbox" name="iq_secret" id="iq_secret" value="1" <?php echo $chk_secret; ?>><span></span>비밀글로 문의하기</label>
			</li>
		</ul>
		
		<div class="px20">
			<div class="fs16 bold mt30">사진/영상업로드</div>
			<ul class="fileImgSet mt10" style="--img-size:120px">
				<?php
				$re_width = 200;
				for($i=1; $i<=5; $i++) {
					echo '<li class="img_li">';
						echo '<input type="file" name="iq_img'.$i.'" id="iq_img'.$i.'" class="myfile1">';
						echo '<div class="upImg1">';
						//업로드된 이미지가 있다면 여기에 출력
						echo '</div>';
						if($iq_img_exists) echo '<input type="checkbox" name="iq_img'.$i.'_del" id="iq_img'.$i.'_del" value="1" data-label="파일삭제">'; //$iq_img_exists -> 이미지가 있을때
						if($iq_img_exists) echo '<a href="'.$it_img_url.'" class="view_ori_img" target="_blank">원본보기</a>'; //$iq_img_exists -> 이미지가 있을때
					echo '</li>';
				} ?>
			</ul>
		</div>

		<div class="form-btnSet">				
			<span class="_btn/line/md modalClose">닫기</span>
			<button type="submit" class="_btn/md btn_submit">작성완료</button>
		</div>
	
	</div>
    </form>

</div>

<script>
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
</script>


<script type="text/javascript">
$('.selectpicker').selectpicker('refresh');

function fitemqa_submit(f)
{
    <?php echo $editor_js; ?>

    return true;
}
</script>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$add_headfile_skin = true;
include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 사용후기 쓰기 시작 { -->
<div id="review-form" class="new_win">
    <h1 id="win_title">사용후기 쓰기</h1>

    <form name="fitemuse" method="post" enctype="multipart/form-data" action="<?php echo G5_SHOP_URL;?>/itemuseformupdate.php" onsubmit="return fitemuse_submit(this);" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="is_id" value="<?php echo $is_id; ?>">
	<input type="hidden" name="ct_id" value="<?php echo $ct_id; ?>">

    <div class="new_win_con form_01">
        <ul class="formContainer" style="--label-width:100px;">
			<li>
				<div class="label">제목</div>
				<input type="text" name="is_subject" value="<?php echo get_text($use['is_subject']); ?>" id="is_subject" required class="required w-full" minlength="5" maxlength="250" placeholder="제목을 입력해 주세요">
			</li>
			<?php if($default['shop_use_it_avg']) {
				echo '<li>';
					echo '<div class="w-full tcenter">';
						echo '<p class="fs15 fw500 tcenter mb10">상품을 평가해 주세요</p>';
						echo '<div class="flex flex-center">';
							echo '<div class="star-rating">';
								echo '<input type="radio" name="is_score" value="5" id="rate5" '.($is_score==5?'checked="checked"':'').'><label for="rate5"></label>';
								echo '<input type="radio" name="is_score" value="4" id="rate4" '.($is_score==4?'checked="checked"':'').'><label for="rate4"></label>';
								echo '<input type="radio" name="is_score" value="3" id="rate3" '.($is_score==3?'checked="checked"':'').'><label for="rate3"></label>';
								echo '<input type="radio" name="is_score" value="2" id="rate2" '.($is_score==2?'checked="checked"':'').'><label for="rate2"></label>';
								echo '<input type="radio" name="is_score" value="1" id="rate1" '.($is_score==1?'checked="checked"':'').'><label for="rate1"></label>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</li>';
			} else {
				echo '<input type="hidden" name="is_score" value="'.$is_score.'">';
			} ?>
			<li>
				<span class="sound_only">내용</span>
				<?php echo $editor_html; ?>
			</li>
			<?php if($default['de_review_guide']) { ?>
			<li>
				<div class="textbox">
					<?php
					$de_review_guide = $default['de_review_guide'] ? nl2br($default['de_review_guide']) : '';
					$de_review_guide_arr = explode(PHP_EOL, $de_review_guide);
					$reviewGuideSet = '';
					for($t=0; $t<count($de_review_guide_arr); $t++) {
						$reviewGuideSet .= $t==0 ? '<h3>'.$de_review_guide_arr[0].'</h3>' : '<p>'.$de_review_guide_arr[$t].'</p>';
					}
					echo $reviewGuideSet;
					?>
				</div>
			</li>
			<?php } ?>
		</ul>

		<div class="fs16 bold mt30">사진업로드</div>
		<ul class="fileImgSet mt10" style="--img-size:120px">
			<?php
			$re_width = 200;
			for($i=1; $i<=5; $i++) {
				echo '<li class="img_li">';
					echo '<input type="file" name="re_img'.$i.'" id="re_img'.$i.'" class="myfile1">';
					echo '<div class="upImg1">';
					//업로드된 이미지가 있다면 여기에 출력
					echo '</div>';
					if($re_img_exists) echo '<input type="checkbox" name="re_img'.$i.'_del" id="re_img'.$i.'_del" value="1" data-label="파일삭제">'; //$re_img_exists -> 이미지가 있을때
					if($re_img_exists) echo '<a href="'.$it_img_url.'" class="view_ori_img" target="_blank">원본보기</a>'; //$re_img_exists -> 이미지가 있을때
				echo '</li>';
			} ?>
		</ul>

        <div class="win_btn mt30">
            <button type="submit" class="btn_submit _btn/lg/mainColor">작성완료</button>
            <button type="button" onclick="self.close();" class="btn_close">닫기</button>
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
function fitemuse_submit(f)
{
    <?php echo $editor_js; ?>

    return true;
}
</script>
<!-- } 사용후기 쓰기 끝 -->
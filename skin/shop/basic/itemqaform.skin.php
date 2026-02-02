<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

//$add_headfile_skin = true;
//include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.G5_JS_URL.'/my/form/bootstrap-select/bootstrap.min.js"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.js').'"></script>', 1);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/_common.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>', 1);
?>

<!-- 상품문의 쓰기 시작 { -->
<div id="sit_qa_write" class="new_win">
    <h1 id="win_title">상품문의 쓰기</h1>

    <form name="fitemqa" method="post" action="<?php echo G5_SHOP_URL;?>/itemqaformupdate.php" onsubmit="return fitemqa_submit(this);" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w; ?>">
    <input type="hidden" name="it_id" value="<?php echo $it_id; ?>">
    <input type="hidden" name="iq_id" value="<?php echo $iq_id; ?>">
	<input type="hidden" name="iq_email" value="<?php echo $member['mb_email']; ?>">
	<input type="hidden" name="iq_hp" value="<?php echo $member['mb_hp']; ?>">

    <div class="form_01 new_win_con">
		
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

		<div class="fs16 bold mt30">사진/영상 업로드</div>
		<ul class="fileImgSet mt10" style="--img-size:120px">
			<?php
			$re_width = 200;
			for($i=1; $i<=5; $i++) {
				$it_img_urls = G5_URL."/data/shop_qa/".$qa['iq_img'.$i];
				echo '<li class="img_li">';
					echo '<input type="file" name="iq_img'.$i.'" id="iq_img'.$i.'" class="myfile1">';
					echo '<div class="upImg1">';
					//업로드된 이미지가 있다면 여기에 출력
					echo '</div>';
					if($qa['iq_img'.$i]) echo '<input type="checkbox" name="iq_img'.$i.'_del" id="iq_img'.$i.'_del" value="1" data-label="파일삭제">'; //$iq_img_exists -> 이미지가 있을때
					if($qa['iq_img'.$i]) echo '<a href="'.$it_img_urls.'" class="view_ori_img" target="_blank">원본보기</a>'; //$iq_img_exists -> 이미지가 있을때
				echo '</li>';
			} ?>
		</ul>
        
        <div class="win_btn">
            <button type="submit" class="btn_submit _btn/lg w-150">작성완료</button>
            <button type="button" onclick="self.close();" class="btn_close">닫기</button>
        </div>
    </div>
    </form>
</div>

<script type="text/javascript">
function fitemqa_submit(f)
{
    <?php echo $editor_js; ?>

    return true;
}
</script>
<!-- } 상품문의 쓰기 끝 -->
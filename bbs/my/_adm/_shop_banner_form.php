<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$bn_id = isset($_REQUEST['bn_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['bn_id']) : 0;
$bn = array(
	'bn_id'=>0,
	'bn_alt'=>'',
	'bn_device'=>'',
	'bn_position'=>'',
	'bn_border'=>'',
	'bn_new_win'=>'',
	'bn_order'=>''
);

$html_title = '배너';
$g5['title'] = $html_title.'관리';

if ($w=="u") {
    $html_title .= ' 수정';
    $sql = " select * from {$g5['g5_shop_banner_table']} where bn_id = '$bn_id' ";
    $bn = sql_fetch($sql);
} else {
    $html_title .= ' 입력';
	if($bn_position) $bn['bn_position'] = $bn_position;
	if($bn_cate) $bn['bn_cate'] = $bn_cate;
    $bn['bn_url']        = "http://";
    $bn['bn_begin_time'] = date("Y-m-d 00:00:00", time());
    //$bn['bn_end_time']   = date("Y-m-d 00:00:00", time()+(60*60*24*31));
}

$select_bn_position_style = '';
if($bn['bn_position']=='메인 팝업') $select_bn_position_style = ' data-style="selectColor-green"';
if($bn['bn_position']=='상단 띠배너') $select_bn_position_style = ' data-style="selectColor-pink-light"';
if($bn['bn_position']=='사이드 배너') $select_bn_position_style = ' data-style="selectColor-pink-light"';

$shop_banner_category = explode('|', $default['shop_banner_category']);
?>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_banner_form_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">
<input type="hidden" name="callback_url" value="<?=$_adm_url?>/?<?=$is_tab?'tab=1&':''?>pn=_shop_banner<?=$bn_position?'&bn_position='.$bn_position:''?><?=$bn_cate?'&bn_cate='.$bn_cate:''?>">

<section class="mybox blue">

	<div class="formContainer label140">
		<div class="form-list">
			<div class="form-label"><label>출력 순서</label></div>
			<div class="formCon">
				<input type="text" name="bn_order" value="<?=$bn['bn_order']?$bn['bn_order']:'0'?>" class="w-50">
				<span class="help-block">배너를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다.</span>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>접속기기</label></div>
			<div class="formCon">
				<select name="bn_device" id="bn_device">
					<option value="both"<?php echo get_selected($bn['bn_device'], 'both', true); ?>>PC와 모바일</option>
					<option value="pc"<?php echo get_selected($bn['bn_device'], 'pc'); ?>>PC</option>
					<option value="mobile"<?php echo get_selected($bn['bn_device'], 'mobile'); ?>>모바일</option>
				</select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>이미지</label></div>
			<div class="formCon flex flex-top gap60">
				<div class="banner_img">
					<input type="file" name="bn_bimg" class="myfile">
					<div class="banner_or_img upImg">
					<?php
					$bimg_str = "";
					$bimg = G5_DATA_PATH."/banner/{$bn['bn_id']}";
					if (file_exists($bimg) && $bn['bn_id']) {
						$size = @getimagesize($bimg);
						if($size[0] && $size[0] > 750)
							$width = 750;
						else
							$width = $size[0];
						
						$bimg_str = '<img src="'.G5_DATA_URL.'/banner/'.$bn['bn_id'].'">';
						$bimg_str .= '<label><input type="checkbox" name="bn_bimg_del" value="1" id="bn_bimg_del">삭제</label>';
					}
					if ($bimg_str) {
						echo $bimg_str;
					}
					?>
					</div>
				</div>
				<div class="banner_position">
					<select name="bn_position" id="bn_position" data-label="출력위치"<?=$select_bn_position_style?>>
						<option value="" <?php echo get_selected($bn['bn_position'], '블럭용'); ?>>블럭용</option>
						<option value="메인 팝업" <?php echo get_selected($bn['bn_position'], '메인 팝업'); ?>>메인 팝업</option>
						<option value="상단 띠배너" <?php echo get_selected($bn['bn_position'], '상단 띠배너'); ?>>상단 띠배너</option>	
						<?php if($default['shop_layout'] == 'outside-right') { ?>
						<option value="사이드 배너" <?php echo get_selected($bn['bn_position'], '사이드 배너'); ?>>사이드 배너</option>	
						<?php } ?>
						<option value="로그인 페이지" <?php echo get_selected($bn['bn_position'], '로그인 페이지'); ?>>로그인 페이지</option>	
						<option value="장바구니" <?php echo get_selected($bn['bn_position'], '장바구니'); ?>>장바구니</option>	
						<option value="마이페이지" <?php echo get_selected($bn['bn_position'], '마이페이지'); ?>>마이페이지</option>	
						<option value="상품상세" <?php echo get_selected($bn['bn_position'], '상품상세'); ?>>상품상세</option>	
					</select>
					<?php if($default['shop_banner_category']) { ?>
					<span class="bn_cate_wrapper ml15">
						<select name="bn_cate" id="bn_cate" data-label="배너 분류"<?=$bn['bn_cate']?' data-style="selectColor-gray"':''?>>						
							<option value="" <?php echo get_selected($bn['bn_cate'], '분류 없음'); ?>>분류 없음</option>
							<?php for($i=0; $i<count($shop_banner_category); $i++) {
								echo '<option value="'.$shop_banner_category[$i].'" '.get_selected($bn['bn_cate'], $shop_banner_category[$i]).'>'.$shop_banner_category[$i].'</option>';
							} ?>				
						</select>
					</span>
					<script>matchOnOff('#bn_position', '', '.bn_cate_wrapper');</script>
					<?php } ?>
					<span class="bn_location_wrapper ml15">
						<select name="bn_location" id="bn_location" data-label="출력할 페이지"<?=$bn['bn_location']?' data-style="selectColor-gray"':''?>>
							<option value="" <?php echo get_selected($bn['bn_location'], '메인페이지만 출력'); ?>>메인페이지만 출력</option>
							<option value="all" <?php echo get_selected($bn['bn_location'], '모든페이지 출력'); ?>>모든페이지 출력</option>
						</select>
					</span>
					<script>matchOnOff('#bn_position', '상단 띠배너', '.bn_location_wrapper');</script>
					<div class="help-block mt10" style="line-height:1.7em;">
						블럭용(기본) : 쇼핑몰 각페이지에서 별도 설정에 따라 출력합니다.<br>
						메인 팝업 : 쇼핑몰 초기화면(메인페이지)에서 팝업형식으로 출력합니다.<br>
						상단 띠배너 : 쇼핑몰화면 최상단에 바형태로 출력되는 배너입니다.<br>
						사이드 배너 : 쇼핑몰화면 왼쪽 또는 오른쪽에 출력합니다.<br>
						<p class="ml75 -mt5" style="">(쇼핑몰 기본레이아웃에 따라 출력여부가 달라질 수 있습니다.)</p>
						로그인 페이지 : 쇼핑몰 로그인 페이지에 출력합니다.<br>	
						장바구니 : 장바구니 페이지에 출력합니다.<br>	
						마이페이지 : 로그인 이후 쇼핑몰 마이페이지에 출력합니다.<br>
						상품상세 : 상품상세 페이지 내에 출력합니다.
					</div>
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>이미지 <span class="fs11 color-red">(모바일)</span></label></div>
			<div class="formCon flex flex-top gap60">
				<div class="banner_img">
					<input type="file" name="bn_bimg2" class="myfile">
					<div class="banner_or_img upImg">
					<?php
					$bimg2_str = "";
					$bimg2 = G5_DATA_PATH."/banner/{$bn['bn_id']}_2";
					if (file_exists($bimg2) && $bn['bn_id']) {
						$size = @getimagesize($bimg2);
						if($size[0] && $size[0] > 750)
							$width = 750;
						else
							$width = $size[0];
						
						$bimg2_str = '<img src="'.G5_DATA_URL.'/banner/'.$bn['bn_id'].'_2">';
						$bimg2_str .= '<label><input type="checkbox" name="bn_bimg2_del" value="1" id="bn_bimg2_del">삭제</label>';
					}
					if ($bimg2_str) {
						echo $bimg2_str;
					}
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>배너 링크</label></div>
			<div class="formCon flex flex-middle gap10">
				<input type="text" name="bn_url" size="80" value="<?php echo get_sanitize_input($bn['bn_url']); ?>" id="bn_url" class="flex1">
				<select name="bn_new_win" id="bn_new_win">
					<option value="0" <?php echo get_selected($bn['bn_new_win'], 0); ?>>바로가기</option>
					<option value="1" <?php echo get_selected($bn['bn_new_win'], 1); ?>>새창 열기</option>
				</select>
			</div>
		</div>				
		<div class="form-list">
			<div class="form-label"><label>배너 게시 시작일</label></div>
			<div class="formCon flex flex-middle gap15">
				<input type="text" name="bn_begin_time" value="<?php echo $bn['bn_begin_time']; ?>" id="bn_begin_time" class="frm_input"  size="21" maxlength="19">
				<input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;" data-label="오늘">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>배너 게시 종료일</label></div>
			<div class="formCon flex flex-middle gap15">
				<input type="text" name="bn_end_time" value="<?php echo $bn['bn_end_time']; ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
				<input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time()+60*60*24*31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;" data-label="오늘+31일">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>이미지 설명</label></div>
			<div class="formCon">
				<?php echo help("img 태그의 alt, title 에 해당되는 내용입니다. 배너에 마우스를 오버하면 이미지의 설명이 나옵니다."); ?>
				<input type="text" name="bn_alt" value="<?php echo get_text($bn['bn_alt']); ?>" id="bn_alt" class="frm_input" size="80">
			</div>
		</div>
		<div class="form-list none">
			<div class="form-label"><label>테두리</label></div>
			<div class="formCon">
			<?php echo help("배너이미지에 테두리를 넣을지를 설정합니다.", 50); ?>
			<select name="bn_border" id="bn_border">
				<option value="0" <?php echo get_selected($bn['bn_border'], 0); ?>>사용안함</option>
				<option value="1" <?php echo get_selected($bn['bn_border'], 1); ?>>사용</option>
			</select>
			</div>
		</div>		
	</div>

</section>

 <div class="_adm_btnSet">
 	<a href="<?=$_SERVER["HTTP_REFERER"]?>" class="btn_02 btn w-70">취소</a>
	<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>







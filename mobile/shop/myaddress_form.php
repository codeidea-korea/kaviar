<?php
include_once('./_common.php');

// 테마에 myaddress_form.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_myaddress_form_file = file_exists(G5_THEME_MSHOP_PATH.'/myaddress_form.php') ? G5_THEME_MSHOP_PATH.'/myaddress_form.php' : G5_THEME_SHOP_PATH.'/myaddress_form.php';
    if(is_file($theme_myaddress_form_file)) {
        include_once($theme_myaddress_form_file);
        return;
        unset($theme_myaddress_form_file);
    }
}


if($w=='u') {
	$g5['title'] = "배송지 수정";
	$head_title = '배송지 수정';
} else {
	$g5['title'] = "배송지 입력";
	$head_title = '배송지 입력';
}
$topMenu_skip = $back_skip = $home_skip = $search_skip = $store_skip = $gnb_skip = $cart_skip = true;
$is_head_close = true;
//$head_close_url = G5_SHOP_URL.'/myaddress.php';
include_once(G5_MSHOP_PATH.'/_head.php');
?>

<form name="fmyaddress" id="fmyaddress" method="post" action="<?=$action_url?>" autocomplete="off">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="ad_id" value="<?=$myadr['ad_id']?>">
<div id="myaddress_form">

	<ul>
		<li>
			<div class="label">배송지명</div>
			<input type="text" name="ad_subject" id="ad_subject" value="<?=$myadr['ad_subject']?>" class="frm_input w-full" maxlength="20" placeholder="배송지명 입력">
			<p class="mt5"><label class="checkbox-label"><input type="checkbox" name="ad_default" id="ad_default" value="1"<?=$myadr['ad_default']?' checked':''?>><span></span>기본배송지로 설정</label></p>
		</li>
		<li>
			<div class="label">받는 사람</div>
			<input type="text" name="ad_name" value="<?=$myadr['ad_name']?>" required class="frm_input w-full" maxlength="20" placeholder="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)">
		</li>
		<li>
			<div class="label">연락처</div>
			<input type="tel" name="ad_hp" value="<?=$myadr['ad_hp']?>" required class="frm_input w-full number" maxlength="20" placeholder="휴대폰번호 (필수)">
		</li>
		<li>
			<div class="label">주소</div>
			<div class="adress flex flex-middle gap8">
				<input type="text" name="ad_zip" id="ad_zip" value="<?=$myadr['ad_zip1'].$myadr['ad_zip2']?>" required class="frm_input flex1" size="8" maxlength="6" placeholder="우편번호" readOnly>
				<button type="button" class="_btn/gray" onclick="win_zip('fmyaddress', 'ad_zip', 'ad_addr1', 'ad_addr2', 'ad_addr3', 'ad_jibeon');">주소 검색</button>
			</div>
			<p class="mt10">
				<input type="text" name="ad_addr1" id="ad_addr1" value="<?=$myadr['ad_addr1']?>" required class="frm_input frm_address w-full" size="60" placeholder="기본주소" readOnly>
			</p>
			<p class="mt10">
				<input type="text" name="ad_addr2" id="ad_addr2" value="<?=$myadr['ad_addr2']?>" class="frm_input frm_address w-full" size="60" placeholder="상세주소">
			</p>
			<p class="mt10">
				<input type="text" name="ad_addr3" id="ad_addr3" value="<?=$myadr['ad_addr3']?>" readonly="readonly" class="frm_input frm_address w-full">
				<input type="hidden" name="ad_jibeon" value="">
			</p>
		</li>
	</ul>

    <div class="flex flex-middle gap15 mt20">
		<input type="submit" value="확인" class="btn_submit _btn/lg/black w-full" accesskey="s">
    </div>
</div>
</form>

<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
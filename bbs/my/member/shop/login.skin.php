<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_back = true; //뒤로가기
$head_title = '로그인';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<div id="mb_login" class="flex column" style="min-height:<?=$_style_min_height?>">
	
	<?php if(!$is_closedmall) { ?>
	<div id="loginTabs" class="tabMenu">
		<a href="<?=G5_BBS_URL?>/login.php" class="tab<?=preg_match("/orderinquiry.php$/", $url)?'':' active'?>">회원 로그인</a>
		<?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 ?>
		<a href="<?=G5_SHOP_URL?>/orderinquiry.php" class="tab<?=preg_match("/orderinquiry.php$/", $url)?' active':''?>">비회원 주문조회</a>
		<?php } ?>
	</div>
	<?php } ?>
	
	<?php if (preg_match("/orderinquiry.php$/", $url)) { ?>
	<div id="non_member_form" class="tabContainer p20">
		<form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off" onsubmit="return forderinquiry_submit(this);">
		<ul class="formContainer mt10">
			<li>
				<input type="text" name="od_id" value="<?php echo $od_id ?>" id="od_id" placeholder="주문번호" required class="frm_input required w-full /lg" size="20">
			</li>
			<li>
				<input type="password" name="od_pwd" size="20" id="od_pwd" placeholder="비밀번호" required class="frm_input required w-full /lg">
			</li>
		</ul>
		<div class="form-btnSet column mt20">
			<button type="submit" class="_btn/mainColor/lg">확인</button>
		</div>
		</form>

		<div class="textbox mt40" style="height:auto">
			<p>
				메일로 발송해드린 주문서의 주문번호 및 주문 시 입력하신<br>
				비밀번호를 정확히 입력해주십시오.
			</p>
		</div>
	</div>
	<?php } else { ?>
	<div id="member_form" class="tabContainer p20">
		 <div class="mt10">
			<h2 class="fs20 fw600">로그인</h2>
			<div class="fs15 fw500 mt5"><?=$config['cf_title']?>의 다양한 혜택을<br>만나보세요.</div>
		</div>
		<form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" id="flogin">
		<input type="hidden" name="url" value="<?php echo $login_url ?>">
		
		<ul class="formContainer mt30">
			<li>
				<div class="label">아이디</div>
				<input type="text" name="mb_id" id="login_id" placeholder="아이디" required class="frm_input required w-full /lg" maxLength="20">
			</li>
			<li>
				<div class="label">비밀번호</div>
				<input type="password" name="mb_password" id="login_pw" placeholder="비밀번호" required class="frm_input required w-full /lg" maxLength="20">
			</li>
		</ul>
		<div class="form-btnSet column mt20">
			<button type="submit" class="_btn/mainColor/lg">로그인</button>
			<a href="<?=G5_BBS_URL?>/register.php?pn=register_intro" class="_btn/mainColor/line/lg">회원가입</a>
		</div>
		
		<div class="mt30 tcenter">
			<a href="<?php echo G5_BBS_URL ?>/password_lost.php" id="" class="underline fs14">아이디/비밀번호 찾기</a>
		</div>

		<?php
		// 소셜로그인 사용시 소셜로그인 버튼
		@include_once(get_social_skin_path().'/social_login.skin.php');
		?>
		</form>
	</div>
	<?php } ?>
    

    <?php // 쇼핑몰 사용시 여기부터 ?>
    <?php if ($default['de_level_sell'] == 1) { // 상품구입 권한 ?>

	<!-- 주문하기, 신청하기 -->
	<?php if (preg_match("/orderform.php/", $url)) { ?>
	<section id="mb_login_notmb" class="p15">
		
		<div class="bg-gray p15 rd6">
			<h2 class="fs15 fw600">비회원 구매</h2>
			<p class="fs14">비회원으로 주문하시는 경우 포인트는 지급하지 않습니다.</p>			
			<div id="guest_privacy">
				<?php echo $default['de_guest_privacy']; ?>
			</div>			
			<div class="chk_box mt10">
				<label class="checkbox-label"><input type="checkbox" id="agree" value="1" class="selec_chk"><span></span>개인정보수집에 대한 내용을 읽었으며 이에 동의합니다.</label>
			</div>
		</div>			
		<div class="form-btnSet mt20 mb20">
			<a href="javascript:guest_submit(document.flogin);" class="_btn/blue">비회원으로 구매하기</a>
		</div>	
	    <script>
	    function guest_submit(f)
	    {
	        if (document.getElementById('agree')) {
	            if (!document.getElementById('agree').checked) {
	                alert("개인정보수집에 대한 내용을 읽고 이에 동의하셔야 합니다.");
	                return;
	            }
	        }
	
	        f.url.value = "<?php echo $url; ?>";
	        f.action = "<?php echo $url; ?>";
	        f.submit();
	    }
	    </script>
	</section>

	<?php } else if (preg_match("/orderinquiry.php$/", $url)) { ?>
	
	<?php } ?>

	<?php } ?>
	<?php // 쇼핑몰 사용시 여기까지 반드시 복사해 넣으세요 ?>

	<div class="mt-auto">
		<?php echo shop_banner('로그인 페이지', '_block_banner.skin.php'); ?>
	</div>

</div>



<!-- 비회원 주문조회시 결과가 없을때 팝업.. -->
<!--<div class="layer-popup" id="pop-non_mb_order">	
	<div class="pop-inner">
		<div class="popCon alert">			
			<div class="msg tcenter">
				주문이 존재하지 않습니다.<br>
				주문서번호와 비밀번호를 다시 한번 확인해주세요.
			</div>
			<div class="btnSet">
				<button type="button" class="popClose color-blue">확인</button>
			</div>
		</div>		
	</div>
	<div class="pop-bg"></div>
</div>-->





<script>
$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f) {
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}


/////////////////////////////////////////////////////////////////////
// 황팀 - 비회원 주문조회시 팝업 띄우기 (임의로 띄움....)
/////////////////////////////////////////////////////////////////////
/*function forderinquiry_submit(f) {
    $('#pop-non_mb_order').addClass('open');
	$('body, html').css('overflow', 'hidden');
	return false;
}*/
</script>


<?php
$is_bottomTabMenu = true;
$footer_skip = true;
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>
<?php
include_once('./_common.php');

if( function_exists('social_check_login_before') ){
    $social_login_html = social_check_login_before();
}

//인태 - 별도 인트로 페이지를 운영할때 사용.. ───────────────────────────────────────────
if($pn) {
	if(file_exists(G5_THIS_PATH.'/member/'.$pn.'.php')) {
		require_once(G5_THIS_PATH.'/member/'.$pn.'.php');
		return;
	} else if(file_exists(G5_THEME_PATH.'/member/'.$pn.'.php')) {
		require_once(G5_THEME_PATH.'/member/'.$pn.'.php');
		return;
	}
}
// ───────────────────────────────────────────────────────────────────────

$g5['title'] = '로그인';
include_once('./_head.sub.php');

$url = isset($_GET['url']) ? strip_tags($_GET['url']) : '';
$od_id = isset($_POST['od_id']) ? safe_replace_regex($_POST['od_id'], 'od_id') : '';

// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if ($is_member && $mode !='admin') {
    if ($url)
        goto_url($url);
    else
        goto_url(G5_URL);
}

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";

include_once(G5_SHOP_PATH.'/shop.head.php');

?>
<meta name="autocomplete" content="off" />

<div id="mb_login" style="min-height:<?=$_style_min_height?>">
	
	<div class="loginContainer">
		
		<div class="page-title">비회원 주문조회</div>
		

		<?php $url = "../shop/orderinquiry.php";	?>
		<div id="non_member_form" class="tabContainer">
			<form name="forderinquiry" method="post" action="<?php echo urldecode($url); ?>" autocomplete="off">
			<ul class="formContainer">
				<li><input type="text" name="od_id" value="<?php echo $od_id; ?>" id="od_id" required class="frm_input required" size="20" placeholder="주문서번호" autocomplete='off' style="width:100%"></li>
				<li><input type="password" name="od_pwd" size="20" id="od_pwd" required class="frm_input required" placeholder="비밀번호" autocomplete="off" style="width:100%"></li>
			</ul>
			<div class="form-btnSet column mt20">
				<button type="submit" class="_btn/mainColor/lg">주문조회</button>
			</div>

			</form>
		</div>

	</div>
</div>

<script>
jQuery('#od_id').attr("autocomplete","off");

</script>

<!-- 비회원 주문조회시 결과가 없을때 팝업.. -->
<div class="layer-popup" id="pop-non_mb_order">	
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
</div>





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
function forderinquiry_submit(f) {
    $('#pop-non_mb_order').addClass('open');
	$('body, html').css('overflow', 'hidden');
	return false;
}
</script>


<?php
$footer_skip = true;
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>

include_once('./_tail.sub.php');
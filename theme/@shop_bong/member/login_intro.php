<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/my/shop_block.lib.php');

if( function_exists('social_check_login_before') ){
    $social_login_html = social_check_login_before();
}

$is_back = true; //뒤로가기
$head_title = '로그인';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/shop.head.php');

$url = isset($_GET['url']) ? strip_tags($_GET['url']) : '';
$od_id = isset($_POST['od_id']) ? safe_replace_regex($_POST['od_id'], 'od_id') : '';

// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if ($is_member && $mod!='admin') {
    if ($url)
        goto_url($url);
    else
        goto_url(G5_URL);
}

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";


?>

<div id="login_intro" style="min-height:<?=$_style_min_height?>">
	<div class="p20">
		<div id="login_intro_head" class="mt30">
			<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_login_intro_head&title=쇼핑몰 로그인 상단문구" class="btnSetting popWin" style="margin-left:-40px" data-width="840" data-height="620" data-top="60" data-left="0" data-area="#login_intro_head">쇼핑몰 로그인 상단문구</a>';?>
			<?php if($default['shop_login_intro_head_content']) {
				echo $default['shop_login_intro_head_content'];
			} else {
				echo '<h2 class="fs20 fw600">로그인</h2>';
				echo '<div class="fs15 fw500 mt5">'.$config['cf_title'].'의 다양한 혜택을<br>만나보세요.</div>';
			} ?>
		</div>
		<div class="btnSet">
			<a href="<?=G5_BBS_URL?>/login.php" class="_btn/mainColor/line/lg">로그인</a>
			<a href="<?=G5_BBS_URL?>/register.php?pn=register_intro" class="_btn/mainColor/lg">회원가입</a>
		</div>
	</div>

	<div class="blockSpace"></div>

	<ul class="_block_link_ul column p20">
		<?php if(!$default['shop_use_closure']) echo '<li><a href="'.G5_SHOP_URL.'/orderinquiry.php">비회원 주문조회</a></li>'; ?>
		<li><a href="<?=G5_SHOP_URL?>/customer.php">고객센터</a></li>
	</ul>
	
	<?php
	echo '<div id="shopblock" style="margin-top:-2px;">';
	if($is_shop_manager) {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=login_intro&title=로그인페이지 블럭관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">로그인페이지 블럭관리</a>';
	}
	echo shop_block('login_intro');
	echo '</div>';
	?>

	<div id="login_banner" class="mt-auto relative">
		<?php echo shop_banner('로그인 페이지', '_block_banner.skin.php'); ?>
		<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=로그인 페이지&title=쇼핑몰 배너관리" class="btnSetting light popWin" style="top:5px;right:-25px;" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#login_banner">쇼핑몰 배너관리</a>';?>
	</div>
</div>

<?php
$footer_skip = true;
include_once(G5_SHOP_PATH.'/shop.tail.php');
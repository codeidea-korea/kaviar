<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


$is_back = true; //뒤로가기
$head_title = '로그인';
include_once(G5_SHOP_PATH.'/shop.head.php');
?>

<?php
// 아이템 목록 모음 (html) ────────────────────────────────────────────────────────────────────────────────────────────
include_once(G5_THEME_MSHOP_PATH.'/_inc_item_list.html.php');
// ─────────────────────────────────────────────────────────────────────────────────────────────────────────────
?>

<div id="login_main" style="min-height:calc(100vh - <?=$headerSpace_height + $bottomTabMenu_height?>px)">
	<div class="p20">
		<div class="mt30">
			<h2 class="fs20 fw600">로그인</h2>
			<div class="fs15 fw500 mt5">봉선장의 다양한 혜택을<br>만나보세요.</div>
		</div>
		<div class="btnSet">
			<a href="<?=G5_BBS_URL?>/login.php" class="_btn:large:blue:line">로그인</a>
			<a href="./register_main.php" class="_btn:large:blue">회원가입</a>
		</div>
	</div>

	<div class="blockSpace"></div>

	<ul class="link-list">
		<li><a href="<?=G5_BBS_URL?>/login.php?tab=2">비회원 주문조회</a></li>
		<li><a href="<?=G5_SHOP_URL?>/customer.php">고객센터</a></li>
		<li><a href="<?=G5_URL?>/theme/bong/mobile/shop/bongStory.php">봉선장이야기</a></li>
	</ul>

	<div class="bottom">
		<?=$slide_banner02_html?>
	</div>
</div>


<?php
$is_bottomTabMenu = true;
$not_footer = true;
include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
?>
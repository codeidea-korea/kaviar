<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.head.php');
    return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
include_once(G5_THEME_SHOP_PATH.'/shop.head.lib.php'); //인태
include_once(G5_BBS_PATH.'/my/adminSet.php'); //인태 - 관리자 메뉴 호출
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';
?>



<div id="root">

<?php
if(defined('_INDEX_')) echo shop_banner('메인 팝업', '_main_popup.php');
?>
<header id="header" class="shop-header"<?=$default['shop_header_width']?' style="--top-header-width:'.$default['shop_header_width'].'px;--top-header-padding:0;"':''?>>
	<div class="inner-wrap">
		<div id="hdInner-1" class="headerContainer">
			<!--<a href="<?=get_pretty_url('intro')?>" class="company">company</a>-->
			<ul class="tollbarContainer">
				<li><a href="<?=$is_member?shop_short_url_my('orderinquiry'):G5_BBS_URL.'/login.php'?>"><?=$is_member?'마이캐비아':'로그인'?></a></li>
				<?php if($is_member) {
					echo '<li><a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></li>';
				} else {
					echo '<li><a href="'.G5_BBS_URL.'/register_form.php">회원가입</a></li>';
				} ?>
				<li><a href="<?=get_pretty_url('notice')?>">고객센터</a></li>
				<?php if(!$is_member) {
					echo '<li><a href="'.G5_BBS_URL.'/nonmember_order.php">비회원 주문조회</a></li>';
				} ?>

			</ul>
		</div>
		<div id="hdInner-2" class="headerContainer">
			<?=$shop_logo?>
			<?php include(G5_THEME_SHOP_PATH.'/_shop_header_search.php'); ?>
			<div class="headerIconCon">
				<!--<a href="#" class="_barand">IP브랜드</a>
				<a href="#" class="_map">지역 IP 맛집</a>-->
				<!-- <a href="<?=get_pretty_url('partners')?>" class="_partners">PARTNERS</a> -->
				<a href="<?=get_pretty_url('partners')?>" class="_partners">PARTNERS<!--<img src="/img/partners.svg" alt="">--></a>
				<a href="<?=shop_short_url_my('cart')?>" class="_cart">장바구니<?=get_boxcart_datas_count()?'<span class="cart-count">'.get_boxcart_datas_count().'</span>':''?></a>
			</div>
		</div>
		<div id="hdInner-3" class="headerContainer">
			<button class="topGnbOpener">카테고리</button>		
			<div class="topMenuContainer"><?=get_shop_top_menu()?></div>
		</div>
		

		<div id="_shopCateMenuContainer" class="_shopCateContainer">
			<?=get_shopCate_menu('img')?>
		</div>

	</div>
	<?php if($is_admin && !defined('_ITEM_') && !$bo_table && !$head_title) echo '<a href="'.$_adm_url.'/?pn=_shop_header_setting&title=쇼핑몰 헤더관리" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area="#header">쇼핑몰 헤더관리</a>';?>
</header>
<div id="headerSpace"></div>


<div id="wrapper" style="--header-height:84px;">
	
	<?php if(!defined('_INDEX_') && get_view_today_items_count() > 0) {
		echo '<div id="_todayview">';
			@include(G5_SHOP_SKIN_PATH.'/boxtodayview.skin.php'); // 오늘 본 상품		
		echo '</div>';
	} ?>
	
	<div id="container" style="min-height:calc(var(--vh) - 84px);">
	    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><!--<h1 id="container_title"><?php echo $g5['title'] ?></h1>--><?php } ?>

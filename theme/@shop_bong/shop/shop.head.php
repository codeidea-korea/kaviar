<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
//include_once(G5_LIB_PATH.'/my/get_shop_my.lib.php'); //인태
include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
include_once(G5_THEME_PATH.'/head.lib.php'); //인태
//include_once(G5_LIB_PATH.'/my/latest_multi.lib.php'); //인태
include_once(G5_BBS_PATH.'/my/adminSet.php'); //인태 - 관리자 메뉴 호출
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';

//if(defined('_INDEX_')) include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
?>



<div id="root">

<?php
if(defined('_INDEX_')) echo shop_banner('메인 팝업', '_main_popup.php');
?>

<!-- web 전용 우측 배너 -->
<article class="shop-outsideContainer media-pc-only">
	
	<?php if($default['shop_layout']=='outside-right') {?>
	<div class="side-banner">
		<?php echo shop_banner('사이드 배너', 'sidebanner.skin.php'); ?>
		<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=사이드 배너&title=쇼핑몰 배너관리" class="btnSetting light popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area=".shop-outsideContainer .side-banner" style="top:-5px;left:-5px;right:auto;transform:scale(0.7);">쇼핑몰 배너관리</a>';?>
	</div>
	<?php } ?>
	<?php if($default['shop_layout']=='outside-left') {?>
	<div class="oustide-title">
		<?=$default['shop_slogan']?'<span class="slogan">'.$default['shop_slogan'].'</span>':''?>
		<?=$shop_logo?>
	</div>
	<?php } ?>
	<div class="side-search">
		<!--<form name="" method="get" action="<?=G5_SHOP_URL?>/search.php">-->
		<form name="" method="get" action="<?=shop_short_url_my('search')?>">
		<input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
		<input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
		<input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
			<div class="inputContainer">
				<input type="text" name="q" value="<?=$q?$q:''?>" class="w-full inp" maxlength="30" placeholder="검색어를 입력해주세요">
				<button type="submit" class="btn-search" value="검색">검색</button>
			</div>
		</form>		
	</div>
	<?php if($default['shop_layout']=='outside-left' && $config['cf_search_keyword']) {
		echo '<div class="oustide-search-keyword">';
			echo get_search_keyword();
		echo '</div>';
	} ?>
	<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_layout&title=쇼핑몰 기본 레이아웃" class="btnSetting popWin" data-width="1050" data-height="440" data-top="60" data-left="0" data-area=".shop-outsideContainer">쇼핑몰 기본 레이아웃</a>';?>
</article>


<header id="header" class="<?=$header_class?>" style="<?=$header_var?>" data-ui="<?=$shop_header_ui_type&&!$head_title?$shop_header_ui_type:'type_left_01'?>">

    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1 class="sound_only"><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

	<?php echo shop_banner('상단 띠배너', '_top_bar_banner.php'); ?>
	
	<div id="header_inwrap">
		<div class="headerContainer" style="height:<?=$header_top_height?>px;">
			<?php
			if(!$head_title) echo '<div id="logo">'.$shop_logo.'</div>';
			if($head_title) {
				if(!$back_skip) {
					if($head_back_url) {
						echo '<a href="'.$head_back_url.'" class="hdIcon_gotoback">뒤로가기</a>';
					} else {
						echo '<button class="hdIcon_gotoback" onclick="history.back();">뒤로가기</button>';
					}
				}
				if(!$home_skip) echo '<a href="'.G5_URL.'" class="hdIcon_home">'.$hdIcon_home.'홈</a>';
				echo '<div class="centerContainer">'.$head_title.'</div>';
			}
			if(!$cart_skip||(strpos($shop_header_ui_type, '_gnb') !== false&&!$head_title)||$default['shop_header_use_store']) {
				if( (strpos($shop_header_ui_type, 'type_center_04') !== false || strpos($shop_header_ui_type, 'type_center_05') !== false) && strpos($shop_header_ui_type, '_gnb') !== false && !$head_title) {
					if(!$gnb_skip) echo '<a href="'.shop_short_url_my('shopCate').'" id="gnbOpener" class="hdIcon_gnb left">'.$hdIcon_gnb.'</a>';
				}
				echo '<div class="headerIconCon">';
					if(strpos($shop_header_ui_type, '_search') !== false && !$search_skip) echo '<a href="'.shop_short_url_my('search').'" class="hdIcon_search">'.$hdIcon_search.'</a>';
					if($default['shop_header_use_store'] && !$store_skip) echo '<a href="'.shop_short_url_my('shopStore').'" class="hdIcon_store">'.$hdIcon_store.'</a>';
					if(!$cart_skip) echo '<a href="'.shop_short_url_my('cart').'" class="hdIcon_cart">'.$hdIcon_cart.'<span class="sound_only">장바구니</span>'.(get_boxcart_datas_count()?'<span class="cart-count">'.get_boxcart_datas_count().'</span>':'').'</a>';
					if( (strpos($shop_header_ui_type, 'type_center_04') === false && strpos($shop_header_ui_type, 'type_center_05') === false) && strpos($shop_header_ui_type, '_gnb') !== false && !$head_title) echo '<a href="'.shop_short_url_my('shopCate').'" id="gnbOpener" class="hdIcon_gnb">'.$hdIcon_gnb.'</a>';
				echo '</div>';
			}
			if($is_head_close) {
				if($head_close_url) {
					echo '<a href="'.$head_close_url.'" class="hdIcon_close">닫기</a>';
				} else {
					echo '<button class="hdIcon_close" onclick="history.back();">닫기</button>';
				}
			}
			?>
		</div>

		<?php if(!$topMenu_skip) {
			echo '<div class="topMenuContainer" style="height:'.$header_menu_height.'px;">';
			echo get_shop_top_menu();
			echo '</div>';
		}
		if($is_shop_manager && !defined('_ITEM_') && !$bo_table && !$head_title) echo '<a href="'.$_adm_url.'/?pn=_shop_header_setting&title=쇼핑몰 헤더관리" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area="#header_inwrap">쇼핑몰 헤더관리</a>';
		?>
	</div>
</header>

<div id="headerSpace" style="height:<?=$header_height?>px;"></div>

<div id="wrapper" style="min-height:calc(var(--vh) - <?=$header_height?>px);--header-height:<?=$header_height?>px;">
	
	<div id="container">
	    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><!--<h1 id="container_title"><?php echo $g5['title'] ?></h1>--><?php } ?>

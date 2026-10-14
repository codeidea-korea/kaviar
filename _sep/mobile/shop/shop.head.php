<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_PATH.'/head.sub.php');
//include_once(G5_LIB_PATH.'/my/get_shop_my.lib.php'); //인태
include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
include_once(G5_THEME_MSHOP_PATH.'/shop.head.lib.php'); //인태
include_once(G5_BBS_PATH.'/my/adminSet.php'); //인태 - 관리자 메뉴 호출
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

$q = isset($_GET['q']) ? clean_xss_tags($_GET['q'], 1, 1) : '';
$mobile_top_menu = !$topMenu_skip ? get_shop_top_menu() : '';
$mobile_header_height = $header_top_height;

//if(defined('_INDEX_')) include G5_MOBILE_PATH.'/newwin.inc.php'; // 팝업레이어
?>

<div id="root">

<?php
if(defined('_INDEX_')) echo shop_banner('메인 팝업', '_main_popup.php');
?>



<header id="header" class="<?=$header_class?>" style="<?=$header_var?>--header-height:<?=$mobile_header_height?>px;" data-ui="<?=$shop_header_ui_type&&!$head_title?$shop_header_ui_type:'type_left_01'?>">

    <?php if ((!$bo_table || $w == 's' ) && defined('_INDEX_')) { ?><h1 class="sound_only"><?php echo $config['cf_title'] ?></h1><?php } ?>

    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

	<?php// echo shop_banner('상단 띠배너', '_top_bar_banner.php'); ?>
	
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
					//echo '<a href="#" class="hdIcon_brand">'.$hdIcon_brand.'</a>';
					//if($default['shop_header_use_store'] && !$store_skip) echo '<a href="'.shop_short_url_my('shopStore').'" class="hdIcon_store">'.$hdIcon_store.'</a>';
					if($mobile_top_menu) echo '<button type="button" class="mobileTopMenuOpener" aria-controls="mobileTopMenu" aria-expanded="false"><span class="mobileTopMenuIcon" aria-hidden="true"><i></i><i></i><i></i></span><span class="sound_only">카테고리 메뉴 열기</span></button>';
					echo '<a href="'.get_pretty_url('partners').'" class="hdIcon_partners"><i class="myIcon"></i></a>';
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

		<?php if($is_shop_manager && !defined('_ITEM_') && !$bo_table && !$head_title) echo '<a href="'.$_adm_url.'/?pn=_shop_header_setting&title=쇼핑몰 헤더관리" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area="#header_inwrap">쇼핑몰 헤더관리</a>';
		?>
	</div>
	<?php if($mobile_top_menu) { ?>
		<div class="mobileTopMenuBackdrop" aria-hidden="true"></div>
		<nav id="mobileTopMenu" class="mobileTopMenu" aria-label="카테고리 메뉴" aria-hidden="true">
			<div class="mobileTopMenuHeader">
				<strong>카테고리</strong>
				<button type="button" class="mobileTopMenuCloser"><span class="sound_only">카테고리 메뉴 닫기</span></button>
			</div>
			<div class="mobileTopMenuList"><?=$mobile_top_menu?></div>
		</nav>
	<?php } ?>
</header>

<div id="headerSpace" style="height:<?=$mobile_header_height?>px;"></div>

<div id="wrapper" style="min-height:calc(var(--vh) - <?=$mobile_header_height?>px);--header-height:<?=$mobile_header_height?>px;">
	
	<div id="container">
	    <?php if ((!$bo_table || $w == 's' ) && !defined('_INDEX_')) { ?><!--<h1 id="container_title"><?php echo $g5['title'] ?></h1>--><?php } ?>

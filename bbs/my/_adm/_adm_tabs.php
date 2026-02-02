<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THEME_PATH.'/_adm/_adm_tabs.php')) {
	require_once(G5_THEME_PATH.'/_adm/_adm_tabs.php');
    return;
}
?>

<div class="box-tabs-container">
	<?php if(!G5_IS_MOBILE) { ?>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_config" class="tab <?=$pn=='_adm_config'?'active':''?>" data-resize="1250,720">기본설정</a>
		<?php if(file_exists(G5_THEME_PATH.'/_adm/_top_header_setting.php')) { ?>
		<a href="<?=$_adm_url?>/?tab=1&pn=_top_header_setting" class="tab <?=$pn=='_top_header_setting'?'active':''?>" data-resize="1250,720">헤더관리</a>
		<?php } ?>
		<?php if(file_exists(G5_THEME_PATH.'/_adm/_side_header_setting.php')) { ?>
		<a href="<?=$_adm_url?>/?tab=1&pn=_side_header_setting" class="tab <?=$pn=='_side_header_setting'?'active':''?>" data-openerClick=".leftSecOpener" data-resize="1250,720">사이드 헤더관리</a>
		<?php } ?>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_mainmenu_setting" class="tab <?=$pn=='_adm_mainmenu_setting'?'active':''?>" data-openerClick=".leftSecOpener" data-resize="1250,720">메인메뉴</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_mainpage" class="tab <?=$pn=='_adm_mainpage'?'active':''?>" data-resize="1250,500">메인페이지</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_default_style" class="tab <?=$pn=='_adm_default_style'?'active':''?>" data-resize="1250,720">사이트 기본스타일</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_board_style" class="tab <?=$pn=='_adm_board_style'?'active':''?>" data-resize="1250,900">게시판 기본스타일</a>
	</div>
	<?php } else { ?>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_config" class="tab <?=$pn=='_adm_config'?'active':''?>">기본설정</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_mobile_header_setting" class="tab <?=$pn=='_mobile_header_setting'?'active':''?>" data-resize="1250,720">헤더관리</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_mobile_side_header_setting" class="tab <?=$pn=='_mobile_side_header_setting'?'active':''?>" data-openerClick="#header .menuOpener" data-resize="1250,720">사이드 헤더관리</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_mainmenu_setting" class="tab <?=$pn=='_adm_mainmenu_setting'?'active':''?>" data-openerClick="#header .menuOpener" data-resize="1250,720">메인메뉴</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_mainpage" class="tab <?=$pn=='_adm_mainpage'?'active':''?>" data-resize="1250,500">메인페이지</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_default_style" class="tab <?=$pn=='_adm_default_style'?'active':''?>" data-resize="1250,720">사이트 기본스타일</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_board_style" class="tab <?=$pn=='_adm_board_style'?'active':''?>" data-resize="1320,900">게시판 기본스타일</a>
	</div>
	<?php } ?>

	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_quicknews" class="tab <?=$pn=='_adm_quicknews'?'active':''?>" data-openerClick=".quickNews_opener" data-resize="1120,900">퀵뉴스</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_helper" class="tab <?=$pn=='_adm_helper'?'active':''?>" data-resize="1650,900">유틸리티 클래스 정보</a>
	</div>	
</div>

<script>
$('.box-tabs-container a').click(function() {
	let openerClick = $(this).attr('data-openerClick'),
		resize = $(this).attr('data-resize').split(',');

	if(openerClick == '.leftSecOpener' || openerClick == '#header .menuOpener') {
		opener.$('.open .quickNews_closer').click();
	} else if(openerClick == '.quickNews_opener') {
		opener.$('.sideSection .closer, #navContainer .menuCloser').click();
	} else {
		opener.$('.sideSection .closer, #navContainer .menuCloser, .quickNews_closer').click();
	}
	if(openerClick) {		
		opener.$(openerClick).click();
	}
	
	if(resize) {
		window.resizeTo(resize[0], resize[1]);
	}
});
</script>
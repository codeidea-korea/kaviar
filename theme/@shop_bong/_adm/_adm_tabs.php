<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="box-tabs-container">
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_config" class="tab <?=$pn=='_shop_config'?'active':''?>" data-resize="1305,830">기본설정</a>		
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_layout" class="tab <?=$pn=='_shop_layout'?'active':''?>" data-resize="1250,830">기본 레이아웃</a>		
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_header_setting" class="tab <?=$pn=='_shop_header_setting'?'active':''?>" data-resize="1250,790">헤더 관리</a>
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_cate_setting" class="tab <?=$pn=='_shop_cate_setting'?'active':''?>" data-resize="1250,700">카테고리 이미지 관리</a>	
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_itemtype_setting" class="tab <?=$pn=='_shop_itemtype_setting'?'active':''?>" data-resize="1250,600">상품유형</a>

		<!--<a href="<?=$_adm_url?>/?tab=1&pn=mainpage" class="tab <?=$pn=='mainpage'?'active':''?>" data-resize="1250,830">메인페이지</a>-->
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_footer_setting" class="tab <?=$pn=='_shop_footer_setting'?'active':''?>" data-resize="1250,830">카피라이트 관리</a>		
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_bottom_setting" class="tab <?=$pn=='_shop_bottom_setting'?'active':''?>" data-resize="1250,830">하단 텝메뉴 관리</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_shop_banner" class="tab <?=$pn=='_shop_banner'?'active':''?>" data-resize="1430,830">쇼핑몰 배너관리</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_default_style" class="tab <?=$pn=='_adm_default_style'?'active':''?>" data-resize="1250,660">사이트 기본스타일</a>
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?tab=1&pn=_adm_helper" class="tab <?=$pn=='_adm_helper'?'active':''?>" data-resize="1650,900">유틸리티 클래스 정보</a>
	</div>
</div>


<script>
$('.box-tabs-container a').click(function() {
	let openerClick = $(this).attr('data-openerClick'),
		resize = $(this).attr('data-resize').split(',');

	if(openerClick) {		
		opener.$(openerClick).click();
	}
	
	if(resize) {
		window.resizeTo(resize[0], resize[1]);
	}
});
</script>
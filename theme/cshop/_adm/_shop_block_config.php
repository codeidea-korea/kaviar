<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_PATH.'/_block_item.skin.php')) {
	require(G5_THIS_PATH.'/_block_item.skin.php');
	return;
}

//디폴트값


//여백
$_banner_padding_t = ;
$_banner_padding_b = ;
$_banner_padding_lr = ;
$_banner_padding_mobile_t = ;
$_banner_padding_mobile_b = ;
$_banner_padding_mobile_lr = ;

$_items_padding_t = ;
$_items_padding_b = ;
$_items_padding_lr = ;
$_items_padding_mobile_t = ;
$_items_padding_mobile_b = ;
$_items_padding_mobile_lr = ;

$_shopCate_padding_t = ;
$_shopCate_padding_b = ;
$_shopCate_padding_lr = ;
$_shopCate_padding_mobile_t = ;
$_shopCate_padding_mobile_b = ;
$_shopCate_padding_mobile_lr = ;

$_itemuse_padding_t = ;
$_itemuse_padding_b = ;
$_itemuse_padding_lr = ;
$_itemuse_padding_mobile_t = ;
$_itemuse_padding_mobile_b = ;
$_itemuse_padding_mobile_lr = ;








$_items_cols_slide = 4; //가로수 - 슬라이드형
$_items_cols_gall = 4; //가로수 - 갤러리형
$_items_cols_slide_mobile = 1.25; //모바일 가로수 - 슬라이드형
$_items_cols_gall_mobile = 2; //모바일 가로수 - 갤러리형

$_items_radius = 8; // 모서리 라운딩
$_items_radius_mobile = 6; //모바일 모서리 라운딩
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_PATH.'/_shop_block_config.php')) {
	require(G5_THIS_PATH.'/_shop_block_config.php');
	return;
}

/* ─────────────────────────────────────────────────────────────────
															디폴트값
───────────────────────────────────────────────────────────────── */


//여백 ───────────────────────────────────────

$_padding = 0;
$_padding_t = 50;
$_padding_b = 35;
$_padding_lr = 30;
$_padding_mobile = 0;
$_padding_mobile_t = 25;
$_padding_mobile_b = 15;
$_padding_mobile_lr = 15;

$_banner_padding = 0;
$_banner_padding_t = 50;
$_banner_padding_b = 0;
$_banner_padding_lr = 30;
$_banner_padding_mobile = 0;
$_banner_padding_mobile_t = 25;
$_banner_padding_mobile_b = 0;
$_banner_padding_mobile_lr = 15;

$_items_padding = 30;
$_items_padding_t = 50;
$_items_padding_b = 35;
$_items_padding_lr = 30;
$_items_padding_mobile = 15;
$_items_padding_mobile_t = 25;
$_items_padding_mobile_b = 15;
$_items_padding_mobile_lr = 15;

$_shopCate_padding = 30;
$_shopCate_padding_t = 50;
$_shopCate_padding_b = 35;
$_shopCate_padding_lr = 30;
$_shopCate_padding_mobile = 15;
$_shopCate_padding_mobile_t = 25;
$_shopCate_padding_mobile_b = 15;
$_shopCate_padding_mobile_lr = 15;

$_itemuse_padding = 30;
$_itemuse_padding_t = 50;
$_itemuse_padding_b = 35;
$_itemuse_padding_lr = 30;
$_itemuse_padding_mobile = 15;
$_itemuse_padding_mobile_t = 25;
$_itemuse_padding_mobile_b = 15;
$_itemuse_padding_mobile_lr = 15;

$_link_padding = 30;
$_link_padding_t = 50;
$_link_padding_b = 35;
$_link_padding_lr = 30;
$_link_padding_mobile = 20;
$_link_padding_mobile_t = 25;
$_link_padding_mobile_b = 20;
$_link_padding_mobile_lr = 20;


$_mix_padding = 30;
$_mix_padding_t = 50;
$_mix_padding_b = 35;
$_mix_padding_lr = 30;
$_mix_padding_mobile = 15;
$_mix_padding_mobile_t = 25;
$_mix_padding_mobile_b = 15;
$_mix_padding_mobile_lr = 15;




//가로수 ───────────────────────────────────────

$_items_cols_slide = 3; //가로수 - 슬라이드형
$_items_cols_gall = 4; //가로수 - 갤러리형
$_items_cols_slide_mobile = 1.25; //모바일 가로수 - 슬라이드형
$_items_cols_gall_mobile = 2; //모바일 가로수 - 갤러리형

$_itemuse_cols_slide = 5; //가로수 - 슬라이드형
$_itemuse_cols_gall = 4; //가로수 - 갤러리형
$_itemuse_cols_slide_mobile = 2.25; //모바일 가로수 - 슬라이드형
$_itemuse_cols_gall_mobile = 2; //모바일 가로수 - 갤러리형





//간격 ───────────────────────────────────────

$_banner_gap = 0;
$_banner_gap_mobile = 0;

$_items_gap = 30;
$_items_gap_mobile = 15;

$_itemuse_gap = 30;
$_itemuse_gap_mobile = 15;






//모서리 라운딩 ───────────────────────────────────────
$_items_radius = 0;
$_items_radius_mobile = 0;
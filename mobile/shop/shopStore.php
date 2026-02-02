<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$head_title = $store_id ? $store['store_subject'] : $store_label.'검색';
$topMenu_skip = true;
if($store_id) $head_back_url = shop_short_url_my('shopStore');
include_once(G5_MSHOP_PATH.'/_head.php');

//비회원 접근 제한
closure_auth_check('');

$store_skin = G5_SHOP_SKIN_PATH.'/store.skin.php';
if(G5_IS_MOBILE && file_exists(G5_MSHOP_SKIN_PATH.'/store.skin.php')) $store_skin = G5_MSHOP_SKIN_PATH.'/store.skin.php';
if($store_id) $store_skin = G5_MSHOP_SKIN_PATH.'/store.view.skin.php';

if(!file_exists($store_skin)) {
    echo str_replace(G5_PATH.'/', '', $store_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($store_skin);
}

$footer_skip = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
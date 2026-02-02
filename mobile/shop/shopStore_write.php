<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$head_title = $w=='u' ? $store_label.'수정' : $store_label.'등록';
$topMenu_skip = true;
include_once(G5_MSHOP_PATH.'/_head.php');

$store_skin = G5_SHOP_SKIN_PATH.'/store.write.skin.php';
if(G5_IS_MOBILE && file_exists(G5_MSHOP_SKIN_PATH.'/store.write.skin.php')) $store_skin = G5_MSHOP_SKIN_PATH.'/store.write.skin.php';

if(!file_exists($store_skin)) {
    echo str_replace(G5_PATH.'/', '', $store_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($store_skin);
}

$footer_skip = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
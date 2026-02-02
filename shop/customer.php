<?php
include_once('./_common.php');


$g5['title'] = '고객센터';


// 테마에 customer.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_inc_file = G5_THEME_SHOP_PATH.'/customer.php';
    if(is_file($theme_inc_file)) {
        include_once($theme_inc_file);
        return;
        unset($theme_inc_file);
    }
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/customer.php');
    return;
}




$g5['title'] = '마이페이지';
include_once('./_head.php');





//PC버전 customer 아직 없음





include_once("./_tail.php");


$footer_skip = true;
include_once(G5_SHOP_PATH.'/_tail.php');
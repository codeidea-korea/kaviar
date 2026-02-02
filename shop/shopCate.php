<?php
include_once('./_common.php');
define('_SHOPCATE_', true); //인태 - 하단메뉴 셀렉팅

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/shopCate.php');
    return;
}

$g5['title'] = '카테고리';
include_once('./_head.php');





include_once('./_tail.php');
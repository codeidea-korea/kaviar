<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_MSHOP_PATH.'/shop.tail.php')) {
	include_once(G5_MSHOP_PATH.'/shop.tail.php');
} else {
	include_once(G5_SHOP_PATH.'/shop.tail.php');
}
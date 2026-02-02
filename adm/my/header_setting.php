<?php
$sub_menu = "110200";
include_once('./_common.php');
//include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '헤더 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

//테마 별도
@include_once (G5_THEME_PATH.'/adm/_header_setting.php');

include_once (G5_ADMIN_PATH.'/admin.tail.php');
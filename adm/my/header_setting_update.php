<?php
$sub_menu = "110200";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

//테마별도
include_once (G5_THEME_PATH.'/adm/_header_setting_update.php');

goto_url(G5_ADMIN_URL.'/my/header_setting.php', false);
<?php
$sub_menu = '400902';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$sql = " update {$g5['config_table']}
            set cf_kakao_app_key = '{$cf_kakao_app_key}' ";
sql_query($sql);

goto_url("./storelist.php");
<?php
$sub_menu = '400902';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$sql = " update {$g5['g5_shop_default_table']}
            set store_label_name = '{$store_label_name}' ";
sql_query($sql);

goto_url("./storelist.php");
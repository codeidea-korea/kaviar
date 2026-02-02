<?php
$sub_menu = '400901';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$itemtype = implode("|", $_POST['itemtype']);
$itemtype_color = implode("|", $_POST['itemtype_color']);

$sql = " update {$g5['g5_shop_default_table']}
            set itemtype		    = '{$itemtype}',
				 itemtype_color	= '{$itemtype_color}' ";

sql_query($sql);

run_event('shop_admin_configformupdate');

if( $warning_msg ){
    alert($warning_msg, "./itemtype.php");
} else {
    goto_url("./itemtype.php");
}
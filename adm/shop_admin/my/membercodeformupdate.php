<?php
$sub_menu = '400903';
include_once('./_common.php');

$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';

check_demo();

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$code_num = isset($_REQUEST['code_num']) ? preg_replace('/[^0-9]/', '', $_REQUEST['code_num']) : 0;
$code_use = isset($_POST['code_use']) ? (int) $_POST['code_use'] : 0;
$code_id = isset($_POST['code_id']) ? clean_xss_tags($_POST['code_id'], 1, 1) : '';
$code_name = isset($_POST['code_name']) ? clean_xss_tags($_POST['code_name'], 1, 1) : '';
$join_content = isset($_POST['join_content']) ? $_POST['join_content'] : '';

if ($w=="") {

    $sql = " insert into {$g5['membercode_table']}
                set code_use        = '$code_use',
                    code_id        = '$code_id',
                    code_name     = '$code_name',
					join_content     = '$join_content' ";
    sql_query($sql);

    $code_num = sql_insert_id();

} else if ($w=="u") {

    $sql = " update {$g5['membercode_table']}
                set code_use        = '$code_use',
                    code_id        = '$code_id',
                    code_name     = '$code_name',
					join_content     = '$join_content'
					where code_num = '$code_num' ";
    sql_query($sql);

} else if ($w=="d") {

    $sql = " delete from {$g5['membercode_table']} where code_num = $code_num ";
    $result = sql_query($sql);

}


if ($w == "" || $w == "u") {
    goto_url(G5_ADMIN_URL."/shop_admin/my/membercodeform.php?w=u&amp;code_num=$code_num");
} else {
    goto_url(G5_ADMIN_URL."/shop_admin/my/membercode.php");
}
<?php
$sub_menu = "110400";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$ft_background = implode("|", $_POST['ft_background']);

$sql = " update {$g5['footer_table']} set 
				ft_inc = '{$_POST['ft_inc']}',
                copyright = '{$_POST['copyright']}',
				copyright_mobile = '{$_POST['copyright_mobile']}',
				ft_background = '{$ft_background}' ";
sql_query($sql);


goto_url('./copyright_register.php', false);
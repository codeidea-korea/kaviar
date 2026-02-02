<?php
$sub_menu = "110400";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$shop_ft_background = implode("|", $_POST['shop_ft_background']);

for($i=1; $i<=5; $i++) {
	$vvar = 'footer_menu'.$i;
	$$vvar = implode('|', $_POST['footer_menu'.$i]);
}

$sql = " update {$g5['footer_table']} set 
				shop_ft_inc = '{$_POST['shop_ft_inc']}',
                shop_copyright = '{$_POST['shop_copyright']}',
				shop_ft_background = '{$shop_ft_background}',
				footer_menu1 = '{$footer_menu1}',
				footer_menu2 = '{$footer_menu2}',
				footer_menu3 = '{$footer_menu3}',
				footer_menu4 = '{$footer_menu4}',
				footer_menu5 = '{$footer_menu5}' ";
sql_query($sql);


goto_url('./shop_copyright_register.php', false);
<?php
	$sub_menu = "900100";
	include_once("./_common.php");

	auth_check_menu($auth, $sub_menu, "w");
	check_demo();
	check_admin_token();

	$sql = " update `g5_config_apppush`
				set app_push1       = '".$_POST['app_push1']."',
					app_push2       = '".$_POST['app_push2']."',
					app_push3       = '".$_POST['app_push3']."',
					app_push4       = '".$_POST['app_push4']."',
					app_push5       = '".$_POST['app_push5']."',
					app_push6       = '".$_POST['app_push6']."' ";
	sql_query($sql);

	goto_url("./push_content.php");
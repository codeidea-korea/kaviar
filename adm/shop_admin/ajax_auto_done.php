<?php
	include_once("./_common.php");

	$valus = $_POST['valus'];
	
	$sql = " update `g5_config` set cf_auto_done = $valus ";
	sql_query($sql);

?>
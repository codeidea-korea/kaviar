<?php
include_once("./_common.php");

$bl_use = $_POST['bl_use'];
$bl_id = $_POST['bl_id'];

$sql = " update {$g5['g5_shop_block_table']} set 
						bl_use = '$bl_use'
				  where bl_id = '$bl_id' ";
	sql_query($sql);
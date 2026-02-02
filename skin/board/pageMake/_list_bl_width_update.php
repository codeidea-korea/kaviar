<?php
include_once("./_common.php");

$bo_table = $_POST['bo_table'];
$bl_width = trim($_POST['bl_width']);

$sql = " update {$write_table} set
						bl_width = '$bl_width'
				  where wr_id = '$wr_id' ";
	sql_query($sql);
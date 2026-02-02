<?php
include_once("./_common.php");

$bo_table = $_POST['bo_table'];
$wr_use = $_POST['wr_use'];

$sql = " update {$write_table} set
						wr_use = '$wr_use'
				  where wr_id = '$wr_id' ";
	sql_query($sql);
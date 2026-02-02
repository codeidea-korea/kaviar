<?php
include_once("./_common.php");

$bo_table = $_POST['bo_table'];
$ca_name = trim($_POST['ca_name']);

$sql = " update {$write_table} set
						ca_name = '$ca_name'
				  where wr_id = '$wr_id' ";
	sql_query($sql);
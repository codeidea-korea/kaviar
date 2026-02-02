<?php
include_once("./_common.php");

$pp_id = $_POST['pp_id'];

sql_query(" delete from {$g5['popular_table']} where pp_id = '$pp_id' ", true);
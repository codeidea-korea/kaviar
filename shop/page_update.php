<?php
include_once('./_common.php');


$pn_id = $_POST['pn_id'];

$sql = " insert into {$g5['g5_shop_page_table']} set pn_id = '$pn_id' ";
sql_query($sql);
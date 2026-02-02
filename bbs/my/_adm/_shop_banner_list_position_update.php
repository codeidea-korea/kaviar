<?php
include_once("./_common.php");

$bn_position = trim($_POST['bn_position']);

$sql = " update {$g5['g5_shop_banner_table']}
                set bn_position   = '$bn_position'
              where bn_id = '$bn_id' ";
    sql_query($sql);
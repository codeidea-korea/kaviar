<?php
include_once("./_common.php");

$bn_location = trim($_POST['bn_location']);

$sql = " update {$g5['g5_shop_banner_table']}
                set bn_location   = '$bn_location'
              where bn_id = '$bn_id' ";
    sql_query($sql);
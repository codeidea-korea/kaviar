<?php
include_once("./_common.php");

$bn_cate = trim($_POST['bn_cate']);

$sql = " update {$g5['g5_shop_banner_table']}
                set bn_cate   = '$bn_cate'
              where bn_id = '$bn_id' ";
    sql_query($sql);
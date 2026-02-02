<?php
include_once('./_common.php');

$bn_closer_color = trim($_POST['bn_closer_color']);

$sql = " update {$g5['g5_shop_default_table']}
                set bn_closer_color   = '$bn_closer_color' ";
    sql_query($sql);
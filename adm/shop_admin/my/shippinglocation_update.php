<?php
$sub_menu = '400904';
include_once('./_common.php');



$sh_name = isset($_POST['sh_name']) ? $_POST['sh_name'] : 0;
$type = isset($_POST['type']) ? $_POST['type'] : $_GET['type'];
$ids = isset($_GET['ids']) ? $_GET['ids'] : 0;

echo $sh_name." / ".$type." / ".$ids;

if ($type=="insert") {

    $sql = " insert into `g5_shop_shipping`
                set sh_name        = '$sh_name' ";
    sql_query($sql);


}else if ($type=="delete") {

    $sql = " delete from `g5_shop_shipping` where sh_id = $ids ";
    sql_query($sql);


}

goto_url(G5_ADMIN_URL."/shop_admin/my/shippinglocation.php");

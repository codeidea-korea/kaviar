<?php
include_once("./_common.php");

$all_order_reset = $_POST['all_order_reset'];

//전체수정
for ($i=0; $i<$chk; $i++){
    $bn_id = $_POST['bn_id_up'][$i];
	if($all_order_reset) $bn_order[$i] = '';
	$sql = " update {$g5['g5_shop_banner_table']} set 
					bn_order = '$bn_order[$i]'
			  where bn_id = '$bn_id' ";
	sql_query($sql);
}


echo "<script>
location.href='".$callback_url."';
</script>";
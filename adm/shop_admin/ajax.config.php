<?php
include_once("./_common.php");


$type   = $_REQUEST['type'];
$content   = $_REQUEST['content'];


if($type == 1){ //사용유무 config 업데이트

	$sql = " update `g5_config` set cf_manager_hp = '$content' ";
	sql_query($sql);

}else if($type == 2) {
	
	$sql = " update `g5_config` set cf_manager_email = '$content'  ";
	sql_query($sql);

}else if($type == 3) {
	
	$sql = " update `g5_config` set cf_manager_hp_qna = '$content' ";
	sql_query($sql);

}else if($type == 4) {
	
	$sql = " update `g5_config` set cf_manager_email_qna = '$content' ";
	sql_query($sql);

}else if($type == 5) {
	
	$sql = " update `g5_config` set cf_manager_order_hp = '$content' ";
	sql_query($sql);

}else if($type == 6) {
	
	$sql = " update `g5_config` set cf_manager_order_email = '$content' ";
	sql_query($sql);

}else if($type == 7) {
	
	$sql = " update `g5_shop_default` set itemreview_skin = '$content' ";
	sql_query($sql);

}

echo(json_encode(
array(
	"type"			=> 'Y'
	)
));

?>

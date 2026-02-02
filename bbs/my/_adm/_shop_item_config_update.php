<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? $_POST['it_id'] : '';

$ca_id = isset($_POST['ca_id']) ? preg_replace('/[^0-9a-z]/i', '', $_POST['ca_id']) : '';
$ca_id2 = isset($_POST['ca_id2']) ? preg_replace('/[^0-9a-z]/i', '', $_POST['ca_id2']) : '';
$ca_id3 = isset($_POST['ca_id3']) ? preg_replace('/[^0-9a-z]/i', '', $_POST['ca_id3']) : '';

$item_info1_label = isset($_POST['item_info1_label']) ? $_POST['item_info1_label'] : '';
$item_info1_subject = implode("|", $_POST['item_info1_subject']);
$item_info1_value = implode("|", $_POST['item_info1_value']);

$item_info2_label = isset($_POST['item_info2_label']) ? $_POST['item_info2_label'] : '';
$item_info2_subject = implode("|", $_POST['item_info2_subject']);
$item_info2_value = implode("|", $_POST['item_info2_value']);

$item_info3_label = isset($_POST['item_info3_label']) ? $_POST['item_info3_label'] : '';
$item_info3_subject = implode("|", $_POST['item_info3_subject']);
$item_info3_value = implode("|", $_POST['item_info3_value']);

$it_type = isset($_POST['it_type']) ? $_POST['it_type'] : '';
if($it_type && $it_sc_type != 1) $it_sc_type = 1;

$it_timer = isset($_POST['it_timer']) ? $_POST['it_timer'] : '';

$sql = " update {$g5['g5_shop_item_table']} set
				 ca_id 							= '$ca_id',
				 ca_id2 							= '$ca_id2',
				 ca_id3 							= '$ca_id3',
				 it_name 						= '$it_name',
				 it_price 						= '$it_price',
				 it_cust_price 				= '$it_cust_price',
				 it_timer						= '$it_timer',
				 it_time_price					= '$it_time_price',
				 it_type1 						= '$it_type1',
				 it_type2 						= '$it_type2',
				 it_type3 						= '$it_type3',
				 it_type4 						= '$it_type4',
				 it_type5 						= '$it_type5',
				 item_info1_label 			= '$item_info1_label',
				 item_info1_subject 		= '$item_info1_subject',
				 item_info1_value 			= '$item_info1_value',
				 item_info2_label 			= '$item_info2_label',
				 item_info2_subject 		= '$item_info2_subject',
				 item_info2_value 			= '$item_info2_value',
				 item_info3_label 			= '$item_info3_label',
				 item_info3_subject 		= '$item_info3_subject',
				 item_info3_value 			= '$item_info3_value',
				 it_type 							= '$it_type',
				 it_sc_type 					= '$it_sc_type',
				 it_sc_method				= '$it_sc_method',
				 it_sc_price					= '$it_sc_price',
				 it_sc_minimum				= '$it_sc_minimum',
				 it_sc_qty						= '$it_sc_qty',
				 it_update_time 		= '".G5_TIME_YMDHIS."'
				 where it_id = '$it_id' ";
sql_query($sql);



if($_POST['close']) {
	echo "<script>
	opener.document.location.reload();
	window.close();
	</script>";
} else {
	echo "<script>
	opener.document.location.reload();
	location.href='".$callback_url."';
	</script>";
}
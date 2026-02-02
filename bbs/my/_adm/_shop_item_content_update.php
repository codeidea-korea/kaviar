<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? $_POST['it_id'] : '';

$sql = " update {$g5['g5_shop_item_table']} set
				 it_explan					= '$it_explan',
				 it_mobile_explan		= '$it_mobile_explan',
				 it_update_time			= '".G5_TIME_YMDHIS."'
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
<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? $_POST['it_id'] : '';

// 이벤트상품을 우선 삭제함
sql_query(" delete from {$g5['g5_shop_event_item_table']} where it_id = '$it_id' ");


// 이벤트상품 등록
$ev_id = explode(",", $ev_list);
for ($i=0; $i<count($ev_id); $i++)
{
	if (trim($ev_id[$i]))
	{
		$sql = " insert into {$g5['g5_shop_event_item_table']}
					set ev_id = '$ev_id[$i]',
						it_id = '$it_id' ";
		sql_query($sql, false);
	}
}



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
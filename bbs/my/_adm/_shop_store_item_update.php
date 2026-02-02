<?php
include_once('./_common.php');




// 등록된 지점 상품 먼저 삭제
$sql = " delete from {$g5['g5_shop_store_item_table']} where store_id = '$store_id' ";
sql_query($sql);

// 지점 상품등록
$item = explode(',', $store_item);
$count = count($item);

for($i=0; $i<$count; $i++) {
	$it_id = isset($item[$i]) ? $item[$i] : '';
	if($it_id) {
		$sql = " insert into {$g5['g5_shop_store_item_table']}
					set store_id = '$store_id',
						it_id = '$it_id' ";
		sql_query($sql);
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
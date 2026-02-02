<?php
include_once('./_common.php');

$it_id = isset($_POST['it_id']) ? $_POST['it_id'] : '';

// 관련상품을 우선 삭제함
sql_query(" delete from {$g5['g5_shop_item_relation_table']} where it_id = '$it_id' ");

// 관련상품의 반대도 삭제
sql_query(" delete from {$g5['g5_shop_item_relation_table']} where it_id2 = '$it_id' ");


// 관련상품 등록
$it_id2 = explode(",", $it_list);
for ($i=0; $i<count($it_id2); $i++) {
	if (trim($it_id2[$i])) {
		$sql = " insert into {$g5['g5_shop_item_relation_table']}
					set it_id  = '$it_id',
						it_id2 = '$it_id2[$i]',
						ir_no = '$i' ";
		sql_query($sql, false);

		// 관련상품의 반대로도 등록
		$sql = " insert into {$g5['g5_shop_item_relation_table']}
					set it_id  = '$it_id2[$i]',
						it_id2 = '$it_id',
						ir_no = '$i' ";
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
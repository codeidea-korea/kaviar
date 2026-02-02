<?php
	include_once(dirname(__DIR__)."/common.php");

	//희망배송일이 존재하는 배송보류상품 준비로 변경하기	
	$result = sql_query("select * from `g5_shop_order` where od_status = '배송보류' and od_delivery_date = '".date("Y-m-d")."' ");

	for ($y=0; $row=sql_fetch_array($result); $y++) {
		
		$sql = " update {$g5['g5_shop_cart_table']}
					set ct_status = '준비'
					where od_id = '".$row['od_id']."' ";
		sql_query($sql);			

		$sql = " update {$g5['g5_shop_order_table']}
				set od_status = '준비'
				where od_id = '".$row['od_id']."' ";
		sql_query($sql);
	
	
	}
?>
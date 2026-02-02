	<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

//$sql = " select * from {$g5['g5_shop_coupon_zone_table']} where cz_code = '$cu_code' ";
//$cp = sql_fetch($sql);

//$result = sql_fetch("select * from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mb_id = '".$member['mb_id']."' order by ct_id desc LIMIT 1 ");
//$tot_count = sql_num_rows($result);
//$tot_count = isset($tot_count) ? $tot_count : 0;


$result = sql_query("select * from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mb_id = '".$member['mb_id']."' group by it_id ");
$cc = 0;
$is_id = array();
for ($i=0; $row=sql_fetch_array($result); $i++) {

	$item_chk = sql_fetch(" select * from {$g5['g5_shop_item_use_table']} where it_id = '".$row['it_id']."' and mb_id = '".$member['mb_id']."' group by it_id ");
	$use_cnt = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_use_table']} where it_id = '".$row['it_id']."' and mb_id = '".$member['mb_id']."' ");
	$order_cnt = sql_fetch("select count(*) as cnt from {$g5['g5_shop_cart_table']} where ct_status = '완료' and mb_id = '".$member['mb_id']."' and it_id = '".$row['it_id']."' ");
	
	
	if(!$item_chk['is_id']){
		$cc++;
		array_push($is_id, $row['it_id']);
	}else{

		if($use_cnt['cnt'] != $order_cnt['cnt']){
			array_push($is_id, $row['it_id']);
			$cc++;
			
		}
	}
		
	
	
}
/*
echo $cc;
print_r($is_id);
*/
if($cc == 0){
	$msg = "후기를 작성할 수 있는 상품이 없습니다.\n상품을 주문해보세요.";

}else{
	
	//$is_in = explode(",",$is_id);

	for($y=0; $y<count($is_id); $y++){
		if($y == 0){
			$inarray = "'".$is_id[$y]."'";
		}else{
			$inarray = $inarray.",'".$is_id[$y]."'";
		}
	}
	
	$review_id = sql_fetch(" select * from {$g5['g5_shop_cart_table']} where it_id in (".$inarray.") and mb_id = '".$member['mb_id']."' order by ct_id desc limit 1");

}


//print_r($is_id);


echo(json_encode(
array(
	"msg" => $msg, "count" => $cc, "review_id" => $review_id['it_id']
	)
));
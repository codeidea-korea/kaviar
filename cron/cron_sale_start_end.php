<?php
dirname(__DIR__) ;
include_once(dirname(__DIR__)."/common.php");

$today = date("Y-m-d H:i");
//$today = "2024-03-20";
//echo $today;

//상품판매 시작일 종료일 업데이트하기
$result_start = sql_fetch("select count(*) as cnt from `g5_shop_item` where it_sale_start_date <= '$today' and it_sale_start_date != '0000-00-00 00:00:00' AND it_use = 0 ");
//echo "aa : ".$result_start['cnt']."<br>";
if($result_start['cnt']){

	$result = sql_query("select * from {$g5['g5_shop_item_table']} where it_sale_start_date <= '$today' and it_sale_start_date != '0000-00-00 00:00:00' AND it_use = 0 ");
	
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		//echo "a : ".$row['it_sale_start_date']."<br>";
		sql_query(" update `g5_shop_item` set it_use = '1' where it_id = '".$row['it_id']."' ");
	}
	

	
}

$result_end = sql_fetch("select count(*) as cnt from `g5_shop_item` where it_sale_end_date <= '$today' and it_sale_end_date != '0000-00-00 00:00:00' AND it_use = 1 ");
//echo "bb : ".$result_end['cnt']."<br>";
if($result_end['cnt']){

	$result = sql_query("select * from {$g5['g5_shop_item_table']} where it_sale_end_date <= '$today' and it_sale_end_date != '0000-00-00 00:00:00' AND it_use = 1 ");
	
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		echo "b : ".$row['it_sale_start_date']."<br>";
		sql_query(" update `g5_shop_item` set it_use = '0' where it_id = '".$row['it_id']."' ");
	}
	
}


?>
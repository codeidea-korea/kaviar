<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.kakao.lib.php');

	//3일동안 카트에 있는경우 푸쉬 발송
	$now = date('Y-m-d H:i:s',time());
	$day_7ago = date('Y-m-d',strtotime($now."+7 day"));     // 3일전

	//$result = sql_query("select * from `g5_point` where date(po_expire_date) = '".$day_7ago."' ");
	$sql = " select sum(po_point - po_use_point) as sum_point
                from `g5_point`
                where mb_id = 'naver_9a9609a3'
                  and po_expired = '0'
                  and po_expire_date <> '9999-12-31'
                  and date(po_expire_date) = '".$day_7ago."' ";
    $row = sql_fetch($sql);
	
	echo $row['sum_point'];

	exit;
	
?>
<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.kakao.lib.php');
	
	$now = date('Y-m-d');
	$sql = " select mb_id
                from {$g5['point_table']}
                where po_expired = '0'
                  and po_expire_date <> '9999-12-31'
                  and po_expire_date = '".$now."' ";
				  
    $result = sql_query($sql);

	for ($i=0; $row=sql_fetch_array($result); $i++) {
		
		$sum_point = get_point_sum($row['mb_id']);

		$sql= " update {$g5['member_table']} set mb_point = '$sum_point' where mb_id = '".$row['mb_id']."' ";
		sql_query($sql);
	}
?>
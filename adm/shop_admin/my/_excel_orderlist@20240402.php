<?php
$sub_menu = '400400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");


$where = array();

$doc = isset($_GET['doc']) ? clean_xss_tags($_GET['doc'], 1, 1) : '';
$sort1 = (isset($_GET['sort1']) && in_array($_GET['sort1'], array('od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash'))) ? $_GET['sort1'] : '';
$sort2 = (isset($_GET['sort2']) && in_array($_GET['sort2'], array('desc', 'asc'))) ? $_GET['sort2'] : 'desc';
$sel_field = (isset($_GET['sel_field']) && in_array($_GET['sel_field'], array('od_id', 'mb_id', 'od_name', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_deposit_name', 'od_invoice')) ) ? $_GET['sel_field'] : ''; 
$od_status = isset($_GET['od_status']) ? get_search_string($_GET['od_status']) : '';
$search = isset($_GET['search']) ? get_search_string($_GET['search']) : '';

$fr_date = (isset($_GET['fr_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['fr_date'])) ? $_GET['fr_date'] : '';
$to_date = (isset($_GET['to_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['to_date'])) ? $_GET['to_date'] : '';

$od_misu = isset($_GET['od_misu']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_misu']) : '';
$od_cancel_price = isset($_GET['od_cancel_price']) ? preg_replace('/[^0-9a-z]/', '', $_GET['od_cancel_price']) : '';
$od_refund_price = isset($_GET['od_refund_price']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_refund_price']) : '';
$od_receipt_point = isset($_GET['od_receipt_point']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_receipt_point']) : '';
$od_coupon = isset($_GET['od_coupon']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_coupon']) : ''; 
$od_settle_case = isset($_GET['od_settle_case']) ? clean_xss_tags($_GET['od_settle_case'], 1, 1) : ''; 
$od_escrow = isset($_GET['od_escrow']) ? clean_xss_tags($_GET['od_escrow'], 1, 1) : ''; 

$tot_itemcount = $tot_orderprice = $tot_receiptprice = $tot_ordercancel = $tot_misu = $tot_couponprice = 0;
$sql_search = "";
if ($search != "") {
    if ($sel_field != "") {
        $where[] = " $sel_field like '%$search%' ";
    }

    if ($save_search != $search) {
        $page = 1;
    }
}

if ($od_status) {
    switch($od_status) {
        case '전체취소':
            $where[] = " od_status = '취소' ";
            break;
        case '부분취소':
            $where[] = " od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
        default:
            $where[] = " od_status = '$od_status' ";
            break;
    }

    switch ($od_status) {
        case '주문' :
            $sort1 = "od_id";
            $sort2 = "desc";
            break;
        case '입금' :   // 결제완료
            $sort1 = "od_receipt_time";
            $sort2 = "desc";
            break;
        case '배송' :   // 배송중
            $sort1 = "od_invoice_time";
            $sort2 = "desc";
            break;
    }
}

if ($od_settle_case) {
    if( $od_settle_case === '간편결제' ) {
        $where[] = " od_settle_case in ('간편결제', '삼성페이', 'lpay', 'inicis_kakaopay') ";
    } else {
        $where[] = " od_settle_case = '$od_settle_case' ";
    }
}

if ($od_misu) {
    $where[] = " od_misu != 0 ";
}

if ($od_cancel_price) {
    $where[] = " od_cancel_price != 0 ";
}

if ($od_refund_price) {
    $where[] = " od_refund_price != 0 ";
}

if ($od_receipt_point) {
    $where[] = " od_receipt_point != 0 ";
}

if ($od_coupon) {
    $where[] = " ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
}

if ($od_escrow) {
    $where[] = " od_escrow = 1 ";
}

if ($fr_date && $to_date) {
    $where[] = " od_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
}

if ($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

if ($sel_field == "")  $sel_field = "od_id";
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_order_table']} $sql_search ";


$sql = " select count(od_id) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql  = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice 
           $sql_common
           order by $sort1 $sort2 ";
$result = sql_query($sql);

if(! function_exists('column_char')) {
    function column_char($i) {
        return chr( 65 + $i );
    }
}

if (phpversion() >= '5.2.0') {
    include_once(G5_LIB_PATH.'/PHPExcel.php');
    
    $headers = array('번호','주문번호','회원아이디','주문상품','상품코드','주문수량','회원할인','총결제금액','실결제금액','사용적립금','사용쿠폰명','사용예치금','배송비','타임세일','전체상품쿠폰 할인금액','상품금액별할인','개별상품쿠폰 할인금액','부분취소금액','결제방법','주문상태','배송회사','운송장번호','배송비형태','배송보류','해외배송 국가','상품총액','전체상품쿠폰 할인금액','원가');
	
    $widths  = array(10, 25, 15, 50, 15, 15, 15, 15, 15, 15, 25, 15, 15, 15, 15, 15, 15, 20, 20, 20 ,20, 15, 15, 15, 15, 15, 15, 15, 15,15, 15);
    $header_bgcolor = 'FFABCDEF';
	
	if((count($headers) + 64) == 92){
		$last_char = 'AB';
	}else{
		$last_char = column_char(count($headers) - 1);
	}

    $rows = array();

    for($i=1; $row=sql_fetch_array($result); $i++) {

		$s_receipt_way = $s_br = "";
		if ($row['od_settle_case'])
		{
			$s_receipt_way = check_pay_name_replace($row['od_settle_case'], $row);
			$s_br = chr(10);
		}
		else
		{
			$s_receipt_way = '결제수단없음';
			$s_br = chr(10);
		}

		if ($row['od_receipt_point'] > 0)
			$s_receipt_way .= $s_br."포인트";

		$mb_nick = $row['od_name'];

		$od_cnt = 0;
		if ($row['mb_id'])
		{
			$sql2 = " select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$row['mb_id']}' ";
			$row2 = sql_fetch($sql2);
			$od_cnt = $row2['cnt'];
		}

		// 주문 번호에 device 표시
		$od_mobile = '';
		if($row['od_mobile'])
			$od_mobile = '(M)';

		// 주문번호에 - 추가
		
		switch(strlen($row['od_id'])) {
			case 16:
				$disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
				break;
			default:
				$disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
				break;
		}

		// 주문 번호에 에스크로 표시
		$od_paytype = '';
		if($row['od_test'])
			$od_paytype .= '<span class="list_test">테스트</span>';

		if($default['de_escrow_use'] && $row['od_escrow'])
			$od_paytype .= '<span class="list_escrow">에스크로</span>';

		$uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

		$invoice_time = is_null_time($row['od_invoice_time']) ? G5_TIME_YMDHIS : $row['od_invoice_time'];
		$delivery_company = $row['od_delivery_company'] ? $row['od_delivery_company'] : $default['de_delivery_company'];

		$bg = 'bg'.($i%2);
		$td_color = 0;
		if($row['od_cancel_price'] > 0) {
			$bg .= 'cancel';
			$td_color = 1;
		}
		// 상품목록
		$itemsql = " select it_id, it_name from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' group by it_id order by ct_id ";
		$itemresult = sql_query($itemsql);

		$counts = " select COUNT(*) as cnt FROM ( select * from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' group by it_id order by ct_id ) a";
		$res_count = sql_fetch($counts);

		$optionsqls = " select * from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' group by it_id order by ct_id";
		$ress = sql_query($optionsqls);
		$ress1 = sql_query($optionsqls);
		$ress2 = sql_query($optionsqls);

		$orign_r= " SELECT a.*,b.it_cust_price from `g5_shop_cart` a, `g5_shop_item` b WHERE a.it_id = b.it_id AND  a.od_id = '{$row['od_id']}' group BY a.it_id order BY a.ct_id ";
		$orign = sql_query($orign_r);

		$coupon_sql = " select * from {$g5['g5_shop_coupon_log_table']} where od_id = '{$row['od_id']}'";
		$coupon_result = sql_query($coupon_sql);
		
		$it_name ='';
		for($t=0; $itemrow=sql_fetch_array($itemresult); $t++) {
			$it_name .= $itemrow['it_name'];

			// 상품의 옵션정보
            $optionsql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}'
                          and it_id = '{$itemrow['it_id']}'
                        order by io_type asc, ct_id asc ";

            $res = sql_query($optionsql);

			
			$c=0;
			
			for($k=0; $opt=sql_fetch_array($res); $k++) {
				if($itemrow['it_name'] != $opt['ct_option']){
	                $it_name .= get_text($opt['ct_option']).chr(10);
					$c++;
				}
			}
			
			if($t < $res_count['cnt'] - 1) $it_name .= chr(10);

		}

		$it_id ='';
		for($v=0; $rew=sql_fetch_array($ress); $v++) {
			$it_id .= ($v==0)?$rew['it_id']:chr(10).$rew['it_id'];
		}
		$cz_subject = '';
		for($c=0; $crow=sql_fetch_array($coupon_result); $c++) {
			$cz_subject .= ($c==0)?$crow['cz_subject']:chr(10).$rew['cz_subject'];
		}
		$ct_time_price = '';
		for($c1=0; $crow1=sql_fetch_array($ress1); $c1++) {
			$ct_time_price .= ($c1==0)?number_format($crow1['ct_time_price']):chr(10).number_format($crow1['ct_time_price']);	
		}
		$cp_price = '';
		for($c2=0; $crow2=sql_fetch_array($ress2); $c2++) {
			$cp_price .= ($c2==0)?number_format($crow2['cp_price']):chr(10).number_format($crow2['cp_price']);
		}
		
		$send = $row['od_send_cost'] + $row['od_send_cost2'];
		if($send == 0) { 
			$sends = "무료"; 
		}else{ 
			$sends = "무료";
		};

		$it_cust_price = '';
		for($o=0; $o2=sql_fetch_array($orign); $o++) {
			$it_cust_price .= ($o==0)?number_format($o2['it_cust_price']):chr(10).number_format($o2['it_cust_price']);
		}
		
		

        $rows[] = 
                    array($i,
						  ' '.$row['od_id'], 
                          $row['mb_id']?$row['mb_id']:'비회원', 
                          $it_name, 
                          $it_id, 
                          $row['od_cart_count'],
						  '0',
                          number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']), 
                          number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']), 
                          number_format($row['od_receipt_point']),
                          $cz_subject,
                          '0', 


                          number_format($row['od_send_cost'] + $row['od_send_cost2']), 
                          $ct_time_price,
                          number_format($row['couponprice']), 
                          '', 
                          $cp_price, 
                          number_format($row['od_cancel_price']), 
                          $s_receipt_way,
                          $row['od_status'],
                          $row['od_delivery_company'] ? $row['od_delivery_company'] : '', 
                          $row['od_invoice'] ? $row['od_invoice'] : '', 
                          $sends, 
                          '', 
                          '', 
                          number_format($row['od_receipt_price']), 
                          number_format($row['couponprice']), 
                          $it_cust_price);
    }








    $data = array_merge(array($headers), $rows);

    $excel = new PHPExcel();
	
    $excel->setActiveSheetIndex(0)->getStyle("A1:${last_char}1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
	$excel->getActiveSheet()->getStyle("A1:${last_char}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //가운데 정렬

	$excel->getActiveSheet()->getStyle("E2:AB100")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //가운데 정렬
	$excel->setActiveSheetIndex(0)->getStyle( "E2:AB100" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
	
	$excel->setActiveSheetIndex(0)->getStyle("U2:V100")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("d2d2d2");
    $excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
	$excel->setActiveSheetIndex(0)->getStyle( "D:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
    foreach($widths as $i => $w){
		$excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);
	}
    $excel->getActiveSheet()->fromArray($data,NULL,'A1');
	

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"deliverylist-".date("ymd", time()).".xls\"");
    header("Cache-Control: max-age=0");

    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
    $writer->save('php://output');
} else {
    /*================================================================================
    php_writeexcel http://www.bettina-attack.de/jonny/view.php/projects/php_writeexcel/
    =================================================================================*/

    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_workbook.inc.php');
    include_once(G5_LIB_PATH.'/Excel/php_writeexcel/class.writeexcel_worksheet.inc.php');

    $fname = tempnam(G5_DATA_PATH, "tmp-deliverylist.xls");
    $workbook = new writeexcel_workbook($fname);
    $worksheet = $workbook->addworksheet();

    // Put Excel data
    $data = array('주문번호', '주문자명', '주문자전화1', '주문자전화2', '배송자명', '배송지전화1', '배송지전화2', '배송지주소', '배송회사', '운송장번호');
    $data = array_map('iconv_euckr', $data);

    $col = 0;
    foreach($data as $cell) {
        $worksheet->write(0, $col++, $cell);
    }

    for($i=1; $row=sql_fetch_array($result); $i++) {
        $row = array_map('iconv_euckr', $row);

        $worksheet->write($i, 0, ' '.$row['od_id']);
        $worksheet->write($i, 1, $row['od_name']);
        $worksheet->write($i, 2, ' '.$row['od_tel']);
        $worksheet->write($i, 3, ' '.$row['od_hp']);
        $worksheet->write($i, 4, $row['od_b_name']);
        $worksheet->write($i, 5, ' '.$row['od_b_tel']);
        $worksheet->write($i, 6, ' '.$row['od_b_hp']);
        $worksheet->write($i, 7, print_address($row['od_b_addr1'], $row['od_b_addr2'], $row['od_b_addr3'], $row['od_b_addr_jibeon']));
        $worksheet->write($i, 8, $row['od_delivery_company']);
        $worksheet->write($i, 9, $row['od_invoice']);
    }

    $workbook->close();

    header("Content-Type: application/x-msexcel; name=\"deliverylist-".date("ymd", time()).".xls\"");
    header("Content-Disposition: inline; filename=\"deliverylist-".date("ymd", time()).".xls\"");
    $fh=fopen($fname, "rb");
    fpassthru($fh);
    unlink($fname);
}
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


if ($fr_date && $to_date == ''){
    $where[] = " od_time >= '$fr_date' ";
}else if ($fr_date == '' && $to_date){
    $where[] = " od_time <= '$to_date' ";
}else if ($fr_date && $to_date) {
    $where[] = " od_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
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

$sql  = " select * from ( select *
            ,(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
			, (SELECT it_id FROM g5_shop_cart WHERE g5_shop_cart.od_id = g5_shop_order.od_id AND g5_shop_cart.it_id = '1724917878' LIMIT 1) AS it_id
           $sql_common
		   )c where it_id = '1724917878'
           order by $sort1 $sort2";
$result = sql_query($sql);


if(! function_exists('column_char')) {
    function column_char($i) {
        return chr( 65 + $i );
    }
}

if (phpversion() >= '5.2.0') {
    include_once(G5_LIB_PATH.'/PHPExcel.php');
    
    $headers = array('고유ID','주문번호', '상품주문번호', '주문상태', '배송회사', '운송장번호', '수취인명', '수취인 전화번호', '수취인 핸드폰번호', '수취인 우편번호', '수취인 주소', '배송메세지',  '상품번호(코드)', '모델명', '주문상품', '상품옵션', '주문수량', '포장단위별 수량', '상품총액', '배송비', '포인트사용액', '할인(쿠폰)', '주문 별 실결제금액(배송비 미포함)', '주문 별 실결제금액(배송비 포함)', '구매자명', '구매자 전화번호', '구매자 아이디', '주문일시', '입금일시', '주문일');
	


    $widths  = array(10, 20, 20, 10, 15, 20, 15, 20, 20, 10, 30, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 40, 40, 40, 40, 40, 30);
    $header_bgcolor = 'FFABCDEF';
	
	if((count($headers) + 62) == 92){
		$last_char = 'AD';
	}else{
		$last_char = column_char(count($headers) - 1);
	}

    $rows = array();

    for($i=1; $row=sql_fetch_array($result); $i++) {

		// 결제 수단
		$s_receipt_way = $s_br = "";
		if ($row['od_settle_case'])
		{
			$s_receipt_way = check_pay_name_replace($row['od_settle_case'], $row);
			$s_br = '<br />';
		}
		else
		{
			$s_receipt_way = '결제수단없음';
			$s_br = '<br />';
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
		//$itemsql = " select io_price, ct_id, ct_status, it_id, it_name,ct_qty,ct_price,ct_point,ct_invoice_number from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' group by it_id order by ct_id ";
		$itemsql = " select io_price, ct_id, ct_status, it_id, it_name,ct_qty,ct_price,ct_point,ct_invoice_number from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' and it_id = '1724917878' order by ct_id ";
		$itemresult = sql_query($itemsql);
		

		$ct_option = "";
		$it_model = "";
		$it_info_values = "";
		$y = 1;
		for($k=0; $ite=sql_fetch_array($itemresult); $k++) {	
			

			$optionsql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
                        from {$g5['g5_shop_cart_table']}
                        where od_id = '{$row['od_id']}'
                          and it_id = '{$ite['it_id']}'
						  and ct_id = '{$ite['ct_id']}'
                        order by io_type asc, ct_id asc ";
            $res = sql_query($optionsql);
			
			for($kk=0; $opt=sql_fetch_array($res); $kk++) {
				$ct_option = get_text($opt['ct_option']);
				
				
			}

			$itemmodel = sql_fetch(" select it_model from {$g5['g5_shop_item_table']} where it_id = '{$ite['it_id']}' ");
			$it_model = $itemmodel['it_model'];
			$it_info_values = $itemmodel['it_info_value'];

			if($k==0){
				$d_price = number_format($row['od_send_cost'] + $row['od_send_cost2']); //배송비
				$p_point = $row['od_receipt_point']; //적립금
				$d_coupon = $row['od_coupon'];
				$s_price = ($ite['ct_price'] + $ite['io_price']) * $ite['ct_qty'];
				$s_price1 = ($ite['ct_price'] + $ite['io_price']) * $ite['ct_qty'] - $row['od_receipt_point'] - $row['od_coupon'];
				$s_price2 = $s_price + $row['od_send_cost'] + $row['od_send_cost2'];
				
				//echo $ite['ct_price']." + ".$ite['io_price']." * ".$ite['ct_qty']." - ".$row['od_receipt_point']." - ".$row['od_coupon']." /// ".$s_price."<br>";
			}else{
				$d_price = 0;
				$p_point = 0;
				$d_coupon = 0;
				$s_price = ($ite['ct_price'] + $ite['io_price']) * $ite['ct_qty'];
				$s_price1 = ($ite['ct_price'] + $ite['io_price']) * $ite['ct_qty'];
				$s_price2 = $s_price;
				
			}
			

			$rows[] = 
					array($ite['ct_id'],	//순서
						$disp_od_id,	//주문번호
						$disp_od_id."-".$y,	//상품주문번호
						get_text($ite['ct_status']), //주문상태
						$ite['ct_invoice_company'] ? get_text($ite['ct_invoice_company']) : '',  //배송회사
						$ite['ct_invoice_number'] ? get_text($ite['ct_invoice_number']) : '',  //운송장번호
						get_text($row['od_b_name']),//수취인명
						get_text($row['od_b_hp']),	//수취인 전화번호번호
						get_text($row['od_b_hp']),	//수취인 핸드폰번호
						get_text($row['od_b_zip1']."".$row['od_b_zip2']),	//수취인 우편번호
						get_text($row['od_b_addr1']." ".$row['od_b_addr2']." ".$row['od_b_addr3']),	//수취인주소
						get_text($row['od_memo']),	//배송메세지
						$ite['it_id'],	//상품번호(코드)
						$it_model,	//모델
						$ite['it_name'],	//주문상품
						$ct_option,	//상품옵션
						$ite['ct_qty'],	//주문수량
						$it_info_values, //포장단위별수량
						$s_price,	//상품총액	
						$d_price, //배송비
						$p_point, //$ite['ct_point'] 포인트사용금액
						$d_coupon,	//주문별할인쿠폰
						$s_price1, //실결제금액 //상품 주문 별 실결제금액 (배송비 미포함)
						$s_price2, //실결제금액 //상품 주문 별 실결제금액 (배송비 포함)
						get_text($row['od_name']),	//구매자명		  
						get_text($row['od_hp']),	//구매자핸드폰번호
						get_text($row['mb_id']),	//회원아이디
						get_text($row['od_time']),	//주문일시
						get_text($row['od_receipt_time']),	//입금일시
						get_text(substr($row['od_time'],0,10))	//입금일시
					);
			$y++;
		}
    }








    $data = array_merge(array($headers), $rows);

    $excel = new PHPExcel();
	
    $excel->setActiveSheetIndex(0)->getStyle("A1:${last_char}1")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB($header_bgcolor);
	$excel->getActiveSheet()->getStyle("A1:${last_char}1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //가운데 정렬
	
	$excel->getActiveSheet()->getStyle("A1:AD1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //가운데 정렬
	$excel->getActiveSheet()->getStyle("A2:AD1000")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //가운데 정렬
	$excel->getActiveSheet()->getStyle("K2:L1000")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //왼쪽 정렬
	$excel->getActiveSheet()->getStyle("O2:P1000")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //왼쪽 정렬
	//$excel->getActiveSheet()->getStyle("B2:D1000")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //왼쪽 정렬
	//$excel->getActiveSheet()->getStyle("F2:AC1000")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT); //왼쪽 정렬
	//$excel->setActiveSheetIndex(0)->getStyle( "E2:AB100" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);


	$excel->setActiveSheetIndex(0)->getStyle("F2:F1000")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	$excel->setActiveSheetIndex(0)->getStyle("M2:M1000")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	$excel->setActiveSheetIndex(0)->getStyle("W2:X1000")->getNumberFormat()->setFormatCode('#,##0');
	$excel->setActiveSheetIndex(0)->getStyle("S2:S1000")->getNumberFormat()->setFormatCode('#,##0');
	//$excel->setActiveSheetIndex(0)->getStyle("D2:D1000")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	
	

	$excel->setActiveSheetIndex(0)->getStyle("F2:F100")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB("d2d2d2");
	$excel->getActiveSheet()->getStyle('A2:AD1000')->getAlignment()->setWrapText(false);
	$excel->getActiveSheet()->getStyle('A1:AD1000')->getFont()->setSize(9);
	$excel->getActiveSheet()->getStyle('A1:AD1000')->getFont()->setName("Arial");
    $excel->setActiveSheetIndex(0)->getStyle( "A:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);
	$excel->setActiveSheetIndex(0)->getStyle( "D:$last_char" )->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setWrapText(true);

    foreach($widths as $i => $w){
		$excel->setActiveSheetIndex(0)->getColumnDimension( column_char($i) )->setWidth($w);
	}
    $excel->getActiveSheet()->fromArray($data,NULL,'A1');
	
	$excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
	$excel->getActiveSheet()->getColumnDimension('A')->setWidth('10');
	$excel->getActiveSheet()->getColumnDimension('AA')->setAutoSize(false);
	$excel->getActiveSheet()->getColumnDimension('AA')->setWidth('20');
	$excel->getActiveSheet()->getColumnDimension('AB')->setAutoSize(false);
	$excel->getActiveSheet()->getColumnDimension('AB')->setWidth('20');
	$excel->getActiveSheet()->getColumnDimension('AC')->setAutoSize(false);
	$excel->getActiveSheet()->getColumnDimension('AC')->setWidth('20');
	$excel->getActiveSheet()->getColumnDimension('AD')->setAutoSize(false);
	$excel->getActiveSheet()->getColumnDimension('AD')->setWidth('20');

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
<?php
$sub_menu = '400400';
include_once('./_common.php');
include_once('./admin.shop.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
include_once(G5_LIB_PATH.'/my/fcm.lib.php');

auth_check_menu($auth, $sub_menu, "w");

define("_ORDERMAIL_", true);

$sms_count = 0;
$sms_messages = array();

if(isset($_FILES['excelfile']['tmp_name']) && $_FILES['excelfile']['tmp_name']) {
    $file = $_FILES['excelfile']['tmp_name'];

    include_once(G5_LIB_PATH.'/PHPExcel/IOFactory.php');

    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $sheet = $objPHPExcel->getSheet(0);

    $num_rows = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    $fail_od_id = array();
	$od_id_array = array();
	$ct_id_array = array();
    $total_count = 0;
    $fail_count = 0;
    $succ_count = 0;
	$od_ids = "";
    // $i 사용시 ordermail.inc.php의 $i 때문에 무한루프에 빠짐
    for ($k = 2; $k <= $num_rows; $k++) {
		
		$rowData = $sheet->rangeToArray('A' . $k . ':' . $highestColumn . $k,
												NULL,
												TRUE,
												FALSE);
		
	
		if($rowData[0][5] != ''){
			
			$od_id               = preg_replace ("/[-]/i", "", isset($rowData[0][1]) ? addslashes(trim($rowData[0][1])) : '');
			$od_status			 = isset($rowData[0][3]) ? addslashes($rowData[0][3]) : '';
			$od_company          = isset($rowData[0][4]) ? addslashes($rowData[0][4]) : '';
			$od_invoice          = isset($rowData[0][5]) ? addslashes($rowData[0][5]) : '';
			$ct_id		         = isset($rowData[0][0]) ? addslashes($rowData[0][0]) : '';
			$od_ids				 = $od_id;
			

			

			if(!$od_id || !$od_invoice) {
				$fail_count++;
				$fail_od_id[] = $od_id;
				continue;
			}

			// 주문정보
			$od = sql_fetch(" select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");
			
			if (!$od) {
				$fail_count++;
				$fail_od_id[] = $od_id;
				continue;
			}
			
			if($od['od_status'] != '준비') {
				$fail_count++;
				$fail_od_id[] = $od_id;
				continue;
			}

			$delivery['invoice'] = $od_invoice;
			$delivery['invoice_time'] = G5_TIME_YMDHIS;
			$delivery['delivery_company'] = $od_company;

			
			if($od_status == '준비' && $od_invoice != '' ) {
				
				$od_id_array[] = $od_id;
				$od_invoice_array[] = $od_invoice;
				$ct_id_array[] = $ct_id;
				
			
				// 주문정보 업데이트
				order_update_delivery($od_id, $od['mb_id'], '배송', $delivery);
				
				sql_query(" update {$g5['g5_shop_cart_table']} set ct_invoice_company = '".$od_company."', ct_invoice_number = '".$od_invoice."', ct_invoice_number_time = '".G5_TIME_YMDHIS."' where ct_id = '".$ct_id."' and ct_status = '준비' ");

				sql_query(" update {$g5['g5_shop_cart_table']} set ct_status = '배송' where ct_id = '".$ct_id."' and ct_status = '준비' ");

				//change_status($od_id, '준비', '배송');

				$succ_count++;
			}

		}
    }
	

	$uniqueOd_idArray = array_values(array_unique($od_id_array));
	$uniqueCt_idArray = array_values(array_unique($ct_id_array));
	$uniqueOd_InvoiceArray = array_values(array_unique($od_invoice_array));


	for ($oo=0; $oo < count($uniqueOd_idArray); $oo++){
		$ct_invoice = "";
		$odd = sql_fetch("SELECT * FROM `g5_shop_order` where od_id = '".$uniqueOd_idArray[$oo]."' ");
		
		if ($odd['mb_id']){
			$receive_numbers = $odd['od_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}else{
			$receive_numbers = $odd['od_b_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}
		
		//$receive_numbers = $odd['od_hp'];
		//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

		$sms_content8 = $default['de_sms_cont8'];	
		$sms_content8 = str_replace("{이름}", $odd['od_name'], $sms_content8);
		$sms_content8 = str_replace("{회원아이디}", $odd['mb_id'], $sms_content8);
		$sms_content8 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content8);
		$sms_content8 = str_replace("{주문번호}", $odd['od_id'], $sms_content8);
		$sms_content8 = str_replace("{주문금액}", number_format($odd['od_receipt_price'])."원", $sms_content8);
		$sms_content8 = str_replace("{주문일자}", $odd['od_time'], $sms_content8);
		$sms_content8 = str_replace("{배송사}", $odd['od_delivery_company'], $sms_content8);
		
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
		
		$od_cart = sql_query("SELECT * FROM `g5_shop_cart` where od_id = '".$uniqueOd_idArray[$oo]."' ");
		for ($ct=0; $ct=sql_fetch_array($od_cart); $ct++){
		//for ($ct=0; $ct < count($uniqueCt_idArray); $ct++){
	
			if($ct==0){
				//$ct_invoice = "\n".$ct['it_name']." : ".$uniqueOd_InvoiceArray[$oo];
				$ct_invoice = "\n".$ct['it_name']." : ".$ct['ct_invoice_number'];
				$ct_company = $ct['ct_invoice_company'];
			}else{
				//$ct_invoice .= "\n".$ct['it_name']." : ".$uniqueOd_InvoiceArray[$oo];
				$ct_invoice .= "\n".$ct['it_name']." : ".$ct['ct_invoice_number'];
				$ct_company = $ct['ct_invoice_company'];
			}
			//echo "<br>".$uniqueOd_idArray[$oo]." -- ".$ct_invoice."<br>";
		}

		//알림톡발송
		//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
		$kresult = kakao_alim("TU_2148", $odd['od_hp'], $odd['od_name'], "", "", "", "", "", $odd['od_delivery_company'], $ct_invoice);
		$sms_content8 = str_replace("{송장번호}", $ct_invoice, $sms_content8);
		if($kresult != 'Y'){
			//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
			aligo_sms_call($sms_content8, $receive_number, $send_number, "", "", "");
		}
		order_email_call('배송중', $odd['od_email'], $odd['mb_id'], $odd['od_id'], $odd['od_name'], $odd['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content8);



		//배송시 PUSH발송 토큰 / 내용
		$sql = " select * from `g5_shop_cart` where od_id = '".$odd['od_id']."' ";
		$od_cart = sql_query($sql);
		$product = "";
		$product_qty = 0;

		for ($uu=0; $row=sql_fetch_array($od_cart); $uu++){
			
			if($uu == 0){
				$price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty'];
				$product = $row['it_name']."(".$row['ct_option'].")";
			}else{
				$product_qty++;
			}
		}

		if($product_qty > 0){
			$product .= " 외 ".$product_qty."EA 가";
		}
		$push_content = str_replace("{상품명}", $product, $config_apppush['app_push1']);
		$push_token = $mb_grades['mb_mobile_token'];

		if($push_token){
			fcm_send($push_token, $push_content);
		}


		sql_query(" update {$g5['g5_shop_order_table']} set od_status = '배송' where od_id = '".$odd['od_id']."' ");
	}
}

// SMS


$g5['title'] = '엑셀 배송일괄처리 결과';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>배송일괄처리를 완료했습니다.</p>
    </div>

    <dl id="excelfile_result">
        <dt>총배송건수</dt>
        <dd><?php echo number_format($total_count); ?></dd>
        <dt class="result_done">완료건수</dt>
        <dd class="result_done"><?php echo number_format($succ_count); ?></dd>
        <dt class="result_fail">실패건수</dt>
        <dd class="result_fail"><?php echo number_format($fail_count); ?></dd>
        <?php if($fail_count > 0) { ?>
        <dt>실패주문코드</dt>
        <dd><?php echo implode(', ', $fail_od_id); ?></dd>
        <?php } ?>
    </dl>

    <div class="btn_confirm01 btn_confirm">
        <button type="button" onclick="window.close();">창닫기</button>
    </div>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
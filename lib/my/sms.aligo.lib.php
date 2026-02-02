<?php
$senderAddress = "kaviarmall@kaviar.kr";
$def = sql_fetch(" select * from `g5_shop_default` where (1) ");
$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_1.jpg";

$temp_top = '<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" style=" border:1px solid #bbc0c4;">
	<tbody>
		<tr>
			<td style="padding:24px 14px 0;">
				<table width="670" border="0" cellpadding="0" cellspacing="0">
					<tbody>
	
						<tr>
							<td>
										
								<table width="670" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-family:Gulim; color:#393939; line-height:19px;">
									<tbody>
	
										<tr>
											<td>
												
														
												<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-family:Gulim; line-height:15px;">
												<thead>


													<tr>
														<td style="padding:30px 0 60px 10px; font-size:12px; font-family:Gulim; color:#393939; line-height:19px;">';


$temp_bottom = '</td>
													</tr>
												
												</thead>
												</table>
											</td>
										</tr>					
									</tbody>
								</table>
										
							</td>
						</tr>
						
					</tbody>
				</table>
			</td></tr><tr><td style="padding:24px 34px; font-family:Gulim; font-size:12px; line-height:18px; background-color:#cacdd4;  color:#fff;">
				  <p>
					Tel : <strong>'.$def['de_admin_company_tel'].'</strong> | Fax : '.$def['de_admin_company_fax'].'<br>
					'.$def['de_admin_company_zip'].' '.$def['de_admin_company_addr'].'<br>
					대표이사 : '.$def['de_admin_company_owner'].' | 정보보호책임자 : '.$def['de_admin_info_name'].' | 사업자 등록번호 ['.$def['de_admin_company_saupja_no'].'] <br> 통신판매업 신고 : '.$def['de_admin_tongsin_no'].'
			   </p>
			   <p>Copyright(c) '.$def['de_admin_company_name'].' all rights reserved. <a href="'.$def['de_admin_domain'].'" target="_blank" style="color:#fff; text-decoration:none;" rel="noreferrer noopener">'.$def['de_admin_domain'].'</a></p>
				</td></tr></tbody>
				</table>';


$temp_bottom1 = '<br><br>해당 메일은 발신 전용으로 회신이 불가합니다</td>
													</tr>
												
												</thead>
												</table>
											</td>
										</tr>					
									</tbody>
								</table>
										
							</td>
						</tr>
						
					</tbody>
				</table>
			</td></tr><tr><td style="padding:24px 34px; font-family:Gulim; font-size:12px; line-height:18px; background-color:#cacdd4;  color:#fff;">
				  <p>
					Tel : <strong>'.$def['de_admin_company_tel'].'</strong> | Fax : '.$def['de_admin_company_fax'].'<br>
					'.$def['de_admin_company_zip'].' '.$def['de_admin_company_addr'].'<br>
					대표이사 : '.$def['de_admin_company_owner'].' | 정보보호책임자 : '.$def['de_admin_info_name'].' | 사업자 등록번호 ['.$def['de_admin_company_saupja_no'].'] <br> 통신판매업 신고 : '.$def['de_admin_tongsin_no'].'
			   </p>
			   <p>Copyright(c) '.$def['de_admin_company_name'].' all rights reserved. <a href="'.$def['de_admin_domain'].'" target="_blank" style="color:#fff; text-decoration:none;" rel="noreferrer noopener">'.$def['de_admin_domain'].'</a></p>
				</td></tr></tbody>
				</table>';
/**************** 문자전송하기 예제 필독항목 ******************/
//동일내용의 문자내용을 다수에게 동시 전송하실 수 있습니다
//대량전송시에는 반드시 컴마분기하여 1천건씩 설정 후 이용하시기 바랍니다. (1건씩 반복하여 전송하시면 초당 10~20건정도 발송되며 컨텍팅이 지연될 수 있습니다.)
//전화번호별 내용이 각각 다른 문자를 다수에게 보내실 경우에는 send 가 아닌 send_mass(예제:curl_send_mass.html)를 이용하시기 바랍니다.

function aligo_sms_call($msg, $receiver, $sender, $sms_type='', $subject='', $gubun=''){

	$sms_url = "https://apis.aligo.in/send/"; //url
	$sms['user_id'] = "kaviar"; // SMS 아이디
	$sms['key'] = "0dcqsrnoz62dc2w9vdczwryqh5imgp7a"; //인증키

	/****************** 전송정보 설정시작 ****************/
	$_POST['msg'] =$msg; // 메세지 내용 : euc-kr로 치환이 가능한 문자열만 사용하실 수 있습니다. (이모지 사용불가능)
	$_POST['receiver'] = $receiver; // 수신번호
	$_POST['destination'] =''; // 수신인 %고객명% 치환'
	$_POST['sender'] = $sender; // 발신번호
	$_POST['rdate'] = ''; // 예약일자 - 20161004 : 2016-10-04일기준
	$_POST['rtime'] = ''; // 예약시간 - 1930 : 오후 7시30분
	$_POST['testmode_yn'] = 'N'; // Y 인경우 실제문자 전송X , 자동취소(환불) 처리
	$_POST['subject'] = $subject; //  LMS, MMS 제목 (미입력시 본문중 44Byte 또는 엔터 구분자 첫라인)
	// $_POST['image'] = '/tmp/pic_57f358af08cf7_sms_.jpg'; // MMS 이미지 파일 위치 (저장된 경로)
	$_POST['msg_type'] = $sms_type; //  SMS, LMS, MMS등 메세지 타입을 지정

	// ※ msg_type 미지정시 글자수/그림유무가 판단되어 자동변환됩니다. 단, 개행문자/특수문자등이 2Byte로 처리되어 SMS 가 LMS로 처리될 가능성이 존재하므로 반드시 msg_type을 지정하여 사용하시기 바랍니다.
	/****************** 전송정보 설정끝 ***************/
	$sms['msg'] = stripslashes($_POST['msg']);
	$sms['receiver'] = $_POST['receiver'];
	$sms['destination'] = $_POST['destination'];
	$sms['sender'] = $_POST['sender'];
	$sms['rdate'] = $_POST['rdate'];
	$sms['rtime'] = $_POST['rtime'];
	$sms['testmode_yn'] = empty($_POST['testmode_yn']) ? '' : $_POST['testmode_yn'];
	$sms['title'] = $_POST['subject'];
	$sms['msg_type'] = $_POST['msg_type'];
	// 만일 $_FILES 로 직접 Request POST된 파일을 사용하시는 경우 move_uploaded_file 로 저장 후 저장된 경로를 사용하셔야 합니다.
	if(!empty($_FILES['image']['tmp_name'])) {
		$tmp_filetype = mime_content_type($_FILES['image']['tmp_name']); 
		if($tmp_filetype != 'image/png' && $tmp_filetype != 'image/jpg' && $tmp_filetype != 'image/jpeg') $_POST['image'] = '';
		else {
			$_savePath = "./".uniqid(); // PHP의 권한이 허용된 디렉토리를 지정
			if(move_uploaded_file($_FILES['file']['tmp_name'], $_savePath)) {
				$_POST['image'] = $_savePath;
			}
		}
	}
	// 이미지 전송 설정
	if(!empty($_POST['image'])) {
		if(file_exists($_POST['image'])) {
			$tmpFile = explode('/',$_POST['image']);
			$str_filename = $tmpFile[sizeof($tmpFile)-1];
			$tmp_filetype = mime_content_type($_POST['image']);
			if ((version_compare(PHP_VERSION, '5.5') >= 0)) { // PHP 5.5버전 이상부터 적용
				$sms['image'] = new CURLFile($_POST['image'], $tmp_filetype, $str_filename);
				curl_setopt($oCurl, CURLOPT_SAFE_UPLOAD, true);
			} else {
				$sms['image'] = '@'.$_POST['image'].';filename='.$str_filename. ';type='.$tmp_filetype;
			}
		}
	}
	/*****/
	$host_info = explode("/", $sms_url);
	$port = $host_info[0] == 'https:' ? 443 : 80;

	$oCurl = curl_init();
	curl_setopt($oCurl, CURLOPT_PORT, $port);
	curl_setopt($oCurl, CURLOPT_URL, $sms_url);
	curl_setopt($oCurl, CURLOPT_POST, 1);
	curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($oCurl, CURLOPT_POSTFIELDS, $sms);
	curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);


	$ret = curl_exec($oCurl);
	curl_close($oCurl);
	//print_r($ret);
	$retArr = json_decode($ret); // 결과배열
	//print_r($retArr); // Response 출력 (연동작업시 확인용)
	$msg_id = $retArr->{'msg_id'}; 
	$result_code = $retArr->{'result_code'}; 
	//echo $msg_id."/".$result_code;
	return $msg_id."/".$result_code;
}



function naver_sms_call($msg, $receiver, $sender, $sms_type, $subject='', $gubun=''){
	
	
	$postData = array(
        'type'          => $sms_type,
        'from'          => $sender,
        'subject'       => $subject,
        'content'       => $msg,
        'messages'      => array(array('to' => str_replace('-', '', $receiver)))
    );

	$postData = json_encode($postData);

    $serviceID          = 'ncp:sms:kr:271573154073:shop002';
    $apiURL             = 'https://sens.apigw.ntruss.com/sms/v2/services/'.$serviceID.'/messages';
    $apiURI             = '/sms/v2/services/'.$serviceID.'/messages';

    $accessKeyID        = 'c4OOubZ58FUosGqroHvD';
    $accessSecretKey    = 'EoBjr4oQRLHFtzjhnXCzXn5xhdaQTgV7ULiNlTT3';

    $timestamp          = floor(microtime(true)  * 1000);
    $message            = "POST {$apiURI}\n{$timestamp}\n{$accessKeyID}";   //", {} 등의 사용에 유의할 것
    $signature          = base64_encode(hash_hmac('sha256', $message, $accessSecretKey, true));

    $postHeader = array(
        'Content-Type: application/json; charset=utf-8',
        'x-ncp-apigw-timestamp: '.$timestamp,
        'x-ncp-iam-access-key: '.$accessKeyID,
        'x-ncp-apigw-signature-v2: '.$signature
    );

    $ch = curl_init($apiURL);

    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    $decodedResponse = json_decode($response, true);
    $statuCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

   /*
    echo $statuCode.'<br /><br />';
    echo '<pre>';
    print_r($decodedResponse);
    echo '</pre>';
    exit;
    */

}


function user_email_call($type, $to_email, $mb_id, $mb_name, $company_name, $content=""){
	
	global $senderAddress, $default, $temp_top, $temp_bottom;


	if($type == "가입완료"){

		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_1.jpg";

		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 가입을 환영합니다.',
			'body'          => '<pre>'.$content.'</pre>',
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}

	$postData = json_encode($postData);

	$apiURL             = 'https://mail.apigw.ntruss.com/api/v1/mails';
	$apiURI             = '/api/v1/mails';

	$accessKeyID        = 'c4OOubZ58FUosGqroHvD';
	$accessSecretKey    = 'EoBjr4oQRLHFtzjhnXCzXn5xhdaQTgV7ULiNlTT3';

	$timestamp          = floor(microtime(true)  * 1000);
	$message            = "POST {$apiURI}\n{$timestamp}\n{$accessKeyID}";   //", {} 등의 사용에 유의할 것
	$signature          = base64_encode(hash_hmac('sha256', $message, $accessSecretKey, true));

	$postHeader = array(
		'Content-Type: application/json',
		'x-ncp-apigw-timestamp: '.$timestamp,
		'x-ncp-iam-access-key: '.$accessKeyID,
		'x-ncp-apigw-signature-v2: '.$signature
	);

	$ch = curl_init($apiURL);

	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	$response = curl_exec($ch);
	$decodedResponse = json_decode($response, true);
	$statuCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	
}



function order_email_call($type, $to_email, $mb_id, $od_id, $od_name, $od_time, $company_name, $bank_account, $content=""){
	
	global $senderAddress, $default, $temp_top, $temp_bottom, $def;

	$ods = sql_fetch(" select * from `g5_shop_order` where od_id = '$od_id' ");
	//$def = sql_fetch(" select * from `g5_shop_default` where (1) ");
	$od_settle  = $ods['od_settle_case'];
	$od_tot		= $ods['od_cart_price'] + $ods['od_send_cost'];

	$sql = " select * from `g5_shop_cart` where od_id = '$od_id' ";
    $od_cart = sql_query($sql);
	$product = "";

	for ($i=0; $row=sql_fetch_array($od_cart); $i++){
		
		if($row['io_type'] == 0){
			$price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty'];
			$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']." / ".number_format($price)." 원<br>";
		}else{
			$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']." / ".number_format($row['io_price'] * $row['ct_qty'])." 원<br>";
		}
	}

	if($ods['od_send_cost'] > 0){
		$product .= "<br>추가배송비 : ".number_format($ods['od_send_cost'])." 원";
	}
	

	if($type == "입금완료"){

		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_4.jpg";

		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 입금처리 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "환불취소완료"){

		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_4.jpg";

		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 환불/취소 처리 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "반품완료"){

		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_4.jpg";

		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 반품 처리 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "무통장완료") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 무통장 주문 완료',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "결제완료") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 결제 주문 완료',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "배송중") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 상품 발송 처리 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "배송완료") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 배송완료 처리 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "입금요청") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 무통장 입금 요청 드립니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "무통장자동취소") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		
		$postData = array(
			'senderName'    => '['.$company_name.']',
			'senderAddress' => $senderAddress,
			'title'         => '['.$company_name.'] 무통장입금 자동 취소 되었습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}

	$postData = json_encode($postData);

	$apiURL             = 'https://mail.apigw.ntruss.com/api/v1/mails';
	$apiURI             = '/api/v1/mails';

	$accessKeyID        = 'c4OOubZ58FUosGqroHvD';
	$accessSecretKey    = 'EoBjr4oQRLHFtzjhnXCzXn5xhdaQTgV7ULiNlTT3';

	$timestamp          = floor(microtime(true)  * 1000);
	$message            = "POST {$apiURI}\n{$timestamp}\n{$accessKeyID}";   //", {} 등의 사용에 유의할 것
	$signature          = base64_encode(hash_hmac('sha256', $message, $accessSecretKey, true));

	$postHeader = array(
		'Content-Type: application/json',
		'x-ncp-apigw-timestamp: '.$timestamp,
		'x-ncp-iam-access-key: '.$accessKeyID,
		'x-ncp-apigw-signature-v2: '.$signature
	);

	$ch = curl_init($apiURL);

	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	$response = curl_exec($ch);
	$decodedResponse = json_decode($response, true);
	$statuCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);

	
}




function pass_email_call($mb_name, $mb_id, $hrref, $change_password, $to_email, $company_name, $content){
	
	global $senderAddress, $default, $temp_top, $temp_bottom, $def;

	//echo $mb_name." / ".$mb_id." / ".$links." / ".$to_email." / ".$change_password." / ".$company_name;

	//$def = sql_fetch(" select * from `g5_shop_default` where (1) ");
	
	$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_9.jpg";

	$postData = array(
		'senderName'    => '['.$company_name.']',
		'senderAddress' => $senderAddress,
		'title'         => '['.$company_name.'] 임시 비밀번호 발급 안내',
		'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
		'recipients'    => array(array('type' => 'R', 'address' => $to_email))
	);
	
	$postData = json_encode($postData);

	$apiURL             = 'https://mail.apigw.ntruss.com/api/v1/mails';
	$apiURI             = '/api/v1/mails';

	$accessKeyID        = 'c4OOubZ58FUosGqroHvD';
	$accessSecretKey    = 'EoBjr4oQRLHFtzjhnXCzXn5xhdaQTgV7ULiNlTT3';

	$timestamp          = floor(microtime(true)  * 1000);
	$message            = "POST {$apiURI}\n{$timestamp}\n{$accessKeyID}";   //", {} 등의 사용에 유의할 것
	$signature          = base64_encode(hash_hmac('sha256', $message, $accessSecretKey, true));

	$postHeader = array(
		'Content-Type: application/json',
		'x-ncp-apigw-timestamp: '.$timestamp,
		'x-ncp-iam-access-key: '.$accessKeyID,
		'x-ncp-apigw-signature-v2: '.$signature
	);

	$ch = curl_init($apiURL);

	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	$response = curl_exec($ch);
	$decodedResponse = json_decode($response, true);
	$statuCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);
}













function qna_email_call($type, $to_email, $mb_name, $company_name, $return_order, $od_id, $return_type, $return_price, $return_memo, $content=""){
	
	global $senderAddress, $default, $temp_top, $temp_bottom, $temp_bottom1, $def;

	//$def = sql_fetch(" select * from `g5_shop_default` where (1) ");
	
	if($type == "반품교환환불"){
		
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '['.$return_order.'] 문의가 들어왔습니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "후기작성"){
		
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '[후기가 작성되었습니다]',
			'body'          => '후기가 작성되었습니다',
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "후기승인"){
		
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '[후기 승인처리 되었습니다.]',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

	}else if($type == "문의작성"){
		
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '[고객문의가 작성되었습니다]',
			'body'          => '고객문의가 작성되었습니다.',
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);
	}else if($type == "문의답변"){
		
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '[고객문의에 대한 답변이 작성되었습니다]',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom1,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);
	}else if($type == "일대일문의답변") {
		
		$top_img = "http://m-img.cafe24.com/images/template/admin/kr/img_visual_customer_3.jpg";
		$content = str_replace('\"', '"', $content);
		$postData = array(
			'senderName'    => '[캐비아]',
			'senderAddress' => $senderAddress,
			'title'         => '[캐비아] 1:1 문의 답변입니다.',
			'body'          => $temp_top.'<pre>'.$content.'</pre>'.$temp_bottom1,
			'recipients'    => array(array('type' => 'R', 'address' => $to_email))
		);

        include_once(G5_LIB_PATH.'/mailer.lib.php');
        

	}
	
    @mailer($postData['senderName'], $postData['senderAddress'], $to_email, $postData['title'], $postData['body'], 1);

/*
	
	$postData = json_encode($postData);

	$apiURL             = 'https://mail.apigw.ntruss.com/api/v1/mails';
	$apiURI             = '/api/v1/mails';

	$accessKeyID        = 'c4OOubZ58FUosGqroHvD';
	$accessSecretKey    = 'EoBjr4oQRLHFtzjhnXCzXn5xhdaQTgV7ULiNlTT3';

	$timestamp          = floor(microtime(true)  * 1000);
	$message            = "POST {$apiURI}\n{$timestamp}\n{$accessKeyID}";   //", {} 등의 사용에 유의할 것
	$signature          = base64_encode(hash_hmac('sha256', $message, $accessSecretKey, true));

	$postHeader = array(
		'Content-Type: application/json',
		'x-ncp-apigw-timestamp: '.$timestamp,
		'x-ncp-iam-access-key: '.$accessKeyID,
		'x-ncp-apigw-signature-v2: '.$signature
	);

	$ch = curl_init($apiURL);

	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $postHeader);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	$response = curl_exec($ch);
	$decodedResponse = json_decode($response, true);
	$statuCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	curl_close($ch);
*/   

}




/*<table align="center" width="700" border="0" cellpadding="0" cellspacing="0" style=" border:1px solid #bbc0c4;">
	<tbody>
		<tr>
			<td style="padding:24px 14px 0;">
				<table width="670" border="0" cellpadding="0" cellspacing="0">
					<tbody>
	
						<tr>
							<td>
											
								<table width="670" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-family:Gulim; color:#393939; line-height:19px;">
									<tbody>
	
										<tr>
											<td>
												<table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin:0 0 20px;">
													<tbody><tr><td valign="middle" width="19"><img src="http://m-img.cafe24.com/images/template/admin/kr/ico_title.gif" alt="" loading="lazy"></td><td valign="middle"><strong style=" font-size:13px; font-family:Gulim; color:#1c1c1c;">반품 문의가 들어왔습니다.</strong></td></tr>
													</tbody>
												</table>
														
												<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:12px; font-family:Gulim; line-height:15px;  border-top:1px solid #d5d5d5;">
												<thead>
													<tr>
														<th colspan="1" rowspan="1" scope="col" width="33%" style="padding:13px 10px 10px; font-weight:normal; background-color:#f5f6f5;  border-bottom:1px solid #d5d5d5; border-right:1px solid #d5d5d5; border-left:1px solid #d5d5d5; color:#80878d;">임시비밀번호
														</th>
														<td colspan="1" rowspan="1" scope="col" width="33%" style="padding:13px 10px 10px; text-align:center;font-weight:normal; border-bottom:1px solid #d5d5d5; border-right:1px solid #d5d5d5; color:#80878d;">'.$change_password.'
														</td>
														<td colspan="1" rowspan="1" scope="col" width="33%" style="padding:13px 10px 10px; text-align:center;font-weight:normal; border-bottom:1px solid #d5d5d5; border-right:1px solid #d5d5d5; color:#80878d;"><a href="'.$hrref.'" target="_blank" style="display:block;padding:30px 0;background:#484848;color:#fff;text-decoration:none;text-align:center">비밀번호 변경</a>
														</td>
													</tr>
												</thead>
												</table>
											</td>
										</tr>					
									</tbody>
								</table>
										
							</td>
						</tr>
						<tr>
							<td style="padding:30px 0 60px 10px; font-size:12px; font-family:Gulim; color:#393939; line-height:19px;">
							<p style="margin-top:13px;">다시 한번 저희 쇼핑몰을 이용해주신 <strong>'.$mb_name.'('.$mb_id.')</strong> 고객님께 진심으로 감사드립니다.</p>
							</td>
						</tr>
					</tbody>
				</table>
			</td></tr><tr><td style="padding:24px 34px; font-family:Gulim; font-size:12px; line-height:18px; background-color:#cacdd4;  color:#fff;">
				  <p>
					Tel : <strong>'.$def['de_admin_company_tel'].'</strong> | Fax : '.$def['de_admin_company_fax'].'<br>
					'.$def['de_admin_company_zip'].' '.$def['de_admin_company_addr'].'<br>
					대표이사 : '.$def['de_admin_company_owner'].' | 정보보호책임자 : '.$def['de_admin_info_name'].' | 사업자 등록번호 ['.$def['de_admin_company_saupja_no'].'] <br> 통신판매업 신고 : '.$def['de_admin_tongsin_no'].'
			   </p>
			   <p>Copyright(c) '.$def['de_admin_company_name'].' all rights reserved. <a href="'.$def['de_admin_domain'].'" target="_blank" style="color:#fff; text-decoration:none;" rel="noreferrer noopener">'.$def['de_admin_domain'].'</a></p>
				</td></tr></tbody>
				</table>
*/
?>
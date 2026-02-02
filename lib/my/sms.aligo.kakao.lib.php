<?php
	$apikey = "0dcqsrnoz62dc2w9vdczwryqh5imgp7a";
	$userid = "kaviar";
	$senderkey = "27237e4d785a10ffbf63b17acc67152d06141062";
	$sender = "01048285646";

	function kakao_token(){

		global $apikey, $userid, $senderkey, $sender;

		$_apiURL	  =	'https://kakaoapi.aligo.in/akv10/token/create/30/s/';
		$_hostInfo	=	parse_url($_apiURL);
		$_port		  =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
		$_variables	=	array(
		'apikey' => $apikey,
		'userid' => $userid
		);

		$oCurl = curl_init();
		curl_setopt($oCurl, CURLOPT_PORT, $_port);
		curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
		curl_setopt($oCurl, CURLOPT_POST, 1);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

		$ret = curl_exec($oCurl);
		$error_msg = curl_error($oCurl);
		curl_close($oCurl);

		// 리턴 JSON 문자열 확인
		//print_r($ret . PHP_EOL);

		// JSON 문자열 배열 변환
		$retArr = json_decode($ret);

		// 결과값 출력
		//print_r($retArr);
		$token = $retArr->token;
		return $token;
	}



	function kakao_alim($tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""){

		global $apikey, $userid, $senderkey, $sender;
		/* 
		-----------------------------------------------------------------------------------
		알림톡 전송
		-----------------------------------------------------------------------------------
		버튼의 경우 템플릿에 버튼이 있을때만 버튼 파라메더를 입력하셔야 합니다.
		버튼이 없는 템플릿인 경우 버튼 파라메더를 제외하시기 바랍니다.
		*/
		$token = kakao_token();
		

		if($tpl_code == "TS_0375"){ //회원가입/

			$content = "[캐비아몰] '당신을 위한 미식선물
[캐비아몰] 
 
안녕하세요 #{이름} 고객님 
ID : #{회원아이디}

미식 큐레이션 플랫폼 캐비아몰의 회원이 되신 것을 환영합니다.

캐비아몰은 미슐랭 레스토랑부터 40년 전통의 노포까지 여러분이 경험하지 못했던, 혹은 경험하고 싶었던 다양한 셰프,
레스토랑의 음식을 일상 곳곳에서 즐기실 수 있도록 ‘큐레이션’ 하고 있습니다.

캐비아몰은 이제 곧 시작될 
고객님과 함께 할 행복한 미식 여정을 기대 합니다. 

캐비아와 함께 항상 
놀라운 미식 생활하세요~

★미식 큐레이션 플랫폼 캐비아★";

			$subject_1 = "회원가입";

		}else if($tpl_code == "TS_0376"){ //무통장입금정보/

			$content = "[#{회사명}]
[#{이름}]님의 무통장 주문

- 주문번호 : #{주문번호}
- 금액 : #{주문금액}원
- 계좌정보 : #{계좌정보}

주문이 완료 되었습니다.
주문일로부터 3일내 입금확인이 되지 않을 시 주문은 자동취소됩니다.

주문자와 입금자명이 다를 경우 입금확인이 지연될 수 있으니 고객센터 02-6670-3672 또는 1:1 게시판을 통해 요청사항을 남겨주시면 감사하겠습니다.";

			$subject_1 = "무통장입금 정보";

		}else if($tpl_code == "TS_0377"){ //주문완료/

			$content = "[캐비아몰] '당신을 위한 미식선물
[캐비아몰]
[#{이름}]님의 주문
 
-주문번호: #{주문번호}
-금액: #{주문금액}원 

주문이 완료 되었습니다.

캐비아몰은 오늘도 고객님의 
놀라운 미식 생활을 위해 
더욱 노력하겠습니다. 

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

캐비아몰을 이용해 주셔서 감사합니다.

★미식큐레이션플랫폼 캐비아★";

			$subject_1 = "주문완료";

		}else if($tpl_code == "TS_0378"){ //환불완료/

			$content = "[캐비아몰] 당신을 위한 미식선물
#{이름}님의 환불 처리가 완료되었습니다.

주문번호 : #{주문번호}
환불금액 : #{주문금액}

결제수단에 따라 1~4일 영업일 이내
환불금액을 확인하실 수 있습니다.

관련 문의사항은 고객센터 02-6670-3672 또는 1:1 게시판을 통해 남겨주시면 확인 후 연락드리겠습니다.

캐비아몰을 이용해 주셔서 감사합니다.

★미식큐레이션플랫폼 캐비아★";

			$subject_1 = "환불완료";

		}else if($tpl_code == "TS_0379"){ //반품완료/

			$content = "[캐비아몰]
#{이름}님의 반품 처리가 완료되었습니다.

주문번호 : #{주문번호}
상품명 : #{주문상품}
환불금액 : #{주문금액}

결제수단에 따라 1~4일 영업일 이내 환불금액을 확인하실 수 있습니다.

관련 문의사항은 고객센터 02-6670-3672 또는 1:1 게시판을 통해 남겨주시면 확인 후 연락드리겠습니다.
캐비아몰을 이용해 주셔서 감사합니다.";

			$subject_1 = "반품완료";

		}else if($tpl_code == "TS_0380"){ //입금완료/

			$content = "[캐비아몰]
[#{이름}] 고객님 감사합니다. 

- 주문번호 : #{주문번호}
- 금액 : #{주문금액}원

입금이 확인 되었습니다.
입력하신 배송지로 주문하신 미식을 빠르게 배송하여 드리겠습니다.

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

감사합니다.";

			$subject_1 = "입금완료";

		}else if($tpl_code == "TS_0381"){ //상품발송/

			$content = "[캐비아몰] 

당신을 위한 미식선물 캐비아에서
#{이름} 고객님을 위한 상품이 발송되었습니다.

- #{배송사} : [ #{송장번호} ]
- 배송조회는 아래 링크로 이동하여 송장번호를 입력해주세요.

https://www.doortodoor.co.kr/parcel/pa_004.jsp

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

캐비아몰을 이용해주셔서 감사합니다.

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "상품발송";

		}else if($tpl_code == "TS_0383"){ //상품문의 답변등록/

			$content = "안녕하세요,
당신을 위한 미식선물 캐비아입니다.

#{이름}님의 질문의 답변이 등록되었습니다. 

1:1문의 바로가기
https://kaviar.testlink.or.kr/bbs/board.php?bo_table=11_inquiry

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "상품문의 답변등록";

		}else if($tpl_code == "TS_0384"){ //후기등록 승인/

			$content = "안녕하세요,
당신을 위한 미식선물 캐비아입니다.

#{이름}님, 정성을 담은 후기를 작성해주셔서 감사합니다. 

더 많은 분들의 미식 큐레이션에 도움을 주심에 감사드립니다.

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "후기등록 승인";

		}else if($tpl_code == "TS_0385"){ //배송완료/

			$content = "[캐비아몰] 당신을 위한 미식선물
[#{이름}]님의 상품의 배송이 완료되었습니다

-주문번호 : #{주문번호}

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

캐비아몰을 이용해주셔서 감사합니다.

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "배송완료";

		}else if($tpl_code == "TS_0386"){ //무통장 입금 요청/

			$content = "[캐비아몰]
#{이름}님 안녕하세요.
고객님의 무통장 입금주문이
아직 확인되지 않았습니다.

-주문번호 : #{주문번호}
-금액 : #{주문금액}원

주문일로부터 3일내 입금확인이 되지 않을 시 주문은 자동취소됩니다.

주문자와 입금자명이 다를 경우 입금확인이 지연될 수 있으니 고객센터 02-6670-3672 또는 1:1 게시판을 통해 요청사항을 남겨주시면 감사하겠습니다.

캐비아몰을 이용해 주셔서 감사합니다.

★미식큐레이션플랫폼 캐비아★";

			$subject_1 = "무통장 입금 요청";

		}else if($tpl_code == "TS_0387"){ //무통장입금 자동취소

			$content = "[캐비아몰] 당신을 위한 미식선물
[캐비아몰]
#{이름}님 #{주문번호} 주문이 무통장 입금기한 3일이 만료되어 자동취소되었습니다.

관련 문의사항은 고객센터 02-6670-3672 또는 1:1 게시판을 통해 남겨주시면 확인 후 연락드리겠습니다.

캐비아몰을 이용해 주셔서 감사합니다.

★미식큐레이션플랫폼 캐비아★";

			$subject_1 = "무통장입금 자동취소";

		}else if($tpl_code == "TS_4881"){ //상품발송/

			$content = "[캐비아몰] 

당신을 위한 미식선물 캐비아에서
#{이름} 고객님을 위한 상품이 발송되었습니다.

#{배송사}
-#{배송정보}

배송조회는 아래 링크로 이동하여 송장번호를 입력해주세요.

배송조회 링크: https://www.doortodoor.co.kr/parcel/pa_004.jsp

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

캐비아몰을 이용해주셔서 감사합니다.

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "상품발송";

		}else if($tpl_code == "TU_2148"){ //상품발송/

			$content = "[캐비아몰] 

당신을 위한 미식선물 캐비아에서
#{이름} 고객님을 위한 상품이 발송되었습니다.

#{배송사}
-#{배송정보}

배송조회는 아래 링크로 이동하여 송장번호를 입력해주세요.

배송조회 링크: https://www.lotteglogis.com/mobile/reservation/tracking/index

모든 문의사항은 
고객센터 02-6670-3672 또는 1:1 게시판을 이용하여주세요. 

캐비아몰을 이용해주셔서 감사합니다.

★당신을 위한 미식선물 KAVIAR★";

			$subject_1 = "상품발송";

		}


		

		
		$content = str_replace("#{회사명}", "캐비아몰", $content);
		$content = str_replace("#{이름}", $name, $content);
		$content = str_replace("#{주문번호}", $od_id, $content);
		$content = str_replace("#{주문금액}", number_format($od_price), $content);
		$content = str_replace("#{회원아이디}", $md_id, $content);
		$content = str_replace("#{계좌정보}", $account, $content);
		$content = str_replace("#{배송사}", $company, $content);
		$content = str_replace("#{송장번호}", $invoice, $content);
		$content = str_replace("#{배송정보}", $invoice, $content);
		$content = str_replace("#{주문상품}", $product, $content);


		$_apiURL    =	'https://kakaoapi.aligo.in/akv10/alimtalk/send/';
		$_hostInfo  =	parse_url($_apiURL);
		$_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
		$_variables =	array(
		'apikey'      => $apikey, 
		'userid'      => $userid, 
		'token'       => $token, 
		'senderkey'   => $senderkey, 
		'tpl_code'    => $tpl_code,
		'sender'      => $sender,
		'senddate'    => '',
		'receiver_1'  => $recevier,
		'recvname_1'  => '',
		'subject_1'   => $subject_1,
		'message_1'   => $content,
		'button_1'    => '' // 템플릿에 버튼이 없는경우 제거하시기 바랍니다.
		);

		$oCurl = curl_init();
		curl_setopt($oCurl, CURLOPT_PORT, $_port);
		curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
		curl_setopt($oCurl, CURLOPT_POST, 1);
		curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
		curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

		$ret = curl_exec($oCurl);
		$error_msg = curl_error($oCurl);
		curl_close($oCurl);

		// 리턴 JSON 문자열 확인
		//print_r($ret . PHP_EOL);

		// JSON 문자열 배열 변환
		$retArr = json_decode($ret,true);

		// 결과값 출력
		//print_r($retArr);
		
		//return $retArr;

		//echo "<br><br>".$retArr['code'];
		if($retArr['code'] == 0){
			return "Y";
		}else{
			return "N";
		}
//		return $retArr['code'];
/*
		echo(json_encode(
		array(
			"code"			=> $retArr['code']
			)
		));*/
		/*
		code : 0 성공, 나머지 숫자는 에러
		message : 결과 메시지
		*/

	}
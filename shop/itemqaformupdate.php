<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if (!$is_member) {
    alert_close("상품문의는 회원만 작성이 가능합니다.");
}

$it_id       = isset($_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';
$iq_id = isset($_REQUEST['iq_id']) ? (int) $_REQUEST['iq_id'] : 0;
$iq_subject = isset($_POST['iq_subject']) ? trim($_POST['iq_subject']) : '';
$iq_question = isset($_POST['iq_question']) ? trim($_POST['iq_question']) : '';
$iq_question = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $iq_question);
$iq_answer = isset($_POST['iq_answer']) ? trim($_POST['iq_answer']) : '';
$hash = isset($_REQUEST['hash']) ? trim($_REQUEST['hash']) : '';
$get_editor_img_mode = $config['cf_editor'] ? false : true;

$iq_secret = isset($_POST['iq_secret']) ? (int) $_POST['iq_secret'] : 0;
$iq_email = isset($_POST['iq_email']) ? clean_xss_tags($_POST['iq_email'], 1, 1) : '';
$iq_hp = isset($_POST['iq_hp']) ? clean_xss_tags($_POST['iq_hp'], 1, 1) : '';
$is_mobile_shop = isset($_REQUEST['is_mobile_shop']) ? (int) $_REQUEST['is_mobile_shop'] : 0;

if ($w == "" || $w == "u") {
    $iq_name     = addslashes(strip_tags($member['mb_name']));
    $iq_password = $member['mb_password'];

    if (!$iq_subject) alert("제목을 입력하여 주십시오.");
    if (!$iq_question) alert("질문을 입력하여 주십시오.");
}

if($is_mobile_shop)
    $url = './iteminfo.php?it_id='.$it_id.'&info=qa';
else
    $url = shop_item_url($it_id, "_=".get_token()."#sit_qa");

if ($w == "")
{
    $sql = "insert {$g5['g5_shop_item_qa_table']}
               set it_id = '$it_id',
                   mb_id = '{$member['mb_id']}',
                   iq_secret = '$iq_secret',
                   iq_name  = '$iq_name',
                   iq_email = '$iq_email',
                   iq_hp = '$iq_hp',
                   iq_password  = '$iq_password',
                   iq_subject  = '$iq_subject',
                   iq_question = '$iq_question',
                   iq_time = '".G5_TIME_YMDHIS."',
                   iq_ip = '".$_SERVER['REMOTE_ADDR']."' ";
    sql_query($sql);
	
	$iq_id = sql_insert_id();

    $alert_msg = '상품문의가 등록 되었습니다.';

	if($config['cf_manager_hp_qna']){

		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
		$receive_number = preg_replace("/[^0-9]/", "", $config['cf_manager_hp_qna']);   // 수신자번호(받는사람)

		//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
		aligo_sms_call("사용자 문의가 등록되었습니다.", $receive_number, $send_number, "", "", "");

	}

	if($config['cf_manager_email_qna']){
		
	
		qna_email_call('문의작성', $config['cf_manager_email_qna'], $member['mb_id'], $default['de_admin_company_name'], "", "", "", "", "");
		//order_email_call('입금완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account']);

	}
	
	
	for($i=1; $i<=5; $i++) {
		$img_file = "iq_img".$i;

		// 새 파일 업로드시
		if ($_FILES[$img_file]['name']) {
			// 파일 정보
			$fileName = $_FILES[$img_file]['name'];
			$fileSize = $_FILES[$img_file]['size'];
			$fileTemp = $_FILES[$img_file]['tmp_name'];
			$fileName = $_FILES[$img_file]['name'];
			$extension = explode('.', $fileName);
			$extension = end($extension);
			
			
			// 파일 검사
			if (!preg_match("/(\.jpg|\.jpeg|\.gif|\.png|\.mp4)$/i", $fileName)) {
				alert("JPG, JPEG, GIF, PNG, MP4 파일만 업로드 가능합니다.");
			}
			if($extension == "mp4"){
				
				// 용량 제한 (예: 30MB)
				if ($fileSize > 30097152) {
					alert("파일 용량은 30MB 이하만 가능합니다.");
				}

				// 파일명 변경 (중복 방지)
				$newFileName = date("YmdHis")."_".mt_rand()."_".$i.".".pathinfo($fileName, PATHINFO_EXTENSION);
				$uploadDir = G5_DATA_PATH.'/shop_qa/';
				$uploadFile = $uploadDir.$newFileName;

				// 디렉토리 확인
				if (!is_dir($uploadDir)) {
					@mkdir($uploadDir, G5_DIR_PERMISSION);
					@chmod($uploadDir, G5_DIR_PERMISSION);
				}
				
				// 파일 업로드
				if (move_uploaded_file($fileTemp, $uploadFile)) {
					
					// DB에 파일명 저장 (예시)
					$sqls = " update `g5_shop_item_qa`
								set iq_img{$i} = '$newFileName'
								where iq_id = '$iq_id' ";
					sql_query($sqls);

				}
				
				
			}else{
			
				// 용량 제한 (예: 2MB)
				if ($fileSize > 2097152) {
					alert("파일 용량은 2MB 이하만 가능합니다.");
				}

				// 파일명 변경 (중복 방지)
				$newFileName = date("YmdHis")."_".mt_rand()."_".$i.".".pathinfo($fileName, PATHINFO_EXTENSION);
				$uploadDir = G5_DATA_PATH.'/shop_qa/';
				$uploadFile = $uploadDir.$newFileName;

				// 디렉토리 확인
				if (!is_dir($uploadDir)) {
					@mkdir($uploadDir, G5_DIR_PERMISSION);
					@chmod($uploadDir, G5_DIR_PERMISSION);
				}
				
				// 파일 업로드
				if (move_uploaded_file($fileTemp, $uploadFile)) {
					// 이미지 리사이징
					$size = @getimagesize($uploadFile);
					if ($size[0] > $re_width) {
						$thumb = thumbnail($newFileName, $uploadDir, $uploadDir, $re_width, $re_width, true, true);
						if($thumb) {
							$newFileName = $thumb;
						}
					}

					// DB에 파일명 저장 (예시)
					$sqls = " update `g5_shop_item_qa`
								set iq_img{$i} = '$newFileName'
								where iq_id = '$iq_id' ";
					sql_query($sqls);

				}
				
			}

		}
	}
	
}else if ($w == "u")
{
    if (!$is_admin)
    {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_qa_table']} where mb_id = '{$member['mb_id']}' and iq_id = '$iq_id' ";
        $row = sql_fetch($sql);
        if (!$row['cnt'])
            alert("자신의 상품문의만 수정하실 수 있습니다.");
    }

    $sql = " update {$g5['g5_shop_item_qa_table']}
                set iq_secret = '$iq_secret',
                    iq_email = '$iq_email',
                    iq_hp = '$iq_hp',
                    iq_subject = '$iq_subject',
                    iq_question = '$iq_question'
              where iq_id = '$iq_id' ";
    sql_query($sql);
	
	for($i=1; $i<=5; $i++) {
		$img_del = "iq_img".$i."_del";
			
		$sql = " update {$g5['g5_shop_item_qa_table']}
					set iq_img{$i} = ''
				  where iq_id = '$iq_id' ";
		sql_query($sql);
	
		/*
		if (isset($_POST[$img_del]) && $_POST[$img_del]) {
			$prev_file = G5_DATA_PATH.'/shop_qa/'.$img_file; // 기존 파일 경로
			if (file_exists($prev_file)) {
				@unlink($prev_file);
			}
		}*/
	}

    $alert_msg = '상품문의가 수정 되었습니다.';
}
else if ($w == "d")
{
    if (!$is_admin)
    {
        $sql = " select iq_answer from {$g5['g5_shop_item_qa_table']} where mb_id = '{$member['mb_id']}' and iq_id = '$iq_id' ";
        $row = sql_fetch($sql);
        if (!$row)
            alert("자신의 상품문의만 삭제하실 수 있습니다.");

        if ($row['iq_answer'])
            alert("답변이 있는 상품문의는 삭제하실 수 없습니다.");
    }

    // 에디터로 첨부된 이미지 삭제
    $sql = " select iq_question, iq_answer from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' and md5(concat(iq_id,iq_time,iq_ip)) = '{$hash}' ";
    $row = sql_fetch($sql);

    $imgs = get_editor_image($row['iq_question'], $get_editor_img_mode);

    for($i=0;$i<count($imgs[1]);$i++) {
        $p = parse_url($imgs[1][$i]);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];

        if( preg_match('/(gif|jpe?g|bmp|png|webp)$/i', strtolower(end(explode('.', $data_path))) ) ){ // WebP 추가

            $destfile = ( ! preg_match('/\w+\/\.\.\//', $data_path) ) ? G5_PATH.$data_path : '';

            if($destfile && preg_match('/\/data\/editor\/[A-Za-z0-9_]{1,20}\//', $destfile) && is_file($destfile))
                @unlink($destfile);
        }
    }

    $imgs = get_editor_image($row['iq_answer'], $get_editor_img_mode);

    $imgs_count = (isset($imgs[1]) && is_array($imgs[1])) ? count($imgs[1]) : 0;

    for($i=0;$i<$imgs_count;$i++) {
        $p = parse_url($imgs[1][$i]);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];

        if( preg_match('/(gif|jpe?g|bmp|png|webp)$/i', strtolower(end(explode('.', $data_path))) ) ){ // WebP 추가

            $destfile = ( ! preg_match('/\w+\/\.\.\//', $data_path) ) ? G5_PATH.$data_path : '';

            if($destfile && preg_match('/\/data\/editor\/[A-Za-z0-9_]{1,20}\//', $destfile) && is_file($destfile))
                @unlink($destfile);
        }
    }

    $sql = " delete from {$g5['g5_shop_item_qa_table']} where iq_id = '$iq_id' and md5(concat(iq_id,iq_time,iq_ip)) = '{$hash}' ";
    sql_query($sql);

    $alert_msg = '상품문의가 삭제 되었습니다.';
}

if($w == 'd') {
    alert($alert_msg, $url);
} else {
	if(!G5_IS_MOBILE) {
		 alert_opener($alert_msg, $url);
	} else {
		alert($alert_msg, $url);
	}
   
}
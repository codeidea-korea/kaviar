<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if (!$is_member) {
    alert_close("사용후기는 회원만 작성이 가능합니다.");
}

$ct_id		 = isset($_POST['ct_id']) ? trim($_POST['ct_id']) : '';
$it_id       = isset($_REQUEST['it_id']) ? safe_replace_regex($_REQUEST['it_id'], 'it_id') : '';
$is_subject  = isset($_POST['is_subject']) ? trim($_POST['is_subject']) : '';
$is_content  = isset($_POST['is_content']) ? trim($_POST['is_content']) : '';
$is_content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $is_content);
$is_name     = isset($_POST['is_name']) ? trim($_POST['is_name']) : '';
$is_password = isset($_POST['is_password']) ? trim($_POST['is_password']) : '';
$is_score    = isset($_POST['is_score']) ? (int) $_POST['is_score'] : 0;
$is_score    = ($is_score > 5) ? 0 : $is_score;
$get_editor_img_mode = $config['cf_editor'] ? false : true;
$is_id       = isset($_REQUEST['is_id']) ? (int) $_REQUEST['is_id'] : 0;
$is_mobile_shop = isset($_REQUEST['is_mobile_shop']) ? (int) $_REQUEST['is_mobile_shop'] : 0;

// 사용후기 작성 설정에 따른 체크
check_itemuse_write($it_id, $member['mb_id']);

if ($w == "" || $w == "u") {
    $is_name     = addslashes(strip_tags($member['mb_name']));
    $is_password = $member['mb_password'];

    if (!$is_subject) alert("제목을 입력하여 주십시오.");
    if (!$is_content) alert("내용을 입력하여 주십시오.");
}



$mb_img_dir = G5_DATA_PATH.'/member_review/';
if( !is_dir($mb_img_dir) ){
	@mkdir($mb_img_dir, G5_DIR_PERMISSION);
	@chmod($mb_img_dir, G5_DIR_PERMISSION);
}
$image_regex = "/(\.(gif|jpe?g|png|webp|mp4))$/i";

// 회원 이미지 삭제
if (isset($del_mb_img) && $del_mb_img)
	@unlink($mb_img_dir.'/'.$mb_icon_img);

//이미지 업로드 됬는지 확인하기
$imgchk = 0;
$filelist;
for ($i=1; $i<=5; $i++)
{	
	$rechk = "re_img".$i;
	$filechk = explode(".",$_FILES[$rechk]['name']);
	$filenames = $filechk[0]."_".date('mdis').".".$filechk[1];
	if($_FILES[$rechk]["name"]){
		$imgchk++;
	
		if($imgchk == 1){
			$filelist = $filenames;
		}else{
			$filelist .= ",".$filenames;
		}
		if (isset($_FILES[$rechk]) && is_uploaded_file($_FILES[$rechk]['tmp_name'])) {
			if (!preg_match($image_regex, $filenames)) {
				alert($filenames . '은(는) 이미지 파일이 아닙니다.');
			}
			
			if (preg_match($image_regex, $filenames)) {
				@mkdir($mb_img_dir, G5_DIR_PERMISSION);
				@chmod($mb_img_dir, G5_DIR_PERMISSION);
				
				$dest_path = $mb_img_dir.'/'.$filenames;
				
				
				move_uploaded_file($_FILES[$rechk]['tmp_name'], $dest_path);
				chmod($dest_path, G5_FILE_PERMISSION);
			
				if($filechk[1] != "mp4"){
					if (file_exists($dest_path)) {
						$size = @getimagesize($dest_path);
						if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
							$thumb = null;
							if($size[2] === 2 || $size[2] === 3 || $size[2] === 18) { // WebP 추가
								//jpg 또는 png 파일 적용


								//$thumb = thumbnail($filenames, $mb_img_dir, $mb_img_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
								$thumb = thumbnail($filenames, $mb_img_dir, $mb_img_dir, $size[0], $size[1], true, true);
								if($thumb) {
									@unlink($dest_path);
									rename($mb_img_dir.'/'.$thumb, $dest_path);
								}
							}
							if( !$thumb ){
								// 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
								@unlink($dest_path);
							}
						}
					}
				}
			}
		}

	}

}



if($is_mobile_shop){
    $url = './iteminfo.php?it_id='.$it_id.'&info=use';
}else{
	if($ct_id){
		$url = './myitemuseinsertlist.php';
	}else{
		$url = shop_item_url($it_id, "_=".get_token()."#sit_use");
	}
    
}
if ($w == "")
{
    /*
    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} ";
    $row = sql_fetch($sql);
    $max_is_id = $row['max_is_id'];

    $sql = " select max(is_id) as max_is_id from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and mb_id = '{$member['mb_id']}' ";
    $row = sql_fetch($sql);
    if ($row['max_is_id'] && $row['max_is_id'] == $max_is_id)
        alert("같은 상품에 대하여 계속해서 평가하실 수 없습니다.");
    */

    $sql = "insert {$g5['g5_shop_item_use_table']}
               set it_id = '$it_id',
				   ct_id = '$ct_id',
                   mb_id = '{$member['mb_id']}',
                   is_score = '$is_score',
                   is_name = '$is_name',
                   is_password = '$is_password',
                   is_subject = '$is_subject',
                   is_content = '$is_content',
				   is_file = '$filelist',
                   is_time = '".G5_TIME_YMDHIS."',
                   is_ip = '{$_SERVER['REMOTE_ADDR']}' ";
    if (!$default['de_item_use_use'])
        $sql .= ", is_confirm = '1' ";
    sql_query($sql);
	
	$use_id = sql_insert_id();

	if($ct_id != ''){
		$sql = " update {$g5['g5_shop_cart_table']}
					set ct_use_id = '$use_id'
				  where ct_id = '$ct_id' ";
		sql_query($sql);
	}

    if ($default['de_item_use_use']) {
        $alert_msg = "평가하신 글은 관리자가 확인한 후에 출력됩니다.";
    }  else {
        $alert_msg = "사용후기가 등록 되었습니다.";
    }

	if($config['cf_manager_hp']){

		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
		$receive_number = preg_replace("/[^0-9]/", "", $config['cf_manager_hp']);   // 수신자번호(받는사람)

		//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
		//aligo_sms_call("사용자 후기가 등록되었습니다.", $receive_number, $send_number, "", "", "");

	}

	if($config['cf_manager_email']){
		
	
		qna_email_call('후기작성', $config['cf_manager_email'], $member['mb_id'], $default['de_admin_company_name'], "", "", "", "", "");
		//order_email_call('입금완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account']);

	}

	

	

}
else if ($w == "u")
{
    $sql = " select is_password from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' ";

    $row = sql_fetch($sql);
    if ($row['is_password'] != $is_password)
        alert("비밀번호가 틀리므로 수정하실 수 없습니다.");

    $sql = " update {$g5['g5_shop_item_use_table']}
                set is_subject = '$is_subject',
                    is_content = '$is_content',
                    is_score = '$is_score'
              where is_id = '$is_id' ";
    sql_query($sql);

    $alert_msg = "사용후기가 수정 되었습니다.";
}
else if ($w == "d")
{
    if (!$is_admin)
    {
        $sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} where mb_id = '{$member['mb_id']}' and is_id = '$is_id' ";
        $row = sql_fetch($sql);
        if (!$row['cnt'])
            alert("자신의 사용후기만 삭제하실 수 있습니다.");
    }

    // 에디터로 첨부된 이미지 삭제
    $sql = " select is_content from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    $row = sql_fetch($sql);

    $imgs = get_editor_image($row['is_content'], $get_editor_img_mode);

    for($i=0;$i<count($imgs[1]);$i++) {
        $p = parse_url($imgs[1][$i]);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];


        if( preg_match('/(gif|jpe?g|bmp|png|webp)$/i', strtolower(end(explode('.', $data_path))) ) ){// WebP 추가

            $destfile = ( ! preg_match('/\w+\/\.\.\//', $data_path) ) ? G5_PATH.$data_path : '';

            if($destfile && preg_match('/\/data\/editor\/[A-Za-z0-9_]{1,20}\//', $destfile) && is_file($destfile))
                @unlink($destfile);
        }
    }

    $sql = " delete from {$g5['g5_shop_item_use_table']} where is_id = '$is_id' and md5(concat(is_id,is_time,is_ip)) = '{$hash}' ";
    sql_query($sql);

    $alert_msg = "사용후기를 삭제 하였습니다.";
}

//쇼핑몰 설정에서 사용후기가 즉시 출력일 경우
if( ! $default['de_item_use_use'] ){
    update_use_cnt($it_id);
    update_use_avg($it_id);
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
<?php
$sub_menu = '400650';
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/fcm.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$posts = array();
$check_keys = array('is_subject', 'is_content', 'is_confirm', 'is_reply_subject', 'is_reply_content', 'is_id');

foreach($check_keys as $key){

    if( in_array($key, array('is_content', 'is_reply_content')) ){
        $posts[$key] = isset($_POST[$key]) ? $_POST[$key] : '';
    } else {
        $posts[$key] = isset($_POST[$key]) ? clean_xss_tags($_POST[$key], 1, 1) : '';
    }
}

if ($w == "u")
{
	$confirm = sql_fetch("select is_confirm,is_file,mb_id,is_name from {$g5['g5_shop_item_use_table']} where is_id = '".$posts['is_id']."' ");
	$mbs = sql_fetch("select mb_hp,mb_email,mb_mobile_token from `g5_member` where mb_id = '".$confirm['mb_id']."' ");


	if($posts['is_confirm'] == 1 && $confirm['is_confirm'] != 1){//확정일때 문자보내기
		
		/* 2024-02-21 준섭 문자 메일 추가 */
		$sms_content10 = $default['de_sms_cont10'];
		$sms_content10 = str_replace("{이름}", $confirm['is_name'], $sms_content10);

		if($config['cf_manager_hp']){

			$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호 (보내는사람)
			$receive_number = preg_replace("/[^0-9]/", "", $mbs['mb_hp']);   // 수신자번호(받는사람)
			

			//알림톡발송
	/*			
			$kresult = kakao_alim("TS_0384", $receive_number, $confirm['is_name'], "", "", "", "", "", "", "");
				
			if($kresult != 'Y'){
				aligo_sms_call($sms_content10, $receive_number, $send_number, "", "", "");
			}

			qna_email_call('후기승인', $mbs['mb_email'], $confirm['is_name'], $default['de_admin_company_name'], "", "", "", "", "", $sms_content10);

	*/
			// 후기승인시 포인트 부여
			if($default['de_item_use_approval'] == 1){
				if($confirm['is_file'] != ''){		
					insert_point($confirm['mb_id'], $default['de_item_use_review_p'], '후기포인트 지급(img)', '@review_point', $confirm['mb_id'], '후기포인트지급.'.$posts['is_id']);
				}else{
					
					insert_point($confirm['mb_id'], $default['de_item_use_review'], '후기포인트 지급', '@review_point', $confirm['mb_id'], '후기포인트지급.'.$posts['is_id']);
				}
			}
		}

		$push_token = $mbs['mb_mobile_token'];
		$push_content = $config_apppush['app_push3'];

		if($push_token){
			//fcm_send($push_token, $push_content);
		}

		

	}


    $sql = "update {$g5['g5_shop_item_use_table']}
               set is_subject = '".$posts['is_subject']."',
                   is_content = '".$posts['is_content']."',
                   is_confirm = '".$posts['is_confirm']."',
                   is_reply_subject = '".$posts['is_reply_subject']."',
                   is_reply_content = '".$posts['is_reply_content']."',
                   is_reply_name = '".$member['mb_nick']."'
             where is_id = '".$posts['is_id']."'";
    sql_query($sql);

    if( isset($_POST['it_id']) ) {
        update_use_cnt($_POST['it_id']);
        update_use_avg($_POST['it_id']);
    }

    goto_url("./itemuseform.php?w=$w&amp;is_id=$is_id&amp;sca=$sca&amp;$qstr");
}
else
{
    alert();
}
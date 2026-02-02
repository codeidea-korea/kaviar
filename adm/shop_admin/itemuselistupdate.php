<?php
$sub_menu = '400650';
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/fcm.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
check_demo();

check_admin_token();

$count_post_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;

if (! $count_post_chk) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] === "선택수정") {
    auth_check_menu($auth, $sub_menu, 'w');
} else if ($_POST['act_button'] === "선택삭제") {
    auth_check_menu($auth, $sub_menu, 'd');
} else {
    alert("선택수정이나 선택삭제 작업이 아닙니다.");
}

for ($i=0; $i<$count_post_chk; $i++)
{
    $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0; // 실제 번호를 넘김
    $iit_id = isset($_POST['it_id'][$k]) ? preg_replace('/[^a-z0-9_\-]/i', '', $_POST['it_id'][$k]) : '';
	$is_file = isset($_POST['is_file'][$k]) ? $_POST['is_file'][$k] : '';
    $iis_id = isset($_POST['is_id'][$k]) ? (int) $_POST['is_id'][$k] : 0;
    $iis_score = isset($_POST['is_score'][$k]) ? (int) $_POST['is_score'][$k] : 0;
    $iis_confirm = isset($_POST['is_confirm'][$k]) ? (int) $_POST['is_confirm'][$k] : 0;
	$mb_id = $_POST['mb_id'][$k];
	
	$mbs = sql_fetch("select mb_hp,mb_email,mb_mobile_token from `g5_member` where mb_id = '".$mb_id."' ");

	$confirm = sql_fetch("select is_confirm,is_name from {$g5['g5_shop_item_use_table']} where is_id = '".$iis_id."' ");
	
    if ($_POST['act_button'] == "선택수정")
    {
        $sql = "update {$g5['g5_shop_item_use_table']}
                   set is_score   = '{$iis_score}',
                       is_confirm = '{$iis_confirm}'
                 where is_id      = '{$iis_id}' ";
        sql_query($sql);
		
		if($iis_confirm == 1 && $confirm['is_confirm'] != 1){//확정일때 문자보내기
			
			/* 2024-02-21 준섭 문자 메일 추가 */
			$sms_content10 = $default['de_sms_cont10'];
			$sms_content10 = str_replace("{이름}", $confirm['is_name'], $sms_content10);

			if($config['cf_manager_hp']){

				$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호 (보내는사람)
				$receive_number = preg_replace("/[^0-9]/", "", $mbs['mb_hp']);   // 수신자번호(받는사람)
				
				
				
				
				
				//알림톡발송
				//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
				
				/*
				$kresult = kakao_alim("TS_0384", $receive_number, $confirm['is_name'], "", "", "", "", "", "", "");
					
				if($kresult != 'Y'){
					aligo_sms_call($sms_content10, $receive_number, $send_number, "", "", "");
				}

				qna_email_call('후기승인', $mbs['mb_email'], $confirm['is_name'], $default['de_admin_company_name'], "", "", "", "", "", $sms_content10);
				*/
				
				// 후기승인시 포인트 부여
				if($default['de_item_use_approval'] == 1){
					if($is_file != ''){
						insert_point($mb_id, $default['de_item_use_review_p'], '후기포인트 지급(List_img))', '@review_point', $mb_id, '후기포인트지급.'.$iis_id);
					}else{
						insert_point($mb_id, $default['de_item_use_review'], '후기포인트 지급 List', '@review_point', $mb_id, '후기포인트지급.'.$iis_id);
					}
				}

			}
		/*
			$push_token = $mbs['mb_mobile_token'];
			$push_content = $config_apppush['app_push3'];

			if($push_token){
				fcm_send($push_token, $push_content);
			}
		*/

		}
    }
    else if ($_POST['act_button'] == "선택삭제")
    {
        $sql = "delete from {$g5['g5_shop_item_use_table']} where is_id = '{$iis_id}' ";
        sql_query($sql);
    }
    
    if($iit_id){
        update_use_cnt($iit_id);
        update_use_avg($iit_id);
    }
}

goto_url("./itemuselist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
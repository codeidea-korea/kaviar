<?php
if (!defined('_GNUBOARD_')) exit;

//가입코드 채크 - 인태추가
function check_join_code($tmp_joinCode){
    global $g5, $config, $member_skin_url;	
	
	if($config['cf_use_join_code'] && $config['cf_join_code']) {
		$code_pass = false;

		if($tmp_joinCode) {
			$cf_join_code = explode("|", $config['cf_join_code']);
			$cf_join_level = explode("|", $config['cf_join_level']);
			for ($i=0; $i<count($cf_join_code); $i++) {
				if($cf_join_code[$i] == $tmp_joinCode) {
					$code_pass = true;
					break;
				}
			}		
			if(!$code_pass) alert('가입코드가 일치하지 않습니다.', $member_skin_url.'/joinCode.php');
		} else {
			goto_url($member_skin_url.'/joinCode.php');
		}
	}
}


function get_join_level($tmp_joinCode) {
	global $g5, $config;	
	
	$join_level = '';
	if($config['cf_use_join_code'] && $config['cf_join_code']) {		
		$cf_join_code = explode("|", $config['cf_join_code']);
		$cf_join_level = explode("|", $config['cf_join_level']);
		for ($i=0; $i<count($cf_join_code); $i++) {
			if($cf_join_code[$i] == $tmp_joinCode) {
				$join_level = $cf_join_level[$i];
				break;
			}
		}
	}
    return $join_level;
}
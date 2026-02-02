<?php
if (!defined('_GNUBOARD_')) exit;

// $cache_time 캐시 갱신시간, 단위는 시간이며, 0 이면 갱신하지 않는다.
function quick_latest_multi($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=0, $latestOption='') {
	global $g5, $is_admin, $config, $group, $css;

	if (!$skin_dir) $skin_dir = 'basic';

	if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) { //테마스킨
		$latest_pcskin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/quick/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/quick/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$skin_dir = $match[1];
	} else if(preg_match('#^seperate/(.+)$#', $skin_dir, $match)) { // 전용스킨
		$latest_pcskin_path = G5_THIS_PATH.'/'.G5_SKIN_DIR.'/quick/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/quick/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$skin_dir = $match[1];
    } else {
		$latest_pcskin_path = G5_SKIN_PATH.'/quick/'.$skin_dir;
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if(G5_IS_MOBILE) {
			$latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/quick/'.$skin_dir;
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url  = str_replace(G5_PATH, G5_URL, $latest_skin_path);		
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;	
		}
	}
	
	if($bo_table) {
		$cache_fwrite = false;
		if(G5_USE_CACHE) {
			$cache_file = G5_DATA_PATH."/cache/latest-{$bo_table}-{$skin_dir}-{$rows}-{$subject_len}.php";

			if(!file_exists($cache_file)) {
				$cache_fwrite = true;
			} else {
				if($cache_time > 0) {
					$filetime = filemtime($cache_file);
					if($filetime && $filetime < (G5_SERVER_TIME - 3600 * $cache_time)) {
						@unlink($cache_file);
						$cache_fwrite = true;
					}
				}

				if(!$cache_fwrite)
					include($cache_file);
			}
		}

		if(!G5_USE_CACHE || $cache_fwrite) {
			$list = array();

			$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
			$board = sql_fetch($sql);
			$bo_subject = get_text($board['bo_subject']);

			//정렬
			$board['bo_sort_field'] = $board['bo_sort_field'] ? $board['bo_sort_field'] : 'wr_num, wr_reply';
			$bo_field = 'wr_order < 0, wr_order = 0, wr_order, '.$board['bo_sort_field'];
			if(!$bo_field || $bo_field == 'field') $bo_field = 'wr_order < 0, wr_order = 0, wr_order, wr_num, wr_reply';

			$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

			//인태 - 사용여부 채크
			$my_order = '';
			$my_order .= 'wr_use != "none" and ';
			$my_order .= G5_IS_MOBILE ? 'wr_use != "pc" and ' : 'wr_use != "mobile" and ';	

			$sql_where = " where {$my_order} wr_is_comment = 0 ";

			if (stristr($options, "notice_only"))		$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 ";
			if (stristr($options, "notice_exclude"))	$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) = 0 ";
			if (stristr($options, "reply_exclude"))		$sql_where .= " and wr_reply = '' ";
			if (stristr($options, "file_exist"))		$sql_where .= " and wr_file > 0 ";

			$sql_order = " order by ";
			$sql_order .= " ".$bo_field.", "; //인태 추가 게시판 설정에 따름
			if(strpos($latestOption, "랜덤") !== false) $sql_order .= " rand(), ";
			$sql_order .= " wr_num limit 0, {$rows} ";

			$sql = " select * from {$tmp_write_table} " . $sql_where . $sql_order;
			$result = sql_query($sql);
			for ($i=0; $row = sql_fetch_array($result); $i++) {
				$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
			}

			if($cache_fwrite) {
				$handle = fopen($cache_file, 'w');
				$cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject='".$bo_subject."';\n\$list=".var_export($list, true)."?>";
				fwrite($handle, $cache_content);
				fclose($handle);
			}
		}
	}

	ob_start();
	$quick_news = get_quick_news();
	$editor_img_not = true; //본문 이미지는 썸네일 사용 안함
	$blockName = 'qn_'.$bo_table;
	@include(G5_BBS_PATH.'/my/_latest.php');
	include $latest_skin_path.'/latest.skin.php';
	$content .= ob_get_contents();	
	ob_end_clean();
	return $content;
}


function get_quicknews() {
	global $g5, $is_admin, $group, $quick_news;

	$quickNews_code = '';
	$quick_news['qn_title'] = $quick_news['qn_title'] ? $quick_news['qn_title'] : 'NㆍEㆍWㆍS';
	$opener_label = '<span class="title">'.$quick_news['qn_title'].'</span>';
	$quickNews_code = '<div id="quickNewsWrap" class="mobile-max-width">';
	if(!G5_IS_MOBILE) $quickNews_code .= '<div class="quickNews_opener">'.$opener_label.'</div>';
	$quickNews_code .= '<div id="quickNews-container">';
	$quickNews_code .= '<header class="quickNews_header">';
	$quickNews_code .= '<span class="quickNews_closer"></span>';
	$quickNews_code .= '<div class="qn_tabs">';
	$now_table = $_GET['bo_table'];
	$is_qn_table[1] = $is_qn_table[2] = true;
	
	if($group['gr_use_layout'] && $group['gr_qn_table']) {
		$gr_tab_active = $now_table == $group['gr_qn_table'] ? 'active' : false;	
		$gr_qn_subject = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table='".$group['gr_qn_table']."'");
		$quickNews_code .= '<span class="tab group_tab '.$gr_tab_active.'" data-target="#qn_'.$group['gr_qn_table'].'">'.$gr_qn_subject['bo_subject'].'</span>';
		for ($i=1; $i<=2; $i++) {
			$is_qn_table[$i] = $quick_news['qn_table'.$i.'_fixed'] ? true : false;
		}
	}
	for ($i=1; $i<=2; $i++) {
		$qn_subject[$i] = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table='".$quick_news['qn_table'.$i]."'");
		$tab_active[$i] = $now_table == $quick_news['qn_table'.$i] ? 'active' : false;
	}
	for ($i=1; $i<=2; $i++) {
		if($quick_news['qn_table'.$i] && $is_qn_table[$i]) $quickNews_code .= '<span class="tab '.$tab_active[$i].'" data-target="#qn_'.$quick_news['qn_table'.$i].'">'.$qn_subject[$i]['bo_subject'].'</span>';
	}
	$quickNews_code .= '</div>';
	if($is_admin == 'super' || $is_admin == 'group') {
		if($group['gr_use_layout']) {
			$quickNews_code .= '<a href="'.G5_BBS_URL.'/my/_adm/?pn=group_quicknews&gr_id='.$group['gr_id'].'&title='.$group['gr_subject'].' 퀵뉴스 추가 설정" class="btnSetting popWin ml20" data-width="900" data-height="360" data-top="60" data-left="0" data-area=".quickNews">그룹 퀵뉴스 관리</a>';
		} else {
			if($is_admin == 'super') $quickNews_code .= '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_adm_quicknews&title=퀵뉴스 관리" class="btnSetting popWin ml20" data-width="900" data-height="600" data-top="60" data-left="0" data-area=".quickNews">퀵뉴스 관리</a>';
		}		
	}
	$quickNews_code .= '</header>';	
	
	$quickNews_code .= '<div class="qnContainer">';
	//if($group['gr_use_layout'] && $group['gr_qn_table']) $quickNews_code .= quick_latest_multi('quicknews', $group['gr_qn_table'], $group['gr_qn_list'], 100, 0, $group['gr_qn_option']); //퀵뉴스
	for ($i=1; $i<=2; $i++) {
		if($quick_news['qn_table'.$i] && $is_qn_table[$i]) $quickNews_code .= quick_latest_multi('quicknews', $quick_news['qn_table'.$i], $quick_news['qn_list'.$i], 100, 0, $quick_news['qn_option']); //퀵뉴스
	}
	$quickNews_code .= '</div>';	

	$quickNews_code .= '</div>';	
	//닫기 버튼
	$quickCloserEL = G5_IS_MOBILE ? '.quickNews_closer, #wrapper, .qn_li' : '.quickNews_closer, #wrapper';
	$startOption = false;
	if(!G5_IS_MOBILE && ($quick_news['qn_start_option']=='1' || $quick_news['qn_start_option']=='2')) $startOption = true;
	if(G5_IS_MOBILE && ($quick_news['qn_start_option']=='1' || $quick_news['qn_start_option']=='3')) $startOption = true;
	if($quick_news['qn_start_option']=='4') $startOption = 'absolute';
	$quickNews_code .= '<script>';
	$quickNews_code .= '
	$(function(){		
		quickNews_toggle(".quickNews_opener, .qnewsOpen", "'.$quickCloserEL.'", "#quickNewsWrap #quickNews-container", "'.$startOption.'");
		if($("#quickNewsWrap .qn_tabs .tab.active").length == 0) {
			$("#quickNewsWrap .qn_tabs .tab").first().addClass("active");
			$("#quickNewsWrap .qnContainer .quickNews").first().addClass("open");
		}
	});';
	$quickNews_code .= '</script>';
	$quickNews_code .= '</div>';

	return $quickNews_code;
}

if(G5_IS_MOBILE) {
	$is_quickNews = ($quick_news['qn_use'] == '1' || $quick_news['qn_use'] == '3') && ($quick_news['qn_table1'] || $quick_news['qn_table2']) ? true : false;
	$is_quickNews = $quick_news['qn_use_admin'] && !$is_admin ? false : $is_quickNews;
} else {
	$is_quickNews = ($quick_news['qn_use'] == '1' || $quick_news['qn_use'] == '2') && ($quick_news['qn_table1'] || $quick_news['qn_table2']) ? true : false;
	$is_quickNews = $quick_news['qn_use_admin'] && !$is_admin ? false : $is_quickNews;
}
<?php
if (!defined('_GNUBOARD_')) exit;

// 다기능 최신글 추출
// ver.2015-12-23  subject_* 추가
// ver.2015-12-19  file_exist 추가

// $cache_time 캐시 갱신시간, 단위는 시간이며, 0 이면 갱신하지 않는다.
function latest_multi($skin_dir='', $bo_table, $rows=10, $subject_len=40, $cache_time=0, $latestSort='', $blockName='', $latestOption='', $latest_width='', $bl_background='', $latest_type='', $bl_font)
{
	global $g5, $is_admin, $config, $css, $board_pcskin_path;


	//특정 카테고리 불러오기 예 - basic|a,b,c
	list($bo_table, $category) = explode("|", $bo_table); 
	if($category) {
		$categories = explode(",", $category);
		$tmp_board = get_board_db($bo_table);
		$where = " AND ca_name IN('".implode("', '", $categories)."')";
	}
	
	//최신글 필터링
	if($latestSort) {
		if(strpos($latestOption, "직접선택") !== false) {
			//글번호로 검색
			$sel_li_ids = explode(",", $latestSort);
			$where .= " AND (";
			for ($t=0; $t<count($sel_li_ids); $t++) {
				$sel_li_id = trim($sel_li_ids[$t]);
				if($sel_li_id=='') continue;
				if($t>0) $where .= ' || ';
				$where .= 'wr_id = '.$sel_li_id.'';
			}
			$where .= ") ";
		} else {
			//태그로 검색
			$sort_tags = explode(",", $latestSort);
			$where .= " AND (";
			for ($t=0; $t<count($sort_tags); $t++) {
				$tag_name = trim($sort_tags[$t]);
				if($tag_name=='') continue;
				if($t>0) $where .= ' || ';
				$where .= 'wr_tag like \'%'.$tag_name.'%\'';
			}
			$where .= ") ";
		}
	}
	
	$parent_skin_path = $board_pcskin_path; //최신글을 불러오는 게시판 스킨(예:skin/board/pageMake)

	if(!$skin_dir) $skin_dir = 'basic';
	$board_skin_url = get_skin_url('board', $skin_dir); //폴더명이 동일한 게시판스킨 url
	$board_skin_path = get_skin_path('board', $skin_dir); //폴더명이 동일한 게시판스킨 url
	$board_pcskin_url = get_pcskin_url('board', $skin_dir); //폴더명이 동일한 게시판스킨 url
	$board_pcskin_path = get_pcskin_path('board', $skin_dir); //폴더명이 동일한 게시판스킨 url

	if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) { //테마스킨
		$latest_pcskin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$skin_dir = $match[1];
	} else if(preg_match('#^seperate/(.+)$#', $skin_dir, $match)) { // 전용스킨
		$latest_pcskin_path = G5_THIS_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$skin_dir = $match[1];
    } else {
		$latest_pcskin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if(G5_IS_MOBILE) {
			$latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url  = str_replace(G5_PATH, G5_URL, $latest_skin_path);		
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;	
		}
	}

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


	if(!G5_USE_CACHE) {
		$list = array();
		$board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$bo_table}' ");
		$bo_subject = get_text($board['bo_subject']);

		$latestSkin = $skin_dir;
		$skin_pagemake = strpos($latestSkin, 'pageMake') !== false ? true : false;
		$skin_bigBanner = strpos($latestSkin, 'bigBanner') !== false ? true : false;
		$skin_map = strpos($latestSkin, 'map') !== false ? true : false;

		//정렬
		$board['bo_sort_field'] = $board['bo_sort_field'] ? $board['bo_sort_field'] : 'wr_num, wr_reply';
		$bo_field = 'wr_order < 0, wr_order = 0, wr_order, '.$board['bo_sort_field'];
		if(!$bo_field || $bo_field == 'field') $bo_field = 'wr_order < 0, wr_order = 0, wr_order, wr_num, wr_reply';
		
		$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름

		//인태 - 사용여부 채크
		$my_order = '';
		$my_order .= 'wr_use != "none" and ';
		$my_order .= G5_IS_MOBILE ? 'wr_use != "pc" and ' : 'wr_use != "mobile" and ';		

		$sql_where = " where {$my_order} wr_is_comment = 0".$where." ";

		if(strpos($latestOption, "공지만") !== false)		$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 ";
		if(strpos($latestOption, "공지제외") !== false)	$sql_where .= " and INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) = 0 ";		
		if(strpos($latestOption, "비밀글제외") !== false)	$sql_where .= " and not wr_option like '%secret%' ";
		if(strpos($latestOption, "댓글만") !== false)		$sql_where .= " and wr_reply = '' ";

		$sql_order = " order by ";
		$sql_order .= " ".$bo_field.", "; //인태 추가 게시판 설정에 따름
		if(strpos($latestOption, "랜덤") !== false) $sql_order .= " rand(), ";
		if($skin_map) $sql_order .= " case when INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 then 0 else 1 end, ";
		/*if($sort == "bo" || $sort == "")		$sql_order .= " ".$bo_field.", "; //인태 추가 게시판 설정에 따름
		if($sort == "notice_up")					$sql_order .= " case when INSTR(concat(',','$board[bo_notice]',','),concat(',',wr_id,',')) > 0 then 0 else 1 end, ";
		if($sort == "reply_list")					$sql_order .= " wr_num, wr_reply, ";
		if($sort == "datetime_asc")				$sql_order .= " wr_datetime asc, ";
		if($sort == "datetime_desc")			$sql_order .= " wr_datetime desc, ";
		if($sort == "hit_asc")						$sql_order .= " wr_hit asc, ";
		if($sort == "hit_desc")					$sql_order .= " wr_hit desc, ";
		if($sort == "last_asc")					$sql_order .= " wr_last asc, ";
		if($sort == "last_desc")					$sql_order .= " wr_last desc, ";
		if($sort == "comment_asc")			$sql_order .= " wr_comment asc, ";
		if($sort == "comment_desc")			$sql_order .= " wr_comment desc, ";
		if($sort == "comment_cnt_desc")	$sql_order .= " wr_comment desc, ";
		if($sort == "good_asc")					$sql_order .= " wr_good asc, ";
		if($sort == "good_desc")					$sql_order .= " wr_good desc, ";
		if($sort == "subject_asc")				$sql_order .= " wr_subject asc, ";
		if($sort == "subject_desc")				$sql_order .= " wr_subject desc, ";
		if($sort == "wr_1_asc")					$sql_order .= " wr_1 asc, ";
		if($sort == "wr_1_desc")					$sql_order .= " wr_1 desc, ";
		if($sort == "random")						$sql_order .= " rand(), ";*/
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
	
	ob_start();	
	@include(G5_BBS_PATH.'/my/_latest.php');
	//if($is_category && $showCateMenu) 	$content .= latest_category('basic', $bo_table, $blockName, $latest_skin_url);
	include $latest_skin_path.'/latest.skin.php';
	$content .= ob_get_contents();
	if($latestScript) $content .= '<script data-name="'.$blockName.'">'.$latestScript.'</script>'.PHP_EOL;
	ob_end_clean();

	return $content;
}





// $bo_tables 테이블들 사이 콤마(,) 단위로 구분해서 넣을 것, 콤마 사이에 공백 없이 (ex aaa,bbb,)
function latest_all($skin_dir='', $bo_tables, $rows=10, $subject_len=40, $cache_time=0, $options='', $latestOption='', $latest_bg=''){
    
	global $g5;

	$is_multyBoard = true;

    if (!$skin_dir) $skin_dir = 'basic';

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

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

		$sql_common = " from {$g5['board_new_table']} a where find_in_set(a.bo_table, '{$bo_tables}')";
		$sql_common .= " and a.wr_id = a.wr_parent";
		$sql_order = " order by a.bn_id ";
		$sql_order .= " desc ";
		$sql = " select a.* {$sql_common} {$sql_order} limit 0, {$rows}";


		$result = sql_query($sql);

		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$sql = " select * from {$g5['board_table']} where bo_table = '{$row['bo_table']}' ";
			$board = sql_fetch($sql);
			$tmp_write_table = $g5['write_prefix'] . $row['bo_table']; // 게시판 테이블 전체이름
			$row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$row['wr_id']}' ");
			$list[$i] = $row2;
			$list[$i] = get_list($row2, $board, $latest_skin_url, $subject_len);
			$list[$i]['bo_table'] = $row['bo_table'];
			//$list[$i]['bo_subject'] = $row['bo_subject'];
			$list[$i]['bo_subject'] = $board['bo_subject'];
		}

		if($cache_fwrite) {
			$handle = fopen($cache_file, 'w');
			$cache_content = "<?php\nif (!defined('_GNUBOARD_')) exit;\n\$bo_subject='".$bo_subject."';\n\$list=".var_export($list, true)."?>";
			fwrite($handle, $cache_content);
			fclose($handle);
		}
	}

    ob_start();
	include(G5_PATH.'/popup/latest.skin.option.lib.php'); //옵션관리
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function latestSortComment($skin_dir='', $bo_table, $rows=10, $subCut=99, $cache_time=0, $sort = 'wr_datetime desc', $blockName='', $latestOption='') {
	global $g5, $is_admin, $config;
	$subject_len=40;
	$cache_time=1;

	//특정 카테고리 불러오기 예 - basic|a,b,c
	list($bo_table, $category) = explode("|", $bo_table); 
	if($category) {
		$categories = explode(",", $category);

		$tmp_board = get_board_db($bo_table);
		//$where = " AND ( wr_1 IN('".implode("', '", $categories)."') || wr_2 IN('".implode("', '", $categories)."') || wr_3 IN('".implode("', '", $categories)."') || wr_4 IN('".implode("', '", $categories)."') )";
		$where = " AND b.wr_2 IN('".implode("', '", $categories)."')";
	}

	if($skin_dir) {
		$latest_skin_path = $latest_pcskin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
		$latest_skin_url  = $latest_pcskin_url = G5_SKIN_URL.'/latest/'.$skin_dir;
	}
  
	$list = array();
	$sql = " select * from {$g5['board_table']} where bo_table = '{$bo_table}' ";
	$board = sql_fetch($sql);
	$bo_subject = get_text($board['bo_subject']);

	$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
	//$sql = " select * from {$tmp_write_table} where wr_is_comment = 1 and wr_comment_reply = '' order by '{$sort}' limit 0, {$rows} ";
	// $sql = " select * from {$tmp_write_table} where wr_is_comment = 1 and wr_comment_reply = '' order by wr_datetime desc limit 0, {$rows} "; //인태 - 최신댓글은 무조건 최신순
	
	if($bo_table == $config['cf_member_write_table']) { //피플허브 최신댓글은 대댓글 제외.
		$sql = " select a.* from {$tmp_write_table} as a left join {$tmp_write_table} as b on a.wr_parent = b.wr_id where a.wr_is_comment = 1 and a.wr_comment_reply = '' ".$where." order by a.wr_datetime desc limit 0, {$rows} "; //인태 - 최신댓글은 무조건 최신순
	} else { //일반 게시판 최신댓글은 모든 댓글
		$sql = " select a.* from {$tmp_write_table} as a left join {$tmp_write_table} as b on a.wr_parent = b.wr_id where a.wr_is_comment = 1  ".$where." order by a.wr_datetime desc limit 0, {$rows} "; //인태 - 최신댓글은 무조건 최신순
	}
	$result = sql_query($sql);

	for ($i=0; $row = sql_fetch_array($result); $i++) {
		$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
		//$sql = " select * from {$tmp_write_table} where wr_is_comment = 0 and wr_id = '{$row[wr_parent]}' limit 1";
		$sql = " select * from {$tmp_write_table} where wr_is_comment = 0 and wr_id = '{$row[wr_parent]}' limit 1";
		$result2 = sql_fetch($sql);
		$list[$i]["parent"] = $result2;
	}

	if($cache_fwrite) {
		$handle = fopen($cache_file, 'w');
		$caches = array(
			'list' => $list,
			'bo_subject' => sql_escape_string($bo_subject),
		);
		$cache_content = "<?php if (!defined('_GNUBOARD_')) exit; ?>\n\n";
		$cache_content .= base64_encode(serialize($caches));  //serialize
		fwrite($handle, $cache_content);
		fclose($handle);
		@chmod($cache_file, 0640);
	}

	for ($i=0;$i<count($list);$i++) {
		$replyCon[$i] = conv_subject($list[$i]['wr_content'], $subCut, '…');
		$list[$i]["wr2"] = $list[$i]['parent']["wr_2"];
	}

	$blockID = '#'.$blockName;
	ob_start();
	$latestCSS = G5_IS_MOBILE ? 'mobile.css':'style.css';
	include(G5_PATH.'/popup/latest.skin.option.lib.php'); //옵션관리
	include(G5_BBS_PATH.'/my/latest.php');
	include(G5_PATH.'/popup/latest_option_style.php');
	if($latestStyle) $content .= '<style name="'.$blockName.'">'.$latestStyle.'</style>';	
	include $latest_skin_path.'/latest.skin.php';
	$content .= ob_get_contents();
	if($latestScript) $content .= '<script data-name="'.$blockName.'">'.$latestScript.'</script>'.PHP_EOL;
	ob_end_clean();

	return $content;
}

?>
<?php
if (!defined('_GNUBOARD_')) exit;

// ───────────────────────────────────────────────────────────────────
//										생성된 게시판을 SELECT 형식으로 얻음 
// ───────────────────────────────────────────────────────────────────
function get_board_select_my($name, $selected='', $event='', $skin='', $option_text='', $gr_id='') {
    global $g5, $board, $is_admin;
	$where = $gr_id ? " where gr_id = '{$gr_id}' " : "";
    $sql = " select bo_table, bo_subject, bo_skin, gr_id from {$g5['board_table']} a {$where} ";
	$sql .= " order by a.bo_order ";
    $result = sql_query($sql);
    $str .= "<select id=\"$name\" name=\"$name\" $event data-live-search=\"true\">\n";
	
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		if($option_text == 'subject' || $option_text == 'subject+table'){
			$optionText = $row['bo_subject'].' <small>('.$row['bo_table'].')</small>';
		} else {
			$optionText = $row['bo_table'].' <small>('.$row['bo_subject'].')</small>';
		}
		if($i == 0) $str .= "<option value=\"\">- 선택 -</option>";
		if($skin) {
			if($skin == 'all') {
				$str .= option_selected_my($row['bo_table'], $selected, $row['bo_table'], "data-content='".$optionText."'");
			} else {
				//if(strpos($row['bo_skin'], $skin) !== false) $str .= option_selected($row['bo_table'], $selected, $optionText);
				if(strpos($row['bo_skin'], $skin) !== false) $str .= option_selected_my($row['bo_table'], $selected, $row['bo_table'], "data-content='".$optionText."'");
			}
		} else {
			$str .= strpos($row['bo_skin'], 'pageMake') !== false ? '' : option_selected_my($row['bo_table'], $selected, $row['bo_table'], "data-content='".$optionText."'");
		}
    }
    $str .= "</select>";
    return $str;
}


// ───────────────────────────────────────────────────────────────────
//										생성된 게시판을 SELECT (multiple) 형식으로 얻음 
// ───────────────────────────────────────────────────────────────────
function get_board_select_multiple($name, $selected='', $event='', $skin='', $option_text='') {
    global $g5, $board, $is_admin;
    $sql = " select bo_table, bo_subject, bo_skin from {$g5['board_table']} a ";
	$sql .= " order by a.bo_order ";
    $result = sql_query($sql);
    $str = "<select id=\"$name\" name=\"$name\" multiple $event>\n";
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		if($option_text == 'subject'){
			$optionText = $row['bo_subject'];
		} else if($option_text == 'table+subject'){
			$optionText = $row['bo_table'].' <b>'.$row['bo_subject'].'</b>';
		} else if($option_text == 'subject+table'){
			$optionText = $row['bo_subject'].' ('.$row['bo_table'].')';
		} else {
			$optionText = $row['bo_table'];
		}
		if($skin){
			if($skin == 'all') {
				$str .= option_multiple_selected_my($row['bo_table'], $selected, $optionText);
			} else {
				if($row['bo_skin'] == $skin) $str .= option_multiple_selected_my($row['bo_table'], $selected, $optionText);
			}
		} else {
			if($row['bo_skin'] != 'pageMake') $str .= option_multiple_selected_my($row['bo_table'], $selected, $optionText);
		}
    }
    $str .= "</select>";
    return $str;
}


// ───────────────────────────────────────────────────────────────────
//										생성된 게시판을 option 형식으로 얻음 
// ───────────────────────────────────────────────────────────────────
function get_board_select_option_my($selected='', $strpos='') {
    global $g5, $board;
    $sql = " select bo_table, bo_subject, bo_skin from {$g5['board_table']} order by bo_order ";
    $result = sql_query($sql);
	
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$optionText = $row['bo_subject'].' <small>('.$row['bo_table'].')</small>';
		if(strpos($row['bo_skin'], 'pageMake') !== false)
			continue;
		
		if($strpos) {
			$str .= strpos($row['bo_skin'], $strpos) !== false ? option_selected_my($row['bo_table'], $selected, $row['bo_subject'], "data-content='".$optionText."'") : '';
		} else {
			$str .= option_selected_my($row['bo_table'], $selected, $row['bo_subject'], "data-content='".$optionText."'");
		}
		
    }

    return $str;
}


// ───────────────────────────────────────────────────────────────────
//										게시판 스킨을 SELECT 형식으로 얻음 
// ───────────────────────────────────────────────────────────────────
function get_skin_select_my($skin_gubun, $id, $name, $selected='', $event='', $showImg=false, $skin_strpos=''){
    global $config, $theme_type;

	//일부 스킨 변경 제한 두기
	if(!$skin_strpos && $selected) {
		if(strpos($selected, 'pageMake') !== false) $skin_strpos = 'pageMake';
		if(strpos($selected, 'PEOPLE-HUB') !== false) $skin_strpos = 'PEOPLE-HUB';
		if(strpos($selected, 'collect') !== false) $skin_strpos = 'collect';
		if(strpos($selected, 'pdf-viewer') !== false) $skin_strpos = 'pdf-viewer';
		if(strpos($selected, 'poll') !== false) $skin_strpos = 'poll';
		//$event .= ' disabled';
	}
	
    $skins = array();
    if(defined('G5_THEME_PATH') && $config['cf_theme']) {
		$this_dirs = get_skin_dir_my($skin_gubun, G5_THIS_PATH.'/'.G5_SKIN_DIR, $skin_strpos);
        if(!empty($this_dirs)) {
            foreach($this_dirs as $dir) {
                $skins[] = strpos($skin_gubun, '/quickMenu') !== false ? 'seperate/quickMenu/'.$dir : 'seperate/'.$dir; //해당사이트 전용
            }
        }
        $dirs = get_skin_dir_my($skin_gubun, G5_THEME_PATH.'/'.G5_SKIN_DIR, $skin_strpos);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = strpos($skin_gubun, '/quickMenu') !== false ? 'theme/quickMenu/'.$dir : 'theme/'.$dir;
            }
        }
    }

    $skins = array_merge($skins, get_skin_dir_my($skin_gubun, G5_SKIN_PATH, $skin_strpos));
	
	if(count($skins) == 1) $event .= ' disabled';

	$str = "<select id=\"$id\" name=\"$name\" $event>\n";
	//$str .= "<option value=\"\" checked>- 선택없음 -</option>\n";
    for ($i=0; $i<count($skins); $i++) {
		
		if(strpos($skins[$i], '@') !== false) $skins[$i] = '';
		if($skin_gubun == 'board') {
			if($theme_type == 'shop') {
				if(strpos($skins[$i], 'shop') === false) $skins[$i] = '';
			} else {
				if(strpos($skins[$i], 'shop') !== false) $skins[$i] = '';
			}
		}

		if($skins[$i]) {
			if(preg_match('#^theme/(.+)$#', $skins[$i], $match)) {
				$text = $showImg ? '@ '.$match[1] : '(테마) '.$match[1];
				$dataSubject = 'data-subtext=\'(테마)\'';
				$skin_img_path = G5_THEME_PATH.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';			
			} else if(preg_match('#^seperate/(.+)$#', $skins[$i], $match)) {
				$text = $showImg ? '+ '.$match[1] : '(전용) '.$match[1];
				$dataSubject = 'data-subtext=\'('.G5_THIS_DIR.')\'';
				$skin_img_path = G5_THIS_PATH.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';
			} else {
				$skins[$i] = strpos($skin_gubun, '/quickMenu') !== false ? 'quickMenu/'.$skins[$i] : $skins[$i];
				$text = $skins[$i];
				$dataSubject = '';
				$skin_img_path = G5_PATH.'/skin/'.$skin_gubun.'/'.$skins[$i].'/thumb.png';
			}
			$skin_img_url = str_replace(G5_PATH, G5_URL, $skin_img_path);

			//$exceptSkin = strpos($skins[$i], '@') !== false ? true : false;
			if($showImg && file_exists($skin_img_path)) {
				$str .= option_selected_my($skins[$i], $selected, $text, 'data-content=\'<img src="'.get_url($skin_img_url).'"><span class="skin_name">'.$text.'</span>\'');
			} else {
				$str .= option_selected_my($skins[$i], $selected, $text, $dataSubject);
			}
		}
    }
    $str .= "</select>";

	if(count($skins) == 1) $str .= "<input type='hidden' name=\"$name\" value=\"$selected\">";
	
    return $str;
}

// ───────────────────────────────────────────────────────────────────
//										@포함한것 제외 및 특정 스킨경로 찾기
// ───────────────────────────────────────────────────────────────────
function get_skin_dir_my($skin, $skin_path=G5_SKIN_PATH, $skin_strpos='') {
    global $g5;
    $result_array = array();
    $dirname = $skin_path.'/'.$skin.'/';
    if(!is_dir($dirname))
        return;
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..'||strpos($file,'@') !== false) continue;
		if($skin_strpos) {
			if(strpos($file,$skin_strpos) === false) continue;
		}
		if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
	usort($result_array, 'strcasecmp');
    return $result_array;
}


// ───────────────────────────────────────────────────────────────────
//										게시판 모바일 스킨을 SELECT 형식으로 얻음 
// ───────────────────────────────────────────────────────────────────
function get_mobile_skin_select_my($skin_gubun, $id, $name, $selected='', $event='') {
    global $config;
    $skins = array();
    if(defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = get_skin_dir($skin_gubun, G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }
    $skins = array_merge($skins, get_skin_dir($skin_gubun, G5_MOBILE_PATH.'/'.G5_SKIN_DIR));
    $str = "<select id=\"$id\" name=\"$name\" $event>\n";
    for ($i=0; $i<count($skins); $i++) {
        if ($i == 0) $str .= "<option value=\"\">pc와 동일</option>"; //인태
		$text = preg_match('#^theme/(.+)$#', $skins[$i], $match) ? '(테마) '.$match[1] : $skins[$i];
        $exceptSkin = strpos($skins[$i], '@') !== false ? true : false;
		if(!$exceptSkin) $str .= option_selected($skins[$i], $selected, $text);
    }
    $str .= "</select>";
    return $str;
}


// ───────────────────────────────────────────────────────────────────
//														비공개 분류 select
// ───────────────────────────────────────────────────────────────────
function get_admin_category_select($bo_table='', $selected='') {
    global $g5, $board;
    $categories = explode("|", $board['bo_category_list']);
    $str = "<select name='bo_category_admin[]' class='selectpicker' multiple data-actions-box=\"true\">\n";
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if (!$category) continue;
		$str .= option_multiple_selected_my($categories[$i], $selected, $categories[$i]);
    }
	$str .= "</select>";
    return $str;
}


// ───────────────────────────────────────────────────────────────────
//														셀렉트 옵션
// ───────────────────────────────────────────────────────────────────
function option_selected_my($value, $selected, $text='', $event='') {
    if (!$text) $text = $value;
    if ($value == $selected)
        return "<option value=\"$value\" selected=\"selected\" $event>$text</option>\n";
    else
        return "<option value=\"$value\" $event>$text</option>\n";
}


// ───────────────────────────────────────────────────────────────────
//														멀티 셀렉트 옵션
// ───────────────────────────────────────────────────────────────────
function option_multiple_selected_my($value, $selected, $text='', $event='') {
    if(!$text) $text = $value;
	$selected = explode(",",$selected);
	$ckeck = false;
	for($k = 0; $k < count($selected); $k++) {
		if($value == $selected[$k]) $ckeck = true;
	}
	if($ckeck)
			 return "<option value=\"$value\" selected=\"selected\" $event>$text</option>\n";
		else
			return "<option value=\"$value\" $event>$text</option>\n";
}


// ───────────────────────────────────────────────────────────────────
//							멀티 채크박스 (,로 구분된 배열에서 특정값이 일치하면 ckecked 반환)
// ───────────────────────────────────────────────────────────────────
function checked_my($value, $option) {
	$allOption = explode(",",$value);
	$ckeck = false;
	for($k = 0; $k < count($allOption); $k++) {
		if($option == $allOption[$k]) $ckeck = true;
	}
	if($ckeck) return "checked";
}


// ───────────────────────────────────────────────────────────────────
//											옵션에서 개별옵션의 숫자값만 반환
// ───────────────────────────────────────────────────────────────────
function get_option_num($key, $allOption) {
	$num = '';
	if(strpos($allOption, $key) !== false) {
		$num = strstr($allOption, $key);
		$num = explode(',', $num);
		$num = preg_replace("/[^0-9]*/s", "", $num[0]); //숫자만 추출
	}
	return $num;
}


// ───────────────────────────────────────────────────────────────────
//														새로운 좋아요 채크
// ───────────────────────────────────────────────────────────────────
function get_new_good_cnt($bo_table, $wr_id) {
	global $g5, $board;	
	$bn_datetime = date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600));
	$new_good = sql_fetch(" SELECT COUNT(DISTINCT `bg_id`) AS `cnt` FROM {$g5['board_good_table']} WHERE  bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bg_datetime >= '{$bn_datetime}' and bg_flag = 'good' ");
	return $new_good['cnt'];
}
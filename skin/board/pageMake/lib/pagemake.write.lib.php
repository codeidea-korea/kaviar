<?php
if (!defined('_GNUBOARD_')) exit;

function get_gr_subject($gr_id) {
    global $g5;
    $sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
    $result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
        if ($gr_id == $row['gr_id']) $str .= $row['gr_subject'];
    }
    return $str;
}

// 생성된 게시판을 SELECT 형식으로 얻음
function get_bo_subject_select($name, $selected='', $event='', $group_id='') {
    global $g5, $board, $is_admin;
    $sql = " select gr_id, bo_table, bo_subject, bo_skin, bo_use_category, bo_use_tag from {$g5['board_table']} ";
	if($group_id) $sql .= " where gr_id = '{$group_id}' ";
	$sql .= " order by gr_id, bo_order ";	
    $result = sql_query($sql);
    $str = "<select id=\"$name\" name=\"$name\" $event data-live-search=\"true\">\n";
    for ($i=0; $row=sql_fetch_array($result); $i++) {		
		if(preg_match('#^theme/(.+)$#', $row['bo_skin'], $match)) {
            $bo_skin = $match[1];			
        } else if(preg_match('#^seperate/(.+)$#', $row['bo_skin'], $match)) {
            $bo_skin = $match[1];
        } else {
            $bo_skin = $row['bo_skin'];
		}
        if ($i == 0) $str .= "<option value=\"\" data-table-skin='0' data-use-cate='0' data-use-tag='0'>- 선택 없음 -</option>";		
		$except = false;
		// 제외할 테이블
		if(strpos($bo_skin, 'pageMake') !== false) $except = true;
		if(strpos($bo_skin, 'SQUARE') !== false) $except = true;
		if(strpos($bo_skin, 'PEOPLE-HUB') !== false) {
			$row['bo_use_category'] = '1';
			$row['bo_use_tag'] = '0';
		}
		if(!$except) {
			$is_order[$i] = $row['bo_use_category'] ? '<i class=\'cate\'></i>':'';
			$is_order[$i] .= $row['bo_use_tag'] ? '<i class=\'tag\'></i>':'';
			$str .= option_selected_my($row['bo_table'], $selected, $row['bo_subject'], 'data-content="<small>('.get_gr_subject($row['gr_id']).')</small> '.$row['bo_subject'].' <small>'.$row['bo_table'].'</small> '.$is_order[$i].'" data-table-skin="'.$bo_skin.'" data-use-cate="'.$row['bo_use_category'].'" data-use-tag="'.$row['bo_use_tag'].'" ');
		}		
    }
	if($is_admin == 'super') $str .= option_selected_my('SQUARE', $selected, 'SQUARE', ' data-content=\'<span class="skin_name square span200">SQUARE</span>\' data-table-skin="SQUARE" data-use-cate="0" data-use-tag="1" ');
    $str .= "</select>";
    return $str;
}

// 스킨디렉토리를 SELECT 형식으로 얻음
function get_latestSkin_select($skin_gubun, $id, $name, $selected='', $event='', $showImg=false, $layout){
    global $config;
    $skins = array();
    if(defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = get_skin_dir_my($skin_gubun, G5_THEME_PATH.'/'.G5_SKIN_DIR);
        if(!empty($dirs)) {
            foreach($dirs as $dir) {
                $skins[] = 'theme/'.$dir;
            }
        }
    }
	$this_dirs = get_skin_dir_my($skin_gubun, G5_THIS_PATH.'/'.G5_SKIN_DIR);
	if(!empty($this_dirs)) {
		foreach($this_dirs as $dir) {
			$skins[] = 'seperate/'.$dir; //해당사이트 전용
		}
	}
    $skins = array_merge($skins, get_skin_dir_my($skin_gubun));

    $str = "<select id=\"$id\" name=\"$name\" $event title=\"- 스킨을 선택해 주세요 -\">\n";
	//$str .= "<option value=\"\" checked>- 선택없음 -</option>\n";
    for ($i=0; $i<count($skins); $i++) {
        if(preg_match('#^theme/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
			$subtext[$i] = '@ ';
			$dataSubject = 'data-subtext=\'(테마)\'';
			$skin_path = G5_THEME_PATH.'/skin/'.$skin_gubun.'/'.$match[1];
			$skin_img_url = G5_THEME_URL.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';
			$skin_img_path = G5_THEME_PATH.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';
        } else if(preg_match('#^seperate/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
			$subtext[$i] = '+ ';
			$dataSubject = 'data-subtext=\'(전용)\'';
			$skin_path = G5_THIS_PATH.'/skin/'.$skin_gubun.'/'.$match[1];
			$skin_img_url = G5_THIS_URL.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';
			$skin_img_path = G5_THIS_PATH.'/skin/'.$skin_gubun.'/'.$match[1].'/thumb.png';
        } else {
            $text = $skins[$i];
			$dataSubject = '';
			$skin_path = G5_PATH.'/skin/'.$skin_gubun.'/'.$skins[$i];
			$skin_img_url = G5_URL.'/skin/'.$skin_gubun.'/'.$skins[$i].'/thumb.png';
			$skin_img_path = G5_PATH.'/skin/'.$skin_gubun.'/'.$skins[$i].'/thumb.png';
		}
		//if(file_exists($skin_path.'/latest.head.skin.php')) {
			//@include($skin_path.'/latest.head.skin.php');
		//}
		
		$except = false;
		if($layout == 'layout-bg') {
			if($skins[$i] != 'basic') $except = true;
		} else if($layout == 'layout-bigBanner') {
			if($skins[$i] != 'bigBanner') $except = true;
		} else {
			if($skins[$i] == 'bigBanner') $except = true;
		}

		if(!$except) {
			if($showImg && file_exists($skin_img_path)) {
				$str .= option_selected_my($skins[$i], $selected, $text, 'data-autothumb="'.$autoThumb.'" data-content=\'<img src="'.get_url($skin_img_url).'" alt="'.$text.'"><span class="skin_name">'.$subtext[$i].$text.'</span>\'');
			} else {
				$str .= option_selected_my($skins[$i], $selected, $text, $dataSubject);
			}
		}
    }
    $str .= "</select>";
    return $str;
}


$latestSkin = $write['wr_subject'];
if(preg_match('#^theme/(.+)$#', $write['wr_subject'], $match)) $latestSkin = $match[1];
if(preg_match('#^seperate/(.+)$#', $write['wr_subject'], $match)) $latestSkin = $match[1];
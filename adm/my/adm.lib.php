<?php
if (!defined('_GNUBOARD_')) exit;


// 회원권한을 SELECT 형식으로 얻음
function get_member_level_select_my($name, $start_id=0, $end_id=10, $selected="", $event="") {
    global $g5;
    $str = "\n<select id=\"{$name}\" name=\"{$name}\"";
    if ($event) $str .= " $event";
    $str .= ">\n";
    for ($i=$start_id; $i<=$end_id; $i++) {
		$option_level = $i == 0 ? '사용안함' : $i; //인태
        $str .= '<option value="'.$i.'"';
        if ($i == $selected)
            $str .= ' selected="selected"';
        $str .= ">{$option_level}</option>\n";
    }
    $str .= "</select>\n";
    return $str;
}


//그룹 여분필드 출력
function get_gr_1($gr_id) {
    global $g5, $is_admin, $member;
    $sql = " select gr_id, gr_1 from {$g5['group_table']} a order by a.gr_id ";
    $result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
        if ($gr_id == $row['gr_id']) $str .= $row['gr_1'];
    }
    return $str;
}


// 입력 폼 안내문
function my_help($help="", $p=false) {
	global $g5;
	if($p) {
		$str  = '<p class="my_help">'.$help.'</span>';
	} else {
		$str  = '<span class="my_help ml15">'.$help.'</span>';
	}
    return $str;
}


// 테마 (커뮤니티와 쇼핑몰 테마 구분)
function get_theme_dir_my($_theme_type = 'community') {

    $result_array = array();

    $dirname = G5_PATH.'/'.G5_THEME_DIR.'/';
    $handle = opendir($dirname);
	
	while ($file = readdir($handle)) {
		if($file == '.'||$file == '..'||strpos($file, '@') !== false) continue;
		if (is_dir($dirname.$file)) {
			$theme_path = $dirname.$file;
			$theme_type = '';
			include($theme_path.'/theme.config.php');
			if(is_file($theme_path.'/index.php') && is_file($theme_path.'/head.php') && is_file($theme_path.'/tail.php') && ($theme_type == $_theme_type || !$theme_type) )
				$result_array[] = $file;
		}
	}

    closedir($handle);
    natsort($result_array);

    return $result_array;
}



// 라이브 전,후 태그표시
function get_live_msg($start, $end) {
	
	$start_date = new DateTime($start);
	$end_date = new DateTime($end);
	$now = new DateTime();
	$dday = (strtotime($start) - strtotime(date("Y-m-d", time()))) / 86400;
	if($start_date > $now) {
		$live_msg = '<span class="_tag/gray/mini">라이브 '.$dday.'일 전</span>';
	} else if(($start_date < $now && $end_date > $now) || $end == '00-00-00 00:00') {
		$live_msg = '<span class="_tag/yellow/mini">라이브 중</span>';
	} else if($end_date < $now) {
		$live_msg = '<span class="_tag/gray/mini">종료</span>';
	}

    return $live_msg;
}





$shopCates = get_shop_category_array(true);

// 상품분류 option으로 얻기
function get_shopCate_option($val='', $multiple='') {
	global $g5, $is_admin;
	
	$shopCate_option = '';

	$sql = " select * from {$g5['g5_shop_category_table']} ";
	if ($is_admin != 'super') $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
	$sql .= " order by ca_order, ca_id ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		$len = strlen($row['ca_id']) / 2 - 1;

		$nbsp = "";
		for ($i=0; $i<$len; $i++)
			$nbsp .= "&nbsp;&nbsp;";
		
		$shopCate_option .= $multiple == 'multiple' ? option_multiple_selected_my($row['ca_id'], $val, $nbsp.$row['ca_name']) : option_selected($row['ca_id'], $val, $nbsp.$row['ca_name']);

	}

	return $shopCate_option;
}


// 상품 id로 분류명 얻기
function get_shopCate_name($ca_id='') {
	global $g5, $shopCates;
	
	$sql = sql_fetch("select ca_name from {$g5['g5_shop_category_table']} where ca_id = '$ca_id'");
	$shopCate_name = $sql['ca_name'];

	return $shopCate_name;
}






//상품 유형 추가
$itemtype = explode("|", $default['itemtype']);


// 회원등급을 SELECT 형식으로 얻음
function get_member_grade_select($name, $selected="", $ids = "", $event="")
{
    global $g5;

	$m = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$ids."' ");
	if($m['od_price'] > 0 ){
		$g = sql_fetch(" select * from `g5_member_grade` WHERE g_reward_start < '".$m['od_price']."' order by idx desc LIMIT 1 ");
	}else if( $m['od_price'] == NULL) {
		$g = sql_fetch(" select * from `g5_member_grade` WHERE g_reward_start <= 0 order by idx desc LIMIT 1 ");
	}

    $sql = " select * from `g5_member_grade` where idx > 1 ";
    $result = sql_query($sql);
    $str = '<select id="'.$name.'" name="'.$name.'">';
    for ($i=2; $row=sql_fetch_array($result); $i++)
    {
        $str .= '<option value="'.$row['idx'].'"';
		if($i>1 && $i<=5){
			if($g['idx'] != $i) $str.= ' disabled ';
		}
        if ($row['idx'] == $selected) $str .= ' selected';
        $str .= '>'.$row['g_name'].'</option>';
    }
    $str .= '</select>';
    return $str;
}


// 회원등급을 name 형식으로 얻음
function get_member_grade_name($name, $selected="", $event="")
{
    global $g5;

    $sql = sql_fetch(" select * from `g5_member_grade` where idx = $name");
    return $sql['g_name'];
}
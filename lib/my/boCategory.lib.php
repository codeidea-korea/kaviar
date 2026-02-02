<?php
if (!defined('_GNUBOARD_')) exit;

//게시판 카테고리 스킨 - 인태
function boCategory($skin_dir='', $bo_table, $all=true){
	global $g5, $board, $sca, $bo_cate_skin, $is_admin, $css, $_adm_url;

	if (!$skin_dir) $skin_dir = 'basic';

	if(G5_IS_MOBILE) {
		$bo_cate_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/_boCategory/'.$skin_dir;
		if(!is_dir($bo_cate_skin_path)) $bo_cate_skin_path = G5_SKIN_PATH.'/_boCategory/'.$skin_dir;
	} else {
		$bo_cate_skin_path = G5_SKIN_PATH.'/_boCategory/'.$skin_dir;
	}
	$bo_cate_skin_url = str_replace(G5_PATH, G5_URL, $bo_cate_skin_path);

	$width = $board['bo_table_width'];
	$width .= $width <= 100 ? '%' : 'px';
	$cateStyle = '';
	if($board['bo_cate_color']) $cateStyle .= '.boCateContainer{--bo-cate-color:'.$board['bo_cate_color'].';}';
	
	$bo_category_list = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
	$bo_category_href = G5_BBS_URL.'/board.php?bo_table='.$bo_table;
	
	$totalOn = $sca=='' ? 'active' : '';

	if($board['bo_cate_all_hidden']) $all=false;

	if($is_admin) $boCateSettting = '<a href="'.$_adm_url.'/?pn=_bo_cate_setting&bo_table='.$bo_table.'&title=카테고리 편집" class="btnSetting popWin" data-width="1150" data-height="400" data-top="0" data-left="0" data-area=".boCateContainer">카테고리 편집</a>';

	for ($i=0; $i<count($bo_category_list); $i++) {
		$ca_name[$i] = trim($bo_category_list[$i]);
		$ca_link[$i] = $bo_category_href."&amp;sca=".urlencode($ca_name[$i]);
		// 카테고리 하위 게시물 카운트
		/*$row[$i] = sql_fetch(" select count(*) as cnt from ".$g5['write_prefix'].$bo_table." where wr_is_comment = 0 and ca_name = '{$ca_name[$i]}'");
		$cateCount[$i] = '<span class="cateCount">'.$row[$i]['cnt'].'</span>'; //카테고리 카운트*/
		$cate_preg[$i] = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", "", $ca_name[$i]);
		$cateOn[$i] = $cate_preg[$i]==$sca ? 'active' : '';
	}
	
	ob_start();
	include $bo_cate_skin_path.'/category.skin.php';
	$content = '<div id="bo_cate">';
	if($cateStyle) $content .= '<style>'.$cateStyle.'</style>';
	$content .= ob_get_contents();
	if($cateScript) $content .= '<script>'.$cateScript.'</script>';
	$content .= '</div>';
	ob_end_clean();
	return $content;
}

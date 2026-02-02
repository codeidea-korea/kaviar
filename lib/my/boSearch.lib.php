<?php
if (!defined('_GNUBOARD_')) exit;

//게시판 카테고리 스킨 - 인태
function boSearch($skin_dir='', $bo_table, $search_holder=''){
	global $g5, $board, $sca, $stx, $is_admin, $css, $_adm_url;
	
	//if(G5_IS_MOBILE) return false;

	if(!$skin_dir || G5_IS_MOBILE) $skin_dir = 'basic';
	
	if(!$search_holder) $search_holder = '검색어를 입력해 주세요.';
	
	if(G5_IS_MOBILE) {
		$bo_search_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/_boSearch/'.$skin_dir;
		if(!is_dir($bo_search_skin_path)) $bo_search_skin_path = G5_SKIN_PATH.'/_boSearch/'.$skin_dir;
	} else {
		$bo_search_skin_path = G5_SKIN_PATH.'/_boSearch/'.$skin_dir;
	}
	$bo_search_skin_url = str_replace(G5_PATH, G5_URL, $bo_search_skin_path);
	
	$bo_search_sfl = str_replace(",", "||", $board['bo_search_sfl']);

	if(!$bo_search_sfl) $bo_search_sfl = 'wr_subject';

	$search_sfl = '<input type="hidden" name="sfl" value="'.$bo_search_sfl.'">';

	if($is_admin && !G5_IS_MOBILE) $boSearchSettting = '<a href="'.$_adm_url.'/?pn=_bo_search_setting&bo_table='.$bo_table.'&title=검색바 편집" class="btnSetting popWin" data-width="1150" data-height="400" data-top="0" data-left="0" data-area="#bo_sch > *">검색바 편집</a>';
	
	ob_start();	
	$content = '<fieldset id="bo_sch" class="'.$board['bo_skin'].' '.($skin_dir=='floating'?'fixed-top':'').'">';
	include $bo_search_skin_path.'/searchbar.skin.php';	
	if($searchbarStyle) $content .= '<style>'.$searchbarStyle.'</style>';
	if($searchbarScript) $content .= '<script>'.$searchbarScript.'</script>';
	$content .= ob_get_contents();	
	$content .= '</fieldset>';
	ob_end_clean();
	return $content;
}

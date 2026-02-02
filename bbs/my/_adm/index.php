<?php
include_once('./_common.php');
if ($is_admin != 'super') {
	echo '<script>window.close();</script>';
	exit;
}
if (!$is_admin) alert('관리자만 접근 가능합니다.');


$_adm_url = G5_BBS_URL.'/my/_adm';
$_adm_path = G5_BBS_PATH.'/my/_adm';
$_adm_inc_path = file_exists(G5_THEME_PATH.'/_adm/'.$pn.'.php') ? G5_THEME_PATH.'/_adm' : G5_BBS_PATH.'/my/_adm';
$_adm_update_url = $_adm_inc_url = file_exists(G5_THEME_PATH.'/_adm/'.$pn.'.php') ? G5_THEME_URL.'/_adm' : $_adm_url;
$_adm_theme = file_exists(G5_THEME_PATH.'/_adm/'.$pn.'.php') ? '<span class="_tag/mini ml5" style="position:relative;top:-2px;--tag-height:16px !important;">theme</span>' : '';
$callback_url = $_adm_url.'/';
$callback_url .= $_SERVER[ "QUERY_STRING" ] ? '?'.$_SERVER[ "QUERY_STRING" ] : '';

if(!$title) {
	$title = G5_IS_MOBILE ? '모바일 관리' : '사이트 관리';
	if($theme_type=='shop' || !defined('G5_COMMUNITY_USE')) $title = '쇼핑몰 사이트 관리';
}
$form_title_sub = '';
if($bo_table) $form_title_sub = '<sub class="label">'.$board['bo_table'].'</sub>';

include_once(G5_BBS_PATH.'/my/_adm/_adm.head.php');

// 파일체크
switch($pn) {
	default									: $adm_file = $_adm_inc_path.'/'.$pn.'.php'; break;
	//case 'quicknews'					: $adm_file = G5_SKIN_PATH.'/quick/quickNews/_setting.php'; break;
}

if(file_exists(G5_THEME_PATH.'/_adm/index.php')) {
	require_once(G5_THEME_PATH.'/_adm/index.php');
    return;
}

$_formClass = '';
if(strpos($pn, '_board_form') !== false) $_formClass = ' _board_form';
if(strpos($pn, '_write_') !== false) {
	$_formClass = ' _write_form';
	$adm_file = $_adm_inc_path.'/_write_form.php';
}
if($pn == '_list_bundle') $_formClass = ' _bundle_list_form';
?>

<div class="_popup_form <?=$pn?><?=$_formClass?>"<?php if($board['bo_skin']) echo ' data-skin="'.$board['bo_skin'].'"';?>>
	<?php
	if($title) echo '<h1 id="form-title">'.$title.$form_title_sub.$_adm_theme.'</h1>';
	if($tab) include_once($_adm_path.'/_adm_tabs.php');
	include_once($adm_file);
	?>
</div>

<script>
function _adm_form_submit(f){
    return true;
}
</script>

</body>
</html>
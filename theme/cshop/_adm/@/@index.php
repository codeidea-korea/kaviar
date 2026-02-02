<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$_adm_url = G5_BBS_URL.'/my/_adm';
$_adm_inc_path = G5_THEME_PATH.'/_adm';
$_adm_update_url = G5_THEME_URL.'/_adm';
$callback_url = $_adm_url.'/';
$callback_url .= $_SERVER[ "QUERY_STRING" ] ? '?'.$_SERVER[ "QUERY_STRING" ] : '';
if(strpos($pn, '_shop_index') !== false) {
	$_adm_inc_path = G5_BBS_PATH.'/my/_adm';
	$_adm_update_url = G5_BBS_URL.'/my/_adm';
}

// 파일체크
switch($pn) {
	default									: $adm_file = $_adm_inc_path.'/'.$pn.'.php'; break;
	case 'group_quicknews'			: $adm_file = G5_SKIN_PATH.'/quick/quickNews/_group_setting.php'; break;
}
?>

<div class="_popup_form<?=$pn=='_shop_index_form'?' _write_form':''?>">
	<?php if($title) echo '<h1 id="form-title">'.$title.'</h1>'; ?>
	<?php if($pn=='_shop_header_setting' || $pn=='_itemtype_setting') { ?>
	<div class="box-tabs-container">
		<div class="tabs-group">
			<a href="<?=$_adm_url?>/?pn=_shop_header_setting&title=쇼핑몰 헤더관리" class="tab <?=$pn=='_shop_header_setting'?'active':''?>">헤더관리</a>			
		</div>
		<div class="tabs-group">
			<a href="<?=$_adm_url?>/?pn=_itemtype_setting&title=상품유형 설정" class="tab <?=$pn=='_itemtype_setting'?'active':''?>">상품유형</a>
		</div>
	</div>
	<?php } ?>
	<?php include_once($adm_file); ?>
</div>

<script>
function _adm_form_submit(f){
    return true;
}
</script>

</body>
</html>
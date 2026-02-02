<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if ($is_admin != 'super') {
	echo '<script>window.close();</script>';
	exit;
}

//상시 열림메뉴 설정 추가
if(!isset($config['cf_open_menu'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_open_menu` VARCHAR(255) NOT NULL DEFAULT '' ", true);
}
function get_open_menu_multiple_select($name, $selected='', $event='') {
	global $g5;
	
	$sql= " select * from {$g5['menu_table']} where LENGTH(me_code) = '2'  and me_name !='' order by `me_order`  ";
	$result = sql_query($sql);

	$str = "<select id=\"$name\" name=\"$name\" multiple $event>\n";
	for ($i=0; $row=sql_fetch_array($result); $i++) {		
		$str .= option_multiple_selected_my($row['me_name'], $selected, $row['me_name']);	
	}
	$str .= "</select>";
	return $str;
}
?>

<?php if(file_exists(G5_THEME_PATH.'/_adm/_side_header_setting.php') || G5_IS_MOBILE) { ?>
<div class="mybox blue" style="margin-bottom:15px">
<form name="fmenu_default_open" id="fmenu_default_open" method="post" action="<?=G5_ADMIN_URL?>/my/menu_default_open_update.php">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
	<div style="display:flex;align-items:center;">
		<b class="mr20">상시 열림 메뉴</b>
		<?=get_open_menu_multiple_select('cf_open_menu[]', $config['cf_open_menu'], 'class="selectpicker" title="상시열림으로 설정할 메뉴를 선택하세요." ')?>
		<button type="submit" name="button" value="확인" class="_btn/sm/rd3 fs12 ml5">저장</button>
	</div>
</form>
</div>
<?php } ?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_adm_mainmenu_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
<section class="">
	<?php include_once(G5_ADMIN_PATH.'/my/menu.php') ?>
	<div class="bo_btnSet">
		<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
	</div>
</section>	
</form>


<?php if(file_exists(G5_THEME_PATH.'/_adm/_side_header_setting.php')) { ?>
<script>
setTimeout(function() {
	opener.$('.leftSecOpener').click();
}, 1200 );
</script>
<?php } ?>


<?php if(G5_IS_MOBILE) { ?>
<script>
setTimeout(function() {
	opener.$('#header .menuOpener').click();
}, 800 );
</script>
<?php } ?>
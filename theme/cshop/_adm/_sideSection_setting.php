<?php
//상시 열림메뉴 설정 추가
/*if(!isset($config['cf_open_menu'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_open_menu` VARCHAR(255) NOT NULL DEFAULT '' ", true);
}*/
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

$side_header_color = explode("|",$header['side_header_color']);
$side_header_color[0] = $side_header_color[0] ? $side_header_color[0] : 'rgba(92,199,185,1)';
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_sideSection_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="header_sideSection" class="mybox blue">	
	<div class="formContainer label160">
		<!--<div class="form-list">
			<div class="form-label"><label>커버 배경색</label></div>
			<div class="formCon">
				<input type="text" name="side_header_color[0]" value="<?=get_text($side_header_color[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
			</div>
		</div>-->
		<div class="form-list">
			<div class="form-label"><label>커버 배경이미지</label></div>
			<div class="formCon">
				<?php
				$cover_img_path = G5_DATA_PATH.'/shop/sideSection_cover_img.png';
				$cover_img_url = G5_DATA_URL.'/shop/sideSection_cover_img.png';
				$upImg_cover_img = file_exists($cover_img_path) ? '<img src="'.get_url($cover_img_url).'"><label class="del"><input type="checkbox" name="del_cover_img" value="1"><span></span>삭제</label>' : '';
				echo '<input type="file" name="cover_img" class="myfile">';
				echo '<div class="upImg">'.$upImg_cover_img.'</div>';
				?>
			</div>
		</div>
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>
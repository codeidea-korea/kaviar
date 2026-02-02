<?php
include_once('./_common.php');

$logo_path = G5_DATA_PATH.'/logo';
if(!is_dir($logo_path)){
	@mkdir($logo_path, G5_DIR_PERMISSION);
	@chmod($logo_path, G5_DIR_PERMISSION);
}

$image_regex = "/(\.(gif|jpg|png|ico))$/i";
$icon_regex = "/(\.(ico|png))$/i";

//아이콘 삭제
if($del_logo_mobile_c) @unlink(G5_DATA_PATH.'/logo/logo_mobile_c.png');
if($del_logo_mobile_w) @unlink(G5_DATA_PATH.'/logo/logo_mobile_w.png');


//모바일로고(컬러)
if(is_uploaded_file($_FILES['logo_mobile_c']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['logo_mobile_c']['name']))
		alert($_FILES['logo_mobile_c']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['logo_mobile_c']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/logo_mobile_c.png';
		move_uploaded_file($_FILES['logo_mobile_c']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
//모바일로고(흰색)
if(is_uploaded_file($_FILES['logo_mobile_w']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['logo_mobile_w']['name']))
		alert($_FILES['logo_mobile_w']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['logo_mobile_w']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/logo_mobile_w.png';
		move_uploaded_file($_FILES['logo_mobile_w']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}


$cfm_top_bg = implode("|", $_POST['cfm_top_bg']);
$cfm_menu_color = implode("|", $_POST['cfm_menu_color']);

$sql = " update {$g5['config_mobile_table']} set
				 cfm_top_bg = '{$cfm_top_bg}' ";
sql_query($sql);


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
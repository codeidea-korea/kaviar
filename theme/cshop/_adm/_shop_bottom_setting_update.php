<?php
include_once('./_common.php');


$shop_bottom_color = implode("|", $_POST['shop_bottom_color']);
$shop_bottom_tabs_name = implode("|", $_POST['shop_bottom_tabs_name']);

$sql = " update {$g5['g5_shop_default_table']}
            set shop_bottom_tabs_scrollhidden			= '{$_POST['shop_bottom_tabs_scrollhidden']}',
				 shop_bottom_color							= '{$shop_bottom_color}',
				 shop_bottom_tabs_name					= '{$shop_bottom_tabs_name}',
				 shop_bottom_use_home					= '{$shop_bottom_use_home}',
				 shop_bottom_use_gnb						= '{$shop_bottom_use_gnb}',
				 shop_bottom_use_search					= '{$shop_bottom_use_search}',
				 shop_bottom_use_member				= '{$shop_bottom_use_member}',
				 shop_bottom_use_store						= '{$shop_bottom_use_store}'
			";
sql_query($sql);


$shop_icon_path = G5_DATA_PATH.'/shop_icon';
if(!is_dir($shop_icon_path)){
	@mkdir($shop_icon_path, G5_DIR_PERMISSION);
	@chmod($shop_icon_path, G5_DIR_PERMISSION);
}

//$icon_regex = "/(\.(jpg|png|svg))$/i";
$icon_regex = "/(\.(svg))$/i";


//아이콘 삭제
if($del_shop_bottom_home) @unlink($shop_icon_path.'/shop_bottom_home.svg');
if($del_shop_bottom_gnb) @unlink($shop_icon_path.'/shop_bottom_gnb.svg');
if($del_shop_bottom_search) @unlink($shop_icon_path.'/shop_bottom_search.svg');
if($del_shop_bottom_store) @unlink($shop_icon_path.'/shop_bottom_store.svg');
if($del_shop_bottom_member) @unlink($shop_icon_path.'/shop_bottom_member.svg');


// 아이콘 업로드
if(is_uploaded_file($_FILES['shop_bottom_home']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_home']['name']))
		alert($_FILES['shop_bottom_home']['name'] . '은(는) svg 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_home']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_home.svg';
		move_uploaded_file($_FILES['shop_bottom_home']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_gnb']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_gnb']['name']))
		alert($_FILES['shop_bottom_gnb']['name'] . '은(는) svg 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_gnb']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_gnb.svg';
		move_uploaded_file($_FILES['shop_bottom_gnb']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_search']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_search']['name']))
		alert($_FILES['shop_bottom_search']['name'] . '은(는) svg 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_search']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_search.svg';
		move_uploaded_file($_FILES['shop_bottom_search']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_store']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_store']['name']))
		alert($_FILES['shop_bottom_store']['name'] . '은(는) svg 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_store']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_store.svg';
		move_uploaded_file($_FILES['shop_bottom_store']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_member']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_member']['name']))
		alert($_FILES['shop_bottom_member']['name'] . '은(는) svg 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_member']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_member.svg';
		move_uploaded_file($_FILES['shop_bottom_member']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}







echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
<?php
include_once('./_common.php');


// 대표이미지 업로드&삭제----------------------------------------------------
$image_regex = "/(\.(gif|jpg|png|ico))$/i";

//대표이미지 삭제
if($del_sitemain_img) @unlink(G5_DATA_PATH.'/file/site_main.png');


//대표이미지 업로드
if(is_uploaded_file($_FILES['site_main']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['site_main']['name']))
		alert($_FILES['site_main']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['site_main']['name'])) {
		$dest_path = G5_DATA_PATH.'/file/site_main.png';
		move_uploaded_file($_FILES['site_main']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}


$logo_path = G5_DATA_PATH.'/logo';
if(!is_dir($logo_path)){
	@mkdir($logo_path, G5_DIR_PERMISSION);
	@chmod($logo_path, G5_DIR_PERMISSION);
}

//북마트 & 앱이미지 삭제
if($del_favorite)	@unlink(G5_DATA_PATH.'/logo/favorite.ico');
if($del_favorite_mobile) @unlink(G5_DATA_PATH.'/logo/favorite_mobile.png');

// 즐겨찾기아이콘(PC) 48x48
if(is_uploaded_file($_FILES['favorite']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['favorite']['name']))
		alert($_FILES['favorite']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['favorite']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/favorite.ico';
		move_uploaded_file($_FILES['favorite']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			if ($size[0] > 48 || $size[1] > 48) @unlink($dest_path); // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
		}
	}
}
// 모바일 즐겨찾기 이미지(mobile) 114x114
if(is_uploaded_file($_FILES['favorite_mobile']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['favorite_mobile']['name']))
		alert($_FILES['favorite_mobile']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['favorite_mobile']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/favorite_mobile.png';
		move_uploaded_file($_FILES['favorite_mobile']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

$sql = " update {$g5['config_table']} set
			cf_title			= '{$_POST['cf_title']}',
			cf_use_login	= '{$_POST['cf_use_login']}',
			cf_use_join	= '{$_POST['cf_use_join']}',
			cf_search_keyword = '{$_POST['cf_search_keyword']}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
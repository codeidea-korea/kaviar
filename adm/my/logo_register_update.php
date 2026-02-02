<?php
$sub_menu = "110300";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

//테마별도
if(file_exists(G5_THEME_PATH.'/adm/_logo_register_update.php')) {
	require_once(G5_THEME_PATH.'/adm/_logo_register_update.php');
    return;
}

$logo_path = G5_DATA_PATH.'/logo';
if(!is_dir($logo_path)){
	@mkdir($logo_path, G5_DIR_PERMISSION);
	@chmod($logo_path, G5_DIR_PERMISSION);
}

$image_regex = "/(\.(gif|jpg|png|ico))$/i";
$icon_regex = "/(\.(ico|png))$/i";

//아이콘 삭제
if($del_logo_c) @unlink(G5_DATA_PATH.'/logo/logo_c.png');
if($del_logo_w) @unlink(G5_DATA_PATH.'/logo/logo_w.png');
if($del_logo_mobile_c) @unlink(G5_DATA_PATH.'/logo/logo_mobile_c.png');
if($del_logo_mobile_w) @unlink(G5_DATA_PATH.'/logo/logo_mobile_w.png');
if($del_favorite)	@unlink(G5_DATA_PATH.'/logo/favorite.ico');
if($del_favorite_mobile) @unlink(G5_DATA_PATH.'/logo/favorite_mobile.png');


//로고업로드(컬러)
if(is_uploaded_file($_FILES['logo_c']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['logo_c']['name']))
		alert($_FILES['logo_c']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['logo_c']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/logo_c.png';
		move_uploaded_file($_FILES['logo_c']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
//로고업로드(흰색)
if(is_uploaded_file($_FILES['logo_w']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['logo_w']['name']))
		alert($_FILES['logo_w']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['logo_w']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/logo_w.png';
		move_uploaded_file($_FILES['logo_w']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
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

goto_url(G5_ADMIN_URL.'/my/logo_register.php');
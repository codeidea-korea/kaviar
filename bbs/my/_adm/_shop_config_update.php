<?php
include_once('./_common.php');


$logo_path = G5_DATA_PATH.'/logo';
if(!is_dir($logo_path)){
	@mkdir($logo_path, G5_DIR_PERMISSION);
	@chmod($logo_path, G5_DIR_PERMISSION);
}

$image_regex = "/(\.(gif|jpg|png|ico))$/i";
$icon_regex = "/(\.(ico|png))$/i";


//이미지 삭제
if($del_shop_logo_c) @unlink($logo_path.'/shop_logo_c.png');
if($del_shop_logo_w) @unlink($logo_path.'/shop_logo_w.png');
if($del_sitemain_img) @unlink(G5_DATA_PATH.'/file/shop_main.png');
if($del_shop_favorite)	@unlink($logo_path.'/shop_favorite.ico');
if($del_shop_favorite_mobile) @unlink($logo_path.'/shop_favorite_mobile.png');


// 쇼핑몰 로고 업로드
if(is_uploaded_file($_FILES['shop_logo_c']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo_c']['name']))
		alert($_FILES['shop_logo_c']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo_c']['name'])) {
		$dest_path = $logo_path.'/shop_logo_c.png';
		move_uploaded_file($_FILES['shop_logo_c']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
// 쇼핑몰 로고 업로드(흰색)
if(is_uploaded_file($_FILES['shop_logo_w']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo_w']['name']))
		alert($_FILES['shop_logo_w']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo_w']['name'])) {
		$dest_path = $logo_path.'/shop_logo_w.png';
		move_uploaded_file($_FILES['shop_logo_w']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

//대표이미지 업로드
if(is_uploaded_file($_FILES['shop_main']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_main']['name']))
		alert($_FILES['shop_main']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_main']['name'])) {
		$dest_path = G5_DATA_PATH.'/file/shop_main.png';
		move_uploaded_file($_FILES['shop_main']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

// 쇼핑몰 즐겨찾기아이콘(PC) 48x48
if(is_uploaded_file($_FILES['shop_favorite']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_favorite']['name']))
		alert($_FILES['shop_favorite']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_favorite']['name'])) {
		$dest_path = $logo_path.'/shop_favorite.ico';
		move_uploaded_file($_FILES['shop_favorite']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			if ($size[0] > 48 || $size[1] > 48) @unlink($dest_path); // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
		}
	}
}

// 쇼핑몰 모바일 앱 이미지(mobile) 114x114
if(is_uploaded_file($_FILES['shop_favorite_mobile']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_favorite_mobile']['name']))
		alert($_FILES['shop_favorite_mobile']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_favorite_mobile']['name'])) {
		$dest_path = $logo_path.'/shop_favorite_mobile.png';
		move_uploaded_file($_FILES['shop_favorite_mobile']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

$de_listtype_card_width = isset($_POST['de_listtype_card_width']) ? (int)$_POST['de_listtype_card_width'] : 0;
if($de_listtype_card_width < 0) $de_listtype_card_width = 0;

if(!isset($default['de_listtype_card_width'])) {
	sql_query(" ALTER TABLE {$g5['g5_shop_default_table']} ADD `de_listtype_card_width` int(11) NOT NULL DEFAULT '0' ", false);
}

$sql = " update {$g5['config_table']} set
			cf_title = '{$_POST['cf_title']}' ";
sql_query($sql);

$sql = " update {$g5['g5_shop_default_table']} set
			de_listtype_card_width = '{$de_listtype_card_width}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";

<?php
include_once('./_common.php');

/*
$shop_header_ui = implode("|", $_POST['shop_header_ui']);

$shop_header_color = implode("|", $_POST['shop_header_color']);

$sql = " update {$g5['g5_shop_default_table']}
            set shop_header_ui				= '{$shop_header_ui}',
				 shop_header_scrollhidden	= '{$shop_header_scrollhidden}',
				 shop_header_color			= '{$shop_header_color}',
				 shop_header_use_store		= '{$shop_header_use_store}'				 
				 ";
sql_query($sql);
*/


$sql = " update {$g5['g5_shop_default_table']}
            set shop_header_width			= '{$_POST['shop_header_width']}'
			";
sql_query($sql);


//로고
if($del_shop_logo_c) @unlink(G5_DATA_PATH.'/logo/shop_logo_c.png');
if($del_shop_logo_w) @unlink(G5_DATA_PATH.'/logo/shop_logo_w.png');
if($del_shop_logo_mobile) @unlink(G5_DATA_PATH.'/logo/shop_logo_mobile.png');

$image_regex = "/(\.(gif|jpg|png|ico))$/i";

//쇼핑몰 로고 업로드
if(is_uploaded_file($_FILES['shop_logo_c']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo_c']['name']))
		alert($_FILES['shop_logo_c']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo_c']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/shop_logo_c.png';
		move_uploaded_file($_FILES['shop_logo_c']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

//쇼핑몰 로고(흰색) 업로드
if(is_uploaded_file($_FILES['shop_logo_w']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo_w']['name']))
		alert($_FILES['shop_logo_w']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo_w']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/shop_logo_w.png';
		move_uploaded_file($_FILES['shop_logo_w']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

//쇼핑몰 로고(모바일) 업로드
if(is_uploaded_file($_FILES['shop_logo_mobile']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo_mobile']['name']))
		alert($_FILES['shop_logo_mobile']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo_mobile']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/shop_logo_mobile.png';
		move_uploaded_file($_FILES['shop_logo_mobile']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

// 쇼핑몰 즐겨찾기아이콘(PC) 48x48
if($del_shop_favorite) @unlink(G5_DATA_PATH.'/logo/shop_favorite.png');
if(is_uploaded_file($_FILES['shop_favorite']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_favorite']['name']))
		alert($_FILES['shop_favorite']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_favorite']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/shop_favorite.ico';
		move_uploaded_file($_FILES['shop_favorite']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
		if (file_exists($dest_path)) {
			$size = getimagesize($dest_path);
			if ($size[0] > 48 || $size[1] > 48) @unlink($dest_path); // 아이콘의 폭 또는 높이가 설정값 보다 크다면 이미 업로드 된 아이콘 삭제
		}
	}
}





// 쇼핑몰 상단 메뉴 --------------------------------------------------------------
// 이전 메뉴정보 삭제
$sql = " delete from {$g5['g5_shop_top_menu_table']} ";
sql_query($sql);

$count = isset($_POST['shopmenu_order']) ? count($_POST['shopmenu_order']) : 0;

for ($i=0; $i<$count; $i++) {
    $_POST = array_map_deep('trim', $_POST);	
	
	$shopmenu_order[$i] = $_POST['shopmenu_order'][$i] ? $_POST['shopmenu_order'][$i] : '0';
	$shopmenu[$i] = $_POST['shopmenu'][$i];
	$shopmenu_name[$i] = preg_replace('/\r\n|\r|\n/','',$_POST['shopmenu_name'][$i]);
	$shopmenu_link[$i] = $_POST['shopmenu_link'][$i] ? $_POST['shopmenu_link'][$i] : '#';
	$shopmenu_link_option[$i] = !$shopmenu[$i] && $_POST['shopmenu_link_option'][$i] ? $_POST['shopmenu_link_option'][$i] : '';
	if($shopmenu[$i] == '_board') $shopmenu_link[$i] = $_POST['shopmenu_link_board'][$i];

	
    if(!$shopmenu && !$shopmenu_name)
        continue;

    // 메뉴 등록
    $sql = " insert into {$g5['g5_shop_top_menu_table']} 
                set shopmenu_order		= '{$shopmenu_order[$i]}',
					 shopmenu					= '{$shopmenu[$i]}',
					 shopmenu_name		= '{$shopmenu_name[$i]}',
					 shopmenu_link			= '{$shopmenu_link[$i]}',
					 shopmenu_link_option			= '{$shopmenu_link_option[$i]}' ";
    sql_query($sql);
}


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
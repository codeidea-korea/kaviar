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
if($del_shop_logo) @unlink(G5_DATA_PATH.'/logo/shop_logo.png');

//쇼핑몰 로고 업로드
if(is_uploaded_file($_FILES['shop_logo']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_logo']['name']))
		alert($_FILES['shop_logo']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_logo']['name'])) {
		$dest_path = G5_DATA_PATH.'/logo/shop_logo.png';
		move_uploaded_file($_FILES['shop_logo']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

$shop_header_color = implode("|", $_POST['shop_header_color']);

$sql = " update {$g5['g5_shop_default_table']}
            set shop_header_color	= '{$shop_header_color}' ";
sql_query($sql);


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

	
    if(!$shopmenu && !$shopmenu_name)
        continue;

    // 메뉴 등록
    $sql = " insert into {$g5['g5_shop_top_menu_table']} 
                set shopmenu_order		= '{$shopmenu_order[$i]}',
					 shopmenu					= '{$shopmenu[$i]}',
					 shopmenu_name		= '{$shopmenu_name[$i]}',
					 shopmenu_link			= '{$shopmenu_link[$i]}' ";
    sql_query($sql);
}


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
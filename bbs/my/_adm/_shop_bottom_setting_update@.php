<?php
include_once('./_common.php');


$shop_bottom_color = implode("|", $_POST['shop_bottom_color']);
$shop_bottom_tabs_name = implode("|", $_POST['shop_bottom_tabs_name']);

$sql = " update {$g5['g5_shop_default_table']}
            set shop_bottom_tabs_scrollhidden			= '{$_POST['shop_bottom_tabs_scrollhidden']}',
				 shop_bottom_color							= '{$shop_bottom_color}',
				 shop_bottom_tabs_name					= '{$shop_bottom_tabs_name}'
			";
sql_query($sql);


$shop_icon_path = G5_DATA_PATH.'/shop_icon';
if(!is_dir($shop_icon_path)){
	@mkdir($shop_icon_path, G5_DIR_PERMISSION);
	@chmod($shop_icon_path, G5_DIR_PERMISSION);
}

$icon_regex = "/(\.(jpg|png|svg))$/i";


//아이콘 삭제
if($del_shop_bottom_tab1)	@unlink($shop_icon_path.'/shop_bottom_tab1.png');
if($del_shop_bottom_tab2)	@unlink($shop_icon_path.'/shop_bottom_tab2.png');
if($del_shop_bottom_tab3)	@unlink($shop_icon_path.'/shop_bottom_tab3.png');
if($del_shop_bottom_tab4)	@unlink($shop_icon_path.'/shop_bottom_tab4.png');


// 아이콘 업로드
if(is_uploaded_file($_FILES['shop_bottom_tab1']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_tab1']['name']))
		alert($_FILES['shop_bottom_tab1']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_tab1']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_tab1.png';
		move_uploaded_file($_FILES['shop_bottom_tab1']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_tab2']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_tab2']['name']))
		alert($_FILES['shop_bottom_tab2']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_tab2']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_tab2.png';
		move_uploaded_file($_FILES['shop_bottom_tab2']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_tab3']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_tab3']['name']))
		alert($_FILES['shop_bottom_tab3']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_tab3']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_tab3.png';
		move_uploaded_file($_FILES['shop_bottom_tab3']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
if(is_uploaded_file($_FILES['shop_bottom_tab4']['tmp_name'])) {
	if (!preg_match($icon_regex, $_FILES['shop_bottom_tab4']['name']))
		alert($_FILES['shop_bottom_tab4']['name'] . '은(는) 아이콘 파일이 아닙니다.');
	if (preg_match($icon_regex, $_FILES['shop_bottom_tab4']['name'])) {
		$dest_path = $shop_icon_path.'/shop_bottom_tab4.png';
		move_uploaded_file($_FILES['shop_bottom_tab4']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}







echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
<?php
include_once('./_common.php');


$sql = " update {$g5['g5_shop_default_table']}
            set shop_layout			= '{$_POST['shop_layout']}',
				 shop_slogan			= '{$_POST['shop_slogan']}' ";
sql_query($sql);

$sql = " update {$g5['config_table']} set
			cf_search_keyword				= '{$_POST['cf_search_keyword']}',
			cf_use_search_keyword		= '{$_POST['cf_use_search_keyword']}' ";
sql_query($sql);


//인텍스 배경이미지
$shop_path = G5_DATA_PATH.'/shop';
if(!is_dir($shop_path)){
	@mkdir($shop_path, G5_DIR_PERMISSION);
	@chmod($shop_path, G5_DIR_PERMISSION);
}

if($del_sitemain_bg) @unlink(G5_DATA_PATH.'/shop/shop_main_bg.png');

$image_regex = "/(\.(gif|jpg|png|ico))$/i";

//쇼핑몰 로고 업로드
if(is_uploaded_file($_FILES['shop_main_bg']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['shop_main_bg']['name']))
		alert($_FILES['shop_main_bg']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['shop_main_bg']['name'])) {
		$dest_path = G5_DATA_PATH.'/shop/shop_main_bg.png';
		move_uploaded_file($_FILES['shop_main_bg']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}



if(strpos($callback_url, 'tab=1') !== false) {
	echo "<script>
	opener.document.location.reload();
	location.href='".$callback_url."';
	</script>";
} else {
	echo "<script>
	opener.document.location.reload();
	window.close();
	</script>";
}
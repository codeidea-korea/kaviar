<?php
include_once('./_common.php');

/*$side_header_color = implode("|",$_POST['side_header_color']);

$sql = " update {$g5['header_table']} set 
				side_header_color = '{$side_header_color}'
				";
sql_query($sql);*/

$shop_path = G5_DATA_PATH.'/shop';
if(!is_dir($shop_path)){
	@mkdir($shop_path, G5_DIR_PERMISSION);
	@chmod($shop_path, G5_DIR_PERMISSION);
}

$image_regex = "/(\.(gif|jpg|png|ico))$/i";
$icon_regex = "/(\.(ico|png))$/i";

//이미지 삭제
if($del_cover_img) @unlink(G5_DATA_PATH.'/shop/sideSection_cover_img.png');

//커버이미지 업로드
if(is_uploaded_file($_FILES['cover_img']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['cover_img']['name']))
		alert($_FILES['cover_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['cover_img']['name'])) {
		$dest_path = G5_DATA_PATH.'/shop/sideSection_cover_img.png';
		move_uploaded_file($_FILES['cover_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}

delete_cache_latest($bo_table);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
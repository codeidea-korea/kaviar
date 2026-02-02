<?php
include_once("./_common.php");


$img_path = G5_DATA_PATH.'/shop_cate';
if(!is_dir($img_path)){
	@mkdir($img_path, G5_DIR_PERMISSION);
	@chmod($img_path, G5_DIR_PERMISSION);
}


$image_regex = "/(\.(gif|jpg|png|ico))$/i";


if($del_ca_all_img) {
	@unlink(G5_DATA_PATH."/shop_cate/ca_all_img");
	$files = glob(G5_DATA_PATH."/shop_cate/thumb-ca_all_img*");
	if (is_array($files)) {
		foreach($files as $thumbnail) {
			$cnt++;
			@unlink($thumbnail);
		}
	}
}

if(is_uploaded_file($_FILES['ca_all_img']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['ca_all_img']['name']))
		alert($_FILES['ca_all_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['ca_all_img']['name'])) {
		$dest_path = $img_path.'/ca_all_img';
		move_uploaded_file($_FILES['ca_all_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}


$post_ca_id_count = (isset($_POST['ca_id_up']) && is_array($_POST['ca_id_up'])) ? count($_POST['ca_id_up']) : 0;

//전체수정
for ($i=0; $i<$post_ca_id_count; $i++){
    $ca_id[$i] = $_POST['ca_id_up'][$i];
	
	if($del_ca_img[$i]) {
		@unlink(G5_DATA_PATH."/shop_cate/$ca_id[$i]");
		$files = glob(G5_DATA_PATH."/shop_cate/thumb-$ca_id[$i]*");
		if (is_array($files)) {
			foreach($files as $thumbnail) {
				$cnt++;
				@unlink($thumbnail);
			}
		}
	}

	if(is_uploaded_file($_FILES['ca_img'.$i]['tmp_name'])) {
		if (!preg_match($image_regex, $_FILES['ca_img'.$i]['name']))
			alert($_FILES['ca_img'.$i]['name'] . '은(는) 이미지 파일이 아닙니다.');
		if (preg_match($image_regex, $_FILES['ca_img'.$i]['name'])) {
			$dest_path = $img_path.'/'.$ca_id[$i];
			move_uploaded_file($_FILES['ca_img'.$i]['tmp_name'], $dest_path);
			chmod($dest_path, G5_FILE_PERMISSION);
		}
	}
	
}





echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
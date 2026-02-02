<?php
$sub_menu = "300930";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();


$sql = " update {$g5['board_tmp_con_table']} set 						
				tmp_subject1 = '{$_POST['tmp_subject1']}',
				tmp_content1 = '{$_POST['tmp_content1']}',
				tmp_subject2 = '{$_POST['tmp_subject2']}',
				tmp_content2 = '{$_POST['tmp_content2']}',
				tmp_subject3 = '{$_POST['tmp_subject3']}',
				tmp_content3 = '{$_POST['tmp_content3']}',
				tmp_subject4 = '{$_POST['tmp_subject4']}',
				tmp_content4 = '{$_POST['tmp_content4']}',
				tmp_subject5 = '{$_POST['tmp_subject5']}',
				tmp_content5 = '{$_POST['tmp_content5']}',
				tmp_subject6 = '{$_POST['tmp_subject6']}',
				tmp_content6 = '{$_POST['tmp_content6']}',
				tmp_subject7 = '{$_POST['tmp_subject7']}',
				tmp_content7 = '{$_POST['tmp_content7']}',
				tmp_subject8 = '{$_POST['tmp_subject8']}',
				tmp_content8 = '{$_POST['tmp_content8']}',
				tmp_subject9 = '{$_POST['tmp_subject9']}',
				tmp_content9 = '{$_POST['tmp_content9']}',
				tmp_subject10 = '{$_POST['tmp_subject10']}',
				tmp_content10 = '{$_POST['tmp_content10']}'
				";
sql_query($sql);


$image_regex = "/(\.(gif|jpg|png|ico))$/i";

for($i=1; $i<=10; $i++) {

	//이미지 삭제
	if($del_tmp_img[$i]) @unlink(G5_DATA_PATH.'/tmp/temp'.$i.'.jpg');

	//이미지 업로드
	if(is_uploaded_file($_FILES['tmp_img'.$i]['tmp_name'])) {
		if (!preg_match($image_regex, $_FILES['tmp_img'.$i]['name']))
			alert($_FILES['tmp_img'.$i]['name'] . '은(는) 이미지 파일이 아닙니다.');
		if (preg_match($image_regex, $_FILES['tmp_img'.$i]['name'])) {
			$dest_path[$i] = G5_DATA_PATH.'/tmp/temp'.$i.'.jpg';
			move_uploaded_file($_FILES['tmp_img'.$i]['tmp_name'], $dest_path[$i]);
			chmod($dest_path[$i], G5_FILE_PERMISSION);
		}
	}
}

goto_url(G5_ADMIN_URL.'/my/tmpCon.php');
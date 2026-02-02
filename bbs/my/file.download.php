<?php
include_once('./_common.php');
//if ($is_admin != 'super') exit; // 개별 페이지 접근 불가


if (isset($_POST['file_path']) && isset($_POST['file_name'])) {

	$file_path = $_POST['file_path'];
	$file_name = $_POST['file_name'];
	$file = $file_path.$file_name;
	$filesize = filesize($file);
	
	if(is_file($file)) {
		header("Content-Type:application/octet-stream");
		header("Content-Disposition:attachment; filename='$file_name'");
		header("Content-Transfer-Encoding:binary");
		header("Content-Length: $filesize");
		header("Cache-Control:cache,must-revalidate");
		ob_clean();
		flush(); //버퍼 비우기
		readfile($file); //파일 읽어서 출력하기


	} else {
		echo '<script>alert("존재하지 않는 파일입니다.")</script>';
	}
}





////////////////////  수정중...................
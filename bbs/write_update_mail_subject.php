<?php
$viewmode =  $_GET['view']=='mail' ? true : false;
if (!defined('_GNUBOARD_') && !$viewmode) exit; // 개별 페이지 접근 불가 - $_GET['view']!='mail' -> 미리보기
if($viewmode) {
	$emailOption = $_GET['emailOption'];
	$wr_subject = '게시물 제목이 여기에 들어갑니다.';
	$wr_content = '게시물 내용이 여기에 들어갑니다.';
	$wr_name = '홍길동';
	$link_url = '#';
	$wr_date = date("Y.m.d");
}
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?php echo $wr_subject ?> 메일</title>
</head>
<body>

<div class="mailContainer" style="margin:30px auto;width:100%;max-width:700px;min-width:500px;">
	<div style="padding:25px;border:1px solid #dedede;border-radius:6px;box-shadow:0 8px 10px rgba(0,0,0,0.06);overflow:hidden">
		<div style="font-size:16px;font-weight:600;"><?=$wr_subject?></div>
		<div style="margin-top:15px;display:flex;align-items:center;gap:15px;font-size:13px;">
			<span style="font-weight:600;"><?=$wr_name?></span>
			<span style="color:#a4a4a4;"><?=$wr_date?></span>
		</div>
		<div style="margin-top:20px;text-align:center;">
			<a href="<?=$link_url?>" style="font-size:16px;font-weight:bold;color:#fff;background:#1bc8a6;text-decoration:none;text-align:center;padding:20px 20px;border-radius:6px;display:flex;align-items:center;justify-content:center;">사이트에서 게시물 확인하기</a>
		</div>
	</div>	
</div>

</body>
</html>

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

if($emailOption=='1') {
	require_once('./write_update_mail_subject.php');
    return;
}
if(file_exists($board_pcskin_path.'/write_update_mail.php') && $emailOption!='1') {
	require_once($board_pcskin_path.'/write_update_mail.php');
    return;
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
	<div style="border:1px solid #dedede;border-radius:6px;box-shadow:0 8px 10px rgba(0,0,0,0.06);overflow:hidden">
		<div style="display:flex;align-items:center;gap:20px;position:relative;padding:25px 30px;background:#f7f7f7;color:#555;">
			<span style="flex:1;font-size:1.4em;font-size:16px;font-weight:600;"><?=$wr_subject?></span>
			<span style="margin-left:auto;font-size:14px;font-weight:bold">작성자 <?=$wr_name?></span>
		</div>
		<div style="padding:30px;">
			<?php if($wr_content) echo '<div style="min-height:150px;height:auto;font-size:14px;">'.$wr_content.'</div>'; ?>
			<div style="text-align:center;">
				<a href="<?=$link_url?>" style="font-size:16px;font-weight:bold;color:#fff;background:#1bc8a6;text-decoration:none;text-align:center;padding:20px 20px;border-radius:6px;display:flex;align-items:center;justify-content:center;">사이트에서 게시물 확인하기</a>
			</div>
		</div>
	</div>
</div>

</body>
</html>

<?php
	include_once('./_common.php');

	// 리퍼러 체크
	referer_check();

	$password    = isset($_POST['password']) ? trim($_POST['password']) : '';
	$password_re = isset($_POST['password_re']) ? trim($_POST['password_re']) : '';
	$mb_id       = isset($_POST['mb_ids']) ? trim($_POST['mb_ids']) : '';
	$emails      = isset($_POST['emails']) ? trim($_POST['emails']) : '';
	$tel         = isset($_POST['tel']) ? trim($_POST['tel']) : '';

    if (!$password)
        alert('비밀번호가 넘어오지 않았습니다.');
    if($password != $password_re)
        alert('비밀번호가 일치하지 않습니다.');



	if (get_session('ss_tmp_mb_id') != $mb_id){
		alert('올바른 방법으로 이용해 주십시오.');
	}

	//===============================================================
	//  본인확인
	//---------------------------------------------------------------
	if($emails){
		$sqls = " select mb_password,mb_id from {$g5['member_table']} where mb_id = '$mb_id' and mb_email = '".$emails."' ";
	}else{
		$sqls = " select mb_password,mb_id from {$g5['member_table']} where mb_id = '$mb_id' and replace(mb_hp,'-','') = replace('".$tel."','-','') ";
	}

	
	$rows = sql_fetch($sqls);
	if ($rows['mb_password']) {
		alert('올바른 방법으로 이용해 주십시오.');
	}
	if (!$rows['mb_id']) {
		alert('올바른 방법으로 이용해 주십시오.');
	}
	


    $sql_password = "";
    if ($password)
        $sql_password = " mb_password = '".get_encrypt_string($password)."' ";

    $sql = " update {$g5['member_table']}
                set {$sql_password}
              where mb_id = '$mb_id' ";
    sql_query($sql);
	
	
	if(isset($_SESSION['ss_tmp_mb_id'])) unset($_SESSION['ss_tmp_mb_id']);


	alert('회원 정보가 수정 되었습니다. 다시 로그인 해주세요.', G5_URL);



?>
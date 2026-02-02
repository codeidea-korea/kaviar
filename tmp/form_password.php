<?php
include_once('./_common.php');

$g5['title'] = '비밀번호 수정';
//$head_title = '비밀번호 수정';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/shop.head.php');

$change_id = $_SESSION['ss_tmp_mb_id'];
?>

<style>
.fx-wrap .fx-list .fx-list-label{font-weight:500;color:rgba(0,0,0,0.9);}
@media screen and (min-width:781px) {
	#form_password{margin-top:180px;}
	.fx-wrap .fx-list .fx-list-label{font-size:16px;}
}
@media screen and (max-width:780px) {
	#form_password{margin:60px auto;}
	.fx-wrap{gap:20px;}
	.fx-wrap .fx-list{flex-direction:column;align-items:flex-start;gap:5px;}
	.fx-wrap .fx-list .fx-list-label{font-weight:500;color:rgba(0,0,0,0.9);}
	.fx-wrap .fx-list > *{width:100%;}
}
</style>

<div id="form_password" style="width:100%;max-width:500px;padding:15px;margin-left:auto;margin-right:auto">

	<h2 class="fs20 tcenter mb25">비밀번호 재설정</h2>
	<form id="fregisterform" name="fregisterform" action="./change_password.php" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="mb_ids" value="<?=$change_id?>">
	<div class="fx-wrap label140 gap15">
		<div class="fx-list">
			<div class="fx-list-label">인증방법</div>
			<div class="fx-list-con flex flex-middle gap20">
				<input type="radio" name="auth" value="email" data-label="이메일 인증" checked>
				<input type="radio" name="auth" value="tel" data-label="전화번호 인증">
			</div>
		</div>

		<div id="frm_tel" class="fx-list">
			<div class="fx-list-label">전화번호</div>
			<div class="fx-list-con">
				<input type="tel" name="tel" id="tel" placeholder="가입하셨던 전화번호를 넣어주세요."  autocomplete="off" required class="w-full /lg" size="50"maxlength="100">
			</div>
		</div>
		<div id="frm_email" class="fx-list">
			<div class="fx-list-label">이메일</div>
			<div class="fx-list-con">
				<input type="email" name="emails" id="emails" placeholder="가입하셨던 이메일 주소를 넣어주세요."  autocomplete="off" required class="w-full /lg" size="50"maxlength="100">
			</div>
		</div>
		<div class="fx-list">
			<div class="fx-list-label">비밀번호</div>
			<div class="fx-list-con">
				<input type="password" name="password" id="password" autocomplete="new-password" placeholder="비밀번호" required="required" class="w-full /lg" size="15" maxLength="20">
			</div>
		</div>
		<div class="fx-list">
			<div class="fx-list-label">비밀번호 확인</div>
			<div class="fx-list-con">
				<input type="password" name="password_re" id="password_re" autocomplete="new-password" placeholder="비밀번호 확인" required="required" class="w-full /lg" size="15" maxLength="20">
			</div>
		</div>
	</div>
	<button type="submit" value="확인" class="_btn/lg/mainColor w-full mt10">비밀번호 수정</button>
    </form>

</div>


<script>

	$('#frm_tel').hide();
	$('#tel').attr("required" , false);

	$("input[name='auth']").change(function(){
	
		var val = $("input[name='auth']:checked").val();
		
		if(val == 'tel') {
			$('#frm_tel').show();
			$('#tel').attr("required" , true);
			$('#frm_email').hide();
			$('#emails').attr("required" , false);
		} else {
			$('#frm_tel').hide();
			$('#tel').attr("required" , false);
			$('#frm_email').show();
			$('#emails').attr("required" , true);
		}
	});

	function fregisterform_submit(f)
	{

		if (f.password.value.length < 8) {
			alert('비밀번호를 8글자 이상 입력하십시오.');
			f.password.focus();
			return false;
		}

		if (f.password.value != f.password_re.value) {
			alert('비밀번호가 같지 않습니다.');
			f.password_re.focus();
			return false;
		}

		if (f.password.value.length > 0) {
			if (f.password_re.value.length < 8) {
				alert('비밀번호를 3글자 이상 입력하십시오.');
				f.password_re.focus();
				return false;
			}
		}

		if(!f.password.value.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/)) 
		{ 
			alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 8이상 15이하로 입력해주세요."); 
			return false; 
		}

		return true;
	}

</script>
<?php
include_once(G5_SHOP_PATH.'/shop.tail.php');


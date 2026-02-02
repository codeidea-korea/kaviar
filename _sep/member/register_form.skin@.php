<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 0);
if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);
?>

<div class="p20" style="--form-height:48px;">
    <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php } ?>
	
	<ul class="formContainer gap30 mt10">
		<li>
			<div class="label"><span class="color-black">아이디</span></div>
			<input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" class="frm_input full_input w-full <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" <?php echo $required ?> <?php echo $readonly ?> placeholder="6자 이상 입력해주세요.">
			<span id="msg_mb_id"></span>
		</li>

		<li>
			<div class="label"><span class="color-black">비밀번호</span></div>
			<input type="password" name="mb_password" id="reg_mb_password" class="frm_input full_input w-full <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?> placeholder="6자 이상 입력해주세요.">
			<input type="password" name="mb_password_re" id="reg_mb_password_re" class="frm_input full_input w-full mt15 <?php echo $required ?>" minlength="3" maxlength="20" <?php echo $required ?>  placeholder="비밀번호 확인">
		</li>
		
		<?php 
		$desc_name = '';
		$desc_phone = '';
		if ($config['cf_cert_use']) {
			$desc_name = ' - 본인확인 시 자동입력';
			$desc_phone = ' - 본인확인 시 자동입력';

			if (!$config['cf_cert_simple'] && !$config['cf_cert_hp'] && $config['cf_cert_ipin']) {
				$desc_phone = '';
			}

			if ($config['cf_cert_simple']) {
				echo '<button type="button" id="win_sa_kakao_cert" class="btn_frmline btn win_sa_cert" data-type="">간편인증</button>'.PHP_EOL;
			}
			if ($config['cf_cert_hp'])
				echo '<button type="button" id="win_hp_cert" class="btn_frmline _btn/md">휴대폰 본인확인</button>'.PHP_EOL;
			if ($config['cf_cert_ipin'])
				echo '<button type="button" id="win_ipin_cert" class="btn_frmline _btn/md">아이핀 본인확인</button>'.PHP_EOL;

			echo '<span class="cert_req">(필수)</span>';
			echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
		}
		?>
		<?php
		if ($config['cf_cert_use'] && $member['mb_certify']) {
			switch  ($member['mb_certify']) {
				case "simple": 
					$mb_cert = "간편인증";
					break;
				case "ipin": 
					$mb_cert = "아이핀";
					break;
				case "hp": 
					$mb_cert = "휴대폰";
					break;
			}    
		?>
		<li>
			<div id="msg_certify">
				<strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
			</div>
		</li>
		<?php } ?>
		
		<li class="rgs_name_li">
			<div class="label"><span class="color-black">이름<?=$desc_name?></span></div>
			<input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $name_readonly; ?> class="frm_input full_input w-full <?php echo $required ?> <?php echo $name_readonly ?>" placeholder="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상) <?php echo $desc_name ?>">
		</li>

		<?php if ($req_nick) { ?>
		<li>
			<div class="label"><span class="color-black">닉네임 (필수)</span></div>	
			<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
			<input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input full_input required nospace w-full" maxlength="20" placeholder="닉네임 (필수)">
			<span id="msg_mb_nick"></span>
		</li>
		<?php } ?>

		<li>
			<div class="label"><span class="color-black">이메일</span></div>	
			<?php if ($config['cf_use_email_certify']) {  ?>
			<span class="frm_info">
				<?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
				<?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
			</span>
			<?php }  ?>
			<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
			<input type="email" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="frm_input email required w-full" size="50" maxlength="100" placeholder="이메일 양식을 지켜주세요.">
		</li>

		<?php if ($config['cf_use_tel']) { ?>
		<li>
			<div class="label"><span class="color-black">전화번호</span></div>
			<input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" class="frm_input full_input w-full <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" <?php echo $config['cf_req_tel']?"required":""; ?> placeholder="전화번호<?php if ($config['cf_req_tel']) { ?> (필수)<?php } ?>">
		</li>
		<?php } ?>

		<?php if ($config['cf_use_hp'] || ($config["cf_cert_use"] && ($config['cf_cert_hp'] || $config['cf_cert_simple']))) {  ?>
		<li>
			<div class="label"><span class="color-black">휴대폰번호</span></div>				
			<input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo $hp_required; ?> <?php echo $hp_readonly; ?> class="frm_input full_input w-full <?php echo $hp_required; ?> <?php echo $hp_readonly; ?>" maxlength="20" placeholder="휴대폰번호 <?php if (!empty($hp_required)) { ?> (필수)<?php } ?><?php echo $desc_phone ?>">
			<?php if ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple'])) { ?>
			<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
			<?php } ?>			
		</li>
		<?php } ?>

		<?php if ($config['cf_use_addr']) { ?>
		<li>
			<div class="label"><span class="color-black">우편번호</span></div>	
			<div class="adress flex flex-middle gap12">
				<input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="flex1 frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder="우편번호<?php echo $config['cf_req_addr']?' (필수)':''; ?>">
				<button type="button" class="_btn/md/blue/line" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button>
			</div>
			<div class="mt10">
				<input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input w-full frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="주소<?php echo $config['cf_req_addr']?' (필수)':''; ?>">
			</div>
			<div class="mt10">
				<input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="frm_input frm_address w-full" size="50" placeholder="상세주소">
			</div>
			<div class="mt10">
				<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address w-full" size="50" readonly="readonly" placeholder="참고항목">
				<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
			</div>			
		</li>
		<?php } ?>

		<?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {
			echo '<li class="reg_mb_img_file">';
				echo '<div class="label"><span class="color-black">회원이미지</span></div>';
				echo '<p class="help-block">gif, jpg, png파일만 등록됩니다.</p>';
				echo '<input type="file" name="mb_img" class="myfile btnImg" data-class="w-full" data-btn-name="이미지 업로드">';
				echo '<div class="upImg">';
					if($w == 'u' && file_exists($mb_img_path)) {
						echo '<img src="'.$mb_img_url.'">';
						echo '<input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">';
					}
				echo '</div>';
			echo '</li>';
		} ?>
		
		<!--<li>
			<div class="label"><span class="color-black">생년월일</span></div>
			<div class="flex flex-middle gap10">
				<select name="" id="select_year" class="selectpicker flex1.7">
					<option>년도</option>
					<option>1980년</option>
					<option>1981년</option>
					<option>...</option>
				</select>
				<select name="" id="select_month" class="selectpicker flex1">
					<option>월</option>
					<option>1월</option>
					<option>2월</option>
					<option>...</option>
				</select>
				<select name="" id="select_day" class="selectpicker flex1">
					<option>일</option>
					<option>1일</option>
					<option>2일</option>
					<option>...</option>
				</select>
			</div>
		</li>-->

		<!--<li>
			<div class="label"><span class="color-black">성별</span></div>
			<div class="flex flex-middle gap25">
				<label class="radio-label"><input type="radio" name="r1" value="" checked><span></span>남자</label>
				<label class="radio-label"><input type="radio" name="r1" value=""><span></span>여자</label>
			</div>
		</li>-->
		
		<!-- 메일링서비스 -->
		<?php if($is_member) {
			echo '<div class="p15 border rounded4 bg-gray"><label class="checkbox-label"><input type="checkbox" name="mb_mailling" value="1" '.($member['mb_mailling']?'checked':'').'><span></span>마케팅 수신동의</label></div>';
		} else {
			echo '<input type="hidden" name="mb_mailling" value="1">';
		} ?>
		

		<!-- SMS 수신여부 -->
		<input type="hidden" name="mb_sms" value="1">

		<!-- 정보공개 -->
		<input type="hidden" name="mb_open" value="0">


		<?php
		//회원정보 수정인 경우 소셜 계정 출력
		if( $w == 'u' && function_exists('social_member_provider_manage') ){
			social_member_provider_manage();
		}
		?>

		<?php if ($w == "" && $config['cf_use_recommend']) { ?>
		<li>
			<div class="label"><span class="color-black">추천인아이디</span></div>
			<div class="flex flex-middle gap12">
				<input type="text" name="mb_recommend" id="reg_mb_recommend" class="frm_input flex1" placeholder="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.">
				<button type="button" class="_btn:middle:blue:line">아이디 확인</button>
			</div>
		</li>
		<?php } ?>

		<li class="is_captcha_use">
			<div class="label"><span class="color-black">자동등록방지</span></div>
			<?php echo captcha_html(); ?>
		</li>
	</ul>
    

    <div class="form-btnSet mt50 mb30">
        <a href="<?php echo G5_URL; ?>/" class="_btn/lg/line">취소</a>
        <button type="submit" id="btn_submit" class="_btn/lg/mainColor" accesskey="s"><?php echo $w==''?'회원가입':'정보수정'; ?></button>
    </div>
    </form>

</div>

<script>
$(function() {
	$("#reg_zip_find").css("display", "inline-block");
	var pageTypeParam = "pageType=register";

	<?php if($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
	// 이니시스 간편인증
	var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
	var type = "";    
	var params = "";
	var request_url = "";

	$(".win_sa_cert").click(function() {
		if(!cert_confirm()) return false;
		type = $(this).data("type");
		params = "?directAgency=" + type + "&" + pageTypeParam;
		request_url = url + params;
		call_sa(request_url);
	});
	<?php } ?>
	<?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
	// 아이핀인증
	var params = "";
	$("#win_ipin_cert").click(function() {
		if(!cert_confirm()) return false;
		params = "?" + pageTypeParam;
		var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php"+params;
		certify_win_open('kcb-ipin', url);
		return;
	});

	<?php } ?>
	<?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
	// 휴대폰인증
	var params = "";
	$("#win_hp_cert").click(function() {
		if(!cert_confirm()) return false;
		params = "?" + pageTypeParam;
		<?php     
		switch($config['cf_cert_hp']) {
			case 'kcb':                    
				$cert_url = G5_OKNAME_URL.'/hpcert1.php';
				$cert_type = 'kcb-hp';
				break;
			case 'kcp':
				$cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
				$cert_type = 'kcp-hp';
				break;
			case 'lg':
				$cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
				$cert_type = 'lg-hp';
				break;
			default:
				echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
				echo 'return false;';
				break;
		}
		?>            
		certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>"+params);
		return;
	});
	<?php } ?>
});

// 인증체크
function cert_confirm()
{
	var val = document.fregisterform.cert_type.value;
	var type;

	switch(val) {
		case "simple":
			type = "간편인증";
			break;
		case "ipin":
			type = "아이핀";
			break;
		case "hp":
			type = "휴대폰";
			break;
		default:
			return true;
	}

	if(confirm("이미 "+type+"으로 본인확인을 완료하셨습니다.\n\n이전 인증을 취소하고 다시 인증하시겠습니까?"))
		return true;
	else
		return false;
}

// submit 최종 폼체크
function fregisterform_submit(f)
{
	// 회원아이디 검사
	if (f.w.value == "") {
		var msg = reg_mb_id_check();
		if (msg) {
			alert(msg);
			f.mb_id.select();
			return false;
		}
	}

	if (f.w.value == '') {
		if (f.mb_password.value.length < 3) {
			alert('비밀번호를 3글자 이상 입력하십시오.');
			f.mb_password.focus();
			return false;
		}
	}

	if (f.mb_password.value != f.mb_password_re.value) {
		alert('비밀번호가 같지 않습니다.');
		f.mb_password_re.focus();
		return false;
	}

	if (f.mb_password.value.length > 0) {
		if (f.mb_password_re.value.length < 3) {
			alert('비밀번호를 3글자 이상 입력하십시오.');
			f.mb_password_re.focus();
			return false;
		}
	}

	// 이름 검사
	if (f.w.value=='') {
		if (f.mb_name.value.length < 1) {
			alert('이름을 입력하십시오.');
			f.mb_name.focus();
			return false;
		}
	}

	<?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
	// 본인확인 체크
	if(f.cert_no.value=="") {
		alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
		return false;
	}
	<?php } ?>

	// 닉네임 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
		var msg = reg_mb_nick_check();
		if (msg) {
			alert(msg);
			f.reg_mb_nick.select();
			return false;
		}
	}

	// E-mail 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
		var msg = reg_mb_email_check();
		if (msg) {
			alert(msg);
			f.reg_mb_email.select();
			return false;
		}
	}

	<?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
	// 휴대폰번호 체크
	var msg = reg_mb_hp_check();
	if (msg) {
		alert(msg);
		f.reg_mb_hp.select();
		return false;
	}
	<?php } ?>

	if (typeof f.mb_icon != "undefined") {
		if (f.mb_icon.value) {
			if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
				alert("회원아이콘이 이미지 파일이 아닙니다.");
				f.mb_icon.focus();
				return false;
			}
		}
	}

	if (typeof f.mb_img != "undefined") {
		if (f.mb_img.value) {
			if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
				alert("회원이미지가 이미지 파일이 아닙니다.");
				f.mb_img.focus();
				return false;
			}
		}
	}

	if (typeof(f.mb_recommend) != 'undefined' && f.mb_recommend.value) {
		if (f.mb_id.value == f.mb_recommend.value) {
			alert('본인을 추천할 수 없습니다.');
			f.mb_recommend.focus();
			return false;
		}

		var msg = reg_mb_recommend_check();
		if (msg) {
			alert(msg);
			f.mb_recommend.select();
			return false;
		}
	}

	<?php echo chk_captcha_js(); ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}

var uploadFile = $('.filebox .uploadBtn');
uploadFile.on('change', function(){
	if(window.FileReader){
		var filename = $(this)[0].files[0].name;
	} else {
		var filename = $(this).val().split('/').pop().split('\\').pop();
	}
	$(this).siblings('.fileName').val(filename);
});
</script>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 0);
if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);

if(file_exists(G5_THIS_PATH.'/member/register_form.skin.php')) {
	require_once(G5_THIS_PATH.'/member/register_form.skin.php');
	return;
} else if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/member/register_form.skin.php')) {
	require_once(G5_THEME_PATH.'/member/register_form.skin.php');
	return;
}

$userAgents = $_SERVER['HTTP_USER_AGENT'];
$patternkaviar = '/'.$config['cf_ios_version'].'/i';

/*
if( ! $config['cf_social_login_use'] ){
    alert('소셜 로그인을 사용하지 않습니다.');
}
*/

if($w != 'u'){
	if( $is_member ){
		alert('이미 회원가입 하였습니다.', G5_URL);
	}
}

$provider_name = social_get_request_provider();
$user_profile = social_session_exists_check();
/*
if( ! $user_profile ){
    alert( "소셜로그인을 하신 분만 접근할 수 있습니다.", G5_URL);
}
*/
// 소셜 가입된 내역이 있는지 확인 상수 G5_SOCIAL_DELETE_DAY 관련

if($user_profile){
	
	$user_nick = social_relace_nick($user_profile->displayName);
	$user_email = isset($user_profile->emailVerified) ? $user_profile->emailVerified : $user_profile->email;
	//$user_email = $user_profile->email;
	$user_id = $user_profile->sid ? preg_replace("/[^0-9a-z_]+/i", "", $user_profile->sid) : get_social_convert_id($user_profile->identifier, $provider_name);
	$user_mobile = $user_profile->mobile;

	$user_birthDay = $user_profile->birthDay;
	$user_birthMonth = $user_profile->birthMonth;
	$user_birthYear = $user_profile->birthYear;
	$identifier = $user_profile->identifier;

//	print_r($user_profile);
	if(! $user_nick) {
		$tmp = explode('_', $user_id);
		$user_nick = $tmp[1];
	}

	//$is_exists_id = exist_mb_id($user_id);
	//$is_exists_name = exist_mb_nick($user_nick, '');
	$user_id = exist_mb_id_recursive($user_id);
	$user_nick = exist_mb_nick_recursive($user_nick, '');
	$is_exists_email = $user_email ? exist_mb_email($user_email, '') : false;

	if($provider == "Kakao"){
		$user_name = isset($user_profile->displayName) ? $user_profile->displayName : ''; 
	}else if($provider == "Naver"){
		$user_name = isset($user_profile->username) ? $user_profile->username : ''; 
	}else{
		$user_name = isset($user_profile->username) ? $user_profile->username : ''; 
	}
		
	

	$object_sha = sha1( serialize( $profile ) );
	
	$json_data = json_encode($user_profile);
$sql = " insert into `g5_mem_log`
                set ids = '".$user_id."', name = '".$user_name."', arrays = '".sql_real_escape_string($json_data)."', regdate = '".date('Y-m-d H:i:s')."' ";
sql_query($sql);

	if($user_email == ''){
		alert("회원 가입시 이메일은 필요합니다. 재동의 페이지로 이동합니다.", "../email_chk.php");
	}
}else{

	$user_id = $member['mb_id'];
	$user_email = $member['mb_email'];
	$user_name = $member['mb_name'];
	$user_mobile = $member['mb_hp'];

}

//echo "<br>aa : ".$user_id." / ".$user_nick." / ".$user_email." / ".$user_name;


//새창을 사용한다면
if( G5_SOCIAL_USE_POPUP ) {
    $self_url = G5_SOCIAL_LOGIN_URL.'/popup.php';
}
?>


<style>
#container {background-color:#fff; }

.join_box {width:500px; max-width:100%; margin:0 auto; margin-top:50px; text-align: center; padding:0 10px;}
.join_box .j_s_01 {margin:0; padding:0; text-align: center;}
.join_box .j_s_01 li{font-size:12px; font-weight:bold; color:#9a9999; text-align:center; margin:0 0 20px 0;}

.join_box .sns_login {display:flex; align-items:center; justify-content:center; gap:10px; width:100%; margin:0 auto !important;}
.join_box .sns_login a{/*width:100%;*/ overflow:hidden; width:48px; line-height:48px; display:inline-block; position:relative; color:#fff; font-weight:bold; font-size:14px; margin-bottom:15px; border-radius:50%;}
.join_box .sns_login a:first-of-type{background:#ffcd00; color:#000;}
.join_box .sns_login a:last-of-type{background:#48c12f; color:#fff;}
/* .join_box .sns_login a img{position:absolute; left:6px; top:6px;} */
.join_box .sns_login a:last-of-type img{left: 6px;}
.join_box .sns_login a span{margin-left:29px; font-size:14px;}
/*
.join_box .sns_login a:last-of-type{background:#707070;}
*/
/* .join_box .sns_login a img{position:absolute; left:6px; top:6px;} */
.join_box .sns_login a:last-of-type img{left:4px;}
.join_box .sns_login a span{margin-left:29px; font-size:14px;}

	

</style>

<?php if( G5_SOCIAL_USE_POPUP && !$social_pop_once ){
        $social_pop_once = true;
        ?>
<script>
	jQuery(function($){
		$(".j_s_01").on("click", "a.social_link", function(e){
			e.preventDefault();

			var pop_url = $(this).attr("href");
			var newWin = window.open(
				pop_url, 
				"social_sing_on", 
				"location=0,status=0,scrollbars=1,width=600,height=500"
			);

			if(!newWin || newWin.closed || typeof newWin.closed=='undefined')
				 alert('브라우저에서 팝업이 차단되어 있습니다. 팝업 활성화 후 다시 시도해 주세요.');

			return false;
		});
	});
</script>
<?php } ?>


<?if($config['cf_use_ioslogin'] == 1){
	if (!preg_match($patternkaviar, $userAgents)) {?>
		<div class="join_box">
			<ul class="j_s_01">

				<li class="sns_login">
					<a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>" class="social_link sns-kakao">
					<img src="<?php echo G5_IMG_URL?>/my/Login_kakao_ico.png"><!--<span>카카오로 시작하기</span>--></a>
					<a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link sns-naver">
					<img src="<?php echo G5_IMG_URL?>/my/Login_naver_ico.png"><!--<span>네이버로 시작하기</span>--></a>
				 
				</li>

			</ul>
		</div>
<?	}
}else{?>
	<div class="join_box">
		<ul class="j_s_01">

			<li class="sns_login">
				<a href="<?php echo $self_url;?>?provider=kakao&amp;url=<?php echo $urlencode;?>" class="social_link sns-kakao">
				<img src="<?php echo G5_IMG_URL?>/my/Login_kakao_ico.png"><!--<span>카카오로 시작하기</span>--></a>
				<a href="<?php echo $self_url;?>?provider=naver&amp;url=<?php echo $urlencode;?>" class="social_link sns-naver">
				<img src="<?php echo G5_IMG_URL?>/my/Login_naver_ico.png"><!--<span>네이버로 시작하기</span>--></a>
			 
			</li>

		</ul>
	</div>
<?}?>



<div id="_joinContainer" class="p20 max-width" style="--form-height:48px;">
	<h2 id="_page_title" style="margin-top:40px">회원가입</h2>

    <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="object_sha" value="<?php echo $object_sha ?>">
	<input type="hidden" name="identifier" value="<?php echo $identifier ?>">
	<input type="hidden" name="provider" value="<?php echo $provider ?>">
	<input type="hidden" name="sns_type" id="sns_type">
	
	
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    <?php if (isset($member['mb_sex'])) { ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php } ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면 ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php } ?>
	
	<ul class="formContainer column gap30 mt10">
		<li>			
			<div class="label"><span class="color-black">아이디</span></div>
			<div class="flex flex-middle w-full">
				<input type="text" name="mb_id" id="reg_mb_id" value="<?php echo isset($user_id) ? get_text($user_id) : ''; ?>" class="frm_input full_input flex1 <?php echo $required ?> <?php echo $readonly ?>" <?if($user_id){?>readonly<?}?> minlength="6" maxlength="20" <?php echo $required ?> <?php echo $readonly ?> placeholder="6자 이상 입력해주세요.">
				<button type="button" class="overlap idcheck _btn">중복확인</button>
			</div>
			<span id="msg_mb_id"></span>
		</li>
<?if(!$user_profile){?>
		<li>
			<div class="label"><span class="color-black">비밀번호</span></div>
			<p class="help-block -mt5">비밀번호는 문자, 숫자, 특수문자의 조합으로 8이상 15이하로 입력.</p>
			<input type="password" name="mb_password" id="reg_mb_password" class="frm_input full_input w-full <?php echo $required ?>" minlength="8" maxlength="15" <?php echo $required ?> placeholder="8자 이상 15 이하로 입력해주세요.">
		</li>
		<li>
			<div class="label"><span class="color-black">비밀번호 확인</span></div>
			<input type="password" name="mb_password_re" id="reg_mb_password_re" class="frm_input full_input w-full <?php echo $required ?>" minlength="8" maxlength="15" <?php echo $required ?>  placeholder="비밀번호 확인">
		</li>
<?}else{?>
		<input type="hidden" name="mb_password" id="reg_mb_password" value="<?php echo $user_id."_".date('hs')."!"; ?>">
		<input type="hidden" name="mb_password_re" id="reg_mb_password_re" value="<?php echo $user_id."_".date('hs')."!"; ?>">
<?}?>
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
		
		
		<input type="hidden" name="cf_use_nickname" value="<?=$config['cf_use_nickname']?>">
		<?php if ($config['cf_use_nickname'] == 1) { ?>
		<li>
			<div class="label"><span class="color-black">닉네임 (필수)</span></div>	
			<input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
			<input type="text" onkeyup="korea('reg_mb_nick')"  name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="frm_input full_input required nospace w-full" maxlength="20" placeholder="닉네임 (필수)">
			<span id="msg_mb_nick"></span>
		</li>
		<?php }else { ?>

		<li class="rgs_name_li">
			<div class="label"><span class="color-black">이름 <?=$desc_name?></span></div>
			<input type="text" onkeyup="korea('reg_mb_name')" value="<?php echo isset($user_name) ? get_text($user_name) : ''; ?>" id="reg_mb_name" name="mb_name" <?php echo $required ?> <?php echo $name_readonly; ?> class="frm_input full_input w-full <?php echo $required ?> <?php echo $name_readonly ?>" placeholder="공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상) <?php echo $desc_name ?>">
		</li>

		<?}?>
<script>
function korea(id) {
    var regexp = /[a-z0-9]|[ \[\]{}()<>?|`~!@#$%^&*-_+=,.;:\"'\\]/g;
    var value = $("#"+id).val();
    if (regexp.test(value)) {
        $("#"+id).val(value.replace(regexp, ''));
    }
}
</script>

	<?php $births = explode("-",$member['mb_births']); echo $births[0]; ?>
		<li>
			<div class="label"><span class="color-black">생년월일</span></div>
			<div class="flex flex-middle gap10">
				<select name="mb_year" id="select_year" class="selectpicker flex1.7">
					<option value="">년도</option>
			<?  $Date = date("Y");
				for($y=1950; $y<$Date; $y++){?>
					<option value="<?=$y?>" <?php if($births[0] == $y){ echo "selected"; } ?>><?=$y?></option>
			<?}?>
				</select>
				<select name="mb_month" id="select_month" class="selectpicker flex1">
					<option value="">월</option>
			<?
				for($mm=1; $mm<13; $mm++){?>
					<option value="<?=$mm?>" <?php if($births[1] == $mm){ echo "selected"; } ?>><?=$mm?></option>
			<?}?>
				</select>
				<select name="mb_day" id="select_day" class="selectpicker flex1">
					<option value="">일</option>
			<?
				for($dd=1; $dd<32; $dd++){?>
					<option value="<?=$dd?>" <?php if($births[2] == $dd){ echo "selected"; } ?>><?=$dd?></option>
			<?}?>
				</select>
			</div>
		</li>


		<li>
			<div class="label"><span class="color-black">성별</span></div>
			<div class="flex flex-middle gap25">
				<label class="radio-label"><input type="radio" name="r1" value="1" <?php if($w =='u'){ echo ($member['mb_sexs'] == 1)?"checked":""; }?>><span></span>남자</label>
				<label class="radio-label"><input type="radio" name="r1" value="2" <?php if($w =='u'){ echo ($member['mb_sexs'] == 2)?"checked":""; }?>><span></span>여자</label>
			</div>
		</li>

		<li>
			<div class="flex flex-middle">
				<div class="label"><span class="color-black">사업자회원 유무</span></div>
				<label class="radio-label"><input type="checkbox" name="r2" id="r2" value="" ><span></span></label>
			</div>

			<?php //if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {
				echo '<li class="reg_mb_img_file" id="reg_file">';
					echo '<div class="label"><span class="color-black">사업자등록증</span></div>';
					echo '<p class="help-block">gif, jpg, png파일만 등록됩니다.</p>';
					echo '<input type="file" name="mb_img" class="myfile btnImg" data-class="w-full" data-btn-name="이미지 업로드">';
					echo '<div class="upImg">';
						if($w == 'u' && file_exists($mb_img_path)) {
							echo '<img src="'.$mb_img_url.'">';
							echo '<input type="checkbox" name="del_mb_img" value="1" id="del_mb_img">';
						}
					echo '</div>';
				echo '</li>';
			//} ?>
		</li>
<script>
    $('#reg_file').hide();   // 초깃값 설정

	$("input[name='r2']").change(function(){
		// 휴대폰 결제 선택 시.
		if($("input[name='r2']:checked").val() == ''){
			$('#reg_file').show();
		}else{
			$('#reg_file').hide();
		}
		
	});
</script>

		<li>
			<div class="label"><span class="color-black">이메일</span></div>	
			<?php if ($config['cf_use_email_certify']) {  ?>
			<span class="frm_info">
				<?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
				<?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
			</span>
			<?php }  ?>
			<input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
			<input type="email" name="mb_email" value="<?php echo isset($user_email) ? get_text($user_email) : ''; ?>" id="reg_mb_email" required class="frm_input email required w-full" size="50" <?if($user_email){?><?}?> maxlength="100" placeholder="이메일 양식을 지켜주세요.">
		</li>

		<?php if ($config['cf_use_tel']) { ?>
		<li>
			<div class="label"><span class="color-black">전화번호</span></div>
			<input type="text" name="mb_tel"  id="reg_mb_tel" class="frm_input full_input w-full <?php echo $config['cf_req_tel']?"required":""; ?>"  maxlength="20" <?php echo $config['cf_req_tel']?"required":""; ?> placeholder="전화번호<?php if ($config['cf_req_tel']) { ?> (필수)<?php } ?>">
		</li>
		<?php } ?>

		<?php if ($config['cf_use_hp'] || ($config["cf_cert_use"] && ($config['cf_cert_hp'] || $config['cf_cert_simple']))) {  ?>
		<li>
			<div class="label"><span class="color-black">휴대폰번호</span></div>				
			<input type="text" name="mb_hp"  id="reg_mb_hp" <?php echo $hp_required; ?> <?php echo $hp_readonly; ?> class="frm_input full_input w-full <?php echo $hp_required; ?> <?php echo $hp_readonly; ?>" maxlength="15" placeholder="휴대폰번호 <?php if (!empty($hp_required)) { ?> (필수)<?php } ?><?php echo $desc_phone ?>" value="<?php echo isset($user_mobile)?$user_mobile:''; ?>" <?if($user_mobile && $w == ''){?>readonly<?}?>>
			<?php if ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple'])) { ?>
			<input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
			<?php } ?>			
		</li>
		<?php } ?>

		<?php if ($config['cf_use_addr']) { ?>
		<li>
			<div class="label"><span class="color-black">우편번호</span></div>	
			<div class="adress flex flex-middle gap12">
				<input type="text" name="mb_zip"  id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="flex1 frm_input <?php echo $config['cf_req_addr']?"required":""; ?>" value="<?php echo $member['mb_zip1'].$member['mb_zip2']?>" size="5" maxlength="6" placeholder="우편번호<?php echo $config['cf_req_addr']?' (필수)':''; ?>">
				<button type="button" class="_btn/blue/line/transparent" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소검색</button>
			</div>
			<input type="text" name="mb_addr1"  id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="frm_input w-full frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="주소<?php echo $config['cf_req_addr']?' (필수)':''; ?>" value="<?php echo $member['mb_addr1']; ?>">
			<input type="text" name="mb_addr2"  id="reg_mb_addr2" class="frm_input frm_address w-full" size="50" placeholder="상세주소"  value="<?php echo $member['mb_addr2']; ?>">
			<input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="frm_input frm_address w-full" size="50" readonly="readonly" placeholder="참고항목">
			<input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">			
		</li>
		<?php } ?>

<!-- reg_mb_recommend_check -->
		<li>			
			<div class="label"><span class="color-black">추천인</span></div>
			<div class="flex flex-middle w-full">
				<input type="text" name="mb_recomm" id="reg_mb_recommend" class="frm_input full_input flex1" minlength="6" maxlength="20" placeholder="추천인 입력" <?if($w=='u'){ echo "readonly"; } ?> >
				<button type="button" class="overlap recheck _btn">추천인 확인</button>
			</div>
			<span id="msg_mb_id"></span>
		</li>

		<?php if ($config['cf_use_sns']) { ?>
		<li>
			<div class="label"><span class="color-black">가입경로</span></div>
	
			<div class="flex flex-middle gap25">
				<label class="radio-label"><input type="radio" name="mb_sns" id="rr1" value="인터넷검색" checked><span></span>인터넷검색</label>
				<label class="radio-label"><input type="radio" name="mb_sns" id="rr2" value="지인소개"><span></span>지인소개</label>
				<label class="radio-label"><input type="radio" name="mb_sns" id="rr3" value="광고"><span></span>광고</label>
				<label class="radio-label"><input type="radio" name="mb_sns" id="rr4" value="기타"><span></span>기타</label>
			</div>

			<input type="text" name="mb_etc" id="reg_etc"  class="frm_input full_input w-full" maxlength="100" placeholder="기타 가입경로 입력 ">
		<!--
			<select name="mb_sns" id="mb_sns" class="selectpicker flex1.7" >
				<option value="">-유입경로-</option>
				<option value="검색">검색</option>
				<option value="SNS">SNS</option>
				<option value="추천">주변추천</option>
				<option value="광고">광고</option>
				<option value="기타">기타</option>
			</select>
		-->
		</li>
		<?php } ?>




<style>
body {
   
}
.checkbox-wrap span {
 --checkbox-size: 18px;
    --radio-size: var(--checkbox-size);
    display: inline-block;
    vertical-align: middle;
    width: var(--checkbox-size);
    height: var(--checkbox-size);
    line-height: calc(var(--checkbox-size) - 2px);
    background: #cacaca69;
	border:1px solid #a9a9a97a;
    border-radius: 15px;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,0.53);
}
.checkbox-wrap input[type="checkbox"]:checked + span {border:1px solid var(--checked-background) !important; }

.agree_area .textbox {display:none; }
.agree_area .detail-btn {position:absolute; right:0; top:2px; transition:all 0.1s; }
.agree_area .detail-btn.active {transform:rotate(-90deg); }
</style>

<div class="mb fs14 max-width sm:p15 agree_area">

	<?php if($config['cf_stipulation_label'] || $config['cf_privacy_label'] || $config['cf_terms_label']) { ?>
	<div class="py20 border-bottom">
		<label class="checkbox-label fw700 fs22"><input type="checkbox" name="chk_all" class="chkall" data-group="chk1" <?if($w=='u'){ echo "checked"; } ?>><span></span>전체 약관 동의</label>
	</div>
	<?php } ?>
	
	<?php if($config['cf_stipulation_label']) { ?>
	<div class="relative mt20">
		<label class="checkbox-label fw400 fs16"><input type="checkbox" name="agree" value="1" class="chk1" <?if($w=='u'){ echo "checked"; } ?>><span></span>이용약관 동의 (필수)</label>
		<button class="detail-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg></button>
		<div class="textbox h-135 fs13 color-gray2 mt15" style="background:#ebe6e1">
			<?php echo nl2br($config['cf_stipulation']) ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if($config['cf_privacy_label']) { ?>
	<div class="relative mt20">
		<label class="checkbox-label fw400 fs16"><input type="checkbox" name="agree2" value="1" class="chk1" <?if($w=='u'){ echo "checked"; } ?>><span></span>개인정보 수집/동의 (필수)</label>
		<button class="detail-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg></button>
		<div class="textbox h-135 fs13 color-gray2 mt15" style="background:#ebe6e1">
			<?php echo nl2br($config['cf_privacy']) ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if($config['cf_terms_label']) { ?>
	<div class="relative mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree3" value="1" class="chk1" ><span></span><?=$config['cf_terms_label']?> (필수)</label>
		<button class="detail-btn" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg></button>
		<div class="textbox h-135 fs13 color-gray2 mt15">
			<?php echo nl2br($config['cf_terms']) ?>
		</div>
	</div>
	<?php } ?>
	
	<div class="mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree4" value="1" class="chk1" <?if($w=='u'){ echo "checked"; } ?>><span></span>만 14세 이상입니다. (필수)</label>
	</div>

	<div class="mt20">
		<label class="checkbox-label fw500 flex-top"><input type="checkbox" name="mb_sms" value="1" class="chk1" <?if($member['mb_sms']=='1'){ echo "checked"; } ?>><span></span>
			이메일 및 SMS 마케팅 정보 수신에 동의합니다. (선택)<br>
		</label>
	</div>
</div>






<script>

	$('.detail-btn').on('click',function(){
		$(this).toggleClass('active')
		$(this).next().toggle();
	})

	
    $('#reg_etc').hide();   // 초깃값 설정

	$("input[name='mb_sns']").change(function(){
		// 휴대폰 결제 선택 시.
		if($("input[name='mb_sns']:checked").val() == '기타'){
			$('#reg_etc').show();
		}else{
			$('#reg_etc').hide();
		}
		
	});


</script>
		
<style>

	.go_login {padding-bottom:30px; color:#999; font-size:14px; }
	.go_login a {color:#333; font-weight:500; text-decoration:underline; }

</style>
		
		
		
		<!-- 메일링서비스 -->
		<?php if($is_member) {
			echo '<div class="p15 border rounded4 bg-gray"><label class="checkbox-label"><input type="checkbox" name="mb_mailling" value="1" '.($member['mb_mailling']?'checked':'').'><span></span>마케팅 수신동의 (선택)</label></div>';
		} else {
			echo '<input type="hidden" name="mb_mailling" value="1">';
		} ?>
		

		<!-- SMS 수신여부 
		<input type="hidden" name="mb_sms" value="1">-->

		<!-- 정보공개 -->
		<input type="hidden" name="mb_open" value="0">


		<?php
		//회원정보 수정인 경우 소셜 계정 출력
		if( $w == 'u1' && function_exists('social_member_provider_manage') ){
			social_member_provider_manage();
		}
		?>

		<?php if ($w == "" && $config['cf_use_recommend']) { ?>
		<li>
			<div class="label"><span class="color-black">추천인아이디</span></div>
			<div class="flex flex-middle gap12">
				<input type="text" name="mb_recommend" id="reg_mb_recommends" class="frm_input flex1" placeholder="영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.">
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
	<div class="go_login">
		<p class="tcenter">이미 아이디가 있으신가요? <a href="https://kaviar.testlink.or.kr/bbs/login.php?pn=login_intro">로그인</a></p>
	</div>
    </form>

</div>
<script>

// 인증체크
function function_test(sns)
{
	var f = document.fregisterform;
	$("#sns_type").val(sns);
	f.submit();
}

</script>

<?php
	if($_GET['provider'] == "Naver"){
		
		if(!$member['mb_id']){
			echo "<script language='javascript'>function_test('".$_GET['provider']."');</script>";
		}
	}
?>

<script>

$(".idcheck").click(function(){
	var regid = $("#reg_mb_id").val();
	if (regid != '') {
		if (regid.length < 6) {
			alert('6자 이상 입력해주세요.');
			$("#reg_mb_id").focus();
			return false;
		}
	}

	var msg = reg_mb_id_check();
	
	

	if(msg == "" || msg == null){
		// 중복된 아이디가 존재하지 않는다.
		if(!confirm("가입할 수 있는 아이디입니다.\n현재 아이디를 사용하시겠습니까?")){
			document.getElementById("reg_mb_id").value = "";
		}
	}
	else
	{
		// 중복된 아이디가 존재한다.
		alert(msg);
	}
});


$(".recheck").click(function(){
	var regid = $("#reg_mb_recommend").val();
	if (regid != '') {
		if (regid.length < 6) {
			alert('6자 이상 입력해주세요.');
			$("#reg_mb_recomm").focus();
			return false;
		}
	}

	var msg = reg_mb_recommend_check();
	
	

	if(msg == "" || msg == null){
		// 중복된 아이디가 존재하지 않는다.
		if(!confirm("추천가능합니다.")){
			document.getElementById("reg_mb_recommend").value = "";
		}
	}
	else
	{
		// 중복된 아이디가 존재한다.
		alert(msg);
	}
});


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
		if (f.mb_password.value.length < 8) {
			alert('비밀번호를 8글자 이상 입력하십시오.');
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
		if (f.mb_password_re.value.length < 8) {
			alert('비밀번호를 3글자 이상 입력하십시오.');
			f.mb_password_re.focus();
			return false;
		}
	}

	if(!f.mb_password.value.match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/)) 
    { 
        alert("비밀번호는 문자, 숫자, 특수문자의 조합으로 8이상 15이하로 입력해주세요."); 
        return false; 
    } 

	

	<?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
	// 본인확인 체크
	if(f.cert_no.value=="") {
		alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
		return false;
	}
	<?php } ?>


	<?php if($w == '' && $config['cf_use_sns']) { ?>
	// 본인확인 체크
	if(f.mb_sns.value=="") {
		alert("유입유형을 선택해주세요.");
		return false;
	}
	<?php } ?>

	
/*
<?php if($w == '' && $config['cf_use_nickname']==1) { ?>

	// 닉네임 검사
	if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
		var msg = reg_mb_nick_check();
		if (msg) {
			alert(msg);
			f.reg_mb_nick.select();
			return false;
		}
	}

<?php }else { ?>
*/
	// 이름 검사
	if (f.w.value=='') {
		if (f.mb_name.value.length < 1) {
			alert('이름을 입력하십시오.');
			f.mb_name.focus();
			return false;
		}
	}
/*
<?php } ?>
*/
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



	<?php if($config['cf_stipulation_label']) { ?>
	if (!f.agree.checked) {
		alert("<?=$config['cf_stipulation_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}
	<?php } ?>
	
	<?php if($config['cf_privacy_label']) { ?>
	if (!f.agree2.checked) {
		alert("<?=$config['cf_privacy_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}
	<?php } ?>

	<?php if($config['cf_terms_label']) { ?>
	if (!f.agree3.checked) {
		alert("<?=$config['cf_terms_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree3.focus();
		return false;
	}
	<?php } ?>

	if (!f.agree4.checked) {
		alert("만 14세 이상만 회원가입 하실 수 있습니다.");
		f.agree4.focus();
		return false;
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
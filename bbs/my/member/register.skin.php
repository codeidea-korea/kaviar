<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_PATH.'/member/register.skin.php')) {
	require_once(G5_THIS_PATH.'/member/register.skin.php');
	return;
} else if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/member/register.skin.php')) {
	require_once(G5_THEME_PATH.'/member/register.skin.php');
	return;
}

echo '<link rel="stylesheet" href="'.get_url($member_skin_url.'/'.$css).'">';
?>

<div class="flexCenter/absolute" style="<?=G5_IS_MOBILE?'background:#fff;':'background:#f8f7f7;'?>">
<div id="join_agree">
    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
	<input type="hidden" name="join_code" value="<?=$_POST['join_code']?>">

    <?php
    // 소셜로그인 사용시 소셜로그인 버튼
    @include_once(get_social_skin_path().'/social_register.skin.php');
    ?>

	<div class="title"><?=$config['cf_title']?><br/>회원가입 약관에 동의해주세요.</div>
	<div id="fregister_chkall" style="--checkbox-size:20px;">
        <input type="checkbox" name="chk_all" value="1" id="chk_all" class="chkall" data-group="ck1" data-active-btn="#btnSubmit" data-class="gap15 line" data-label="모두 동의합니다.">
		<p>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>
    </div>
	<ul class="fregister_ul">
		<li>
			<input type="checkbox" name="agree" value="1" id="agree" class="ck1" data-class="gap15 line" data-label="회원가입약관의 내용에 동의합니다.">
			<a href="#fregister_term" class="popup-inline view"></a>
		</li>
		<li>
			<input type="checkbox" name="agree2" value="1" id="agree2" class="ck1" data-class="gap15 line" data-label="개인정보처리방침안내의 내용에 동의합니다.">
			<a href="#fregister_private" class="popup-inline view"></a>
		</li>
	</ul>
    <div class="btnSet flex column gap10">
		<button type="submit" id="btnSubmit" class="_btn/lg/gray w-full">동의</button>
        <a href="<?php echo G5_URL ?>" class="_btn/lg/line w-full">취소</a>
    </div>
    </form>

    <script>
    function fregister_submit(f)
    {
        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보 수집 및 이용의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        return true;
    }
    </script>
</div>
</div>




<div class="layerPopup zoom-anim-dialog mfp-hide" id="fregister_term" style="font-size:14px;width:100%;min-width:600px;max-width:800px;">
	<h2 class="fs15 mb20">회원가입약관</h2>
	<?php echo get_text($config['cf_stipulation']) ?>
</div>

<div class="layerPopup zoom-anim-dialog mfp-hide" id="fregister_private" style="font-size:14px;width:100%;min-width:600px;max-width:800px;">
	<h2 class="fs15 mb20">개인정보처리방침안내</h2>
	<table>
		<caption>개인정보처리방침안내</caption>
		<thead>
		<tr>
			<th class="bold tcenter">목적</th>
			<th class="bold tcenter">항목</th>
			<th class="bold tcenter">보유기간</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>이용자 식별 및 본인여부 확인</td>
			<td>아이디, 이름, 비밀번호</td>
			<td>회원 탈퇴 시까지</td>
		</tr>
		<tr>
			<td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
			<td>연락처 (이메일, 휴대전화번호)</td>
			<td>회원 탈퇴 시까지</td>
		</tr>
		</tbody>
	</table>
</div>

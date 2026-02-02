<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div id="mb_confirm">

    <p class="fw500 mb20">
        <?php if ($url == 'member_leave.php') { ?>
        비밀번호를 입력하시면 회원탈퇴가 완료됩니다.
        <?php }else{ ?>
        회원정보를 안전하게 보호하기 위해<br>
		비밀번호를 한번 더 입력해주세요.
        <?php }  ?>
    </p>

    <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
    <input type="hidden" name="w" value="u">

    <fieldset class="flex column gap10">
		<input type="text" name="" value="<?=$member['mb_id']?>"class="/lg w-full bg-gray" readonly>
        <input type="password" name="mb_password" id="mb_confirm_pw" placeholder="비밀번호" required class="frm_input /lg" size="15" maxLength="20">
        <input type="submit" value="확인" id="btn_submit" class="_btn/lg/mainColor mt10">
    </fieldset>

    </form>

</div>

<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>

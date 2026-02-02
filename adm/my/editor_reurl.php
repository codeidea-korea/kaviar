<?php
$sub_menu = "110600";
include_once('./_common.php');
//include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$g5['title'] = 'URL 일괄 변경';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>
<style>
ul.list-number{counter-reset:list-number;line-height:1em} 
ul.list-number li{counter-increment:list-number;}
ul.list-number li:before{content:counter(list-number)'. ';}
</style>

<div class="local_desc02 local_desc">
    <div>
        <b>사이트도메인 변경시 사이트 내에 기존 URL을 (현재 사이트 URL)로 변경합니다.</b>
    </div>
</div>

<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="" id="token">

<section id="img_rename">
    <div class="tbl_frm01 tbl_wrap">
       <table>
        <caption>이미지주소변경</caption>
        <colgroup>
			<col width="150">
			<col width="550">
			<col width="200">
			<col>
		</colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="previous_site">이전 URL<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('이전 사이트의 이미지 주소를 정확하게 입력해주세요. ex) http://test.co.kr') ?>
                <input type="text" name="previous_site" value="" id="previous_site" class="span400" size="30" required>
            </td>
            <th scope="row"><label for="now_site">변경 URL (현재 사이트 URL)<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('수정불가.') ?>
                <input type="text" name="now_site" value="<?php echo G5_URL ?>" id="now_site" class="span400" size="30">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f)
{
    f.action = "./editor_reurl_update.php";
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>
<?php
if (!defined('_GNUBOARD_')) exit;
?>

<form name="fmember" id="fmember" action="<?=$_my_url?>/member_form_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<section class="mybox blue">
<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="mb_id">아이디<?php echo $sound_only ?></label></th>
        <td>
            <input type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id" <?php echo $required_mb_id ?> class="frm_input <?php echo $required_mb_id_class ?>" size="15"  maxlength="20">
            <?php if ($w=='u'){ ?><a href="<?=G5_ADMIN_URL?>/boardgroupmember_form.php?mb_id=<?php echo $mb['mb_id'] ?>" class="btn_frmline">접근가능그룹보기</a><?php } ?>
        </td>
        <th scope="row"><label for="mb_password">비밀번호<?php echo $sound_only ?></label></th>
        <td><input type="password" name="mb_password" id="mb_password" <?php echo $required_mb_password ?> class="frm_input <?php echo $required_mb_password ?>" size="15" maxlength="20"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_name">이름(실명)<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_name" value="<?php echo $mb['mb_name'] ?>" id="mb_name" required class="required frm_input" size="15"  maxlength="20"></td>
        <th scope="row"><label for="mb_nick">닉네임<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_nick" value="<?php echo $mb['mb_nick'] ?>" id="mb_nick" required class="required frm_input" size="15"  maxlength="20"></td>
    </tr>
<style>
	.bootstrap-select .dropdown-toggle.bs-placeholder:not([class*='selectColor-']){color:black !important}
</style>
    <tr>
        <th scope="row"><label for="mb_level">회원 권한</label></th>
        <td><?php echo get_member_level_select('mb_level', 1, $member['mb_level'], $mb['mb_level']) ?></td>
        <th scope="row">회원등급</th>
        <td>
			<?php echo get_member_grade_select('mb_grade', $mb['mb_grade'], $mb['mb_id']) ?>
			<input type="hidden" id="mb_grades" name="mb_grades">
		</td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_email">E-mail<strong class="sound_only">필수</strong></label></th>
        <td><input type="text" name="mb_email" value="<?php echo $mb['mb_email'] ?>" id="mb_email" maxlength="100" required class="required frm_input email" size="30"></td>
        <th scope="row"><label for="mb_homepage">홈페이지</label></th>
        <td><input type="text" name="mb_homepage" value="<?php echo $mb['mb_homepage'] ?>" id="mb_homepage" class="frm_input" maxlength="255" size="15"></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_hp">휴대폰번호</label></th>
        <td><input type="text" name="mb_hp" value="<?php echo $mb['mb_hp'] ?>" id="mb_hp" class="frm_input" size="15" maxlength="20">
		<input type="hidden" name="mb_hp_orgin" value="<?php echo $mb['mb_hp'] ?>" >
		</td>
        <th scope="row"><label for="mb_tel">전화번호</label></th>
        <td><input type="text" name="mb_tel" value="<?php echo $mb['mb_tel'] ?>" id="mb_tel" class="frm_input" size="15" maxlength="20"></td>
    </tr>
    <tr>
        <th scope="row">본인확인방법</th>
        <td>
            <input type="radio" name="mb_certify_case" value="simple" id="mb_certify_sa" <?php if($mb['mb_certify'] == 'simple') echo 'checked="checked"'; ?> data-label="간편인증">
            <input type="radio" name="mb_certify_case" value="hp" id="mb_certify_hp" <?php if($mb['mb_certify'] == 'hp') echo 'checked="checked"'; ?> data-class="ml20" data-label="휴대폰">
            <input type="radio" name="mb_certify_case" value="ipin" id="mb_certify_ipin" <?php if($mb['mb_certify'] == 'ipin') echo 'checked="checked"'; ?> data-class="ml20" data-label="아이핀">
        </td>
		<th scope="row">포인트</th>
        <td><a href="<?=G5_ADMIN_URL?>/point_list.php?sfl=mb_id&amp;stx=<?php echo $mb['mb_id'] ?>" target="_blank"><?php echo number_format($mb['mb_point']) ?></a> 점</td>
    </tr>
	<tr>
        <th scope="row">생년월일</th>
        <td>
           <? $births = explode("-",$mb['mb_births']);
		  
		   ?>
				<select name="mb_year" id="select_year" class="selectpicker flex1.7">
					<option value="">년도</option>
			<?  $Date = date("Y");
				for($y=1950; $y<=$Date; $y++){?>
					<option value="<?=$y?>" <?=($y==$births[0]?"selected":"")?>><?=$y?></option>
			<?}?>
				</select>
				<select name="mb_month" id="select_month" class="selectpicker flex1">
					<option value="">월</option>
			<?
				for($mm=1; $mm<13; $mm++){?>
					<option value="<?=$mm?>" <?=($mm==$births[1]?"selected":"")?>><?=$mm?></option>
			<?}?>
				</select>
				<select name="mb_day" id="select_day" class="selectpicker flex1">
					<option value="">일</option>
			<?
				for($dd=1; $dd<32; $dd++){?>
					<option value="<?=$dd?>" <?=($dd==$births[2]?"selected":"")?>><?=$dd?></option>
			<?}?>
				</select>
			
        </td>
        <th scope="row">사업자확인</th>
        <td>
			<label class="radio-label"><input type="checkbox" name="mb_buisness" id="mb_buisness" <?=($mb['mb_buisness']=="1"?"checked":"")?>><span></span></label>
        </td>
    </tr>
	 <tr>
        <th scope="row">성별</th>
        <td>
            <label class="radio-label"><input type="radio" name="mb_sexs" value="1" <?=($mb['mb_sexs']=="1"?"checked":"")?>><span></span>남자</label>
			<label class="radio-label"><input type="radio" name="mb_sexs" value="2" <?=($mb['mb_sexs']=="2"?"checked":"")?>><span></span>여자</label>
        </td>
        <th scope="row"></th>
        <td>
          
        </td>
    </tr>
    <tr>
        <th scope="row">본인확인</th>
        <td>
            <input type="radio" name="mb_certify" value="1" id="mb_certify_yes" <?php echo $mb_certify_yes; ?> data-label="예">
            <input type="radio" name="mb_certify" value="" id="mb_certify_no" <?php echo $mb_certify_no; ?> data-class="ml20" data-label="아니오">
        </td>
        <th scope="row">성인인증</th>
        <td>
            <input type="radio" name="mb_adult" value="1" id="mb_adult_yes" <?php echo $mb_adult_yes; ?> data-label="예">
            <input type="radio" name="mb_adult" value="0" id="mb_adult_no" <?php echo $mb_adult_no; ?> data-class="ml20" data-label="아니오">
        </td>
    </tr>
    <tr>
        <th scope="row">주소</th>
        <td colspan="3" class="td_addr_line">
            <label for="mb_zip" class="sound_only">우편번호</label>
            <input type="text" name="mb_zip" value="<?php echo $mb['mb_zip1'].$mb['mb_zip2']; ?>" id="mb_zip" class="frm_input readonly" size="5" maxlength="6">
            <button type="button" class="btn_frmline" onclick="win_zip('fmember', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
            <input type="text" name="mb_addr1" value="<?php echo $mb['mb_addr1'] ?>" id="mb_addr1" class="frm_input readonly" size="60">
            <label for="mb_addr1">기본주소</label><br>
            <input type="text" name="mb_addr2" value="<?php echo $mb['mb_addr2'] ?>" id="mb_addr2" class="frm_input" size="60">
            <label for="mb_addr2">상세주소</label>
            <br>
            <input type="text" name="mb_addr3" value="<?php echo $mb['mb_addr3'] ?>" id="mb_addr3" class="frm_input" size="60">
            <label for="mb_addr3">참고항목</label>
            <input type="hidden" name="mb_addr_jibeon" value="<?php echo $mb['mb_addr_jibeon']; ?>"><br>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_img">사업자등록증</label></th>
        <td colspan="3">            
            <?php
            $mb_dir = substr($mb['mb_id'],0,2);
            $imb_img_file = G5_DATA_PATH.'/member_image/'.$mb_dir.'/'.get_mb_icon_name($mb['mb_id']).'.gif';
			$upImg = file_exists($imb_img_file) ? get_member_profile_img($mb['mb_id']).'<label><input type="checkbox" name="del_mb_img" value="1">삭제</label>' : '';
			echo '<input type="file" name="mb_img" id="mb_img" class="myfile">';
			echo '<div class="upImg" style="max-width:150px">'.$upImg.'</div>';
            ?>
        </td>
    </tr>
<script language="javascript">
function news(url){

	window.open("member_popup.php?url="+url,"new", "width=500, height=800, left=30, top=30, scrollbars=no,titlebar=no,status=no,resizable=no,fullscreen=no");
}
</script>
<img src="이미지주소"  style="cursor:hand"/>
    <tr>
        <th scope="row">메일 수신</th>
        <td>
            <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?> data-label="예">
            <input type="radio" name="mb_mailling" value="0" id="mb_mailling_no" <?php echo $mb_mailling_no; ?> data-class="ml20" data-label="아니오">
        </td>
        <th scope="row"><label for="mb_sms_yes">SMS 수신</label></th>
        <td>
            <input type="radio" name="mb_sms" value="1" id="mb_sms_yes" <?php echo $mb_sms_yes; ?> data-label="예">
            <input type="radio" name="mb_sms" value="0" id="mb_sms_no" <?php echo $mb_sms_no; ?> data-class="ml20" data-label="아니오">
        </td>
    </tr>
    <tr>
        <th scope="row">정보 공개</th>
        <td>
            <input type="radio" name="mb_open" value="1" id="mb_open_yes" <?php echo $mb_open_yes; ?> data-label="예">
            <input type="radio" name="mb_open" value="0" id="mb_open_no" <?php echo $mb_open_no; ?> data-class="ml20" data-label="아니오">
        </td>
		<th scope="row">유입경로</th>
        <td>
            <select name="mb_sns" id="mb_sns" class="selectpicker flex1.7" >
				<option value="">-유입경로-</option>
				<option value="검색" <?=('검색'==$mb['mb_sns']?"selected":"")?>>검색</option>
				<option value="SNS" <?=('SNS'==$mb['mb_sns']?"selected":"")?>>SNS</option>
				<option value="추천" <?=('추천'==$mb['mb_sns']?"selected":"")?>>추천</option>
				<option value="광고" <?=('광고'==$mb['mb_sns']?"selected":"")?>>광고</option>
				<option value="기타" <?=('기타'==$mb['mb_sns']?"selected":"")?>>기타</option>
			</select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_signature">서명</label></th>
        <td colspan="3"><textarea  name="mb_signature" id="mb_signature"><?php echo $mb['mb_signature'] ?></textarea></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_profile">자기 소개</label></th>
        <td colspan="3"><textarea name="mb_profile" id="mb_profile"><?php echo $mb['mb_profile'] ?></textarea></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_memo">메모</label></th>
        <td colspan="3"><textarea name="mb_memo" id="mb_memo"><?php echo $mb['mb_memo'] ?></textarea></td>
    </tr>
    <tr>
        <th scope="row"><label for="mb_cert_history">본인인증 내역</label></th> 
        <td colspan="3">
            <?php 
            $cnt = 0;
            while ($row = sql_fetch_array($mb_cert_history)) {
                $cnt++;
                switch($row['ch_type']){
                    case 'simple':
                        $cert_type = '간편인증';
                        break;
                    case 'hp':
                        $cert_type = '휴대폰';
                        break;
                    case 'ipin':
                        $cert_type = '아이핀';
                        break;
                }
            ?>
            <div>
                [<?php echo $row['ch_datetime']; ?>]
                <?php echo $row['mb_id']; ?> /
                <?php echo $row['ch_name']; ?> /
                <?php echo $row['ch_hp']; ?> /
                <?php echo $cert_type; ?>
            </div>
            <?php } ?>

            <?php if ($cnt == 0) { ?>
                본인인증 내역이 없습니다.
            <?php } ?>
        </td>
    </tr>

    <?php if ($w == 'u') { ?>
    <tr>
        <th scope="row">회원가입일</th>
        <td><?php echo $mb['mb_datetime'] ?></td>
        <th scope="row">최근접속일</th>
        <td><?php echo $mb['mb_today_login'] ?></td>
    </tr>
    <tr>
        <th scope="row">IP</th>
        <td colspan="3"><?php echo $mb['mb_ip'] ?></td>
    </tr>
    <?php if ($config['cf_use_email_certify']) { ?>
    <tr>
        <th scope="row">인증일시</th>
        <td colspan="3">
            <?php if ($mb['mb_email_certify'] == '0000-00-00 00:00:00') { ?>
            <?php echo help('회원님이 메일을 수신할 수 없는 경우 등에 직접 인증처리를 하실 수 있습니다.') ?>
            <input type="checkbox" name="passive_certify" id="passive_certify">
            <label for="passive_certify">수동인증</label>
            <?php } else { ?>
            <?php echo $mb['mb_email_certify'] ?>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
    <?php } ?>

    <?php if ($config['cf_use_recommend']) { // 추천인 사용 ?>
    <tr>
        <th scope="row">추천인</th>
        <td colspan="3"><?php echo ($mb['mb_recommend'] ? get_text($mb['mb_recommend']) : '없음'); // 081022 : CSRF 보안 결함으로 인한 코드 수정 ?></td>
    </tr>
    <?php } ?>

    <tr>
        <th scope="row"><label for="mb_leave_date">탈퇴일자</label></th>
        <td>
            <input type="text" name="mb_leave_date" value="<?php echo $mb['mb_leave_date'] ?>" id="mb_leave_date" class="frm_input" maxlength="8">
            <input type="checkbox" value="<?php echo date("Ymd"); ?>" id="mb_leave_date_set_today" onclick="if (this.form.mb_leave_date.value==this.form.mb_leave_date.defaultValue) {
this.form.mb_leave_date.value=this.value; } else { this.form.mb_leave_date.value=this.form.mb_leave_date.defaultValue; }" data-class="ml15" data-label="탈퇴일을 오늘로 지정">
        </td>
        <th scope="row">접근차단일자</th>
        <td>
            <input type="text" name="mb_intercept_date" value="<?php echo $mb['mb_intercept_date'] ?>" id="mb_intercept_date" class="frm_input" maxlength="8">
            <input type="checkbox" value="<?php echo date("Ymd"); ?>" id="mb_intercept_date_set_today" onclick="if
(this.form.mb_intercept_date.value==this.form.mb_intercept_date.defaultValue) { this.form.mb_intercept_date.value=this.value; } else {
this.form.mb_intercept_date.value=this.form.mb_intercept_date.defaultValue; }" data-class="ml15" data-label="접근차단일을 오늘로 지정">
        </td>
    </tr>

    <?php
    //소셜계정이 있다면
    if(function_exists('social_login_link_account') && $mb['mb_id'] ){
        if( $my_social_accounts = social_login_link_account($mb['mb_id'], false, 'get_data') ){ ?>

    <tr>
    <th>소셜계정목록</th>
    <td colspan="3">
        <ul class="social_link_box">
            <li class="social_login_container">
                <h4>연결된 소셜 계정 목록</h4>
                <?php foreach($my_social_accounts as $account){     //반복문
                    if( empty($account) ) continue;

                    $provider = strtolower($account['provider']);
                    $provider_name = social_get_provider_service_name($provider);
                ?>
                <div class="account_provider" data-mpno="social_<?php echo $account['mp_no'];?>" >
                    <div class="sns-wrap-32 sns-wrap-over">
                        <span class="sns-icon sns-<?php echo $provider; ?>" title="<?php echo $provider_name; ?>">
                            <span class="ico"></span>
                            <span class="txt"><?php echo $provider_name; ?></span>
                        </span>

                        <span class="provider_name"><?php echo $provider_name;   //서비스이름?> ( <?php echo $account['displayname']; ?> )</span>
                        <span class="account_hidden" style="display:none"><?php echo $account['mb_id']; ?></span>
                    </div>
                    <div class="btn_info"><a href="<?php echo G5_SOCIAL_LOGIN_URL.'/unlink.php?mp_no='.$account['mp_no'] ?>" class="social_unlink" data-provider="<?php echo $account['mp_no'];?>" >연동해제</a> <span class="sound_only"><?php echo substr($account['mp_register_day'], 2, 14); ?></span></div>
                </div>
                <?php } //end foreach ?>
            </li>
        </ul>
        <script>
        jQuery(function($){
            $(".account_provider").on("click", ".social_unlink", function(e){
                e.preventDefault();

                if (!confirm('정말 이 계정 연결을 삭제하시겠습니까?')) {
                    return false;
                }

                var ajax_url = "<?php echo G5_SOCIAL_LOGIN_URL.'/unlink.php' ?>";
                var mb_id = '',
                    mp_no = $(this).attr("data-provider"),
                    $mp_el = $(this).parents(".account_provider");

                    mb_id = $mp_el.find(".account_hidden").text();

                if( ! mp_no ){
                    alert('잘못된 요청! mp_no 값이 없습니다.');
                    return;
                }

                $.ajax({
                    url: ajax_url,
                    type: 'POST',
                    data: {
                        'mp_no': mp_no,
                        'mb_id': mb_id
                    },
                    dataType: 'json',
                    async: false,
                    success: function(data, textStatus) {
                        if (data.error) {
                            alert(data.error);
                            return false;
                        } else {
                            alert("연결이 해제 되었습니다.");
                            $mp_el.fadeOut("normal", function() {
                                $(this).remove();
                            });
                        }
                    }
                });

                return;
            });
        });
        </script>

    </td>
    </tr>

    <?php
        }   //end if
    }   //end if

    run_event('admin_member_form_add', $mb, $w, 'table');
    ?>

    <?php for ($i=1; $i<=10; $i++) { ?>
    <tr>
        <th scope="row"><label for="mb_<?php echo $i ?>">여분 필드 <?php echo $i ?></label></th>
        <td colspan="3"><input type="text" name="mb_<?php echo $i ?>" value="<?php echo $mb['mb_'.$i] ?>" id="mb_<?php echo $i ?>" class="frm_input" size="30" maxlength="255"></td>
    </tr>
    <?php } ?>

    </tbody>
    </table>
</div>
</section>
<style>
h2 {font-size:20px;font-weight:bold}
</style>
<div style="padding-top:20px">
<h2>주문내역</h2>
<?php
	include_once(G5_ADMIN_PATH.'/shop_admin/orderlist.sub.php');
?>

<div style="padding-top:20px">
<h2>상품후기</h2>
<?php
	include_once(G5_ADMIN_PATH.'/shop_admin/itemuselist.sub.php');
?>
</div>

<div style="padding-top:20px">
<h2>상품문의</h2>
<?php
	include_once(G5_ADMIN_PATH.'/shop_admin/itemqalist.sub.php');
?>

<div style="padding-top:20px">
<h2>1:1문의</h2>
<?php
	include_once(G5_ADMIN_PATH.'/shop_admin/itemonelist.sub.php');
?>

</div>
<div class="btn_fixed_top">
    <a href="<?=G5_ADMIN_URL?>/member_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
</div>
</form>

<script>
function fmember_submit(f)
{
	var selectElement = document.getElementById("mb_grade");
    var selectedValue = selectElement.value;

	$("#mb_grades").val(selectedValue);
    if (!f.mb_icon.value.match(/\.(gif|jpe?g|png|webp)$/i) && f.mb_icon.value) {
        alert('아이콘은 이미지 파일만 가능합니다.');
        return false;
    }

    if (!f.mb_img.value.match(/\.(gif|jpe?g|png|webp)$/i) && f.mb_img.value) {
        alert('회원이미지는 이미지 파일만 가능합니다.');
        return false;
    }

	

    return true;
}
</script>
<?php
run_event('admin_member_form_after', $mb, $w);

include_once(G5_ADMIN_PATH.'/admin.tail.php');
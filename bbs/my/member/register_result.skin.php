<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

if(file_exists(G5_THIS_PATH.'/member/register_result.skin.php')) {
	require_once(G5_THIS_PATH.'/member/register_result.skin.php');
	return;
} else if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/member/register_result.skin.php')) {
	require_once(G5_THEME_PATH.'/member/register_result.skin.php');
	return;
}

//가입환영 문자 및 이메일발송
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
$sms_content1 = $default['de_sms_cont1'];
$sms_content1 = str_replace("{이름}", $mb_name, $sms_content1);
$sms_content1 = str_replace("{회원아이디}", $mb_id, $sms_content1);
$sms_content1 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content1);

/*
$sms_content1 = str_replace("{주문번호}", $_POST['od_id'], $sms_content1);
$sms_content1 = str_replace("{주문금액}", number_format($_POST['od_total_price']), $sms_content1);
$sms_content1 = str_replace("{계좌정보}", $_POST['od_time'],   $sms_content1);
$sms_content1 = str_replace("{배송사}", $_POST['od_time'],    $sms_content1);
$sms_content1 = str_replace("{운송장번호}", $_POST['od_time'], $sms_content1);
$sms_content1 = str_replace("{소멸적립금}", $_POST['od_time'], $sms_content1);
$sms_content1 = str_replace("{소멸예정일}", $_POST['od_time'], $sms_content1);
*/

$receive_number = preg_replace("/[^0-9]/", "", $mb_hp); // 수신자번호 (받는사람)

if($config['cf_sms_use'] == "aligo"){

	$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호 (보내는사람)
	//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
	aligo_sms_call($sms_content1, $receive_number, $send_number, "", "", "");

}else if($config['cf_sms_use'] == "naver"){
	$send_number = preg_replace("/[^0-9]/", "", $config['cf_naver_sender']); // 발신자번호 (보내는사람)
	$sms_type = 'LMS';
	//네이버문자발송
	naver_sms_call($msg, $receive_number, $send_number, $sms_type);

}

user_email_call('가입완료', $mb_email, $mb_id, $mb_name, $default['de_admin_company_name'],$sms_content1);

?>

<!-- 회원가입결과 시작 { -->
<div id="reg_result" class="register">
    <p class="reg_result_p">
        <strong><?php echo get_text($mb['mb_name']); ?></strong>님의 회원가입을 진심으로 축하합니다.
    </p>

	<?php if($config['cf_use_membercode'] && $code['code_name']) echo '<p class="fs20 fw600">'.$code['code_name'].' 회원입니다.</p>'; ?>

    <?php if (is_use_email_certify()) {  ?>
    <p class="result_txt">
        회원 가입 시 입력하신 이메일 주소로 인증메일이 발송되었습니다.<br>
        발송된 인증메일을 확인하신 후 인증처리를 하시면 사이트를 원활하게 이용하실 수 있습니다.
    </p>
    <div id="result_email">
        <span>아이디</span>
        <strong><?php echo $mb['mb_id'] ?></strong><br>
        <span>이메일 주소</span>
        <strong><?php echo $mb['mb_email'] ?></strong>
    </div>
    <p>
        이메일 주소를 잘못 입력하셨다면, 사이트 관리자에게 문의해주시기 바랍니다.
    </p>
    <?php }  ?>

    <p class="result_txt">
        회원님의 비밀번호는 아무도 알 수 없는 암호화 코드로 저장되므로 안심하셔도 좋습니다.<br>
        아이디, 비밀번호 분실시에는 회원가입시 입력하신 이메일 주소를 이용하여 찾을 수 있습니다.
    </p>

    <p class="result_txt">
        회원 탈퇴는 언제든지 가능하며 일정기간이 지난 후, 회원님의 정보는 삭제하고 있습니다.<br><br>
        감사합니다.
    </p>
</div>
<!-- } 회원가입결과 끝 -->
<div class="btn_confirm_reg p20">
	<a href="<?php echo G5_URL ?>/" class="reg_btn_submit">메인으로</a>
</div>
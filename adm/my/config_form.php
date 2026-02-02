<?php
if (!defined('_GNUBOARD_')) exit;

if (!$config['cf_icode_server_ip'])   $config['cf_icode_server_ip'] = '211.172.232.124';
if (!$config['cf_icode_server_port']) $config['cf_icode_server_port'] = '7295';

$userinfo = array('payment'=>'');
if ($config['cf_sms_use'] && $config['cf_icode_id'] && $config['cf_icode_pw']) {
    $userinfo = get_icode_userinfo($config['cf_icode_id'], $config['cf_icode_pw']);
}

// css,js 로드시 경로뒤 파라미터에 수정일자 대신, 랜덤숫자로 대체
// 작업중일때 캐시없이 새로고침 사용하려고 만듬.
if (!isset($config['cf_url_random'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_url_random` tinyint(4) NOT NULL DEFAULT '0' ", true);
}
if (!isset($config['cf_show_include_admin'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_show_include_admin` tinyint(4) NOT NULL DEFAULT '1' ", true);
}
?>

<form name="fconfigform" id="fconfigform" method="post" onsubmit="return fconfigform_submit(this);">
<input type="hidden" name="token" value="" id="token">


<section id="anc_cf_basic"  class="mybox">
    <h2 class="mybox-title">홈페이지 기본환경 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>홈페이지 기본환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
		<?php if($is_admin=='super') { ?>
        <tr style="background:rgba(255, 92, 92, 0.035)">
            <th scope="row"><label class="color-blue">사이트 작업중일때</label></th>
            <td colspan="3">
				<div class="flex flex-middle gap30">
					<input type="checkbox"name="cf_url_random" value="1" class="toggle-light" <?=$config['cf_url_random']?'checked':'';?> data-class="w-90" data-on="작업중" data-off="작업완료">
					<div>
						<p class="help-block">
							작업중으로 채크시 모든 css, js파일을 로드할때 캐쉬없이 매번 새로 불러오고,<br>
							참조되고 있는 include 파일 목록을 화면에 출력합니다.
						</p>
						<div class="flex flex-middle mt10">
							<input type="checkbox"name="cf_show_include_admin" value="1" class="" <?=$config['cf_show_include_admin']?'checked':'';?> data-label="참조파일 로그인한 관리자에게만 노출">
							<span class="help-block">참조파일 목록을 로그인한 관리자에게만 노출합니다. 채크시 로그인전 화면(로그인,회원가입 등..)에서는 출력되지 않습니다.</span>
						</div>
					</div>
				</div>
			</td>
        </tr>
		<?php } else { ?>
		<input type="hidden"name="cf_url_random" value="<?=$config['cf_url_random']?>">
		<?php } ?>
		<tr>
            <th scope="row"><label for="cf_title">홈페이지 제목<strong class="sound_only">필수</strong></label></th>
            <td colspan="3"><input type="text" name="cf_title" value="<?php echo get_sanitize_input($config['cf_title']); ?>" id="cf_title" required class="required frm_input" size="40" placeholder="홈페이지 제목"></td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_admin">최고관리자<strong class="sound_only">필수</strong></label></th>
            <td colspan="3"><?php echo get_member_id_select('cf_admin', 10, $config['cf_admin'], 'required') ?></td>
        </tr>

		<tr>
            <th scope="row"><label for="cf_admin">IOS로그인 노출유무<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
				<input type="checkbox" name="cf_use_ioslogin" value="1" id="cf_use_ioslogin" <?php echo $config['cf_use_ioslogin']?'checked':''; ?> data-label="사용">
				<input type="text" name="cf_ios_version" value="<?php echo get_sanitize_input($config['cf_ios_version']); ?>" id="cf_ios_version" class="required frm_input" size="40" placeholder="버전등록">
			</td>
        </tr>
	<!--
		<tr>
            <th scope="row"><label for="cf_admin">담당자번호</label></th>
            <td colspan="3"><input type="text" name="cf_manager_hp" value="<?=$config['cf_manager_hp']?>" id="cf_manager_hp" class="frm_input" size="40" placeholder="담당자 전화번호"></td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_admin">담당자 이메일</label></th>
            <td colspan="3"><input type="text" name="cf_manager_email" value="<?=$config['cf_manager_email']?>" id="cf_manager_email" class="frm_input" size="40" placeholder="담당자 이메일"></td>
        </tr>
	-->
		<?php if($magma405) { ?>
		<tr>
            <th scope="row"><label class="color-red">최고관리자 추가</label></th>
            <td colspan="3">
				<?php echo help('최고관리자 추가 - 회원ID 입력') ?>
				<input type="text" name="cf_admin_add" value="<?php echo get_sanitize_input($config['cf_admin_add']); ?>" id="cf_admin_add"  class="w-full" size="40" placeholder="여러명일때 ,로 구분">
			</td>
        </tr>
		<?php } else { ?>
		<input type="hidden"name="cf_admin_add" value="<?=$config['cf_admin_add']?>">
		<?php } ?>
        <tr>
            <th scope="row"><label for="cf_admin_email">관리자 메일 주소<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('관리자가 보내고 받는 용도로 사용하는 메일 주소를 입력합니다. (회원가입, 인증메일, 테스트, 회원메일발송 등에서 사용)') ?>
                <input type="text" name="cf_admin_email" value="<?php echo get_sanitize_input($config['cf_admin_email']); ?>" id="cf_admin_email" required class="required email frm_input" size="40" data-label="메일 주소">
				<input type="text" name="cf_admin_email_name" value="<?php echo get_sanitize_input($config['cf_admin_email_name']); ?>" id="cf_admin_email_name" required class="required frm_input" size="40" data-class="ml20" data-label="메일 발송이름">
            </td>
        </tr>
		<tr>
            <th scope="row"><label>사이트 대표이미지</label></th>
            <td>
                <?php
				$sitemain_img_path = G5_DATA_PATH.'/file/site_main.png';
				$sitemain_img_url = G5_DATA_URL.'/file/site_main.png';
				$upImg_sitemain_img = file_exists($sitemain_img_path) ? '<img src="'.get_url($sitemain_img_url).'"><label class="del_file"><input type="checkbox" name="del_sitemain_img" value="1">삭제</label>' : '';
				echo '<input type="file" name="site_main" class="myfile">';
				echo '<div class="upImg">'.$upImg_sitemain_img.'</div>';
				if(file_exists($sitemain_img_path)) {
					echo '<p class="help-block mt10">&lt;meta property="og:image" content="'.$sitemain_img_url.'" /&gt; <b>적용됨</b></p>';
					echo '<p class="help-block mt10">카카오링크 이미지 적용이 안될때 <a href="https://developers.kakao.com/tool/clear/og" class="ml20 btn_frmline">카카오톡 캐쉬삭제</a></p>';
				} ?>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_add_meta">추가 메타태그</label></th>
            <td colspan="3">
                <?php echo help('추가로 사용하실 meta 태그를 입력합니다.'); ?>
				<div class="flex">
					<textarea name="cf_add_meta" id="cf_add_meta" placeholder="검색엔진 최적화 관련 추가할 메타태그를 입력해주세요." class="autosize flex1"  style="min-height:100px;"><?php echo $config['cf_add_meta']; ?></textarea>
					<p class="ml15 help-block" style="color:rgba(71,78,103,0.4);line-height:1.3em;">
						&lt;meta property="og:title" content="컨텐츠 제목" /&gt;<br>
						&lt;meta property="og:url" content="페이지 표준 url" /&gt;<br>
						&lt;meta property="og:description" content="사이트 설명 문구" /&gt;<br>						
						&lt;meta name="description" content="사이트 설명 문구 적는곳" /&gt;<br>
						&lt;meta name="keywords" content="대표키워드 적는곳" /&gt;
					</p>
				</div>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_analytics">방문자분석 스크립트</label></th>
            <td colspan="3">
                <?php echo help('방문자분석 스크립트 코드를 입력합니다. 예) 구글 애널리틱스'); ?>
                <textarea name="cf_analytics" id="cf_analytics" class="autosize flex1"  style="min-height:100px;"><?php echo get_text($config['cf_analytics']); ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_point">포인트 사용</label></th>
            <td colspan="3"><input type="checkbox" name="cf_use_point" value="1" id="cf_use_point" <?php echo $config['cf_use_point']?'checked':''; ?> data-label="사용"></td>
        </tr>
        <tr class="tr_point">
            <th scope="row"><label for="cf_login_point">로그인시 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
                <?php echo help('회원이 로그인시 하루에 한번만 적립') ?>
                <input type="text" name="cf_login_point" value="<?php echo (int) $config['cf_login_point'] ?>" id="cf_login_point" required class="required frm_input" size="5" data-label-inline="점">
            </td>
            <th scope="row"><label for="cf_memo_send_point">쪽지보낼시 차감 포인트<strong class="sound_only">필수</strong></label></th>
            <td>
				<?php echo help('양수로 입력하십시오. 0점은 쪽지 보낼시 포인트를 차감하지 않습니다.') ?>
                <input type="text" name="cf_memo_send_point" value="<?php echo (int) $config['cf_memo_send_point']; ?>" id="cf_memo_send_point" required class="required frm_input" size="5" data-label-inline="점">
            </td>
        </tr>
		<tr class="tr_point">
            <th scope="row"><label for="cf_point_term">포인트 유효기간</label></th>
            <td colspan="3">
                <?php echo help('기간을 0으로 설정시 포인트 유효기간이 적용되지 않습니다.') ?>
                <input type="text" name="cf_point_term" value="<?php echo (int) $config['cf_point_term']; ?>" id="cf_point_term" required class="required frm_input" size="5" data-label-inline="일">
            </td>
        </tr>        
        </tbody>
        </table>
    </div>
	<button type="button" class="get_theme_confc btn_02 btn" data-type="conf_skin" >테마 스킨설정 가져오기</button>
</section>

<section id="" class="mybox hide">
    <h2 class="mybox-title toggle">보안 관련</h2>	
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_captcha">캡챠 선택<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('사용할 캡챠를 선택합니다.<br>1) Kcaptcha 는 그누보드5의 기본캡챠입니다. ( 문자입력 )<br>2) reCAPTCHA V2 는 구글에서 서비스하는 원클릭 형식의 간편한 캡챠입니다. ( 모바일 친화적 UI )<br>3) Invisible reCAPTCHA 는 구글에서 서비스하는 안보이는 형식의 캡챠입니다. ( 간혹 퀴즈를 풀어야 합니다. )<br>') ?>
                <select name="cf_captcha" id="cf_captcha" required class="required">
                <option value="kcaptcha" <?php echo get_selected($config['cf_captcha'], 'kcaptcha') ; ?>>Kcaptcha</option>
                <option value="recaptcha" <?php echo get_selected($config['cf_captcha'], 'recaptcha') ; ?>>reCAPTCHA V2</option>
                <option value="recaptcha_inv" <?php echo get_selected($config['cf_captcha'], 'recaptcha_inv') ; ?>>Invisible reCAPTCHA</option>
                </select>
            </td>
        </tr>
        <tr class="kcaptcha_mp3">
            <th scope="row"><label for="cf_captcha_mp3">음성캡챠 선택<strong class="sound_only">필수</strong></label></th>
            <td colspan="3">
                <?php echo help('kcaptcha 사용시 '.str_replace(array('recaptcha_inv', 'recaptcha'), 'kcaptcha', G5_CAPTCHA_URL).'/mp3 밑의 음성 폴더를 선택합니다.') ?>
                <select name="cf_captcha_mp3" id="cf_captcha_mp3" required class="required">
                <?php
                $arr = get_skin_dir('mp3', str_replace(array('recaptcha_inv', 'recaptcha'), 'kcaptcha', G5_CAPTCHA_PATH));
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">선택</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_captcha_mp3'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
		<tr>
			<th scope="row"><label for="cf_recaptcha_site_key">구글 reCAPTCHA Site key</label></th>
			<td colspan="3">
            <?php echo help('reCAPTCHA V2와 Invisible reCAPTCHA 캡챠의 sitekey 와 secret 키는 동일하지 않고, 서로 발급받는 키가 다릅니다.') ?>
            <input type="text" name="cf_recaptcha_site_key" value="<?php echo get_sanitize_input($config['cf_recaptcha_site_key']); ?>" id="cf_recaptcha_site_key" class="frm_input" size="52"> <a href="https://www.google.com/recaptcha/admin" target="_blank" class="btn_frmline">reCAPTCHA 등록하기</a>
            </td>
		</tr>
		<tr>
            <th scope="row"><label for="cf_recaptcha_secret_key">구글 reCAPTCHA Secret key</label></th>
            <td colspan="3">
                <input type="text" name="cf_recaptcha_secret_key" value="<?php echo get_sanitize_input($config['cf_recaptcha_secret_key']); ?>" id="cf_recaptcha_secret_key" class="frm_input" size="52">
            </td>
		</tr>
        
        <tr>
            <th scope="row"><label for="cf_possible_ip">접근가능 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터만 접근할 수 있습니다.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_possible_ip" id="cf_possible_ip"><?php echo get_sanitize_input($config['cf_possible_ip']); ?></textarea>
            </td>
            <th scope="row"><label for="cf_intercept_ip">접근차단 IP</label></th>
            <td>
                <?php echo help('입력된 IP의 컴퓨터는 접근할 수 없음.<br>123.123.+ 도 입력 가능. (엔터로 구분)') ?>
                <textarea name="cf_intercept_ip" id="cf_intercept_ip"><?php echo get_sanitize_input($config['cf_intercept_ip']); ?></textarea>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><label for="cf_syndi_token">네이버 신디케이션 연동키</label></th>
            <td colspan="3">
                <?php if (!function_exists('curl_init')) echo help('<b>경고) curl이 지원되지 않아 네이버 신디케이션을 사용할수 없습니다.</b>'); ?>
                <?php echo help('네이버 신디케이션 연동키(token)을 입력하면 네이버 신디케이션을 사용할 수 있습니다.<br>연동키는 <a href="http://webmastertool.naver.com/" target="_blank"><u>네이버 웹마스터도구</u></a> -> 네이버 신디케이션에서 발급할 수 있습니다.') ?>
                <input type="text" name="cf_syndi_token" value="<?php echo isset($config['cf_syndi_token']) ? get_sanitize_input($config['cf_syndi_token']) : ''; ?>" id="cf_syndi_token" class="frm_input" size="70">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_syndi_except">네이버 신디케이션 제외게시판</label></th>
            <td colspan="3">
                <?php echo help('네이버 신디케이션 수집에서 제외할 게시판 아이디를 | 로 구분하여 입력하십시오. 예) notice|adult<br>참고로 그룹접근사용 게시판, 글읽기 권한 2 이상 게시판, 비밀글은 신디케이션 수집에서 제외됩니다.') ?>
                <input type="text" name="cf_syndi_except" value="<?php echo isset($config['cf_syndi_except']) ? get_sanitize_input($config['cf_syndi_except']) : ''; ?>" id="cf_syndi_except" class="frm_input" size="70">
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<section class="mybox">
    <h2 class="mybox-title">기본기능 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>추가기능설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>		
		<tr class="">
            <th scope="row"><label>자동등록방지 사용여부</label></th>
            <td>
				<input type="checkbox" name="cf_join_captcha" value="1" id="cf_join_captcha" class="" <?=$config['cf_join_captcha']?'checked':'';?> data-label="회원가입 사용">
				<input type="checkbox" name="cf_password_captcha" value="1" id="cf_password_captcha" class="" <?=$config['cf_password_captcha']?'checked':'';?> data-label="아이디/비번찾기 사용" data-class="ml30">
            </td>
        </tr>
		<tr>
            <th scope="row"><label>로그인 사용여부</label></th>
            <td>
				<select id="cf_use_login" name="cf_use_login" class="selectpicker">
					<option value="0" <?=get_selected($config['cf_use_login'], '0')?>>사용안함</option>
					<option value="1" <?=get_selected($config['cf_use_login'], '1')?>>pc, 모바일 둘다 사용</option>
					<option value="2" <?=get_selected($config['cf_use_login'], '2')?>>pc만 사용</option>
					<option value="3" <?=get_selected($config['cf_use_login'], '3')?>>모바일만 사용</option>
				</select>
				<input type="checkbox" name="cf_use_login_popup" value="1" id="cf_use_login_popup" class="" <?=$config['cf_use_login_popup']?'checked':''?> data-label="팝업 사용" data-class="ml30">
            </td>
        </tr>
		<tr>
            <th scope="row"><label>회원가입 사용여부</label></th>
            <td>
				<input type="checkbox" name="cf_use_join" value="1" id="cf_use_join" class="" <?=$config['cf_use_join']?'checked':''?> data-label="사용">
            </td>
        </tr>
		<tr>
            <th scope="row"><label>카카오 API</label></th>
            <td>
				<p>
					<label class="labelInput"><b class="label">JavaScript 키</b><input type="text" name="cf_kakao_app_key" value="<?=get_text($config['cf_kakao_app_key'])?>" id="cf_kakao_app_key" class="frm_input span350" size="50" maxlength="60"></label>
					<a href="https://developers.kakao.com/" target="_blank" class="btn ml10" style="height:26px;line-height:1em;background:#ffcc00;display:inline-flex;align-items:center;justify-content:center;color:#645d40">카카오 API 신청</a>
				</p>
				<p class="help-block mt5">* 카카오 지도 API를 사용하려면 카카오 API를 신청하고 javascript 키를 발급받아야 합니다.</p>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<section id="anc_cf_board" class="mybox">
    <h2 class="mybox-title">게시판 기본 설정</h2>	
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_delay_sec" class="myTip_" data-tip="cf_delay_sec">글쓰기 간격<strong class="sound_only">필수</strong></label></th>
            <td>
				<input type="text" name="cf_delay_sec" value="<?php echo $config['cf_delay_sec'] ?>" id="cf_delay_sec" required class="required numeric frm_input" size="3" data-label-inline="초"> 지난 후 가능
				<span class="help-block ml20">※ 도배글 방지</span>
			</td>
        </tr>		
        <tr>
            <th scope="row"><label for="cf_filter" class="myTip_" data-tip="cf_filter">단어 필터링</label></th>
            <td>
                <?php echo help('입력된 단어가 포함된 내용은 게시할 수 없습니다. 단어와 단어 사이는 ,로 구분합니다.') ?>
                <textarea name="cf_filter" id="cf_filter" class="autosize" style="min-height:80px;"><?php echo $config['cf_filter'] ?></textarea>
             </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_new_del" class="myTip_" data-tip="cf_new_del">최근게시물 보관기간</label></th>
            <td>
                <input type="text" name="cf_new_del" value="<?=$config['cf_new_del']?$config['cf_new_del']:'1825'?>" id="cf_new_del" class="frm_input" size="5" data-label-inline="일">
				<span class="help-block ml20">※ 설정일이 지난 최근게시물 자동 삭제</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_editor">에디터 선택</label></th>
            <td>
                <?php echo help(G5_EDITOR_URL.' 밑의 DHTML 에디터 폴더를 선택합니다.') ?>
                <select name="cf_editor" id="cf_editor">
                <?php
                $arr = get_skin_dir('', G5_EDITOR_PATH);
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">사용안함</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($config['cf_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_image_extension">이미지 업로드 확장자</label></th>
            <td colspan="3">
                <?php echo help('게시판 글작성시 이미지 파일 업로드 가능 확장자. | 로 구분') ?>
                <input type="text" name="cf_image_extension" value="<?php echo get_sanitize_input($config['cf_image_extension']); ?>" id="cf_image_extension" class="frm_input" size="70">
            </td>
        </tr>
		<tr class="tr_point">
            <th scope="row"><label>포인트<strong class="sound_only">필수</strong></label></th>
            <td>
				<div class="flex flex-middle gap20">
					<input type="text" name="cf_read_point" value="<?php echo (int) $config['cf_read_point'] ?>" id="cf_read_point" required class="required frm_input" size="3" data-label="글읽기 포인트" data-label-inline="점">
					<input type="text" name="cf_write_point" value="<?php echo (int) $config['cf_write_point'] ?>" id="cf_write_point" required class="required frm_input" size="3" data-label="글쓰기 포인트" data-label-inline="점">
					<input type="text" name="cf_comment_point" value="<?php echo (int) $config['cf_comment_point'] ?>" id="cf_comment_point" required class="required frm_input" size="3" data-label="댓글쓰기 포인트" data-label-inline="점">
					<input type="text" name="cf_download_point" value="<?php echo (int) $config['cf_download_point'] ?>" id="cf_download_point" required class="required frm_input" size="3" data-label="다운로드 포인트" data-label-inline="점">
				</div>
			</td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<section id="anc_cf_join" class="mybox">
    <h2 class="h2_frm">회원가입 설정</h2>
    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>회원가입 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
		<tr>
            <th scope="row"><label>닉네임 사용</label></th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_nickname" value="1" id="cf_use_nickname" <?=$config['cf_use_nickname']?'checked':''?> data-label="사용">
				<span class="help-block ml20">※ 닉네임 사용안함일 경우 닉네임 대신 이름(실명)이 출력됩니다.</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label>회원가입 인증코드 사용</label></th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_join_code" value="1" id="cf_use_join_code" <?=$config['cf_use_join_code']?'checked':'';?> data-label="사용">
				<span class="help-block ml20">※ 회원가입시 관리자가 설정한 인증코드를 입력해야 회원가입을 할 수 있습니다.</span>
            </td>
        </tr>
		<tr>
            <th scope="row"><label>회원가입 인증코드 설정</label></th>
            <td colspan="3">
				<div class="join-code-option">
					<p><span class="add-list">+ 코드추가</span></p>
					<ul>
						<?php
						$cf_join_code = explode("|", $config['cf_join_code']);	
						$cf_join_level = explode("|", $config['cf_join_level']);	
						$joinCodeCount = $config['cf_join_code'] ? count($cf_join_code) : 1; 
						for ($i=0; $i<$joinCodeCount; $i++) {
							echo '<li>';
							echo '<label class="labelInput"><span class="label">인증코드</span><input type="text" name="cf_join_code[]" value="'.$cf_join_code[$i].'" class="w-300" size="30"></label>';
							echo '<label class="labelInput"><span class="label">가입레벨</span>'.get_member_level_select('cf_join_level[]', 2, 10, $cf_join_level[$i], 'class="selectpicker"').'</label>';
							if($i >= 1) echo '<span class="del-list ml5">삭제</span>';
							echo '</li>';
						}
						?>						
					</ul>
				</div>
            </td>
        </tr>
		<script>
		$(function() {
			$(document).on("click", ".join-code-option .add-list", function() {				
				add_list();
			});

			$(document).on("click", ".join-code-option .del-list", function() {
				if(!confirm("선택하신 인증코드 옵션이 삭제됩니다. 계속하시겠습니까?"))
					return false;
				var $li = $(this).closest("li");
				$li.remove();        
			});
		});	

		function add_list() {
			var $option_list = $(".join-code-option ul");
			var list = '<li>';
			list += '<label class="labelInput"><span class="label">인증코드</span><input type="text" name="cf_join_code[]" value="" class="w-300" size="30"></label>';
			list += '<label class="labelInput"><span class="label">가입레벨</span><select name="cf_join_level[]" class="selectpicker"><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select></label>';
			list += '<span class="del-list ml5">삭제</span>';
			list += '</li>';
			var $list_last = null;
			var $list_last = $option_list.find("li:last-child");
			$list_last.after(list);
			$('select').selectpicker('refresh');
		}
		</script>
		<tr>
            <th scope="row"><label>회원가입 약관 사용여부</label></th>
            <td colspan="3"><input type="checkbox" name="cf_use_stipulation" value="1" id="cf_use_stipulation" <?=$config['cf_use_stipulation']?'checked':'';?> data-label="사용 (회원가입약관 및 개인정보처리방침)"></td>
        </tr>
		<script>matchOnOff_checkbox('#cf_use_stipulation', '.cf-join-agree', '');</script>
		<tr class="cf-join-agree">
            <th scope="row"><input type="text" name="cf_stipulation_label" value="<?=$config['cf_stipulation_label']?>" class="w-full" placeholder="회원가입약관"></th>
            <td colspan="3"><textarea name="cf_stipulation" id="cf_stipulation" class="autosize" style="min-height:130px;"><?php echo $config['cf_stipulation'] ?></textarea></td>
        </tr>
        <tr class="cf-join-agree">
            <th scope="row"><input type="text" name="cf_privacy_label" value="<?=$config['cf_privacy_label']?>" class="w-full" placeholder="개인정보처리방침"></th>
            <td colspan="3"><textarea id="cf_privacy" name="cf_privacy" class="autosize" style="min-height:130px;"><?php echo $config['cf_privacy'] ?></textarea></td>
        </tr>
		<tr class="cf-join-agree">
            <th scope="row"><input type="text" name="cf_terms_label" value="<?=$config['cf_terms_label']?>" class="w-full" placeholder="위치기반서비스 이용약관"></th>
            <td colspan="3"><textarea id="cf_terms" name="cf_terms" class="autosize" style="min-height:130px;"><?php echo $config['cf_terms'] ?></textarea></td>
        </tr>		
		<tr>
            <th scope="row">전화번호 입력</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_tel" value="1" id="cf_use_tel" <?php echo $config['cf_use_tel']?'checked':''; ?> data-label="사용">
                <input type="checkbox" name="cf_req_tel" value="1" id="cf_req_tel" <?php echo $config['cf_req_tel']?'checked':''; ?> data-label="필수입력" data-class="ml20">
            </td>
        </tr>
		<tr>
            <th scope="row">휴대폰번호 입력</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_hp" value="1" id="cf_use_hp" <?php echo $config['cf_use_hp']?'checked':''; ?> data-label="사용">
                <input type="checkbox" name="cf_req_hp" value="1" id="cf_req_hp" <?php echo $config['cf_req_hp']?'checked':''; ?> data-label="필수입력" data-class="ml20">
            </td>
        </tr>
        <tr>
            <th scope="row">주소 입력</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_addr" value="1" id="cf_use_addr" <?php echo $config['cf_use_addr']?'checked':''; ?> data-label="사용">
                <input type="checkbox" name="cf_req_addr" value="1" id="cf_req_addr" <?php echo $config['cf_req_addr']?'checked':''; ?> data-label="필수입력" data-class="ml20">
            </td>
        </tr>        
        <tr>
            <th scope="row">인사말 입력</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_profile" value="1" id="cf_use_profile" <?php echo $config['cf_use_profile']?'checked':''; ?> data-label="사용">
                <input type="checkbox" name="cf_req_profile" value="1" id="cf_req_profile" <?php echo $config['cf_req_profile']?'checked':''; ?> data-label="필수입력" data-class="ml20">
            </td>
        </tr>
		<tr>
            <th scope="row">기업코드 입력</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_membercode" value="1" id="cf_use_membercode" <?php echo $config['cf_use_membercode']?'checked':''; ?> data-label="사용">
                <input type="checkbox" name="cf_req_membercode" value="1" id="cf_req_membercode" <?php echo $config['cf_req_membercode']?'checked':''; ?> data-label="필수입력" data-class="ml20">
            </td>
        </tr>
		<tr>
            <th scope="row"><label>유입채널 사용</label></th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_sns" value="1" id="cf_use_sns" <?=$config['cf_use_sns']?'checked':''?> data-label="사용">
				<span class="help-block ml20">검색,SNS,주변 추천,광고,기타 선택으로 출력됩니다.</span>
            </td>
        </tr>
		<tr>
            <th scope="row">회원 이미지 업로드 사용</th>
            <td colspan="3">
                <input type="checkbox" name="cf_use_member_icon" value="1" id="cf_use_member_icon" <?php echo $config['cf_use_member_icon']?'checked':''; ?> data-label="사용">
            </td>
        </tr>
		
        <tr class="tr_point">
            <th scope="row"><label>회원가입 포인트</label></th>
            <td colspan="3">
				<input type="text" name="cf_register_point" value="<?php echo (int) $config['cf_register_point'] ?>" id="cf_register_point" class="frm_input" size="5" data-label="회원가입 포인트" data-label-inline="점">
			</td>
        </tr>
        <tr>
            <th scope="row" id="th310"><label for="cf_leave_day">회원탈퇴후 삭제일</label></th>
            <td colspan="3"><input type="text" name="cf_leave_day" value="<?php echo (int) $config['cf_leave_day'] ?>" id="cf_leave_day" class="frm_input w60" size="2" data-label-inline="일"> 후 자동 삭제</td>
        </tr>        
        <tr class="tr_point">
            <th scope="row"><label for="cf_recommend_point">추천인 포인트</label></th>
            <td colspan="3"><input type="text" name="cf_recommend_point" value="<?php echo (int) $config['cf_recommend_point'] ?>" id="cf_recommend_point" class="frm_input"> 점</td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_prohibit_id">아이디,닉네임 금지단어</label></th>
            <td>
                <?php echo help('회원아이디, 닉네임으로 사용할 수 없는 단어를 정합니다. 쉼표 (,) 로 구분') ?>
                <textarea name="cf_prohibit_id" id="cf_prohibit_id" rows="5" class="autosize" style="min-height:60px;"><?php echo get_sanitize_input($config['cf_prohibit_id']); ?></textarea>
            </td>
            <th scope="row"><label for="cf_prohibit_email">입력 금지 메일</label></th>
            <td>
                <?php echo help('입력 받지 않을 도메인을 지정합니다. 엔터로 구분 ex) hotmail.com') ?>
                <textarea name="cf_prohibit_email" id="cf_prohibit_email" rows="5" class="autosize" style="min-height:60px;"><?php echo get_sanitize_input($config['cf_prohibit_email']); ?></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
    <!--<button type="button" class="get_theme_confc btn btn_02" data-type="conf_member">테마 회원스킨설정 가져오기</button>-->
</section>


<section id="anc_cf_cert" class="mybox">
    <h2 class="h2_frm">본인확인 설정</h2>
    
    <div class="local_desc02 local_desc">
        <p>
            회원가입 시 본인확인 수단을 설정합니다.<br>
            실명과 휴대폰 번호 그리고 본인확인 당시에 성인인지의 여부를 저장합니다.<br>
            게시판의 경우 본인확인 또는 성인여부를 따져 게시물 조회 및 쓰기 권한을 줄 수 있습니다.
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>본인확인 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_cert_use">본인확인</label></th>
            <td>
                <select name="cf_cert_use" id="cf_cert_use">
                    <?php echo option_selected("0", $config['cf_cert_use'], "사용안함"); ?>
                    <?php echo option_selected("1", $config['cf_cert_use'], "테스트"); ?>
                    <?php echo option_selected("2", $config['cf_cert_use'], "실서비스"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_find">회원정보찾기</label></th>
            <td class="cf_cert_service">
                <?php echo help('휴대폰/아이핀 본인확인을 이용하시다가 간편인증을 이용하시는 경우, 기존 회원은 아이디/비밀번호 찾기에 사용할 수 없을 수 있습니다.') ?>
                <input type="checkbox" name="cf_cert_find" id="cf_cert_find" value="1" <?php if (isset($config['cf_cert_find']) && $config['cf_cert_find'] == 1) { ?> checked <?php } ?>><label for="cf_cert_find"> 아이디/비밀번호 찾기에 사용하기</label>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_simple">통합인증(간편인증)</label></th>
            <td class="cf_cert_service">
                <?php echo help('KG이니시스의 통합인증(간편인증+전자서명) 서비스에서 전자서명을 제외한 간편인증 서비스 입니다. <a href="https://www.inicis.com/all-auth-service" target="_blank"><u>KG이니시스 통합인증 안내</u></a>') ?>
                <select name="cf_cert_simple" id="cf_cert_simple">
                    <?php echo option_selected("", $config['cf_cert_simple'], "사용안함"); ?>
                    <?php echo option_selected("inicis", $config['cf_cert_simple'], "KG이니시스 통합인증(간편인증)"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_hp">휴대폰 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="cf_cert_hp" id="cf_cert_hp">
                    <?php echo option_selected("",    $config['cf_cert_hp'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['cf_cert_hp'], "코리아크레딧뷰로(KCB) 휴대폰 본인확인"); ?>
                    <?php echo option_selected("kcp", $config['cf_cert_hp'], "NHN KCP 휴대폰 본인확인"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_ipin">아이핀 본인확인</label></th>
            <td class="cf_cert_service">
                <select name="cf_cert_ipin" id="cf_cert_ipin">
                    <?php echo option_selected("",    $config['cf_cert_ipin'], "사용안함"); ?>
                    <?php echo option_selected("kcb", $config['cf_cert_ipin'], "코리아크레딧뷰로(KCB) 아이핀"); ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kg_cd">KG이니시스 간편인증 MID</label></th>
            <td class="cf_cert_service">
                <span class="sitecode">SRA</span>
                <input type="text" name="cf_cert_kg_mid" value="<?php echo get_sanitize_input($config['cf_cert_kg_mid']); ?>" id="cf_cert_kg_mid" class="frm_input" size="10" minlength="7" maxlength="7">
                <a href="http://sir.kr/main/service/inicis_cert_form.php" target="_blank" class="btn_frmline">KG이니시스 통합인증(간편인증) 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kg_cd">KG이니시스 간편인증 API KEY</label></th>
            <td class="cf_cert_service">
                <input type="text" name="cf_cert_kg_cd" value="<?php echo get_sanitize_input($config['cf_cert_kg_cd']); ?>" id="cf_cert_kg_cd" class="frm_input" size="40" minlength="32" maxlength="32">
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcb_cd">코리아크레딧뷰로<br>KCB 회원사ID</label></th>
            <td class="cf_cert_service">
                <?php echo help('KCB 회원사ID를 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, KCB와 계약체결 후 회원사ID를 발급 받으실 수 있습니다.<br>이용하시려는 서비스에 대한 계약을 아이핀, 휴대폰 본인확인 각각 체결해주셔야 합니다.<br>아이핀 본인확인 테스트의 경우에는 KCB 회원사ID가 필요 없으나,<br>휴대폰 본인확인 테스트의 경우 KCB 에서 따로 발급 받으셔야 합니다.') ?>
                <input type="text" name="cf_cert_kcb_cd" value="<?php echo get_sanitize_input($config['cf_cert_kcb_cd']); ?>" id="cf_cert_kcb_cd" class="frm_input" size="20">
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_kcp_cd">NHN KCP 사이트코드</label></th>
            <td class="cf_cert_service">
                <?php echo help('SM으로 시작하는 5자리 사이트 코드중 뒤의 3자리만 입력해 주십시오.<br>서비스에 가입되어 있지 않다면, 본인확인 서비스 신청페이지에서 서비스 신청 후 사이트코드를 발급 받으실 수 있습니다.') ?>
                <span class="sitecode">SM</span>
                <input type="text" name="cf_cert_kcp_cd" value="<?php echo get_sanitize_input($config['cf_cert_kcp_cd']); ?>" id="cf_cert_kcp_cd" class="frm_input" size="3"> <a href="http://sir.kr/main/service/p_cert.php" target="_blank" class="btn_frmline">NHN KCP 휴대폰 본인확인 서비스 신청페이지</a>
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_limit">본인확인 이용제한</label></th>
            <td class="cf_cert_service">
                <?php echo help('1일 단위 본인인증을 시도할 수 있는 최대횟수를 지정합니다. (0으로 설정 시 무한으로 인증시도 가능)<br>아이핀/휴대폰/간편인증에서 개별 적용됩니다.)'); ?>
                <input type="text" name="cf_cert_limit" value="<?php echo (int) $config['cf_cert_limit']; ?>" id="cf_cert_limit" class="frm_input" size="3"> 회
            </td>
        </tr>
        <tr>
            <th scope="row" class="cf_cert_service"><label for="cf_cert_req">본인확인 필수</label></th>
            <td class="cf_cert_service">
                <?php echo help('회원가입 때 본인확인을 필수로 할지 설정합니다. 필수로 설정하시면 본인확인을 하지 않은 경우 회원가입이 안됩니다.'); ?>
                <input type="checkbox" name="cf_cert_req" value="1" id="cf_cert_req"<?php echo get_checked($config['cf_cert_req'], 1); ?>> 예
            </td>
        </tr>
        </tbody>
        </table>
    </div>
</section>

<?php
include_once('_rewrite_config_form.php');
?>

<section id="anc_cf_mail" class="mybox">
    <h2 class="h2_frm">기본 메일 환경 설정</h2>
    

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>기본 메일 환경 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_email_use">메일발송 사용</label></th>
            <td>
                <?php echo help('체크하지 않으면 메일발송을 아예 사용하지 않습니다. 메일 테스트도 불가합니다.') ?>
                <input type="checkbox" name="cf_email_use" value="1" id="cf_email_use" <?php echo $config['cf_email_use']?'checked':''; ?> data-label="사용">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_email_certify">메일인증 사용</label></th>
            <td>
                <?php $tmp = !(defined('G5_SOCIAL_CERTIFY_MAIL') && G5_SOCIAL_CERTIFY_MAIL) ? ' ( SNS를 이용한 소셜로그인 한 회원은 회원메일인증을 하지 않습니다. 일반회원에게만 해당됩니다. )' : ''; ?>
                <?php echo help('메일에 배달된 인증 주소를 클릭하여야 회원으로 인정합니다.'.$tmp); ?>
                <input type="checkbox" name="cf_use_email_certify" value="1" id="cf_use_email_certify" <?php echo $config['cf_use_email_certify']?'checked':''; ?> data-label="사용">
            </td>
        </tr>
		<tr>
            <th scope="row">게시판에 글 작성시 <br/>메일을 받을 회원</th>
            <td>
				<div class="flex flex-middle gap20">
					<input type="checkbox" name="cf_email_wr_super_admin" value="1" id="cf_email_wr_super_admin" <?php echo $config['cf_email_wr_super_admin']?'checked':''; ?> data-label="최고관리자"></label>
					<input type="checkbox" name="cf_email_wr_group_admin" value="1" id="cf_email_wr_group_admin" <?php echo $config['cf_email_wr_group_admin']?'checked':''; ?> data-label="그룹관리자"></label>
					<input type="checkbox" name="cf_email_wr_board_admin" value="1" id="cf_email_wr_board_admin" <?php echo $config['cf_email_wr_board_admin']?'checked':''; ?> data-label="게시판관리자"></label>
					<input type="checkbox" name="cf_email_wr_write" value="1" id="cf_email_wr_write" <?php echo $config['cf_email_wr_write']?'checked':''; ?> data-label="원글작성자"></label>
					<input type="checkbox" name="cf_email_wr_comment_all" value="1" id="cf_email_wr_comment_all" <?php echo $config['cf_email_wr_comment_all']?'checked':''; ?> data-label="댓글작성자"></label>
					<span class="help-block ml15">※ 채크된 회원에게 메일이 발송됩니다.</span>
				</div>
            </td>
        </tr>
		<tr>
            <th scope="row">회원가입 후 메일발송</th>
            <td>
				<div class="flex flex-middle gap20">
					<input type="checkbox" name="cf_email_mb_super_admin" value="1" id="cf_email_mb_super_admin" <?php echo $config['cf_email_mb_super_admin']?'checked':''; ?> data-label="최고관리자에게 알림메일">
					<input type="checkbox" name="cf_email_mb_member" value="1" id="cf_email_mb_member" <?php echo $config['cf_email_mb_member']?'checked':''; ?> data-label="가입회원님께 알림메일">
				</div>
            </td>
        </tr>
        </table>
    </div>
</section>


<section id="anc_cf_sns" class="mybox">
    <h2 class="h2_frm">소셜네트워크서비스(SNS : Social Network Service)</h2>
    

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>소셜네트워크서비스 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_social_login_use">소셜로그인설정</label></th>
            <td>
				<input type="checkbox" name="cf_social_login_use" value="1" id="cf_social_login_use" <?php echo (!empty($config['cf_social_login_use']))?'checked':''; ?> data-label="소셜로그인 사용">
				<a href="https://sir.kr/manual/g5/276" class="btn btn_03 ml20" target="_blank">설정 관련 메뉴얼 보기</a>
            </td>
        </tr>
		<tr>
            <th scope="row"><label for="cf_social_servicelist">소셜로그인 설정</label></th>
            <td class="">
                <div class="flex flex-middle gap20">
                    <input type="checkbox" name="cf_social_servicelist[]" id="check_social_naver" value="naver" <?php echo option_array_checked('naver', $config['cf_social_servicelist']); ?> data-label="네이버 로그인 사용">
                    <input type="checkbox" name="cf_social_servicelist[]" id="check_social_kakao" value="kakao" <?php echo option_array_checked('kakao', $config['cf_social_servicelist']); ?> data-label="카카오 로그인 사용">
					<input type="checkbox" name="cf_social_servicelist[]" id="check_social_facebook" value="facebook" <?php echo option_array_checked('facebook', $config['cf_social_servicelist']); ?> data-label="페이스북 로그인 사용">
                    <input type="checkbox" name="cf_social_servicelist[]" id="check_social_google" value="google" <?php echo option_array_checked('google', $config['cf_social_servicelist']); ?> data-label="구글 로그인 사용">
                    <input type="checkbox" name="cf_social_servicelist[]" id="check_social_twitter" value="twitter" <?php echo option_array_checked('twitter', $config['cf_social_servicelist']); ?> data-label="트위터 로그인 사용">
                    <input type="checkbox" name="cf_social_servicelist[]" id="check_social_payco" value="payco" <?php echo option_array_checked('payco', $config['cf_social_servicelist']); ?> data-label="페이코 로그인 사용">                    
                </div>
            </td>
        </tr>
		<script>
		matchOnOff_checkbox('#check_social_naver', '#social_naver', '');
		matchOnOff_checkbox('#check_social_kakao', '#social_kakao', '');
		matchOnOff_checkbox('#check_social_facebook', '#social_facebook', '');
		matchOnOff_checkbox('#check_social_google', '#social_google', '');
		matchOnOff_checkbox('#check_social_twitter', '#social_twitter', '');
		matchOnOff_checkbox('#check_social_payco', '#social_payco', '');
		</script>
        <tr id="social_naver">
            <th scope="row"><label for="cf_naver_clientid" class="myTip_" data-tip="cf_naver_clientid">네이버</label></th>
            <td>
				<p class="mb10"><b>네이버 CallbackURL</b> -> <?php echo get_social_callbackurl('naver'); ?></p>
                <p class="mb10"><input type="text" name="cf_naver_clientid" value="<?php echo $config['cf_naver_clientid'] ?>" id="cf_naver_clientid" class="frm_input" size="40" data-label="네이버 Client ID"> <a href="https://developers.naver.com/apps/#/register" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<p><input type="text" name="cf_naver_secret" value="<?php echo $config['cf_naver_secret'] ?>" id="cf_naver_secret" class="frm_input" size="45" data-label="네이버 Client Secret"></p>
            </td>
        </tr>
		<tr id="social_kakao">
            <th scope="row"><label for="cf_kakao_rest_key">카카오 API</label></th>
            <td>
				<p class="mb10"><b>카카오 로그인 Redirect URI</b> -> <?php echo get_social_callbackurl('kakao', true); ?></p>
                <p class="mb10"><input type="text" name="cf_kakao_rest_key" value="<?php echo $config['cf_kakao_rest_key'] ?>" id="cf_kakao_rest_key" class="frm_input" size="40" data-label="카카오 REST API 키"> <a href="https://developers.kakao.com/apps/new" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<p class="mb20"><input type="text" name="cf_kakao_client_secret" value="<?php echo $config['cf_kakao_client_secret'] ?>" id="cf_kakao_client_secret" class="frm_input" size="45" data-label="카카오 Client Secret"></p>
				<input type="text" name="cf_kakao_js_apikey" value="<?php echo $config['cf_kakao_js_apikey'] ?>" id="cf_kakao_js_apikey" class="frm_input" size="45" data-label="카카오 JavaScript 키">
            </td>
        </tr>
        <tr id="social_facebook">
            <th scope="row"><label for="cf_facebook_appid">페이스북 앱 ID</label></th>
            <td>
				<p class="mb10"><b>페이스북 유효한 OAuth 리디렉션 URI</b> -> <?php echo get_social_callbackurl('facebook'); ?><br/></p>
                <p class="mb10"><input type="text" name="cf_facebook_appid" value="<?php echo $config['cf_facebook_appid'] ?>" id="cf_facebook_appid" class="frm_input" size="40" data-label="페이스북 앱 ID"> <a href="https://developers.facebook.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<input type="text" name="cf_facebook_secret" value="<?php echo $config['cf_facebook_secret'] ?>" id="cf_facebook_secret" class="frm_input" size="45" data-label="페이스북 앱 Secret">
            </td>
        </tr>
        <tr id="social_twitter">
            <th scope="row"><label for="cf_twitter_key">트위터 컨슈머 Key</label></th>
            <td>
				<p class="mb10"><b>트위터 CallbackURL</b> -> <?php echo get_social_callbackurl('twitter'); ?><br/></p>
                <p class="mb10"><input type="text" name="cf_twitter_key" value="<?php echo $config['cf_twitter_key'] ?>" id="cf_twitter_key" class="frm_input" size="40" data-label="트위터 컨슈머 Key"> <a href="https://dev.twitter.com/apps" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<input type="text" name="cf_twitter_secret" value="<?php echo $config['cf_twitter_secret'] ?>" id="cf_twitter_secret" class="frm_input" size="45" data-label="트위터 컨슈머 Secret">
            </td>
        </tr>
        <tr id="social_google">
            <th scope="row"><label for="cf_google_clientid">구글 Client ID</label></th>
            <td>
				<p class="mb10"><b>구글 승인된 리디렉션 URI</b> -> <?php echo get_social_callbackurl('google'); ?><br/></p>
                <p class="mb10"><input type="text" name="cf_google_clientid" value="<?php echo $config['cf_google_clientid'] ?>" id="cf_google_clientid" class="frm_input" size="40" data-label="구글 Client ID"> <a href="https://console.developers.google.com" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<p class="mb20"><input type="text" name="cf_google_secret" value="<?php echo $config['cf_google_secret'] ?>" id="cf_google_secret" class="frm_input" size="45" data-label="구글 Client Secret"></p>
				<input type="text" name="cf_googl_shorturl_apikey" value="<?php echo $config['cf_googl_shorturl_apikey'] ?>" id="cf_googl_shorturl_apikey" class="frm_input" size="40" data-label="구글 짧은주소 API Key"> <a href="http://code.google.com/apis/console/" target="_blank" class="btn_frmline">API Key 등록하기</a>
            </td>
        </tr>      
        <tr id="social_payco">
            <th scope="row"><label for="cf_payco_clientid">페이코 Client ID</label></th>
            <td>
				<p class="mb10"><b>페이코 CallbackURL</b> -> <?php echo get_social_callbackurl('payco'); ?></p>
                <p class="mb10"><input type="text" name="cf_payco_clientid" value="<?php echo $config['cf_payco_clientid']; ?>" id="cf_payco_clientid" class="frm_input" size="40" data-label="페이코 Client ID"> <a href="https://developers.payco.com/guide" target="_blank" class="btn_frmline">앱 등록하기</a></p>
				<input type="text" name="cf_payco_secret" value="<?php echo $config['cf_payco_secret']; ?>" id="cf_payco_secret" class="frm_input" size="45" data-label="페이코 Secret">
            </td>
        </tr>  
        </tbody>
        </table>
    </div>
</section>



<section id="anc_cf_sms" class="mybox">
    <h2 class="h2_frm">SMS</h2>
    

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>SMS 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="cf_sms_use">SMS 사용</label></th>
            <td>
	<!-- 2024-02-20	 준섭 (알리고 추가)-->
                <select id="cf_sms_use" name="cf_sms_use">
                    <option value="" <?php echo get_selected($config['cf_sms_use'], ''); ?>>사용안함</option>
					<option value="aligo" <?php echo get_selected($config['cf_sms_use'], 'aligo'); ?>>알리고</option>
					<option value="icode" <?php echo get_selected($config['cf_sms_use'], 'icode'); ?>>아이코드</option>
					<option value="naver" <?php echo get_selected($config['cf_sms_use'], 'naver'); ?>>네이버</option>
                </select>
            </td>
        </tr>
		<script>
		matchOnOff('#cf_sms_use', 'icode', '.sms_use', '');
		matchOnOff('#cf_sms_use', 'aligo', '.sms_use1', '');
		matchOnOff('#cf_sms_use', 'naver', '.sms_use2', '');
		</script>
	<!-- 2024-02-20	 준섭 (알리고 추가) 끝-->
        <tr class="sms_use">
            <th scope="row"><label for="cf_sms_type">SMS 전송유형</label></th>
            <td>
                <?php echo help("전송유형을 SMS로 선택하시면 최대 80바이트까지 전송하실 수 있으며<br>LMS로 선택하시면 90바이트 이하는 SMS로, 그 이상은 ".G5_ICODE_LMS_MAX_LENGTH."바이트까지 LMS로 전송됩니다.<br>요금은 건당 SMS는 16원, LMS는 48원입니다."); ?>
                <select id="cf_sms_type" name="cf_sms_type">
                    <option value="" <?php echo get_selected($config['cf_sms_type'], ''); ?>>SMS</option>
                    <option value="LMS" <?php echo get_selected($config['cf_sms_type'], 'LMS'); ?>>LMS</option>
                </select>
            </td>
        </tr>
        <tr class="sms_use icode_old_version">
            <th scope="row"><label for="cf_icode_id">아이코드 회원아이디<br>(구버전)</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 회원아이디를 입력합니다."); ?>
                <input type="text" name="cf_icode_id" value="<?php echo get_sanitize_input($config['cf_icode_id']); ?>" id="cf_icode_id" class="frm_input" size="20">
            </td>
        </tr>
        <tr class="sms_use icode_old_version">
            <th scope="row"><label for="cf_icode_pw">아이코드 비밀번호<br>(구버전)</label></th>
            <td>
                <?php echo help("아이코드에서 사용하시는 비밀번호를 입력합니다."); ?>
                <input type="password" name="cf_icode_pw" value="<?php echo get_sanitize_input($config['cf_icode_pw']); ?>" id="cf_icode_pw" class="frm_input">
            </td>
        </tr>
        <tr class="sms_use icode_old_version <?php if(!(isset($userinfo['payment']) && $userinfo['payment'])){ echo 'cf_tr_hide'; } ?>">
            <th scope="row">요금제<br>(구버전)</th>
            <td>
                <input type="hidden" name="cf_icode_server_ip" value="<?php echo get_sanitize_input($config['cf_icode_server_ip']); ?>">
                <?php
                    if ($userinfo['payment'] == 'A') {
                       echo '충전제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    } else if ($userinfo['payment'] == 'C') {
                        echo '정액제';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7296">';
                    } else {
                        echo '가입해주세요.';
                        echo '<input type="hidden" name="cf_icode_server_port" value="7295">';
                    }
                ?>
            </td>
        </tr>
        <?php if ($userinfo['payment'] == 'A') { ?>
        <tr class="sms_use icode_old_version">
            <th scope="row">충전 잔액<br>(구버전)</th>
            <td>
                <?php echo number_format($userinfo['coin']); ?> 원.
                <a href="http://www.icodekorea.com/smsbiz/credit_card_amt.php?icode_id=<?php echo get_text($config['cf_icode_id']); ?>&amp;icode_passwd=<?php echo get_text($config['cf_icode_pw']); ?>" target="_blank" class="btn_frmline">충전하기</a>
            </td>
        </tr>
        <?php } ?>
        <tr class="sms_use icode_json_version">
            <th scope="row"><label for="cf_icode_token_key">아이코드 토큰키<br>(JSON버전)</label></th>
            <td>
                <?php echo help("아이코드 JSON 버전의 경우 아이코드 토큰키를 입력시 실행됩니다.<br>SMS 전송유형을 LMS로 설정시 90바이트 이내는 SMS, 90 ~ 2000 바이트는 LMS 그 이상은 절삭 되어 LMS로 발송됩니다."); ?>
                <input type="text" name="cf_icode_token_key" value="<?php echo isset($config['cf_icode_token_key']) ? get_sanitize_input($config['cf_icode_token_key']) : ''; ?>" id="cf_icode_token_key" class="frm_input" size="40">
                <?php echo help("아이코드 사이트 -> 토큰키관리 메뉴에서 생성한 토큰키를 입력합니다."); ?>
                <br>
                서버아이피 : <?php echo $_SERVER['SERVER_ADDR']; ?>
            </td>
        </tr>
        <tr class="sms_use">
            <th scope="row">아이코드 SMS 신청<br>회원가입</th>
            <td>
                <a href="http://icodekorea.com/res/join_company_fix_a.php?sellid=sir2" target="_blank" class="btn_frmline">아이코드 회원가입</a>
            </td>
        </tr>

<!-- 2024-02-20	 준섭 (알리고 추가) -->
		<tr class="sms_use1">
            <th scope="row"><label for="cf_aligo_token_key">알리고 토큰키</label></th>
            <td>
                <input type="text" name="cf_aligo_token_key" value="<?php echo isset($config['cf_aligo_token_key']) ? get_sanitize_input($config['cf_aligo_token_key']) : ''; ?>" id="cf_aligo_token_key" class="frm_input" size="40">
                <?php echo help("알리고 사이트 -> 토큰키관리 메뉴에서 생성한 토큰키를 입력합니다."); ?>
            </td>
        </tr>
<!-- 종료 -->
        </tbody>
        </table>
    </div>
</section>



<?php
//주석 처리한 필드 모음
include_once(G5_ADMIN_PATH.'/my/config_form_inc.php');
?>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>matchOnOff_checkbox('#cf_use_point', '.tr_point', '');</script>	

<script>
$(function(){
    <?php
    if(!$config['cf_cert_use'])
        echo '$(".cf_cert_service").addClass("cf_cert_hide");';
    ?>
    $("#cf_cert_use").change(function(){
        switch($(this).val()) {
            case "0":
                $(".cf_cert_service").addClass("cf_cert_hide");
                break;
            default:
                $(".cf_cert_service").removeClass("cf_cert_hide");
                break;
        }
    });

    $("#cf_captcha").on("change", function(){
        if ($(this).val() == 'recaptcha' || $(this).val() == 'recaptcha_inv') {
            $("[class^='kcaptcha_']").hide();
        } else {
            $("[class^='kcaptcha_']").show();
        }
    }).trigger("change");

    $(".get_theme_confc").on("click", function() {
        var type = $(this).data("type");
        var msg = "기본환경 스킨 설정";
        if(type == "conf_member")
            msg = "기본환경 회원스킨 설정";

        if(!confirm("현재 테마의 "+msg+"을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: type },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('cf_member_skin', 'cf_mobile_member_skin', 'cf_new_skin', 'cf_mobile_new_skin', 'cf_search_skin', 'cf_mobile_search_skin', 'cf_connect_skin', 'cf_mobile_connect_skin', 'cf_faq_skin', 'cf_mobile_faq_skin');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("select[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function fconfigform_submit(f)
{
    var current_user_ip = "<?php echo $_SERVER['REMOTE_ADDR']; ?>";
    var cf_intercept_ip_val = f.cf_intercept_ip.value;

    if( cf_intercept_ip_val && current_user_ip ){
        var cf_intercept_ips = cf_intercept_ip_val.split("\n");

        for(var i=0; i < cf_intercept_ips.length; i++){
            if ( cf_intercept_ips[i].trim() ) {
                cf_intercept_ips[i] = cf_intercept_ips[i].replace(".", "\.");
                cf_intercept_ips[i] = cf_intercept_ips[i].replace("+", "[0-9\.]+");
                
                var re = new RegExp(cf_intercept_ips[i]);
                if ( re.test(current_user_ip) ){
                    alert("현재 접속 IP : "+ current_user_ip +" 가 차단될수 있기 때문에, 다른 IP를 입력해 주세요.");
                    return false;
                }
            }
        }
    }

    f.action = "<?=$_my_url?>/config_form_update.php";
    return true;
}
</script>

<?php
// 본인확인 모듈 실행권한 체크
if($config['cf_cert_use']) {
    // kcb일 때
    if($config['cf_cert_ipin'] == 'kcb' || $config['cf_cert_hp'] == 'kcb') {
        // 실행모듈
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname';
            else
                $exe = G5_OKNAME_PATH.'/bin/okname_x64';
        } else {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_OKNAME_PATH.'/bin/okname.exe';
            else
                $exe = G5_OKNAME_PATH.'/bin/oknamex64.exe';
        }

        echo module_exec_check($exe, 'okname');

        if(is_dir(G5_OKNAME_PATH.'/log') && is_writable(G5_OKNAME_PATH.'/log') && function_exists('check_log_folder') ) {
            check_log_folder(G5_OKNAME_PATH.'/log');
        }
    }

    // kcp일 때
    if($config['cf_cert_hp'] == 'kcp') {
        if(strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
            if(PHP_INT_MAX == 2147483647) // 32-bit
                $exe = G5_KCPCERT_PATH . '/bin/ct_cli';
            else
                $exe = G5_KCPCERT_PATH . '/bin/ct_cli_x64';
        } else {
            $exe = G5_KCPCERT_PATH . '/bin/ct_cli_exe.exe';
        }

        echo module_exec_check($exe, 'ct_cli');
    }

    // LG의 경우 log 디렉토리 체크
    if($config['cf_cert_hp'] == 'lg') {
        $log_path = G5_LGXPAY_PATH.'/lgdacom/log';

        if(!is_dir($log_path)) {

            if( is_writable(G5_LGXPAY_PATH.'/lgdacom/') ){
                // 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
                @mkdir($log_path, G5_DIR_PERMISSION);
                @chmod($log_path, G5_DIR_PERMISSION);
            }

            if(!is_dir($log_path)){
                echo '<script>'.PHP_EOL;
                echo 'alert("'.str_replace(G5_PATH.'/', '', G5_LGXPAY_PATH).'/lgdacom 폴더 안에 log 폴더를 생성하신 후 쓰기권한을 부여해 주십시오.\n> mkdir log\n> chmod 707 log");'.PHP_EOL;
                echo '</script>'.PHP_EOL;
            }
        }

        if(is_dir($log_path) && is_writable($log_path)) {
            if( function_exists('check_log_folder') ){
                check_log_folder($log_path);
            }
        } else if (is_dir($log_path)) {
            echo '<script>'.PHP_EOL;
            echo 'alert("'.str_replace(G5_PATH.'/', '',$log_path).' 폴더에 쓰기권한을 부여해 주십시오.\n> chmod 707 log");'.PHP_EOL;
            echo '</script>'.PHP_EOL;
        }
    }
}

if (stripos($config['cf_image_extension'], "webp") !== false) {
    if (!function_exists("imagewebp")) {
        echo '<script>'.PHP_EOL;
        echo 'alert("이 서버는 webp 이미지를 지원하고 있지 않습니다.\n이미지 업로드 확장자에서 webp 확장자를 제거해 주십시오.\n제거하지 않으면 이미지와 관련된 오류가 발생할 수 있습니다.");'.PHP_EOL;
        echo 'document.getElementById("cf_image_extension").focus();'.PHP_EOL;
        echo '</script>'.PHP_EOL;
    }
}

include_once (G5_ADMIN_PATH.'/admin.tail.php');
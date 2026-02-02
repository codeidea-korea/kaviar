<?php
$sub_menu = '400100';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], "r");

$g5['title'] = '쇼핑몰설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$pg_anchor = '<ul class="anchor">
<li><a href="#anc_scf_info">사업자정보</a></li>
<li><a href="#anc_scf_skin">스킨설정</a></li>
<li><a href="#anc_scf_index">쇼핑몰 초기화면</a></li>
<li><a href="#anc_mscf_index">모바일 초기화면</a></li>
<li><a href="#anc_scf_payment">결제설정</a></li>
<li><a href="#anc_scf_delivery">배송설정</a></li>
<li><a href="#anc_scf_etc">기타설정</a></li>
<li><a href="#anc_scf_sms">SMS설정</a></li>
</ul>';
?>
<form name="fconfig" method="post" enctype="MULTIPART/FORM-DATA">
<input type="hidden" name="token" value="">


<section id ="anc_scf_payment">
    <h2 class="h2_frm">결제설정</h2>
    <?php echo $pg_anchor; ?>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>결제설정 입력</caption>
        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_bank_use">무통장입금사용</label></th>
            <td>
                <?php echo help("주문시 무통장으로 입금을 가능하게 할것인지를 설정합니다.\n사용할 경우 은행계좌번호를 반드시 입력하여 주십시오.", 50); ?>
                <select id="de_bank_use" name="de_bank_use">
                    <option value="0" <?php echo get_selected($default['de_bank_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_bank_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_bank_account">은행계좌번호</label></th>
            <td>
                <textarea name="de_bank_account" id="de_bank_account"><?php echo $default['de_bank_account']; ?></textarea>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_iche_use">계좌이체 결제사용</label></th>
            <td>
            <?php echo help("주문시 실시간 계좌이체를 가능하게 할것인지를 설정합니다.", 50); ?>
                <select id="de_iche_use" name="de_iche_use">
                    <option value="0" <?php echo get_selected($default['de_iche_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_iche_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_vbank_use">가상계좌 결제사용</label></th>
            <td>
                <?php echo help("주문별로 유일하게 생성되는 일회용 계좌번호입니다. 주문자가 가상계좌에 입금시 상점에 실시간으로 통보가 되므로 업무처리가 빨라집니다.", 50); ?>
                <select name="de_vbank_use" id="de_vbank_use">
                    <option value="0" <?php echo get_selected($default['de_vbank_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_vbank_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr id="kcp_vbank_url" class="pg_vbank_url">
            <th scope="row">NHN KCP 가상계좌<br>입금통보 URL</th>
            <td>
                <?php echo help("NHN KCP 가상계좌 사용시 다음 주소를 <strong><a href=\"http://admin.kcp.co.kr\" target=\"_blank\">NHN KCP 관리자</a> &gt; 상점정보관리 &gt; 정보변경 &gt; 공통URL 정보 &gt; 공통URL 변경후</strong>에 넣으셔야 상점에 자동으로 입금 통보됩니다."); ?>
                <?php echo G5_SHOP_URL; ?>/settle_kcp_common.php</td>
        </tr>
        <tr id="inicis_vbank_url" class="pg_vbank_url">
            <th scope="row">KG이니시스 가상계좌 입금통보 URL</th>
            <td>
                <?php echo help("KG이니시스 가상계좌 사용시 다음 주소를 <strong><a href=\"https://iniweb.inicis.com/\" target=\"_blank\">KG이니시스 관리자</a> &gt; 거래조회 &gt; 가상계좌 &gt; 입금통보방식선택 &gt; URL 수신 설정</strong>에 넣으셔야 상점에 자동으로 입금 통보됩니다."); ?>
                <?php echo G5_SHOP_URL; ?>/settle_inicis_common.php</td>
        </tr>
        <tr>
            <th scope="row"><label for="de_hp_use">휴대폰결제사용</label></th>
            <td>
                <?php echo help("주문시 휴대폰 결제를 가능하게 할것인지를 설정합니다.", 50); ?>
                <select id="de_hp_use" name="de_hp_use">
                    <option value="0" <?php echo get_selected($default['de_hp_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_hp_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_use">신용카드결제사용</label></th>
            <td>
                <?php echo help("주문시 신용카드 결제를 가능하게 할것인지를 설정합니다.", 50); ?>
                <select id="de_card_use" name="de_card_use">
                    <option value="0" <?php echo get_selected($default['de_card_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_card_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_noint_use">신용카드 무이자할부사용<br>( KCP 만 해당 )</label></th>
            <td>
                <?php echo help("주문시 신용카드 무이자할부를 가능하게 할것인지를 설정합니다.<br>사용으로 설정하시면 KCP PG사 가맹점 관리자 페이지에서 설정하신 무이자할부 설정이 적용됩니다.<br>사용안함으로 설정하시면 KCP PG사 무이자 이벤트 카드를 제외한 모든 카드의 무이자 설정이 적용되지 않습니다.", 50); ?>
                <select id="de_card_noint_use" name="de_card_noint_use">
                    <option value="0" <?php echo get_selected($default['de_card_noint_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_card_noint_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_easy_pay_use">PG사 간편결제 버튼 사용</label></th>
            <td>
                <?php echo help("주문서 작성 페이지에 PG사 간편결제(PAYCO, PAYNOW, KPAY) 버튼의 별도 사용 여부를 설정합니다.", 50); ?>
                <select id="de_easy_pay_use" name="de_easy_pay_use">
                    <option value="0" <?php echo get_selected($default['de_easy_pay_use'], 0); ?>>노출안함</option>
                    <option value="1" <?php echo get_selected($default['de_easy_pay_use'], 1); ?>>노출함</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_taxsave_use">현금영수증<br>발급사용</label></th>
            <td>
                <?php echo help("관리자는 설정에 관계없이 <a href=\"".G5_ADMIN_URL."/shop_admin/orderlist.php\">주문내역</a> &gt; 보기에서 발급이 가능합니다.\n현금영수증 발급 취소는 PG사에서 지원하는 현금영수증 취소 기능을 사용하시기 바랍니다.", 50); ?>
                <select id="de_taxsave_use" name="de_taxsave_use">
                    <option value="0" <?php echo get_selected($default['de_taxsave_use'], 0); ?>>사용안함</option>
                    <option value="1" <?php echo get_selected($default['de_taxsave_use'], 1); ?>>사용</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="cf_use_point">포인트 사용</label></th>
            <td>
                <?php echo help("<a href=\"".G5_ADMIN_URL."/config_form.php#frm_board\" target=\"_blank\">환경설정 &gt; 기본환경설정</a>과 동일한 설정입니다."); ?>
                <input type="checkbox" name="cf_use_point" value="1" id="cf_use_point"<?php echo $config['cf_use_point']?' checked':''; ?>> 사용
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_min_point">결제 최소포인트</label></th>
            <td>
                <?php echo help("회원의 포인트가 설정값 이상일 경우만 주문시 결제에 사용할 수 있습니다.\n포인트 사용을 하지 않는 경우에는 의미가 없습니다."); ?>
                <input type="text" name="de_settle_min_point" value="<?php echo $default['de_settle_min_point']; ?>" id="de_settle_min_point" class="frm_input" size="10"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_max_point">최대 결제포인트</label></th>
            <td>
                <?php echo help("주문 결제시 최대로 사용할 수 있는 포인트를 설정합니다.\n포인트 사용을 하지 않는 경우에는 의미가 없습니다."); ?>
                <input type="text" name="de_settle_max_point" value="<?php echo $default['de_settle_max_point']; ?>" id="de_settle_max_point" class="frm_input" size="10"> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_settle_point_unit">결제 포인트단위</label></th>
            <td>
                <?php echo help("주문 결제시 사용되는 포인트의 절사 단위를 설정합니다."); ?>
                <select id="de_settle_point_unit" name="de_settle_point_unit">
                    <option value="100" <?php echo get_selected($default['de_settle_point_unit'], 100); ?>>100</option>
                    <option value="10"  <?php echo get_selected($default['de_settle_point_unit'],  10); ?>>10</option>
                    <option value="1"   <?php echo get_selected($default['de_settle_point_unit'],   1); ?>>1</option>
                </select> 점
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_card_point">포인트부여</label></th>
            <td>
                <?php echo help("신용카드, 계좌이체, 휴대폰 결제시 포인트를 부여할지를 설정합니다. (기본값은 '아니오')"); ?>
                <select id="de_card_point" name="de_card_point">
                    <option value="0" <?php echo get_selected($default['de_card_point'], 0); ?>>아니오</option>
                    <option value="1" <?php echo get_selected($default['de_card_point'], 1); ?>>예</option>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_point_days">주문완료 포인트</label></th>
            <td>
                <?php echo help("주문자가 회원일 경우에만 주문완료시 포인트를 지급합니다. 주문취소, 반품 등을 고려하여 포인트를 지급할 적당한 기간을 입력하십시오. (기본값은 7일)\n0일로 설정하는 경우에는 주문완료와 동시에 포인트를 지급합니다."); ?>
                주문 완료 <input type="text" name="de_point_days" value="<?php echo $default['de_point_days']; ?>" id="de_point_days" class="frm_input" size="2"> 일 이후에 포인트를 지급
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_pg_service">결제대행사</label></th>
            <td>
                <input type="hidden" name="de_pg_service" id="de_pg_service" value="<?php echo $default['de_pg_service']; ?>" >
                <?php echo help('쇼핑몰에서 사용할 결제대행사를 선택합니다.'); ?>
                <ul class="de_pg_tab">
                    <li class="<?php if($default['de_pg_service'] == 'kcp') echo 'tab-current'; ?>"><a href="#kcp_info_anchor" data-value="kcp" title="NHN KCP 선택하기" >NHN KCP</a></li>
                    <li class="<?php if($default['de_pg_service'] == 'lg') echo 'tab-current'; ?>"><a href="#lg_info_anchor" data-value="lg" title="LG유플러스 선택하기">LG유플러스</a></li>
                    <li class="<?php if($default['de_pg_service'] == 'inicis') echo 'tab-current'; ?>"><a href="#inicis_info_anchor" data-value="inicis" title="KG이니시스 선택하기">KG이니시스</a></li>
                    <li class="<?php if($default['de_pg_service'] == 'danalpay') echo 'tab-current'; ?>"><a href="#danal_info_anchor" data-value="danalpay" title="나이스페이 선택하기">다날페이</a></li> <!-- wetoz : danalpay -->
                </ul>
            </td>
        </tr>

        
        <style>.danalpay_info_fld th {background-color: #fffff6;}</style>

        <tr class="pg_info_fld danalpay_info_fld">
            <th scope="row">다날페이 (신용카드)</th>
            <td>
                <?php echo help("다날페이 가맹점관리자 페이지 : https://cp.teledit.com/login/"); ?>
                <?php echo help("CPID, CRYPTOKEY 는 다날 계약담당자에게 문의 바랍니다."); ?>
                <?php echo help("실서비스 정보와 테스트정보가 다르므로 실서비스를 위해서는 반드시 교체가 필요합니다."); ?>
                <?php echo help("테스트용 CPID, CRYPTOKEY 가 별도로 발급되므로 테스트를 위해서는 별도로 발급받은 값을 입력해주세요."); ?>
                <div><span style="display:inline-block;width:66px;">CPID</span> : <input type="text" name="de_danalpay_cpid" value='<?php echo $default['de_danalpay_cpid']?>' class="frm_input" size="20"></div>
                <div style="margin-top:7px;"><span style="display:inline-block;width:66px;">CRYPTOKEY</span> : <input type="text" name="de_danalpay_cryptokey" value='<?php echo $default['de_danalpay_cryptokey']?>' class="frm_input" size="50"></div>
            </td>
        </tr>
        <tr class="pg_info_fld danalpay_info_fld">
            <th scope="row">다날페이 (휴대폰)</th>
            <td>
                <?php echo help("CPID, CPPWD 값을 결제수단에 관계없이 모두 동일한 값을 부여받았다면 모두 동일하게 입력해주세요."); ?>
                <div><span style="display:inline-block;width:66px;">CPID</span> : <input type="text" name="de_danalpay_hp_cpid" value='<?php echo $default['de_danalpay_hp_cpid']?>' class="frm_input" size="20"></div>
                <div style="margin-top:7px;"><span style="display:inline-block;width:66px;">CPPWD</span> : <input type="text" name="de_danalpay_hp_cryptokey" value='<?php echo $default['de_danalpay_hp_cryptokey']?>' class="frm_input" size="50"></div>
            </td>
        </tr>
        <tr class="pg_info_fld danalpay_info_fld">
            <th scope="row">다날페이 (계좌이체)</th>
            <td>
                <div><span style="display:inline-block;width:66px;">CPID</span> : <input type="text" name="de_danalpay_dbank_cpid" value='<?php echo $default['de_danalpay_dbank_cpid']?>' class="frm_input" size="20"></div>
                <div style="margin-top:7px;"><span style="display:inline-block;width:66px;">CRYPTOKEY</span> : <input type="text" name="de_danalpay_dbank_cryptokey" value='<?php echo $default['de_danalpay_dbank_cryptokey']?>' class="frm_input" size="50"></div>
            </td>
        </tr>
        <tr class="pg_info_fld danalpay_info_fld">
            <th scope="row">다날페이 (가상계좌)</th>
            <td>
                <div><span style="display:inline-block;width:66px;">CPID</span> : <input type="text" name="de_danalpay_vbank_cpid" value='<?php echo $default['de_danalpay_vbank_cpid']?>' class="frm_input" size="20"></div>
                <div style="margin-top:7px;"><span style="display:inline-block;width:66px;">CRYPTOKEY</span> : <input type="text" name="de_danalpay_vbank_cryptokey" value='<?php echo $default['de_danalpay_vbank_cryptokey']?>' class="frm_input" size="50"></div>
            </td>
        </tr>
        <tr class="pg_info_fld danalpay_info_fld">
            <th scope="row">ItemCode</th>
            <td>
                <?php echo help("휴대폰 결제를 위하여 다날에서 제공한 ItemCode 입력"); ?>
                <input type="text" name="de_danalpay_itemcode" value='<?php echo $default['de_danalpay_itemcode']?>' class="frm_input" size="30">
            </td>
        </tr>
        <!-- wetoz : danalpay -->

        <tr class="pg_info_fld kcp_info_fld" id="kcp_info_anchor">
            <th scope="row">
                <label for="de_kcp_mid">KCP SITE CODE</label><br>
                <a href="http://sir.kr/main/service/p_pg.php" target="_blank" id="scf_kcpreg" class="kcp_btn">NHN KCP서비스신청하기</a>
            </th>
            <td>
                <?php echo help("NHN KCP 에서 받은 SR 로 시작하는 영대문자, 숫자 혼용 총 5자리 중 SR 을 제외한 나머지 3자리 SITE CODE 를 입력하세요.\n만약, 사이트코드가 SR로 시작하지 않는다면 NHN KCP에 사이트코드 변경 요청을 하십시오. 예) SR9A3"); ?>
                <span class="sitecode">SR</span> <input type="text" name="de_kcp_mid" value="<?php echo $default['de_kcp_mid']; ?>" id="de_kcp_mid" class="frm_input code_input" size="2" maxlength="3"> 영대문자, 숫자 혼용 3자리
            </td>
        </tr>
        <tr class="pg_info_fld kcp_info_fld">
            <th scope="row"><label for="de_kcp_site_key">NHN KCP SITE KEY</label></th>
            <td>
                <?php echo help("25자리 영대소문자와 숫자 - 그리고 _ 로 이루어 집니다. SITE KEY 발급 NHN KCP 전화: 1544-8660\n예) 1Q9YRV83gz6TukH8PjH0xFf__"); ?>
                <input type="text" name="de_kcp_site_key" value="<?php echo $default['de_kcp_site_key']; ?>" id="de_kcp_site_key" class="frm_input" size="36" maxlength="25">
            </td>
        </tr>
        <tr class="pg_info_fld lg_info_fld" id="lg_info_anchor">
            <th scope="row">
                <label for="cf_lg_mid">LG유플러스 상점아이디</label><br>
                <a href="http://sir.kr/main/service/lg_pg.php" target="_blank" id="scf_lgreg" class="lg_btn">LG유플러스 서비스신청하기</a>
            </th>
            <td>
                <?php echo help("LG유플러스에서 받은 si_ 로 시작하는 상점 ID를 입력하세요.\n만약, 상점 ID가 si_로 시작하지 않는다면 LG유플러스에 사이트코드 변경 요청을 하십시오. 예) si_lguplus\n<a href=\"".G5_ADMIN_URL."/config_form.php#anc_cf_cert\">기본환경설정 &gt; 본인확인</a> 설정의 LG유플러스 상점아이디와 동일합니다."); ?>
                <span class="sitecode">si_</span> <input type="text" name="cf_lg_mid" value="<?php echo $config['cf_lg_mid']; ?>" id="cf_lg_mid" class="frm_input code_input" size="10" maxlength="20"> 영문자, 숫자 혼용
            </td>
        </tr>
        <tr class="pg_info_fld lg_info_fld">
            <th scope="row"><label for="cf_lg_mert_key">LG유플러스 MERT KEY</label></th>
            <td>
                <?php echo help("LG유플러스 상점MertKey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실 수 있습니다.\n예) 95160cce09854ef44d2edb2bfb05f9f3\n<a href=\"".G5_ADMIN_URL."/config_form.php#anc_cf_cert\">기본환경설정 &gt; 본인확인</a> 설정의 LG유플러스 MERT KEY와 동일합니다."); ?>
                <input type="text" name="cf_lg_mert_key" value="<?php echo $config['cf_lg_mert_key']; ?>" id="cf_lg_mert_key" class="frm_input " size="36" maxlength="50">
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld" id="inicis_info_anchor">
            <th scope="row">
                <label for="de_inicis_mid">KG이니시스 상점아이디</label><br>
                <a href="http://sir.kr/main/service/inicis_pg.php" target="_blank" id="scf_kgreg" class="kg_btn">KG이니시스 서비스신청하기</a>
            </th>
            <td>
                <?php echo help("KG이니시스로 부터 발급 받으신 상점아이디(MID) 10자리 중 SIR 을 제외한 나머지 7자리를 입력 합니다.\n만약, 상점아이디가 SIR로 시작하지 않는다면 계약담당자에게 변경 요청을 해주시기 바랍니다. (Tel. 02-3430-5858) 예) SIRpaytest"); ?>
                <span class="sitecode">SIR</span> <input type="text" name="de_inicis_mid" value="<?php echo $default['de_inicis_mid']; ?>" id="de_inicis_mid" class="frm_input code_input" size="10" maxlength="10"> 영문소문자(숫자포함 가능)
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row"><label for="de_inicis_admin_key">KG이니시스 키패스워드</label></th>
            <td>
                <?php echo help("KG이니시스에서 발급받은 4자리 상점 키패스워드를 입력합니다.\nKG이니시스 상점관리자 패스워드와 관련이 없습니다.\n키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오"); ?>
                <input type="text" name="de_inicis_admin_key" value="<?php echo $default['de_inicis_admin_key']; ?>" id="de_inicis_admin_key" class="frm_input" size="5" maxlength="4">
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row"><label for="de_inicis_sign_key">KG이니시스 웹결제 사인키</label></th>
            <td>
                <?php echo help("KG이니시스에서 발급받은 웹결제 사인키를 입력합니다.\n관리자 페이지의 상점정보 > 계약정보 > 부가정보의 웹결제 signkey생성 조회 버튼 클릭, 팝업창에서 생성 버튼 클릭 후 해당 값을 입력합니다."); ?>
                <input type="text" name="de_inicis_sign_key" value="<?php echo $default['de_inicis_sign_key']; ?>" id="de_inicis_sign_key" class="frm_input" size="40" maxlength="50">
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_samsung_pay_use">KG이니시스 삼성페이 사용</label>
                <a href="http://sir.kr/main/service/samsungpay.php" target="_blank" class="kg_btn">삼성페이 서비스신청하기</a>
            </th>
            <td>
                <?php echo help("체크시 KG이니시스 삼성페이를 사용합니다.( 모바일 결제시 주문화면에 삼성페이 버튼이 출력됩니다. ) <br >실결제시 반드시 결제대행사 KG이니시스 항목에 상점 아이디와 키패스워드를 입력해 주세요.", 50); ?>
                <input type="checkbox" name="de_samsung_pay_use" value="1" id="de_samsung_pay_use"<?php echo $default['de_samsung_pay_use']?' checked':''; ?>> <label for="de_samsung_pay_use">사용</label>
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_inicis_lpay_use">KG이니시스 L.pay 사용</label>
            </th>
            <td>
                <?php echo help("체크시 KG이니시스 L.pay를 사용합니다. <br >실결제시 반드시 결제대행사 KG이니시스 항목의 상점 정보( 아이디, 키패스워드, 웹결제 사인키 )를 입력해 주세요.", 50); ?>
                <input type="checkbox" name="de_inicis_lpay_use" value="1" id="de_inicis_lpay_use"<?php echo $default['de_inicis_lpay_use']?' checked':''; ?>> <label for="de_inicis_lpay_use">사용</label>
            </td>
        </tr>
        <tr class="pg_info_fld inicis_info_fld">
            <th scope="row">
                <label for="de_inicis_cartpoint_use">KG이니시스 신용카드 포인트 결제</label>
            </th>
            <td>
                <?php echo help("신용카드 포인트 결제에 대해 이니시스와 계약을 맺은 상점에서만 적용하는 옵션입니다.<br>체크시 pc 결제에서는 신용카드 포인트 사용 여부에 대한 팝업창에 사용 버튼과 사용안함 버튼이 표기되어 결제하는 고객의 선택여부에 따라 신용카드 포인트 결제가 가능합니다.<br >모바일에서는 신용카드 포인트 사용이 가능합니다.", 50); ?>
                <input type="checkbox" name="de_inicis_cartpoint_use" value="1" id="de_inicis_cartpoint_use"<?php echo $default['de_inicis_cartpoint_use']?' checked':''; ?>> <label for="de_inicis_cartpoint_use">사용</label>
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row">
                <label for="de_kakaopay_mid">카카오페이 상점MID</label>
                <a href="http://sir.kr/main/service/kakaopay.php" target="_blank" class="kakao_btn">카카오페이 서비스신청하기</a>
            </th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점아이디(MID) 10자리 중 첫 KHSIR과 끝 m 을 제외한 영문4자리를 입력 합니다. 예) KHSIRtestm"); ?>
                <span class="sitecode">KHSIR</span> <input type="text" name="de_kakaopay_mid" value="<?php echo $default['de_kakaopay_mid']; ?>" id="de_kakaopay_mid" class="frm_input code_input" size="5" maxlength="4"> <span class="sitecode">m</span>
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_key">카카오페이 상점키</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 서명키를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_key" value="<?php echo $default['de_kakaopay_key']; ?>" id="de_kakaopay_key" class="frm_input" size="100">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_enckey">카카오페이 상점 EncKey</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 인증 전용 EncKey를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_enckey" value="<?php echo $default['de_kakaopay_enckey']; ?>" id="de_kakaopay_enckey" class="frm_input" size="20">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_hashkey">카카오페이 상점 HashKey</label></th>
            <td>
                <?php echo help("카카오페이로 부터 발급 받으신 상점 인증 전용 HashKey를 입력합니다."); ?>
                <input type="text" name="de_kakaopay_hashkey" value="<?php echo $default['de_kakaopay_hashkey']; ?>" id="de_kakaopay_hashkey" class="frm_input" size="20">
            </td>
        </tr>
        <tr class="kakao_info_fld">
            <th scope="row"><label for="de_kakaopay_cancelpwd">카카오페이 결제취소 비밀번호</label></th>
            <td>
                <?php echo help("카카오페이 상점관리자에서 설정하신 취소 비밀번호를 입력합니다.<br>입력하신 비밀번호와 상점관리자에서 설정하신 비밀번호가 일치하지 않으면 취소가 되지 않습니다."); ?>
                <input type="text" name="de_kakaopay_cancelpwd" value="<?php echo $default['de_kakaopay_cancelpwd']; ?>" id="de_kakaopay_cancelpwd" class="frm_input" size="20">
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_mid">네이버페이 가맹점 아이디</label>
                <a href="http://sir.kr/main/service/naverpay.php" target="_blank" class="naver_btn">네이버페이 서비스신청하기</a>
            </th>
            <td>
                <?php echo help("네이버페이 가맹점 아이디를 입력합니다."); ?>
                <input type="text" name="de_naverpay_mid" value="<?php echo $default['de_naverpay_mid']; ?>" id="de_naverpay_mid" class="frm_input" size="20" maxlength="50">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_cert_key">네이버페이 가맹점 인증키</label>
            </th>
            <td>
                <?php echo help("네이버페이 가맹점 인증키를 입력합니다."); ?>
                <input type="text" name="de_naverpay_cert_key" value="<?php echo $default['de_naverpay_cert_key']; ?>" id="de_naverpay_cert_key" class="frm_input" size="50" maxlength="100">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_button_key">네이버페이 버튼 인증키</label>
            </th>
            <td>
                <?php echo help("네이버페이 버튼 인증키를 입력합니다."); ?>
                <input type="text" name="de_naverpay_button_key" value="<?php echo $default['de_naverpay_button_key']; ?>" id="de_naverpay_button_key" class="frm_input" size="50" maxlength="100">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row"><label for="de_naverpay_test">네이버페이 결제테스트</label></th>
            <td>
                <?php echo help("네이버페이 결제테스트 여부를 설정합니다. 검수 과정 중에는 <strong>예</strong>로 설정해야 하며 최종 승인 후 <strong>아니오</strong>로 설정합니다."); ?>
                <select id="de_naverpay_test" name="de_naverpay_test">
                    <option value="1" <?php echo get_selected($default['de_naverpay_test'], 1); ?>>예</option>
                    <option value="0" <?php echo get_selected($default['de_naverpay_test'], 0); ?>>아니오</option>
                </select>
            </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_mb_id">네이버페이 결제테스트 아이디</label>
            </th>
            <td>
                <?php echo help("네이버페이 결제테스트를 위한 테스트 회원 아이디를 입력합니다. 네이버페이 검수 과정에서 필요합니다."); ?>
                <input type="text" name="de_naverpay_mb_id" value="<?php echo $default['de_naverpay_mb_id']; ?>" id="de_naverpay_mb_id" class="frm_input" size="20" maxlength="20">
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">네이버페이 상품정보 XML URL</th>
            <td>
                <?php echo help("네이버페이에 상품정보를 XML 데이터로 제공하는 페이지입니다. 검수과정에서 아래의 URL 정보를 제공해야 합니다."); ?>
                <?php echo G5_SHOP_URL; ?>/naverpay/naverpay_item.php
             </td>
        </tr>
        <tr class="naver_info_fld">
            <th scope="row">
                <label for="de_naverpay_sendcost">네이버페이 추가배송비 안내</label>
            </th>
            <td>
                <?php echo help("네이버페이를 통한 결제 때 구매자에게 보여질 추가배송비 내용을 입력합니다.<br>예) 제주도 3,000원 추가, 제주도 외 도서·산간 지역 5,000원 추가"); ?>
                <input type="text" name="de_naverpay_sendcost" value="<?php echo $default['de_naverpay_sendcost']; ?>" id="de_naverpay_sendcost" class="frm_input" size="70">
             </td>
        </tr>
        <tr>
            <th scope="row">에스크로 사용</th>
            <td>
                <?php echo help("에스크로 결제를 사용하시려면, 반드시 결제대행사 상점 관리자 페이지에서 에스크로 서비스를 신청하신 후 사용하셔야 합니다.\n에스크로 사용시 배송과의 연동은 되지 않으며 에스크로 결제만 지원됩니다."); ?>
                    <input type="radio" name="de_escrow_use" value="0" <?php echo $default['de_escrow_use']==0?"checked":""; ?> id="de_escrow_use1">
                    <label for="de_escrow_use1">일반결제 사용</label>
                    <input type="radio" name="de_escrow_use" value="1" <?php echo $default['de_escrow_use']==1?"checked":""; ?> id="de_escrow_use2">
                    <label for="de_escrow_use2"> 에스크로결제 사용</label>
            </td>
        </tr>
        <tr>
            <th scope="row">결제 테스트</th>
            <td>
                <?php echo help("PG사의 결제 테스트를 하실 경우에 체크하세요. 결제단위 최소 1,000원"); ?>
                <input type="radio" name="de_card_test" value="0" <?php echo $default['de_card_test']==0?"checked":""; ?> id="de_card_test1">
                <label for="de_card_test1">실결제 </label>
                <input type="radio" name="de_card_test" value="1" <?php echo $default['de_card_test']==1?"checked":""; ?> id="de_card_test2">
                <label for="de_card_test2">테스트결제</label>
                <div class="scf_cardtest kcp_cardtest">
                    <a href="http://admin.kcp.co.kr/" target="_blank" class="btn_frmline">실결제 관리자</a>
                    <a href="http://testadmin8.kcp.co.kr/" target="_blank" class="btn_frmline">테스트 관리자</a>
                </div>
                <div class="scf_cardtest lg_cardtest">
                    <a href="https://pgweb.uplus.co.kr/" target="_blank" class="btn_frmline">실결제 관리자</a>
                    <a href="https://pgweb.uplus.co.kr/tmert" target="_blank" class="btn_frmline">테스트 관리자</a>
                </div>
                <div class="scf_cardtest inicis_cardtest">
                    <a href="https://iniweb.inicis.com/" target="_blank" class="btn_frmline">상점 관리자</a>
                </div>
                <div id="scf_cardtest_tip">
                    <strong>일반결제 사용시 테스트 결제</strong>
                    <dl>
                        <dt>신용카드</dt><dd>1000원 이상, 모든 카드가 테스트 되는 것은 아니므로 여러가지 카드로 결제해 보셔야 합니다.<br>(BC, 현대, 롯데, 삼성카드)</dd>
                        <dt>계좌이체</dt><dd>150원 이상, 계좌번호, 비밀번호는 가짜로 입력해도 되며, 주민등록번호는 공인인증서의 것과 일치해야 합니다.</dd>
                        <dt>가상계좌</dt><dd>1원 이상, 모든 은행이 테스트 되는 것은 아니며 "해당 은행 계좌 없음" 자주 발생함.<br>(광주은행, 하나은행)</dd>
                        <dt>휴대폰</dt><dd>1004원, 실결제가 되며 다음날 새벽에 일괄 취소됨</dd>
                    </dl>
                    <strong>에스크로 사용시 테스트 결제</strong><br>
                    <dl>
                        <dt>신용카드</dt><dd>1000원 이상, 모든 카드가 테스트 되는 것은 아니므로 여러가지 카드로 결제해 보셔야 합니다.<br>(BC, 현대, 롯데, 삼성카드)</dd>
                        <dt>계좌이체</dt><dd>150원 이상, 계좌번호, 비밀번호는 가짜로 입력해도 되며, 주민등록번호는 공인인증서의 것과 일치해야 합니다.</dd>
                        <dt>가상계좌</dt><dd>1원 이상, 입금통보는 제대로 되지 않음.</dd>
                        <dt>휴대폰</dt><dd>테스트 지원되지 않음.</dd>
                    </dl>
                    <ul id="kcp_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li>테스트결제의 <a href="http://testadmin8.kcp.co.kr/assist/login.LoginAction.do" target="_blank">상점관리자</a> 로그인 정보는 NHN KCP로 문의하시기 바랍니다. (기술지원 1544-8661)</li>
                        <li><b>일반결제</b>의 테스트 사이트코드는 <b>T0000</b> 이며, <b>에스크로 결제</b>의 테스트 사이트코드는 <b>T0007</b> 입니다.</li>
                    </ul>
                    <ul id="lg_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li>테스트결제의 <a href="http://pgweb.dacom.net:7085/" target="_blank">상점관리자</a> 로그인 정보는 LG유플러스 상점아이디 첫 글자에 t를 추가해서 로그인하시기 바랍니다. 예) tsi_lguplus</li>
                    </ul>
                    <ul id="inicis_cardtest_tip" class="scf_cardtest_tip_adm scf_cardtest_tip_adm_hide">
                        <li><b>일반결제</b>의 테스트 사이트 mid는 <b>INIpayTest</b> 이며, <b>에스크로 결제</b>의 테스트 사이트 mid는 <b>iniescrow0</b> 입니다.</li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="de_tax_flag_use">복합과세 결제</label></th>
            <td>
                 <?php echo help("복합과세(과세, 비과세) 결제를 사용하려면 체크하십시오.\n복합과세 결제를 사용하기 전 PG사에 별도로 결제 신청을 해주셔야 합니다. 사용시 PG사로 문의하여 주시기 바랍니다."); ?>
                <input type="checkbox" name="de_tax_flag_use" value="1" id="de_tax_flag_use"<?php echo $default['de_tax_flag_use']?' checked':''; ?>> 사용
            </td>
        </tr>
        </tbody>
        </table>
        <script>
        $('#scf_cardtest_tip').addClass('scf_cardtest_tip');
        $('<button type="button" class="scf_cardtest_btn btn_frmline">테스트결제 팁 더보기</button>').appendTo('.scf_cardtest');

        $(".scf_cardtest").addClass("scf_cardtest_hide");
        $(".<?php echo $default['de_pg_service']; ?>_cardtest").removeClass("scf_cardtest_hide");
        $("#<?php echo $default['de_pg_service']; ?>_cardtest_tip").removeClass("scf_cardtest_tip_adm_hide");
        </script>
    </div>
</section>
<?

include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>

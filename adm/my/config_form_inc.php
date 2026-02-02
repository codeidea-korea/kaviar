<?php
if (!defined('_GNUBOARD_')) exit;
?>

<input type="hidden" name="cf_cut_name" value="<?php echo $config['cf_cut_name'] ?>" id="cf_cut_name" class="frm_input" size="5" data-info="이름(닉네임) 표시 - 자리만 표기">
<input type="hidden" name="cf_nick_modify" value="<?php echo $config['cf_nick_modify'] ?>" data-info="닉네임 수정">
<input type="hidden" name="cf_open_modify" value="<?php echo $config['cf_open_modify'] ?>" data-info="정보공개 수정">
<input type="hidden" name="cf_memo_del" value="<?php echo $config['cf_memo_del'] ?>" data-info="쪽지 삭제">
<input type="hidden" name="cf_visit_del" value="<?php echo $config['cf_visit_del'] ?>" id="cf_visit_del" class="frm_input" size="5" data-info="접속자로그 삭제 - 설정일이 지난 접속자 로그 자동 삭제 - 일">
<input type="hidden" name="cf_popular_del" value="<?php echo $config['cf_popular_del'] ?>" id="cf_popular_del" class="frm_input" size="5" data-info="인기검색어 삭제 - 설정일이 지난 인기검색어 자동 삭제 - 일">
<input type="hidden" name="cf_login_minutes" value="<?php echo $config['cf_login_minutes'] ?>" id="cf_login_minutes" class="frm_input" size="3" data-info="현재 접속자 - 설정값 이내의 접속자를 현재 접속자로 인정 - 분">
<input type="hidden" name="cf_new_rows" value="<?php echo $config['cf_new_rows'] ?>" id="cf_new_rows" class="frm_input" size="3" data-info="최근게시물 라인수 - 목록 한페이지당 라인수 - 라인">
<input type="hidden" name="cf_page_rows" value="<?php echo $config['cf_page_rows'] ?>" id="cf_page_rows" class="frm_input" size="3" data-info="한페이지당 라인수 - 목록(리스트) 한페이지당 라인수 - 라인">
<input type="hidden" name="cf_mobile_page_rows" value="<?php echo $config['cf_mobile_page_rows'] ?>" id="cf_mobile_page_rows" class="frm_input" size="3" data-info="모바일 한페이지당 라인수 - 모바일 목록 한페이지당 라인수 - 라인">
<input type="hidden" name="cf_write_pages" value="<?php echo $config['cf_write_pages'] ?>" id="cf_write_pages" data-info="페이지 표시 수">
<input type="hidden" name="cf_mobile_pages" value="<?php echo $config['cf_mobile_pages'] ?>" id="cf_mobile_pages" data-info="모바일 페이지 표시 수">

<input type="hidden" name="cf_new_skin" value="<?php echo $config['cf_new_skin'] ?>">
<input type="hidden" name="cf_mobile_new_skin" value="<?php echo $config['cf_mobile_new_skin'] ?>">
<input type="hidden" name="cf_search_skin" value="<?php echo $config['cf_search_skin'] ?>">
<input type="hidden" name="cf_mobile_search_skin" value="<?php echo $config['cf_mobile_search_skin'] ?>">
<input type="hidden" name="cf_connect_skin" value="<?php echo $config['cf_connect_skin'] ?>">
<input type="hidden" name="cf_mobile_connect_skin" value="<?php echo $config['cf_mobile_connect_skin'] ?>">
<input type="hidden" name="cf_faq_skin" value="<?php echo $config['cf_faq_skin'] ?>">
<input type="hidden" name="cf_mobile_faq_skin" value="<?php echo $config['cf_mobile_faq_skin'] ?>">

<input type="hidden" name="cf_use_copy_log" value="" data-info="복사, 이동시 로그">
<input type="hidden" name="cf_link_target" value="_blank" data-info="새창 링크 - 글내용중 자동 링크되는 타켓">
<input type="hidden" name="cf_search_part" value="<?php echo $config['cf_search_part'] ?>" data-info="검색 단위">

<input type="hidden" name="cf_member_skin" value="<?php echo $config['cf_member_skin'] ?>" data-info="회원 스킨">
<input type="hidden" name="cf_mobile_member_skin" value="<?php echo $config['cf_mobile_member_skin'] ?>" data-info="모바일 회원 스킨">
<input type="hidden" name="cf_use_homepage" value="<?php echo $config['cf_use_homepage'] ?>" data-info="홈페이지 입력 - 보이기">
<input type="hidden" name="cf_req_homepage" value="<?php echo $config['cf_req_homepage'] ?>" data-info="홈페이지 입력 - 필수입력">

<input type="hidden" name="cf_use_signature" value="<?php echo $config['cf_use_signature'] ?>" data-info="서명 입력 - 사용">
<input type="hidden" name="cf_req_signature" value="<?php echo $config['cf_req_signature'] ?>" data-info="서명 입력 - 필수입력">

<input type="hidden" name="cf_register_level" value="<?php echo $config['cf_register_level'] ?>" data-info="회원가입시 권한">
<!--<input type="hidden" name="cf_use_member_icon" value="2" data-info="회원아이콘 사용 - 아이콘+이름 표시...">-->
<input type="hidden" name="cf_icon_level" value="1" data-info="회원 아이콘, 이미지 업로드 권한 - 레벨1부터(비회원부터)">
<input type="hidden" name="cf_member_icon_size" value="<?php echo $config['cf_member_icon_size'] ?>" id="cf_member_icon_size" class="frm_input" size="10" data-info="회원아이콘 용량 - 바이트 이하">
<input type="hidden" name="cf_member_icon_width" value="<?php echo $config['cf_member_icon_width'] ?>" id="cf_member_icon_width" class="frm_input" size="2" data-info="회원아이콘 가로 사이즈 - 픽셀이하">
<input type="hidden" name="cf_member_icon_height" value="<?php echo $config['cf_member_icon_height'] ?>" id="cf_member_icon_height" class="frm_input" size="2" data-info="회원아이콘 세로 사이즈 - 픽셀이하">
<input type="hidden" name="cf_member_img_size" value="<?php echo $config['cf_member_img_size'] ?>" id="cf_member_img_size" class="frm_input" size="10" data-info="회원이미지 용량 - 바이트 이하">
<input type="hidden" name="cf_member_img_width" value="<?php echo $config['cf_member_img_width'] ?>" id="cf_member_img_width" class="frm_input" size="2" data-info="회원이미지 가로 사이즈 - 픽셀이하">
<input type="hidden" name="cf_member_img_height" value="<?php echo $config['cf_member_img_height'] ?>" id="cf_member_img_height" class="frm_input" size="2" data-info="회원이미지 세로 사이즈 - 픽셀이하">
<input type="hidden" name="cf_use_recommend" value="0" data-info="추천인제도 사용 - 사용안함으로.."> 
<input type="hidden" name="cf_formmail_is_member" value="1" id="cf_formmail_is_member" data-info="폼메일 사용 여부 - 회원만 사용">

<input type="hidden" name="cf_email_po_super_admin" value="0" id="cf_email_po_super_admin" data-info="투표 기타의견 작성 시 최고관리자에게 메일발송 - 사용안함으로..">
<textarea name="cf_add_script" id="cf_add_script" style="display:none" data-info="추가 script"><?php echo get_text($config['cf_add_script']); ?></textarea>
<!--


<input type="hidden" name="cf_sms_use" value="" data-info="SMS 사용">
<input type="hidden" name="cf_sms_type" value="" data-info="SMS 전송유형">
<input type="hidden" name="cf_icode_id" value="<?=$config['cf_icode_id']?>" data-info="아이코드 회원아이디">
<input type="hidden" name="cf_icode_pw" value="<?=$config['cf_icode_pw']?>" data-info="아이코드 비밀번호">
<input type="hidden" name="cf_icode_server_ip" value="<?=$config['cf_icode_server_ip']?>" data-info="요금제">
<input type="hidden" name="cf_use_point" value="">
<input type="hidden" name="cf_login_point" value="<?php echo $config['cf_login_point'] ?>" data-info="">
<input type="hidden" name="cf_memo_send_point" value="<?php echo $config['cf_memo_send_point'] ?>" data-info="">
-->



<input type="hidden" name="cf_flash_extension" value="<?php echo $config['cf_flash_extension'] ?>" data-info="">
<input type="hidden" name="cf_movie_extension" value="<?php echo $config['cf_movie_extension'] ?>" data-info="">
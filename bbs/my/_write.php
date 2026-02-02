<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/my/get_my.lib.php');

/*─────────────────────────────────────────────────────────────────────────────────────────────────
																					기본 필드 추가
─────────────────────────────────────────────────────────────────────────────────────────────────*/
if(!isset($write['wr_use'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table}
					 ADD wr_use ENUM( '', 'pc', 'mobile', 'none', 'admin' ) NOT NULL DEFAULT '' AFTER `wr_twitter_user`,
					 ADD wr_order TINYINT NOT NULL DEFAULT '0' AFTER `wr_use`,
					 ADD wr_subject_hide TINYINT NOT NULL DEFAULT '0' AFTER `wr_order`,
					 ADD wr_short_con text NOT NULL DEFAULT '' AFTER `wr_subject_hide`,
					 ADD wr_content_mobile text NOT NULL DEFAULT '' AFTER `wr_short_con`,
					 ADD wr_tag text NOT NULL DEFAULT '' AFTER `wr_content_mobile`,
					 ADD wr_link_target ENUM( '_self', '_blank', 'attach', 'popup', 'alert' ) NOT NULL DEFAULT '_self' AFTER `wr_tag`,
					 ADD wr_link_name VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_link_target`,
					 ADD wr_link_option VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_link_name`,
					 ADD wr_video VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_link_option`,
					 ADD wr_video_src VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_video`,
					 ADD wr_video_play TINYINT NOT NULL DEFAULT '0' AFTER `wr_video_src`,
					 ADD wr_btn1 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_video_play`,
					 ADD wr_btn1_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn1`,
					 ADD wr_btn2 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_btn1_option`,
					 ADD wr_btn2_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn2`,
					 ADD wr_btn3 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_btn2_option`,
					 ADD wr_btn3_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn3`,
					 ADD wr_btn4 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_btn3_option`,
					 ADD wr_btn4_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn4`,
					 ADD wr_btn5 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_btn4_option`,
					 ADD wr_btn5_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn5`,
					 ADD wr_btn6 VARCHAR(300) NOT NULL DEFAULT '' AFTER `wr_btn5_option`,
					 ADD wr_btn6_color VARCHAR(255) NOT NULL DEFAULT '' AFTER `wr_btn6`
					 ", false);
}

$wr_link_option = explode("|", $write['wr_link_option']);

for ($i=1; $i<=6; $i++) {
	$ex_btn[$i] = explode("|", $write['wr_btn'.$i]);
	$wr_btn_color[$i] = explode("|", $write['wr_btn'.$i.'_color']);
}

$tag_val = '';
$wr_tags = explode(",", $write['wr_tag']);
if($write['wr_tag']) {
	for ($i=0; $i<count($wr_tags); $i++) {
		$tag_val .= '#'.$wr_tags[$i];
	}
}

/*
- 수정할 파일 - 
adm/sql_write.sql
bbs/move_update.php
bbs/write_update.php
*/

/*───────────────────────────────────────────────────────────────────────────────────────────────── */




//내용(모바일) 추가 에디터
$editor_mobile_html = editor_html('wr_content_mobile', $write['wr_content_mobile'], $is_dhtml_editor, $board['bo_editor_height']);
$editor_mobile_js = '';
$editor_mobile_js .= get_editor_js('wr_content_mobile', $is_dhtml_editor);
$editor_mobile_js .= chk_editor_js('wr_content_mobile', $is_dhtml_editor);


//옵션
$option = '';
$option_hidden = '';
$bo_html_tag = $board['bo_use_html_tag'] ? $board['bo_use_html_tag'] : 'html2';
if($is_notice || $is_html || $is_secret || $is_mail || $is_admin) {
	if($is_notice) $option .= "\n".'<label class="mr15"><input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>상단고정</label>';
	if($is_html) {
		if($is_dhtml_editor) {
			$option_hidden .= '<input type="hidden" name="html" value="html1">';
		} else {
			$option_hidden .= '<input type="hidden" name="html" value="'.$bo_html_tag.'">'; //html:줄바꿈만 적용, html1:태그만 적용, html2:줄바꿈+태그 둘다 적용
		}
	}
	if($is_secret) {
		if($is_secret==1) {
			$option .= "\n".'<label class="mr15"><input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>비밀글</label>';
		} else {
			$option_hidden .= '<input type="hidden" name="secret" value="secret">';
		}
	}
	if($is_mail && $is_member) {
		$option .= "\n".'<label class="mr15"><input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>답변메일받기</label>';
	}
}
if($option) $wr_option = '<div class="wr-list"><div class="wr-list-label"><label>옵션</label></div><div class="wr-list-con flex gap30">'.$option.'</div></div>';


//비회원
if($is_name || $is_password) {
	if($is_admin) {
		if($is_name) $wr_guest .= '<input type="hidden" name="wr_name" value="'.$name.'" id="wr_name">';
		if($is_password) $wr_guest .= '<input type="hidden" name="wr_password" id="wr_password">';
	} else {
		$wr_guest = '<div class="wr-group wr-guest">';
		$wr_guest .= '<div class="wr-list">';
		$wr_guest .= '<div class="wr-list-con lg:flex lg:flex-middle gap20">';
		$wr_name_size = $wr_password_size = G5_IS_MOBILE ? 'w-full':'w-150';
		if($is_name && G5_IS_MOBILE) $wr_guest .= '<label class="label">이름</label>';
		if($is_name) $wr_guest .= '<input type="text" name="wr_name" value="'.$name.'" id="wr_name" required class="required '.$wr_name_size.'" size="10" maxlength="20"'.(!G5_IS_MOBILE?' data-label="이름"':'').'>';
		if($is_password && G5_IS_MOBILE) $wr_guest .= '<label class="label">비밀번호</label>';
		if($is_password) $wr_guest .= '<input type="password" name="wr_password" id="wr_password" '.$password_required.' class="'.$password_required.' '.$wr_password_size.'" maxlength="20"'.(!G5_IS_MOBILE?' data-label="비밀번호"':'').'>';
		if($is_mail && G5_IS_MOBILE) $wr_guest .= '<label class="label">이메일</label>';
		if($is_mail) {
			$wr_guest .= '<input type="'.(G5_IS_MOBILE?'email':'text').'" name="wr_email" value="'.$email.'" class="emailCheck '.(G5_IS_MOBILE?'w-full':'w-220').'" required maxlength="255"'.(!G5_IS_MOBILE?' data-label="이메일"':'').'>';
			$wr_guest .= '<div class="emailCheck-msg"></div>';
		}
		$wr_guest .= '</div>';
		$wr_guest .= '</div>';
		$wr_guest .= '</div>';
	}
}


//사용여부
$wr_use = '';
if($is_admin) {
	$wr_use .= '<div class="wr-list sm:flex1">'.PHP_EOL;
	$wr_use .= '	<div class="wr-list-label"><label class="label-order">사용여부</label></div>'.PHP_EOL;
	$wr_use .= '	<div class="wr-list-con">'.PHP_EOL;
	if($write['wr_use'] == '') $wr_use_selectColor = 'selectColor-gray';
	if($write['wr_use'] == 'none') $wr_use_selectColor = 'selectColor-black';
	if($write['wr_use'] == 'pc' || $write['wr_use'] == 'mobile') $wr_use_selectColor = 'selectColor-yellow';
	if($write['wr_use'] == 'admin') $wr_use_selectColor = 'selectColor-black';
	$wr_use .= '	<select name="wr_use" value="'.$write['wr_use'].'" id="wr_use" class="selectpicker" data-style="'.$wr_use_selectColor.'">';
	$wr_use .= option_selected_my("",  $write['wr_use'], "전체 공개", "data-content='<span class=\"icon_check\">전체 공개</span>'");
	$wr_use .= option_selected_my("none",  $write['wr_use'], "비공개", "data-content='<span class=\"icon_none\">비공개</span>'");
	$wr_use .= option_selected_my("pc",  $write['wr_use'], "PC 전용", "data-content='<span class=\"icon_pc\">PC 전용</span>'");
	$wr_use .= option_selected_my("mobile",  $write['wr_use'], "MOBILE 전용", "data-content='<span class=\"icon_mobile\">MOBILE 전용</span>'");	
	if($skin_pagemake || $skin_adm) $wr_use .= option_selected_my("admin",  $write['wr_use'], "관리자 확인용", "data-content='<span class=\"icon_admin\">관리자 확인용</span>'");
	$wr_use .= '	</select>'.PHP_EOL;
	if(!$skin_pagemake) $wr_use .= '	<span class="help-block" id="use-none-help">* 비공개된 게시물은 관리자를 제외한 모든 사용자에게 비노출됩니다.</span>'.PHP_EOL;
	$wr_use .= '	</div>'.PHP_EOL;
	$wr_use .= '</div>'.PHP_EOL;
	$myScript .= 'matchOnOff("#wr_use", "none", "#use-none-help");';
}

//출력순서
$option_hidden .= '<input type="hidden" name="wr_order" value="'.$write['wr_order'].'">';
$wr_order = '';
if($is_admin) {
	$wr_order .= '<div class="wr-list sm:flex1">'.PHP_EOL;
	$wr_order .= '	<div class="wr-list-label"><label class="label-order">출력순서</label></div>'.PHP_EOL;
	$wr_order .= '	<div class="wr-list-con">'.PHP_EOL;
	$wr_order .= '	<input type="tel" name="wr_order" value="'.($write['wr_order']?$write['wr_order']:'').'" id="wr_order" class="lg:w-50 sm:w-full" data-label-mobile="출력순서">';
	$wr_order .= '	</div>'.PHP_EOL;
	$wr_order .= '</div>'.PHP_EOL;
}


//카테고리
$wr_category = '';
if($is_category) {
	$wr_category_required = $is_admin ? '' : 'required';
	$wr_category = '<div class="wr-list" id="wrCate">';
	if(G5_IS_MOBILE) $wr_category .= '<div class="wr-list-label"><label>'.($board['bo_category_label']?$board['bo_category_label']:'카테고리').'</label></div>'.PHP_EOL;
	$wr_category .= '<div class="wr-list-con">';	
	$wr_category .= '<select name="ca_name" id="ca_name" '.$wr_category_required.' class="selectpicker '.$wr_category_required.'" data-lg-label="'.$bo_cate_label.'">';	
	if(!$board['bo_cate_all_hidden']) $wr_category .= option_selected("",  $ca_name, "- 분류 없음 -");
	$wr_category .= $category_option;
	$wr_category .= '</select>';
	$wr_category .= '</div>';
	$wr_category .= '</div>';
}

//제목
$subject_hide_checked = $write['wr_subject_hide'] ? 'checked' : '';
$wr_subject = '';
$wr_subject .= '<div class="wr-list wr_subject" id="wrSubject">';
if(G5_IS_MOBILE || $wr_subject_label) $wr_subject .= '<div class="wr-list-label"><label>'.($wr_subject_label?$wr_subject_label:'제목').'</label></div>'.PHP_EOL;
$wr_subject .= '<div class="wr-list-con">';
if($is_admin && $theme_type != 'shop') $wr_subject .= '<label class="checkbox-hide'.(!G5_IS_MOBILE?' myTip mini top':'').'" data-tip="제목 On·Off"><input type="checkbox" name="wr_subject_hide" value="1" '.$subject_hide_checked.'></label>';
$wr_subject .= '<input type="text" name="wr_subject" value="'.$subject.'" id="wr_subject" required class="w-full" maxlength="255" placeholder="제목을 입력해주세요.">';
$wr_subject .= '</div>';
$wr_subject .= '</div>';

//내용
$wr_myContent = '';
if($board['bo_use_dhtml_editor'] || $board['bo_use_html_tag']) {
	$wrEditorClass = $is_dhtml_editor ? 'editor '.$config['cf_editor'] : '';
	$wr_myContent .= '<div class="wr-list wr_content '.$wrEditorClass.'">';
	if(G5_IS_MOBILE || $wr_content_label) $wr_myContent .= '<div class="wr-list-label"><label>'.($wr_content_label?$wr_content_label:'내용').'</label></div>'.PHP_EOL;
	$wr_myContent .= '<div class="wr-list-con">';
	$wr_myContent .= '<div class="wrConBox">';
	if($is_admin && !G5_IS_MOBILE) {
		$wr_myContent .= '<ul class="wrConTabs">';
		$wr_myContent .= '<li class="active icon_pc" data-target="pcCon" title="PC"></li>';
		$wr_myContent .= '<li class="icon_mobile" data-target="mobileCon" title="모바일"></li>';
		$wr_myContent .= '</ul>';
	}
	if(G5_IS_MOBILE) {
		if($write['wr_content'] && $write['wr_content_mobile'] && $write['wr_content_mobile'] != '&nbsp;') {
			$wr_myContent .= '<input type="hidden" name="wr_content" value="'.$write['wr_content'].'">';
			$wr_myContent .= '<div class="tabEditor mobileCon active">'.$editor_mobile_html.'</div>';		
		} else {
			$wr_myContent .= '<div class="tabEditor pcCon active">'.$editor_html.'</div>';
			$wr_myContent .= '<input type="hidden" name="wr_content_mobile" value="'.$write['wr_content_mobile'].'">';
		}		
	} else {
		$wr_myContent .= '<div class="tabEditor pcCon active">';
		if($write_min || $write_max) $wr_myContent .= '<p id="char_count_desc">이 게시판은 최소 <strong>'.$write_min.'</strong>글자 이상, 최대 <strong>'.$write_max.'</strong>글자 이하까지 글을 쓰실 수 있습니다.</p>';
		$wr_myContent .= $editor_html;
		if($write_min || $write_max) $wr_myContent .= '<div id="char_count_wrp"><span id="char_count"></span>글자</div>';
		$wr_myContent .= '</div>';
		$wr_myContent .= '<div class="tabEditor mobileCon">'.$editor_mobile_html.'</div>';
	}
	$wr_myContent .= '</div>';
	$wr_myContent .= '</div>';
	$wr_myContent .= '</div>';
} else {	
	$wr_myContent = '<input type="hidden" name="wr_content" value="'.$write['wr_content'].'"><input type="hidden" name="wr_content_mobile" value="'.$write['wr_content_mobile'].'">';
}


//업로드된 이미지 썸네일
include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 
$thumb[$i] = '';
for($i=0; $is_file && $i<$file_count; $i++) {
	$thumb[$i] = get_list_thumbnail($bo_table, $wr_id, 280, 0, false, true, 'center', false, '80/0.5/3', $i, false);
	$upImg[$i] = $thumb[$i]['src'] && $wr_id ? '<a href="'.$thumb[$i]['ori'].'" target="_blank" alt="'.$file[$i]['source'].'" class="img-ori"><img src="'.$thumb[$i]['src'].'" alt="업로드 이미지" title="'.$file[$i]['source'].'('.$file[$i]['size'].')"></a>' : '<span class="no-img"></span>';
	$upIcon[$i] = $thumb[$i]['src'] && $wr_id ? '<img src="'.$thumb[$i]['ori'].'" alt="업로드 이미지">' : '';
}

//이미지 업로드(갤러리)
$wr_gall_file = '';
$wr_gall_file .= '<div class="wr-list wr-gall-file flex-top">';
$gall_file_count = $is_admin ? 2 : 1;
for($i=0; $i<$gall_file_count; $i++) {
	if(!G5_IS_MOBILE) $wr_gall_file .= '<div class="wr-list-label"><label>이미지'.($i ==0 && $is_admin?'&nbsp;<span class="color-red">(pc)</span>':'').($i == 1 && $is_admin?'&nbsp;<span class="color-red">(mobile)</span>':'').'</label></div>';
	$wr_gall_file .= '<div class="wr-list-con">';
	//if($i == 1) $wr_gall_file .= '<p class="help-block">* 모바일용 이미지가 없으면 PC용 이미지를 모바일에서 함께 사용합니다.</p>';
	$wr_gall_file .= '<input type="file" name="bf_file[]" class="myfile'.(G5_IS_MOBILE?' btnImg':'').'" title="파일첨부 '.$i.' : 용량 '.$upload_max_filesize.' 이하만 업로드 가능" accept="image/*"'.(G5_IS_MOBILE?' data-btn-name="이미지 업로드 '.($i ==0?'(PC용)':'(모바일용)').'"':'').'>';
	$wr_gall_file .= '<div class="upImg">';
	$wr_gall_file .= $upImg[$i];
	if($w == 'u' && $file[$i]['file']) $wr_gall_file .= '<label class="label-del"><input type="checkbox" id="bf_file_del'.$i.'" name="bf_file_del['.$i.']" value="1">파일삭제</label>';
	$wr_gall_file .= '</div>';
	$wr_gall_file .= '</div>';
}
$wr_gall_file .= '</div>';

//파일 업로드
$bo_upload_size_mb = $board['bo_upload_size'] / 1048576;
$wr_file = '';
for ($i=0; $is_file && $i<$file_count; $i++) {
	$wr_file .= '<div class="wr-list">';
	if(!G5_IS_MOBILE) {
		$wr_file .= '<div class="wr-list-label"><label>파일첨부';
		if($file_count > 1) $wr_file .= '<span class="fileNum">'.($i+1).'</span>';
		$wr_file .= '</label></div>';
	}
	$wr_file .= '<div class="wr-list-con">';
	$wr_file .= '<input type="file" name="bf_file[]" class="myfile'.(G5_IS_MOBILE?' btnfile':'').'" title="파일첨부 '.$i.' : 용량 '.$upload_max_filesize.' 이하만 업로드 가능" '.($is_admin?'':'data-maxSize="'.$bo_upload_size_mb.'"').(G5_IS_MOBILE?' data-btn-name="파일첨부"':"").'>';
	if($is_file_content && !G5_IS_MOBILE) $wr_file .= '<input type="text" name="bf_content[]" value="'.$file[$i]['bf_content'].'" class="inp_file_name" size="50" data-label="파일설명" data-class="ml20">';	
	if($w == 'u' && $file[$i]['file']) {
		$wr_file .= '<div class="upfile">';
		$wr_file .= '<span class="info">'.$file[$i]['source'].'('.$file[$i]['size'].')</span>';
		$wr_file .= '<input type="checkbox" id="bf_file_del'.$i.'" name="bf_file_del['.$i.']" value="1" data-label="파일삭제">';
		$wr_file .= '</div>';
	}
	if(!$is_admin) $wr_file .= '<p class="help-block">※'.$bo_upload_size_mb.'MB 이하의 파일로 업로드 해주세요.</p>';
	$wr_file .= '</div>';
	$wr_file .= '</div>';
}


//동영상
$wr_video = '';
if($is_admin) {
	$wr_video .= '<div class="wr-list wr-video">'.PHP_EOL;
	$wr_video .= '<div class="wr-list-label"><label class="label-video">동영상</label></div>'.PHP_EOL;
	$wr_video .= '<div class="wr-list-con">'.PHP_EOL;
	$video_play_checked = $write['wr_video_play'] ? 'checked' : '';
	if(strpos($boSkin, 'gallery') !== false) {
		$wr_video .= '<label class="checkbox-video-play myTip mini top" data-tip="목록에서 재생"><input type="checkbox" name="wr_video_play" value="1" '.$video_play_checked.'></label>'.PHP_EOL;
	} else if(strpos($boSkin, 'pageMake') !== false) {
		$wr_video .= '<label class="checkbox-video-play myTip mini top" data-tip="자동재생"><input type="checkbox" name="wr_video_play" value="1" '.$video_play_checked.'></label>'.PHP_EOL;
	} else {
		$wr_video_data = 'data-label-mobile="동영상"';
	}
	$wr_video .= '<input type="'.(G5_IS_MOBILE?'url':'text').'" name="wr_video_src" value="'.$write['wr_video_src'].'" id="wr_video_src" class="w-full" size="50" placeholder="mp4경로,&nbsp;&nbsp;&nbsp;(유투브) https://youtu.be/AbCdefGhiJK...,&nbsp;&nbsp;&nbsp;(비메오) https://vimeo.com/01234567..." '.$wr_video_data.'>'.PHP_EOL;
	$wr_video .= '</div>'.PHP_EOL;
	$wr_video .= '</div>'.PHP_EOL;
}

//게시물링크
$wr_link = '';
if($is_link) {
	$wr_link .= '<div class="wr-list wr-link">'.PHP_EOL;
	$wr_link .= '	<div class="wr-list-label"><label for="wr_link1">게시물 링크</label></div>'.PHP_EOL;
	$wr_link .= '	<div class="wr-list-con flex sm:column">'.PHP_EOL;
	$wr_link .= '		<label id="link-name" style="'.($write['wr_link_name'] != 'attach'?'display:none':'').'">'.PHP_EOL;
	$wr_link .= '			<input type="text" name="wr_link_name" value="'.$write['wr_link_name'].'" id="wr_link_name" class="w-200" size="50" placeholder="링크 설명" data-label="링크 설명">'.PHP_EOL;
	$wr_link .= '		</label>'.PHP_EOL;
	$wr_link .= '		<input type="'.(G5_IS_MOBILE?'url':'text').'" name="wr_link1" value="'.$write['wr_link1'].'" id="wr_link1" class="lg:flex1" placeholder="http://" data-label-mobile="링크">'.PHP_EOL;
	$wr_link .= G5_IS_MOBILE?'<select name="wr_link_target" value="'.$write['wr_link_target'].'" id="wr_link_target" class="selectpicker link-target">':'<select name="wr_link_target" value="'.$write['wr_link_target'].'" id="wr_link_target" class="selectpicker link-target">'.PHP_EOL;
	$wr_link .=		option_selected("_self",  $write['wr_link_target'], "바로 이동");
	$wr_link .=		option_selected("_blank",  $write['wr_link_target'], "새창 열기");	
	$wr_link .=		option_selected("attach",  $write['wr_link_target'], "링크 첨부");
	if($is_admin) $wr_link .= option_selected("popup",  $write['wr_link_target'], "팝업");
	if($is_admin) $wr_link .= G5_IS_MOBILE ? option_selected("alert",  $write['wr_link_target'], "↑엘럿") : option_selected("alert",  $write['wr_link_target'], "←엘럿");	
	$wr_link .= '		</select>'.PHP_EOL;	
	$wr_link .= '		<span id="popup-option" class="popupOption" style="'.($write['wr_link_target'] != 'popup'?'display:none':'').'">'.PHP_EOL;
	$wr_link .= '			<input type="text" name="wr_link_option[0]" value="'.$wr_link_option[0].'" class="w-70" size="50" placeholder="가로" data-label-inline="W">'.PHP_EOL;
	$wr_link .= '			<input type="text" name="wr_link_option[1]" value="'.$wr_link_option[1].'" class="w-70" size="50" placeholder="세로" data-label-inline="H">'.PHP_EOL;
	$wr_link .= '			<input type="text" name="wr_link_option[2]" value="'.$wr_link_option[2].'" class="w-70" size="50" placeholder="left" data-label-inline="L">'.PHP_EOL;
	$wr_link .= '			<input type="text" name="wr_link_option[3]" value="'.$wr_link_option[3].'" class="w-70" size="50" placeholder="top" data-label-inline="T">'.PHP_EOL;
	$wr_link .= '		</span>'.PHP_EOL;
	
	$wr_link .= '	</div>'.PHP_EOL;
	$wr_link .= '</div>'.PHP_EOL;
}

//버튼달기
$wr_btn = '<div class="wr-group/btn-group">';
$wr_btn .= '<div class="wr-group-head"><span class="tag">버튼달기</span><span class="add-list">추가</span></div>';
$wr_btn .= '<div class="option-list">';
for($i=1; $i<=6; $i++) {
	if($i==1 || $ex_btn[$i][0]) {
		$wr_btn .= '<div class="wr-list wr-btn">'.PHP_EOL;
		$wr_btn .= '<div class="wr-list-con flex">'.PHP_EOL;
		$wr_btn .= '<div class="btnColor-set">'.PHP_EOL;
		$wr_btn .= '<input type="text" name="wr_btn'.$i.'[0]" value="'.$ex_btn[$i][0].'" class="btn-name w-140" size="50" placeholder="바로가기" data-label="버튼명'.$i.'">'.PHP_EOL;
		$wr_btn .= '<div class="labelColor-hiddenSet">'.PHP_EOL;
		$wr_btn .= '<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="wr_btn'.$i.'_color[0]" value="'.get_text($wr_btn_color[$i][0]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
		$wr_btn .= '<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="wr_btn'.$i.'_color[1]" value="'.get_text($wr_btn_color[$i][1]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
		$wr_btn .= '</div>'.PHP_EOL;
		$wr_btn .= '</div>'.PHP_EOL;
		$wr_btn .= '<input type="'.(G5_IS_MOBILE?'url':'text').'" name="wr_btn'.$i.'[1]" value="'.$ex_btn[$i][1].'" id="wr_btn'.$i.'_link" size="50" class="btn-link flex1" placeholder="http://">'.PHP_EOL;
		if(G5_IS_MOBILE) $wr_btn .= '<div class="flex gap10">';
		$wr_btn .= '<select name="wr_btn'.$i.'[2]" value="'.$ex_btn[$i][2].'" id="wr_btn'.$i.'_target" class="selectpicker lg:w-130 btn-target">'.PHP_EOL;
		$wr_btn .= option_selected("_self",  $ex_btn[$i][2], "바로 이동");
		$wr_btn .= option_selected("_blank",  $ex_btn[$i][2], "새창 열기");				
		$wr_btn .= option_selected("popup",  $ex_btn[$i][2], "팝업");
		$wr_btn .= option_selected("alert",  $ex_btn[$i][2], "←엘럿");
		$wr_btn .= option_selected("layerpopup",  $ex_btn[$i][2], "레이어 팝업");
		$wr_btn .= option_selected("down",  $ex_btn[$i][2], "다운로드 링크");
		$wr_btn .= '</select>'.PHP_EOL;
		$wr_btn .= '<span class="btnPopupOption">'.PHP_EOL;
		$wr_btn .= '<input type="tel" name="wr_btn'.$i.'[3]" value="'.$ex_btn[$i][3].'" class="lg:w-70 sm:w-90" size="50" placeholder="가로" data-label-inline="W">'.PHP_EOL;
		$wr_btn .= '<input type="tel" name="wr_btn'.$i.'[4]" value="'.$ex_btn[$i][4].'" class="lg:w-70 sm:w-90" size="50" placeholder="세로" data-label-inline="H">'.PHP_EOL;
		$wr_btn .= '</span>'.PHP_EOL;
		if(G5_IS_MOBILE) $wr_btn .= '</div>'.PHP_EOL;
		$wr_btn .= '</div>'.PHP_EOL;
		$wr_btn .= '</div>'.PHP_EOL;
	}
}
$wr_btn .= '</div>'.PHP_EOL;
$wr_btn .= '</div>'.PHP_EOL;

$myScript .= '
$(function() {
	$(document).on("click", ".add-list", function() {
		add_list();
	});
	$(document).on("click", ".del-list", function() {
		var $li = $(this).closest(".wr-list");
		$li.remove();        
	});
});
function add_list() {
	var $option_list = $(".option-list");
	var count = $(".option-list .wr-list").length + 1;
	if(count <= 6) {
		var list = \'<div class="wr-list wr-btn">\';
		list += \'<div class="wr-list-con flex">\';
		list += \'<div class="btnColor-set">\';
		list += \'<label class="labelInput left-label"><span class="label">버튼명\'+count+\'</span><input type="text" name="wr_btn\'+count+\'[0]" value="" class="btn-name w-140" size="50" placeholder="바로가기" data-label="버튼명\'+count+\'"></label>\';
		list += \'<div class="labelColor-hiddenSet">\';
		list += \'<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="wr_btn\'+count+\'_color[0]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>\';
		list += \'<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="wr_btn\'+count+\'_color[1]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>\';
		list += \'</div>\';
		list += \'</div>\';
		list += \'<input type="text" name="wr_btn\'+count+\'[1]" value="" id="wr_btn\'+count+\'_link" size="50" class="btn-link flex1" placeholder="http://">\';
		list += \'<select name="wr_btn\'+count+\'[2]" value="" id="wr_btn\'+count+\'_target" class="selectpicker lg:w-130 btn-target">\';
		list += \'<option value="_self">바로 이동</option>\';
		list += \'<option value="_blank">새창 열기</option>\';
		list += \'<option value="popup">팝업</option>\';
		list += \'<option value="alert">←엘럿</option>\';
		list += \'<option value="layerpopup">레이어 팝업</option>\';
		list += \'<option value="down">다운로드 링크</option>\';
		list += \'</select>\';
		list += \'<span class="btnPopupOption">\';
		list += \'<label class="labelInput"><input type="text" name="wr_btn\'+count+\'[3]" value="" class="w-70" size="50" placeholder="가로" data-label-inline="W" style="padding-right:17px;"><span class="label-inline">W</span></label>\';
		list += \'<label class="labelInput"><input type="text" name="wr_btn\'+count+\'[4]" value="" class="w-70" size="50" placeholder="세로" data-label-inline="H" style="padding-right:17px;"><span class="label-inline">H</span></label>\';
		list += \'</span>\';
		list += \'</div>\';
		list += \'</div>\';
		var $list_last = null;
		var $list_last = $option_list.find(".wr-list:last");
		$list_last.after(list);
		$(".selectpicker").selectpicker("refresh");
		btn_target("select.btn-target");
		colorpicker(".colorpicker");
	} else {
		alert("버튼은 6개 까지 추가 가능합니다.");
	}
}';


//태그입력
$wr_tag = '';
if($board['bo_use_tag']) {
	add_javascript('<script src="'.get_url(G5_JS_URL.'/my/form/tagsinput/jquery.tagsinput.js').'"></script>', 0);
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/tagsinput/jquery.tagsinput.css').'">', 0);
	$myScript .= '$(".tagInput").tagsInput();';
	$wr_tag .= '<div class="wr-list">';
	if(G5_IS_MOBILE) $wr_tag .= '<div class="wr-list-label"><label>태그 달기</label></div>'.PHP_EOL;
	$wr_tag .= '<div class="wr-list-con">';
	$wr_tag .= '<input type="text" name="wr_tag" value="'.$write['wr_tag'].'" id="wr_tag" class="w-full tagInput" placeholder="태그입력 (,)로 구분">';
	$wr_tag .= '</div>';
	$wr_tag .= '</div>';
}

//인크루드 파일생성
$wr_include = '';
if($write['wr_id'] && !G5_IS_MOBILE && $is_admin == 'super') {
	$htmlURL = G5_HTML_URL.'/'.$bo_table;
	$includeFilePATH_top = G5_HTML_PATH.'/'.$bo_table.'/section_'.$write['wr_id'].'_top.php';
	$includeFilePATH = G5_HTML_PATH.'/'.$bo_table.'/section_'.$write['wr_id'].'.php';
	$includeFileURL = G5_HTML_URL.'/'.$bo_table.'/section_'.$write['wr_id'].'.php';
	$includeTop = file_exists($includeFilePATH_top) ? 'active' : 'bin';
	$include = file_exists($includeFilePATH) ? 'active' : 'bin';
	
	$wr_include .= '<div class="wr-list">'.PHP_EOL;
	$wr_include .= '	<div class="wr-list-label"><label>HTML 파일</label></div>'.PHP_EOL;
	$wr_include .= '	<div class="wr-list-con">'.PHP_EOL;
	$wr_include .= '		<div class="layout-box column gap5 w-90">'.PHP_EOL;

	if(strpos($board['bo_skin'], 'pageMake') !== false) {
		$wr_include .= '			<div class="itemContainer">'.PHP_EOL;
		$wr_include .= '				<div class="item h-20 fileMake '.$includeTop.'" data-filepath="'.$includeFilePATH_top.'">내용 상단</div>'.PHP_EOL;
		$wr_include .= '				<span class="fileDelete" data-filepath="'.$includeFilePATH_top.'">삭제</span>';
		$wr_include .= '				<p class="text">html/'.$bo_table.'/section_'.$write['wr_id'].'_top.php</p>'.PHP_EOL;
		$wr_include .= '			</div>'.PHP_EOL;
		$wr_include .= '			<div class="itemContainer">'.PHP_EOL;
		$wr_include .= '				<div class="item h-18">내용</div>'.PHP_EOL;
		$wr_include .= '			</div>'.PHP_EOL;
		$wr_include .= '			<div class="itemContainer">'.PHP_EOL;
		$wr_include .= '				<div class="item h-20 fileMake '.$include.'" data-filepath="'.$includeFilePATH.'">내용 하단</div>'.PHP_EOL;
		$wr_include .= '				<span class="fileDelete" data-filepath="'.$includeFilePATH.'">삭제</span>';
		$wr_include .= '				<p class="text">html/'.$bo_table.'/section_'.$write['wr_id'].'.php</p>'.PHP_EOL;
		$wr_include .= '			</div>'.PHP_EOL;
	} else {
		$wr_include .= '			<div class="itemContainer">'.PHP_EOL;
		$wr_include .= '				<div class="item h-20 fileMake '.$include.'" data-filepath="'.$includeFilePATH.'">HTML 인크루드</div>'.PHP_EOL;
		$wr_include .= '				<span class="fileDelete" data-filepath="'.$includeFilePATH.'">삭제</span>';
		$wr_include .= '				<p class="text">html/'.$bo_table.'/<b>section_'.$write['wr_id'].'.php</b></p>'.PHP_EOL;
		$wr_include .= '			</div>'.PHP_EOL;
		$wr_include .= '			<div class="itemContainer">'.PHP_EOL;
		$wr_include .= '				<div class="item h-18">내용</div>'.PHP_EOL;
		$wr_include .= '			</div>'.PHP_EOL;
	}
	$wr_include .= '		</div>'.PHP_EOL;
	$wr_include .= '	</div>'.PHP_EOL;
	$wr_include .= '</div>'.PHP_EOL;

	$myScript .= '
	$(document).ready(function() {
		matchOnOff("#wr_use", "none", "#use-none-help");
	});';
}



//삭제버튼
if ($w == 'u') { //수정페이지 일때
	$is_delete = true;
	if(($member['mb_id'] && ($write['mb_id'] == $member['mb_id'])) || $is_admin) {		
		set_session("ss_delete_token", $token = uniqid(time()));
		$delete_href = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);		
	} else if (!$write['mb_id']) { // 회원이 쓴 글이 아니라면
		$delete_href = './password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;page='.$page.$qstr;
	}
	$deleteCode = '<a href="'.$delete_href.'" class="btn_del" onclick="del(this.href); return false;" alt="삭제">삭제</a>';
}


//자동등록방지
if($is_use_captcha) $wr_captcha = '<div class="wr-list"><div class="wr-list-label"><label>자동등록방지</label></div><div class="wr-list-con">'.$captcha_html.'</div></div>';







/*▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣*/

if($boStyle) echo '<style>'.$boStyle.'</style>'; //게시판 스타일

echo '<div id="'.$bo_table.'" class="boWrap '.$boSkin.'" data-option="'.$bo_skinOption.'">';

if(G5_IS_MOBILE) {
	if($board['bo_use_mobile_write']) {
		if(file_exists($board_skin_path.'/write.skin.php')) {
			include_once ($board_skin_path.'/write.skin.php');
		} else if(file_exists($board_pcskin_path.'/write.skin.php')) {
			include_once ($board_pcskin_path.'/write.skin.php');
		}
	} else {
		alert("PC모드에서만 등록 및 수정이 가능합니다.", G5_BBS_URL."/board.php?bo_table=$bo_table".$qstr);
	}
} else {

	echo '<div id="_boContainer" class="max-width">';
	
		if($group['gr_2']) include_once(G5_BBS_PATH.'/my/_bo_submenu.php');
		
		echo '<div id="_boContainer_con">';

			include_once ($board_skin_path.'/write.skin.php');

		echo '</div>';
	echo '</div>';

	
}

echo '</div>'; // end - boWrap

$myScript .= '$(".btnSubmit").click(function(){ $(".bo_btnSet #btn_submit").click(); });';

//html 파일 만들기 스크립트
$_filemake_type = 'board';
$_filemake_dir = $bo_table;
$_filemake_id = $wr_id;
$_skin = $board['bo_skin'];
include_once(G5_BBS_PATH.'/my/filemake_script.php');

include_once('./board_tail.php');
@include_once ($board_skin_path.'/write.tail.skin.php');
include_once(G5_PATH.'/tail.sub.php');
<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_EDITOR_LIB);

$bo_table = $_GET['bo_table'];
$write_table = $g5['write_prefix'] . $bo_table;
$w = $wr_id ? 'u' : '';

/*─────────────────────────────────────────────────────────────────────
														게시물 상단, 하단 html 인크루드 만들기
─────────────────────────────────────────────────────────────────────*/
$includeFilePATH_top = G5_HTML_PATH.'/'.$bo_table.'/section_'.$write['wr_id'].'_top.php';
$includeFilePATH = G5_HTML_PATH.'/'.$bo_table.'/section_'.$write['wr_id'].'.php';
$includeTop = file_exists($includeFilePATH_top) ? 'active' : 'bin';
$include = file_exists($includeFilePATH) ? 'active' : 'bin';
$list_inc_info = '<div id="bo_inc_info">';
$list_inc_info .= '<div class="layout-box column gap5 w-75">';
$list_inc_info .= '<div class="itemContainer">';
$list_inc_info .= '<span class="item h-15 fileMake '.$includeTop.'" data-filepath="'.$includeFilePATH_top.'">상단</span>';
$list_inc_info .= '<span class="fileDelete" data-filepath="'.$includeFilePATH_top.'">삭제</span>';
$list_inc_info .= '</div>';
$list_inc_info .= '<div class="itemContainer">';
$list_inc_info .= '<span class="item h-15 fileMake '.$include.'" data-filepath="'.$includeFilePATH.'">하단</span>';
$list_inc_info .= '<span class="fileDelete" data-filepath="'.$includeFilePATH.'">삭제</span>';
$list_inc_info .= '</div>';
$list_inc_info .= '</div>';
$list_inc_info .= '</div>';
$list_inc_info .= '<script>';
$list_inc_info .= '
$(".fileMake:not(.active)").click(function() {
	var $this = $(this),
		dir = "'.$bo_table.'",
		clickBtnData = $(this).attr("data-filepath"),
		wr_id = "'.$write['wr_id'].'",
		ajaxurl = "'.G5_BBS_URL.'/my/file.make.php",
		data = {"dir":dir, "file_url":clickBtnData, "wr_id":wr_id, "bo_skin":"'.$board['bo_skin'].'"};
	$.post(ajaxurl, data, function (response) {
		$this.addClass("active").removeClass("bin");
		alert("파일을 생성했습니다.");		
	});
});
$(".fileDelete").click(function() {
	if(confirm("정말 삭제하시겠습니까??") == true) {
		var $this = $(this),
			clickBtnData = $(this).attr("data-filepath"),
			ajaxurl = "'.G5_BBS_URL.'/my/file.delete.php",
			data =  {"file_url": clickBtnData};
		$.post(ajaxurl, data, function (response) {
			$this.prev(".fileMake").removeClass("active").addClass("bin");
			//alert("파일을 삭제했습니다.");
		});
	} else {
		return false;
	}
});';
$list_inc_info .= '</script>';


/*─────────────────────────────────────────────────────────────────────
														내용 에디터
─────────────────────────────────────────────────────────────────────*/
$content = get_text($write['wr_content'], 0);
$editor_height = 120;
$editor_html = editor_html('wr_content', $content, true, $editor_height);
$editor_js = '';
$editor_js .= get_editor_js('wr_content', true);
$editor_js .= chk_editor_js('wr_content', true);
$editor_mobile_html = editor_html('wr_content_mobile', $write['wr_content_mobile'], true, $editor_height);
$editor_mobile_js = '';
$editor_mobile_js .= get_editor_js('wr_content_mobile', true);
$editor_mobile_js .= chk_editor_js('wr_content_mobile', true);

//내용
$wrEditorClass = 'editor '.$config['cf_editor'];
$wr_myContent = '';
$wr_myContent .= '<div class="form-list wr_content '.$wrEditorClass.'">';
$wr_myContent .= '<div class="formCon">';
$wr_myContent .= '<div class="wrConBox">';
if($is_admin && !G5_IS_MOBILE) {
	$wr_myContent .= '<ul class="wrConTabs">';
	$wr_myContent .= '<li class="active icon_pc" data-target="pcCon" title="PC"></li>';
	$wr_myContent .= '<li class="icon_mobile" data-target="mobileCon" title="모바일"></li>';
	$wr_myContent .= '</ul>';
}
if(G5_IS_MOBILE) {
	if($write['wr_content'] && $write['wr_content_mobile']) {
		$wr_myContent .= '<input type="hidden" name="wr_content" value="'.$write['wr_content'].'">';
		$wr_myContent .= '<div class="tabEditor mobileCon">'.$editor_mobile_html.'</div>';		
	} else {
		$wr_myContent .= '<div class="tabEditor pcCon">'.$editor_html.'</div>';
		$wr_myContent .= '<input type="hidden" name="wr_content_mobile" value="'.$write['wr_content_mobile'].'">';
	}		
} else {
	$wr_myContent .= '<div class="tabEditor pcCon active">';
	if($write_min || $write_max) $wr_myContent .= '<p id="char_count_desc">이 게시판은 최소 <strong>'.$write_min.'</strong>글자 이상, 최대 <strong>'.$write_max.'</strong>글자 이하까지 글을 쓰실 수 있습니다.</p>';
	$wr_myContent .= $editor_html;
	if($write_min || $write_max) $wr_myContent .= '<div id="char_count_wrp"><span id="char_count"></span>글자</div>';
	$wr_myContent .= '</div>';
	$wr_myContent .= '<div class="tabEditor mobileCon">'.$editor_mobile_html.'</div>';
	//$wr_myContent .= $help_html;
}
$wr_myContent .= '</div>';
$wr_myContent .= '</div>';
$wr_myContent .= '</div>';






/*─────────────────────────────────────────────────────────────────────
															갤러리 이미지
─────────────────────────────────────────────────────────────────────*/
if($w == 'u') {
	include_once(G5_LIB_PATH.'/thumbnail.lib.php'); 
	for($i=0; $i<2; $i++) {
		$thumb[$i] = get_list_thumbnail($bo_table, $wr_id, 280, 0, false, true, 'center', false, '80/0.5/3', $i, false);
		$upImg[$i] = $thumb[$i]['src'] ? '<img src="'.$thumb[$i]['src'].'" alt="업로드 이미지">' : '';
	}
}
$form_gall_file = '';
$form_gall_file .= '<div class="form-list wr-gall-file flex-top">';
for($i=0; $i<2; $i++) {
	$form_gall_file .= '<div class="form-label"><label>이미지 '.($i == 0?'<span class="color-red">(pc)</span>' : '<span class="color-red">(mobile)</span>').'</label></div>';
	$form_gall_file .= '<div class="formCon">';
	$form_gall_file .= '<input type="file" name="bf_file[]" class="myfile" title="파일첨부 '.$i.' : 용량 '.$upload_max_filesize.' 이하만 업로드 가능" accept="image/*">';
	$form_gall_file .= '<div class="upImg">';
	if($upImg[$i]) $form_gall_file .= $upImg[$i].'<label class="label-del"><input type="checkbox" id="bf_file_del'.$i.'" name="bf_file_del['.$i.']" value="1"></label>';
	$form_gall_file .= '</div>';
	$form_gall_file .= '</div>';
}
$form_gall_file .= '</div>';


/*─────────────────────────────────────────────────────────────────────
																동영상
─────────────────────────────────────────────────────────────────────*/
$form_video = '';
$form_video .= '<div class="form-list wr-video">'.PHP_EOL;
$form_video .= '<div class="form-label"><label class="label-video">동영상</label></div>'.PHP_EOL;
$form_video .= '<div class="formCon flex">'.PHP_EOL;
$form_video .= '<label class="checkbox-video-play myTip mini top flex1" data-tip="자동재생"><input type="checkbox" name="wr_video_play" value="1"'.($write['wr_video_play']?' checked':'').'></label>'.PHP_EOL;
$form_video .= '<input type="url" name="wr_video_src" value="'.$write['wr_video_src'].'" id="wr_video_src" class="span" size="50" placeholder="mp4경로,&nbsp;&nbsp;&nbsp;(유투브) https://youtu.be/AbCdefGhiJK...,&nbsp;&nbsp;&nbsp;(비메오) https://vimeo.com/01234567...">'.PHP_EOL;
if(!G5_IS_MOBILE) {
	if(strpos($board['bo_skin'], 'pageMake') !== false) $form_video .= '<input type="text" name="wr_video_width" value="'.($write['wr_video_width']?$write['wr_video_width']:'').'" id="wr_video_width" class="w-full" size="4" placeholder="" data-class="w-220" data-label="영상 가로사이즈" data-label-inline="PX">';
} else {
	$form_video .= '<input type="hidden" name="wr_video_width" value="'.($write['wr_video_width']?$write['wr_video_width']:'').'">';
}
$form_video .= '</div>'.PHP_EOL;
$form_video .= '</div>'.PHP_EOL;




//버튼달기
for ($i=1; $i<=6; $i++) {
	$ex_btn[$i] = explode("|", $write['wr_btn'.$i]);
	$wr_btn_color[$i] = explode("|", $write['wr_btn'.$i.'_color']);
}
$form_btn = '<div class="form-btn-set">';
$form_btn .= '<div class="form-btn-head"><span class="tag">버튼달기</span><span class="add-list">추가</span></div>';
$form_btn .= '<div class="option-list">';
for($i=1; $i<=6; $i++) {
	if($i==1 || $ex_btn[$i][0]) {
		$form_btn .= '<div class="form-btn-list">'.PHP_EOL;
		$form_btn .= '<div class="formCon flex">'.PHP_EOL;
		$form_btn .= '<div class="btnColor-set">'.PHP_EOL;
		$form_btn .= '<input type="text" name="wr_btn'.$i.'[0]" value="'.$ex_btn[$i][0].'" class="btn-name w-140" size="50" placeholder="바로가기" data-label="버튼명'.$i.'">'.PHP_EOL;
		$form_btn .= '<div class="labelColor-hiddenSet">'.PHP_EOL;
		$form_btn .= '<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="wr_btn'.$i.'_color[0]" value="'.get_text($wr_btn_color[$i][0]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
		$form_btn .= '<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="wr_btn'.$i.'_color[1]" value="'.get_text($wr_btn_color[$i][1]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
		$form_btn .= '</div>'.PHP_EOL;
		$form_btn .= '</div>'.PHP_EOL;
		$form_btn .= '<input type="text" name="wr_btn'.$i.'[1]" value="'.$ex_btn[$i][1].'" id="wr_btn'.$i.'_link" size="50" class="btn-link flex1" placeholder="http://">'.PHP_EOL;
		$form_btn .= '<select name="wr_btn'.$i.'[2]" value="'.$ex_btn[$i][2].'" id="wr_btn'.$i.'_target" class="selectpicker w-130 btn-target">'.PHP_EOL;
		$form_btn .= option_selected("_self",  $ex_btn[$i][2], "바로 이동");
		$form_btn .= option_selected("_blank",  $ex_btn[$i][2], "새창 열기");				
		$form_btn .= option_selected("popup",  $ex_btn[$i][2], "팝업");
		$form_btn .= option_selected("alert",  $ex_btn[$i][2], "←엘럿");
		$form_btn .= option_selected("layerpopup",  $ex_btn[$i][2], "레이어 팝업");
		$form_btn .= option_selected("down",  $ex_btn[$i][2], "다운로드 링크");
		$form_btn .= '</select>'.PHP_EOL;
		$form_btn .= '<span class="btnPopupOption">'.PHP_EOL;
		$form_btn .= '<input type="text" name="wr_btn'.$i.'[3]" value="'.$ex_btn[$i][3].'" class="w-70" size="50" placeholder="가로" data-label-inline="W">'.PHP_EOL;
		$form_btn .= '<input type="text" name="wr_btn'.$i.'[4]" value="'.$ex_btn[$i][4].'" class="w-70" size="50" placeholder="세로" data-label-inline="H">'.PHP_EOL;
		$form_btn .= '</span>'.PHP_EOL;
		$form_btn .= '</div>'.PHP_EOL;
		$form_btn .= '</div>'.PHP_EOL;
	}
}
$form_btn .= '</div>'.PHP_EOL;
$form_btn .= '</div>'.PHP_EOL;
$form_btn .= '<script>
$(function() {
	$(document).on("click", ".add-list", function() {
		add_list();
	});
	$(document).on("click", ".del-list", function() {
		var $li = $(this).closest(".form-btn-list");
		$li.remove();        
	});
});
function add_list() {
	var $option_list = $(".option-list");
	var count = $(".option-list .form-btn-list").length + 1;
	if(count <= 6) {
		var list = \'<div class="form-btn-list">\';
		list += \'<div class="formCon flex">\';
		list += \'<div class="btnColor-set">\';
		list += \'<label class="labelInput left-label"><span class="label">버튼명\'+count+\'</span><input type="text" name="wr_btn\'+count+\'[0]" value="" class="btn-name w-140" size="50" placeholder="바로가기" data-label="버튼명\'+count+\'"></label>\';
		list += \'<div class="labelColor-hiddenSet">\';
		list += \'<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="wr_btn\'+count+\'_color[0]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>\';
		list += \'<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="wr_btn\'+count+\'_color[1]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>\';
		list += \'</div>\';
		list += \'</div>\';
		list += \'<input type="text" name="wr_btn\'+count+\'[1]" value="" id="wr_btn\'+count+\'_link" size="50" class="btn-link flex1" placeholder="http://">\';
		list += \'<select name="wr_btn\'+count+\'[2]" value="" id="wr_btn\'+count+\'_target" class="selectpicker w-130 btn-target">\';
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
		var $list_last = $option_list.find(".form-btn-list:last");
		$list_last.after(list);
		$(".selectpicker").selectpicker("refresh");
		btn_target("select.btn-target");
		colorpicker(".colorpicker");
	} else {
		alert("버튼은 6개 까지 추가 가능합니다.");
	}
}
</script>';


/*─────────────────────────────────────────────────────────────────────
														pageMake 에서 블록편집할때
─────────────────────────────────────────────────────────────────────*/
if(strpos($board['bo_skin'], 'pageMake') !== false) {
	// 원글만 구한다.
	$sql = " select count(*) as cnt from {$write_table}
				where wr_reply like '{$reply}%'
				and wr_id <> '{$write['wr_id']}'
				and wr_num = '{$write['wr_num']}'
				and wr_is_comment = 0 ";
	$row = sql_fetch($sql);

	$latest_table = $write['latest_table'];
	$latest_board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$latest_table}' ");

	if(preg_match('#^theme/(.+)$#', $write['latest_skin'], $match)) { //테마스킨
		$latest_pcskin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$write['latest_skin'] = $match[1];
	} else if(preg_match('#^seperate/(.+)$#', $write['latest_skin'], $match)) { // 전용스킨
		$latest_pcskin_path = G5_THIS_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if (G5_IS_MOBILE) {
			$latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);	
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;
		}
		$write['latest_skin'] = $match[1];
	} else {
		$latest_pcskin_path = G5_SKIN_PATH.'/latest/'.$write['latest_skin'];
		$latest_pcskin_url = str_replace(G5_PATH, G5_URL, $latest_pcskin_path);
		if(G5_IS_MOBILE) {
			$latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$write['latest_skin'];
			if(!is_dir($latest_skin_path)) $latest_skin_path = $latest_pcskin_path;
			$latest_skin_url  = str_replace(G5_PATH, G5_URL, $latest_skin_path);		
		} else {
			$latest_skin_path = $latest_pcskin_path;
			$latest_skin_url = $latest_pcskin_url;	
		}
	}
	$sel_li_id = explode(",",$write['latest_sel_li_id']);

	$bo_option = explode("|",$board['bo_option']);
	$bl_font = $bo_option[0] ? $bo_option[0] : 'noto600'; //블록 제목 폰트
}
// ──────────────────────────────────────────────────────────────────────────────────────


if(file_exists($board_pcskin_path.'/'.$pn.'.skin.php')) {
	include_once($board_pcskin_path.'/'.$pn.'.skin.php');
    return;
}
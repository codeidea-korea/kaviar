<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);

$bo_background = explode("|",$board['bo_background']);
$bo_option = explode("|",$board['bo_option']);

//인크루드 파일 스크립트
echo '<script>

</script>';


// 게시판 상단, 하단 html 인크루드 만들기 ──────────────────────────────────────────────
$bo_inc_info = '<div id="bo_inc_info">';
$inc_boTop = G5_HTML_PATH.'/'.$bo_table.'/bo_top.php';
$inc_boBottom = G5_HTML_PATH.'/'.$bo_table.'/bo_bottom.php';
$inc_boTop_class = file_exists($inc_boTop) ? 'active' : 'bin';
$inc_boBottom_class = file_exists($inc_boBottom) ? 'active' : 'bin';
$bo_inc_info .= '<div class="layout-box column gap5 w-75">';
$bo_inc_info .= '<div class="itemContainer">';
$bo_inc_info .= '<span class="item h-16 fileMake '.$inc_boTop_class.'" data-filepath="'.$inc_boTop.'">상단</span>';
$bo_inc_info .= '<span class="fileDelete" data-filepath="'.$inc_boTop.'">삭제</span>';
$bo_inc_info .= '</div>';
$bo_inc_info .= '<div class="itemContainer">';
$bo_inc_info .= '<span class="item h-16 fileMake '.$inc_boBottom_class.'" data-filepath="'.$inc_boBottom.'">하단</span>';
$bo_inc_info .= '<span class="fileDelete" data-filepath="'.$inc_boBottom.'">삭제</span>';
$bo_inc_info .= '</div>';
$bo_inc_info .= '</div>';
$bo_inc_info .= '</div>';


// 상단 이미지 관리 ──────────────────────────────────────────────
$img_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img.png';
$img_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img.png';
$upImg = file_exists($img_path) ? '<img src="'.get_url($img_url).'"><label class="del_file"><input type="checkbox" id="del_bo_top_img" name="del_bo_top_img" value="1">삭제</label>' : '';
$img_mob_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img_mob.png';
$img_mob_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img_mob.png';	
$upImg_mob = file_exists($img_mob_path) ? '<img src="'.get_url($img_mob_url).'"><label class="del_file"><input type="checkbox" id="del_bo_top_img_mob" name="del_bo_top_img_mob" value="1">삭제</label>' : '';	
$_form_top_img = '<section class="mybox blue '.(file_exists($img_path) || file_exists($img_mob_path)?'':'hide').'">';
$_form_top_img .= '<h2 class="mybox-title toggle">상단 이미지</h2>';
$_form_top_img .= '<div class="formContainer label150">';		
$_form_top_img .= '<div class="form-list flex-top">';
$_form_top_img .= '<div class="form-label"><label>상단 이미지</label></div>';
$_form_top_img .= '<div class="formCon">';
$_form_top_img .= '<input type="file" name="bo_top_img" id="bo_top_img" class="myfile">';
$_form_top_img .= '<div class="upImg" style="max-width:200px;">'.$upImg.'</div>';
$_form_top_img .= '</div>';
$_form_top_img .= '<div class="form-label flex-top"><label class="mobile">상단 이미지 (모바일)</label></div>';
$_form_top_img .= '<div class="formCon">';
$_form_top_img .= '<input type="file" name="bo_top_img_mob" id="bo_top_img_mob" class="myfile">';
$_form_top_img .= '<div class="upImg" style="max-width:200px;">'.$upImg_mob.'</div>';
$_form_top_img .= '</div>';
$_form_top_img .= '</div>';
$_form_top_img .= '<div class="form-list">';
$_form_top_img .= '<div class="form-label"><label>상단 이미지 설정</label></div>';
$_form_top_img .= '<div class="formCon">';
$_form_top_img .= '<select name="bo_top_img_type" id="bo_top_img_type">';
$_form_top_img .= option_selected('1', $board['bo_top_img_type'], "기본형");
$_form_top_img .= option_selected('2', $board['bo_top_img_type'], "커버형");
$_form_top_img .= option_selected('3', $board['bo_top_img_type'], "모션형");
$_form_top_img .= '</select>';			
$_form_top_img .= '<span id="top_img_height">';
$_form_top_img .= '<input type="text" name="bo_top_img_height" value="'.($board['bo_top_img_height']?$board['bo_top_img_height']:'').'" id="bo_top_img_height" class="span60" size="4" data-label="높이" data-label-inline="PX" data-class="ml15">';
$_form_top_img .= '<input type="text" name="bo_top_img_height_mob" value="'.($board['bo_top_img_height_mob']?$board['bo_top_img_height_mob']:'').'" id="bo_top_img_height_mob" class="span60" size="4" data-label="모바일 높이" data-label-inline="PX" data-class="ml5">';
$_form_top_img .= '</span>';
$_form_top_img .= '<script>matchOnOff(\'#bo_top_img_type\', \'3\', \'#top_img_height\');</script>'; //상단 이미지 설정 옵션별 설명 출력
$_form_top_img .= '</div>';
$_form_top_img .= '</div>';
$_form_top_img .= '</div>';
$_form_top_img .= '</section>';
	

// 상단내용 관리 ──────────────────────────────────────────────
$_form_con_head = '<section class="mybox blue '.($board['bo_content_head']?'':'hide visible').'">';
$_form_con_head .= '<h2 class="mybox-title toggle">상단 (Editor)</h2>';
$_form_con_head .= '<div class="formContainer label150">';
$_form_con_head .= '<div class="form-list">';
$_form_con_head .= '<div class="formCon" style="padding-left:30px">';
$_form_con_head .= '<div class="wrConBox">';
$_form_con_head .= '<ul class="wrConTabs">';
$_form_con_head .= '<li class="icon_pc active" data-target="topCon">상단내용</li>';
$_form_con_head .= '<li class="icon_mobile" data-target="topCon_mob">모바일 상단내용</li>';
$_form_con_head .= '</ul>';
$_form_con_head .= '<div class="tabEditor topCon active">';
$_form_con_head .= editor_html("bo_content_head", get_text(html_purifier($board['bo_content_head']), 0), 1, 130);
$_form_con_head .= '</div>';
$_form_con_head .= '<div class="tabEditor topCon_mob">';
$_form_con_head .= editor_html("bo_mobile_content_head", get_text(html_purifier($board['bo_mobile_content_head']), 0), 1, 130);
$_form_con_head .= '</div>';
$_form_con_head .= '</div>';
$_form_con_head .= '</div>';
$_form_con_head .= '</div>';
$_form_con_head .= '</div>';
$_form_con_head .= '</section>';


// 하단내용 관리 ──────────────────────────────────────────────
if($board['bo_top_img_type'] == 2) {
	$_form_con_tail = '<section class="mybox blue '.($board['bo_content_tail']?'':'hide visible').'">';
	$_form_con_tail .= '<h2 class="mybox-title toggle">하단 (Editor)</h2>';
	$_form_con_tail .= '<div class="formContainer label150">';
	$_form_con_tail .= '<div class="form-list">';
	$_form_con_tail .= '<div class="formCon" style="padding-left:30px">';
	$_form_con_tail .= '<div class="wrConBox">';
	$_form_con_tail .= '<ul class="wrConTabs">';
	$_form_con_tail .= '<li class="icon_pc active" data-target="topCon">하단내용</li>';
	$_form_con_tail .= '<li class="icon_mobile" data-target="topCon_mob">모바일 하단내용</li>';
	$_form_con_tail .= '</ul>';
	$_form_con_tail .= '<div class="tabEditor topCon active">';
	$_form_con_tail .= editor_html("bo_content_tail", get_text(html_purifier($board['bo_content_tail']), 0), 1, 130);
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '<div class="tabEditor topCon_mob">';
	$_form_con_tail .= editor_html("bo_mobile_content_tail", get_text(html_purifier($board['bo_mobile_content_tail']), 0), 1, 130);
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '</div>';
	$_form_con_tail .= '</section>';
}

if(file_exists($board_pcskin_path.'/_board_form_listpage.php')) {
	echo '<span id="from-skin"></span>';
	require_once($board_pcskin_path.'/_board_form_listpage.php');
    return;
}
?>

<?php
$_filemake_type = 'board';
$_filemake_dir = $bo_table;
include_once(G5_BBS_PATH.'/my/filemake_script.php');
?>
<?=$bo_inc_info?>


<form name="bf_form" id="bf_form" action="<?=$_adm_update_url?>/_board_form_listpage_update.php" onsubmit="return bf_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="bo_skin" value="<?=$board['bo_skin']?>" id="bo_skin">
<input type="hidden" name="bo_category_label" value="<?=$board['bo_category_label']?>">
<input type="hidden" name="bo_category_list" value="<?=$board['bo_category_list']?>">
<input type="hidden" name="bo_tag_list" value="<?=$board['bo_tag_list']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
<input type="hidden" name="bo_content_tail" value="<?=$board['bo_content_tail']?>">
<input type="hidden" name="bo_mobile_content_tail" value="<?=$board['bo_mobile_content_tail']?>">
	
<?=$_form_top_img?>

<?=$_form_con_head?>

<?=$_form_con_tail?>

<?php
echo '<section class="mybox blue '.($board['bo_use_category'] || $board['bo_use_tag']?'':'hide').'">';
echo '<h2 class="mybox-title toggle">분류</h2>';
echo '<div class="formContainer label170">';
//카테고리
echo '<div class="form-list">';
echo '<div class="form-label">';
echo '<label class="w-full"><input type="text" name="bo_category_label" value="'.$board['bo_category_label'].'" id="bo_category_label" class="frm_input w-full" style="font-weight:bold;" size="15" placeholder="카테고리"></label>';
echo '</div>';
echo '<div class="formCon flex gap15">';
echo '<input type="text" name="bo_category_list" value="'.get_text($board['bo_category_list']).'" id="bo_category_list" class="frm_input flex1" placeholder="분류와 분류 사이는 | 로 구분하세요. 첫자로 #은 입력하지 마세요. 분류명에 일부 특수문자 ()/ 는 사용할수 없습니다.">';
echo '<input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" '.($board['bo_use_category']?'checked':'').' data-label="사용">';
echo '<input type="checkbox" name="bo_cate_all_hidden" value="1"'.($board['bo_cate_all_hidden']?' checked':'').' data-label="전체보기 사용안함">';
echo '</div>';
echo '</div>';
//태그
echo '<div class="form-list">';
echo '<div class="formCon flex gap15">';
echo '<input type="text" name="bo_tag_list" value="'.get_text($board['bo_tag_list']).'" id="bo_tag_list" class="span flex1" data-class="flex1" data-label="#태그" placeholder="태그와 태그 사이는 | 로 구분하세요.">';
echo '<input type="checkbox" name="bo_use_tag" value="1" id="bo_use_tag" '.($board['bo_use_tag']?'checked':'').' data-label="사용">';
echo '</div>';
echo '</div>';
echo '</div>';
echo '</section>';			
?>

<section class="mybox blue">
	<div class="formContainer label140">
		<div class="form-list">
			<div class="form-label"><label>게시판 제목</label></div>
			<div class="formCon">
				<div style="position:relative;">
					<label class="checkbox-hide"><input type="checkbox" name="bo_subject_hide" value="1" <?=$board['bo_subject_hide']?'checked':'';?>></label>
					<input type="text" name="bo_subject" value="<?=get_text($board['bo_subject'])?>" id="bo_subject" required size="80" maxlength="120">						
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label for="bo_table_width">게시판 사이즈</label></div>
			<div class="formCon">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="bo_table_width" value="<?=$board['bo_table_width']?>" id="bo_table_width" required class="percent span65" size="4" data-label="max" data-label-inline="px" data-class="mr30">
				<input type="text" name="bo_padding_top" value="<?=$board['bo_padding_top']?>" id="bo_padding_top" class="frm_input" size="4" data-label="상단여백" data-label-inline="px" data-class="mr10">
				<input type="text" name="bo_padding_bottom" value="<?=$board['bo_padding_bottom']?>" id="bo_padding_bottom" class="required frm_input" size="4" data-label="하단여백" data-label-inline="px" data-class="mr10">
				<input type="text" name="bo_padding_left_right" value="<?=$board['bo_padding_left_right']?>" id="bo_padding_left_right" class="frm_input" size="4" data-label="좌우여백" data-label-inline="px" data-class="mr10">
				<?php } else { ?>
				<input type="hidden" name="bo_table_width" value="<?=$board['bo_table_width']?>">
				<input type="hidden" name="bo_padding_top" value="<?=$board['bo_padding_top']?>">
				<input type="hidden" name="bo_padding_bottom" value="<?=$board['bo_padding_bottom']?>">
				<input type="hidden" name="bo_padding_left_right" value="<?=$board['bo_padding_left_right']?>">
				<?php } ?>
				<input type="text" name="bo_mobile_padding" value="<?=$board['bo_mobile_padding']?>" id="bo_mobile_padding" class="frm_input" size="4" data-label="모바일 여백" data-label-inline="px">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>게시판 배경</label></div>
			<div class="formCon">
				<input type="text" name="bo_background[0]" value="<?=$bo_background[0]?>" class="colorpicker" id="bo_background" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<input type="text" name="bo_background[1]" value="<?=$bo_background[1]?>" class="colorpicker" id="bo_content_color" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-class="ml10" data-label="텍스트 색상">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>게시판 검색 사용</label></div>
			<div class="formCon">
				<?=get_skin_select_my('_boSearch', 'bo_search_skin', 'bo_search_skin', $board['bo_search_skin'], 'class="selectpicker select-img span270 label-OnOff" data-label="검색바 스킨"', true)?>				
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>기본항목 (목록)</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_list_writer" value="1" <?=$board['bo_list_writer']?'checked':'';?> id="bo_writer" class="" data-label="작성자 보이기">
				<input type="checkbox" name="bo_list_date" value="1" <?=$board['bo_list_date']?'checked':'';?> id="bo_date" class="" data-label="날짜 보이기" data-class="ml20">
				<input type="checkbox" name="bo_hit" value="1" <?=$board['bo_hit']?'checked':'';?> id="bo_hit" class="" data-label="조회수 사용" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>상세 팝업</label></div>
			<div class="formCon flex gap25">
				<input type="checkbox" name="bo_layer_popup" value="1" <?=$board['bo_layer_popup']?'checked':''?> id="bo_layer_popup" data-label="팝업으로 상세페이지 열기">
				<?php if(!G5_IS_MOBILE) { ?>
				<div id="viewpop_option">
					<input type="text" name="bo_popup_padding" value="<?=$board['bo_popup_padding']?>" id="bo_popup_padding" class="span60" size="6" placeholder="0" data-label="팝업 여백" data-label-inline="PX">							
					<input type="text" name="bo_popup_min_size" value="<?=$board['bo_popup_min_size']?>" id="bo_popup_min_size" class="span60 percent" size="6" data-class="ml15" data-label="최소사이즈" data-percent-max="100" data-label-inline="PX">
					<input type="text" name="bo_popup_max_size" value="<?=$board['bo_popup_max_size']?>" id="bo_popup_max_size" class="span60 percent" size="6" data-label="팝업 최대사이즈" data-class="ml10" data-label-inline="PX">
				</div>
				<?php } else { ?>
				<input type="hidden" name="bo_popup_padding" value="<?=$board['bo_popup_padding']?>">							
				<input type="hidden" name="bo_popup_min_size" value="<?=$board['bo_popup_min_size']?>">
				<input type="hidden" name="bo_popup_max_size" value="<?=$board['bo_popup_max_size']?>">
				<?php } ?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>제목 길이</label></div>
			<div class="formCon">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="bo_subject_len" value="<?=$board['bo_subject_len']?>" id="bo_subject_len" required class="required numeric " size="4" data-label-inline="글자" data-class="mr15">
				<?php } else { ?>
				<input type="hidden" name="bo_subject_len" value="<?=$board['bo_subject_len']?>">
				<?php } ?>
				<input type="text" name="bo_mobile_subject_len" value="<?=$board['bo_mobile_subject_len']?>" id="bo_mobile_subject_len" required size="4" data-label="모바일 제목길이" data-label-inline="글자">
				<span class="help-block ml15">0은 말줄임 없이 태그도 가능</span>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>페이지당 목록 수</label></div>
			<div class="formCon">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="bo_page_rows" value="<?=$board['bo_page_rows']?>" id="bo_page_rows" required class="required numeric frm_input" size="4" data-label-inline="개" data-class="mr15">
				<?php } else { ?>
				<input type="hidden" name="bo_page_rows" value="<?=$board['bo_page_rows']?>">
				<?php } ?>
				<input type="text" name="bo_mobile_page_rows" value="<?=$board['bo_mobile_page_rows']?>" id="bo_mobile_page_rows" required size="4" data-label="모바일" data-label-inline="개">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>글쓰기 버튼명</label></div>
			<div class="formCon">
				<input type="text" name="bo_btn_write_name" value="<?=get_text($board['bo_btn_write_name'])?>" id="bo_btn_write_name" class="span160" placeholder="버튼명">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>메일발송</label></div>
			<div class="formCon">
				<select id="bo_use_email" name="bo_use_email" class="selectpicker" <?=$board['bo_use_email']?'data-style="selectColor-green"':''?>>
					<?=option_selected(0, $board['bo_use_email'], "사용안함");?>
					<?=option_selected(1, $board['bo_use_email'], "메일발송 (제목만 발송)");?>
					<?=option_selected(2, $board['bo_use_email'], "메일발송 (모든내용 발송)");?>
				</select>
			</div>
		</div>
	</div>

	<?php
	include_once($board_pcskin_path.'/list.head.skin.php');
	if($autoSize) {
		echo '<div id="gall-option" class="mt20 mb10">';	
		echo '	<div class="formContainer label160">';
		echo '		<h2 class="mybox-title-sub mb15">갤러리 스킨 기본설정</h2>';
		
		echo '		<div class="form-list">';
		echo '			<div class="form-label"><label>갤러리 스킨</label></div>';
		echo '			<div class="formCon">';
		echo				get_skin_select_my('board', 'bo_skin', 'bo_skin', $board['bo_skin'], 'required class="selectpicker select-img w-270" ', true, 'gallery');		
		echo '<select name="bo_option[]" class="selectpicker select-img n2 w-170 ml20" data-id="gall-type">';
		echo option_multiple_selected_my("",  "", "기본 스타일", "data-content=\"<img src='".get_url(G5_SKIN_URL."/board/gallery/img/list-style1.gif")."' alt='기본 스타일'><span class='skin_name'>기본 스타일</span>\"");
		echo option_multiple_selected_my("외곽선",  $bo_option[0], "라인 스타일", "data-content=\"<img src='".get_url(G5_SKIN_URL."/board/gallery/img/list-style2.gif")."' alt='라인 스타일'><span class='skin_name'>라인 스타일</span>\"");
		echo '</select>';
		echo '			</div>';
		echo '		</div>';		
		echo '		<div class="form-list">';
		echo '			<div class="form-label"><label>리스트 가로 수</label></div>';
		echo '			<div class="formCon flex flex-imddle gap20">';
		if(!G5_IS_MOBILE) {
			echo get_member_level_select('bo_gallery_cols', 1, 10, $board['bo_gallery_cols'], 'class="selectpicker"');
		} else {
			echo '<input type="hidden" name="bo_gallery_cols" value="'.$board['bo_gallery_cols'].'">';
		}
		echo get_member_level_select('bo_gall_mobile_cols', 1, 10, $board['bo_gall_mobile_cols'], 'class="selectpicker" data-label="모바일"');
		echo '			</div>';
		echo '		</div>';
		if(!G5_IS_MOBILE) {
			echo '		<div class="form-list">';
			echo '			<div class="form-label"><label>반응형 리스트 가로 수</label></div>';
			echo '			<div class="formCon">';
			echo '				<input type="text" name="bo_max_screen" value="'.$board['bo_max_screen'].'" id="bo_max_screen" class="span250" placeholder="1024|840" data-label="@media screen">';
			echo '			</div>';
			echo '		</div>';
		} else {
			echo '<input type="hidden" name="bo_max_screen" value="'.$board['bo_max_screen'].'">';
		}
			
		if($autoSize === 'masonry') {
			echo '	<input type="hidden" name="bo_gallery_width" value="'.$board['bo_gallery_width'].'">';
			echo '	<input type="hidden" name="bo_gallery_height" value="'.$board['bo_gallery_height'].'">';
			echo '	<input type="hidden" name="bo_mobile_gallery_width" value="'.$board['bo_mobile_gallery_width'].'">';
			echo '	<input type="hidden" name="bo_mobile_gallery_height" value="'.$board['bo_mobile_gallery_height'].'">';
		} else {
			echo '	<div class="form-list">';
			echo '		<div class="form-label"><label>썸네일 사이즈(비율)</label></div>';
			echo '		<div class="formCon flex flex-middle gap30">';
			if(!G5_IS_MOBILE) {
				echo '		<div class="inline-flex flex-middle gap10">';
				echo '			<input type="text" name="bo_gallery_width" value="'.$board['bo_gallery_width'].'" id="bo_gallery_width" required size="4" data-label="가로" data-label-inline="PX">';
				echo '			<input type="text" name="bo_gallery_height" value="'.$board['bo_gallery_height'].'" id="bo_gallery_height" required size="4" data-label="세로" data-label-inline="PX">';
				echo '		</div>';
			} else {
				echo '		<input type="hidden" name="bo_gallery_width" value="'.$board['bo_gallery_width'].'">';
				echo '		<input type="hidden" name="bo_gallery_height" value="'.$board['bo_gallery_height'].'">';
			}
			echo '			<div class="inline-flex flex-middle gap10">';
			echo '				<input type="text" name="bo_mobile_gallery_width" value="'.$board['bo_mobile_gallery_width'].'" id="bo_mobile_gallery_width" required size="4" data-label="모바일 가로" data-label-inline="PX">';
			echo '				<input type="text" name="bo_mobile_gallery_height" value="'.$board['bo_mobile_gallery_height'].'" id="bo_mobile_gallery_height" required size="4" data-label="모바일 세로" data-label-inline="PX">';
			echo '			</div>';
			echo '		</div>';
			echo '	</div>';
		}
		
		echo '		<div class="form-list">';
		echo '			<div class="form-label"><label>리스트 간격</label></div>';
		echo '			<div class="formCon flex flex-middle gap25">';
		if(!G5_IS_MOBILE) {
			echo '			<input type="text" name="bo_gall_itemspace" value="'.get_text($board['bo_gall_itemspace']).'" id="bo_gall_itemspace" class="frm_input" size="4" maxlength="10" data-label-inline="PX">';
		} else {
			echo '			<input type="hidden" name="bo_gall_itemspace" value="'.get_text($board['bo_gall_itemspace']).'">';
		}
		echo '				<input type="text" name="bo_gall_mobile_itemspace" value="'.get_text($board['bo_gall_mobile_itemspace']).'" id="bo_gall_mobile_itemspace" size="4" maxlength="10" data-label="모바일 간격" data-label-inline="PX">';
		echo '			</div>';
		echo '		</div>';
		echo '	</div>';
		echo '</div>';
	} else {
		echo '<input type="hidden" name="bo_skin" value="'.$board['bo_skin'].'">';
		echo '<input type="hidden" name="bo_gallery_cols" value="'.$board['bo_gallery_cols'].'">';
		echo '<input type="hidden" name="bo_gall_mobile_cols" value="'.$board['bo_gall_mobile_cols'].'">';
		echo '<input type="hidden" name="bo_max_screen" value="'.$board['bo_max_screen'].'">';
		echo '<input type="hidden" name="bo_gallery_width" value="'.$board['bo_gallery_width'].'">';
		echo '<input type="hidden" name="bo_gallery_height" value="'.$board['bo_gallery_height'].'">';
		echo '<input type="hidden" name="bo_mobile_gallery_width" value="'.$board['bo_mobile_gallery_width'].'">';
		echo '<input type="hidden" name="bo_mobile_gallery_height" value="'.$board['bo_mobile_gallery_height'].'">';
		echo '<input type="hidden" name="bo_gall_itemspace" value="'.$board['bo_gall_itemspace'].'">';
		echo '<input type="hidden" name="bo_gall_mobile_itemspace" value="'.$board['bo_gall_mobile_itemspace'].'">';				
	}
	echo '<input type="hidden" name="bo_upload_count" value="'.$board['bo_upload_count'].'">';	
	?>
</section>	

<?php if(file_exists($board_pcskin_path.'/_skin.option.php')) include_once($board_pcskin_path.'/_skin.option.php'); ?>

<?php if(file_exists($board_pcskin_path.'/_skin.option.php')) {
	/*echo '<div id="form_bo_option" class="formOption">';
	echo '<div class="inner">';
	echo '<div class="inp-tag-wrap">';
	echo '<label class="input-label " data-tip="bo_option"><i class="my-icon-pc"></i></label>';
	echo '<input type="text" name="bo_option" value="'.get_text($board['bo_option']).'" id="bo_option" class="frm_input span inputTag" placeholder="스킨 옵션">';
	echo '</div>';
	//$option_open = $board['bo_option'] ? true : false;
	//echo get_skinOption('skin', '', 'bo_option', 'bo_mobile_option', $option_open, $config['cf_theme']);
	echo '<div class="inp-tag-wrap blueTag mt5">';
	echo '<label class="input-label " data-tip="bo_mobile_option"><i class="my-icon-mobile"></i></label>';
	echo '<input type="text" name="bo_mobile_option" value="'.$board['bo_mobile_option'].'" id="bo_mobile_option" class="frm_input span inputTag" size="200" placeholder="스킨 옵션(모바일)">';
	echo '</div>';
	echo '</div>';
	echo '<div id="skinOptionAfterCover"></div>';
	echo '</div>';*/
} ?>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
matchOnOff_checkbox('#bo_layer_popup', '#viewpop_option');

function bf_form_submit(f){
	<?=get_editor_js("bo_content_head")?>
    <?=get_editor_js("bo_mobile_content_head")?>
	<?=get_editor_js("bo_content_tail")?>
    <?=get_editor_js("bo_mobile_content_tail")?>
    return true;
}
</script>
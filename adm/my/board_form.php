<?php
if (!defined('_GNUBOARD_')) exit;

$board_default = array(
'bo_mobile_subject'=>'',
'bo_device'=>'',
'bo_use_category'=>0,
'bo_category_list'=>'',
'bo_admin'=>'',
'bo_list_level'=>0,
'bo_read_level'=>0,
'bo_write_level'=>0,
'bo_reply_level'=>0,
'bo_comment_level'=>0,
'bo_link_level'=>0,
'bo_upload_level'=>0,
'bo_download_level'=>0,
'bo_html_level'=>0,
'bo_use_sideview'=>0,
'bo_select_editor'=>'',
'bo_use_rss_view'=>0,
'bo_use_good'=>0,
'bo_use_nogood'=>0,
'bo_use_name'=>0,
'bo_use_signature'=>0,
'bo_use_ip_view'=>0,
'bo_use_list_content'=>0,
'bo_use_list_file'=>0,
'bo_use_list_view'=>0,
'bo_use_email'=>0,
'bo_use_file_content'=>0,
'bo_use_cert'=>'',
'bo_write_min'=>0,
'bo_write_max'=>0,
'bo_comment_min'=>0,
'bo_comment_max'=>0,
'bo_use_sns'=>0,
'bo_order'=>0,
'bo_use_captcha'=>0,
'bo_content_head'=>'',
'bo_content_tail'=>'',
'bo_mobile_content_head'=>'',
'bo_mobile_content_tail'=>'',
'bo_insert_content'=>'',
'bo_sort_field'=>'',
);

for($i=0;$i<=10;$i++){
    $board_default['bo_'.$i.'_subj'] = '';
    $board_default['bo_'.$i] = '';
}

$board = array_merge($board_default, $board);

run_event('adm_board_form_before', $board, $w);

$required = "";
$readonly = "";
$sound_only = "";
$required_valid = "";
if ($w == '') {

    $html_title .= ' 생성';
    $required = 'required';
    $required_valid = 'alnum_';
    $sound_only = '<strong class="sound_only">필수</strong>';
    $board['bo_count_delete'] = 1;
    $board['bo_count_modify'] = 1;
    $board['bo_read_point'] = $config['cf_read_point'];
    $board['bo_write_point'] = $config['cf_write_point'];
    $board['bo_comment_point'] = $config['cf_comment_point'];
    $board['bo_download_point'] = $config['cf_download_point'];
	
	$board['bo_skin'] = 'basic';
	$board['bo_mobile_skin'] = '';
	$board['gr_id'] = $gr_id;
	$board['bo_use_secret'] = 0;
	$board['bo_use_html_tag'] = 'html2';
	$board['bo_reply_order'] = 1; //댓글정렬
	$board['bo_reply_level'] = 0; //댓글정렬
	$board['bo_use_search'] = 1;
	$board['bo_image_width'] = 0; //인태 - 상세페이지 이미지는 원본출력하기 위해 0으로 수정
	$board['bo_include_head'] = '_head.php';
	$board['bo_include_tail'] = '_tail.php';
	$board['bo_new'] = 24;
	$board['bo_hot'] = 500;
	if(file_exists(G5_THEME_PATH.'/adm/_theme_board_config.php')) {
		include_once(G5_THEME_PATH.'/adm/_theme_board_config.php');
	}

}

if ($is_admin != 'super') {
    $group = get_group($board['gr_id']);
    $is_admin = is_admin($member['mb_id']);
}

$bo_background = explode("|",$board['bo_background']);

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_bo_basic">기본 설정</a></li>
    <li><a href="#anc_bo_auth">권한 설정</a></li>
	<li><a href="#anc_bo_cate">카테고리</a></li>
	<li><a href="#anc_bo_listpage">목록페이지 설정</a></li>
	<li><a href="#anc_bo_viewpage">상세페이지 설정</a></li>
	<li><a href="#anc_bo_writepage">쓰기페이지 설정</a></li>
    <li><a href="#anc_bo_function">고급설정</a></li>
	'.($config['cf_use_point']?'<li><a href="#anc_bo_point">고급설정</a></li>':'').'
</ul>';


$g5['title'] = $html_title;
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<form name="fboardform" id="fboardform" action="<?=G5_ADMIN_URL?>/my/board_form_update.php" onsubmit="return fboardform_submit(this)" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">

<section id="anc_bo_basic" class="mybox blue">
    <h2 class="h2_frm">게시판 기본 설정</h2>

    <div class="formContainer label180">
        <div class="form-list">
            <div class="form-label"><label for="bo_table">TABLE<?php echo $sound_only ?></label></div>
            <div class="formCon">
                <input type="text" name="bo_table" value="<?php echo $board['bo_table'] ?>" id="bo_table" <?php echo $required ?> <?php echo $readonly ?> class="frm_input <?php echo $readonly ?> <?php echo $required ?> <?php echo $required_valid ?>" maxlength="20">
                <?php if ($w == '') { ?>
                    영문자, 숫자, _ 만 가능 (공백없이 20자 이내)
                <?php } else { ?>
                    <a href="<?php echo get_pretty_url($board['bo_table']) ?>" class="btn_basic">게시판 바로가기</a>
                    <a href="./board_list.php?<?php echo $qstr;?>" class="btn_basic">목록으로</a>
                <?php } ?>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="gr_id">그룹<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <?php echo get_group_select('gr_id', $board['gr_id'], 'required'); ?>
                <?php if ($w=='u') { ?><a href="javascript:document.location.href='./board_list.php?sfl=a.gr_id&stx='+document.fboardform.gr_id.value;" class="btn_basic">동일그룹 게시판목록</a><?php } ?>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_subject">게시판 제목<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
				<span class="relative">
					<label class="checkbox-hide"><input type="checkbox" name="bo_subject_hide" value="1" <?=$board['bo_subject_hide']?'checked':'';?>></label>
					<input type="text" name="bo_subject" value="<?=get_text($board['bo_subject'])?>" id="bo_subject" required class="required frm_input" size="80" maxlength="120">
				</span>
				<input type="text" name="bo_mobile_subject" value="<?php echo get_text($board['bo_mobile_subject']) ?>" id="bo_mobile_subject" class="frm_input" size="50" maxlength="120" data-class="ml20" data-label="모바일 전용 제목">
            </div>
        </div>

		<div class="form-list">
            <div class="form-label"><label for="bo_skin">스킨 선택<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
				<?=get_skin_select_my('board', 'bo_skin', 'bo_skin', $board['bo_skin'], 'required class="selectpicker select-img span270 label-OnOff mr20" data-label="스킨" data-myTip="bo_skin" ', true)?>
				<?=get_mobile_skin_select_my('board', 'bo_mobile_skin', 'bo_mobile_skin', $board['bo_mobile_skin'], 'class="selectpicker label-OnOff" data-label="모바일 스킨" data-myTip="bo_mobile_skin" ')?>
				<input type="hidden" name="bo_skin_type" value="<?=$board['bo_skin_type']?>">
            </div>
        </div>		
		
		<div class="form-list">
            <div class="form-label"><label for="bo_table_width">게시판 폭<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_table_width" value="<?=$board['bo_table_width']?>" id="bo_table_width" required class="percent span65" size="4" data-label="max" data-label-inline="px">	
				<input type="text" name="bo_min_width" value="<?=$board['bo_min_width']?>" id="bo_min_width" class="percent span65" size="4" data-label="min" data-class="ml10" data-label-inline="px">
				<input type="text" name="bo_view_width" value="<?=$board['bo_view_width']?>" id="bo_view_width" class="frm_input span65" size="4" data-label="상세페이지" data-class="ml20" data-label-inline="px">			
            </div>
			<div class="grpset">
                <label><input type="checkbox" name="chk_grp_table_width" value="1" id="chk_grp_table_width">그룹적용</label>
                <label><input type="checkbox" name="chk_all_table_width" value="1" id="chk_all_table_width">전체적용</label>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label>게시판 여백</label></div>
            <div class="formCon">
                <input type="text" name="bo_padding_top" value="<?=$board['bo_padding_top']?>" id="bo_padding_top" class="frm_input" size="4" data-label="상단여백" data-label-inline="px">
				<input type="text" name="bo_padding_bottom" value="<?=$board['bo_padding_bottom']?>" id="bo_padding_bottom" class="required frm_input" size="4" data-label="하단여백" data-label-inline="px" data-class="ml15">
				<input type="text" name="bo_padding_left_right" value="<?=$board['bo_padding_left_right']?>" id="bo_padding_left_right" class="frm_input" size="4" data-label="좌우여백" data-label-inline="px" data-class="ml15">
				<input type="text" name="bo_mobile_padding" value="<?=$board['bo_mobile_padding']?>" id="bo_mobile_padding" class="frm_input" size="4" data-label="모바일 여백" data-label-inline="px" data-class="ml15">
            </div>
			<div class="grpset">
                <label><input type="checkbox" name="chk_grp_padding" value="1" id="chk_grp_padding">그룹적용</label>
                <label><input type="checkbox" name="chk_all_padding" value="1" id="chk_all_padding">전체적용</label>
            </div>
        </div>

		<div class="form-list">
            <div class="form-label"><label for="bo_background">게시판 배경</label></div>
            <div class="formCon">
				<input type="text" name="bo_background[0]" value="<?=$bo_background[0]?>" class="colorpicker" id="bo_background" data-format="rgb" data-opacity="1" data-swatches="rgba(230, 230, 230, 1)|rgba(240, 240, 240, 1)|rgba(250, 250, 250, 1)" placeholder="#">
				<input type="text" name="bo_background[1]" value="<?=$bo_background[1]?>" class="colorpicker" id="bo_content_color" data-format="rgb" data-opacity="1" data-swatches="rgba(230, 230, 230, 1)|rgba(240, 240, 240, 1)|rgba(250, 250, 250, 1)" placeholder="#" data-class="ml10" data-label="텍스트 색상">
            </div>
			<div class="grpset">
                <label><input type="checkbox" name="chk_grp_background" value="1" id="chk_grp_background">그룹적용</label>
                <label><input type="checkbox" name="chk_all_background" value="1" id="chk_all_background">전체적용</label>
            </div>
        </div>

		<div class="form-list">
			<div class="form-label"><label class="color-blue">기능 사용 여부</label></div>
			<div class="formCon flex gap20">
				<input type="checkbox" name="bo_hit" value="1" <?=$board['bo_hit']?'checked':'';?> id="bo_hit" data-label="조회수 사용">				
				<input type="checkbox" name="bo_use_good" value="1" <?=$board['bo_use_good']?'checked':'';?> id="bo_use_good" data-label="좋아요 사용">
				<input type="checkbox" name="bo_use_good_guest" value="1" <?=$board['bo_use_good_guest']?'checked':'';?> id="bo_use_good_guest" data-class="bo_use_good_guest" data-label="비회원도 추천 가능">
				<script>matchOnOff_checkbox('#bo_use_good', '.bo_use_good_guest');</script>
				<input type="checkbox" name="bo_use_search" value="1" id="bo_use_search" <?=$board['bo_use_search']?'checked':'';?> data-label="사이트 전체 검색시 검색허용" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
            <div class="form-label"><label for="bo_btn_write_name">글쓰기 버튼명 바꾸기</label></div>
            <div class="formCon">
                <input type="text" name="bo_btn_write_name" value="<?=get_text($board['bo_btn_write_name'])?>" id="bo_btn_write_name" class="frm_input span160" placeholder="버튼명">
            </div>
        </div>
    </div>
</section>

<section id="anc_bo_auth" class="mybox blue">
    <h2 class="mybox-title">게시판 권한 설정</h2>
    <div class="formContainer label180">
       <div class="form-list">
            <div class="form-label"><label for="bo_admin">게시판 관리자</label></div>
            <div class="formCon">
                <input type="text" name="bo_admin" value="<?php echo $board['bo_admin'] ?>" id="bo_admin" class="frm_input w-full" maxlength="20">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_admin" value="1" id="chk_grp_admin" data-label="그룹적용">
                <input type="checkbox" name="chk_all_admin" value="1" id="chk_all_admin" data-label="전체적용">
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_list_level">목록보기 권한</label></div>
            <div class="formCon">                
                <?=get_member_level_select('bo_list_level', 1, 10, $board['bo_list_level'])?>
				<?=my_help('권한 1은 비회원, 2 이상 회원입니다. 권한은 10 이 가장 높습니다.')?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_list_level" value="1" id="chk_grp_list_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_list_level" value="1" id="chk_all_list_level">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_read_level">글읽기 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_read_level', 1, 10, $board['bo_read_level'])?>
				<?=get_member_level_select_my('bo_comment_level', 0, 10, $board['bo_comment_level'], 'class="selectpicker" data-label="댓글쓰기 권한" data-class="ml20"')?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_read_level" value="1" id="chk_grp_read_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_read_level" value="1" id="chk_all_read_level">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_write_level">글등록 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_write_level', 1, 10, $board['bo_write_level'])?>
				<input type="checkbox" name="bo_use_mobile_write" value="1" <?=$board['bo_use_mobile_write']?'checked':''?> id="bo_use_mobile_write" data-class="ml20" data-label="모바일에서 글쓰기 허용">
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_write_level" value="1" id="chk_grp_write_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_write_level" value="1" id="chk_all_write_level">전체적용</label>
            </div>
        </div>	
    </div>
</section>

<section id="anc_bo_cate" class="mybox blue">
    <h2 class="mybox-title">게시판 카테고리</h2>
    <div class="formContainer label180">
		 <div class="form-list">
            <div class="form-label flex-top">
				<input type="text" name="bo_category_label" value="<?=$board['bo_category_label']?>" id="bo_category_label" class="frm_input span" style="font-weight:bold;" size="15" placeholder="카테고리">
			</div>
            <div class="formCon">                
                <input type="text" name="bo_category_list" value="<?=get_text($board['bo_category_list'])?>" id="bo_category_list" class="frm_input span900">
                <input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" <?=$board['bo_use_category']?'checked':''?> data-label="사용" data-class="ml15">
				<input type="checkbox" name="bo_cate_all_hidden" value="1"<?=$board['bo_cate_all_hidden']?' checked':''?> data-label="전체보기 사용안함" data-class="ml15">
				<?=my_help('분류와 분류 사이는 | 로 구분하세요. (예: 질문|답변) 첫자로 #은 입력하지 마세요. (예: #질문|#답변 [X]) - 분류명에 일부 특수문자 ()/ 는 사용할수 없습니다.', true)?>
            </div>
        </div>
		<div class="form-list">
			<div class="form-label"><label>카테고리 스킨</label></div>
			<div class="formCon">				
				<?=get_skin_select_my('_boCategory', 'bo_cate_skin', 'bo_cate_skin', $board['bo_cate_skin'], 'class="selectpicker select-img span350 label-OnOff mr20" data-label="카테고리 스킨" data-myTip="bo_cate_skin"', true)?>
				<input type="text" name="bo_cate_color" value="<?=$board['bo_cate_color']?>" class="colorpicker" id="bo_cate_color" data-label="카테고리 메뉴 색상" data-class="ml20" data-format="rgb" data-opacity="1" data-swatches="rgba(230, 230, 230, 1)|rgba(240, 240, 240, 1)|rgba(250, 250, 250, 1)" placeholder="#">
				<?=my_help("일부 게시판은 적용되지 않습니다.", true)?>
			</div>
		</div>
		<div class="form-list">
			<div class="formCon flex">
				<input type="text" name="bo_tag_list" value="<?=get_text($board['bo_tag_list'])?>" id="bo_tag_list" class="span" data-class="flex1" data-label="#태그" placeholder="태그와 태그 사이는 | 로 구분하세요.">
				<input type="checkbox" name="bo_use_tag" value="1" id="bo_use_tag" <?=$board['bo_use_tag']?'checked':''?> data-label="사용">
			</div>
		</div>
    </div>
</section>


<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
목록페이지
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="anc_bo_listpage" class="mybox blue-bg <?=$is_admin != 'super'?'hide':''?>">
    <h2 class="mybox-title">목록페이지 설정</h2>
    <div class="formContainer label180">
		<div class="form-list">
			<div class="form-label"><label>기본항목 (목록)</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_list_writer" value="1" <?=$board['bo_list_writer']?'checked':'';?> id="bo_writer" data-label="작성자 보이기">
				<input type="checkbox" name="bo_list_date" value="1" <?=$board['bo_list_date']?'checked':'';?> id="bo_date" data-label="날짜 보이기" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>게시판 검색 사용</label></div>
			<div class="formCon" style="vertical-align:top;">
				<?=get_skin_select_my('_boSearch', 'bo_search_skin', 'bo_search_skin', $board['bo_search_skin'], 'class="selectpicker select-img span400 label-OnOff mr20" data-label="검색바 스킨"', true)?>
				<input type="text" name="bo_search_color" value="<?=$board['bo_search_color']?>" class="colorpicker" id="bo_search_color" data-label="검색바 색상" data-format="rgb" data-opacity="1" data-swatches="rgba(230, 230, 230, 1)|rgba(240, 240, 240, 1)|rgba(250, 250, 250, 1)" placeholder="#" data-class="ml20">
				<input type="hidden" name="bo_search_sfl" value="<?=$board['bo_search_sfl']?>"><!-- 범위설정은 프론트에서 -->
			</div>
		</div>
		<div class="form-list">
            <div class="form-label"><label for="bo_subject_len">제목 길이 자르기<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">				
                <input type="text" name="bo_subject_len" value="<?=$board['bo_subject_len']?>" id="bo_subject_len" required class="required" size="4" data-label-inline="글자">
				<input type="text" name="bo_mobile_subject_len" value="<?=$board['bo_mobile_subject_len']?>" id="bo_mobile_subject_len" required class="required frm_input" size="4" data-label="모바일 제목길이" data-label-inline="글자" data-class="ml20"></label>
				<?=my_help('목록에서의 제목 글자수. 잘리는 글은 … 로 표시')?>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_page_rows">페이지당 목록 수<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_page_rows" value="<?=$board['bo_page_rows']?>" id="bo_page_rows" required class="required frm_input" size="4" data-label-inline="개">
				<input type="text" name="bo_mobile_page_rows" value="<?=$board['bo_mobile_page_rows']?>" id="bo_mobile_page_rows" required class="required frm_input" size="4" data-label="모바일" data-class="ml20" data-label-inline="개">
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label for="bo_sort_field">리스트 정렬</label></div>
            <div class="formCon">                
                <select id="bo_sort_field" name="bo_sort_field">
					<?php foreach( get_board_sort_fields($board) as $v ) {                        
						$option_value = $order_by_str = $v[0];
						if( $v[0] === 'wr_num, wr_reply' ){
							$selected = (! $board['bo_sort_field']) ? 'selected="selected"' : '';
							$option_value = '';
						} else {
							$selected = ($board['bo_sort_field'] === $v[0]) ? 'selected="selected"' : '';
						}                        
						if( $order_by_str !== 'wr_num, wr_reply' ){
							$tmp = explode(',', $v[0]);
							$order_by_str = $tmp[0];
						}
						echo '<option value="'.$option_value.'" '.$selected.' >'.$order_by_str.' : '.$v[1].'</option>';
                    } ?>
                </select>
				<?=my_help('리스트에서 기본으로 정렬에 사용할 필드를 선택합니다. "기본"으로 사용하지 않으시는 경우 속도가 느려질 수 있습니다.')?>
            </div>
		</div>
	</div>
	
	<script>//matchOnOff('#bo_skin', '<?=$skin_gall?>', '#gall-option');</script><!-- //$skin_gall -> extend/intae.extend.php -->
	<div id="gall-option">		
		<div class="formContainer label180 mt30">
			<h2 class="mybox-title-sub">갤러리 관련</h2>
			
			<div class="form-list">
				<div class="form-label"><label for="bo_gallery_cols">리스트 가로 수<strong class="sound_only">필수</strong></label></div>
				<div class="formCon">					
					<?=get_member_level_select('bo_gallery_cols', 1, 10, $board['bo_gallery_cols'])?>
					<?=get_member_level_select('bo_gall_mobile_cols', 1, 10, $board['bo_gall_mobile_cols'], 'class="selectpicker" data-class="ml10" data-label="모바일"')?>
					<?=my_help('갤러리 형식의 게시판 목록에서 이미지를 한줄에 몇장씩 보여 줄 것인지를 설정하는 값')?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label for="bo_max_screen">반응형 리스트 가로 수</label></div>
				<div class="formCon">					
					<input type="text" name="bo_max_screen" value="<?=$board['bo_max_screen']?>" id="bo_max_screen" class="span200" placeholder="1400|1100" data-label="@media screen">
					<?=my_help('창사이즈가 입력값보다 작아질 경우 리스트 가로수가 1씩 감소합니다. ex) 1400|1100')?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label for="bo_gallery_width">썸네일 사이즈(비율)<strong class="sound_only">필수</strong></label></div>
				<div class="formCon">					
					<input type="text" name="bo_gallery_width" value="<?=$board['bo_gallery_width']?>" id="bo_gallery_width" required class="required frm_input" size="4" data-label="가로" data-label-inline="PX">
					<input type="text" name="bo_gallery_height" value="<?=$board['bo_gallery_height']?>" id="bo_gallery_height" required class="required frm_input" size="4" data-label="세로" data-label-inline="PX" data-class="ml5">
					<input type="text" name="bo_mobile_gallery_width" value="<?=$board['bo_mobile_gallery_width']?>" id="bo_mobile_gallery_width" required class="required frm_input" size="4" data-label-inline="PX" data-label="모바일 가로"data-class="ml20">
					<input type="text" name="bo_mobile_gallery_height" value="<?=$board['bo_mobile_gallery_height']?>" id="bo_mobile_gallery_height" required class="required frm_input" size="4" data-label-inline="PX" data-label="모바일 세로"data-class="ml5">
					<?=my_help('갤러리 형식의 게시판 목록에서 썸네일 이미지의 사이즈를 설정하는 값', true)?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label for="bo_gall_itemspace">리스트 간격</label></div>
				<div class="formCon">					
					<input type="text" name="bo_gall_itemspace" value="<?=get_text($board['bo_gall_itemspace'])?>" id="bo_gall_itemspace" class="frm_input" size="4" maxlength="10" data-label="이미지 간격" data-label-inline="PX">
					<input type="text" name="bo_gall_mobile_itemspace" value="<?=get_text($board['bo_gall_mobile_itemspace'])?>" id="bo_gall_mobile_itemspace" class="frm_input" size="4" maxlength="10" data-label="모바일 간격" data-label-inline="PX" data-class="ml10">
					<?=my_help('갤러리 형식의 게시판 목록에서 이미지의 간격을 설정하는 값')?>
				</div>
			</div>
		</div>
		<div class="tright mt10"><button type="button" class="get_theme_galc btn btn_02" >테마 이미지설정 가져오기</button></div>
	</div>
</section>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
상세페이지
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="anc_bo_viewpage" class="mybox blue-bg <?=$is_admin != 'super'?'hide':''?>">
    <h2 class="mybox-title">상세페이지 설정</h2>
    <div class="formContainer label180">
		<div class="form-list">
			<div class="form-label"><label>기본항목 (상세)</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_view_thumb" value="1" <?=$board['bo_view_thumb']?'checked':''?> id="bo_view_thumb" data-label="첨부된 이미지 출력">
				<input type="checkbox" name="bo_view_writer" value="1" <?=$board['bo_view_writer']?'checked':'';?> id="bo_view_writer" data-label="작성자 출력" data-class="ml20">
				<input type="checkbox" name="bo_view_date" value="1" <?=$board['bo_view_date']?'checked':'';?> id="bo_view_date" data-label="날짜 출력" data-class="ml20">
				<input type="checkbox" name="bo_use_list_view" value="1" id="bo_use_list_view" <?=$board['bo_use_list_view']?'checked':'';?> data-label="상세페이지에서 목록사용" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>팝업설정 (상세)</label></div>
			<div class="formCon">				
				<input type="checkbox" name="bo_layer_popup" value="1" <?=$board['bo_layer_popup']?'checked':''?> id="bo_layer_popup" class="myTip" data-label="팝업으로 상세페이지 열기">
				<input type="text" name="bo_popup_padding" value="<?=$board['bo_popup_padding']?>" id="bo_popup_padding" class="myTip span60" size="6" placeholder="0" data-label="팝업 여백" data-class="ml20" data-label-inline="PX">
				<input type="text" name="bo_popup_min_size" value="<?=$board['bo_popup_min_size']?>" id="bo_popup_min_size" class="span60 percent" size="6" data-percent-max="100" data-label="팝업 최소사이즈" data-class="ml10" data-label-inline="PX">
				<input type="text" name="bo_popup_max_size" value="<?=$board['bo_popup_max_size']?>" id="bo_popup_max_size" class="span60 percent" size="6" data-label="팝업 최대사이즈" data-class="ml10" data-label-inline="PX">
			</div>
		</div>
		<div class="form-list">
            <div class="form-label"><label for="bo_reply_order">댓글 정렬</label></div>
            <div class="formCon">
                <select id="bo_reply_order" name="bo_reply_order">
                    <option value="1"<?=get_selected($board['bo_reply_order'], 1, true)?>>나중에 쓴 답변 아래로 달기 (기본)
                    <option value="0"<?=get_selected($board['bo_reply_order'], 0)?>>나중에 쓴 답변 위로 달기
                </select>
            </div>
        </div>
    </div>
</section>

<!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
쓰기페이지
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
<section id="anc_bo_writepage" class="mybox blue-bg <?=$is_admin != 'super'?'hide':''?>">
    <h2 class="mybox-title">쓰기페이지 설정</h2>
    <div class="formContainer label180">
		<div class="form-list">
            <div class="form-label"><label for="bo_use_dhtml_editor" >DHTML 에디터 사용</label></div>
            <div class="formCon">
                <?=help('글작성시 내용을 DHTML 에디터 기능으로 사용할 것인지 설정합니다. 스킨에 따라 적용되지 않을 수 있습니다.')?>
                <!--<input type="checkbox" name="bo_use_dhtml_editor" value="1" <?=$board['bo_use_dhtml_editor']?'checked':'';?> id="bo_use_dhtml_editor" data-label="사용">-->
				<select name="bo_use_dhtml_editor" id="bo_use_dhtml_editor" class="selectpicker" data-label="에디터 사용">
					<?=option_selected('', $board['bo_use_dhtml_editor'], "사용안함")?>
					<?=option_selected('1', $board['bo_use_dhtml_editor'], "PC만 사용")?>
					<?=option_selected('2', $board['bo_use_dhtml_editor'], "PC, 모바일 둘다 사용")?>
				</select>
				<input type="text" name="bo_editor_height" value="<?=$board['bo_editor_height']?>" id="bo_editor_height" class="frm_input" size="6" data-label="에디터 기본 높이" data-label-inline="PX" data-class="ml20">
				<label class="ml25 mr5 bold ">에디터 미적용시</label>
				<select id="bo_use_html_tag" name="bo_use_html_tag">
					<?=option_selected('html2', $board['bo_use_html_tag'], "자동 줄바꿈, html태그 둘다 적용")?>
					<?=option_selected('html', $board['bo_use_html_tag'], "자동 줄바꿈 적용")?>
					<?=option_selected('html1', $board['bo_use_html_tag'], "html태그 적용")?>
					<?=option_selected('', $board['bo_use_html_tag'], "내용쓰기 없음")?>
				</select>
                <select name="bo_select_editor" id="bo_select_editor" class="selectpicker" data-label="에디터 선택" data-class="ml20">
                <?php
                $arr = get_skin_dir('', G5_EDITOR_PATH);
                for ($i=0; $i<count($arr); $i++) {
                    if ($i == 0) echo "<option value=\"\">기본환경설정의 에디터 사용</option>";
                    echo "<option value=\"".$arr[$i]."\"".get_selected($board['bo_select_editor'], $arr[$i]).">".$arr[$i]."</option>\n";
                }
                ?>
                </select>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label>첨부파일</label></div>
            <div class="formCon">				
				<input type="text" name="bo_upload_count" value="<?=$board['bo_upload_count']?>" id="bo_upload_count" required class="required span50" size="4" data-label="첨부파일 개수" data-label-inline="개">
				<?php $bo_upload_size = $board['bo_upload_size'] ? $board['bo_upload_size'] / 1048576 : $bo_upload_size;?>
				<input type="text" name="bo_upload_size" value="<?=$bo_upload_size?>" id="bo_upload_size" required class="required span50"  size="3" data-label="첨부 제한용량" data-label-inline="MB" data-class="ml10">
				<?//=my_help('최대 '.ini_get("upload_max_filesize").' 이하 업로드 가능, 1 MB = 1,048,576 bytes')?>
				<input type="checkbox" name="bo_use_file_content" value="1" id="bo_use_file_content" <?=$board['bo_use_file_content']?'checked':'';?> data-label="파일설명 쓰기" data-class="ml20">
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label for="bo_use_secret">비밀글 사용</label></div>
            <div class="formCon">               
                <label class="mr10">
				<select id="bo_use_secret" name="bo_use_secret">
                    <?=option_selected(0, $board['bo_use_secret'], "사용하지 않음")?>
                    <?=option_selected(1, $board['bo_use_secret'], "체크박스")?>
                    <?=option_selected(2, $board['bo_use_secret'], "무조건")?>
                </select>
				</label>
				 <?=my_help('스킨에 따라 적용되지 않을 수 있습니다.')?>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label for="bo_use_captcha">캡챠 사용</label></div>
            <div class="formCon">
                <select id="bo_use_captcha" name="bo_use_captcha" class="selectpicker" data-label="글쓰기 자동등록방지">
					<?//=option_selected(0, $board['bo_use_captcha'], "사용 안함");?>
					<?=option_selected(0, $board['bo_use_captcha'], "비회원 사용");?>
					<?=option_selected(1, $board['bo_use_captcha'], "비회원 + 회원 사용");?>
				</select>
            </div>
        </div>		
    </div>
</section>




<section id="anc_bo_function" class="mybox blue <?=$is_admin!='super'?'hide':''?>">
    <h2 class="mybox-title">고급 설정</h2>
    <div class="formContainer label180">
		<?php
		$_filemake_type = 'board';
		$_filemake_dir = $bo_table;
		include_once(G5_BBS_PATH.'/my/filemake_script.php');

		$inc_boTop = G5_HTML_PATH.'/'.$bo_table.'/bo_top.php';
		$inc_boBottom = G5_HTML_PATH.'/'.$bo_table.'/bo_bottom.php';
		$inc_boTop_class = file_exists($inc_boTop) ? 'active' : 'bin';
		$inc_boBottom_class = file_exists($inc_boBottom) ? 'active' : 'bin';
		$includeTop = $is_boTop ? 'active' : '';
		$includeBottom = $is_boBottom ? 'active' : '';
		$tableName = $bo_table ? $bo_table : '테이블명';
		?>
		<div class="form-list">			
            <div class="form-label"><label>게시판 인크루드</label></div>
            <div class="formCon">
				<div class="layout-box column gap5 w-75">
					<div class="itemContainer">
						<span class="item h-20 fileMake <?=$inc_boTop_class?>" data-filepath="<?=$inc_boTop?>">상단</span>
						<span class="fileDelete" data-filepath="<?=$inc_boTop?>">삭제</span>
						<p class="text">html/<?=$tableName?>/<span>bo_top.php</span>	</p>
					</div>
					<span class="item h-20">게시판</span>
					<div class="itemContainer">
						<span class="item h-20 fileMake <?=$inc_boBottom_class?>" data-filepath="<?=$inc_boBottom?>">하단</span>
						<span class="fileDelete" data-filepath="<?=$inc_boBottom?>">삭제</span>
						<p class="text">html/<?=$tableName?>/<span>bo_bottom.php</span></p>
					</div>
				</div>
            </div>
        </div>
		<div class="form-list">
			<div class="form-label"><label>기능 사용 여부</label></div>
			<div class="formCon">				
				<input type="checkbox" name="bo_use_sideview" value="1" id="bo_use_sideview" <?=$board['bo_use_sideview']?'checked':'';?> data-label="글쓴이 사이드뷰 사용">
				<input type="checkbox" name="bo_use_name" value="1" id="bo_use_name" <?=$board['bo_use_name']?'checked':'';?> data-label="실명(이름) 사용" data-class="ml20">	
				<div class="mt15">
					<select id="bo_use_email" name="bo_use_email" class="selectpicker" <?=$board['bo_use_email']?'data-style="selectColor-green"':''?>>
						<?=option_selected(0, $board['bo_use_email'], "메일발송 사용안함");?>
						<?=option_selected(1, $board['bo_use_email'], "메일발송 (제목만 발송)");?>
						<?=option_selected(2, $board['bo_use_email'], "메일발송 (모든내용 발송)");?>
					</select>			
					<?php
					$mail_form_url = file_exists($board_pcskin_path.'/write_update_mail.php') && $board['bo_use_email'] != '1' ? $board_pcskin_url.'/write_update_mail.php?view=mail&emailOption='.$board['bo_use_email'] : G5_BBS_URL.'/write_update_mail.php?view=mail&emailOption='.$board['bo_use_email'];
					echo '<a href="'.$mail_form_url.'" class="popWin btn_admin ml5" data-width="1200" data-height="'.($board['bo_use_email']=='1'?'400':'800').'">메일폼 미리보기</a>';
					?>
				</div>
			</div>
		</div>	
		<div class="form-list">
            <div class="form-label"><label for="bo_reply_level">글답변 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select_my('bo_reply_level', 0, 10, $board['bo_reply_level'])?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_reply_level" value="1" id="chk_grp_reply_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_reply_level" value="1" id="chk_all_reply_level">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_link_level">링크 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_link_level', 1, 10, $board['bo_link_level'])?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_link_level" value="1" id="chk_grp_link_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_link_level" value="1" id="chk_all_link_level">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_upload_level">업로드 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_upload_level', 1, 10, $board['bo_upload_level'])?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_upload_level" value="1" id="chk_grp_upload_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_upload_level" value="1" id="chk_all_upload_level">전체적용</label>
            </div>
        </div>
		
        <div class="form-list">
            <div class="form-label"><label for="bo_download_level">다운로드 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_download_level', 1, 10, $board['bo_download_level'])?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_download_level" value="1" id="chk_grp_download_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_download_level" value="1" id="chk_all_download_level">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_html_level">HTML 쓰기 권한</label></div>
            <div class="formCon">
                <?=get_member_level_select('bo_html_level', 1, 10, $board['bo_html_level'])?>
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_html_level" value="1" id="chk_grp_html_level">그룹적용</label>
                <label><input type="checkbox" name="chk_all_html_level" value="1" id="chk_all_html_level">전체적용</label>
            </div>
        </div>
        <?php if($is_admin === 'super') { // 최고관리자만 수정 가능?>
        <div class="form-list">
			<div class="form-label"><label>상단 이미지</label></div>
			<div class="formCon">
				<?php
				$img_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img.png';
				$img_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img.png';
				$upImg = file_exists($img_path) ? '<img src="'.get_url($img_url).'"><label class="del_file"><input type="checkbox" id="del_bo_top_img" name="del_bo_top_img" value="1">삭제</label>' : '';
				echo '<input type="file" name="bo_top_img" id="bo_top_img" class="myfile">';
				echo '<div class="upImg" style="max-width:260px;">'.$upImg.'</div>';
				?>
			</div>
			<div class="form-label"><label class="mobile">모바일 상단 이미지</label></div>
			<div class="formCon">
				<?php
				$img_mob_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img_mob.png';
				$img_mob_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img_mob.png';
				$upImg_mob = file_exists($img_mob_path) ? '<img src="'.get_url($img_mob_url).'"><label class="del_file"><input type="checkbox" id="del_bo_top_img_mob" name="del_bo_top_img_mob" value="1">삭제</label>' : '';
				echo '<input type="file" name="bo_top_img_mob" id="bo_top_img_mob" class="myfile">';
				echo '<div class="upImg" style="max-width:260px;">'.$upImg_mob.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label for="bo_top_img_type">상단 이미지 설정</label></div>
			<div class="formCon">
				<?=help("기본형:단순 출력, 커버형:배경커버 스타일, 모션형:스크롤에 따라 위치가 변하는 이미지")?>
				<select name="bo_top_img_type" id="bo_top_img_type">
					<?=option_selected('1', $board['bo_top_img_type'], "기본형")?>
					<?=option_selected('2', $board['bo_top_img_type'], "커버형")?>
					<?=option_selected('3', $board['bo_top_img_type'], "모션형")?>
				</select>
				<input type="hidden" name="bo_top_img_height" value="<?=$board['bo_top_img_height']?>">
				<input type="hidden" name="bo_top_img_height_mob" value="<?=$board['bo_top_img_height_mob']?>">
				<span id="top_img_height">
					<input type="text" name="bo_top_img_height" value="<?php if($board['bo_top_img_height']) echo $board['bo_top_img_height'];?>" id="bo_top_img_height" class="span60" size="4" data-class="ml20" data-label="높이" data-label-inline="PX">
					<input type="text" name="bo_top_img_height_mob" value="<?php if($board['bo_top_img_height_mob']) echo $board['bo_top_img_height_mob'];?>" id="bo_top_img_height_mob" class="span60" size="4" data-class="ml10" data-label="모바일 높이" data-label-inline="PX">
				</span>
				<script>matchOnOff('#bo_top_img_type', '3', '#top_img_height'); //상단 이미지 설정 옵션별 설명 출력</script>
			</div>
		</div>
		<div class="form-list">
            <div class="form-label"><label for="bo_content_head">상단 내용</label></div>
            <div class="formCon">
				<div class="wrConBox">
					<ul class="wrConTabs">
						<li class="icon_pc active" data-target="topCon">상단내용</li>
						<li class="icon_mobile" data-target="topCon_mob">모바일 상단내용</li>
					</ul>
					<div class="tabEditor topCon active">
						<?=editor_html("bo_content_head", get_text(html_purifier($board['bo_content_head']), 0), 1, 130)?>
					</div>
					<div class="tabEditor topCon_mob">
						<?=editor_html("bo_mobile_content_head", get_text(html_purifier($board['bo_mobile_content_head']), 0), 1, 130)?>
					</div>
				</div>
				<p class="help-block mt5">상단이미지를 사용할 경우 상단내용은 이미지 위에 겹쳐서 출력됩니다.</p>
            </div>
        </div>
		<div class="form-list">
            <div class="form-label"><label for="bo_content_head">하단 내용</label></div>
            <div class="formCon">
				<div class="wrConBox">
					<ul class="wrConTabs">
						<li class="icon_pc active" data-target="bottomCon">하단내용</li>
						<li class="icon_mobile" data-target="bottomCon_mob">모바일 하단내용</li>
					</ul>
					<div class="tabEditor bottomCon active">
						<?=editor_html("bo_content_tail", get_text(html_purifier($board['bo_content_tail']), 0), 1, 130)?>
					</div>
					<div class="tabEditor bottomCon_mob">
						<?=editor_html("bo_mobile_content_tail", get_text(html_purifier($board['bo_mobile_content_tail']), 0), 1, 130)?>
					</div>
				</div>
				<p class="help-block mt5">커버형 타입의 상단이미지를 사용할 경우 하단내용은 상단이미지의 커버 콘텐츠로 출력됩니다.</p>
            </div>
        </div>
        <?php } else { ?>
		<input type="hidden" name="bo_top_img_type" value="<?=$board['bo_top_img_type']?>"><!-- 상단 이미지 설정 -->
		<input type="hidden" name="bo_top_img_height" value="<?=$board['bo_top_img_height']?>"><!-- 상단 이미지 높이 -->
		<input type="hidden" name="bo_top_img_height_mob" value="<?=$board['bo_top_img_height_mob']?>"><!-- 상단 이미지 모바일 높이 -->
		<input type="hidden" name="bo_content_head" value="<?=$board['bo_content_head']?>"><!-- 상단내용 -->
		<input type="hidden" name="bo_mobile_content_head" value="<?=$board['bo_mobile_content_head']?>"><!-- 모바일 상단내용 -->
		<input type="hidden" name="bo_content_head" value="<?=$board['bo_content_head']?>"><!-- 하단 내용 -->
		<input type="hidden" name="bo_mobile_content_tail" value="<?=$board['bo_mobile_content_tail']?>"><!-- 모바일 하단내용 -->
		<?php } ?>
		<div class="form-list">
            <div class="form-label"><label for="bo_insert_content">글쓰기 기본 내용</label></div>
            <div class="formCon">
                <textarea id="bo_insert_content" name="bo_insert_content" rows="5"><?=html_purifier($board['bo_insert_content'])?></textarea>
            </div>
        </div>       
        <div class="form-list">
            <div class="form-label"><label for="bo_new">새글 아이콘<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <?=help('글 입력후 new 이미지를 출력하는 시간. 0을 입력하시면 아이콘을 출력하지 않습니다.')?>
                <input type="text" name="bo_new" value="<?=$board['bo_new']?>" id="bo_new" required class="required frm_input" size="4">
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_new" value="1" id="chk_grp_new">그룹적용</label>
                <label><input type="checkbox" name="chk_all_new" value="1" id="chk_all_new">전체적용</label>
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_hot">인기글 아이콘<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <?=help('조회수가 설정값 이상이면 hot 이미지 출력. 0을 입력하시면 아이콘을 출력하지 않습니다.')?>
                <input type="text" name="bo_hot" value="<?=$board['bo_hot']?>" id="bo_hot" required class="required frm_input" size="4">
            </div>
            <div class="grpset">
                <label><input type="checkbox" name="chk_grp_hot" value="1" id="chk_grp_hot">그룹적용</label>
                <label><input type="checkbox" name="chk_all_hot" value="1" id="chk_all_hot">전체적용</label>
            </div>
        </div>
		<?php if ($w == 'u') { ?>
        <div class="form-list">
            <div class="form-label"><label for="proc_count">카운트 조정</label></div>
            <div class="formCon">
                <?php echo help('현재 원글수 : '.number_format($board['bo_count_write']).', 현재 댓글수 : '.number_format($board['bo_count_comment']).'&nbsp;&nbsp;&nbsp;(게시판 목록에서 글의 번호가 맞지 않을 경우에 체크하십시오.)') ?>
                <input type="checkbox" name="proc_count" value="1" id="proc_count" data-label="카운트 리셋">
            </div>
        </div>
        <?php } ?>
        </tbody>
        </table>
    </div>
</section>


<?php if($config['cf_use_point']) { //인태 - 포인트사용일때만?>
<section id="anc_bo_point" class="mybox blue">
    <h2 class="h2_frm">게시판 포인트 설정</h2>

    <div class="formContainer label180">
        <div class="form-list">
            <div class="form-label"><label for="chk_grp_point">기본값으로 설정</label></div>
            <div class="formCon">
                <?php echo help('환경설정에 입력된 포인트로 설정') ?>
                <input type="checkbox" name="chk_grp_point" id="chk_grp_point" onclick="set_point(this.form)">
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_read_point">글읽기 포인트<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_read_point" value="<?php echo $board['bo_read_point'] ?>" id="bo_read_point" required class="required frm_input" size="5">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_read_point" value="1" id="chk_grp_read_point" data-label="그룹적용">
                <input type="checkbox" name="chk_all_read_point" value="1" id="chk_all_read_point" data-label="전체적용">
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_write_point">글쓰기 포인트<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_write_point" value="<?php echo $board['bo_write_point'] ?>" id="bo_write_point" required class="required frm_input" size="5">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_write_point" value="1" id="chk_grp_write_point" data-label="그룹적용">
                <input type="checkbox" name="chk_all_write_point" value="1" id="chk_all_write_point" data-label="전체적용">
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_comment_point">댓글쓰기 포인트<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_comment_point" value="<?php echo $board['bo_comment_point'] ?>" id="bo_comment_point" required class="required frm_input" size="5">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_comment_point" value="1" id="chk_grp_comment_point" data-label="그룹적용">
                <input type="checkbox" name="chk_all_comment_point" value="1" id="chk_all_comment_point" data-label="전체적용">
            </div>
        </div>
        <div class="form-list">
            <div class="form-label"><label for="bo_download_point">다운로드 포인트<strong class="sound_only">필수</strong></label></div>
            <div class="formCon">
                <input type="text" name="bo_download_point" value="<?php echo $board['bo_download_point'] ?>" id="bo_download_point" required class="required frm_input" size="5">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_download_point" value="1" id="chk_grp_download_point" data-label="그룹적용">
                <input type="checkbox" name="chk_all_download_point" value="1" id="chk_all_download_point" data-label="전체적용">
            </div>
        </div>
    </div>
</section>
<?php } ?>

<section id="anc_bo_extra" class="mybox blue none">
    <h2 class="h2_frm">게시판 여분필드 설정</h2>

    <div class="formContainer label180">
        <?php for ($i=1; $i<=10; $i++) { ?>
        <div class="form-list">
            <div class="form-label">여분필드<?php echo $i ?></div>
            <div class="formCon td_extra">
                <label for="bo_<?php echo $i ?>_subj">여분필드 <?php echo $i ?> 제목</label>
                <input type="text" name="bo_<?php echo $i ?>_subj" id="bo_<?php echo $i ?>_subj" value="<?php echo get_text($board['bo_'.$i.'_subj']) ?>" class="frm_input">
                <label for="bo_<?php echo $i ?>">여분필드 <?php echo $i ?> 값</label>
                <input type="text" name="bo_<?php echo $i ?>" value="<?php echo get_text($board['bo_'.$i]) ?>" id="bo_<?php echo $i ?>" class="frm_input extra-value-input">
            </div>
            <div class="grpset">
                <input type="checkbox" name="chk_grp_<?php echo $i ?>" value="1" id="chk_grp_<?php echo $i ?>" data-label="그룹적용">
                <input type="checkbox" name="chk_all_<?php echo $i ?>" value="1" id="chk_all_<?php echo $i ?>" data-label="전체적용">
            </div>
        </div>
        <?php } ?>
    </div>
</section>


<div class="btn_fixed_top">
    <?php if( $bo_table && $w ){ ?>
        <a href="./board_copy.php?bo_table=<?php echo $board['bo_table']; ?>" id="board_copy" target="win_board_copy" class=" btn_02 btn">게시판복사</a>
        <a href="<?php echo get_pretty_url($board['bo_table']); ?>" class=" btn_02 btn">게시판 바로가기</a>
        <a href="./board_thumbnail_delete.php?bo_table=<?php echo $board['bo_table'].'&amp;'.$qstr;?>" onclick="return delete_confirm2('게시판 썸네일 파일을 삭제하시겠습니까?');" class="btn_02 btn">게시판 썸네일 삭제</a>
    <?php } ?>
    <input type="submit" value="확인" class="btn_submi btn btn_01" accesskey="s">
</div>


<input type="hidden" name="bo_option" value="<?=$board['bo_option']?>"><!--//인태 - 추가-->
<input type="hidden" name="bo_device" value="both"><!-- 접속기기 -->
<input type="hidden" name="bo_count_modify" value="<?=$board['bo_count_modify']?>"><!--원글 수정 불가 -->
<input type="hidden" name="bo_count_delete" value="<?=$board['bo_count_delete']?>"><!-- 원글 삭제 불가 -->
<input type="hidden" name="bo_use_rss_view" value="<?=$board['bo_use_rss_view']?>"><!-- RSS 보이기 사용 -->
<input type="hidden" name="bo_use_nogood" value="<?=$board['bo_use_nogood']?>"><!-- 비추천 사용 -->
<input type="hidden" name="bo_use_signature" value="<?=$board['bo_use_signature']?>"><!-- 서명보이기 사용 -->
<input type="hidden" name="bo_use_ip_view" value="<?=$board['bo_use_ip_view']?>"><!-- IP 보이기 사용 -->
<input type="hidden" name="bo_use_list_content" value="<?=$board['bo_use_list_content']?>"><!-- 목록에서 내용 사용 -->
<input type="hidden" name="bo_use_list_file" value="<?=$board['bo_use_list_file']?>"><!-- 목록에서 파일 사용 -->
<input type="hidden" name="bo_use_cert" value="<?=$board['bo_use_cert']?>"><!-- 본인확인 사용 -->
<input type="hidden" name="bo_write_min" value="<?=$board['bo_write_min']?>"><!-- 최소 글수 -->
<input type="hidden" name="bo_write_max" value="<?=$board['bo_write_max']?>"><!-- 최대 글수 -->
<input type="hidden" name="bo_comment_min" value="<?=$board['bo_comment_min']?>"><!-- 최소 댓글수 -->
<input type="hidden" name="bo_comment_max" value="<?=$board['bo_comment_max']?>"><!-- 최대 댓글수 -->
<input type="hidden" name="bo_order" value="<?=$board['bo_order']?>"><!-- 출력 순서 -->
<input type="hidden" name="bo_include_head" value="<?=$board['bo_include_head']?>"><!-- 상단 파일 경로 -->
<input type="hidden" name="bo_include_tail" value="<?=$board['bo_include_tail']?>"><!-- 하단 파일 경로 -->
<input type="hidden" name="bo_image_width" value="0"><!-- 상세페이지 이미지 사이즈 -->
<input type="hidden" name="bo_option" value="<?=$board['bo_option']?>"><!-- 스킨옵션 -->
<input type="hidden" name="bo_mobile_option" value="<?=$board['bo_mobile_option']?>"><!-- 스킨옵션(모바일) -->
<input type="hidden" name="bo_use_sns" value="0"> <!-- SNS 사용 -->


</form>

<script>
$(function(){
    $("#board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=10,top=10,width=600,height=380");
        return false;
    });

    $(".get_theme_galc").on("click", function() {
        if(!confirm("현재 테마의 게시판 이미지 설정을 적용하시겠습니까?"))
            return false;

        $.ajax({
            type: "POST",
            url: "./theme_config_load.php",
            cache: false,
            async: false,
            data: { type: "board" },
            dataType: "json",
            success: function(data) {
                if(data.error) {
                    alert(data.error);
                    return false;
                }

                var field = Array('bo_gallery_cols', 'bo_gallery_width', 'bo_gallery_height', 'bo_mobile_gallery_width', 'bo_mobile_gallery_height', 'bo_image_width');
                var count = field.length;
                var key;

                for(i=0; i<count; i++) {
                    key = field[i];

                    if(data[key] != undefined && data[key] != "")
                        $("input[name="+key+"]").val(data[key]);
                }
            }
        });
    });
});

function board_copy(bo_table) {
    window.open("./board_copy.php?bo_table="+bo_table, "BoardCopy", "left=10,top=10,width=500,height=200");
}

function set_point(f) {
    if (f.chk_grp_point.checked) {
        f.bo_read_point.value = "<?php echo $config['cf_read_point'] ?>";
        f.bo_write_point.value = "<?php echo $config['cf_write_point'] ?>";
        f.bo_comment_point.value = "<?php echo $config['cf_comment_point'] ?>";
        f.bo_download_point.value = "<?php echo $config['cf_download_point'] ?>";
    } else {
        f.bo_read_point.value     = f.bo_read_point.defaultValue;
        f.bo_write_point.value    = f.bo_write_point.defaultValue;
        f.bo_comment_point.value  = f.bo_comment_point.defaultValue;
        f.bo_download_point.value = f.bo_download_point.defaultValue;
    }
}

var captcha_chk = false;

function use_captcha_check(){
    $.ajax({
        type: "POST",
        url: g5_admin_url+"/ajax.use_captcha.php",
        data: { admin_use_captcha: "1" },
        cache: false,
        async: false,
        dataType: "json",
        success: function(data) {
        }
    });
}

function frm_check_file(){
    var bo_include_head = "<?php echo $board['bo_include_head']; ?>";
    var bo_include_tail = "<?php echo $board['bo_include_tail']; ?>";
    var head = jQuery.trim(jQuery("#bo_include_head").val());
    var tail = jQuery.trim(jQuery("#bo_include_tail").val());

    if(bo_include_head !== head || bo_include_tail !== tail){
        // 캡챠를 사용합니다.
        jQuery("#admin_captcha_box").show();
        captcha_chk = true;

        use_captcha_check();

        return false;
    } else {
        jQuery("#admin_captcha_box").hide();
    }

    return true;
}

jQuery(function($){
    if( window.self !== window.top ){   // frame 또는 iframe을 사용할 경우 체크
        $("#bo_include_head, #bo_include_tail").on("change paste keyup", function(e) {
            frm_check_file();
        });

        use_captcha_check();
    }
});

function fboardform_submit(f)
{
    <?php
    if(!$w){
    $js_array = get_bo_table_banned_word();
    echo "var banned_array = ". json_encode($js_array) . ";\n";
    }
    ?>

    // 게시판명이 금지된 단어로 되어 있으면
    if( (typeof banned_array != 'undefined') && jQuery.inArray(f.bo_table.value, banned_array) !== -1 ){
        alert("입력한 게시판 TABLE명을 사용할수 없습니다. 다른 이름으로 입력해 주세요.");
        return false;
    }

    <?php echo get_editor_js("bo_content_head"); ?>
    <?php echo get_editor_js("bo_content_tail"); ?>
    <?php echo get_editor_js("bo_mobile_content_head"); ?>
    <?php echo get_editor_js("bo_mobile_content_tail"); ?>

    if (parseInt(f.bo_count_modify.value) < 0) {
        alert("원글 수정 불가 댓글수는 0 이상 입력하셔야 합니다.");
        f.bo_count_modify.focus();
        return false;
    }

    if (parseInt(f.bo_count_delete.value) < 1) {
        alert("원글 삭제 불가 댓글수는 1 이상 입력하셔야 합니다.");
        f.bo_count_delete.focus();
        return false;
    }

    if( captcha_chk ) {
        <?php echo isset($captcha_js) ? $captcha_js : ''; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
    }

    return true;
}
</script>

<?php
include_once ('./admin.tail.php');
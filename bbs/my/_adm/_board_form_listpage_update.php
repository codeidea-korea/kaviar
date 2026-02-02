<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];
$bo_background = implode("|",$_POST['bo_background']);
$bo_option = implode("|",$_POST['bo_option']);

if(file_exists($board_pcskin_path.'/_board_form_listpage_update.php')) {
	require_once($board_pcskin_path.'/_board_form_listpage_update.php');
    return;
}

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
//@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
//@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = isset($_POST['bo_category_list']) ? str_replace($src_char, $dst_char, $_POST['bo_category_list']) : '';
//https://github.com/gnuboard/gnuboard5/commit/f5f4925d4eb28ba1af728e1065fc2bdd9ce1da58 에 따른 조치
$str_bo_category_list = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", "", $bo_category_list);




$sql = " update {$g5['board_table']}
                set bo_subject_hide				= '{$_POST['bo_subject_hide']}',
					 bo_subject						= '{$_POST['bo_subject']}',
					 bo_table_width					= '{$_POST['bo_table_width']}',
					 bo_padding_top					= '{$_POST['bo_padding_top']}',
					 bo_padding_bottom			= '{$_POST['bo_padding_bottom']}',
					 bo_padding_left_right		= '{$_POST['bo_padding_left_right']}',
					 bo_mobile_padding			= '{$_POST['bo_mobile_padding']}',
					 bo_background					= '{$bo_background}',
					 bo_category_label				= '{$bo_category_label}',
					 bo_category_list				= '{$str_bo_category_list}',
					 bo_use_category				= '{$_POST['bo_use_category']}',
					 bo_cate_all_hidden			= '{$_POST['bo_cate_all_hidden']}',
					 bo_tag_list						= '{$_POST['bo_tag_list']}',
					 bo_use_tag						= '{$_POST['bo_use_tag']}',
					 bo_search_skin					= '{$_POST['bo_search_skin']}',
					 bo_list_writer					= '{$_POST['bo_list_writer']}',
					 bo_list_date						= '{$_POST['bo_list_date']}',
					 bo_hit								= '{$_POST['bo_hit']}',
					 bo_layer_popup				= '{$_POST['bo_layer_popup']}',
					 bo_popup_padding			= '{$_POST['bo_popup_padding']}',
					 bo_popup_min_size			= '{$_POST['bo_popup_min_size']}',
					 bo_popup_max_size			= '{$_POST['bo_popup_max_size']}',
					 bo_subject_len					= '{$_POST['bo_subject_len']}',
					 bo_mobile_subject_len		= '{$_POST['bo_mobile_subject_len']}',
					 bo_page_rows					= '{$_POST['bo_page_rows']}',
					 bo_mobile_page_rows		= '{$_POST['bo_mobile_page_rows']}',
					 bo_btn_write_name			= '{$_POST['bo_btn_write_name']}',
					 bo_skin							= '{$_POST['bo_skin']}',
					 bo_gallery_cols					= '{$_POST['bo_gallery_cols']}',
					 bo_gall_mobile_cols			= '{$_POST['bo_gall_mobile_cols']}',
					 bo_upload_count				= '{$_POST['bo_upload_count']}',					 
					 bo_max_screen					= '{$_POST['bo_max_screen']}',
					 bo_gallery_width				= '{$_POST['bo_gallery_width']}',
					 bo_gallery_height				= '{$_POST['bo_gallery_height']}',
					 bo_mobile_gallery_width	= '{$_POST['bo_mobile_gallery_width']}',
					 bo_mobile_gallery_height	= '{$_POST['bo_mobile_gallery_height']}',
					 bo_gall_itemspace				= '{$_POST['bo_gall_itemspace']}',
					 bo_gall_mobile_itemspace	= '{$_POST['bo_gall_mobile_itemspace']}',
					 bo_top_img_type				= '{$_POST['bo_top_img_type']}',
					 bo_top_img_height			= '{$_POST['bo_top_img_height']}',
					 bo_top_img_height_mob	= '{$_POST['bo_top_img_height_mob']}',
					 bo_content_head				= '{$_POST['bo_content_head']}',
					 bo_mobile_content_head	= '{$_POST['bo_mobile_content_head']}',
					 bo_content_tail					= '{$_POST['bo_content_tail']}',
					 bo_mobile_content_tail		= '{$_POST['bo_mobile_content_tail']}',
					 bo_use_email					= '{$_POST['bo_use_email']}',
					 bo_option							= '{$bo_option}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);


$image_regex = "/(\.(gif|jpg|png))$/i";

//상단이미지 업로드
if(is_uploaded_file($_FILES['bo_top_img']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['bo_top_img']['name']))
		alert($_FILES['bo_top_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['bo_top_img']['name'])) {
		$dest_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img.png';
		move_uploaded_file($_FILES['bo_top_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
//상단이미지(모바일 업로드)
if(is_uploaded_file($_FILES['bo_top_img_mob']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['bo_top_img_mob']['name']))
		alert($_FILES['bo_top_img_mob']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['bo_top_img_mob']['name'])) {
		$dest_path = G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img_mob.png';
		move_uploaded_file($_FILES['bo_top_img_mob']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}
//상단 이미지 삭제
if($del_bo_top_img) @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img.png');
if($del_bo_top_img_mob) @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img_mob.png');

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
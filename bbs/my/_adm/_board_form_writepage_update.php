<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];

if(file_exists($board_pcskin_path.'/_board_form_writepage_update.php')) {
	require_once($board_pcskin_path.'/_board_form_writepage_update.php');
    return;
}

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = isset($_POST['bo_category_list']) ? str_replace($src_char, $dst_char, $_POST['bo_category_list']) : '';
//https://github.com/gnuboard/gnuboard5/commit/f5f4925d4eb28ba1af728e1065fc2bdd9ce1da58 에 따른 조치
$str_bo_category_list = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", "", $bo_category_list);

$bo_upload_size = $_POST['bo_upload_size'] * 1048576; //인태 - mb를 bytes로 변환해서 저장

$sql = " update {$g5['board_table']}
                set bo_category_list				= '{$str_bo_category_list}',
					 bo_use_category				= '{$_POST['bo_use_category']}',
					 bo_cate_all_hidden			= '{$_POST['bo_cate_all_hidden']}',
					 bo_tag_list						= '{$_POST['bo_tag_list']}',	
					 bo_use_tag						= '{$_POST['bo_use_tag']}',
					 bo_use_dhtml_editor			= '{$_POST['bo_use_dhtml_editor']}',
					 bo_editor_height				= '{$_POST['bo_editor_height']}',
					 bo_use_html_tag				= '{$_POST['bo_use_html_tag']}',
					 bo_upload_count				= '{$_POST['bo_upload_count']}',
					 bo_upload_size					= '{$bo_upload_size}',
					 bo_use_file_content			= '{$_POST['bo_use_file_content']}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
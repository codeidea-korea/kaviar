<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = isset($_POST['bo_category_list']) ? str_replace($src_char, $dst_char, $_POST['bo_category_list']) : '';
//https://github.com/gnuboard/gnuboard5/commit/f5f4925d4eb28ba1af728e1065fc2bdd9ce1da58 에 따른 조치
$str_bo_category_list = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", "", $bo_category_list);

$sql = " update {$g5['board_table']}
                set bo_table_width					= '{$_POST['bo_table_width']}',
					 bo_padding_left_right		= '{$_POST['bo_padding_left_right']}',
					 bo_mobile_padding			= '{$_POST['bo_mobile_padding']}',
					 bo_category_label				= '{$bo_category_label}',
					 bo_category_list				= '{$str_bo_category_list}',
					 bo_use_category				= '{$_POST['bo_use_category']}',
					 bo_cate_skin						= '{$_POST['bo_cate_skin']}',
					 bo_background					= '{$_POST['bo_background']}',
					 bo_option							= '{$bo_option}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
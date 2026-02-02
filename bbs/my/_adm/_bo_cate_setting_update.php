<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];

// 분류에 & 나 = 는 사용이 불가하므로 2바이트로 바꾼다.
$src_char = array('&', '=');
$dst_char = array('＆', '〓');
$bo_category_list = isset($_POST['bo_category_list']) ? str_replace($src_char, $dst_char, $_POST['bo_category_list']) : '';
//https://github.com/gnuboard/gnuboard5/commit/f5f4925d4eb28ba1af728e1065fc2bdd9ce1da58 에 따른 조치
$str_bo_category_list = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", "", $bo_category_list);

$sql = " update {$g5['board_table']}
                set bo_category_label		= '{$bo_category_label}',
					 bo_cate_all_hidden	= '{$_POST['bo_cate_all_hidden']}',
					 bo_category_list		= '{$str_bo_category_list}',
					 bo_cate_skin				= '{$_POST['bo_cate_skin']}',
					 bo_cate_color			= '{$_POST['bo_cate_color']}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
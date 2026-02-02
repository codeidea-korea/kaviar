<?php
include_once("./_common.php");


$post_btn_submit = isset($_POST['btn_submit']) ? clean_xss_tags($_POST['btn_submit'], 1, 1) : '';
//echo $_POST['btn_submit'];



if($post_btn_submit === '선택복사') {
	
	

} else {

	$all_order_reset = $_POST['all_order_reset'];

	//전체수정
	for ($i=0; $i<$chk; $i++){
		$bl_id = $_POST['bl_id_up'][$i];
		if($all_order_reset) $bl_order[$i] = '';
		$sql = " update {$g5['g5_shop_block_table']} set 
						bl_order = '$bl_order[$i]',
						bl_name = '$bl_name[$i]'
				  where bl_id = '$bl_id' ";
		sql_query($sql);
	}
	
	echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";

}



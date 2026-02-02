<?php
include_once('./_common.php');

//$bo_table = $_POST['bo_table'];
//$chk_wr_id = $_POST['chk_wr_id'];

$sel_list_id = '';
for($i=0; $i<count($_POST['chk_wr_id']); $i++){
	$chk_wr_id = $_POST['chk_wr_id'];
	if($i>0) $sel_list_id .= ','; 
	$sel_list_id .= $chk_wr_id[$i];	
}

if($sel_list_id) {
	$chkCount = count(explode(",",$sel_list_id));
	echo "<script>
	opener.$('#latest_sel_li_id').val('".$sel_list_id."');
	opener.$('#btn_list_of_select').addClass('active');
	opener.$('#btn_list_of_select span').remove();
	opener.$('#btn_list_of_select').prepend('<span class=\'count\'>".$chkCount."개</span>');
	window.close();
	</script>";
} else {
	echo "<script>
	opener.$('#latest_sel_li_id').val('');
	opener.$('#btn_list_of_select').removeClass('active');
	opener.$('#btn_list_of_select span').remove();
	window.close();
	</script>";
}
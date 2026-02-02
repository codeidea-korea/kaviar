<?php
include_once('./_common.php');

$sel_list_id = '';
for($i=0; $i<count($_POST['chk_li_id']); $i++){
	$chk_li_id = $_POST['chk_li_id'];
	if($i>0) $sel_list_id .= ','; 
	$sel_list_id .= $chk_li_id[$i];	
}

$input_id = $_POST['input_id'] ? $_POST['input_id'] : '';

if($input_id) {
	if($sel_list_id) {
		$chkCount = count(explode(",",$sel_list_id));
		echo "<script>
		opener.$('#".$input_id."').val('".$sel_list_id."');
		opener.$('#".$input_id."').parent('label').addClass('active');
		window.close();
		</script>";
	} else {
		echo "<script>
		opener.$('#".$input_id."').val('');
		opener.$('#".$input_id."').parent('label').removeClass('active');
		window.close();
		</script>";
	}
} else {
	if($sel_list_id) {
		$chkCount = count(explode(",",$sel_list_id));
		echo "<script>
		opener.$('#items_sel_li_id').val('".$sel_list_id."');
		opener.$('#items_sel_li_count').val('".$chkCount."');
		opener.$('#btn_list_of_select').addClass('active');
		opener.$('#btn_list_of_select').empty();
		opener.$('#btn_list_of_select').append('<span class=\'count\'>".$chkCount."개</span>');
		window.close();
		</script>";
	} else {
		echo "<script>
		opener.$('#items_sel_li_id').val('');
		opener.$('#items_sel_li_count').val('');
		opener.$('#btn_list_of_select').removeClass('active');
		opener.$('#btn_list_of_select span').remove();
		window.close();
		</script>";
	}
}
<?php
include_once("./_common.php");

$bo_table = $_POST['bo_table'];
if($_POST['sca']) $qstr = '&sca='.$_POST['sca'];
$all_order_reset = $_POST['all_order_reset'];

//전체수정
for ($i=0; $i<$chk; $i++){
    $wr_id = $_POST['wr_id_up'][$i];
	if($all_order_reset) $wr_order[$i] = '';
	$sql = " update {$write_table} set
					wr_order = '$wr_order[$i]'
			  where wr_id = '$wr_id' ";
	sql_query($sql);
}

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";

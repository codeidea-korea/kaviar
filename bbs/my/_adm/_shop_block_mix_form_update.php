<?php
include_once("./_common.php");

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

@mkdir(G5_DATA_PATH."/shop_block", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/shop_block", G5_DIR_PERMISSION);


$bl_id = isset($_REQUEST['bl_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['bl_id']) : 0;
//$mix_type = isset($_POST['mix_type']) ? $_POST['mix_type'] : '';

$sql_common = " mix_li_1				= '$mix_li_1',
						  mix_li_2				= '$mix_li_2',
						  mix_li_3				= '$mix_li_3',
						  mix_li_4				= '$mix_li_4',
						  mix_li_5				= '$mix_li_5',
						  mix_li_6				= '$mix_li_6',
						  mix_li_7				= '$mix_li_7',
						  mix_li_8				= '$mix_li_8',
						  mix_li_9				= '$mix_li_9',
						  mix_li_10				= '$mix_li_10',
						  mix_li_11				= '$mix_li_11',
						  mix_li_12				= '$mix_li_12',
						  mix_li_13				= '$mix_li_13',
						  mix_li_14				= '$mix_li_14',
						  mix_li_15				= '$mix_li_15',
						  mix_li_16				= '$mix_li_16',
						  mix_li_17				= '$mix_li_17',
						  mix_li_18				= '$mix_li_18',
						  mix_li_19				= '$mix_li_19',
						  mix_li_20				= '$mix_li_20'
						  ";




$sql = " update {$g5['g5_shop_block_table']}
			set $sql_common
		  where bl_id = '$bl_id' ";
sql_query($sql);

@include($mix_skin_path.'/_mix_form.head.php');


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
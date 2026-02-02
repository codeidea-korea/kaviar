<?php
include_once('./_common.php');

$itemtype = implode("|", $_POST['itemtype']);
$itemtype_color = implode("|", $_POST['itemtype_color']);

$sql = " update {$g5['g5_shop_default_table']}
            set itemtype			= '{$itemtype}',
				 itemtype_color	= '{$itemtype_color}' ";
sql_query($sql);


if(strpos($callback_url, 'tab=1') !== false) {
	echo "<script>
	opener.document.location.reload();
	location.href='".$callback_url."';
	</script>";
} else {
	echo "<script>
	opener.document.location.reload();
	window.close();
	</script>";
}
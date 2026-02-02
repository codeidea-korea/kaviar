<?php
include_once('./_common.php');

$itemtype = implode("|", $_POST['itemtype']);

$sql = " update {$g5['g5_shop_default_table']}
            set itemtype					= '{$itemtype}' ";
sql_query($sql);


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
<?php
include_once('./_common.php');

$sql = " update {$g5['g5_shop_default_table']}
            set shop_banner_category = '{$_POST['shop_banner_category']}' ";
sql_query($sql);



echo "<script>
opener.document.location.reload();
window.close();
</script>";
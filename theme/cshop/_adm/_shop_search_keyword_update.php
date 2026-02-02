<?php
include_once('./_common.php');

/*
$sql = " update {$g5['g5_shop_default_table']}
            set shop_layout			= '{$_POST['shop_layout']}',
				 shop_slogan			= '{$_POST['shop_slogan']}' ";
sql_query($sql);
*/
$sql = " update {$g5['config_table']} set
			cf_search_keyword			= '{$_POST['cf_search_keyword']}' ";
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
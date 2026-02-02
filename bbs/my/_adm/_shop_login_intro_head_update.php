<?php
include_once('./_common.php');


// 쇼핑몰 기본 레이아웃
if(!isset($default['shop_login_intro_head_content'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_login_intro_head_content` text NOT NULL DEFAULT '' after `shop_layout` ", true);
}


$sql = " update {$g5['g5_shop_default_table']}
            set shop_login_intro_head_content			= '{$_POST['shop_login_intro_head_content']}' ";
sql_query($sql);


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";

/*echo "<script>
	opener.document.location.reload();
	window.close();
	</script>";*/
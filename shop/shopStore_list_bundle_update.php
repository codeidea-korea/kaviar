<?php
include_once("./_common.php");


$post_btn_submit = isset($_POST['btn_submit']) ? clean_xss_tags($_POST['btn_submit'], 1, 1) : '';


//전체수정
for ($i=0; $i<$chk; $i++){
	$store_id = $_POST['store_id_up'][$i];
	if($post_btn_submit == '초기화') $store_order[$i] = '';
	$sql = " update {$g5['g5_shop_store_table']} set 
					store_order = '$store_order[$i]'
			  where store_id = '$store_id' ";
	sql_query($sql);
}



$redirect_url = shop_short_url_my('shopStore');

goto_url($redirect_url);
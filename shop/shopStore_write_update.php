<?php
include_once('./_common.php');





$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
$store_use = isset($_POST['store_use']) ? clean_xss_tags($_POST['store_use'], 1, 1) : '';
$store_subject = isset($_POST['store_subject']) ? clean_xss_tags($_POST['store_subject'], 1, 1) : '';
$store_address = implode("|", $_POST['store_address']);
$store_wr1 = isset($_POST['store_wr1']) ? $_POST['store_wr1'] : '';
$store_wr2 = isset($_POST['store_wr2']) ? $_POST['store_wr2'] : '';
$store_wr3 = isset($_POST['store_wr3']) ? $_POST['store_wr3'] : '';
$store_wr4 = isset($_POST['store_wr4']) ? $_POST['store_wr4'] : '';
$store_wr5 = isset($_POST['store_wr5']) ? $_POST['store_wr5'] : '';

$sql_common = " store_use				= '$store_use',
						  store_subject			= '$store_subject',
						  store_address			= '$store_address',
						  store_lat					= '$store_lat',
						  store_lng					= '$store_lng',
						  store_wr1				= '$store_wr1',
						  store_wr2				= '$store_wr2',
						  store_wr3				= '$store_wr3',
						  store_wr4				= '$store_wr4',
						  store_wr5				= '$store_wr5'
						  ";


if($w == "") {
	
	$store_id = G5_SERVER_TIME;

    $sql = " insert into {$g5['g5_shop_store_table']} set
                    $sql_common
					, store_id = '$store_id' ";
    sql_query($sql);

	//$store_id = sql_insert_id();

} else if ($w == "u") {
    $sql = " update {$g5['g5_shop_store_table']}
                set $sql_common
              where store_id = '$store_id' ";
    sql_query($sql);

} else if ($w == "d") {
	
	// 지점 블럭 삭제
	$sql = "select * from {$g5['g5_shop_block_table']} where bl_cate = 'store{$store_id}' ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		@unlink(G5_DATA_PATH."/shop_block/{$row['bl_id']}_1");
		@unlink(G5_DATA_PATH."/shop_block/{$row['bl_id']}_2");
		$sql = " delete from {$g5['g5_shop_block_table']} where bl_id = '{$row['bl_id']}' "; 
		sql_query($sql);
	}
	
	// 등록된 지점 상품 삭제
	$sql = " delete from {$g5['g5_shop_store_item_table']} where store_id = '$store_id' ";
	sql_query($sql);
	
	$sql = " delete from {$g5['g5_shop_store_table']} where store_id = '$store_id' ";
    sql_query($sql);
}









$redirect_url = shop_short_url_my('shopStore');

goto_url($redirect_url);
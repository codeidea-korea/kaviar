<?php
$sub_menu = '400902';
include_once('./_common.php');

check_demo();

$w = isset($_REQUEST['w']) ? $_REQUEST['w'] : '';

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
$store_use = isset($_POST['store_use']) ? clean_xss_tags($_POST['store_use'], 1, 1) : '';
$store_subject = isset($_POST['store_subject']) ? clean_xss_tags($_POST['store_subject'], 1, 1) : '';
$store_basic = isset($_POST['store_basic']) ? clean_xss_tags($_POST['store_basic'], 1, 1) : '';
$store_address = implode("|", $_POST['store_address']);
$store_wr1 = isset($_POST['store_wr1']) ? $_POST['store_wr1'] : '';
$store_wr2 = isset($_POST['store_wr2']) ? $_POST['store_wr2'] : '';
$store_wr3 = isset($_POST['store_wr3']) ? $_POST['store_wr3'] : '';
$store_wr4 = isset($_POST['store_wr4']) ? $_POST['store_wr4'] : '';
$store_wr5 = isset($_POST['store_wr5']) ? $_POST['store_wr5'] : '';

$sql_common = " store_use				= '$store_use',
						  store_url					= '$store_url',
						  store_subject			= '$store_subject',
						  store_basic				= '$store_basic',
						  store_address			= '$store_address',
						  store_lat					= '$store_lat',
						  store_lng					= '$store_lng',
						  store_wr1				= '$store_wr1',
						  store_wr2				= '$store_wr2',
						  store_wr3				= '$store_wr3',
						  store_wr4				= '$store_wr4',
						  store_wr5				= '$store_wr5',
						  store_time				= '".G5_TIME_YMDHIS."'
						  ";

if ($w=="") {

   $store_id = G5_SERVER_TIME;
   
   $sql = " insert into {$g5['g5_shop_store_table']} set
                    $sql_common
					, store_id = '$store_id' ";
    sql_query($sql);

} else if ($w=="u") {
    
	$sql = " update {$g5['g5_shop_store_table']}
                set $sql_common
              where store_id = '$store_id' ";
    sql_query($sql);

} else if ($w=="d") {

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

if ($w == "" || $w == "u") {
	// 등록된 지점 상품 먼저 삭제
	$sql = " delete from {$g5['g5_shop_store_item_table']} where store_id = '$store_id' ";
	sql_query($sql);

	// 지점 상품등록
	$item = explode(',', $store_item);
	$count = count($item);

	for($i=0; $i<$count; $i++) {
		$it_id = isset($item[$i]) ? $item[$i] : '';
		if($it_id) {
			$sql = " insert into {$g5['g5_shop_store_item_table']}
						set store_id = '$store_id',
							it_id = '$it_id' ";
			sql_query($sql);
		}
	}
}


/* 이미지 삭제 & 업로드 */
$stroe_path = G5_DATA_PATH.'/store';
if(!is_dir($stroe_path)){
	@mkdir($stroe_path, G5_DIR_PERMISSION);
	@chmod($stroe_path, G5_DIR_PERMISSION);
}
$image_regex = "/(\.(gif|jpg|png|ico))$/i";
if($del_store_img) @unlink(G5_DATA_PATH.'/store/store_'.$store_id.'.png');
if(is_uploaded_file($_FILES['store_img']['tmp_name'])) {
	if (!preg_match($image_regex, $_FILES['store_img']['name']))
		alert($_FILES['store_img']['name'] . '은(는) 이미지 파일이 아닙니다.');
	if (preg_match($image_regex, $_FILES['store_img']['name'])) {
		$dest_path = G5_DATA_PATH.'/store//store_'.$store_id.'.png';
		move_uploaded_file($_FILES['store_img']['tmp_name'], $dest_path);
		chmod($dest_path, G5_FILE_PERMISSION);
	}
}


if ($w == "u") {
    goto_url("./storeform.php?w=u&amp;store_id=$store_id");
} else {
    goto_url("./storelist.php");
}
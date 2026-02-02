<?php
	include_once('./_common.php');

	// print_r2($_POST); exit;

	// 보관기간이 지난 상품 삭제
	cart_item_clean();

	$sw_direct = (isset($_REQUEST['sw_direct']) && $_REQUEST['sw_direct']) ? 1 : 0;

	$ii = $_REQUEST['ii'];

//echo "ii : ".$ii."<br>";

	// cart id 설정
	set_cart_id($sw_direct);

	if($sw_direct)
		$tmp_cart_id = get_session('ss_cart_direct');
	else
		$tmp_cart_id = get_session('ss_cart_id');
	
	//echo "bb : ".$tmp_cart_id."<br>";

	// 브라우저에서 쿠키를 허용하지 않은 경우라고 볼 수 있음.
	if (!$tmp_cart_id)
	{
		alert('더 이상 작업을 진행할 수 없습니다.\\n\\n브라우저의 쿠키 허용을 사용하지 않음으로 설정한것 같습니다.\\n\\n브라우저의 인터넷 옵션에서 쿠키 허용을 사용으로 설정해 주십시오.\\n\\n그래도 진행이 되지 않는다면 쇼핑몰 운영자에게 문의 바랍니다.');
	}

	$it_id = (isset($_POST['it_id'][$ii])) ? $_POST['it_id'][$ii] : '';
	$ct_id = (isset($_POST['ct_id'][$ii])) ? $_POST['ct_id'][$ii] : '';
	$inp = (isset($_POST['inp'][$ii])) ? $_POST['inp'][$ii] : '';
/*
echo "it_id :: ".$it_id."<br>";
echo "inp :: ".$inp."<br>";
echo "ct_id :: ".$ct_id."<br>";
print_r($post_it_ids);
*/
	// 레벨(권한)이 상품구입 권한보다 작다면 상품을 구입할 수 없음.
	if ($member['mb_level'] < $default['de_level_sell'])
	{
		alert('상품을 구입할 수 있는 권한이 없습니다.');
	}


	$sql3 = " update {$g5['g5_shop_cart_table']} set ct_qty = '$inp' where ct_id = '$ct_id' ";
	
	sql_query($sql3);


?>
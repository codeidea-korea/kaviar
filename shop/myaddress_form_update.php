<?php
include_once("./_common.php");

if($is_guest)
    die('회원 로그인 후 이용해 주십시오.');


$w = isset($_POST['w']) ? $_POST['w'] : '';

$ad_id = isset($_POST['ad_id']) ? (int) $_POST['ad_id'] : 0;

$ad_subject = isset($_POST['ad_subject']) ? clean_xss_tags($_POST['ad_subject']) : '';
$ad_default = isset($_POST['ad_default']) ? (int) $_POST['ad_default'] : 0;
$ad_name = clean_xss_tags($_POST['ad_name']);
$ad_hp = clean_xss_tags($_POST['ad_hp']);
$ad_zip1 = substr($_POST['ad_zip'], 0, 3);
$ad_zip2 = substr($_POST['ad_zip'], 3);
$ad_addr1 = clean_xss_tags($_POST['ad_addr1']);
$ad_addr2 = clean_xss_tags($_POST['ad_addr2']);
$ad_addr3 = clean_xss_tags($_POST['ad_addr3']);
$ad_jibeon = clean_xss_tags($_POST['ad_jibeon']);


if($ad_default) {
	sql_query(" update {$g5['g5_shop_order_address_table']} set ad_default = '0' where mb_id = '{$member['mb_id']}' ");
}


if ($w=="") {	
	 $sql = " insert into {$g5['g5_shop_order_address_table']}
                    set mb_id       = '{$member['mb_id']}',
                        ad_subject  = '$ad_subject',
                        ad_default  = '$ad_default',
                        ad_name     = '$ad_name',
                        ad_hp      = '$ad_hp',
                        ad_zip1     = '$ad_zip1',
                        ad_zip2     = '$ad_zip2',
                        ad_addr1    = '$ad_addr1',
                        ad_addr2    = '$ad_addr2',
                        ad_addr3    = '$ad_addr3',
                        ad_jibeon   = '$ad_jibeon' ";
} else if ($w=="u") {
	//alert($ad_subject);
	$sql = " update {$g5['g5_shop_order_address_table']}
                      set ad_subject  = '$ad_subject',
						  ad_default = '$ad_default',
						  ad_name     = '$ad_name',
						  ad_hp      = '$ad_hp',
						  ad_zip1     = '$ad_zip1',
						  ad_zip2     = '$ad_zip2',
						  ad_addr1    = '$ad_addr1',
						  ad_addr2    = '$ad_addr2',
						  ad_addr3    = '$ad_addr3',
						  ad_jibeon   = '$ad_jibeon'
                    where mb_id = '{$member['mb_id']}'
                      and ad_id = '{$ad_id}' ";
}
sql_query($sql);


goto_url(G5_SHOP_URL.'/myaddress.php');
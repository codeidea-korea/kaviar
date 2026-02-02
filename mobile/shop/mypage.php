<?php
include_once('./_common.php');

// 테마에 mypage.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_mypage_file = file_exists(G5_THEME_MSHOP_PATH.'/mypage.php') ? G5_THEME_MSHOP_PATH.'/mypage.php' : G5_THEME_SHOP_PATH.'/mypage.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

$g5['title'] = '마이페이지';
include_once(G5_MSHOP_PATH.'/_head.php');

// 쿠폰
$cp_count = get_shop_member_coupon_count($member['mb_id'], true);
?>

<div id="mypage">
	

	<?php include_once(G5_SHOP_PATH.'/_my_head.php'); ?>
	
	<?php include_once(G5_SHOP_PATH.'/_my_gnb.php'); ?>

	<!--<ul class="_block_link_ul column max-width">
		<li><a href="<?=G5_BBS_URL?>/member_confirm.php?url=register_form.php">회원정보수정</a></li>
		<li><a href="<?=$href_orderinquiry?>">주문내역</a></li>
		<li><a href="<?=$href_myitemuselist?>">나의 후기</a></li>
		<li><a href="<?=$href_customer?>">고객센터</a></li>
		<li><a href="<?=$href_couponzone?>">쿠폰존</a></li>-->
		<!--<li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();">회원탈퇴</a></li>-->
	<!--</ul>-->
	
	

	<?php
	/*include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
	echo '<div id="shopblock">';
	if($is_admin == 'super') {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=mypage&title=고객센터 관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">고객센터 관리</a>';
	}
	echo shop_block('mypage');
	echo '</div>';*/
	?>

</div>

<script>
function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>

<?php
include_once(G5_MSHOP_PATH.'/_tail.php');
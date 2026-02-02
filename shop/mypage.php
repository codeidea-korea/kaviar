<?php
include_once('./_common.php');
define('_SHOPMYPAGE_', true); //인태 - 하단메뉴 셀렉팅

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

// 읽지 않은 쪽지수
$memo_not_read = isset($member['mb_memo_cnt']) ? (int) $member['mb_memo_cnt'] : 0;

if(is_file(G5_THIS_SHOP_PATH.'/mypage.php')) {
	include_once(G5_THIS_SHOP_PATH.'/mypage.php');
	return;
} else if(defined('G5_THEME_SHOP_PATH')) {
    $theme_mypage_file = G5_THEME_SHOP_PATH.'/mypage.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/mypage.php');
    return;
}


echo "<script>location.href='".shop_short_url_my('orderinquiry')."'</script>";



$g5['title'] = '마이페이지';
include_once('./_head.php');
?>

<div id="mypage">
	

	<?php include_once(G5_SHOP_PATH.'/_my_head.php'); ?>

	<div id="_myContainer" class="max-width">
		<?php include_once(G5_SHOP_PATH.'/_my_gnb.php'); ?>
		<div id="_myContainer_con">
			
		</div>
	</div>

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
$(function() {
    $(".win_pop").click(function() {
        var new_win = window.open($(this).attr("href"), "win_coupon", "left=100,top=100,width=520, height=600, scrollbars=1");
        new_win.focus();
        return false;
    });
});

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}

$("#container_wr").addClass("container_wr");

</script>

<?php
include_once("./_tail.php");
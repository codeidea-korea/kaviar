<?php
include_once('./_common.php');

$g5['title'] = '마이페이지';

$head_title = '마이페이지';
$topMenu_skip = true;
include_once(G5_THEME_SHOP_PATH.'/shop.head.php');

$href_point = G5_BBS_URL.'/point.php';
$href_coupon = G5_SHOP_URL.'/coupon.php';
$href_wishlist = G5_SHOP_URL.'/wishlist.php';
$href_myitemuselist = G5_SHOP_URL.'/myitemuselist.php';

$href_orderinquiry = G5_SHOP_URL.'/orderinquiry.php';
$href_customer = G5_SHOP_URL.'/customer.php';
$href_couponzone = G5_SHOP_URL.'/couponzone.php';
$href_myaddress = G5_SHOP_URL.'/myaddress.php';
$href_myitemqalist = G5_SHOP_URL.'/myitemqalist.php';
?>

<div id="mypage" class="">

	<div class="head">
		<div class="my_name">
			<?php echo $member['mb_id'] ? $member['mb_name'] : '비회원'; ?>님
			<span class="label-member-lv"><?=$is_shop_manager?'관리자등급':'회원등급'?></span>
			<a href="<?=G5_BBS_URL?>/logout.php" class="_btn/line h-35 ml-auto">로그아웃</a>
		</div>
		<div class="my_cou_wr">
			<ul class="ic_label">
				<li><a href="<?=$href_point?>" target="_blank" class="win_pop my_point">포인트</a></li>
				<li><a href="<?=$href_coupon?>" target="_blank"  class="win_pop my_coupon">쿠폰</a></li>
				<li><a href="<?=$href_wishlist?>" class="my_wishlist">찜하기</a></li>
				<li><a href="<?=$href_myitemuselist?>" class="my_reply">나의후기</a></li>
			</ul>
			<ul class="result">
				<li><a href="<?=G5_BBS_URL?>/point.php" target="_blank" class="win_pop"><?=number_format($member['mb_point'])?>점</a></li>
				<li><a href="<?=$href_coupon?>" target="_blank" class="win_pop"><?=get_my_coupon_count()?>장</a></li>
				<li><a href="<?=$href_wishlist?>"><?=number_format($my_wish_count)?>개</a></li>
				<li><a href="<?=$href_myitemuselist?>"><?=$my_itemuse_count?>개</a></li>
			</ul>
        </div>
	</div>

	<div id="mypage_banner" class="bottom relative">
		<?php echo shop_banner('마이페이지', '_block_banner.skin.php'); ?>
		<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=마이페이지&title=쇼핑몰 배너관리" class="btnSetting light popWin" style="top:5px;right:-25px;" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#mypage_banner">쇼핑몰 배너관리</a>';?>
	</div>

	<ul class="_block_link_ul column p20">
		<li><a href="<?=G5_BBS_URL?>/member_confirm.php?url=register_form.php">회원정보수정</a></li>
		<li><a href="<?=$href_orderinquiry?>"><?=$default['shop_type']?'예약내역':'주문내역'?></a></li>
		<li><a href="<?=$href_myitemuselist?>">나의 후기</a></li>
		<li><a href="<?=$href_myitemqalist?>">문의 내역</a></li>
		<li><a href="<?=$href_customer?>">고객센터</a></li>
		<li><a href="<?=$href_couponzone?>">쿠폰존</a></li>
		<li><a href="<?=$href_myaddress?>">배송지 관리</a></li>
		
		<!--<li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();">회원탈퇴</a></li>-->
	</ul>

	<?php
	include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
	echo '<div id="shopblock">';
	if($is_admin == 'super') {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=mypage&title=고객센터 관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">고객센터 관리</a>';
	}
	echo shop_block('mypage');
	echo '</div>';
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
$footer_skip = true;
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
?>
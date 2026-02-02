<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div id="my_gnb">
	<?php if(!G5_IS_MOBILE) echo '<div class="_myCon_title">마이페이지</div>'; ?>
	<ul>
		<li><a href="<?=shop_short_url_my('orderinquiry')?>"<?=defined('_ORDERINQUIRY_')?' class="active"':''?>>주문내역</a></li>
		<li><a href="<?=shop_short_url_my('wishlist')?>"<?=defined('_WISHLIST_')?' class="active"':''?>>찜한상품</a></li>
	<!--
		<li><a href="<?=$href_myitemuselist?>"<?=defined('_ITEMUSELIST_')?' class="active"':''?>>상품후기</a></li>
	-->
		<li><a href="<?=shop_short_url_my('myaddress')?>"<?=defined('_MYADDRESS_')?' class="active"':''?>>배송지 관리</a></li>
	<!--
		<li><a href="<?=$href_point?>" target="_blank" class="win_pop<?=defined('_POINTLIST_')?' active':''?>">포인트</a></li>
		<li><a href="<?=$href_coupon?>" target="_blank" class="win_pop<?=defined('_COUPON_')?' active':''?>">쿠폰</a></li>
	-->
		<?php if(!G5_IS_MOBILE) { ?>
		<li><a href="<?=$href_couponzone?>" target="_blank" class="win_pop<?=defined('_COUPONZONE_')?' active':''?>">쿠폰존</a></li>
		<?php } else { ?>
		<li><a href="<?=$href_couponzone?>" class="<?=defined('_COUPONZONE_')?' active':''?>">쿠폰존</a></li>
		<?php } ?>
		
		<li><a href="<?=shop_short_url_my('myitemqalist')?>"<?=defined('_ITEMQALIST_')?' class="active"':''?>>상품문의</a></li>
		<li><a href="<?=shop_short_url_my('mycscenter')?>"<?=defined('_CSCENTER_')?' class="active"':''?>>1:1문의 내역</a></li>
		<li><a href="<?=G5_BBS_URL?>/member_confirm.php?url=register_form.php">회원정보 수정</a></li>
		<li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();">회원 탈퇴</a></li>
	</ul>
	<a href="https://kaviar.co.kr/bbs/board.php?bo_table=11_inquiry" class="btn_help"><span class="bold">도움이 필요하신가요?</span>고객센터 바로가기</a>
	<script>
	function member_leave() {
		return confirm('정말 회원에서 탈퇴 하시겠습니까?')
	}
	</script>
</div>


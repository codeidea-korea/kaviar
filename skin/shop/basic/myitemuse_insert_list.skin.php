<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="myitemuse">

	<ul class="myitemuse_ul">
		 <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
			$num = $total_count - ($page - 1) * $rows - $i;
			$star = get_star($row['is_score']);

			$row2 = get_shop_item($row['it_id'], true);
			$it_href = shop_item_url($row['it_id']);
			//$row2['it_name'] - 상품명
			//get_itemuse_thumb($row['is_content'], 60, 60) - 후기 이미지 썸네일
		?>
		<li>
			<div class="thumb">
				<?=get_it_image($row['it_id'], 70, get_it_height(70))?>
			</div>
			<div class="con" style="justify-content: center;">
				<div class="subject"><?=$row2['it_name']?></div>				
				<div class="subject" ><?=number_format($row['ct_price'] * $row['ct_qty'])?>원</div>
				<div class="date"><?=$row['ct_time']?></div>
			</div>
			<div style="display:flex;align-content:center;flex-wrap:wrap;">
			
			<?if(!G5_IS_MOBILE) {?>
				<div style="height:30px;display: flex;align-items: center;padding:12px;border-radius:5px;">
					<a href="https://kaviar.co.kr/shop/itemuseform.php?it_id=<?=$row['it_id']?>&ct_id=<?=$row['ct_id']?>" class="itemuse_form _btn/rd5/sm/mainColor ic-arrow-right ml-auto">후기 작성하기</a>
				</div>
			<?}else{?>
				<a href="https://kaviar.co.kr/shop/itemuseform.php?it_id=<?=$row['it_id']?>&ct_id=<?=$row['ct_id']?>" class="pop-modal-review _btn/rd5/sm/mainColor ic-arrow-right ml-auto">후기 작성하기</a>
			<?}?>
			</div>
		</li>
		<?php }
		if ($i == 0) echo '<p id="sps_empty">자료가 없습니다.</p>';
		?>
	</ul>
	
	<?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
</div>

<script>

$(function(){
    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });
});


//magnific-popup
$('.pop-modal-review').magnificPopup({
	type: 'ajax',
	fixedContentPos: true,
	fixedBgPos: true,
	closeOnContentClick: false, 
	closeOnBgClick: false,
	overflowY: 'auto',
	closeBtnInside: true,
});
</script>
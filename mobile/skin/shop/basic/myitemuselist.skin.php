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
				<a href="<?=$it_href?>"><?=get_it_image($row['it_id'], 150, get_it_height(150))?></a>
			</div>
			<div class="con">
				<div class="it_name"><a href="<?=$it_href?>"><?=$row2['it_name']?></a></div>				
				<a href="<?=G5_SHOP_URL?>/myitemuselist.php?is_id=<?=$row['is_id']?>" class="link_view">
					<div class="subject"><?=get_text($row['is_subject'])?></div>
					<div class="date"><?=substr($row['is_time'],0,10)?></div>
					<div class="grade" data-score="<?=$star?>"><span class="star"></span></div>
				</a>
			</div>
		</li>
		<?php }
		if ($i == 0) echo '<p id="sps_empty">자료가 없습니다.</p>';
		?>
	</ul>
	
	<?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
</div>
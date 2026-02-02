<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="myitemqa">

	<ul class="myitemqa_ul">
		 <?php for ($i=0; $row=sql_fetch_array($result); $i++) {
			$row2 = get_shop_item($row['it_id'], true);
			$it_href = shop_item_url($row['it_id']);

			$iq_subject = conv_subject($row['iq_subject'],50,"…");
			$iq_time = substr($row['iq_time'], 0, 10);
			$iq_time = str_replace("-", ".", $iq_time);
			$iq_stats = $row['iq_answer'] ? '<span class="tag complete">답변완료</span>' : '<span class="tag">답변대기</span>';

			$iq_question = preg_replace("/<(.*?)\>/"," ",$row['iq_question']); 
			$iq_question = preg_replace("/&nbsp;/"," ",$iq_question); 
			$iq_question = str_replace("//##", " ", $iq_question);
			$iq_question = cut_str($iq_question, 200, '…');

			//$row2['it_name'] - 상품명
			//get_itemuse_thumb($row['is_content'], 60, 60) - 후기 이미지 썸네일
		?>
		<li>
			<div class="thumb">
				<a href="<?=$it_href?>"><?=get_it_image($row['it_id'], 150, 150)?></a>
			</div>
			<div class="con">
				<div class="it_name"><a href="<?=$it_href?>"><?=$row2['it_name']?></a></div>
				<div class="qa_head">
					<a href="<?=G5_SHOP_URL?>/myitemqalist.php?iq_id=<?=$row['iq_id']?>" class="link_view">
						<span class="subject"><?=$iq_subject?></span>
						<span class="date"><?=$iq_time?></span>
					</a>
					<?=$iq_stats?>
				</div>
				<div class="iq_question"><a href="<?=G5_SHOP_URL?>/myitemqalist.php?iq_id=<?=$row['iq_id']?>"><?=$iq_question?></a></div>
			</div>
		</li>
		<?php }
		if ($i == 0) echo '<p id="sps_empty">문의내역이 없습니다.</p>';
		?>
	</ul>
	
	<?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>
</div>
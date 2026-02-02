<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);
?>

<div id="itemusephoto">	
    <h1 id="pop_title">사진 후기 전체보기</h1>	
	<div id="itemusephoto_list">
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if ($i == 0) echo '<ul>';

			$dirfile = G5_URL.'/data/member_review/';
			$chk_img = explode(",",$row['is_file']);
		?>
	<!--
		<li><a href="<?=$itemusephotolist_href?>&is_id=<?=$row['is_id']?>"><?php echo get_it_image($row['it_id'], 140, 140); //임시 이미지입니다?></a></li>
	-->
		<li><a href="<?=$itemusephotolist_href?>&is_id=<?=$row['is_id']?>"><img src="<?php echo $dirfile.$chk_img[0]?>" style="width:140px !important;height:140px;"></a></li>
		<?php }
		if ($i > 0) echo '</ul>';
		if ($i == 0) echo '<p id="sps_empty" class="tcenter">자료가 없습니다.</p>';
		?>
	</div>

	<?php echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?it_id=$it_id&amp;$qstr&amp;page="); ?>

	<button type="button" onclick="window.close();" class="btn_close">창닫기</button>
</div>
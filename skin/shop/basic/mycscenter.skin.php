<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="_mycscenter">

    <ul class="_mycscenter_ul">
		<?php
		for ($i=0; $row=sql_fetch_array($cs_result); $i++) {
			$link_url[$i] = shop_short_url_my('mycscenter','','wr_id='.$row['wr_id']);
			echo '<li>';
				echo '<a href="'.shop_short_url_my('mycscenter','','wr_id='.$row['wr_id']).'">';
					echo '<div class="subject">'.$row['wr_subject'].'</div>';
				echo '</a>';
				//echo '<span class="name">'.$row['wr_name'].'</span>';
				echo '<span class="date">'.registration_day($row['wr_datetime']).'</span>';
				echo !$row['wr_comment']?'<span class="state_tag ready">답변대기</span>':'<span class="state_tag complete">답변완료</span>';
			echo '</li>';
		}
		if($i==0) echo '<li class="empty_li">등록된 문의 내역이 없습니다.</li>';
		?>
	</ul>
	
	<?php echo $write_pages; ?>
</div>
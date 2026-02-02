<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="bo_gall">
	<ul class="gall_ul">
		<?php for ($i=0; $i<count($list); $i++) {
			echo '<li class="gall_li '.$skinOption_frame.'">'.PHP_EOL;	
			echo $gallContents[$i];
			echo '</li>';
		} ?>
	</ul>
	<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>';?>
</div>
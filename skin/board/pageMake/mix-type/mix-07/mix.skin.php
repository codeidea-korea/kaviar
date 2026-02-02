<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
for($s=0; $s<5; $s++) {
	$thumb[$i][$s] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 1, 0, false, true, 'center', false, '80/0.5/3', $s, false);
}
?>


<section class="mixWrap">
	<div class="mix-07 mixContainer">
		<?php
		echo	'<div class="mix-thumb"'.($thumb[1][$i]?' style="background-image:url('.$thumb[1][$i]["ori"].');"':'').'></div>';
		echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
		if($list[$i]['bl_title']) echo '<div class="block-title scrollMotion'.($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
		if($isContent[$i]) echo '<div class="contents scrollMotion">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
		echo '<div class="scrollMotion">'.$list_btn_set[$i].'</div>';
		echo '</div>';		
		?>
	</div>
</section>

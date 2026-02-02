<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$thumb[$i][0] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 200, 200, false, true, 'center', false, '80/0.5/3', 0, false);

if($list[$i]['bl_title'] || $isContent[$i]) {
	if($bl_text_align[$i][0] == 'center') $bl_textCon_align[$i] = 'flex-center';
	if($bl_text_align[$i][0] == 'right') $bl_textCon_align[$i] = 'flex-right';
	echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
	if($list[$i]['bl_title']) echo '<div class="block-title'.($bl_font?' '.$bl_font:'').'"><div>'.nl2br($list[$i]['bl_title']).'</div></div>'.PHP_EOL;
	if($isContent[$i]) echo '<div class="contents">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
	echo $list_btn_set[$i];
	echo '</div>';
}
?>

<section class="mixWrap">		
	<div class="mix-09 mixContainer">
		<ul class="mix-ul <?=$list[$i]['latest_list_style']?$list[$i]['latest_list_style']:'type01'?> <?=$list[$i]['latest_gall_cols']?'row-'.$list[$i]['latest_gall_cols']:'row-4'?>">
			<?php
			for($x=1; $x<11; $x++) {
				if($wr[$x][$i][0] && $wr[$x][$i][1]) {
					echo '<li class="mix-li wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0s">';					
					if($wr[$x][$i][2] == 'layer-popup') {
						echo '<a href="'.get_layer_popup_url($wr[$x][$i][1]).'" class="'.$blockName[$i].'_popup-view" alt="링크">';
					} else if($wr[$x][$i][2] == 'alert') {
						echo '<a class="pop-alert" data-text="'.$wr[$x][$i][1].'">';		
					} else {
						echo '<a href="'.$wr[$x][$i][1].'" target="'.$wr[$x][$i][2].'" alt="링크">';
					}					
					echo '<span class="mix-btn span">'.$wr[$x][$i][0].'</span>';
					echo '</a>';
					echo '</li>';
				}
			}

			for($x=1; $x<11; $x++) {
				if($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1]) {
					echo '<li class="mix-li wow fadeInUp" data-wow-duration="0.6s" data-wow-delay="0s">';					
					if($wr_sub[$x][$i][2] == 'layer-popup') {
						echo '<a href="'.get_layer_popup_url($wr_sub[$x][$i][1]).'" class="'.$blockName[$i].'_popup-view" alt="링크">';
					} else if($wr_sub[$x][$i][2] == 'alert') {
						echo '<a class="pop-alert" data-text="'.$wr_sub[$x][$i][1].'">';		
					} else {
						echo '<a href="'.$wr_sub[$x][$i][1].'" target="'.$wr_sub[$x][$i][2].'" alt="링크">';
					}					
					echo '<span class="mix-btn span">'.$wr_sub[$x][$i][0].'</span>';
					echo '</a>';
					echo '</li>';
				}
			}
			?>
		</ul>
	</div>
</section>
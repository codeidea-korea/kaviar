<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($list[$i]['bl_title'] || $isContent[$i]) {
	echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
	if($list[$i]['bl_title']) echo '<div class="block-title'.($bl_font?' '.$bl_font:'').'"><div>'.nl2br($list[$i]['bl_title']).'</div></div>'.PHP_EOL;
	if($isContent[$i]) echo '<div class="contents">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
	echo $list_btn_set[$i];
	echo '</div>';
}
?>

<section class="mixWrap">		
	<div class="mix-10 mixContainer">
		<ul class="mix-ul">			
			<?php for($x=1; $x<4; $x++) {
				echo '<li class="mix-li">';
				echo '<div class="mix-thumb" style="'.($thumb[$x][$i]['src']?'background-image:url('.$thumb[$x][$i]['ori'].')':'').'"></div>';				
				if($wr[$x][$i][0] || $wr[$x][$i][1] || ($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1])) {
					echo '<div class="mix-con">';
					if($wr[$x][$i][0]) echo '<p class="text-subject">'.nl2br($wr[$x][$i][0]).'</p>';
					if($wr[$x][$i][1]) echo '<p class="text-sub">'.nl2br($wr[$x][$i][1]).'</p>';
					if($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1]) {
						if($wr_sub[$x][$i][2] == 'layer-popup') {
							echo '<a href="'.get_layer_popup_url($wr_sub[$x][$i][1]).'" class="mix-btn '.$blockName[$i].'_popup-view" alt="'.$wr_sub[$x][$i][0].' 바로가기">'.$wr_sub[$x][$i][0].'</a>';
						} else if($wr_sub[$x][$i][2] == 'alert') {
							echo '<a href="javascript:alert(\''.$wr_sub[$x][$i][1].'\');" class="mix-btn" alt="'.$wr_sub[$x][$i][0].' 바로가기">'.$wr_sub[$x][$i][0].'</a>';
						} else {
							echo '<a href="'.$wr_sub[$x][$i][1].'" class="mix-btn" target="'.$wr_sub[$x][$i][2].'" alt="'.$wr_sub[$x][$i][0].' 바로가기">'.$wr_sub[$x][$i][0].'</a>';
						}
					}
					echo '</div>';
				}
				echo '</li>';
			} ?>
		</ul>
	</div>
</section>
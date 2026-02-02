<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($list[$i]['bl_title'] || $isContent[$i]) {
	echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
	if($list[$i]['bl_title']) echo '<div class="block-title scrollMotion'.($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
	if($isContent[$i]) echo '<div class="contents scrollMotion">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
	echo $list_btn_set[$i];
	echo '</div>';
}
?>

<section class="mixWrap">
	<div class="mix-01 mixContainer">
		<ul class="mix-ul">
			<?php for($x=1; $x<5; $x++) {
				if($thumb[$x][$i]['src'] || $wr[$x][$i][0] || $wr[$x][$i][1]) {
					echo '<li class="mix-li" data-num="'.$x.'">';
					echo $mix_link[$x][$i];
					echo '<div class="mix-thumb" style="'.($thumb[$x][$i]['src']?'background-image:url('.$thumb[$x][$i]['ori'].')':'').'"></div>';				
					if($wr[$x][$i][0] || $wr[$x][$i][1] || ($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1])) {
						echo '<div class="mix-con">';
						if($wr[$x][$i][0]) echo '<p class="text-subject">'.nl2br($wr[$x][$i][0]).'</p>';
						if($wr[$x][$i][1]) echo '<p class="text-sub">'.nl2br($wr[$x][$i][1]).'</p>';
						if($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1]) echo '<span class="mix-btn type01">'.$wr_sub[$x][$i][0].'</span>';
						echo '</div>';
					}
					if($mix_link[$x][$i]) echo '</a>';
					echo '</li>';
				}
			} ?>			
		</ul>
	</div>
</section>

<script>
$(document).ready(function(){
	gsap.registerPlugin(ScrollTrigger);
	
	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(1)"), {
		top:300,
	});
	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(2)"), {
		top:200,
	});
	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(3)"), {
		top:350,
	});
	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(4)"), {
		top:400,
	});

	gsap.to($("<?=$blockID[$i]?> .mix-li"), {
		scrollTrigger: {
			trigger: "<?=$blockID[$i]?> .mixContainer",
			start: "center bottom",
			end: "center center",
			scrub: 1,
			//markers: true,
		},
		top:0,
	});
});
</script>

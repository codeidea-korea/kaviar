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
	<div class="mix-03 mixContainer">
		
		<?php if($thumb[1][$i]['src'] || $wr[1][$i][0] || $wr[1][$i][1]) {
			echo '<div class="head">';
			echo $mix_link[1][$i];
			if($thumb[1][$i]["src"]) echo '<div class="mix-thumb" style="background-image:url('.$thumb[1][$i]["src"].');"></div>';
			if($wr[1][$i][0] || $wr1[$i][1] || ($wr_sub1[$i][0] && $wr_sub[1][$i][1])){
				echo '<div class="mix-con">';
				if($wr[1][$i][0]) echo '<p class="text-subject">'.nl2br($wr[1][$i][0]).'</p>';
				if($wr[1][$i][1]) echo '<p class="text-sub">'.nl2br($wr[1][$i][1]).'</p>';
				if($wr_sub[1][$i][0] && $wr_sub[1][$i][1]) echo '<span class="mix-btn type02">'.$wr_sub[1][$i][0].'</span>';
				echo '</div>';
			}	
			if($mix_link[1][$i]) echo '</a>';
			echo '</div>';
		} ?>
		<div class="body">
			<ul class="mix-ul">
				<?php for($x=2; $x<6; $x++) {
					if($wr[$x][$i][0] || $wr[$x][$i][1] || ($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1])) {
						echo '<li class="mix-li">';
						echo '<div class="mix-con">';
						if($wr[$x][$i][0]) echo '<p class="text-subject">'.nl2br($wr[$x][$i][0]).'</p>';
						if($wr[$x][$i][1]) echo '<p class="text-sub">'.nl2br($wr[$x][$i][1]).'</p>';
						if($mix_link[$x][$i] && $wr_sub[$x][$i][0]) echo $mix_link[$x][$i].'<span class="mix-btn type02">'.$wr_sub[$x][$i][0].'</span></a>';
						echo '</div>';
						echo '</li>';
					}
				} ?>
			</ul>
		</div>
	</div>
</section>

<?php if(!G5_IS_MOBILE) { ?>
<script>
$(document).ready(function(){	
	gsap.registerPlugin(ScrollTrigger);
	
	gsap.from($("<?=$blockID[$i]?> .head"), {
		top:400,
	});
	gsap.from($("<?=$blockID[$i]?> .mix-li"), {
		top:200, opacity:0,
	});

	gsap.to($("<?=$blockID[$i]?> .head"), {
		scrollTrigger: {
			trigger: "<?=$blockID[$i]?> .mixContainer",
			start: "top bottom",
			end: "bottom bottom",
			scrub: 1,
			//markers: true,
		},
		top:0,
	});
	$("<?=$blockID[$i]?> .mix-li").each(function(q){
		gsap.to($(this), {
			scrollTrigger: {
				trigger: "<?=$blockID[$i]?> .mixContainer",
				start: "center bottom",
				end: "bottom bottom",
				scrub: 0.5 + q,
				//markers: true,
			},
			top:0, opacity:1,
		});
	});
});
</script>
<?php } ?>
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
	<div class="mix-04 mixContainer">
		<ul class="mix-ul">
			<?php for($x=1; $x<6; $x++) {
				if($thumb[$x][$i]["src"] || $wr[$x][$i][0] || $wr[$x][$i][1]) {
					echo '<li class="mix-li">';
					echo $mix_link[$x][$i];
					echo	'<div class="mix-thumb"'.($thumb[$x][$i]["src"]?' style="background-image:url('.$thumb[$x][$i]["src"].');"':'').'></div>';
					if($mix_link[$x][$i]) echo '</a>';
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
</section>

<?php if(!G5_IS_MOBILE) { ?>
<script>
$(document).ready(function(){
	gsap.registerPlugin(ScrollTrigger);

	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(odd)"), {
		top:200,
	});
	gsap.from($("<?=$blockID[$i]?> .mix-li:nth-child(even)"), {
		top:150,
	});

	$("<?=$blockID[$i]?> .mix-li").each(function(q){
		gsap.to($(this), {
			scrollTrigger: {
				trigger: $(this),
				start: "top bottom",
				end: "bottom center",
				scrub: 1,
				//markers: true,
			},
			top:-50,
		});
	});
});
</script>
<?php } ?>
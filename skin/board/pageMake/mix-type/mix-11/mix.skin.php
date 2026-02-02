<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$thumb[0][$i] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 600, 0, false, true, 'center', false, '80/0.5/3', 0, false);

if($list[$i]['bl_title'] || $isContent[$i]) {
	echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
	if($list[$i]['bl_title']) echo '<div class="block-title'.($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
	if($isContent[$i]) echo '<div class="contents">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
	echo $list_btn_set[$i];
	echo '</div>';
}
?>


<section class="mixWrap">	
	<div class="mix-11 mixContainer">
		<ul class="mix-ul">
			<?php
			$btnType = 'type04';
			$scrub[1] = '0.1';
			$scrub[2] = '0.1';
			$scrub[3] = '0.4';
			$scrub[4] = '0.2';
			$scrub[5] = '0.4';
			$scrub[6] = '0.2';
			$scrub[7] = '0.4';
			$scrub[8] = '0.2';
			$scrub[9] = '0.4';
			for($x=1; $x<10; $x++) {
				if($thumb[$x][$i]['src'] || $wr[$x][$i][0] || $wr[$x][$i][1]) {
					echo '<li class="mix-li" data-scrub="'.$scrub[$x].'">';
					echo $mix_link[$x][$i];
					echo '<div class="mix-li-inner">';
					echo	'<div class="mix-thumb" '.($thumb[$x][$i]['src']?'style="background-image:url('.$thumb[$x][$i]["ori"].')"':'').'></div>';
					echo '<div class="mix-con">';
					if($wr[$x][$i][0]) echo '<p class="text-subject">'.nl2br($wr[$x][$i][0]).'</p>';
					if($wr[$x][$i][1]) echo '<p class="text-sub">'.nl2br($wr[$x][$i][1]).'</p>';
					if($mix_link[$x][$i] && $wr_sub[$x][$i][0]) echo '<span class="mix-btn '.$btnType.'">'.$wr_sub[$x][$i][0].'</span>';
					echo '</div>';
					echo '</div>';
					if($mix_link[$x][$i]) echo '</a>';
					echo '</li>';
				}
			}	
			?>			
		</ul>
	</div>
	<div class="bgContainer"><div class="backgroundCon" style="<?php if(!$videoCon[$i] && $thumb[0][$i]['src']) echo 'background-image:url('.$thumb[0][$i]["ori"].')'?>"><?=$videoCon[$i]?></div></div>
</section>
<div class="end-zone"></div>


<script>
$(document).ready(function(){
	gsap.registerPlugin(ScrollTrigger);
	
	gsap.to("<?=$blockID[$i]?> .bgContainer", {
		scrollTrigger: {
			trigger: "<?=$blockID[$i]?> .bgContainer",
			start: "top top",
			endTrigger : $('<?=$blockID[$i]?> .end-zone'),
			end: "top bottom",
			//scrub: 1,
			pin: true,
			//markers: true,
			onUpdate: function(){
			},
		},
	});
	<?php if(!G5_IS_MOBILE) { ?>
	gsap.to("<?=$blockID[$i]?> .textCon", {
		scrollTrigger: {
			trigger: "<?=$blockID[$i]?> .textCon",
			start: "top +=200 top",
			endTrigger : $('<?=$blockID[$i]?> .end-zone'),
			end: "top bottom",
			scrub: 1,
			pin: true,
			//markers: true,
		},
	});
	<?php } ?>
	
	gsap.to("<?=$blockID[$i]?> .backgroundCon", {
		scrollTrigger: {
			trigger: "<?=$blockID[$i]?> .backgroundCon",
			start: "top bottom",
			end: "top top",
			scrub: 0.4,
			toggleClass: {targets: "<?=$blockID[$i]?> .bgContainer", className: "on"},
			//markers: true,
			onUpdate: function(self){
				gsap.to($("<?=$blockID[$i]?> .backgroundCon"), 1, {width:40 + (self.progress.toFixed(3) * 60) + "%", marginTop: <?=!G5_IS_MOBILE?'700':'200'?> - (self.progress.toFixed(3) * <?=!G5_IS_MOBILE?'700':'200'?>), ease:Power4.easeOut});
			},
		},
		//width: "100%",
		//marginTop: 0,
	});

	$("<?=$blockID[$i]?> .mix-li:nth-child(odd)").each(function(q){
		gsap.to($(this), {
			scrollTrigger: {
				trigger: "<?=$blockID[$i]?> .mixContainer",
				start: "top bottom",
				endTrigger : $('<?=$blockID[$i]?> .end-zone'),
				end: "top bottom",
				scrub: 1.5,
				//markers: true,
			},
			top:<?=!G5_IS_MOBILE?'-850':'-250'?>,
		});
	});

	$("<?=$blockID[$i]?> .mix-li:nth-child(even)").each(function(q){
		gsap.to($(this), {
			scrollTrigger: {
				trigger: "<?=$blockID[$i]?> .mixContainer",
				start: "top bottom",
				endTrigger : $('<?=$blockID[$i]?> .end-zone'),
				end: "top bottom",
				scrub: 1.2,
				//markers: true,
			},
			top:<?=!G5_IS_MOBILE?'-100':'-250'?>,
		});
	});
});
</script>
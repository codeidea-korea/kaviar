<?php
//이곳에 작성한 HTML은 쇼핑몰 블럭 ID3에 출력합니다.
//이미지 경로 - $html_img_url

$logo_list = '';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo01.png"></a></div>';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo02.png"></a></div>';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo03.png"></a></div>';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo04.png"></a></div>';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo05.png"></a></div>';
$logo_list .= '<div class="swiper-slide"><a href="#"><img src="'.$html_img_url.'/logo06.png"></a></div>';
?>

<style>
<?php if(!G5_IS_MOBILE) { ?>
.logolistContainer{display:flex;align-items:center;justify-content:center;gap:30px;}
.logolistContainer .swiper-slide{width:auto !important;}
<?php } else { ?>
.logolistContainer .swiper-container{padding:0 20px;}
<?php } ?>
</style>

<div id="bl_id_3" class="_sectionContainer">
	<?php if(!G5_IS_MOBILE) { ?>
	<div class="logolistContainer">
		<?=$logo_list?>
	</div>	
	<?php } else { ?>
	<div class="logolistContainer mySwiper" data-per="3" data-gap="15" data-loop="false">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<?=$logo_list?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>

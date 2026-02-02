<?php
//이곳에 작성한 HTML은 쇼핑몰 블럭 ID20에 출력합니다.
//이미지 경로 - $html_img_url
?>

<style>
.blCon-head{padding:0 20px}
#bl_id_20 .swiper-slide{display:flex;flex-direction:column;gap:5px;}
#bl_id_20 .swiper-slide img{border-radius:12px;}
#bl_id_20 .swiper-slide .subject{font-size:16px;font-weight:500;text-align:center;}
#bl_id_20 .swiper-slide .sub{font-size:13px;text-align:center;}
</style>

<div id="bl_id_20" class="_sectionContainer">
	<div class="mySwiper p20 pt0" data-per="3.2" data-gap="15" data-loop="false">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<img src="<?=$html_img_url?>/brand1.png">
					<div class="subject">비담은</div>
					<div class="sub">프리미엄 절임식품</div>
				</div>
				<div class="swiper-slide">
					<img src="<?=$html_img_url?>/brand2.png">
					<div class="subject">온·바다</div>
					<div class="sub">제철 수산물</div>
				</div>
				<div class="swiper-slide">
					<img src="<?=$html_img_url?>/brand3.png">
					<div class="subject">포시즌</div>
					<div class="sub">급랭·손질 수산물</div>
				</div>
				<div class="swiper-slide">
					<img src="<?=$html_img_url?>/brand4.png">
					<div class="subject">봉쿡</div>
					<div class="sub">밀키트</div>
				</div>
			</div>		
		</div>
	</div>
</div>

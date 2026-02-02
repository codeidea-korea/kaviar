<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$tv_datas = get_view_today_items(true);

$tv_div['top'] = 0;
$tv_div['img_width'] = 65;
$tv_div['img_height'] = 65;
$tv_div['img_length'] = 2; // 한번에 보여줄 이미지 수

add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 5);
?>

<!-- 오늘 본 상품 시작 { -->
<div id="stv">
    <h2 class="s_h2">최근 본 상품</h2>

    <?php if($tv_datas) { // 오늘 본 상품이 1개라도 있을 때
		
		$tv_tot_count = 0;
		$k = 0;
		foreach($tv_datas as $rowx) {
			if(!$rowx['it_id'])
				continue;
			
			$tv_it_id = $rowx['it_id'];

			if ($tv_tot_count % $tv_div['img_length'] == 0) $k++;

			$it_name = get_text($rowx['it_name']);
			$stv_img = get_it_image($tv_it_id, 70, get_it_height(70), $tv_it_id, '', $it_name);
			$it_price = get_price($rowx);
			$print_price = is_int($it_price) ? number_format($it_price) : $it_price;

			if($tv_tot_count == 0) {
				echo '<div class="swiper-container">'.PHP_EOL;
					echo '<ul id="stv_ul" class="swiper-wrapper">'.PHP_EOL;
			}
				echo '<li class="swiper-slide stv_item c'.$k.'">'.PHP_EOL;
					echo '<div class="prd_img">';
						echo $stv_img;
					echo '</div>'.PHP_EOL;
				echo '</li>'.PHP_EOL;

			$tv_tot_count++;
		}
		if ($tv_tot_count > 0) {
				echo '</ul>'.PHP_EOL;
				echo '<div class="prev"></div>'.PHP_EOL;
				echo '<div class="next"></div>'.PHP_EOL;
			echo '</div>'.PHP_EOL;
		}
    ?>

    <script>
	$(document).ready(function(){	
		$(window).scroll(function() {
			if( $(this).scrollTop() >= $('#_todayview').offset().top - 80) {
				$('#stv').addClass('scroll-fix');
			} else {
				$('#stv').removeClass('scroll-fix');
			}
		});

		var swiper = new Swiper("#stv .swiper-container", {
			direction: "vertical",
			slidesPerView : 2.5,
			centeredSlides: false,
			spaceBetween: 7,
			navigation: {
				nextEl: '#stv .next',
				prevEl: '#stv .prev'
			},
		});

	});
    </script>

    <?php } else { // 오늘 본 상품이 없을 때 ?>

    <p class="li_empty">없음</p>

    <?php } ?>
</div>
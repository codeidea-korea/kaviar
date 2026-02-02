<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/'.$css.'">', 0);

$max_width = $max_height = 0;

$_pop_disable_hours = 24;

echo '<div id="_top_bar_banner" class="mobile-max-width" style="display:none">';
	echo '<div id="_top_bar_banner_con"'.($default['bn_closer_color']?' style="--closer-color:'.$default['bn_closer_color'].';"':'').'>';
		if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=상단 띠배너&title=쇼핑몰 배너관리" class="btnSetting light popWin" data-width="1430" data-height="600" data-top="60" data-left="0" data-area="#_top_bar_banner_con">쇼핑몰 배너관리</a>';
		echo '<button class="_banner_close">닫기</button>';
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			if ($i==0) {
				echo '<div class="mySwiper" data-per="1" data-gap="0" data-loop="false" data-center="'.($bannerCount>1?'true':'false').'" data-timer="7">';
				echo '<div class="swiper-container">'.PHP_EOL;
				echo '<div class="swiper-wrapper">'.PHP_EOL;
			}
			//print_r2($row);
			// 테두리 있는지
			$bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';;
			// 새창 띄우기인지
			$bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

			$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
			if (file_exists($bimg))
			{
				$banner = '';
				$size = getimagesize($bimg);

				if($size[2] < 1 || $size[2] > 16)
					continue;

				if($max_width < $size[0])
					$max_width = $size[0];

				if($max_height < $size[1])
					$max_height = $size[1];

				echo '<div class="swiper-slide">'.PHP_EOL;
				if ($row['bn_url'][0] == '#')
					$banner .= '<a href="'.$row['bn_url'].'">';
				else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
					$banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
				}
				echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
				if($banner)
					echo '</a>'.PHP_EOL;
				echo '</div>'.PHP_EOL;

				$bn_sl = '';
			}
		}

		if ($i > 0) {
			echo '</div>'.PHP_EOL;
			echo '</div>'.PHP_EOL;
			if ($i > 1) {
				echo '<div class="pagination fraction inside"></div>'.PHP_EOL;
			}
			echo '</div>'.PHP_EOL;
		}	
	echo '</div>';

echo '</div>'.PHP_EOL;
?>

<script>
//$("body, html").css("overflow", "hidden");
$(function() {
	var _top_bar_banner_cookie = Get_Cookie( "_top_bar_banner" );
	if(_top_bar_banner_cookie == 1) {
		$('#_top_bar_banner').remove();
	} else {
		$("#_top_bar_banner").css({'display':''});
	}
    $('#_top_bar_banner ._banner_close').click(function() {
        $('#_top_bar_banner').remove();
		Set_Cookie('_top_bar_banner', '1', 1 );
    });
});
</script>
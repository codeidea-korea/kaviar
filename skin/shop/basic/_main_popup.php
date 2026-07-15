<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/'.$css.'">', 0);

$max_width = $max_height = 0;

$_pop_disable_hours = 24;
//if($_SERVER["REMOTE_ADDR"] == "121.161.30.109"){
	echo '<div id="_main_pop" class="mobile-max-width" style="display:none;">';
		echo '<div id="_main_pop_con">';
			if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=메인 팝업&title=쇼핑몰 배너관리" class="btnSetting light popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#_main_pop_con">쇼핑몰 배너관리</a>';
			
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				if ($i==0) {
					echo '<div class="mySwiper" data-per="1" data-gap="'.($bannerCount>1?'20':'0').'" data-loop="false" data-center="true" data-timer="4.65" data-autoheight="true">';
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
					echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.' style="border-radius: 15px;">';
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
					echo '<div class="pagination"></div>'.PHP_EOL;
				}
				echo '</div>'.PHP_EOL;
			}	
		echo '</div>';

		echo '<div id="_main_pop_bottom" style="'.(G5_IS_MOBILE?'justify-content: space-around; !important;gap:0;width:100%;margin-top:-10px':'').'">';
			echo '<div><button class="_pop_close_disable" style="text-decoration:auto">다시보지 않기</button></div>';
			echo '<div><button class="_pop_close">닫기</button></div>';
		echo '</div>';

		echo '<div id="_main_pop_bg"></div>';

	echo '</div>'.PHP_EOL;
//}
?>

<script>
$("body, html").css("overflow", "hidden");
$(function() {
	var _main_pop_cookie = Get_Cookie( "_main_pop" );
	if(_main_pop_cookie == 1) {
		$('#_main_pop').remove();
		$('body, html').css('overflow', '');
	} else {
		$("#_main_pop").css({'display':''});
	}

    $("#_main_pop ._pop_close_disable").click(function() {
		$('body, html').css('overflow', '');
		$('#_main_pop').remove();
		Set_Cookie('_main_pop', '1', 1 );
        //set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
    });
    $('#_main_pop ._pop_close').click(function() {
        $('#_main_pop').remove();
		$('body, html').css('overflow', '');
    });
});
</script>

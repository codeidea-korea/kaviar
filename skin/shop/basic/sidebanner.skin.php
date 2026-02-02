<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
//add_javascript('<script src="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.js"></script>', 10);
//add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/owlcarousel/owl.carousel.min.css">', 10);

$max_width = $max_height = 0;
$bn_first_class = ' class="bn_first"';
$bn_slide_btn = '';
$bn_sl = ' class="bn_sl"';
$main_banners = array();

echo '<div class="mySwiper imgContainer" data-per="1" data-gap="10" data-loop="false">';

echo '<div class="swiper-container">';
echo '<div class="swiper-wrapper">';
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $main_banners[] = $row;

    // 테두리 있는지
    $bn_border  = ($row['bn_border']) ? ' class="border-"' : '';
    // 새창 띄우기인지
    $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

    $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
    $item_html = '';

    if (file_exists($bimg)) {
        $banner_link = '';
        $size = getimagesize($bimg);
        if($size[2] < 1 || $size[2] > 16) continue;
        if($max_width < $size[0]) $max_width = $size[0];
        if($max_height < $size[1]) $max_height = $size[1];

        $item_html .= '<div class="swiper-slide">';
        if ($row['bn_url'][0] == '#') {
            $banner_link .= '<a href="'.$row['bn_url'].'">';
        } else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner_link .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
        $item_html .= $banner_link.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if($banner_link) $item_html .= '</a>';
        $item_html .= '</div>';
    }
    
    echo $item_html;
}
echo '</div>';
echo '</div>';
if($i > 1) {
	echo '<div class="controller">';
	echo '<span class="prev"></span><div class="pagination fraction"></div><span class="next"></span>';
	echo '</div>';
}
echo '</div>';


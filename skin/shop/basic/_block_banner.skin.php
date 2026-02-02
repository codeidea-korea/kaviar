<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
$skin_style_url = !G5_IS_MOBILE ? G5_SHOP_SKIN_URL : G5_MSHOP_SKIN_URL;
add_stylesheet('<link rel="stylesheet" href="'.get_url($skin_style_url.'/skin.css').'">', 0);

$_this_block_banner_skin_path = G5_THIS_PATH.'/skin/shop/_block_banner.skin.php';
if(file_exists($_this_block_banner_skin_path)) {
	require($_this_block_banner_skin_path);
	return;
}
$_theme_block_banner_skin_path = G5_THEME_PATH.'/skin/shop/basic/_block_banner.skin.php';
if(file_exists($_theme_block_banner_skin_path)) {
	require($_theme_block_banner_skin_path);
	return;
}

$_pagination_type = !$position && $pager_type != 'basic' ? 'fraction' : '';


$max_width = $max_height = 0;
$bn_slide_btn = '';
$bn_sl = ' class="bn_sl"';
for ($i=0; $row=sql_fetch_array($result); $i++) {
    if ($i==0) {
		echo '<div class="bannerContainer mySwiper" data-per="'.($cols?$cols:1).'" data-gap="'.($gap?$gap:0).'" data-loop="true" data-timer="5" data-autoheight="true" style="--border-radius:'.$items_radius.'px;">';
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

        echo '<div class="banner-list swiper-slide">'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
		$banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'];
		if(G5_IS_MOBILE && file_exists(G5_DATA_PATH.'/banner/'.$row['bn_id'].'_2')) $banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'].'_2';
       // echo $banner.'<img src="'.$banner_url[$i].'?v='.date("his").' width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
		echo $banner.'<img src="'.$banner_url[$i].'?v='.date("his").'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if($banner) echo '</a>'.PHP_EOL;
		if($is_admin) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/bannerform.php?w=u&amp;bn_id='.$row['bn_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
        echo '</div>'.PHP_EOL;

        $bn_sl = '';
    }
}

if ($i > 0) {
    echo '</div>'.PHP_EOL;
	echo '</div>'.PHP_EOL;
	if ($i > 1) {
		echo '<div class="pagination inside '.$_pagination_type.'"></div>'.PHP_EOL;
		if($_pagination_type =='fraction') echo '<div class="prev"></div>'.PHP_EOL;
		if($_pagination_type =='fraction') echo '<div class="next"></div>'.PHP_EOL;
	}
	echo '</div>'.PHP_EOL;
}

?>
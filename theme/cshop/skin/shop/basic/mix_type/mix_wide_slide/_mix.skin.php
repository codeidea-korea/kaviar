<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//$bl_img1 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_1';
//if(file_exists($bl_img1)) $bl_img1_ur = G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_1';
for($i=1; $i<=6; $i++) {
	$var = 'bl_img'.$i.'_ur';
	$svar = 'slide'.$i.'Style';
	if(file_exists(G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_'.$i)) $$var = G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_'.$i;
	if(!G5_IS_MOBILE) $$svar = 'background:url('.$$var .') no-repeat center / cover';
}

// ───────────────────────────────────────────────────────────────────
//												믹스형블럭에서 배너 출력
// ───────────────────────────────────────────────────────────────────
function get_mix_banner2($banner_id) {
	global $g5, $is_admin, $default;


	$sql_device = " and ( bn_device = 'both' or bn_device = 'pc' ) ";
	if(G5_IS_MOBILE) $sql_device = " and ( bn_device = 'both' or bn_device = 'mobile' ) ";

	//직접선택
	$sel_li_ids = explode(",", $banner_id);
	$where .= " AND (";
	for ($t=0; $t<count($sel_li_ids); $t++) {
		$sel_li_id = trim($sel_li_ids[$t]);
		if($sel_li_id=='') continue;
		if($t>0) $where .= ' || ';
		$where .= 'bn_id = '.$sel_li_id.'';
	}
	$where .= ") ";

	$sql = " select * from {$g5['g5_shop_banner_table']} where ('".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time || bn_end_time='0000-00-00 00:00:00') $sql_device {$where} order by bn_order, bn_id desc ";
	$result = sql_query($sql);
	
	$str = '';

	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
		if (file_exists($bimg)) {
			$banner = '';
			$size = getimagesize($bimg);

			if($size[2] < 1 || $size[2] > 16)
				continue;

			if($max_width < $size[0])
				$max_width = $size[0];

			if($max_height < $size[1])
				$max_height = $size[1];

			$str .= '<div class="item-list mix-banner">';
			if ($row['bn_url'][0] == '#')
				$banner .= '<a href="'.$row['bn_url'].'">';
			else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
				$banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.($row['bn_new_win']?' target="_blank"':'').'>';
			}
			$banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'];
			if(G5_IS_MOBILE && file_exists(G5_DATA_PATH.'/banner/'.$row['bn_id'].'_2')) $banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'].'_2';
			$str .= $banner.'<img src="'.$banner_url[$i].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'">';
			if($banner) $str .= '</a>'.PHP_EOL;
			if($is_admin) $str .= '<a href="'.G5_ADMIN_URL.'/shop_admin/bannerform.php?w=u&amp;bn_id='.$row['bn_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
			$str .= '</div>';
		}
	}

	return $str;	
}

function get_mix_item2($it_id, $items_skin='', $img_width=350, $img_height=350) {
	global $g5, $is_admin, $default, $member, $config;
	
	add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);

	$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);
	
	$item_link_href = shop_item_url($it['it_id']);     // 상품링크
	$star_score = $it['it_use_avg'] ? (int) get_star($it['it_use_avg']) : '';     //사용자후기 평균별점
	$is_soldout = is_soldout($it['it_id'], true);   // 품절인지 체크

	$str = '';
	$str .= '<div class="item-list mix-item">';

		$str .= '<div class="thumb">';      
			$itemtype_tag = '';
			$itemtype = explode("|", $default['itemtype']);
			$itemtype_color = explode("|", $default['itemtype_color']);
			for ($t=0; $t < count($itemtype); $t++) {
				$num = $t + 1;
				if($it['it_type'.$num]) $itemtype_tag .= '<span class="itemtyp_tag"'.($itemtype_color[$t]?' style="background:'.$itemtype_color[$t].';"':'').'>'.$itemtype[$t].'</span>';
			}
			if($itemtype_tag) $str .= '<div class="itemtype-tag-set">'.$itemtype_tag.'</div>';
			$str .= '<a href="'.$item_link_href.'">'.get_it_image($it['it_id'], $img_width, $img_height, '', '', stripslashes($it['it_name']), true).'</a>';
			if($is_soldout) $str .= '<span class="shop_icon_soldout"><span class="soldout_txt" style="position:absolute;top:0px;left:0px;color:#000;background:rgba(255, 255, 255, 0.8);width:100%;height:100%;text-align:center;padding-top:60%" >SOLD OUT</span></span>';	
			
			$it_timer_arr[$i] = explode('|', $it['it_timer']);
			if($it_timer_arr[$i][0]) $str .= get_buy_timer($it['it_id']);

			if(!$is_soldout) $str .= '<div class="sct_btn list-10-btn"><button type="button" class="btn_cart sct_cart" data-it_id="'.$it['it_id'].'">장바구니</button></div>';
			//$str .= '<div class="cart-layer"></div>';
		$str .= '</div>';

		$str .= '<div class="itemCon">';
			 if($it['it_store_id']) {
				$store = sql_fetch("select * from {$g5['g5_shop_store_table']} where store_id = {$it['it_store_id']}");
				$store_img_path = G5_DATA_PATH.'/store/store_'.$it['it_store_id'].'.png';
				$store_img_url = G5_DATA_URL.'/store/store_'.$it['it_store_id'].'.png';
				if(!G5_IS_MOBILE) {
					$str .= '<div class="sit_store">';
						if($store['store_url']) $str .= '<a href="'.$store['store_url'].'">';
						$str .= file_exists($store_img_path) ? '<img src="'.$store_img_url.'?'.preg_replace('/[^0-9]/i', '', $store['store_time']).'">' : '<span class="tag">'.$store['store_subject'].'</span>';
						if($store['store_url']) $str .= '</a>';
						if(!G5_IS_MOBILE) $str .= $store['store_basic'];
					$str .= '</div>';
				}
				/*
				if(file_exists($store_img_path)) {
					$str .= '<div class="sit_store"><img src="'.get_url($store_img_url).'">'.$store['store_basic'].'</div>';
				} else {					
					$str .= '<div class="sit_store"><span class="tag">'.$store['store_subject'].'</span>'.$store['store_basic'].'</div>';
				}*/
			}
			$mba = sql_fetch("select * from `g5_member_grade` where idx = '".$member['mb_grade']."' ");
			//$str .= $config['cf_grade']." - ".$mba['g_discount'];
			//$it_timer_arr[$i] = explode('|', $it['it_timer']);
			//if($it_timer_arr[$i][0]) $str .= get_buy_timer($it['it_id']);
			$str .= '<div class="box">';
				$str .= '<div class="head">';
					$str .= '<div class="subject">';
						$str .= '<a href="'.$item_link_href.'">'.stripslashes($it['it_name']).'</a>';
					$str .= '</div>';
				$str .= '</div>';
				//if(G5_IS_MOBILE) $it['it_basic'] = cut_str($it['it_basic'], 27, '…');
				if($it['it_basic']) $str .= '<div class="item_basic">'.$it['it_basic'].'</div>';
				$str .= '<div class="priceInfo">';
					
					if($it['it_tel_inq']){
						$str .= '<span class="price">'.$it['it_tel_inq_text'].'</span>';
					}else{
						if($config['cf_grade'] == 1 && $mba['g_discount'] > 0){ //할인율이 존재할경우
							if($it['it_grade']){
								$prii = $it['it_cust_price']?$it['it_cust_price']:$it['it_price'];
								$discount_rate = round(($prii - get_price($it)) / $prii * 100);
								//$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
								//$str .= '<span class="price before">'.display_price($it['it_price']).'</span>';
								$str .= '<span class="price before">'.display_price($prii).'</span>';
								$str .= '<span class="rate">'.$discount_rate.'%</span>';
							}else{
								$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
								$str .= '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
								$str .= '<span class="rate">'.$discount_rate.'%</span>';
							}
							$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
						}else{

							if($it['it_cust_price']){
								$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
								if($it['it_cust_price']) $str .= '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
								if($it['it_cust_price']) $str .= '<span class="rate">'.$discount_rate.'%</span>';				
								$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
							}else{
								//$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
								//$str .= '<span class="price before">'.display_price($it['it_price']).'</span>';
								//$str .= '<span class="rate">'.$discount_rate.'%</span>';				
								$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
							}

							
						}
					}
/*
					$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
					if($it['it_cust_price']) $str .= '<span class="rate">'.$discount_rate.'%</span>';				
					$str .= '<span class="price">'.display_price(get_price($it), $it['it_tel_inq']).'</span>';
					if($it['it_cust_price']) $str .= '<span class="price before">'.display_price($it['it_cust_price']).'</span>';*/
				$str .= '</div>';
				if(!G5_IS_MOBILE) $str .= get_it_tag($it['it_id'], 4);
			$str .= '</div>';
			$str .= '<a href="'.$item_link_href.'" class="link_item_view">자세히 보기</a>';
		$str .= '</div>';
		if($is_admin) $str .= '<a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$it['it_id'].'&amp;ca_id='.$it['ca_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
	
	$str .= '</div>';

	return $str;
}







echo '<div class="itemsContainer _slide mySwiper" data-timer="5" data-per="1" data-gap="0" data-loop="true" data-loop="false" data-autoheight="true" style="--border-radius:8px;">';
	echo '<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';
			if($shopblock['mix_li_1'] || $shopblock['mix_li_2']) {
				echo '<div class="swiper-slide" style="'.$slide1Style.'">';
					if($shopblock['mix_li_1']) echo get_mix_banner2($shopblock['mix_li_1']);
					if($shopblock['mix_li_2']) echo get_mix_item2($shopblock['mix_li_2'], '', 270, 338);
				echo '</div>';
			}
			if($shopblock['mix_li_3'] || $shopblock['mix_li_4']) {
				echo '<div class="swiper-slide" style="'.$slide2Style.'">';
					if($shopblock['mix_li_3']) echo get_mix_banner2($shopblock['mix_li_3']);
					if($shopblock['mix_li_4']) echo get_mix_item2($shopblock['mix_li_4'], '', 270, 338);
				echo '</div>';
			}
			if($shopblock['mix_li_5'] || $shopblock['mix_li_6']) {
				echo '<div class="swiper-slide" style="'.$slide3Style.'">';
					if($shopblock['mix_li_5']) echo get_mix_banner2($shopblock['mix_li_5']);
					if($shopblock['mix_li_6']) echo get_mix_item2($shopblock['mix_li_6'], '', 270, 338);
				echo '</div>';
			}
			if($shopblock['mix_li_7'] || $shopblock['mix_li_8']) {
				echo '<div class="swiper-slide" style="'.$slide4Style.'">';
					if($shopblock['mix_li_7']) echo get_mix_banner2($shopblock['mix_li_7']);
					if($shopblock['mix_li_8']) echo get_mix_item2($shopblock['mix_li_8'], '', 270, 338);
				echo '</div>';
			}
			if($shopblock['mix_li_9'] || $shopblock['mix_li_10']) {
				echo '<div class="swiper-slide" style="'.$slide5Style.'">';
					if($shopblock['mix_li_9']) echo get_mix_banner2($shopblock['mix_li_9']);
					if($shopblock['mix_li_10']) echo get_mix_item2($shopblock['mix_li_10'], '', 270, 338);
				echo '</div>';
			}
			if($shopblock['mix_li_11'] || $shopblock['mix_li_12']) {
				echo '<div class="swiper-slide" style="'.$slide6Style.'">';
					if($shopblock['mix_li_11']) echo get_mix_banner2($shopblock['mix_li_11']);
					if($shopblock['mix_li_12']) echo get_mix_item2($shopblock['mix_li_12'], '', 270, 338);
				echo '</div>';
			}
		echo '</div>';
	echo '</div>';
	
	echo '<div class="prev"></div>'.PHP_EOL;
	echo '<div class="next"></div>'.PHP_EOL;
echo '</div>';


?>

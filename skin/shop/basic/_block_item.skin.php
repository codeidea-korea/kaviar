<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/'.(G5_IS_MOBILE?'mobile':'style').'.css">', 0);

// 장바구니 또는 위시리스트 ajax 스크립트
add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);
$mbg = sql_fetch("select * from `g5_member_grade` where idx = '".$member['mb_grade']."' ");
$_this_block_item_skin_path = G5_THIS_PATH.'/skin/shop/_block_item.skin.php';
if(file_exists($_this_block_item_skin_path)) {
	require($_this_block_item_skin_path);
	return;
}
$_theme_block_item_skin_path = G5_THEME_PATH.'/skin/shop/basic/_block_item.skin.php';
if(file_exists($_theme_block_item_skin_path)) {
	require($_theme_block_item_skin_path);
	return;
}

$totalCount = $this->total_count;
$_items_skin = $this->items_skin;
$items_skin_arr = explode("|", $_items_skin);
$items_skin = $items_skin_arr[0];
if(G5_IS_MOBILE && $items_skin_arr[1]) $items_skin = $items_skin_arr[1];
$items_cols = $this->items_cols;
$items_gap = $this->items_gap;
$items_radius = $this->items_radius;
$items_sel_li_id = $this->items_sel_li_id;
$_get_item_option = '';
$_get_item_option .= strpos($_items_skin, '외곽선') !== false ? ' itemOutline' : '';
$_get_item_option .= strpos($_items_skin, '그림자') !== false ? ' itemShadow' : '';
if($items_cols <= 1.7 && $items_skin != '_wz') $_get_item_option .= ' itemSize_large';
if($items_cols > 2.25 && $items_cols < 5 && $items_skin != '_wz') $_get_item_option .= ' itemSize_small';
if($items_cols >= 5 && $items_skin != '_wz') $_get_item_option .= ' itemSize_mini';
if( count($list) < $items_cols ) $_get_item_option .= ' not-enough';

$i = 0;
foreach((array) $list as $row){
	if($row['it_use_show'] == 0){
		if( empty($row) ) continue;

		$item_link_href = shop_item_url($row['it_id']);     // 상품링크
		$star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
		$is_soldout = is_soldout($row['it_id'], true);   // 품절인지 체크


		//실판매가격 업데이트
		update_real_price($row['it_id']);

		if ($i == 0) {
			if($items_skin == '_slide') {
				echo '<div class="itemsContainer '.$items_skin.$_get_item_option.' mySwiper" data-per="'.$items_cols.'" data-gap="'.$items_gap.'" data-loop="false"'.($items_radius?' style="--items-radius:'.$items_radius.'px;"':'').'>';
					echo '<div class="swiper-container">';
						echo '<div class="swiper-wrapper">';
			} else {
				echo '<ul class="itemsContainer '.$items_skin.$_get_item_option.'" data-cols="'.($items_cols?$items_cols:'2').'" style="'.($items_gap?'--item-gap:'.$items_gap.'px;':'').($items_radius?'--items-radius:'.$items_radius.'px;':'').'" data-gap="'.($items_gap?$items_gap:'15').'">';
			}
		}

		echo $items_skin == '_slide' ? '<div class="swiper-slide item-list sct_li">' : '<li class="item-list sct_li">';
			if($this->view_it_img) {
				$itemtype_tag = '';
				$itemtype = explode("|", $default['itemtype']);
				$itemtype_color = explode("|", $default['itemtype_color']);
				for ($t=0; $t < count($itemtype); $t++) {
					$num = $t + 1;
					if($row['it_type'.$num]) $itemtype_tag .= '<span class="itemtype_tag"'.($itemtype_color[$t]?' style="background:'.$itemtype_color[$t].';"':'').'>'.$itemtype[$t].'</span>';
				}
				if($itemtype_tag) echo '<div class="itemtype-tag-set">'.$itemtype_tag.'</div>';
					
				echo '<div class="thumb img-hover">';
					if($this->href) echo '<a href="'.$item_link_href.'">';
					$it_width = $this->img_width;
					$it_height = get_it_height($it_width);
	//				$it_height = 450;
					echo get_it_image($row['it_id'], $this->img_width, $it_height, '', '', stripslashes($row['it_name']) , true);
					if($this->href) echo '</a>';
					if($is_soldout) echo '<span class="shop_icon_soldout"><span class="soldout_txt" style="position:absolute;top:0px;left:0px;color:#000;background:rgba(255, 255, 255, 0.8);width:100%;height:100%;text-align:center;padding-top:60%">SOLD OUT</span></span>';
					$it_timer_arr[$i] = explode('|', $row['it_timer']);
					if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
					if(!$is_soldout) echo '<div class="sct_btn list-10-btn"><button type="button" class="btn_cart sct_cart" data-it_id="'.$row['it_id'].'">장바구니</button></div>';
					//echo '<div class="cart-layer"></div>';
					//$it_timer_arr[$i] = explode('|', $row['it_timer']);
					//if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
					/*echo '<div class="sit_set">';
						echo '<button class="sit_btn_wish" data-id="'.$row['it_id'].'">찜하기</button>';
						if(get_wish_item_count($row['it_id'])) echo '<div class="wishCount">좋아요'.get_wish_item_count($row['it_id']).'</div>';
					echo '</div>';*/
				echo '</div>';
			}
			echo '<div class="itemCon">';
				echo '<div class="head">';
					//$it_timer_arr[$i] = explode('|', $row['it_timer']);
					//if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
					if($this->view_it_name) {
						echo '<div class="subject">';
						if($this->href) echo '<a href="'.$item_link_href.'">';
						echo stripslashes($row['it_name']);
						if($this->href) echo '</a>';
						echo '</div>';
					}
				echo '</div>';
				if($row['it_basic'] && !G5_IS_MOBILE) echo '<div class="item_basic">'.$row['it_basic'].'</div>'; //모바일에서 설명글 삭제
				if($this->view_it_price) {
					echo '<div class="priceInfo">';

					if($row['it_tel_inq']){
						echo '<span class="price">'.$row['it_tel_inq_text'].'</span>';
					}else{
						if($config['cf_grade'] == 1 && $mbg['g_discount'] > 0){ //할인율이 존재할경우
							if($row['it_grade']){
								$prii = $row['it_cust_price']?$row['it_cust_price']:$row['it_price'];
								$discount_rate = round(($prii - get_price($row)) / $prii * 100);
								//$discount_rate = round(($row['it_price'] - get_price($row)) / $row['it_price'] * 100);
								echo '<span class="price before">'.display_price($prii).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';	
							}else{
								$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
								echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';
							}
							echo '<span class="price">'.display_price(get_price($row)).'</span>';
						}else{
							if(get_time_price($row['it_id'])) {
								$prii = $row['it_cust_price']?$row['it_cust_price']:$row['it_price'];
								$discount_rate = round(($prii - get_price($row)) / $prii * 100);
								echo '<span class="price before">'.display_price($prii).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';				
								echo '<span class="price">'.display_price(get_price($row)).'</span>';
							}else{
								if($row['it_cust_price']){
									if($row['it_cust_price']) echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
									$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
									if($row['it_cust_price']) echo '<span class="rate">'.$discount_rate.'%</span>';
									//echo '<span class="price">'.display_price(get_price($row), $row['it_tel_inq']).'</span>';
									echo '<span class="price">'.display_price(get_price($row)).'</span>';
								}else{
									//$discount_rate = round(($row['it_price'] - get_price($row)) / $row['it_price'] * 100);
									//echo '<span class="price before">'.display_price($row['it_price']).'</span>';
									//echo '<span class="rate">'.$discount_rate.'%</span>';				
									echo '<span class="price">'.display_price(get_price($row)).'</span>';
								}
							}
						}
					}
					echo '</div>';
				}
				echo get_it_tag($row['it_id'], 4);
			echo '</div>';
			if($is_shop_manager) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$row['it_id'].'&amp;ca_id='.$row['ca_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
		echo $items_skin == '_slide' ? '</div>' : '</li>';

		$i++;
	}
}
if($i > 0) {
	if($items_skin == '_slide') {
				echo '</div>';
			echo '</div>';
			if ($i > 1) {
				echo '<div class="prev"></div>'.PHP_EOL;
				echo '<div class="next"></div>'.PHP_EOL;
			}
		echo '</div>';
	} else {
		echo '</ul>';
	}
}

//if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
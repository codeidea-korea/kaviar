<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);

// 장바구니 또는 위시리스트 ajax 스크립트
add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);
$mba = sql_fetch("select * from `g5_member_grade` where idx = '".$member['mb_grade']."' ");

$_get_item_option = '';
$_get_item_option .= $list_mod <= 1 ? ' _wz' : ' _gall';
if($list_mod > 2.25) $_get_item_option .= ' itemSize_small';

$listtype_card_script = isset($_SERVER['SCRIPT_NAME']) ? str_replace('\\', '/', $_SERVER['SCRIPT_NAME']) : '';
$listtype_card_type = isset($_GET['type']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['type']) : '';
$listtype_card_width = isset($default['de_listtype_card_width']) ? (int)$default['de_listtype_card_width'] : 0;
$listtype_card_enabled = !G5_IS_MOBILE && preg_match('#/shop/listtype\.php$#', $listtype_card_script) && $listtype_card_type === '1' && $listtype_card_width > 0;
$listtype_card_style = '';
if($listtype_card_enabled) {
	$_get_item_option .= ' cardSize_control';
	$listtype_card_gap = 16;
	$listtype_card_cols = is_numeric($list_mod) && $list_mod > 0 ? (float)$list_mod : 4;
	$listtype_card_list_width = ceil(($listtype_card_width * $listtype_card_cols) + ($listtype_card_gap * max(0, $listtype_card_cols - 1)));
	$listtype_card_style = ' style="--card-max-width:'.$listtype_card_width.'px;--card-list-width:'.$listtype_card_list_width.'px;"';
}
?>

<!-- 상품진열 10 시작 { -->
<?php
$i = 0;

$this->view_star = (method_exists($this, 'view_star')) ? $this->view_star : true;

foreach((array) $list as $row){
	if($row['it_use_show'] == 0){
		if( empty($row) ) continue;

		$item_link_href = shop_item_url($row['it_id']);     // 상품링크
		$star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
		$list_mod = $this->list_mod;    // 분류관리에서 1줄당 이미지 수 값 또는 파일에서 지정한 가로 수
		$is_soldout = is_soldout($row['it_id'], true);   // 품절인지 체크

		/*$classes = array();

		$classes[] = 'col-row-'.$list_mod;

		if( $i && ($i % $list_mod == 0) ){
			$classes[] = 'row-clear';
		}*/
		
		$i++;   // 변수 i 를 증가

		if ($i === 1) {
			echo '<ul class="itemsContainer '.$_get_item_option.'" data-cols="'.$list_mod.'" data-gap="16"'.$listtype_card_style.'>';
			//echo '<ul class="itemsContainer _gall '.$items_skin.$_get_item_option.'" data-cols="'.($items_cols?$items_cols:'2').'" style="'.($items_gap?'--item-gap:'.$items_gap.'px;':'').($items_radius?'--items-radius:'.$items_radius.'px;':'').'" data-gap="'.($items_gap?$items_gap:'15').'">';
		}
		
		echo '<li class="item-list sct_li">';
			if($listtype_card_enabled) echo '<div class="itemCardInner">';
			if($this->view_it_img) {
				$itemtype_tag = '';
				$itemtype = explode("|", $default['itemtype']);
				$itemtype_color = explode("|", $default['itemtype_color']);
				for ($t=0; $t < count($itemtype); $t++) {
					$num = $t + 1;
					if($row['it_type'.$num]) $itemtype_tag .= '<span class="itemtyp_tag"'.($itemtype_color[$t]?' style="background:'.$itemtype_color[$t].';"':'').'>'.$itemtype[$t].'</span>';
				}
				if($itemtype_tag) echo '<div class="itemtype-tag-set">'.$itemtype_tag.'</div>';
				
				echo '<div class="thumb img-hover">';
					if($this->href) echo '<a href="'.$item_link_href.'">';
					$it_width = $this->img_width;
					$it_height = get_it_height($it_width);				
					//echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
					echo get_it_image($row['it_id'], $this->img_width, $it_height, '', '', stripslashes($row['it_name']))."\n";
					if($this->href) echo '</a>';
					if($is_soldout) echo '<span class="shop_icon_soldout"><span class="soldout_txt"  style="position:absolute;top:0px;left:0px;color:#000;background:rgba(255, 255, 255, 0.8);width:100%;height:100%;text-align:center;padding-top:63%">SOLD OUT</span></span>';
					
					if($row['it_timer_start'] <= date("Y-m-d H:i:s") && $row['it_timer'] >= date("Y-m-d H:i:s") ){
						$it_timer_arr[$i] = explode('|', $row['it_timer']);
						if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
					}
					
					//$it_timer_arr[$i] = explode('|', $row['it_timer']);
					//if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
					
					if(!$is_soldout){    // 품절 상태가 아니면 출력합니다.
						echo '<div class="sct_btn"><button type="button" class="btn_cart sct_cart" data-it_id="'.$row['it_id'].'">장바구니</button></div>';
					}
					echo '<div class="cart-layer"></div>';
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
				if($row['it_basic']) echo '<div class="item_basic">'.$row['it_basic'].'</div>';
				if($this->view_it_price) {
					echo '<div class="priceInfo">';
					if($row['it_tel_inq']){
						echo '<span class="price">'.$row['it_tel_inq_text'].'</span>';
					}else{
						if($config['cf_grade'] == 1 && $mba['g_discount'] > 0){ //할인율이 존재할경우
							if($row['it_grade']){
								$prii = $row['it_cust_price']?$row['it_cust_price']:$row['it_price'];
								$discount_rate = round(($prii - get_price($row)) / $prii * 100);
								echo '<span class="price before">'.display_price($row['it_cust_price']?$row['it_cust_price']:$row['it_price']).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';	
							}else{
								$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
								echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';
							}
							echo '<span class="price">'.display_price(get_price($row)).'</span>';
	/*
							$prii = $row['it_cust_price']?$row['it_cust_price']:$row['it_price'];
							//$discount_rate = round(($row['it_price'] - get_price($row)) / $row['it_price'] * 100);
							$discount_rate = round(($prii - get_price($row)) / $prii * 100);
							echo '<span class="price before">'.display_price($row['it_cust_price']?$row['it_cust_price']:$row['it_price']).'</span>';
							if($row['it_price']) echo '<span class="rate">'.$discount_rate.'%</span>';				
							echo '<span class="price">'.display_price(get_price($row)).'</span>';*/
						}else{
							
							if(get_time_price($row['it_id'])) {
								$prii = $row['it_cust_price']?$row['it_cust_price']:$row['it_price'];
								$discount_rate = round(($prii - get_price($row)) / $prii * 100);
								echo '<span class="price before">'.display_price($prii).'</span>';
								echo '<span class="rate">'.$discount_rate.'%</span>';				
								echo '<span class="price">'.display_price(get_price($row)).'</span>';
							}else{
								if($row['it_cust_price']){
									$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
									if($row['it_cust_price']) echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
									if($row['it_cust_price']) echo '<span class="rate">'.$discount_rate.'%</span>';				
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
			if($listtype_card_enabled) echo '</div>';
		echo '</li>';
	}
}

if ($i >= 1) echo "</ul>\n";

///////////////////////////////////////////////////////////////////////////

/*
foreach((array) $list as $row){
    if( empty($row) ) continue;

    $item_link_href = shop_item_url($row['it_id']);     // 상품링크
    $star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
    $list_mod = $this->list_mod;    // 분류관리에서 1줄당 이미지 수 값 또는 파일에서 지정한 가로 수
    $is_soldout = is_soldout($row['it_id'], true);   // 품절인지 체크

    $classes = array();

    $classes[] = 'col-row-'.$list_mod;

    if( $i && ($i % $list_mod == 0) ){
        $classes[] = 'row-clear';
    }
    
    $i++;   // 변수 i 를 증가

    if ($i === 1) {
        if ($this->css) {
            echo "<ul class=\"{$this->css}\">\n";
        } else {
            echo "<ul class=\"sct sct_10 lists-row\">\n";
        }
    }
	
    echo "<li class=\"sct_li ".implode(' ', $classes)."\" data-css=\"nocss\" style=\"height:auto\">\n";
	echo "<div class=\"sct_img\">\n";

    if ($this->href) {
        echo "<a href=\"{$item_link_href}\">\n";
    }

    if ($this->view_it_img) {
        echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
    }

    if ($this->href) {
        echo "</a>\n";
    }
    
    if ( !$is_soldout ){    // 품절 상태가 아니면 출력합니다.
        echo "<div class=\"sct_btn list-10-btn\">
            <button type=\"button\" class=\"btn_cart sct_cart\" data-it_id=\"{$row['it_id']}\"><i class=\"fa fa-shopping-cart\" aria-hidden=\"true\"></i> 장바구니</button>\n";
        echo "</div>\n";
	}

	echo "<div class=\"cart-layer\"></div>\n";
	
	if ($this->view_it_icon) {
        // 품절
        if ($is_soldout) {
            echo '<span class="shop_icon_soldout"><span class="soldout_txt">SOLD OUT</span></span>';
        }
    }
    echo "</div>\n";
	
	echo "<div class=\"sct_ct_wrap\">\n";
    
	// 사용후기 평점표시
	if ($this->view_star && $star_score) {
        echo "<div class=\"sct_star\"><span class=\"sound_only\">고객평점</span><img src=\"".G5_SHOP_URL."/img/s_star".$star_score.".png\" alt=\"별점 ".$star_score."점\" class=\"sit_star\"></div>\n";
    }
	
    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }

    if ($this->href) {
        echo "<div class=\"sct_txt\"><a href=\"{$item_link_href}\">\n";
    }

    if ($this->view_it_name) {
        echo stripslashes($row['it_name'])."\n";
    }

    if ($this->href) {
        echo "</a></div>\n";
    }
	
	if ($this->view_it_basic && $row['it_basic']) {
        echo "<div class=\"sct_basic\">".stripslashes($row['it_basic'])."</div>\n";
    }

    echo "<div class=\"sct_bottom\">\n";

        if ($this->view_it_cust_price || $this->view_it_price) {

            echo "<div class=\"sct_cost\">\n";
            if ($this->view_it_price) {
                echo display_price(get_price($row), $row['it_tel_inq'])."\n";
            }
            if ($this->view_it_cust_price && $row['it_cust_price']) {
                echo "<span class=\"sct_dict\">".display_price($row['it_cust_price'])."</span>\n";
            }
            echo "</div>\n";
        }
        
        // 위시리스트 + 공유 버튼 시작
        echo "<div class=\"sct_op_btn\">\n";
        echo "<button type=\"button\" class=\"btn_wish\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">위시리스트</span><i class=\"fa fa-heart-o\" aria-hidden=\"true\"></i></button>\n";
        if ($this->view_sns) {
            echo "<button type=\"button\" class=\"btn_share\"><span class=\"sound_only\">공유하기</span><i class=\"fa fa-share-alt\" aria-hidden=\"true\"></i></button>\n";
        }
        
        echo "<div class=\"sct_sns_wrap\">";
        if ($this->view_sns) {
            $sns_top = $this->img_height + 10;
            $sns_url  = $item_link_href;
            $sns_title = get_text($row['it_name']).' | '.get_text($config['cf_title']);
            echo "<div class=\"sct_sns\">";
            echo "<h3>SNS 공유</h3>";
            echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/facebook.png');
            echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/twitter.png');
            echo get_sns_share_link('googleplus', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/gplus.png');
            echo "<button type=\"button\" class=\"sct_sns_cls\"><span class=\"sound_only\">닫기</span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>";
            echo "</div>\n";
        }
        echo "<div class=\"sct_sns_bg\"></div>";
        echo "</div></div>\n";
        // 위시리스트 + 공유 버튼 끝
	
    echo "</div>";

        if ($this->view_it_icon) {
            echo "<div class=\"sit_icon_li\">".item_icon($row)."</div>\n";
        }

	echo "</div>\n";
	
    echo "</li>\n";
}   //end foreach

if ($i >= 1) echo "</ul>\n";
*/

if ($i === 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 10 끝 -->

<script>
//SNS 공유
$(function (){
	$(".btn_share").on("click", function() {
		$(this).parent("div").children(".sct_sns_wrap").show();
	});
    $('.sct_sns_bg, .sct_sns_cls').click(function(){
        $('.sct_sns_wrap').hide();
	});
});			
</script>

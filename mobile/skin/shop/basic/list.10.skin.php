<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
//add_stylesheet('<link rel="stylesheet" href="'.G5_MSHOP_SKIN_URL.'/style.css">', 0);

// 장바구니 또는 위시리스트 ajax 스크립트
add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);

$_get_item_option = '';
$_get_item_option .= $list_mod <= 1 ? ' _wz' : ' _gall';
if($list_mod > 2.25) $_get_item_option .= ' itemSize_small';
?>

<?php if(!defined('G5_IS_SHOP_AJAX_LIST') && $config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js" async></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<!-- 메인상품진열 10 시작 { -->
<?php
$i = 0;
foreach((array) $list as $row){
	if( empty($row) ) continue;

	$item_link_href = shop_item_url($row['it_id']);     // 상품링크
	$star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
	$is_soldout = is_soldout($row['it_id'], true);   // 품절인지 체크
	$list_mod = $this->list_mod;
	$list_mod = $list_mod ? $list_mod : 2;

	//실판매가격 업데이트
	update_real_price($row['it_id']);

	if ($i == 0) echo '<ul class="itemsContainer p15 '.$_get_item_option.'" data-cols="'.$list_mod.'" data-gap="14">';

	echo '<li class="item-list">';
		if($this->view_it_img) {
			$it_width = $this->img_width;
			$it_height = get_it_height($it_width);	
			echo '<div class="thumb">';
				if($this->href) echo '<a href="'.$item_link_href.'">';
				//echo get_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name']))."\n";
				echo get_it_image($row['it_id'], $this->img_width, $it_height, '', '', stripslashes($row['it_name']))."\n";
				if($this->href) echo '</a>';
				if ($is_soldout) echo '<span class="shop_icon_soldout"><span class="soldout_txt">SOLD OUT</span></span>';
			echo '</div>';
		}
		echo '<div class="itemCon">';
			$it_timer_arr[$i] = explode('|', $row['it_timer']);
			if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
			if($this->view_it_name) {
				echo '<div class="subject">';
				if($this->href) echo '<a href="'.$item_link_href.'">';
					echo $is_closedmall ? '<span class="it_name_hide"></span>' : stripslashes($row['it_name']);
				if($this->href) echo '</a>';
				echo '</div>';
			}	
			if($this->view_it_price) {
				echo '<div class="priceInfo">';
					if($is_closedmall) {
						echo '<span class="color-gray">-</span>';
					} else if($row['it_tel_inq']) { // 전화문의일 경우
						echo '<span class="price">'.$row['it_tel_inq_text'].'</span>';
					} else {
						//$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
						//if($row['it_cust_price']) echo '<span class="rate">'.$discount_rate.'%</span>';
						if($row['it_cust_price']) echo '<span class="rate">'.get_discount_rate(get_price($row), $row['it_cust_price']).'</span>';
						echo '<span class="price">'.display_price(get_price($row), $row['it_tel_inq']).($default['use_item_price_deco']?' ~':'').'</span>';	
						if($row['it_cust_price']) echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
					}
				echo '</div>';
			}
		echo '</div>';
		if($is_shop_manager) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$row['it_id'].'&amp;ca_id='.$row['ca_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
	echo '</li>';

	$i++;
}
if($i > 0) echo '</ul>';

if($i == 0) echo "<p class=\"sct_noitem\">등록된 상품이 없습니다.</p>\n";
?>
<!-- } 상품진열 10 끝 -->

<?php if( !defined('G5_IS_SHOP_AJAX_LIST') ) { ?>
<script>
jQuery(function($){
    var li_width = "<?php echo intval(100 / $this->list_mod); ?>",
        img_width = "<?php echo $this->img_width; ?>",
        img_height = "<?php echo $this->img_height; ?>",
        list_ca_id = "<?php echo $this->ca_id; ?>";

    function shop_list_type_fn(type){
        var $ul_sct = $("ul.sct");

        if(type == "gallery") {
            $ul_sct.removeClass("sct_10_list").addClass("sct_10")
            .find(".sct_li").attr({"style":"width:"+li_width+"%"});
        } else {
            $ul_sct.removeClass("sct_10").addClass("sct_10_list")
            .find(".sct_li").removeAttr("style");
        }
        
        if (typeof g5_cookie_domain != 'undefined') {
            set_cookie("ck_itemlist"+list_ca_id+"_type", type, 1, g5_cookie_domain);
        }
    }

    $("button.sct_lst_view").on("click", function() {
        var $ul_sct = $("ul.sct");

        if($(this).hasClass("sct_lst_gallery")) {
            shop_list_type_fn("gallery");
        } else {
            shop_list_type_fn("list");
        }
    });

    //SNS 공유
	$(document).on("click", ".btn_share", function(e) {
		$(this).parent("div").children(".sct_sns_wrap").show();
	})
    .on("click", ".sct_sns_bg, .sct_sns_cls", function(e) {
	    $('.sct_sns_wrap').hide();
	});
});
</script>
<?php }
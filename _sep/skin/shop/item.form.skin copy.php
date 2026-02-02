<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);

if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?pn=_shop_item_setting&title=상품 관리&it_id='.$it['it_id'].'" id="itemSetting" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area="#sit">상품 관리</a>';

$tmp_cart_ids = get_session('ss_cart_id');
$chk_ct = sql_fetch(" select count(*) as count from {$g5['g5_shop_cart_table']} where od_id = '$tmp_cart_ids' and it_id != '".$it['it_id']."' and mb_id = '".$member['mb_id']."' ");
$mbg = sql_fetch("select * from `g5_member_grade` where idx = '".$member['mb_grade']."' ");
?>


<div id="sit_ov_from">
	

	<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return;">
	<!--
	<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
	-->
	<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
	<input type="hidden" name="sw_direct">
	<input type="hidden" name="cart_all">
	<input type="hidden" name="url">
	<input type="hidden" name="chk_ct" value="<?=$chk_ct['count']?>">
	
	<div id="sit_ov_wrap">
	    
	    <div id="sit_pvi">
			<?php
			echo '<div id="sit_pvi_big">';				
				$big_img_count = 0;
				$thumbnails = array();
				for($i=1; $i<=10; $i++) {
					if(!$it['it_img'.$i])
						continue;
		
					//$img = get_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);
					$img = get_it_thumbnail($it['it_img'.$i], 530, get_it_height(530));
		
					if($img) {
						// 썸네일
						$thumb = get_it_thumbnail($it['it_img'.$i], 70, 70, '', true);
						$thumbnails[] = $thumb;
						$big_img_count++;
		
						echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" target="_blank" class="popup_item_image">'.$img.'</a>';
					}
				}
		
				if($big_img_count == 0) echo '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
	        echo '</div>';

			if($it['it_use']) {
				//특가 타이머
				$it_timer = explode('|', $it['it_timer']);
				if($it_timer[0] && get_buy_timer($it['it_id'])) {
					echo '<div id="buyTimerContainer"><span class="title">남은 시간</span>';
						echo get_buy_timer($it['it_id']);
					echo '</div>';
				}
			}

	        // 썸네일
	        $thumb1 = true;
	        $thumb_count = 0;
	        $total_count = count($thumbnails);
	        if($total_count > 0) {
	            echo '<ul id="sit_pvi_thumb">';
	            foreach($thumbnails as $val) {
	                $thumb_count++;
	                $sit_pvi_last ='';
	                if ($thumb_count % 5 == 0) $sit_pvi_last = 'class="li_last"';
	                    echo '<li '.$sit_pvi_last.'>';
	                    echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$thumb_count.'" target="_blank" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
	                    echo '</li>';
	            }
	            echo '</ul>';
	        }
			
	        ?>
	    </div>

	    <section id="sit_ov" class="2017_renewal_itemform">
			
			<div id="_sit_head">
				<?php if($it['it_store_id']) {
					$store_img_path = G5_DATA_PATH.'/store/store_'.$it['it_store_id'].'.png';
					$store_img_url = G5_DATA_URL.'/store/store_'.$it['it_store_id'].'.png';
					$store = sql_fetch("select * from {$g5['g5_shop_store_table']} where store_id = {$it['it_store_id']}");
					echo '<div id="sit_store">';
						if($store['store_url']) echo '<a href="'.$store['store_url'].'">';
							echo file_exists($store_img_path) ? '<img src="'.$store_img_url.'?'.preg_replace('/[^0-9]/i', '', $store['store_time']).'">' : '<span class="tag">'.$store['store_subject'].'</span>';					
						if($store['store_url']) echo '</a>';
					echo '</div>';
				} ?>
				<h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
				<p id="sit_desc"><?php echo $it['it_basic']; ?></p>

				<?=get_it_tag($it['it_id']);?>

				<?php
				if($it['it_use']) {
					echo '<div id="sit_priceInfo">';
					
						if($it['it_tel_inq']){
							echo '<span class="price">'.$it['it_tel_inq_text'].'</span>';
						}else{
							if($config['cf_grade'] == 1 && $mbg['g_discount'] > 0){ //할인율이 존재할경우
								if($it['it_grade']){
                                    
									$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
									echo '<span class="price before">'.display_price($it['it_price']).'</span>';
									echo '<br><span class="rate" style="padding-right: 20px;">'.$discount_rate.'%</span>';	
								}else{
									$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
									echo '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
									echo '<br><span class="rate" style="padding-right: 20px;">'.$discount_rate.'%</span>';
								}
								echo '<span class="price">'.display_price(get_price($it)).'</span>';
							}else{
								if($it['it_cust_price']){
									if($it['it_cust_price']) echo '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
									$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
									if($it['it_cust_price']) echo '<br><span class="rate" style="padding-right: 20px;">'.$discount_rate.'%</span>';
									//echo '<span class="price">'.display_price(get_price($it), $it['it_tel_inq']).'</span>';
									echo '<span class="price">'.display_price(get_price($it)).'</span>';
								}else{
									//$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
									//echo '<span class="price before">'.display_price($it['it_price']).'</span>';
									//echo '<br><span class="rate" style="padding-right: 20px;">'.$discount_rate.'%</span>';				
									echo '<span class="price">'.display_price(get_price($it)).'</span>';
								}
							}
						}

/*
				if($it['it_tel_inq']){
					echo '<span class="price">'.$it['it_tel_inq_text'].'</span>';
				}else{
					if($config['cf_grade'] == 1 && $mbg['g_discount'] > 0){ //할인율이 존재할경우
						if($it['it_grade']){
							$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
							echo '<span class="price before">'.display_price($it['it_price']).'</span>';
							echo '<span class="rate">'.$discount_rate.'%</span>';	
						}else{
							$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
							echo '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
							echo '<span class="rate">'.$discount_rate.'%</span>';
						}
						echo '<span class="price">'.display_price(get_price($it)).'</span>';
					}else{
						if($it['it_cust_price']){
							if($it['it_cust_price']) echo '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
							$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
							if($it['it_cust_price']) echo '<span class="rate">'.$discount_rate.'%</span>';
							//echo '<span class="price">'.display_price(get_price($it), $it['it_tel_inq']).'</span>';
							echo '<span class="price">'.display_price(get_price($it)).'</span>';
						}else{
							//$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
							//echo '<span class="price before">'.display_price($it['it_price']).'</span>';
							//echo '<span class="rate">'.$discount_rate.'%</span>';				
							echo '<span class="price">'.display_price(get_price($it)).'</span>';
						}
					}
				}
				*/

					echo '</div>';
					
				} else {
					echo '<div class="fs18 fw600 mt15">판매중지</div>';
				}
				echo '<input type="hidden" id="it_price" value="'.get_price($it).'?>">';

				if($it['it_origin']) {
					echo '<div class="fs22 fw500 mt20">';
						echo '<div class="">원산지 : '.$it['it_origin'].'</div>';
					echo '</div>';
				}

				if($is_orderable) echo '<p id="sit_opt_info">상품 선택옵션 '.$option_count.' 개, 추가옵션 '.$supply_count.' 개</p>';

				//상품 기본 정보
				if($it['it_maker'] || $it['it_brand'] || $it['it_model_show']) {
					echo '<div class="productInfo">';
						echo '<div class="title">상품 기본정보</div>';
						echo '<div class="fx-wrap label140">';				
						if($it['it_maker']) {
							echo '<div class="fx-list">';
								echo '<div class="fx-list-label">제조사</div>';
								echo '<div class="fx-list-con">'.$it['it_maker'].'</div>';
							echo '</div>';
						}
						if($it['it_brand']) {
							echo '<div class="fx-list">';
								echo '<div class="fx-list-label">브랜드</div>';
								echo '<div class="fx-list-con">'.$it['it_brand'].'</div>';
							echo '</div>';
						}
						if($it['it_model_show']) {
							echo '<div class="fx-list">';
								echo '<div class="fx-list-label">모델</div>';
								echo '<div class="fx-list-con">'.$it['it_model'].'</div>';
							echo '</div>';
						}
						echo '</div>';
					echo '</div>';
				}

				//상품정보1
				$item_info1_subject = explode("|", $it['item_info1_subject']);
				$item_info1_value = explode("|", $it['item_info1_value']);
				$info1_list = '';
				for ($i=0; $i < count($item_info1_subject); $i++) {
					if($item_info1_subject[$i] && $item_info1_value[$i]) {
						$info1_list .= '<div class="fx-list">';
						$info1_list .= '<div class="fx-list-label">'.$item_info1_subject[$i].'</div>';
						$info1_list .= '<div class="fx-list-con">'.$item_info1_value[$i].'</div>';
						$info1_list .= '</div>';
					}
				}
				if($info1_list) {
					echo '<div class="productInfo">';
						echo '<div class="title">'.($it['item_info1_label']?$it['item_info1_label']:'상품정보').'</div>';
						echo '<div class="fx-wrap label140">';
							echo $info1_list;
						echo '</div>';
					echo '</div>';
				}
				//상품정보2
				$item_info2_subject = explode("|", $it['item_info2_subject']);
				$item_info2_value = explode("|", $it['item_info2_value']);
				$info2_list = '';
				for ($i=0; $i < count($item_info2_subject); $i++) {
					if($item_info2_subject[$i] && $item_info2_value[$i]) {
						$info2_list .= '<div class="fx-list">';
						$info2_list .= '<div class="fx-list-label">'.$item_info2_subject[$i].'</div>';
						$info2_list .= '<div class="fx-list-con">'.$item_info2_value[$i].'</div>';
						$info2_list .= '</div>';
					}
				}
				if($info2_list) {
					echo '<div class="productInfo">';
						echo '<div class="title">'.($it['item_info2_label']?$it['item_info2_label']:'상품정보').'</div>';
						echo '<div class="fx-wrap label140">';
							echo $info2_list;
						echo '</div>';
					echo '</div>';
				}
				//상품정보3
				$item_info3_subject = explode("|", $it['item_info3_subject']);
				$item_info3_value = explode("|", $it['item_info3_value']);
				$info3_list = '';
				for ($i=0; $i < count($item_info3_subject); $i++) {
					if($item_info3_subject[$i] && $item_info3_value[$i]) {
						$info3_list .= '<div class="fx-list">';
						$info3_list .= '<div class="fx-list-label">'.$item_info3_subject[$i].'</div>';
						$info3_list .= '<div class="fx-list-con">'.$item_info3_value[$i].'</div>';
						$info3_list .= '</div>';
					}
				}
				if($info3_list) {
					echo '<div class="productInfo">';
						echo '<div class="title">'.($it['item_info3_label']?$it['item_info3_label']:'상품정보').'</div>';
						echo '<div class="fx-wrap label140">';
							echo $info3_list;
						echo '</div>';
					echo '</div>';
				}
				?>			

				<?php if(!$it['it_type']) { ?>
				<div class="productInfo">
					<div class="title">배송 정보</div>			
					<div class="fx-wrap label140">
						<?php if($default['de_baesong_content']) { ?>
						<div class="fx-list">
							<div class="fx-list-label">배송</div>
							<div class="fx-list-con"><?= conv_content($default['de_baesong_content'], 1)?></div>
						</div>
						<?php } ?>
						<div class="fx-list">
							<div class="fx-list-label">배송비</div>
							<div class="fx-list-con">
								<?php if($it['it_sc_type'] == 0) { //쇼핑몰 기본설정
									if($default['de_send_cost_case']=='무료') {
										echo '무료배송';
									} else if($default['de_send_cost_case']=='차등') {
										//echo '금액별차등';
										$tmp_de_send_cost_limit = $default['de_send_cost_limit'] / 10000;
										echo '무료배송 ('.$tmp_de_send_cost_limit.'만원 이상 주문시)';
										$de_send_cost_list = explode(';', $default['de_send_cost_list']);
										echo '<span class="color-gray ml15">'.display_price1(end($de_send_cost_list)).' ~ '.display_price1($de_send_cost_list[0]).'</span>';
									}

								} else if($it['it_sc_type'] == 1) { //무료배송
									echo '무료배송';

								} else if($it['it_sc_type'] == 2) { //조건부 무료배송
									echo display_price1($it['it_sc_price']);
									echo '<span class="color-slate-500 ml5">(';
									if($it['it_sc_method']==0)
										echo '선불';
									else if($it['it_sc_method']==1)
										echo '착불';
									else if($it['it_sc_method']==2)
										echo '사용자 선택';
									echo ')</span>';
									if($it['it_sc_minimum']) echo '<br><span class="color-blue">주문금액 '.display_price1($it['it_sc_minimum']).' 이상 무료배송</span>';

								} else if($it['it_sc_type'] == 3) { //유료배송
									echo display_price1($it['it_sc_price']);
									echo '<span class="color-slate-500 ml5">(';
									if($it['it_sc_method']==0)
										echo '선불';
									else if($it['it_sc_method']==1)
										echo '착불';
									else if($it['it_sc_method']==2)
										echo '사용자 선택';
									echo ')</span>';
								} else if($it['it_sc_type'] == 4) { //수량별 부솨
									echo '기본배송비 - '.display_price1($it['it_sc_price']);
									echo '<span class="color-slate-500 ml5">(';
									if($it['it_sc_method']==0)
										echo '선불';
									else if($it['it_sc_method']==1)
										echo '착불';
									else if($it['it_sc_method']==2)
										echo '사용자 선택';
									echo ')</span>';

									if($it['it_sc_qty']) echo '<br><span class="color-orange">주문수량×'.$it['it_sc_qty'].' 마다 배송비가 부과됩니다.</span>';
								}						
								?>
							</div>
						</div>
						<div class="fx-list">
							<div class="fx-list-label">택배사</div>
							<div class="fx-list-con"><?=$default['de_delivery_company']?></div>
						</div>
					</div>
					<!-- //배송정보 (에디터 내용)를 출력하려면 여기 주석을 해제
					<div class="mt15"><?php echo conv_content($default['de_baesong_content'], 1); ?></div>
					-->
				</div>
				<?php } ?>

				<?php if($config['cf_use_point'] || $it['it_buy_min_qty'] || $it['it_buy_max_qty']) {
					echo '<div class="productInfo">';
						echo '<div class="title">상품 주문 정보</div>';
						echo '<div class="fx-wrap label140">';
							if($config['cf_use_point']) { // 포인트 사용한다면
								echo '<div class="fx-list">';
									echo '<div class="fx-list-label">포인트</div>';
									echo '<div class="fx-list-con">';
										if($it['it_point_type'] == 2) {
											echo '구매금액(추가옵션 제외)의 '.$it['it_point'].'%';
										} else {
											$it_point = get_item_point($it);
											echo number_format($it_point).'점';
										}
									echo '</div>';
								echo '</div>';
							}
							if($it['it_buy_min_qty']) {
								echo '<div class="fx-list">';
									echo '<div class="fx-list-label">최소구매수량</div>';
									echo '<div class="fx-list-con">'.number_format($it['it_buy_min_qty']).' 개</div>';
								echo '</div>';
							}						
							if($it['it_buy_max_qty']) {
								echo '<div class="fx-list">';
									echo '<div class="fx-list-label">최대구매수량</div>';
									echo '<div class="fx-list-con">'.number_format($it['it_buy_max_qty']).' 개</div>';
								echo '</div>';
							}
						echo '</div>';
					echo '</div>';
				} ?>

				<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_item_config&title=상품 기본정보 관리&it_id='.$it['it_id'].'" class="edit-block btnSetting popWin" data-width="900" data-height="600" data-top="60" data-left="0" data-area=".productInfo">상품 기본정보 관리</a>'; ?>
			</div>
	   
	        <?php
			echo '<div id="_sit_option">';
				//echo '<div class="title">선택옵션</div>';
				echo '<div class="fx-wrap label140">';
					
					echo '<div class="fx-list">';
						echo '<div class="fx-list-label">상품선택</div>';
						echo '<div class="fx-list-con">';

							if($option_item) { //선택 옵션
								echo '<section class="sit_option">';
									echo $option_item;
								echo '</section>';
							}
							if($supply_item) { //추가 옵션
								echo '<section class="sit_option">';
									echo $supply_item;
								echo '</section>';
							}
							if($is_orderable) {
								echo '<section id="sit_sel_option">';									
									if(!$option_item) {
										if(!$it['it_buy_min_qty']) $it['it_buy_min_qty'] = 1;
										echo '<ul id="sit_opt_added">';
											echo '<li class="sit_opt_list">';
												echo '<input type="hidden" name="io_type['.$it_id.'][]" value="0">';
												echo '<input type="hidden" name="io_id['.$it_id.'][]" value="">';
												echo '<input type="hidden" name="io_value['.$it_id.'][]" value="'.$it['it_name'].'">';
												echo '<input type="hidden" class="io_price" value="0">';
												echo '<input type="hidden" class="io_stock" value="'.$it['it_stock_qty'].'">';
												echo '<div class="opt_name">';
													echo '<span class="sit_opt_subj">'.$it['it_name'].'</span>';
												echo '</div>';
												echo '<div class="opt_count">';
													echo '<label for="ct_qty_'.$i.'" class="sound_only">수량</label>';
													echo '<button type="button" class="sit_qty_minus"><span class="sound_only">감소</span></button>';
													echo '<input type="text" name="ct_qty['.$it_id.'][]" value="'.$it['it_buy_min_qty'].'" id="ct_qty_'.$i.'" class="num_input" size="5">';
													echo '<button type="button" class="sit_qty_plus"><span class="sound_only">증가</span></button>';
													//echo '<span class="sit_opt_prc">+0원</span>';
													echo '<span class="sit_opt_prc">+'.display_price(get_price($it)).'</span>';
												echo '</div>';
											echo '</li>';
										echo '</ul>';
										echo '<script>$(function() { price_calculate(); });</script></script>';
									}
								echo '</section>';
								echo '<div id="sit_tot_price"></div>'; //총 구매액
							}
							
							
							if($is_soldout) echo '<p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>';

						echo '</div>'; // fx-list-con
					echo '</div>'; // fx-list

				echo '</div>';
			echo '</div>';
	        ?>

			<div id="sit_ov_btn">
				<a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" class="sit_btn_wish"><span class="sound_only">위시리스트</span></a>
	            <?php if ($is_orderable) { ?>
	            <button type="submit" onclick="document.pressed=this.value;" value="장바구니" class="sit_btn_cart">장바구니</button>
	            <!--<button type="submit" onclick="document.pressed=this.value;" value="바로구매" class="sit_btn_buy">바로구매</button>-->
				<div value="바로구매" class="sit_btn_buy" style="cursor: pointer;"onclick="fitem_submit('바로구매')">바로구매</div>
	            <?php } ?>            	
	            <?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
	            <a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_alm">재입고알림</a>
	            <?php } ?>
	            <?php if ($naverpay_button_js) { ?>
	            <div class="itemform-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
	            <?php } ?>
	        </div>

	        <script>
	        // 상품보관
	        function item_wish(f, it_id)
	        {
	            f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
	            f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
	            f.submit();
	        }
	
	        // 추천메일
	        function popup_item_recommend(it_id)
	        {
	            if (!g5_is_member)
	            {
	                if (confirm("회원만 추천하실 수 있습니다."))
	                    document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(shop_item_url($it_id)); ?>";
	            }
	            else
	            {
	                url = "./itemrecommend.php?it_id=" + it_id;
	                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
	                popup_window(url, "itemrecommend", opt);
	            }
	        }
	
	        // 재입고SMS 알림
	        function popup_stocksms(it_id)
	        {
	            url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
	            opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
	            popup_window(url, "itemstocksms", opt);
	        }
	        </script>
	    </section>
	    
	</div>

	</form>
</div>

<!-- Include the Bulma theme -->
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@4/bootstrap-4.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>


<script>
$('#_sit_option select').selectpicker(); //인태

$(function(){
    // 상품이미지 첫번째 링크
    $("#sit_pvi_big a:first").addClass("visible");

    // 상품이미지 미리보기 (썸네일에 마우스 오버시)
    $("#sit_pvi .img_thumb").bind("mouseover focus", function(){
        var idx = $("#sit_pvi .img_thumb").index($(this));
        $("#sit_pvi_big a.visible").removeClass("visible");
        $("#sit_pvi_big a:eq("+idx+")").addClass("visible");
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").length < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(cs)
{
	
	var f = document.forms["fitem"];
    f.action = "<?php echo $action_url; ?>";
    f.target = "";
	var chk = 0;

    if (cs == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }
	

	// 판매가격이 0 보다 작다면
	if (document.getElementById("it_price").value < 0) {
		alert("전화로 문의해 주시면 감사하겠습니다.");
		return false;
	}
		
	if($(".sit_opt_list").length < 1) {
		alert("상품의 선택옵션을 선택해 주십시오.");
		return false;
	}

	var val, io_type, result = true;
	var sum_qty = 0;
	var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
	var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
	var $el_type = $("input[name^=io_type]");

	$("input[name^=ct_qty]").each(function(index) {
		val = $(this).val();

		if(val.length < 1) {
			alert("수량을 입력해 주십시오.");
			result = false;
			return false;
		}

		if(val.replace(/[0-9]/g, "").length > 0) {
			alert("수량은 숫자로 입력해 주십시오.");
			result = false;
			return false;
		}

		if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
			alert("수량은 1이상 입력해 주십시오.");
			result = false;
			return false;
		}

		io_type = $el_type.eq(index).val();
		if(io_type == "0")
			sum_qty += parseInt(val);
	});

	if(!result) {
		return false;
	}

	if(min_qty > 0 && sum_qty < min_qty) {
		alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
		return false;
	}

	if(max_qty > 0 && sum_qty > max_qty) {
		alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
		return false;
	}


	if (cs == "바로구매") {

		if(f.chk_ct.value > 0){
			
			Swal.fire({
		
				text: "장바구니에 담긴 상품이 있습니다. 함께 구매하시겠습니까?",
				
				showCancelButton: true,
				cancelButtonText: "아니오",
				cancelButtonColor: "red",
				confirmButtonColor: "#3085d6",
				confirmButtonText: "&nbsp;&nbsp;예&nbsp;&nbsp;"
			}).then((result) => {
				if (result.isConfirmed) {
					///return true;
						
					f.cart_all.value = 1;
					f.submit();
				}else{

					f.cart_all.value = 0;
					f.submit();
				}
			});

/*
			var k = confirm("장바구니 상품이 있습니다. 같이 구매하시겠습니까?");

			if(k==false){
				f.cart_all.value = 0;
			}else{	
				f.cart_all.value = 1;
			}
			*/
		}else{

			f.cart_all.value = 0;
			f.submit();
		}
	}
	

}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>







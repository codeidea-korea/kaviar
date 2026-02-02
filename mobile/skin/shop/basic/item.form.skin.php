<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_MSHOP_SKIN_PATH.'/item.form.skin.php')) {
	require_once(G5_THIS_MSHOP_SKIN_PATH.'/item.form.skin.php');
	return;
}

add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_MSHOP_SKIN_URL.'/skin.css').'">', 0);

add_javascript('<script src="'.G5_THEME_JS_URL.'/my/scrollIt/scrollIt.min.js"></script>', 10);

if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?pn=_shop_item_setting&title=상품 관리&it_id='.$it['it_id'].'" id="itemSetting" class="btnSetting popWin" data-width="1100" data-height="600" data-top="60" data-left="0" data-area="#sit">상품 관리</a>';

//실판매가격 업데이트
update_real_price($it['it_id']);
?>

<?php if($config['cf_kakao_js_apikey']) { ?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js" async></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js"></script>
<script>
    // 사용할 앱의 Javascript 키를 설정해 주세요.
    Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
</script>
<?php } ?>

<form name="fitem" action="<?php echo $action_url; ?>" method="post" onsubmit="return fitem_submit(this);">
<input type="hidden" name="it_id[]" value="<?php echo $it['it_id']; ?>">
<input type="hidden" name="sw_direct">
<input type="hidden" name="url">

<div id="item_view_wrap">
    <?php
	$thumbnails = array();
    // 이미지(중) 썸네일
    $thumb_img = '';
    $thumb_img_w = 640; // 넓이
    //$thumb_img_h = 720; // 높이
	$thumb_img_h = get_it_height($thumb_img_w);	
    for ($i=1; $i<=10; $i++) {
        if(!$it['it_img'.$i])
            continue;
		
		$thumb = get_it_thumbnail($it['it_img'.$i], $thumb_img_w, $thumb_img_h);
		$thumbnails[$i] = $thumb;

        if(!$thumb)
            continue;

        $thumb_img .= '<div class="swiper-slide">';
			$thumb_img .= file_ext_type($it['it_img'.$i]) == 'video' ? $thumb : '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" class="popup_item_image slide_img" target="_blank">'.$thumb.'</a>';
        $thumb_img .= '</div>'.PHP_EOL;
    }
	$total_count = count($thumbnails);

	echo '<div id="itemSlideShow">';
		if ($thumb_img) {
			echo '<div class="mySwiper" data-autoheight="true">'.PHP_EOL;
				echo '<div class="swiper-container">';
					echo '<div class="swiper-wrapper">';
						echo $thumb_img;
					echo '</div>';
				echo '</div>';
				if($total_count>1) echo '<div class="pagination fraction inside"></div>';		
			echo '</div>';
		}
		if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_item_img&title=상품 이미지 관리&it_id='.$it['it_id'].'&close=1" class="edit-block btnSetting popWin" data-width="790" data-height="520" data-top="60" data-left="0" data-area="#itemSlideShow">상품 이미지 관리</a>';
	echo '</div>';

	//특가 타이머
	$it_timer = explode('|', $it['it_timer']);
	if($it_timer[0] && get_buy_timer($it['it_id'])) {
		echo '<div id="buyTimerContainer"><span class="title">남은 시간</span>';
			echo get_buy_timer($it['it_id']);
		echo '</div>';
	} ?>
	
	<section id="item_v_info">
		<div class="subject">
			<?php
			if($is_closedmall) {
				echo '<span class="it_name_hide"></span>';
			} else {
				echo stripslashes($it['it_name']);
				if($it['it_basic']) echo '<sub>'.$it['it_basic'].'</sub>';
			}
			?>
		</div>		
		<div class="conInfo">
			<?php
			if (!$it['it_use']) { // 판매가능이 아닐 경우

				echo '<div class="price">판매중지</div>';
			
			} else if($it['it_tel_inq']) { // 전화문의일 경우

			} else {
				if($is_closedmall) {
					echo '-';
				} else {
					if($it['it_cust_price']) echo '<p class="price before">'.display_price($it['it_cust_price']).'</p>';
					echo '<div class="flex flex-middle gap10">';
						if($it['it_cust_price']) echo '<span class="rate">'.get_discount_rate(get_price($it), $it['it_cust_price']).'</span>';
						echo '<span class="price">'.display_price(get_price($it)).'</span>';
						echo '<input type="hidden" id="it_price" value="'.get_price($it).'">';
					echo '</div>';
				}
			}

			echo get_it_tag($it['it_id']);

			/*$itemtype_tag = '';
			$itemtype = explode("|", $default['itemtype']);
			$itemtype_color = explode("|", $default['itemtype_color']);
			for ($t=0; $t < count($itemtype); $t++) {
				$num = $t + 1;
				if($it['it_type'.$num]) $itemtype_tag .= '<span class="itemtyp_tag"'.($itemtype_color[$t]?' style="background:'.$itemtype_color[$t].';"':'').'>'.$itemtype[$t].'</span>';
			}
			if($itemtype_tag) echo '<div id="itemtype_tag_set" class="mt10">'.$itemtype_tag.'</div>';
			*/
			if($default['shop_use_it_avg']) {
				if($it['it_use_avg'] > 0) {
					$it_use_avg = rtrim($it['it_use_avg'], ".0");
					if($it_use_avg > 0 && $it_use_avg < 1) $it_use_avg = 0.5;
					if($it_use_avg > 1 && $it_use_avg < 2) $it_use_avg = 1.5;
					if($it_use_avg > 2 && $it_use_avg < 3) $it_use_avg = 2.5;
					if($it_use_avg > 3 && $it_use_avg < 4) $it_use_avg = 3.5;
					if($it_use_avg > 4 && $it_use_avg < 5) $it_use_avg = 4.5;
					echo '<div class="grade" data-score="'.$it_use_avg.'">';
						echo '<span class="score">'.$it['it_use_avg'].'</span><span class="star"></span>';
					echo '</div>';	
				}
			}
			//echo '<button type="button" data-href="#pop-sns-share" class="pop-inline btn_sns_share"><span class="sound_only">sns 공유</span></button>';
		echo '</div>';
		
		//상품 기본 정보
		if($it['it_maker'] || $it['it_origin'] || $it['it_brand'] || $it['it_model']) {
			echo '<div class="producInfo">';
				echo '<div class="title border-bottom">상품 기본정보</div>';
				echo '<div class="fx-wrap label70">';				
				if($it['it_maker']) {
					echo '<div class="fx-list">';
						echo '<div class="fx-list-label">제조사</div>';
						echo '<div class="fx-list-con">'.$it['it_maker'].'</div>';
					echo '</div>';
				}
				if($it['it_origin']) {
					echo '<div class="fx-list">';
						echo '<div class="fx-list-label">원산지</div>';
						echo '<div class="fx-list-con">'.$it['it_origin'].'</div>';
					echo '</div>';
				}
				if($it['it_brand']) {
					echo '<div class="fx-list">';
						echo '<div class="fx-list-label">브랜드</div>';
						echo '<div class="fx-list-con">'.$it['it_brand'].'</div>';
					echo '</div>';
				}
				if($it['it_model']) {
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
			echo '<div class="producInfo">';
				echo '<div class="title border-bottom">'.($it['item_info1_label']?$it['item_info1_label']:'상품정보').'</div>';
				echo '<div class="fx-wrap label100">';
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
			echo '<div class="producInfo">';
				echo '<div class="title border-bottom">'.($it['item_info2_label']?$it['item_info2_label']:'상품정보').'</div>';
				echo '<div class="fx-wrap label90">';
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
			echo '<div class="producInfo">';
				echo '<div class="title border-bottom">'.($it['item_info3_label']?$it['item_info3_label']:'상품정보').'</div>';
				echo '<div class="fx-wrap label90">';
					echo $info3_list;
				echo '</div>';
			echo '</div>';
		}
		?>
		

		<?php if(!$it['it_type']) { ?>
		<div class="producInfo">
			<div class="title border-bottom">배송 정보</div>			
			<div class="fx-wrap label70">
				<div class="fx-list">
					<div class="fx-list-label">배송</div>
					<div class="fx-list-con"><?= conv_content($default['de_baesong_content'], 1)?></div>
				</div>
				<div class="fx-list">
					<div class="fx-list-label">배송비</div>
					<div class="fx-list-con">
						<?php if($it['it_sc_type'] == 0) { //쇼핑몰 기본설정
							if($default['de_send_cost_case']=='무료') {
								echo '무료배송';
							} else if($default['de_send_cost_case']=='차등') {
								echo '금액별차등';
								$de_send_cost_list = explode(';', $default['de_send_cost_list']);
								echo '<span class="color-gray ml15">'.display_price(end($de_send_cost_list)).' ~ '.display_price($de_send_cost_list[0]).'</span>';
							}

						} else if($it['it_sc_type'] == 1) { //무료배송
							echo '무료배송';

						} else if($it['it_sc_type'] == 2) { //조건부 무료배송
							echo display_price($it['it_sc_price']);
							echo '<span class="color-slate-500 ml5">(';
							if($it['it_sc_method']==0)
								echo '선불';
							else if($it['it_sc_method']==1)
								echo '착불';
							else if($it['it_sc_method']==2)
								echo '사용자 선택';
							echo ')</span>';
							if($it['it_sc_minimum']) echo '<br><span class="color-blue">주문금액 '.display_price($it['it_sc_minimum']).' 이상 무료배송</span>';

						} else if($it['it_sc_type'] == 3) { //유료배송
							echo display_price($it['it_sc_price']);
							echo '<span class="color-slate-500 ml5">(';
							if($it['it_sc_method']==0)
								echo '선불';
							else if($it['it_sc_method']==1)
								echo '착불';
							else if($it['it_sc_method']==2)
								echo '사용자 선택';
							echo ')</span>';
						} else if($it['it_sc_type'] == 4) { //수량별 부솨
							echo '기본배송비 - '.display_price($it['it_sc_price']);
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
		<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_item_config&title=상품 기본정보 관리&it_id='.$it['it_id'].'&close=1" class="edit-block btnSetting popWin" data-width="900" data-height="600" data-top="60" data-left="0" data-area="#item_v_info">상품 기본정보 관리</a>'; ?>
    </section>
	

	<?php
	//관련 상품
	$sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";	
	$re_result = sql_query($sql);
	$re_total = sql_num_rows($re_result);			
	if($re_total > 0) {	
		echo '<div class="blockSpace"></div>';
		echo '<div id="item_v_relation" class="blockContainer" style="--items-radius:6px;">';
			echo '<div class="inner p20">';
				echo '<div class="blCon-head"><div class="bl_title">관련상품</div></div>';
				echo '<div class="blCon-con">';
					$re_it_width = 350;
					$re_it_height = get_it_height($re_it_width);	

					$list_file = G5_SHOP_SKIN_PATH.'/_block_item.skin.php';
					$list = new item_list();
					$list->set_list_mod($items_count[$i]);
					$list->set_list_row(1);
					$list->set_list_skin($list_file);
					$list->set_img_size(350, $re_it_height);
					$list->set_items_cols(2.5);
					$list->set_items_gap(15);
					$list->set_items_radius(8);
					$list->set_items_skin('_slide');					
					$list->set_query($sql);

					echo $list->run();
				echo '</div>';
			echo '</div>';
			if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_item_relation&title=관련상품&it_id='.$it['it_id'].'&close=1" class="edit-block btnSetting popWin" data-width="1450" data-height="900" data-top="60" data-left="0" data-area="#item_v_relation">관련상품</a>';
		echo '</div>';
	} ?>

	<div class="blockSpace"></div>
	
	<?php
	//후기 카운트
	$re_sql = " select COUNT(*) as cnt from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";
	$re_row = sql_fetch($re_sql);
	$replyCount = $re_row['cnt'];
	//문의 카운트
	$qa_sql = " select COUNT(*) as cnt from `{$g5['g5_shop_item_qa_table']}` where it_id = '{$it_id}' ";
	$qa_row = sql_fetch($qa_sql);
	$qaCount = $qa_row['cnt'];
	?>
	<section id="v_tabContainer">
		<ul class="">
			<li class="active"><button type="button" data-scroll-nav="1">상품상세</button></li>
			<li><button type="button" data-scroll-nav="2">상품후기<span class="count">(<?=$replyCount?>)</span></button></li>
			<li><button type="button" data-scroll-nav="3">상품문의<span class="count">(<?=$qaCount?>)</span></button></li>
		</ul>
	</section>
	
	
	<section id="v_itemContent" data-scroll-index="1">
		<?php
		if ($it['it_explan'] || $it['it_mobile_explan']) {
			echo '<div class="inner">';
				echo ($it['it_mobile_explan'] ? conv_content($it['it_mobile_explan'], 1) : conv_content($it['it_explan'], 1));
				echo '<div class="v_itemCon-toggle"><span class="is_hide">상품정보 펼치기</span><span class="is_show">상품정보 가리기</span></div>';
			echo '</div>';
		} else {
			echo '<div class="noCon">상세 내용이 없습니다.</div>';
		}
		if($is_shop_manager) echo '<a href="'.$_adm_url.'/?pn=_shop_item_content&title=상품상세 편집&it_id='.$it['it_id'].'&close=1" class="edit-block btnSetting popWin mb20" data-width="755" data-height="900" data-top="60" data-left="0" data-area="#v_itemContent">상품상세 편집</a>';
		?>
	</section>
	
	<?php
	if(shop_banner('상품상세', '_block_banner.skin.php')) {
		echo '<section id="item_banner" class="relative">';
			echo shop_banner('상품상세', '_block_banner.skin.php');
			if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=상품상세&title=쇼핑몰 배너관리" class="edit-block btnSetting popWin" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#mypage_banner">쇼핑몰 배너관리</a>';
		echo '</section>';
	}
	?>

	<div class="blockSpace"></div>	

	<!-- 상품 후기 -->
	<section id="v_review" class="" data-scroll-index="2">
		<?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?>
	</section>

	<div class="blockSpace"></div>

	<!-- 상품 후기 -->
	<section id="v_qna" class="" data-scroll-index="3">
		<?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?>
	</section>
	
	<div class="blockSpace"></div>
	
	<?php if(!$is_closedmall) { ?>
	<div id="btn-purchase-wrap">
		<a href="javascript:item_wish(document.fitem, '<?=$it['it_id']?>');" id="sit_btn_wish">찜하기</a>
		<button type="button" class="purchaseOption-opener ani"><?=$it['it_type']?'예약하기':'구매하기'?></button>
	</div>
	<?php
		//구매하기 버튼 높이만큼 하단에 여백 주기
		//$bottomSpace_height = 51;
	} ?>
	 
	<div id="purchaseOption">		
		<div class="purchaseOption-inner">
			<span class="btnClose"><span class="sound_only">닫기</span></span>
			<div class="title">옵션 선택</div>

			<div class="scroll-auto">			
				<?php
				// 선택옵션
				if($option_item) {
					echo '<section class="sit_option">';
					echo '<h3 class="option-title">선택옵션</h3>';
					echo '<div class="sit_op_sl">'.$option_item.'</div>';
					echo '</section>';
				}			
				// 추가옵션
				if($supply_item) {
					echo '<section class="sit_option">';
					echo '<h3 class="option-title">추가옵션</h3>';
					echo '<div class="sit_op_sl">'.$supply_item.'</div>';
					echo '</section>';
				}
				
				//옵션 선택 결과
				if($it['it_use'] && !$it['it_tel_inq'] && !$is_soldout) {
					echo '<div id="sit_sel_option">';
					if(!$option_item) {
						if(!$it['it_buy_min_qty']) $it['it_buy_min_qty'] = 1;
						echo '<ul id="sit_opt_added">';
							echo '<li class="sit_opt_list">';
								echo '<input type="hidden" name="io_type['.$it_id.'][]" value="0">';
								echo '<input type="hidden" name="io_id['.$it_id.'][]" value="">';
								echo '<input type="hidden" name="io_value['.$it_id.'][]" value="'.$it['it_name'].'">';
								echo '<input type="hidden" class="io_price" value="0">';
								//echo '<input type="hidden" class="io_price" value="'.get_price($it).'">';
								echo '<input type="hidden" class="io_stock" value="'.$it['it_stock_qty'].'">';
								echo '<div class="row">';
									echo '<span class="sit_opt_subj">'.$it['it_name'].'</span>';
									echo '<button type="button" class="sit_opt_del">삭제</button>';
								echo '</div>';
								echo '<div class="row">';
									echo '<div class="quantity-controler">';
										echo '<button type="button" class="sit_qty_minus">감소</button>';
										echo '<input type="text" name="ct_qty['.$it_id.'][]" value="'.$it['it_buy_min_qty'].'" class="num_input" size="5">';
										echo '<button type="button" class="sit_qty_plus">증가</button>';						
									echo '</div>';
									//echo '<span class="sit_opt_prc">+0원</span>';
									echo '<span class="sit_opt_prc comma">+'.get_price($it).'원</span>';						
								echo '</div>';
							echo '</li>';
						echo '</ul>';
						echo '<script>$(function() { price_calculate(); });</script>';
					}
					echo '</div>';
					//echo '<div id="sit_tot_price"></div>';
				}
				
				if($is_soldout) echo '<p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>';
				?>
			</div>
			<div class="purchaseOption-bottom">
				<?php if($it['it_use'] && !$it['it_tel_inq'] && !$is_soldout) echo '<div id="sit_tot_price"></div>'; ?>
				<div id="sit_ov_btn">
					<?php if ($is_orderable) { ?>
					<input type="submit" onclick="document.pressed=this.value;" value="장바구니" id="sit_btn_cart">
					<input type="submit" onclick="document.pressed=this.value;" value="<?=$it['it_type']?'예약하기':'구매하기'?>" id="sit_btn_buy" class="btn_submit">
					<!--<button type="button" onclick="document.pressed=this.value;" id="sit_btn_buy" class="btn_submit">구매하기</button>-->
					<?php } ?>
					<?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
					<a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_phone">재입고알림</a>
					<?php } ?>
					<!--<a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" id="sit_btn_wish"><span class="sound_only">위시리스트</span><i class="fa fa-heart-o" aria-hidden="true"></i></a>-->
					<?php if ($naverpay_button_js) { ?>
					<div class="naverpay-item"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="bgCover"></div>
	</div>
	
</div>

</form>


<!-- 레이어팝업 - sns 공유 -->
<!--<div class="layer-popup" id="pop-sns-share">	
	<div class="pop-inner">
		<div class="popCon">			
			<span class="pop-closer">팝업닫기</span>
			<p class="fs15 fw600 tcenter mb20">SNS 공유</p>
			<div class="sns_set">
				<a href="javascript:Navershare()" class="sns_naver">NAVER</a>
				<a href="javascript:KakaoshareMsg()" class="sns_kakao">KAKAO</a>
				<a href="#" data-clipboard-target="#share_url" class="link_url">URL</a>
			</div>
		</div>
	</div>
	<div class="pop-bg"></div>
</div>-->

<script>
/*
var clipboard = new ClipboardJS('.link_url');

clipboard.on('success', function(e) {
	alert("URL주소가 클립보드에 복사되었습니다.");
	console.log(e);
});

clipboard.on('error', function(e) {
	alert("복사가 실패하였습니다.");
	console.log(e);
});
*/
</script>
<script src="//t1.kakaocdn.net/kakao_js_sdk/2.1.0/kakao.min.js" integrity="sha384-dpu02ieKC6NUeKFoGMOKz6102CLEWi9+5RQjWSV0ikYSFFd8M3Wp2reIcquJOemx" crossorigin="anonymous" async=""></script>
<script>
  //Kakao.init('b8c2836d3ed1b27ec846e5db3ddc203a'); // 사용하려는 앱의 JavaScript 키 입력
</script>
<script>
/*
function KakaoshareMsg() {
    Kakao.Share.sendDefault({
      objectType: 'commerce',
      content: {
        title: '',
        imageUrl: '<?=G5_DATA_URL."/item/".$it["it_img1"]?>',
        link: {
          // [내 애플리케이션] > [플랫폼] 에서 등록한 사이트 도메인과 일치해야 함
          mobileWebUrl: '<?=G5_URL?>',
          webUrl: '<?=G5_URL?>',
        },
      },
      commerce: {
        productName: '<?=stripslashes($it["it_name"])?>',
        regularPrice: 18000,
        discountRate: 21,
        discountPrice: 14300,
      },
      buttons: [
        {
          title: '자세히 보기',
          link: {
            mobileWebUrl: '<?=shop_item_url($it["it_id"])?>',
            webUrl: '<?=shop_item_url($it["it_id"])?>',
          },
        },
      ],
    });	  
}

function Navershare() {
	var title = '<?=stripslashes($it["it_name"])?>';
	var url = 'https://share.naver.com/web/shareView?url=<?=shop_item_url($it["it_id"])?>&title='+title;
    opt = 'scrollbars=yes,width=450,height=600';
    popup_window(url, "wnavershare", opt);
}
*/
</script>



<script>
$(document).ready(function(){

	//스크롤 이벤트
	let headerCon_height = $('#header .headerContainer').height();
	const hdShowAnim = gsap.from('#header #header_inwrap, #v_tabContainer', {
		//yPercent: -100,
		y: -headerCon_height,
		paused: true,
		duration: 0.2
	}).progress(1);
	ScrollTrigger.create({
		trigger: "#v_tabContainer",
		start: "-=30px top top",
		end: 99999,
		onUpdate: (self) => {
			self.direction === -1 ? hdShowAnim.play() : hdShowAnim.reverse()
		}
	});
	
	//텝버튼 스크롤 이동
	$.scrollIt({		
		scrollTime: 0,
		topOffset: - $("#v_tabContainer").height(),
		activeClass: 'active',
	});
	

	$('select.it_option, select.it_supply').selectpicker();
	//옵션선택 활성화
	$(".purchaseOption-opener").click(function(){
		if($(this).hasClass('ani')) {
			$("#purchaseOption").show().addClass('open').animate({"bottom": 0}, 300);
			$("#purchaseOption .bgCover").animate({"opacity": 1}, 250);
		} else {
			$("#purchaseOption").show().addClass('open').css({'bottom':0});
			$("#purchaseOption .bgCover").css({"opacity": 1});
		}
		$('body, html').css('overflow', 'hidden');
	});
	$("#purchaseOption .btnClose").click(function(){
		$("#purchaseOption").hide().removeAttr('style');
		$("#purchaseOption .bgCover").removeAttr('style');
		$('body, html').css('overflow', '');
	});

});
</script>





<script>
$(window).bind("pageshow", function(event) {
    if (event.originalEvent.persisted) {
        document.location.reload();
    }
});

$(function(){

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });

    if (window.location.href.split("#").length > 1) {
        let id = window.location.href.split("#")[1];
        $("#btn_" + id).trigger("click");
    };
});

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
        url = "<?php echo G5_SHOP_URL; ?>/itemrecommend.php?it_id=" + it_id;
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

// 구매하기, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 구매하기
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

    return true;
}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
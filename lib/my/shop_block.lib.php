<?php
if (!defined('_GNUBOARD_')) exit;

$pn = $_GET['pn'];
if($pn=='_view_adm' && $is_shop_manager) goto_url(G5_SHOP_URL);

// ───────────────────────────────────────────────────────────────────
//														쇼핑몰 메인
// ───────────────────────────────────────────────────────────────────
function shop_block($bl_cate) {
	global $g5, $pn, $is_admin, $is_shop_manager, $_adm_url, $is_closedmall;
	
	@include_once(G5_THEME_PATH.'/_shop_block_config.php'); //블럭 기본 설정값

	$shopblock_where = " where bl_use != 'none' ";	
	if($pn!='_view_adm' && !$is_shop_manager) $shopblock_where .= " and bl_use != 'admin' ";
	if(!G5_IS_MOBILE) $shopblock_where .= " and bl_use != 'mobile' ";
	if(G5_IS_MOBILE) $shopblock_where .= " and bl_use != 'pc' ";
	if($bl_cate) {
		$shopblock_where .= " and bl_cate = '$bl_cate' ";
	} else {
		$shopblock_where .= " and bl_cate = '' ";
	}

	$shopblock_sql_common = " from {$g5['g5_shop_block_table']} ";
	$shopblock_sql = " select count(*) as cnt " . $shopblock_sql_common . $shopblock_where;
	$shopblock_row = sql_fetch($shopblock_sql);
	$shopblock_count = $shopblock_row['cnt'];

	$shopblock_sql = "select * from {$g5['g5_shop_block_table']} {$shopblock_where} order by bl_order < 0, bl_order = 0, bl_order, bl_id ";
	$result = sql_query($shopblock_sql);

	for($i=0; $row=sql_fetch_array($result); $i++) {
		$shopblock[$i] = $row;
	}
	
	$blockCon = '';
	for($i=0; $i<$shopblock_count; $i++) {
		$bl_id[$i] = $shopblock[$i]['bl_id'];
		$blConStyle[$i] = '';

		// 여백
		$bl_padding[$i] = !G5_IS_MOBILE ? explode("|", $shopblock[$i]['bl_padding']) : explode("|", $shopblock[$i]['bl_padding_mobile']);
		$bl_padding_t[$i] = $bl_padding[$i][0];
		$bl_padding_b[$i] = $bl_padding[$i][1];
		$bl_padding_lr[$i] = $bl_padding[$i][2];

		if($shopblock[$i]['bl_width']) {
			$blConStyle[$i] = $shopblock[$i]['bl_width'] <= 100 ? '--bl-width:'.$shopblock[$i]['bl_width'].'%;' : '--bl-width:'.$shopblock[$i]['bl_width'].'px;';
		}
		if($shopblock[$i]['bl_width'] && !G5_IS_MOBILE && $bl_padding_lr[$i] != '0') {
			$blConCSS[$i] = '@media screen and (max-width:'.$shopblock[$i]['bl_width'].'px) {';
			$blConCSS[$i] .= '#section-'.$bl_id[$i].'{padding-left:var(--screen-bl-padding);padding-right:var(--screen-bl-padding);}';
			$blConCSS[$i] .= '}';
		}
		if($shopblock[$i]['bl_title_color']) $blConStyle[$i] .= '--bl-title-color:'.$shopblock[$i]['bl_title_color'].';--bl-title-sub-color:'.$shopblock[$i]['bl_title_color'].';';
		if($shopblock[$i]['bl_title_size']) $blConStyle[$i] .= '--bl-title-size:'.$shopblock[$i]['bl_title_size'].'px;';

		// 타이틀 (첫째줄과 나머지줄 분리. 둘째줄부터 소제목 처리)		
		$bl_title_arr[$i] = $shopblock[$i]['bl_title'] ? nl2br($shopblock[$i]['bl_title']) : '';
		$bl_title_arr[$i] = explode(PHP_EOL, $bl_title_arr[$i]);
		$bl_title[$i] = '';
		for($t=0; $t<count($bl_title_arr[$i]); $t++) {
			$bl_title[$i] .= $t==0 ? $bl_title_arr[$i][0] : '<sub>'.$bl_title_arr[$i][$t].'</sub>';
		}
		if(G5_IS_MOBILE) {
			$bl_title_mobile_arr[$i] = $shopblock[$i]['bl_title_mobile'] ? nl2br($shopblock[$i]['bl_title_mobile']) : '';
			$bl_title_mobile_arr[$i] = explode(PHP_EOL, $bl_title_mobile_arr[$i]);
			$bl_title_mobile[$i] = '';
			for($t=0; $t<count($bl_title_mobile_arr[$i]); $t++) {
				$bl_title_mobile[$i] .= $t==0 ? $bl_title_mobile_arr[$i][0] : '<sub>'.$bl_title_mobile_arr[$i][$t].'</sub>';
			}
			$bl_title[$i] = $bl_title_mobile[$i] ? $bl_title_mobile[$i] : $bl_title[$i];
		}
		$bl_title[$i] = $bl_title[$i] ? '<div class="bl_title">'.$bl_title[$i].'</div>' : '';

		// 여백
		/*$bl_padding[$i] = !G5_IS_MOBILE ? explode("|", $shopblock[$i]['bl_padding']) : explode("|", $shopblock[$i]['bl_padding_mobile']);
		$bl_padding_t[$i] = $bl_padding[$i][0];
		$bl_padding_b[$i] = $bl_padding[$i][1];
		$bl_padding_lr[$i] = $bl_padding[$i][2];*/
		// 배경 컬러
		$bl_background[$i] = explode("|", $shopblock[$i]['bl_background']);
		// 불러오기 옵션(블럭타입에따라 달라진다..)
		$items_order_option[$i] = explode("|", $shopblock[$i]['items_order_option']);
		$items_order_option1[$i] = $items_order_option[$i][0];
		$items_order_option2[$i] = $items_order_option[$i][1];
		$items_order_option3[$i] = $items_order_option[$i][2];
		//링크
		/* 전체보기 링크 없애기
		$bl_link[$i] = explode("|", $shopblock[$i]['bl_link']);
		$bl_link_name[$i] = $bl_link[$i][0] ? $bl_link[$i][0] : '전체보기';
		$bl_link_url[$i] = $bl_link[$i][1];
		$bl_link_option[$i] = $bl_link[$i][2] ? ' target="'.$bl_link[$i][2].'"' : '';
		*/
		// 상품진열 스킨(_slide, _wz, _gall)
		$items_skin_arr[$i] = explode("|", $shopblock[$i]['items_skin']);
		$items_skin[$i] = $items_skin_arr[$i][0];
		if(G5_IS_MOBILE && $items_skin_arr[$i][1]) $items_skin[$i] = $items_skin_arr[$i][1];
		//가로수
		$items_cols[$i] = !G5_IS_MOBILE ? $shopblock[$i]['items_cols'] : $shopblock[$i]['items_cols_mobile'];
		if($shopblock[$i]['bl_type'] == 'banner' && !$items_cols[$i]) {
			if($items_skin[$i] == '_slide' && !G5_IS_MOBILE) $items_cols[$i] = $_banner_cols_slide;
			if($items_skin[$i] == '_gall' && !G5_IS_MOBILE) $items_cols[$i] = $_banner_cols_gall;
			if($items_skin[$i] == '_slide' && G5_IS_MOBILE) $items_cols[$i] = $_banner_cols_slide_mobile;
			if($items_skin[$i] == '_gall' && G5_IS_MOBILE) $items_cols[$i] = $_banner_cols_gall_mobile;
		}
		if($shopblock[$i]['bl_type'] == 'item' && !$items_cols[$i]) {
			if($items_skin[$i] == '_slide' && !G5_IS_MOBILE) $items_cols[$i] = $_items_cols_slide;
			if($items_skin[$i] == '_gall' && !G5_IS_MOBILE) $items_cols[$i] = $_items_cols_gall;
			if($items_skin[$i] == '_slide' && G5_IS_MOBILE) $items_cols[$i] = $_items_cols_slide_mobile;
			if($items_skin[$i] == '_gall' && G5_IS_MOBILE) $items_cols[$i] = $_items_cols_gall_mobile;
		}
		//아이템 간격
		$items_gap[$i] = !G5_IS_MOBILE ? $shopblock[$i]['items_gap'] : $shopblock[$i]['items_gap_mobile'];
		//아이템 라운딩
		$items_radius[$i] = !G5_IS_MOBILE ? $shopblock[$i]['items_radius'] : $shopblock[$i]['items_radius_mobile'];
		if(!$items_radius[$i] && !G5_IS_MOBILE && $_items_radius) $items_radius[$i] = $_items_radius;
		if(!$items_radius[$i] && G5_IS_MOBILE && $_items_radius_mobile) $items_radius[$i] = $_items_radius;


		// 디폴트 값들.. ───────────────────────────────────────────────────────────────
		// 위 여백 (디폴트)
		if(!$bl_padding_t[$i] && $bl_padding_t[$i] != '0') {
			if($bl_title[$i]) {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_items_padding_t : $_items_padding_mobile_t;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_itemuse_padding_t  : $_itemuse_padding_mobile_t;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_shopCate_padding_t : $_shopCate_padding_mobile_t;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_link_padding_t : $_link_padding_mobile_t;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_mix_padding_t : $_mix_padding_mobile_t;
				if(!$shopblock[$i]['bl_type']) $bl_padding_t[$i] = !G5_IS_MOBILE ? $_padding_t : $_padding_mobile_t;
			} else {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_items_padding : $_items_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_itemuse_padding : $_itemuse_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_shopCate_padding : $_shopCate_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_link_padding : $_link_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_t[$i] = !G5_IS_MOBILE ? $_mix_padding : $_mix_padding_mobile;
				if(!$shopblock[$i]['bl_type']) $bl_padding_t[$i] = !G5_IS_MOBILE ? $_padding : $_padding_mobile;
			}
		}
		// 아래 여백 (디폴트)
		if(!$bl_padding_b[$i] && $bl_padding_b[$i] != '0') {
			if($bl_title[$i]) {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_items_padding_b : $_items_padding_mobile_b;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_itemuse_padding_b  : $_itemuse_padding_mobile_b;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_shopCate_padding_b : $_shopCate_padding_mobile_b;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_link_padding_b : $_link_padding_mobile_b;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_mix_padding_b : $_mix_padding_mobile_b;
				if(!$shopblock[$i]['bl_type']) $bl_padding_b[$i] = !G5_IS_MOBILE ? $_padding_b : $_padding_mobile_b;
			} else {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_items_padding : $_items_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_itemuse_padding : $_itemuse_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_shopCate_padding : $_shopCate_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_link_padding : $_link_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_b[$i] = !G5_IS_MOBILE ? $_mix_padding : $_mix_padding_mobile;
				if(!$shopblock[$i]['bl_type']) $bl_padding_b[$i] = !G5_IS_MOBILE ? $_padding : $_padding_mobile;
			}
		}
		// 좌우여백 (디폴트)
		if(!$bl_padding_lr[$i] && $bl_padding_lr[$i] != '0') {
			if($bl_title[$i]) {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_items_padding_lr : $_items_padding_mobile_lr;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_itemuse_padding_lr : $_itemuse_padding_mobile_lr;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_shopCate_padding_lr : $_shopCate_padding_mobile_lr;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_link_padding_lr : $_link_padding_mobile_lr;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_mix_padding_lr : $_mix_padding_mobile_lr;
				if(!$shopblock[$i]['bl_type']) $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_padding_lr : $_padding_mobile_lr;
			} else {
				if($shopblock[$i]['bl_type'] == 'item') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_items_padding : $_items_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'itemuse') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_itemuse_padding : $_itemuse_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'shopCate') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_shopCate_padding : $_shopCate_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'link') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_link_padding : $_link_padding_mobile;
				if($shopblock[$i]['bl_type'] == 'mix') $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_mix_padding : $_mix_padding_mobile;
				if(!$shopblock[$i]['bl_type']) $bl_padding_lr[$i] = !G5_IS_MOBILE ? $_padding : $_padding_mobile;
			}
			if($shopblock[$i]['bl_width'] && !G5_IS_MOBILE) $bl_padding_lr[$i] = '0'; //가로사이즈가 있으면 좌우여백 디폴트 변경
		}
		// 아이템 간격 (디폴트)
		if(!$items_gap[$i]) {
			if($shopblock[$i]['bl_type'] == 'item' && !G5_IS_MOBILE) $items_gap[$i] = $_items_gap;
			if($shopblock[$i]['bl_type'] == 'item' && G5_IS_MOBILE) $items_gap[$i] = $_items_gap_mobile;
		}
		// 목록수 (디폴트)
		$items_count[$i] = $shopblock[$i]['items_count'] ? $shopblock[$i]['items_count'] : 2;
		// ────────────────────────────────────────────────────────────────────────

		
		if($bl_padding_t[$i]) $blConStyle[$i] .= '--padding-t:'.$bl_padding_t[$i].'px;';
		if($bl_padding_b[$i]) $blConStyle[$i] .= '--padding-b:'.$bl_padding_b[$i].'px;';
		/*if($bl_id[$i] == 5){
			if($bl_padding_b[$i]) $blConStyle[$i] .= '--padding-b:0px;'; //하드코딩 직접 맛보고 추천하는 메뉴 일경우 하단 패딩제거
		}else{
			if($bl_padding_b[$i]) $blConStyle[$i] .= '--padding-b:'.$bl_padding_b[$i].'px;';
		}*/

		
		if($bl_padding_lr[$i]) $blConStyle[$i] .= '--padding-lr:'.$bl_padding_lr[$i].'px;';
		if($bl_background[$i][0]) $blConStyle[$i] .= '--bl-background:'.$bl_background[$i][0].';';
		if($bl_background[$i][1]) $blConStyle[$i] .= '--bl-border:1px dashed rgba(0,0,0,0.12);';
		
		// 여백을 무시하는 콘텐츠가 있는지 검사. 있다면 padding 적용 범위가 달라진다.
		$has_fullCon[$i] = false;
		if($shopblock[$i]['bl_type'] == 'banner') $has_fullCon[$i] = true;
		if($shopblock[$i]['bl_type'] == 'item' && $items_skin[$i] == '_slide') $has_fullCon[$i] = true;
		if($shopblock[$i]['bl_type'] == 'itemuse' && $items_skin[$i] == '_slide') $has_fullCon[$i] = true;
		if($shopblock[$i]['bl_type'] == 'shopCate' && $items_cols[$i] > 4) $has_fullCon[$i] = true;
		if($shopblock[$i]['bl_video_src']) $has_fullCon[$i] = true;
		
		// 콘텐츠를 직접선택 하면 목록수를 선택한 아이템 수로 변경
		if($items_order_option1[$i]=='list_of_select' || $items_order_option2[$i]=='list_of_select') {
			$items_sel_li_id[$i] = explode(",", $shopblock[$i]['items_sel_li_id']);
			$items_count[$i] = count($items_sel_li_id[$i]);
		}
				
		
		// 영상 여부
		$blVideoContainer[$i] = '';
		if($shopblock[$i]['bl_video_src']) {
			$blVideoContainer[$i] = '<div id="blVideoContainer">';
			if(strpos($shopblock[$i]['bl_video_src'], 'youtu') !== false) {
				$blVideoContainer[$i] .= '<iframe src="https://www.youtube.com/embed/'.$shopblock[$i]['bl_video'].'?amp;controls=2&amp;showinfo=1&autoplay=0&modestbranding=1" frameborder="0" class="video" allowfullscreen></iframe>';
			} else if(strpos($shopblock[$i]['bl_video_src'], 'vimeo') !== false) {
				$blVideoContainer[$i] .= '<iframe src="https://player.vimeo.com/video/'.$shopblock[$i]['bl_video'].'?autoplay=0" frameborder="0" class="video" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';			
			} else if($shopblock[$i]['bl_video_src']) {
				if( !preg_match('/http(s?)\:\/\//i', $shopblock[$i]['bl_video']) ) $shopblock[$i]['bl_video'] = G5_URL.'/video/'.$shopblock[$i]['bl_video'];
				$blVideoContainer[$i] .= '<div class="video-container play-btn"><video src="'.$shopblock[$i]['bl_video'].'" controls class="video"></video></div>';
			}
			$blVideoContainer[$i] .= '</div>';		
		}
		
		// 이미지 여부
		$bl_img1[$i] = G5_DATA_PATH.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_1';
		if(file_exists($bl_img1[$i])) {				
			//$thumb1[$i] = thumbnail('bl'.$shopblock[$i]['bl_id'].'_1', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 500, '', 1, 1, 'center');
			//$bl_thumb1[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$thumb1[$i].'">';
			//$bl_thumb1[$i] = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_1">';
			$bl_img_url[$i] = G5_DATA_URL.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_1';
		}
		$bl_img2[$i] = G5_DATA_PATH.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_2';
		if(G5_IS_MOBILE && file_exists($bl_img2[$i])) {				
			//$thumb2[$i] = thumbnail('bl'.$shopblock[$i]['bl_id'].'_2', G5_DATA_PATH.'/shop_block/', G5_DATA_PATH.'/shop_block/', 500, '', 1, 1, 'center');
			//$bl_thumb2[$i] = '<img src="'.G5_DATA_URL.'/shop_block/'.$thumb2[$i].'">';
			//$bl_thumb2[$i] = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_2">';
			$bl_img_url[$i] = G5_DATA_URL.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_2';
		}
		$bl_thumb[$i] = $bl_img_url[$i] ? '<img src="'.$bl_img_url[$i].'">' : '';
		
		
		
		$blCon_con[$i] = '';

		// 배너 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'banner') {
			$blCon_con[$i] .= shop_banner('', '_block_banner.skin.php', $shopblock[$i]['items_order_option'], $items_count[$i], $shopblock[$i]['items_sel_li_id'], $items_cols[$i], $items_gap[$i], $bl_padding[$i][1], $items_radius[$i]);
			if($bl_padding_t[$i] > 0 && $bl_padding_b[$i] > 0 && $bl_padding_lr[$i] > 0) $blConStyle[$i] .= '--border-radius:6px;';
		}

		// 상품 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'item') {

			// 콘텐츠 헤드 여부 (제목, 전체보기)
			/*$blCon_tabs[$i] = '';
			$tabs_items_cate[$i] = explode("|", $shopblock[$i]['tabs_items_cate']);			
			for ($j=0; $j<count($tabs_items_cate[$i]); $j++) {
				$blCon_tabs[$i] .= '<a onclick="get_bl_'.$bl_id[$i].'_items_ajax(\''.$tabs_items_cate[$i][$j].'\')" class="tab">'.$tabs_items_cate[$i][$j].'</a>';
			}
			$blCon_tabs[$i] = $blCon_tabs[$i] ? '<div class="tabs_items_cate">'.$blCon_tabs[$i].'</div>' : '';*/

			if($shopblock[$i]['tabs_items_cate']) {

				$blCon_con[$i] .= get_include_tabs_items_cate($bl_id[$i], $items_radius[$i]);
				//$blCon_con[$i] .= '<div class="_get_itemsContainer"></div>';

			} else {

				//썸네일 사이즈
				$itemImgSize[$i] = $items_cols[$i] < 2 ? 580 : 350;
				//상품 분류 (직접선택이 없을때만 적용)
				if($items_order_option1[$i]!='list_of_select' && $items_order_option2[$i]!='list_of_select') $itemId[$i] = $items_order_option1[$i];
				//상품 타입 (직접선택이 없을때만 적용)
				if($items_order_option1[$i]!='list_of_select' && $items_order_option2[$i]!='list_of_select') $itemtype[$i] = $items_order_option2[$i];
				
				$list_file = G5_SHOP_SKIN_PATH.'/_block_item.skin.php';
				$list = new item_list();
				$list->set_list_mod($items_count[$i]);
				$list->set_list_row(1);
				//$list->set_mobile(true);			
				if($itemtype[$i]) $list->set_type($itemtype[$i]);
				$list->set_list_skin($list_file);
				$list->set_img_size($itemImgSize[$i], $itemImgSize[$i]);
				$list->set_category($itemId[$i], 1);
				$list->set_category($itemId[$i], 2);
				$list->set_category($itemId[$i], 3);
				$list->set_items_cols($items_cols[$i]);
				$list->set_items_gap($items_gap[$i]);
				$list->set_items_radius($items_radius[$i]);
				$list->set_items_skin($shopblock[$i]['items_skin']);
				$list->set_items_sel_li_id($shopblock[$i]['items_sel_li_id']);
				
				$list->set_view('it_img', true);
				$list->set_view('it_id', false);
				$list->set_view('it_name', true);
				$list->set_view('it_cust_price', true);
				$list->set_view('it_price', true);
				$list->set_view('it_icon', true);
				//$list->set_view('sns', true);
				
				$blCon_con[$i] .= $list->run();
			}
		}

		// 상품후기 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'itemuse') {
			$itemuse_cols[$i] = $items_cols[$i];
			if($items_skin[$i]=='_slide' && !$items_cols[$i]) $itemuse_cols[$i] = 2.25;
			if($items_skin[$i]=='_gall' && !$items_cols[$i]) $itemuse_cols[$i] = 2;
			$itemuse_gap[$i] = $items_gap[$i] ? $items_gap[$i] : 15;
			$blCon_con[$i] .= bl_itemuse('_block_itemuse.skin.php', $shopblock[$i]['items_order_option'], $items_count[$i], $shopblock[$i]['items_sel_li_id'], $itemuse_cols[$i], $itemuse_gap[$i], $items_radius[$i], $items_skin[$i], $bl_padding[$i][1]);
		}

		// 링크 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'link') {
			$blCon_con[$i] .= '<ul class="_block_link_ul'.($items_cols[$i]<=1||!$items_cols[$i]?' column':' flex-wrap').'"'.($items_cols[$i]>1?'  style="--link-cols:'.$items_cols[$i].';"':'').'>';
			
			for($j=1; $j<=10; $j++) {

				// 아이콘 여부
				$bl_icon_path[$i][$j] = G5_DATA_PATH.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_icon'.$j;
				$bl_icon[$i][$j] = '';
				if(file_exists($bl_icon_path[$i][$j])) $bl_icon[$i][$j] = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock[$i]['bl_id'].'_icon'.$j.'">';

				$bl_link_set[$i][$j] = explode("|", $shopblock[$i]['bl_link'.$j]);

				if($bl_icon[$i][$j] || $bl_link_set[$i][$j][0] || $bl_link_set[$i][$j][1] || $bl_link_set[$i][$j][2]) {
					$blCon_con[$i] .= '<li>';
					if($bl_link_set[$i][$j][0]) {
						$blCon_con[$i] .= '<a href="'.get_pretty_url($bl_link_set[$i][$j][0]).'">'.$bl_icon[$i][$j].get_bo_subject($bl_link_set[$i][$j][0]);
					} else if($bl_link_set[$i][$j][1]) {
						$blCon_con[$i] .= '<a href="'.$bl_link_set[$i][$j][2].'"'.($bl_link_set[$i][$j][3]?' target="'.$bl_link_set[$i][$j][3].'"':'').'>'.$bl_icon[$i][$j].$bl_link_set[$i][$j][1];
					}
					$blCon_con[$i] .= '</a></li>';
				}
			}
			$blCon_con[$i] .= '</ul>';
		}
		

		// 카테고리 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'shopCate') {
			if($items_cols[$i] > 4) {
				$blCon_con[$i] .= get_shopCate_list('slide|'.$items_cols[$i].'|'.$items_gap[$i].'|'.$items_radius[$i], $img=true, $all=true);
			} else {
				$blCon_con[$i] .= get_shopCate_list($option='list|'.$items_cols[$i].'|'.$items_gap[$i].'|'.$items_radius[$i], $img=true, $all=true, 'shopCate_ul');
			}
			
		}


		// 믹스형 블럭 출력 ───────────────────────────────────────────────────────────────────
		if($shopblock[$i]['bl_type'] == 'mix') {
			$mix_empty[$i] = true;
			for($k=1; $k<=20; $k++) {
				if($shopblock[$i]['mix_li_'.$k]) {
					$mix_empty[$i] = false;
					continue;
				}
			}
			
			$blCon_con[$i] .= $mix_empty[$i] ? '<a href="'.$_adm_url.'/?pn=_shop_block_mix_form&title=믹스 블럭 편집&w=u&amp;bl_id='.$bl_id[$i].'" class="mix_empty popWin" data-width="800" data-height="900" data-top="60" data-left="0">콘텐츠를 등록해 주세요.</a>' : get_include_mix_skin($shopblock[$i]['bl_id']);

			$this_mix_path = G5_THIS_PATH.'/skin/shop/basic/mix_type/';
			$theme_mix_path = G5_THEME_PATH.'/skin/shop/basic/mix_type/';
			$_mix_path = G5_PATH.'/skin/shop/basic/mix_type/';
			if(is_dir($this_mix_path)) {
				$_mix_path =  $this_mix_path;
			} else if(is_dir($theme_mix_path)){
				$_mix_path =  $theme_mix_path;
			} else {
				$_mix_path =  $_mix_path;
			}

			//echo $shopblock[$i]['mix_type']."<br>";
			@include $_mix_path.$shopblock[$i]['mix_type'].'/_mix.head.skin.php';
		}

		
		if($shopblock[$i]['bl_content']) $blCon_con[$i] .= $shopblock[$i]['bl_content'];
		if(!$shopblock[$i]['bl_type']) {
			if($blVideoContainer[$i]) $blCon_con[$i] .= $blVideoContainer[$i];
			if($bl_thumb[$i]) $blCon_con[$i] .= $bl_thumb[$i];
		} else if($shopblock[$i]['bl_type'] != 'mix') {
			if($bl_thumb[$i]) $blConStyle[$i] .= 'background:url('.$bl_img_url[$i].') no-repeat center / cover';
		}


		// 블럭 버튼 모음
		$bl_btn_set[$i] = '';
		$bl_btn_count[$i] = 0;
		for($b=1; $b<=4; $b++) {
			$ex_btn[$b][$i] = explode("|",$shopblock[$i]['bl_btn'.$b]);
			$btn_color[$b][$i] = explode("|",$shopblock[$i]['bl_btn'.$b.'_color']);
			if($ex_btn[$b][$i][2] == '_blank') $abtnOption[$i] = ' " target="_blank"';
			$bl_btn_href[$i] = $ex_btn[$b][$i][2] == 'alert' ? '' : ' href="'.$ex_btn[$b][$i][1].'" ';
			if($shopblock[$i]['bl_btn'.$b] && $ex_btn[$b][$i][1]) {
				$bl_btn_set[$i] .= '<a href="'.$ex_btn[$b][$i][1].'" class="_bl_btn a_'.$shopblock[$i]['bl_id'].'_'.$b.'"'.$abtnOption[$i].'>'.$ex_btn[$b][$i][0].'</a>';
				$bl_btn_count[$i] ++;
			}
			
			if($btn_color[$b][$i][0]) {
				$blConCSS[$i] .= '._bl_btn_set a.a_'.$shopblock[$i]['bl_id'].'_'.$b.'{background:'.$btn_color[$b][$i][0].' !important;color:'.($btn_color[$b][$i][0]=='rgba(255, 255, 255, 1)'?'#000':'#fff').' !important;border:0 !important;}';
				if($btn_color[$b][$i][1]) $blConCSS[$i] .= '._bl_btn_set a.a_'.$shopblock[$i]['bl_id'].'_'.$b.':hover{background:'.$btn_color[$b][$i][1].' !important;color:'.($btn_color[$b][$i][1]=='rgba(255, 255, 255, 1)'?'#000':'#fff').' !important;border:0 !important;}';
			} else {
				if($btn_color[$b][$i][1]) $blConCSS[$i] .= '._bl_btn_set a.a_'.$shopblock[$i]['bl_id'].'_'.$b.'{color:'.$btn_color[$b][$i][1].' !important;border-color:'.$btn_color[$b][$i][1].' !important;}';
				if($btn_color[$b][$i][1]) $blConCSS[$i] .= '._bl_btn_set a.a_'.$shopblock[$i]['bl_id'].'_'.$b.':hover{background:transparent !important;}';
			}
		}
		$bl_btn_set[$i] = $bl_btn_set[$i] ? '<div class="_bl_btn_set"'.($shopblock[$i]['bl_btn_radius']?' style="--btn-radius:'.$shopblock[$i]['bl_btn_radius'].'px;"':'').'>'.$bl_btn_set[$i].'</div>' : '';

		
		// 콘텐츠 헤드 여부 (제목, 전체보기)
		$blCon_head[$i] = '';
		if($bl_title[$i]) $blCon_head[$i] .= $bl_title[$i];
		if($bl_link_url[$i]&&G5_IS_MOBILE) $blCon_head[$i] .= '<a href="'.$bl_link_url[$i].'" class="allview"'.$bl_link_option[$i].'>'.$bl_link_name[$i].'</a>';
		$bl_title_align[$i] = !G5_IS_MOBILE ? $shopblock[$i]['bl_title_align'] : $shopblock[$i]['bl_title_mobile_align'];
		$blCon_head[$i] = $blCon_head[$i] ? '<div class="blCon-head'.($has_fullCon[$i]?' _get_padding_lr':'').' pretendard'.($bl_title_align[$i]?' '.$bl_title_align[$i]:'').'">'.$blCon_head[$i].'</div>' : '';


		//블럭 콘텐츠 시작
		$blockCon .= '<section id="section-'.$bl_id[$i].'" class="blockContainer"'.($blConStyle[$i]?' style="'.$blConStyle[$i].'"':'').'>';
			$blockCon .= '<div class="inner _get_padding_tb '.(!$has_fullCon[$i]?' _get_padding_lr':'').'"'.($blInnerStyle[$i]?' style="'.$blInnerStyle[$i].'"':'').'>';

				$blockCon .= get_include_shop_block_html_top($bl_id[$i]);	

				if($blCon_head[$i]) $blockCon .= $blCon_head[$i];
				
				if($shopblock[$i]['bl_type'] || $blCon_con[$i]) {
					$blockCon .= '<div class="blCon-con">';
					$blockCon .= $blCon_con[$i];
					$blockCon .= '</div>';
				}
				$blockCon .= get_include_shop_block_html($bl_id[$i]);		
				if($bl_link_url[$i] && !G5_IS_MOBILE) $blockCon .= '<div class="_bl_link_set"'.($shopblock[$i]['bl_link_color']?' style="--btnColor:'.$shopblock[$i]['bl_link_color'].';"':'').'><a href="'.$bl_link_url[$i].'" class="_bl_link'.($shopblock[$i]['bl_link_color']?' _btnColor':'').($bl_link[$i][0]?' _btndeco':'').'"'.$bl_link_option[$i].'>'.$bl_link_name[$i].'</a></div>';
				$blockCon .= $bl_btn_set[$i];
			$blockCon .= '</div>';
			
			if($is_shop_manager) {
				//$blockCon .= '<a href="'.$_adm_url.'/?pn=_shop_block_form&bl_cate='.$bl_cate.'&title=블럭 수정&w=u&amp;bl_id='.$bl_id[$i].'&close=1" class="edit-block btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#section-'.$bl_id[$i].'">블럭 수정</a>';
				$blockCon .= '<a href="'.$_adm_url.'/?pn=_shop_block_form&bl_cate='.$bl_cate.'&title=블럭 수정&w=u&amp;bl_id='.$bl_id[$i].'&callback=1" class="edit-block btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#section-'.$bl_id[$i].'">블럭 수정</a>';
				if($shopblock[$i]['bl_type'] == 'mix') $blockCon .= '<a href="'.$_adm_url.'/?pn=_shop_block_mix_form&title=믹스 블럭 편집&w=u&amp;bl_id='.$bl_id[$i].'" class="edit-block-mix btnSetting popWin ml10" data-width="800" data-height="900" data-top="60" data-left="0" data-area="#section-'.$bl_id[$i].' .inner">믹스 블럭 편집</a>';
				if(get_include_shop_block_html_top($bl_id[$i]) || get_include_shop_block_html($bl_id[$i])) {
					$includeTip[$i] = '';
					$includeTip[$i] .= get_include_shop_block_html_top($bl_id[$i]) ? 'section_'.$bl_id[$i].'_top.php' : '';
					if(get_include_shop_block_html($bl_id[$i])) {
						$includeTip[$i] .= $includeTip[$i] ? ', ' : '';
						$includeTip[$i] .= 'section_'.$bl_id[$i].'.php';
					}
					$blockCon .= '<div class="helpTag includeTip myTip mini" data-tip="'.$includeTip[$i].'">Inc</div>';
				}
			}
			if($blConCSS[$i]) $blockCon .= '<style>'.$blConCSS[$i].'</style>';
		$blockCon .= '</section>';
		

		//첫블럭이 풀사이즈 배너일때 헤더 투명
		if($i==0 && $shopblock[$i]['bl_type'] == 'banner' && !$shopblock[$i]['bl_width'] && defined('_INDEX_')) {
			if(!G5_IS_MOBILE) {
				$blockCon .= '<style>';
				$blockCon .= '#header:not(.scroll){--header-color:#fff;color:var(--header-color);}
									#headerSpace{display:none}
									.shop-header:not(.scroll){background:transparent;}
									.shop-header:not(.scroll) #hdInner-1 .tollbarContainer li:not(:first-child):before{background:rgba(255,255,255,0.6);}
									.shop-header:not(.scroll) #hdInner-2 .shop_logo_c{display:none;}
									.shop-header:not(.scroll) #hdInner-2 .shop_logo_w{display:block !important;}
									.shop-header:not(.scroll) #hdInner-2 .headerIconCon > ._partners:before{background-image:url('.G5_THEME_URL.'/css/img/partners_w.svg);}
									';
				$blockCon .= '</style>';
			} else {
				//모바일은 적용 안함
				/*
				$blockCon .= '<style>';
				$blockCon .= '#header:not(.scroll):not(.end){--header-color:#fff;color:var(--header-color);}
									#headerSpace{display:none}
									#header:not(.scroll):not(.end) .shop_logo_mobile_c{display:none;}
									#header:not(.scroll):not(.end) .shop_logo_mobile_w{display:block !important;}
									#header:not(.scroll):not(.end) .headerContainer{background:transparent;}
									#header:not(.scroll):not(.end) .topMenuContainer{background:transparent;}
									#header:not(.scroll):not(.end) .headerContainer .hdIcon_partners .myIcon:before{background-image:url('.G5_THEME_URL.'/css/img/partners_w.svg);}
									';
				$blockCon .= '</style>';
				*/
			}
		}

	}



	return $blockCon;
}


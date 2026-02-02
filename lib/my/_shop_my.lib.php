<?php
if (!defined('_GNUBOARD_')) exit;

/*require_once (G5_PATH.'/lib/my/Mobile-Detect/Mobile_Detect.php'); // 모바일 Detect Class 파일
//테블릿 구분 추가
$detect = new Mobile_Detect;
$is_tablet = $detect->isTablet() ? true : false;*/


$is_shop_manager = false;
if($is_admin == 'super') $is_shop_manager = true;

$is_closedmall = false;
if($default['shop_use_closure'] && !$member['mb_id']) $is_closedmall = true;


//비회원 접근불가 페이지 엘럿
function closure_auth_check($msg) {
	global $g5, $is_guest, $default;
	if($is_guest && $default['shop_use_closure']) {
		$msg = $msg ? $msg : "로그인 후, 상세 조회가 가능합니다.";
		//alert($msg, G5_BBS_URL.'/login.php?wr_id='.$wr_id.$qstr.'&amp;url='.$_SERVER["HTTP_REFERER"];
		alert($msg, G5_BBS_URL.'/login.php');
	}
}

// ───────────────────────────────────────────────────────────────────
//													상품 카테고리 호출
// ───────────────────────────────────────────────────────────────────
function get_shopCate() {
	global $g5, $ca_id;
	$shopCategory = '';
	$mshop_categories = get_shop_category_array(true);
	$shopCategory .= '<div class="_shopCate">';
	$shopCategory .= '<ul class="shopCate_1cha_ul">';
	// 1단계 분류 판매 가능한 것만
	$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
	$i = 0;
	foreach($mshop_categories as $cate1) {
		if( empty($cate1) ) continue;

		$row = $cate1['text'];
		$gnb_zindex -= 1; // html 구조에서 앞선 gnb_1dli 에 더 높은 z-index 값 부여
		// 2단계 분류 판매 가능한 것만
		$count = ((int) count($cate1)) - 1;
	
		$shopCategory .= '<li class="shopCate_1cha_li'.($count?' hasSub':'').($row['ca_id']==$ca_id?' active':'').'">';
		$shopCategory .= '<a href="'.$row['url'].'" class="a_1cha">'.$row['ca_name'].'</a>';
		
		$j=0;
		foreach($cate1 as $key=>$cate2) {
			if( empty($cate2) || $key === 'text' ) continue;
		
			$row2 = $cate2['text'];
			if ($j==0) $shopCategory .= '<ul class="shopCate_2cha_ul">';
			$shopCategory .= '<li class="shopCate_2cha_li'.($row2['ca_id']==$ca_id?' active':'').'"><a href="'.$row2['url'].'" class="a_2cha">'.$row2['ca_name'].'</a></li>';
			$j++;
		}   //end for
		if ($j>0) $shopCategory .= '</ul>';

		$shopCategory .= '</li>';

	$i++;
	}   //end for
	$shopCategory .= '</ul>';
	$shopCategory .= '</div>';

	return $shopCategory;
}


// ───────────────────────────────────────────────────────────────────
//												쇼핑몰 상단 메뉴 (상품유형별 구분)
// ───────────────────────────────────────────────────────────────────
function get_shop_top_menu($all=true) {
	global $g5, $default, $menu, $pn_id, $bo_table;

	$type = isset($_REQUEST['type']) ? preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']) : '';
	$ev_id = isset($_REQUEST['ev_id']) ? preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['ev_id']) : '';
	$itemtype = explode("|", $default['itemtype']);

	$shop_top_menu_list = '';
	$sql = " select * from {$g5['g5_shop_top_menu_table']} order by shopmenu_order, shopmenu_id ";
	$result = sql_query($sql, false);
	$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
	$shopmenu_datas = array();

	for($i=0; $row=sql_fetch_array($result); $i++) {
		if(empty($row)) continue;
		$active[$i] = false;
		if($row['shopmenu_name']) {
			$shopmenu[$i] = $row['shopmenu_name'];
		} else if($row['shopmenu'] == '_event') {
			$shopmenu[$i] = '이벤트';
		} else if($row['shopmenu'] == '_all') {
			$shopmenu[$i] = '전체상품';
		} else if($row['shopmenu'] == '_board') {
			$board[$i] = sql_fetch(" select * from {$g5['board_table']} where bo_table='".$row['shopmenu_link']."'");
			$shopmenu[$i] = $board[$i]['bo_subject'];
		} else {
			$shopmenu[$i] = $row['shopmenu'];
		}
		$shopmenu_text[$i] = explode("/", $shopmenu[$i]);
		if(count($shopmenu_text[$i]) > 1) {
			$shopmenu[$i] = '<div class="rolling-text">';
			for ($r=0; $r < count($shopmenu_text[$i]); $r++) {
				$shopmenu[$i] .= '<span>'.$shopmenu_text[$i][$r].'</span>';
			}
			$shopmenu[$i] .= '</div>';
		}

		if($row['shopmenu']) {
			if($row['shopmenu'] == '_event') {
				if(defined('_EVENT_')) $active[$i] = true;
				$shopmenu_link[$i] = shop_short_url_my('event');
			} else if($row['shopmenu'] == '_all') {
				if(defined('_SHOPLIST_')) $active[$i] = true;				
				$shopmenu_link[$i] = shop_category_url('all');
			} else if($row['shopmenu'] == '_page') {
				if($pn_id == $row['shopmenu_link']) $active[$i] = true;	
				$shopmenu_link[$i] = shop_short_url_my('page', $row['shopmenu_link']);
			} else if($row['shopmenu'] == '_board') {
				if($bo_table == $row['shopmenu_link']) $active[$i] = true;	
				$shopmenu_link[$i] = get_pretty_url($row['shopmenu_link']);
			} else {
				for ($t=0; $t < count($itemtype); $t++) {
					$num = $t + 1;
					if($row['shopmenu'] == $itemtype[$t]) {
						$shopmenu_link[$i] = shop_type_url($num);
						if($type == $num) $active[$i] = true;
					} else if($row['shopmenu'] == '전체상품') {
						$shopmenu_link[$i] = shop_type_url('all');
						if($type == 'all') $active[$i] = true;
					}
				}
			}
		} else {
			$shopmenu_link[$i] = $row['shopmenu_link'];
			$shopmenu_link_option[$i] = $row['shopmenu_link_option'] ? ' target="'.$row['shopmenu_link_option'].'"' : ''; 
		}
				
		$shop_top_menu_list .= '<li>';
		$shop_top_menu_list .= '<a href="'.$shopmenu_link[$i].'"'.($active[$i]?' class="active" ':'').'alt="'.($row['shopmenu']?$row['shopmenu']:$row['shopmenu_name']).'"'.$shopmenu_link_option[$i].'>'.$shopmenu[$i].'</a>';
		$shop_top_menu_list .= '</li>';
	}

	$shop_top_menu_list = $shop_top_menu_list ? '<ul>'.$shop_top_menu_list.'</ul>' : '';

	return $shop_top_menu_list;
}



// ───────────────────────────────────────────────────────────────────
//													분류코드로 분류명 얻기
// ───────────────────────────────────────────────────────────────────
function get_shop_cate($ca_id) {
	global $g5;

	$sql  = " select * from {$g5['g5_shop_category_table']} where ca_id = $ca_id ";
	//$result = sql_query($sql);
	$shopcate = sql_fetch($sql);	


	return $shopcate['ca_name'];
}


// ───────────────────────────────────────────────────────────────────
//														쇼핑몰 하단 메뉴
// ───────────────────────────────────────────────────────────────────
function get_shop_bottom_tabs() {
	global $g5, $default, $is_member, $store_label;
	
	$shop_top_menu_list = '';

	if($default['shop_bottom_use_home'] || $default['shop_bottom_use_gnb'] || $default['shop_bottom_use_search'] || $default['shop_bottom_use_store'] || $default['shop_bottom_use_member']) {
		$shop_bottom_tabs_name = explode("|", $default['shop_bottom_tabs_name']);
		$shop_bottom_tabs_name1 = $shop_bottom_tabs_name[0] ? $shop_bottom_tabs_name[0] : '';
		$shop_bottom_tabs_name2 = $shop_bottom_tabs_name[1] ? $shop_bottom_tabs_name[1] : '';
		$shop_bottom_tabs_name3 = $shop_bottom_tabs_name[2] ? $shop_bottom_tabs_name[2] : '';
		$shop_bottom_tabs_name4 = $shop_bottom_tabs_name[3] ? $shop_bottom_tabs_name[3] : '';
		$shop_bottom_tabs_name4 = explode("/", $shop_bottom_tabs_name4);
		$shop_bottom_tabs_name4 = !$is_member ? $shop_bottom_tabs_name4[0] : $shop_bottom_tabs_name4[1];
		
		$shop_bottom_home = file_exists(G5_DATA_PATH.'/shop_icon/shop_bottom_home.svg') ? '<img src="'.G5_DATA_URL.'/shop_icon/shop_bottom_home.svg">' : '<i class="ic_home"></i>';
		$shop_bottom_gnb = file_exists(G5_DATA_PATH.'/shop_icon/shop_bottom_gnb.svg') ? '<img src="'.G5_DATA_URL.'/shop_icon/shop_bottom_gnb.svg">' : '<i class="ic_gnb"></i>';
		$shop_bottom_search = file_exists(G5_DATA_PATH.'/shop_icon/shop_bottom_tab3.svg') ? '<img src="'.G5_DATA_URL.'/shop_icon/shop_bottom_search.svg">' : '<i class="ic_search"></i>';
		$shop_bottom_store = file_exists(G5_DATA_PATH.'/shop_icon/shop_bottom_store.svg') ? '<img src="'.G5_DATA_URL.'/shop_icon/shop_bottom_store.svg">' : '<i class="ic_store"></i>';
		$shop_bottom_member = file_exists(G5_DATA_PATH.'/shop_icon/shop_bottom_member.svg') ? '<img src="'.G5_DATA_URL.'/shop_icon/shop_bottom_member.svg">' : '<i class="ic_my"></i>';
		
		$shop_bottom_color = explode("|", $default['shop_bottom_color']);

		$shop_top_menu_list = '<ul style="'.($shop_bottom_color[0]?'--bottom-bg:'.$shop_bottom_color[0].';':'').($shop_bottom_color[1]?'--bottom-color:'.$shop_bottom_color[1].';--mainColor:'.$shop_bottom_color[1].';':'').'">';
			if($default['shop_bottom_use_home']) $shop_top_menu_list .= '<li><a href="'.G5_URL.'"'.(defined('_INDEX_')?' class="active"':'').'"><span class="myIcon">'.$shop_bottom_home.'</span><span class="txt">'.$shop_bottom_tabs_name1.'</span></a></li>';
			if($default['shop_bottom_use_gnb']) $shop_top_menu_list .= '<li><a href="'.shop_short_url_my('shopCate').'"'.(defined('_SHOPCATE_')?' class="active"':'').'"><span class="myIcon">'.$shop_bottom_gnb.'</span><span class="txt">'.$shop_bottom_tabs_name2.'</span></a></li>';
			if($default['shop_bottom_use_search']) $shop_top_menu_list .= '<li><a href="'.shop_short_url_my('search').'"'.(defined('_SHOPSEARCH_')?' class="active"':'').'"><span class="myIcon">'.$shop_bottom_search.'</span><span class="txt">'.$shop_bottom_tabs_name3.'</span></a></li>';
			if($default['shop_bottom_use_store']) $shop_top_menu_list .= '<li><a href="'.shop_short_url_my('shopStore').'"'.(defined('_SHOPSTORE_')?' class="active"':'').'"><span class="myIcon">'.$shop_bottom_store.'</span><span class="txt">'.$store_label.'검색</span></a></li>';
			if($default['shop_bottom_use_member']) $shop_top_menu_list .= '<li><a href="'.($is_member?shop_short_url_my('mypage'):G5_BBS_URL.'/login.php?pn=login_intro').'"'.(defined('_SHOPMYPAGE_')?' class="active"':'').'"><span class="myIcon">'.$shop_bottom_member.'</span><span class="txt">'.$shop_bottom_tabs_name4.'</span></a></li>';
		$shop_top_menu_list .= '</ul>';
	}

	return $shop_top_menu_list;
}


// ───────────────────────────────────────────────────────────────────
//														상품유형 메뉴
// ───────────────────────────────────────────────────────────────────
/*function get_itemtype_menu($all=true) {
    global $g5, $default;
	
	$type = isset($_REQUEST['type']) ? preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\s]/", "", $_REQUEST['type']) : '';
	$itemtype = explode("|", $default['itemtype']);
	$itemtype_menu = '<ul>';
	for ($i=0; $i < count($itemtype); $i++) {
		$num = $i + 1;		
		if($itemtype[$i]) {
			$itemtype_name[$i] = explode("/", $itemtype[$i]);
			if(count($itemtype_name[$i]) > 1) {
				$itemtype[$i] = '<div class="rolling-text">';
				for ($r=0; $r < count($itemtype_name[$i]); $r++) {
					$itemtype[$i] .= '<span>'.$itemtype_name[$i][$r].'</span>';
				}
				$itemtype[$i] .= '</div>';
			}

			$itemtype_menu .= '<li><a href="'.shop_type_url($num).'"'.($type==$num?' class="active"':'').'>'.$itemtype[$i].'</a></li>';
		}
	}
	if($all) $itemtype_menu .= '<li><a href="'.shop_type_url('all').'"'.($type=='all'?' class="active"':'').'>전체상품</a></li>';
	$itemtype_menu .= '</ul>';

    return $itemtype_menu;
}*/


// ───────────────────────────────────────────────────────────────────
//															상품 정렬
// ───────────────────────────────────────────────────────────────────
function get_shop_item_sort($href) {
	global $g5, $sort, $sortodr;
	
	$_s = strpos($href, '?') !== false ? '&' : '?';

	$select = '';
	$select .= '<section id="_itemSort">';
		$select .= '<select class="select-link selectpicker">';
			$select .= '<option value="'.$href.$_s.'"'.($sort==''?' selected':'').'>상품정렬</option>';
			$select .= '<option value="'.$href.$_s.'sort=it_price&amp;sortodr=asc"'.($sort=='it_price'&&$sortodr=='asc'?' selected':'').'>낮은가격순</option>';
			$select .= '<option value="'.$href.$_s.'sort=it_price&amp;sortodr=desc"'.($sort=='it_price'&&$sortodr=='desc'?' selected':'').'>높은가격순</option>';
			$select .= '<option value="'.$href.$_s.'sort=it_name&amp;sortodr=asc"'.($sort=='it_name'&&$sortodr=='asc'?' selected':'').'>상품명순</option>';
		$select .= '</select>';
	$select .= '</section>';

	return $select;
}


// ───────────────────────────────────────────────────────────────────
//												쇼핑몰 카테고리 (슬라이드형, 목록형)
// ───────────────────────────────────────────────────────────────────
$shopCates = get_shop_category_array(true);
function get_shopCate_list($option="slide|4.5|15|0", $img=false, $all=false, $class="", $href="") {
	global $g5, $shopCates, $is_admin;
	
	$ca_id = $_GET['ca_id'];

	$i = 0;
	foreach($shopCates as $_shopCate) {
		if( empty($_shopCate) ) continue;
		$shopCate[$i] = $_shopCate['text'];
		$i++;
	}

	$shopCate_str = '';

	$catetype = explode('|', $option);
	$type = $catetype[0] ? $catetype[0] : 'list';
	$per = $catetype[1] ? $catetype[1] : 1;
	$gap = $catetype[2] ? $catetype[2] : 15;
	$radius = $catetype[3] ? $catetype[3] : 0;

	if($all) {
		$all_url = $href ? $href : shop_category_url('all');
		if($img) {
			$ca_all_path = G5_DATA_PATH.'/shop_cate/ca_all_img';
			if(file_exists($ca_all_path)) {
				$ca_all_thumb = thumbnail('ca_all_img', G5_DATA_PATH.'/shop_cate/', G5_DATA_PATH.'/shop_cate/', 120, '', 1, 1, 'center');	
				$ca_all_img = '<img src="'.G5_DATA_URL.'/shop_cate/'.$ca_all_thumb.'">';
			} else {
				$ca_all_img = '<span class="no_ca_img"></span>';
			}
		}
		$shopCate_str .= $type == 'slide' ? '<div class="swiper-slide'.$active[$i].'"><a href="'.$all_url.'" class="cate'.(!$ca_id||$ca_id=='all'?' active':'').'">'.$ca_all_img.'<span class="subject">전체</span></a></div>' : '<li class="'.$active[$i].($per>=3?' column':'').'"><a href="'.$all_url.'" class="cate">'.$ca_all_img.'<span class="subject">전체</span></a></li>';
	}

	for ($i=0; $i<count($shopCates); $i++) {
		$active[$i] = $ca_id == $shopCate[$i]['ca_id'] ? ' active':'';
		$shopCate[$i]['url'] = $href ? $href.'&ca_id='.$shopCate[$i]['ca_id'] : $shopCate[$i]['url'];
		$shopCate_str .= $type == 'slide' ? '<div class="swiper-slide'.$active[$i].'">' : '<li class="'.$active[$i].($per>=3?' column':'').'">';
		$shopCate_str .= '<a href="'.$shopCate[$i]['url'].'" class="cate'.$active[$i].'">';
		if($img) {
			$img_path[$i] = G5_DATA_PATH.'/shop_cate/'.$shopCate[$i]['ca_id'];
			if(file_exists($img_path[$i])) {
				$ca_thumb[$i] = thumbnail($shopCate[$i]['ca_id'], G5_DATA_PATH.'/shop_cate/', G5_DATA_PATH.'/shop_cate/', 120, '', 1, 1, 'center');								
				$shopCate_str .= '<img src="'.G5_DATA_URL.'/shop_cate/'.$ca_thumb[$i].'">';
			} else {
				$shopCate_str .= '<span class="no_ca_img"></span>';
			}
		}
		$shopCate_str .= '<span class="subject">'.$shopCate[$i]['ca_name'].'</span>';
		$shopCate_str .= '</a>';
		$shopCate_str .= $type == 'slide' ? '</div>' : '</li>';
	}

	if($is_admin && $img) $shopCate_str .= '<a href="'.G5_BBS_URL.'/my/_adm/?tab=1&pn=_shop_cate_setting&title=카테고리 이미지 관리" class="btnSetting popWin" data-width="1250" data-height="700" data-top="60" data-left="0" data-area=".shopCategory">카테고리 이미지 관리</a>';
	
	if($shopCate_str) {
		$class = $class ? ' '.$class : '';
		$shopCate_str = $type == 'slide' ? '<div class="shopCategory mySwiper'.$class.'" data-per="'.$per.'" data-gap="'.$gap.'" data-loop="false" style="--radius:'.$radius.'px;"><div class="swiper-container"><div class="swiper-wrapper">'.$shopCate_str.'</div></div></div>' : '<ul class="shopCategory'.$class.'" style="--cols:'.$per.';--gap:'.$gap.'px;--radius:'.$radius.'px;">'.$shopCate_str.'</ul>';
	}

	return $shopCate_str;
}


// ───────────────────────────────────────────────────────────────────
//													상품 카테고리 호출
// ───────────────────────────────────────────────────────────────────
function get_shopCate_menu($img='') {
	global $g5, $ca_id;
	$shopCategory = '';
	$mshop_categories = get_shop_category_array(true);
	//$shopCategory .= '<div class="_shopCate_menu">';
	$shopCategory .= '<a href="'.G5_SHOP_URL.'/list.php?ca_id=all&ca_id2=&price=&tags=" class="a_1cha"><div class="all">전체</div></a>';
	
	$shopCategory .= '<div class="inner">';
	// 1단계 분류 판매 가능한 것만
	$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
	$i = 0;
	foreach($mshop_categories as $cate1) {
		if( empty($cate1) ) continue;

		$row = $cate1['text'];
		$gnb_zindex -= 1; // html 구조에서 앞선 gnb_1dli 에 더 높은 z-index 값 부여
		// 2단계 분류 판매 가능한 것만
		$count = ((int) count($cate1)) - 1;
		
		$shopCategory .= '<ul class="shopCate_1cha_ul">';
			if($row['ca_menu_use']) {
				$shopCategory .= '<li class="shopCate_1cha_li'.($count?' hasSub':'').($row['ca_id']==$ca_id?' active':'').'">';
					//$shopCategory .= '<a href="'.$row['url'].'" class="a_1cha">'.$row['ca_name'].'</a>';
			
					$j=0;
					foreach($cate1 as $key=>$cate2) {
						if( empty($cate2) || $key === 'text' ) continue;
					
						$row2 = $cate2['text'];
						if ($j==0) $shopCategory .= '<ul class="shopCate_2cha_ul">';
						if($row2['ca_menu_use']) {
							$shopCategory .= '<li class="shopCate_2cha_li'.($row2['ca_id']==$ca_id?' active':'').'">';						
								$shopCategory .= '<a href="'.$row2['url'].'" class="a_2cha">';
								if($img=='img') {
									$img_path[$j] = G5_DATA_PATH.'/shop_cate/'.$row2['ca_id'];
									if(file_exists($img_path[$j])) {
										//$ca_thumb[$i] = thumbnail($row2['ca_id'], G5_DATA_PATH.'/shop_cate/', G5_DATA_PATH.'/shop_cate/', '', '', 1, 1, 'center');								
										$shopCategory .= '<img src="'.G5_DATA_URL.'/shop_cate/'.$row2['ca_id'].'">';
									}
								}
								$shopCategory .= $row2['ca_name'];
								$shopCategory .= '</a>';
							$shopCategory .= '</li>';
							$j++;
						}
					}   //end for
					if ($j>0) $shopCategory .= '</ul>';

				$shopCategory .= '</li>';
			}
		$shopCategory .= '</ul>';
	$i++;
	}   //end for
	
	$shopCategory .= '</div>';

	return $shopCategory;
}


// ───────────────────────────────────────────────────────────────────
//														쇼핑몰 배너 출력
// ───────────────────────────────────────────────────────────────────
function shop_banner($position='', $skin='', $itemsOrder='', $itemsCount='', $items_sel_li_id='', $cols=1, $gap=0, $padding='', $items_radius='') {
	global $g5, $css, $default, $is_admin, $_adm_url, $is_shop_manager;

	if(!$skin) $skin = '_block_banner.skin.php';

	$skin_path = G5_SHOP_SKIN_PATH.'/'.$skin;
	if(G5_IS_MOBILE && file_exists(G5_MSHOP_SKIN_PATH.'/'.$skin)) $skin_path = G5_MSHOP_SKIN_PATH.'/'.$skin;

	if(file_exists($skin_path)) {
		$sql_device = " and ( bn_device = 'both' or bn_device = 'pc' ) ";
		if(G5_IS_MOBILE) $sql_device = " and ( bn_device = 'both' or bn_device = 'mobile' ) ";

		$where = "and bn_position = '$position' ";

		if($position=='상단 띠배너') {
			if(!defined('_INDEX_')) {
				$where .= "and bn_location = 'all' ";
			}
		}
		
		$itemsOrder = explode("|", $itemsOrder);
		$pager_type = $itemsOrder[1]; 
		if($position) $itemsCount = 10; //메인팝업, 상단띠배너, 사이드배너는 맥스 10개정도에서 자른다..
		$itemsCount = $itemsCount ? $itemsCount : 2; //블럭 베너에 디폴트는 2개..


		if($itemsOrder[0] == 'list_of_select' && $items_sel_li_id) {			
			//직접선택
			$sel_li_ids = explode(",", $items_sel_li_id);
			$where .= " AND (";
			for ($t=0; $t<count($sel_li_ids); $t++) {
				$sel_li_id = trim($sel_li_ids[$t]);
				if($sel_li_id=='') continue;
				if($t>0) $where .= ' || ';
				$where .= 'bn_id = '.$sel_li_id.'';
			}
			$where .= ") ";
			$limit = '';
			
		} else if($itemsOrder[0]) {
			$where .= "and bn_cate = '$itemsOrder[0]' ";			
			$limit = "limit 0, ".$itemsCount;
		} else {
			$limit = "limit 0, ".$itemsCount;
		}
		$sql = " select * from {$g5['g5_shop_banner_table']} where ('".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time || bn_end_time='0000-00-00 00:00:00') $sql_device {$where} order by bn_order, bn_id desc {$limit}";
		$result = sql_query($sql);

		//출력할 배너수
		$bannerCount = mysqli_num_rows($result);			
		//if($bannerCount) $result = include $skin_path;
	} else {
		echo '<p class="tcenter">'.str_replace(G5_PATH.'/', '', $skin_path).'파일이 존재하지 않습니다.</p>';
	}

	ob_start();	
	if($bannerCount) include $skin_path;
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;
}


// ───────────────────────────────────────────────────────────────────
//														상품 후기 출력
// ───────────────────────────────────────────────────────────────────
function bl_itemuse($skin='', $itemuseOrder='', $itemuseCount='', $items_sel_li_id='', $itemuse_cols=0, $itemuse_gap=0, $itemuse_radius=0, $itemuse_skin='', $padding='') {
	global $g5, $css, $default, $is_admin, $_adm_url;

	if(!$skin) $skin = '_block_itemuse.skin.php';

	$skin_path = G5_SHOP_SKIN_PATH.'/'.$skin;
	if(G5_IS_MOBILE && file_exists(G5_MSHOP_SKIN_PATH.'/'.$skin)) $skin_path = G5_MSHOP_SKIN_PATH.'/'.$skin;

	if(file_exists($skin_path)) {
		$itemuseOrder = explode("|", $itemuseOrder);
		$itemuseCount = $itemuseCount ? $itemuseCount : 2; //블럭 베너에 디폴트는 2개..
		
		$sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
		$sql_search = " where a.is_confirm = '1' ";
		$order = "a.is_id desc";

		if($itemuseOrder[0] == 'list_of_select' && $items_sel_li_id) {
			//직접선택
			$sel_li_ids = explode(",", $items_sel_li_id);
			$sql_search .= " AND (";
			for ($t=0; $t<count($sel_li_ids); $t++) {
				$sel_li_id = trim($sel_li_ids[$t]);
				if($sel_li_id=='') continue;
				if($t>0) $sql_search .= ' || ';
				$sql_search .= 'a.is_id = '.$sel_li_id.'';
			}
			$sql_search .= ") ";
			$limit = '';
			
		} else if($itemuseOrder[0]=='best') {		
			$limit = "limit 0, ".$itemuseCount;
			$order = "a.is_score desc, a.is_id desc";
		} else {
			$limit = "limit 0, ".$itemuseCount;
		}
		
		$sql = " select * $sql_common $sql_search order by {$order} {$limit} ";
		$result = sql_query($sql);

		//출력할 후기수
		$itemuseCount = mysqli_num_rows($result);
	} else {
		echo '<p class="tcenter">'.str_replace(G5_PATH.'/', '', $skin_path).'파일이 존재하지 않습니다.</p>';
	}

	ob_start();	
	if($itemuseCount) include $skin_path;
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;
}


// ───────────────────────────────────────────────────────────────────
//														믹스형 블럭 스킨 인크루드
// ───────────────────────────────────────────────────────────────────
function get_include_mix_skin($bl_id) {
	global $g5;
	
	$shopblock_sql = "select * from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
	$shopblock = sql_fetch($shopblock_sql);

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
	$_mix_url = str_replace(G5_PATH, G5_URL, $_mix_path);

	//add_stylesheet('<link rel="stylesheet" href="'.get_url($_mix_url.'/_mix_style.css">', 3);

	$skin_path = $_mix_path.$shopblock['mix_type'].'/_mix.skin.php';

	ob_start();	
	if(file_exists($skin_path)) include $skin_path;
	$content .= '<div class="mixContainer" data-mix-type="'.$shopblock['mix_type'].'">';
	$content .= '<link rel="stylesheet" href="'.get_url($_mix_url.'/_mix_style'.(G5_IS_MOBILE?'_mobile':'').'.css').'">';
	$content .= ob_get_contents();
	$content .= '</div>';
	ob_end_clean();

	return $content;	
}


// ───────────────────────────────────────────────────────────────────
//												믹스형블럭에서 상품 출력
// ───────────────────────────────────────────────────────────────────
function get_mix_item($it_id, $items_skin='_slide', $img_width=350, $img_height=350) {
	global $g5, $is_admin, $default, $member, $config;
	
	add_javascript('<script src="'.G5_JS_URL.'/shop.list.action.js"></script>', 10);
	$mbq = sql_fetch("select * from `g5_member_grade` where idx = '".$member['mb_grade']."' ");

	$sql = " select * from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);
	
	$item_link_href = shop_item_url($it['it_id']);     // 상품링크
	$star_score = $it['it_use_avg'] ? (int) get_star($it['it_use_avg']) : '';     //사용자후기 평균별점
	$is_soldout = is_soldout($it['it_id'], true);   // 품절인지 체크

	$str = '';
	$str .= $items_skin == '_slide' ? '<div class="swiper-slide item-list sct_li">' : '<li class="item-list sct_li">';

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
			if($is_soldout) $str .= '<span class="shop_icon_soldout"><span class="soldout_txt" style="position:absolute;top:0px;left:0px;color:#000;background:rgba(255, 255, 255, 0.8);width:100%;height:100%;text-align:center;padding-top:60%">SOLD OUT</span></span>';	
			
			$it_timer_arr[$i] = explode('|', $it['it_timer']);
			if($it_timer_arr[$i][0]) $str .= get_buy_timer($it['it_id']);

			if(!$is_soldout) $str .= '<div class="sct_btn list-10-btn"><button type="button" class="btn_cart sct_cart" data-it_id="'.$it['it_id'].'">장바구니</button></div>';
			//$str .= '<div class="cart-layer"></div>';
		$str .= '</div>';
		//$str .= $config['cf_grade']." - ".$mbq['g_discount'];
		$str .= '<div class="itemCon">';
			//$it_timer_arr[$i] = explode('|', $it['it_timer']);
			//if($it_timer_arr[$i][0]) $str .= get_buy_timer($it['it_id']);
			$str .= '<div class="head">';
				$str .= '<div class="subject">';
					$str .= '<a href="'.$item_link_href.'">'.stripslashes($it['it_name']).'</a>';
				$str .= '</div>';
			$str .= '</div>';
			if($it['it_basic'] && !G5_IS_MOBILE) $str .= '<div class="item_basic">'.$it['it_basic'].'</div>'; //모바일에서 설명글 삭제
			$str .= '<div class="priceInfo">';
				if($it['it_tel_inq']){
					$str .= '<span class="price">'.$it['it_tel_inq_text'].'</span>';
				}else{
					if($config['cf_grade'] == 1 && $mbq['g_discount'] > 0){ //할인율이 존재할경우
						if($it['it_grade']){
							$prii = $it['it_cust_price']?$it['it_cust_price']:$it['it_price'];
							$discount_rate = round(($prii - get_price($it)) / $prii * 100);
							$str .= '<span class="price before">'.display_price($prii).'</span>';
							$str .= '<span class="rate">'.$discount_rate.'%</span>';
							/*
							$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
							$str .= '<span class="price before">'.display_price($it['it_price']).'</span>';
							$str .= '<span class="rate">'.$discount_rate.'%</span>';
							*/
						}else{
							$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
							$str .= '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
							$str .= '<span class="rate">'.$discount_rate.'%</span>';
						}
						$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
					}else{
						if(get_time_price($it['it_id'])) {
								$prii = $it['it_cust_price']?$it['it_cust_price']:$it['it_price'];
								$discount_rate = round(($prii - get_price($it)) / $prii * 100);
								$str .= '<span class="price before">'.display_price($prii).'</span>';
								$str .= '<span class="rate">'.$discount_rate.'%</span>';				
								$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
						}else{
							if($it['it_cust_price']){
								$discount_rate = round(($it['it_cust_price'] - get_price($it)) / $it['it_cust_price'] * 100);
								if($it['it_cust_price']) $str .= '<span class="price before">'.display_price($it['it_cust_price']).'</span>';
								if($it['it_cust_price']) $str .= '<span class="rate">'.$discount_rate.'%</span>';			
								//$str .= '<span class="price">'.display_price(get_price($it), $it['it_tel_inq']).'</span>';
								$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
							}else{
								//$discount_rate = round(($it['it_price'] - get_price($it)) / $it['it_price'] * 100);
								//$str .= '<span class="price before">'.display_price($it['it_price']).'</span>';
								//$str .= '<span class="rate">'.$discount_rate.'%</span>';			
								//$str .= '<span class="price">'.display_price(get_price($it), $it['it_tel_inq']).'</span>';
								$str .= '<span class="price">'.display_price(get_price($it)).'</span>';
							}
						}
					}
				}
			$str .= '</div>';
			$str .= get_it_tag($it['it_id'], 4);
		$str .= '</div>';
		if($is_admin) $str .= '<a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&amp;it_id='.$it['it_id'].'&amp;ca_id='.$it['ca_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
	
	$str .= $items_skin == '_slide' ? '</div>' : '</li>';

	return $str;	
}




// ───────────────────────────────────────────────────────────────────
//												믹스형블럭에서 배너 출력
// ───────────────────────────────────────────────────────────────────
function get_mix_banner($banner_id, $items_skin='_slide', $img_width=350, $img_height=350) {
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

			$str .= $items_skin == '_slide' ? '<div class="swiper-slide item-list banner-list">' : '<li class="item-list banner-list">';
			if ($row['bn_url'][0] == '#')
				$banner .= '<a href="'.$row['bn_url'].'">';
			else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
				$banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.($row['bn_new_win']?' target="_blank"':'').'>';
			}
			$banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'];
			if(G5_IS_MOBILE && file_exists(G5_DATA_PATH.'/banner/'.$row['bn_id'].'_2')) $banner_url[$i] = G5_DATA_URL.'/banner/'.$row['bn_id'].'_2';
			$str .= $banner.'<div class="imgbox"><img src="'.$banner_url[$i].'" width="'.$size[0].'" alt="'.get_text($row['bn_alt']).'"></div>';
			if($banner) $str .= '</a>'.PHP_EOL;
			if($is_admin) $str .= '<a href="'.G5_ADMIN_URL.'/shop_admin/bannerform.php?w=u&amp;bn_id='.$row['bn_id'].'" class="" target="_blank"><span class="btnEdit">수정</span></a>';
			$str .= $items_skin == '_slide' ? '</div>' : '</li>';
		}
	}

	return $str;	
}





// ───────────────────────────────────────────────────────────────────
//														블럭에서 ajax로 상품 로드
// ───────────────────────────────────────────────────────────────────
function get_include_tabs_items_cate($bl_id, $items_radius) {
	global $g5, $is_admin, $_adm_url;
	
	$shopblock_sql = "select * from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
	$shopblock = sql_fetch($shopblock_sql);

	$_inc_path = G5_SHOP_SKIN_PATH.'/_block_tabs_item_cate.skin.php';
	
	ob_start();
	$content = '';
	if(file_exists($_inc_path)) include $_inc_path;
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;	
}





// ───────────────────────────────────────────────────────────────────
//											프론트 검색어 키워드 출력
// ───────────────────────────────────────────────────────────────────
function get_search_keyword() {
	global $g5, $config;
	
	$content = '';
	$content .= '<ul>';
		if($config['cf_use_search_keyword']) {
			$cf_search_keyword = explode(",",$config['cf_search_keyword']);
			for($k=0; $k<count($cf_search_keyword); $k++) {
				$content .= '<li><a href="'.shop_short_url_my('search','','q='.$cf_search_keyword[$k]).'" class="keyword">'.$cf_search_keyword[$k].'</a></li>';
			}
		} else {
			//인기검색어 (기준은 30일전부터 오늘까지 검색어중 랭킹을 얻는다..)
			$to_date = date("Y-m-d");
			$fr_date = date('Y-m-d',strtotime($to_date."-30 day"));
			if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
			if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

			$popular_sql_common = " from {$g5['popular_table']} a ";
			$popular_sql_search = " where trim(pp_word) <> '' and pp_date between '{$fr_date}' and '{$to_date}' ";
			$popular_sql_group = " group by pp_word ";
			$popular_sql_order = " order by cnt desc ";
			$popular_sql = " select pp_word, count(*) as cnt {$popular_sql_common} {$popular_sql_search} {$popular_sql_group} {$popular_sql_order} limit 0, 10 ";
			$popular_result = sql_query($popular_sql);
			for ($i=0; $row=sql_fetch_array($popular_result); $i++) {
				$word = get_text($row['pp_word']);
				$rank = $i + 1;
				$content .= '<li><a href="'.shop_short_url_my('search','','q='.$word).'" class="keyword">'.$word.'</a></li>';
			}
		}
	$content .= '</ul>';

	ob_start();	
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;	
}




// ───────────────────────────────────────────────────────────────────
//														블럭 HTML
// ───────────────────────────────────────────────────────────────────
function get_include_shop_block_html_top($bl_id) {
	global $g5, $pn_id, $is_admin, $_adm_url;

	$section_id = '#section-'.$bl_id.'_top';
	$dir = '_shop_block';
	$include_style_url = G5_HTML_URL.'/'.$dir.'/style.css';
	$include_style_path = G5_HTML_PATH.'/'.$dir.'/style.css';
	$html_img_url = G5_HTML_URL.'/'.$dir.'/img';
	$include_path = G5_HTML_PATH.'/'.$dir.'/_section_'.$bl_id.'_top.php';		
	if(file_exists($include_style_path)) add_stylesheet('<link rel="stylesheet" href="'.get_url($include_style_url).'">', 4);

	ob_start();	
	if(file_exists($include_path)) include $include_path;
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;	
}
function get_include_shop_block_html($bl_id) {
	global $g5, $pn_id, $is_admin, $_adm_url;

	$section_id = '#section-'.$bl_id;
	$dir = '_shop_block';
	$include_style_url = G5_HTML_URL.'/'.$dir.'/style.css';
	$include_style_path = G5_HTML_PATH.'/'.$dir.'/style.css';
	$html_img_url = G5_HTML_URL.'/'.$dir.'/img';
	$include_path = G5_HTML_PATH.'/'.$dir.'/_section_'.$bl_id.'.php';		
	if(file_exists($include_style_path)) add_stylesheet('<link rel="stylesheet" href="'.get_url($include_style_url).'">', 4);

	ob_start();	
	if(file_exists($include_path)) include $include_path;
	$content .= ob_get_contents();
	ob_end_clean();

	return $content;	
}




// ───────────────────────────────────────────────────────────────────
//													상품 이미지 높이 (비율계산)
// ───────────────────────────────────────────────────────────────────
function get_it_height($it_width) {
    global $g5, $default;

	$item_ratio = explode("|", $default['item_ratio']);
	$item_ratio[0] = strlen($item_ratio[0]) ? $item_ratio[0] : 100;
	$item_ratio[1] = strlen($item_ratio[1]) ? $item_ratio[1] : 100;

	$it_height = (int)(($it_width / $item_ratio[0]) * $item_ratio[1]);

    return $it_height;
}


// ───────────────────────────────────────────────────────────────────
//														타임 특가 타이머 (인태)
// ───────────────────────────────────────────────────────────────────
function get_buy_timer($it_id) {
	global $g5;

	add_javascript('<script src="'.G5_JS_URL.'/my/countdown/jquery.plugin.js"></script>', 10);
	add_javascript('<script src="'.G5_JS_URL.'/my/countdown/jquery.countdown.js"></script>', 10);
	
	$sql = " select it_timer, it_time_price from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

	$startdate = date("Y-m-d H:i:s", time());
	$enddate = $it['it_timer'] ? $it['it_timer'].':00' : '';
	$timediffer = strtotime($enddate) - strtotime($startdate);

	$content = '';
	if($it['it_time_price'] && $it['it_timer']) {
		if($timediffer > 0) {
			$content .= '<div class="buy-timer" data-timer="'.$timediffer.'"></div>';
		}
	}
	
	return $content;
}


// ───────────────────────────────────────────────────────────────────
//														상품 태그 출력
// ───────────────────────────────────────────────────────────────────
function get_it_tag($it_id, $limit='') {
	global $g5;
	
	$sql = " select it_tag from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

	$it_tag = explode(",", $it['it_tag']);
	$content = '';
	$count = $limit ? $limit : count($it_tag);
	for ($i=0; $i<$count; $i++) {
		$tag_name = trim($it_tag[$i]);
		if($tag_name=='') continue;			

		$content .= '<span class="itemtag"><a href="'.G5_SHOP_URL.'/list.php?ca_id=all&ca_id2=&price=&tags='.$tag_name.'">'.$tag_name.'</a></span>';
	}
	$content = $content ? '<div class="tagSet">'.$content.'</div>' : '';
	
	return $content;
}




// ───────────────────────────────────────────────────────────────────
//					it_real_price 타임특가 적용시, 적용된 실 판매금액 (가격순 정렬을 위해 칼럼추가)
// ───────────────────────────────────────────────────────────────────
function update_real_price($it_id) {
	global $g5;
	
	$sql = " select it_price, it_timer, it_time_price from {$g5['g5_shop_item_table']} where it_id = '$it_id' ";
    $it = sql_fetch($sql);

	$it_real_price = $it['it_price'];
	if($it['it_time_price'] && $it['it_timer']) {
		$startdate = date("Y-m-d H:i:s", time());
		$enddate = $it['it_timer'] ? $it['it_timer'].':00' : '';
		$timediffer = strtotime($enddate) - strtotime($startdate);
		if($timediffer > 0) {
			$it_real_price = $it['it_time_price'];
		}
	}

	if($it['it_real_price'] != $it_real_price) {
		$sql = " update {$g5['g5_shop_item_table']} set it_real_price = '$it_real_price' where it_id = '$it_id' ";
		sql_query($sql);
	}
}



// ───────────────────────────────────────────────────────────────────
//														할인률 (소수점 표기 포함)
// ───────────────────────────────────────────────────────────────────
function get_discount_rate($price, $cust_price) {
    global $g5, $default;

	if($default['use_item_discount_rate_decimal']) {
		$str = round(($cust_price - $price) / $cust_price * 100, 1);
	} else {
		$str = round(($cust_price - $price) / $cust_price * 100);
	}
	$str .= '%';

    return $str;
}


// ───────────────────────────────────────────────────────────────────
//										테이블 명으로 테이블 제목 얻기 
// ───────────────────────────────────────────────────────────────────
function get_bo_subject($bo_table='') {
    global $g5;	
	$board = sql_fetch(" select bo_subject from {$g5['board_table']} where bo_table='".$bo_table."'");

    return $board['bo_subject'];
}




// ───────────────────────────────────────────────────────────────────
//													상품 타입 (배송상품, 예약상품)
// ───────────────────────────────────────────────────────────────────
function get_it_type($it_id='') {
    global $g5;	
	$it = sql_fetch(" select it_type from {$g5['g5_shop_item_table']} where it_id='".$it_id."'");

    return $it['it_type'];
}


// ───────────────────────────────────────────────────────────────────
//													기업코드 -> 기업이름
// ───────────────────────────────────────────────────────────────────
function get_code_name($code_id) {
    global $g5;	

	$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';
	$sql = " select * from {$g5['membercode_table']} where code_id = '$code_id' ";
	$code = sql_fetch($sql);

    return $code['code_name'];
}



// 이벤트 진행 여부
function get_event_live($start, $end) {
	
	$start_date = new DateTime($start);
	$end_date = new DateTime($end);
	$now = new DateTime();
	$dday = (strtotime($start) - strtotime(date("Y-m-d", time()))) / 86400;	
	if($start_date > $now) {
		$live_msg = '<span class="fs14 fw500">라이브 '.$dday.'일 전</span>';
	} else if(($start_date < $now && $end_date > $now) || $end == '00-00-00 00:00') {
		$live_msg = '<span class="fs14 fw500 mainColor">진행중</span>';
	} else if($end_date < $now) {
		$live_msg = '<span class="fs14 fw500">종료</span>';
	}

    return $live_msg;
}

//상품별 찜 카운트 (위시리스트)
function get_wish_item_count($it_id) {
    global $g5;
	
	$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';
    $sql = " select count(*) as cnt from {$g5['g5_shop_wish_table']} where it_id = '$it_id' ";
    $row = sql_fetch($sql);

    return $row['cnt'];
}


//나의 찜 카운트 (위시리스트)
function get_my_wish_item_count($mb_id) {
    global $g5, $member;

    $sql = " select count(*) as cnt from {$g5['g5_shop_wish_table']} where mb_id = '{$member['mb_id']}' ";
    $row = sql_fetch($sql);

    return $row['cnt'];
}
$my_wish_count = get_my_wish_item_count($member['mb_id']);


//나의 쿠폰 카운트
function get_my_coupon_count() {
    global $g5, $member;

	$sql = " select cp_id, cp_subject, cp_method, cp_target, cp_start, cp_end, cp_type, cp_price
            from {$g5['g5_shop_coupon_table']}
            where (mb_id IN ( '{$member['mb_id']}', '전체회원' )
			  or mb_grade like '%{$member['mb_grade']}%')
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."'
            order by cp_no ";
	$result = sql_query($sql);

	$cp_count = 0;
	for($i=0; $row=sql_fetch_array($result); $i++) {
		if(is_used_coupon($member['mb_id'], $row['cp_id']))
			continue;

		$cp_count++;
	}

    return $cp_count;
}





//나의후기 카운트
function get_my_itemuse_count($mb_id) {
    global $g5, $member;

	$sql = " select count(*) as cnt from {$g5['g5_shop_item_use_table']} a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) where a.is_confirm = '1' and a.mb_id='{$member['mb_id']}' ";
    $row = sql_fetch($sql);

    return $row['cnt'];
}
$my_itemuse_count = get_my_itemuse_count($member['mb_id']);






// ───────────────────────────────────────────────────────────────────
//														서브메뉴 호출
// ───────────────────────────────────────────────────────────────────

function get_subMenu($gr_id) {
	global $g5, $bo_table;
	$sql = " select gr_subject, gr_id, gr_main_table from {$g5['group_table']} where gr_id = '{$gr_id}' order by gr_order, gr_id  ";
	$result = sql_query($sql);
	$str = '';
	for ($gi=0; $row=sql_fetch_array($result); $gi++) { // gi 는 group index
		$sql2 = " select bo_table, bo_subject, bo_skin from {$g5['board_table']} where gr_id = '{$row['gr_id']}' {$where} order by bo_order ";
		$result2 = sql_query($sql2);
		$str .= '<ul>';		
			for ($bi=0; $row2=sql_fetch_array($result2); $bi++) {
				$str .= '<li><a href="'.get_pretty_url($row2['bo_table']).'" class="'.($bo_table==$row2['bo_table']?'active':'').'">'.$row2['bo_subject'].'</a></li>';
			}
		$str .= '</ul>';
	}
	return $str;
}



// ───────────────────────────────────────────────────────────────────
//														선택된 지점 상품 수
// ───────────────────────────────────────────────────────────────────
function get_store_items_count($store_id) {
	global $g5;
	$sql = " select count(*) as cnt
				from {$g5['g5_shop_store_item_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
				where a.store_id = '$store_id' ";
	$row = sql_fetch($sql);
	return $row['cnt'];
}






//관리자(팝업) 경로
$_adm_url = G5_BBS_URL.'/my/_adm';



if (!defined('G5_IS_ADMIN') && !$add_headfile_skin) {
	// ───────────────────────────────────────────────────────────────────────────────────────────────────────
	//																					쇼핑몰 전용 스크립트
	// ───────────────────────────────────────────────────────────────────────────────────────────────────────
	// [_common]
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/_common.js').'"></script>', 1);

	// [easing]
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/easing.js').'"></script>', 1);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/jquery.transit.min.js').'"></script>', 1);
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/animation/animations.css').'">', 1);
	add_javascript('<script type="text/javascript" src="'.get_url('https://cdnjs.cloudflare.com/ajax/libs/egjs-jquery-transform/2.0.0/transform.min.js').'"></script>', 1);

	// [ScrollTrigger]
	add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>',1);
	add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/ScrollTrigger.min.js"></script>',1);

	// [bootstrap-select]
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.css').'">', 1);
	add_javascript('<script type="text/javascript" src="'.G5_JS_URL.'/my/form/bootstrap-select/bootstrap.min.js"></script>', 1);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.js').'"></script>', 1);
	//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_JS_URL.'/my/bootstrap-select/bootstrap-select.css').'">', 3);
	//add_javascript('<script src="'.G5_THEME_JS_URL.'/my/bootstrap-select/bootstrap.min.js"></script>', 2);
	//add_javascript('<script src="'.get_url(G5_THEME_JS_URL.'/my/bootstrap-select/bootstrap-select.js').'"></script>', 2);

	// [magnific-popup]
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/magnific-popup/magnific-popup.css').'">', 1);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/magnific-popup/jquery.magnific-popup.js').'"></script>', 1);
	//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_JS_URL.'/my/magnific-popup/magnific-popup.css').'">', 3);
	//add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js"></script>', 2);

	// [swiper]
	//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/swiper/swiper.min.css').'">', 3);
	//add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/swiper/swiper.min.js').'"></script>', 2);
	//add_stylesheet('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />', 3);
	//add_javascript('<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>', 2);
	//add_stylesheet('<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />', 3);
	//add_javascript('<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>', 2);
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/swiper-bundle.min20240501.css').'">', 3);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/swiper-bundle.min20240501.js').'"></script>', 2);
	// [colorpicker]
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.css').'">', 1);
	add_javascript('<script type="text/javascript" src="'.G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.js"></script>', 1);

	// [myform]
	add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>', 1);
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform'.(G5_IS_MOBILE?'-sm':'-lg').'.js').'"></script>', 1);
	
	// [board]
	if($board['bo_table']) add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_shop_board'.(G5_IS_MOBILE?'_mobile':'').'.css').'">', 3); //쇼핑몰 게시판

	// [myShop]
	add_javascript('<script src="'.get_url(G5_JS_URL.'/my/myShop.js').'"></script>', 11);
	if(!G5_IS_MOBILE) {
		if(file_exists(G5_THEME_PATH.'/js/my/themeShop.js')) add_javascript('<script src="'.get_url(G5_THEME_JS_URL.'/my/themeShop.js').'"></script>', 12);
	} else {
		if(file_exists(G5_THEME_PATH.'/js/my/themeShop_mobile.js')) add_javascript('<script src="'.get_url(G5_THEME_JS_URL.'/my/themeShop_mobile.js').'"></script>', 12);
	}
}
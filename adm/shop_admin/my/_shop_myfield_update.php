<?php
include_once('./_common.php');
if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');



// 쇼핑몰 기본 레이아웃
if(!isset($default['shop_header_width'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_header_width` INT(11) NOT NULL DEFAULT '0' after `de_member_reg_coupon_minimum` ", true);
}

// 쇼핑몰 기본 레이아웃
if(!isset($default['shop_layout'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_layout` varchar(255) NOT NULL DEFAULT '' after `shop_header_width` ", true);
}

//쇼핑몰 슬로건
if(!isset($default['shop_slogan'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_slogan` varchar(255) NOT NULL DEFAULT '' after `shop_layout` ", true);
}

//쇼핑몰 상단 메뉴관리 테이블 생성
if(!sql_query(" DESCRIBE {$g5['g5_shop_top_menu_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['g5_shop_top_menu_table']} (
				  `shopmenu_id` int(11) NOT NULL AUTO_INCREMENT,
				  `shopmenu_order` int(11) NOT NULL DEFAULT '0',
				  `shopmenu` varchar(255) NOT NULL DEFAULT '',
				  `shopmenu_name` varchar(255) NOT NULL DEFAULT '',
				  `shopmenu_link` varchar(255) NOT NULL DEFAULT '',
				  `shopmenu_link_option` varchar(30) NOT NULL DEFAULT '',
				  PRIMARY KEY (`shopmenu_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}


// 상품리뷰정책
if(!isset($default['de_review_guide'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_review_guide` text NOT NULL after `de_shop_mobile_skin` ", true);
}
// 상품유형 추가
if(!isset($default['itemtype'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `itemtype` varchar(255) NOT NULL DEFAULT '베스트|신상품|추천|할인' ", true);
}
if(!isset($default['itemtype_color'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `itemtype_color` varchar(255) NOT NULL DEFAULT '' after `itemtype` ", true);
}

// 헤더관리
if(!isset($default['shop_header_ui'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_header_ui` varchar(255) NOT NULL DEFAULT '' after `itemtype_color`,
					ADD `shop_header_scrollhidden` int(11) NOT NULL DEFAULT '0' after `shop_header_ui`
					", true);
}
if(!isset($default['shop_header_color'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_header_color` varchar(255) NOT NULL DEFAULT '' ", true);
}
//헤더 - 매장검색 사용유무
if(!isset($default['shop_header_use_store'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_header_use_store` tinyint(4) NOT NULL DEFAULT '0' ", true);
}

// 하단 텝메뉴바 설정
if(!isset($default['shop_bottom_tabs_scrollhidden'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_bottom_tabs_scrollhidden` int(11) NOT NULL DEFAULT '0',
					ADD `shop_bottom_color` varchar(255) NOT NULL DEFAULT '',
					ADD `shop_bottom_tabs_name` varchar(255) NOT NULL DEFAULT '' ", true);
}
//하단 - 매장검색 사용유무
if(!isset($default['shop_bottom_use_store'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_bottom_use_store` tinyint(4) NOT NULL DEFAULT '0' ", true);
}
//하단 - 아이콘 사용유무
if(!isset($default['shop_bottom_use_home'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_bottom_use_home` tinyint(4) NOT NULL DEFAULT '1',
					ADD `shop_bottom_use_gnb` tinyint(4) NOT NULL DEFAULT '1',
					ADD `shop_bottom_use_search` tinyint(4) NOT NULL DEFAULT '1',
					ADD `shop_bottom_use_member` tinyint(4) NOT NULL DEFAULT '1' ", true);
}

// 배너 분류 설정
if(!isset($default['shop_banner_category'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_banner_category` varchar(255) NOT NULL DEFAULT '' ", true);
}

// 배너 닫기버튼 컬러 (띠배너 적용)
if(!isset($default['bn_closer_color'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `bn_closer_color` varchar(30) NOT NULL DEFAULT '' ", true);
}

//매장 -> 라벨명 변경
if(!isset($default['store_label_name'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `store_label_name` varchar(255) NOT NULL DEFAULT '' ", true);
}

// 상품리뷰정책
if(!isset($default['de_review_guide'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `de_review_guide` text NOT NULL ", true);
}

// 폐쇄몰 사용
if(!isset($default['shop_use_closure'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_use_closure` tinyint(4) NOT NULL DEFAULT '0' ", true);
}

// 할인률 소수점 표기
if(!isset($default['use_item_discount_rate_decimal'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD use_item_discount_rate_decimal tinyint(4) NOT NULL DEFAULT '0' ", true);
}

//쇼핑몰 타입설정
if(!isset($default['shop_type'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `shop_type` int(11) NOT NULL DEFAULT '0' ", true);
}

//가격표 ~ 표시
if(!isset($default['use_item_price_deco'])) {
        sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD use_item_price_deco tinyint(4) NOT NULL DEFAULT '0' ", true);
}

//상품 사진 비율
if(!isset($default['item_ratio'])) {
        sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD item_ratio varchar(255) NOT NULL DEFAULT '' ", true);
}

//상품 별점 사용
if(!isset($default['shop_use_it_avg'])) {
        sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD shop_use_it_avg  tinyint(4) NOT NULL DEFAULT '1' ", true);
}


//사진후기 페이지 스킨
if(!isset($default['itemreview_skin'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_default_table']}`
                    ADD `itemreview_skin` varchar(255) NOT NULL DEFAULT '' ", true);
}



/*─────────────────────────────────────────────────────────────────────────────────
																		분류관리
──────────────────────────────────────────────────────────────────────────────────*/
//분류관리 > 분류 수정등록타임
if(!sql_query(" select ca_time from {$g5['g5_shop_category_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` 
					 ADD `ca_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ", true);
}





/*─────────────────────────────────────────────────────────────────────────────────
																		배너관리
──────────────────────────────────────────────────────────────────────────────────*/
//배너 분류
$sql = " select * from {$g5['g5_shop_banner_table']} ";
$bn = sql_fetch($sql);
if(!isset($bn['bn_cate'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                    ADD `bn_cate` varchar(255) NOT NULL DEFAULT '' ", true);
}
//배너 출력할 페이지
if(!isset($bn['bn_location'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                    ADD `bn_location` varchar(255) NOT NULL DEFAULT '' ", true);
}

//배너 logo
if(!isset($bn['bn_log'])) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_banner_table']}`
                    ADD `bn_log` varchar(255) NOT NULL DEFAULT '' ", true);
}




/*─────────────────────────────────────────────────────────────────────────────────
													쇼핑몰 페이지 설정 테이블 생성
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['g5_shop_page_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['g5_shop_page_table']} (
				  `pn_id` varchar(20) NOT NULL DEFAULT '',
				  `pn_subject` varchar(255) NOT NULL DEFAULT '',
				  `pn_1` varchar(255) NOT NULL DEFAULT '',
				  `pn_2` varchar(255) NOT NULL DEFAULT '',
				  `pn_3` varchar(255) NOT NULL DEFAULT '',
				  `pn_4` varchar(255) NOT NULL DEFAULT '',
				  `pn_5` varchar(255) NOT NULL DEFAULT '',
				  PRIMARY KEY (`pn_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}



/*─────────────────────────────────────────────────────────────────────────────────
													쇼핑몰 블럭 관리 테이블 생성
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['g5_shop_block_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['g5_shop_block_table']} (
				  `bl_id` int(11) NOT NULL AUTO_INCREMENT,
				  `bl_device` ENUM( '', 'pc', 'admin' ) NOT NULL DEFAULT '',
				  `bl_order` int(11) NOT NULL DEFAULT '0',
				  `bl_use` ENUM( '', 'none', 'pc', 'mobile', 'admin' ) NOT NULL DEFAULT '',
				  `bl_cate` varchar(255) NOT NULL DEFAULT '',
				  `bl_name` varchar(100) NOT NULL DEFAULT '',
				  `bl_type` varchar(255) NOT NULL DEFAULT '',
				  `bl_title` varchar(255) NOT NULL DEFAULT '',
				  `bl_title_align` enum('','center','right') NOT NULL DEFAULT '',
				  `bl_title_mobile` varchar(255) NOT NULL DEFAULT '',
				  `bl_title_mobile_align` enum('','center','right') NOT NULL DEFAULT '',
				  `bl_title_color` varchar(30) NOT NULL DEFAULT '',
				  `bl_link` varchar(255) NOT NULL DEFAULT '',
				  `bl_link_color` varchar(30) NOT NULL DEFAULT '',
				  `bl_content` varchar(255) NOT NULL DEFAULT '',
				  `bl_width` int(11) NOT NULL DEFAULT '0',
				  `bl_padding` varchar(100) NOT NULL DEFAULT '',
				  `bl_padding_mobile` varchar(100) NOT NULL DEFAULT '',
				  `bl_background` varchar(30) NOT NULL DEFAULT '',
				  `items_skin` varchar(30) NOT NULL DEFAULT '',
				  `tabs_items_cate` varchar(255) NOT NULL DEFAULT '',
				  `items_order_option` varchar(255) NOT NULL DEFAULT '',
				  `items_count` int(11) NOT NULL DEFAULT '0',
				  `items_count_mobile` int(11) NOT NULL DEFAULT '0',
				  `items_sel_li_id` varchar(255) NOT NULL DEFAULT '',
				  `items_cols` FLOAT NOT NULL DEFAULT '0',
				  `items_cols_mobile` FLOAT NOT NULL DEFAULT '0',
				  `items_gap` int(11) NOT NULL DEFAULT '0',
				  `items_gap_mobile` int(11) NOT NULL DEFAULT '0',
				  `items_radius` int(11) NOT NULL DEFAULT '0',
				  `items_radius_mobile` int(11) NOT NULL DEFAULT '0',				  
				  `bl_video` varchar(255) NOT NULL DEFAULT '',
				  `bl_video_src` varchar(255) NOT NULL DEFAULT '',
				  `bl_link1` varchar(255) NOT NULL DEFAULT '',
				  `bl_link2` varchar(255) NOT NULL DEFAULT '',
				  `bl_link3` varchar(255) NOT NULL DEFAULT '',
				  `bl_link4` varchar(255) NOT NULL DEFAULT '',
				  `bl_link5` varchar(255) NOT NULL DEFAULT '',
				  `bl_link6` varchar(255) NOT NULL DEFAULT '',
				  `bl_link7` varchar(255) NOT NULL DEFAULT '',
				  `bl_link8` varchar(255) NOT NULL DEFAULT '',
				  `bl_link9` varchar(255) NOT NULL DEFAULT '',
				  `bl_link10` varchar(255) NOT NULL DEFAULT '',
				  `mix_block` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_1` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_2` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_3` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_4` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_5` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_6` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_7` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_8` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_9` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_10` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_11` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_12` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_13` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_14` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_15` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_16` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_17` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_18` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_19` varchar(255) NOT NULL DEFAULT '',
				  `mix_li_20` varchar(255) NOT NULL DEFAULT '',
				  
				  `bl_btn1` VARCHAR(300) NOT NULL DEFAULT '',
				  `bl_btn1_color` VARCHAR(255) NOT NULL DEFAULT '',
				  `bl_btn2` VARCHAR(300) NOT NULL DEFAULT '',
				  `bl_btn2_color` VARCHAR(255) NOT NULL DEFAULT '',
				  `bl_btn3` VARCHAR(300) NOT NULL DEFAULT '',
				  `bl_btn3_color` VARCHAR(255) NOT NULL DEFAULT '',
				  `bl_btn4` VARCHAR(300) NOT NULL DEFAULT '',
				  `bl_btn4_color` VARCHAR(255) NOT NULL DEFAULT '',
				  `bl_btn_radius` INT(11) NOT NULL DEFAULT '0',

				  PRIMARY KEY (`bl_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}

function get_shop_block($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['g5_shop_block_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$shop_block = get_shop_block();
/*
if(!isset($shop_block['bl_link1'])) {
	sql_query(" ALTER TABLE `{$g5['g5_shop_block_table']}`
					  ADD `bl_link1` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link2` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link3` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link4` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link5` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link6` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link7` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link8` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link9` varchar(255) NOT NULL DEFAULT '',
					  ADD `bl_link10` varchar(255) NOT NULL DEFAULT '' ", true);
}
*/



//카피라이트  [shop_copyright_register.php]
if(!isset($footer['shop_ft_inc'])) {
    sql_query(" ALTER TABLE `{$g5['footer_table']}` 
					 ADD `shop_ft_inc` TINYINT NOT NULL DEFAULT '0',
					 ADD `shop_copyright` text NOT NULL DEFAULT '',
					 ADD `shop_ft_background` varchar(255) NOT NULL DEFAULT '',
					 ADD `footer_menu1` varchar(255) NOT NULL DEFAULT '',
					 ADD `footer_menu2` varchar(255) NOT NULL DEFAULT '',
					 ADD `footer_menu3` varchar(255) NOT NULL DEFAULT '',
					 ADD `footer_menu4` varchar(255) NOT NULL DEFAULT '',
					 ADD `footer_menu5` varchar(255) NOT NULL DEFAULT '' ", true);
}




/*─────────────────────────────────────────────────────────────────────────────────
																		상품 상세
──────────────────────────────────────────────────────────────────────────────────*/
//특가 타이머
if(!sql_query(" select it_timer from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_timer` varchar(255) NOT NULL DEFAULT '' ", true);
}
//타임특가
if(!sql_query(" select it_time_price from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_time_price` int(11) NOT NULL DEFAULT '0' after `it_timer` ", true);
}
//실판매가격 (가격순 정렬을 위해 추가)
if(!sql_query(" select it_real_price from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_real_price` int(11) NOT NULL DEFAULT '0' after `it_time_price` ", true);
}

//상품 정보
if(!sql_query(" select item_info1_label from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `item_info1_label` varchar(255) NOT NULL DEFAULT '',
					 ADD `item_info1_subject` text NOT NULL DEFAULT '',
					 ADD `item_info1_value` text NOT NULL DEFAULT '' ", true);
}
if(!sql_query(" select item_info2_label from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `item_info2_label` varchar(255) NOT NULL DEFAULT '',
					 ADD `item_info2_subject` text NOT NULL DEFAULT '',
					 ADD `item_info2_value` text NOT NULL DEFAULT '' ", true);
}
if(!sql_query(" select item_info3_label from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `item_info3_label` varchar(255) NOT NULL DEFAULT '',
					 ADD `item_info3_subject` text NOT NULL DEFAULT '',
					 ADD `item_info3_value` text NOT NULL DEFAULT '' ", true);
}

//상품 타입
if(!sql_query(" select it_type from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_type`int(11) NOT NULL DEFAULT '0' ", true);
}

//상품 타입
if(!sql_query(" select it_type6 from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_type6` tinyint(4) NOT NULL DEFAULT '0' after `it_type5`,
					 ADD `it_type7` tinyint(4) NOT NULL DEFAULT '0' after `it_type6`,
					 ADD `it_type8` tinyint(4) NOT NULL DEFAULT '0' after `it_type7`,
					 ADD `it_type9` tinyint(4) NOT NULL DEFAULT '0' after `it_type8`,
					 ADD `it_type10` tinyint(4) NOT NULL DEFAULT '0' after `it_type9`
					 ", true);
}

//상품 태그
if(!sql_query(" select it_tag from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_tag`text NOT NULL ", true);
}

//상품 브랜드(매장)
if(!sql_query(" select it_store_id from {$g5['g5_shop_item_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_item_table']}` 
					 ADD `it_store_id` varchar(100) NOT NULL DEFAULT '' ", true);
}



/*─────────────────────────────────────────────────────────────────────────────────
																		분류 관리
──────────────────────────────────────────────────────────────────────────────────*/
//카테고리 메뉴 사용
if(!sql_query(" select ca_menu_use from {$g5['g5_shop_category_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_category_table']}` 
					 ADD `ca_menu_use` int(11) NOT NULL DEFAULT '1' ", true);
}



/*─────────────────────────────────────────────────────────────────────────────────
																	이벤트 관리
──────────────────────────────────────────────────────────────────────────────────*/
//이벤트 배너 링크
if(!sql_query(" select ev_banner_link from {$g5['g5_shop_event_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` 
					 ADD `ev_banner_link` varchar(255) NOT NULL DEFAULT '' ", true);
}
if(!sql_query(" select ev_begin_time from {$g5['g5_shop_event_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` 
					 ADD `ev_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ", true);
}
if(!sql_query(" select ev_end_time from {$g5['g5_shop_event_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` 
					 ADD `ev_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ", true);
}
if(!sql_query(" select ev_order from {$g5['g5_shop_event_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_event_table']}` 
					 ADD `ev_order` int(11) NOT NULL DEFAULT '0' ", true);
}


/*─────────────────────────────────────────────────────────────────────────────────
														모바일 설정[config_mobile.php]
──────────────────────────────────────────────────────────────────────────────────*/
/*
if(!sql_query(" DESCRIBE {$g5['config_mobile_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['config_mobile_table']}` (                  
				  `cfm_top_layout` TINYINT NOT NULL DEFAULT '0',
                  `cfm_top_bg` varchar(30) NOT NULL DEFAULT '',
				  `cfm_menu_top_bg` varchar(90) NOT NULL DEFAULT '',	
				  `cfm_menu_bg` varchar(30) NOT NULL DEFAULT '',
				  `cfm_menu_color` varchar(90) NOT NULL DEFAULT ''
                  ) ENGINE=MYISAM, DEFAULT CHARSET=utf8", true);
}
if(empty($config_mobile)) {
    $sql = " insert into `{$g5['config_mobile_table']}`
                ( cfm_top_layout, cfm_top_bg, cfm_menu_top_bg, cfm_menu_bg, cfm_menu_color )
              values
                ( '0', '', '', '', '' ) ";
    sql_query($sql);
}
*/











goto_url($_SERVER['HTTP_REFERER'], false);
<?php
include_once('./_common.php');
if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');


/*────────────────────────────────────────────────────────────────────────────────────────────────
									기본환경설정 [config_form.php] - 메인페이지 설정, 추천검색어 설정, 사이트 기본스타일, 기본컬러
─────────────────────────────────────────────────────────────────────────────────────────────────*/
if(!isset($config['cf_main_table'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`                    
					ADD `cf_main_table` VARCHAR(255) NOT NULL DEFAULT '',
					ADD `cf_main_url` VARCHAR(255) NOT NULL DEFAULT '',
					ADD `cf_search_keyword` VARCHAR(255) NOT NULL DEFAULT '',
					ADD `cf_default_style` VARCHAR(255) NOT NULL DEFAULT '',
					ADD `cf_default_color` VARCHAR(255) NOT NULL DEFAULT ''
					", true);
}

/* 검색 키워드 직접입력 사용 */
if(!isset($config['cf_use_search_keyword'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`                    
					ADD `cf_use_search_keyword` TINYINT NOT NULL DEFAULT '0'
					", true);
}

if(isset($config['cf_1_subj'])) { //config 여분필드 삭제
    sql_query(" ALTER TABLE `{$g5['config_table']}` drop cf_1_subj,drop cf_2_subj,drop cf_3_subj,drop cf_4_subj,drop cf_5_subj,drop cf_6_subj,drop cf_7_subj,
	drop cf_8_subj,drop cf_9_subj,drop cf_10_subj,drop cf_1,drop cf_2,drop cf_3,drop cf_4,drop cf_5,drop cf_6,drop cf_7,drop cf_8,drop cf_9,drop cf_10");
}
if(!isset($config['cf_join_captcha'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
					ADD `cf_join_captcha` TINYINT NOT NULL DEFAULT '1',
					ADD `cf_password_captcha` TINYINT NOT NULL DEFAULT '1',
					ADD `cf_use_login` TINYINT NOT NULL DEFAULT '1',
					ADD `cf_use_login_popup` TINYINT NOT NULL DEFAULT '0',
					ADD `cf_use_join` TINYINT NOT NULL DEFAULT '0',
					ADD `cf_use_nickname` TINYINT NOT NULL DEFAULT '1',
					ADD `cf_use_join_code` TINYINT NOT NULL DEFAULT '0',
					ADD `cf_join_code` varchar(255) NOT NULL DEFAULT '',
					ADD `cf_join_level` varchar(255) NOT NULL DEFAULT '',
					ADD `cf_use_stipulation` TINYINT NOT NULL DEFAULT '1'
					", true);
}

// 카카오 API ────────────────
if(!isset($config['cf_kakao_app_key'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					 ADD `cf_kakao_app_key` VARCHAR(255) NOT NULL DEFAULT '' after `cf_use_join`
					 ", false);
}

// 최고관리자 추가 ────────────────
if(!isset($config['cf_admin_add'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					 ADD `cf_admin_add` VARCHAR(255) NOT NULL DEFAULT '' after `cf_admin`
					 ", false);
}

// 기업코드 사용여부 ────────────────
if(!isset($config['cf_use_membercode'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					 ADD `cf_use_membercode` TINYINT NOT NULL DEFAULT '0',
					 ADD `cf_req_membercode` TINYINT NOT NULL DEFAULT '0'
					 ", false);
}

// 회원가입 약관관련 ────────────────
if(!isset($config['cf_stipulation_label'])) {
	sql_query(" ALTER TABLE `{$g5['config_table']}`
					 ADD `cf_stipulation_label` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `cf_privacy_label` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `cf_terms_label` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `cf_terms` text NOT NULL DEFAULT ''
					 ", false);
}








// 회원정보 (기업코드) ────────────────
if(!isset($mb['mb_code'])) {
	sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_code` varchar(255) NOT NULL DEFAULT '' ", false);
}


/*─────────────────────────────────────────────────────────────────────────────────
														메뉴설정 [menu_list.php]
──────────────────────────────────────────────────────────────────────────────────*/
function get_menu_table($fld='*') { // 게시판 스타일 테이블
    global $g5;
    $sql = " select $fld from {$g5['menu_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$main_menu = get_menu_table();
if(!isset($main_menu['me_level'])) {
	sql_query(" ALTER TABLE `{$g5['menu_table']}`
					 ADD `me_level` TINYINT NOT NULL DEFAULT '1'
					 ", false);
}




/*─────────────────────────────────────────────────────────────────────────────────
														헤더 관리 [header_setting.php]
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['header_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['header_table']}` (
				  `header_width` INT(11) NOT NULL DEFAULT '0',
				  `header_height` INT(11) NOT NULL DEFAULT '0',
				  `top_header_color` varchar(255) NOT NULL DEFAULT '',
				  `top_header_menu_color` varchar(255) NOT NULL DEFAULT '',
				  `top_header_color_fixed` TINYINT NOT NULL DEFAULT '0',
				  `side_logo_margin` varchar(30) NOT NULL DEFAULT '',
				  `side_header_color` varchar(30) NOT NULL DEFAULT '',
				  `side_header_menu_color` varchar(255) NOT NULL DEFAULT '',
				  `header_qb_table` varchar(255) NOT NULL DEFAULT '',
				  `header_qb_use_admin` tinyint(4) NOT NULL DEFAULT '0',
				  `header_qb_list` INT(11) NOT NULL DEFAULT '0'
                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}
if(empty($header)) sql_query(" insert into `{$g5['header_table']}` ( header_width, header_height, side_logo_margin ) values ( '450', '90', '60|30' ) ");


/*─────────────────────────────────────────────────────────────────────────────────
														하단(카피라이트) [copyright_register.php]
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['footer_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['footer_table']}` (
                  `ft_inc` TINYINT NOT NULL DEFAULT '0',
                  `copyright` text NOT NULL DEFAULT '',
				  `copyright_mobile` text NOT NULL DEFAULT '',
				  `ft_background` varchar(255) NOT NULL DEFAULT 'rgba(48, 48, 48, 1)|rgba(255, 255, 255, 1)'
                  ) ENGINE=MYISAM, DEFAULT CHARSET=utf8", true);
}
if(empty($footer)) sql_query(" insert into `{$g5['footer_table']}` ( ft_inc ) values ( '0' ) ");


/*─────────────────────────────────────────────────────────────────────────────────
														모바일 설정[config_mobile.php]
──────────────────────────────────────────────────────────────────────────────────*/
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


/*─────────────────────────────────────────────────────────────────────────────────
														퀵뉴스 설정[quick_news.php]
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['quick_news_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['quick_news_table']}` (
                  `qn_use` TINYINT NOT NULL DEFAULT '0',
                  `qn_use_admin` TINYINT NOT NULL DEFAULT '0',
                  `qn_start_option` TINYINT NOT NULL DEFAULT '0',
                  `qn_title` VARCHAR(255) NOT NULL DEFAULT '',
                  `qn_background` VARCHAR(30) NOT NULL DEFAULT '',                  
                  `qn_width` INT(11) NOT NULL DEFAULT '350',
				  `qn_table1` VARCHAR(255) NOT NULL DEFAULT '',					 
                  `qn_list1` INT(11) NOT NULL DEFAULT '10',
				  `qn_table2` VARCHAR(255) NOT NULL DEFAULT '',					 
                  `qn_list2` INT(11) NOT NULL DEFAULT '10'
                  ) ENGINE=MYISAM, DEFAULT CHARSET=utf8", true);
}
if(empty($quick_news)) {
    sql_query(" insert into `{$g5['quick_news_table']}` ( qn_use) values ( '0' ) ");
}
//퀵뉴스 옵션 추가
if (!isset($quick_news['qn_option'])) {
    sql_query(" ALTER TABLE `{$g5['quick_news_table']}`
                    ADD `qn_option` VARCHAR(255) NOT NULL DEFAULT ''
					", true);
}


/*─────────────────────────────────────────────────────────────────────────────────
														회원관리(추가)[member_form.php]
──────────────────────────────────────────────────────────────────────────────────*/
/*
if(!isset($member['mb_cate'])) {
    sql_query(" ALTER TABLE `{$g5['member_table']}`
                ADD `mb_cate` VARCHAR(255) NOT NULL DEFAULT '' AFTER `mb_scrap_cnt`", false);
}
*/


/*─────────────────────────────────────────────────────────────────────────────────
														그룹별 메뉴 테이블 생성
──────────────────────────────────────────────────────────────────────────────────*/
/*if(!sql_query(" DESCRIBE `g5_gr_menu_table` ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS `g5_gr_menu_table` (
				  `me_id` int(11) NOT NULL AUTO_INCREMENT,
				  `me_code` varchar(255) NOT NULL DEFAULT '',
				  `me_order` int(11) NOT NULL DEFAULT '0',
				  `me_name` varchar(255) NOT NULL DEFAULT '',
				  `me_link` varchar(255) NOT NULL DEFAULT '',
				  `me_target` varchar(255) NOT NULL DEFAULT '',
				  `me_cate` varchar(255) NOT NULL DEFAULT '',
				  PRIMARY KEY (`me_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}*/


/*─────────────────────────────────────────────────────────────────────────────────
															게시판 그룹 테이블
──────────────────────────────────────────────────────────────────────────────────*/
if(!isset($group['gr_main_table'])) sql_query(" ALTER TABLE `{$g5['group_table']}` ADD `gr_main_table` VARCHAR(255) NOT NULL DEFAULT '' ", false); //게시판그룹 전용 메인페이지




/*─────────────────────────────────────────────────────────────────────────────────
														게시판관리[board_form.php]
──────────────────────────────────────────────────────────────────────────────────*/
function get_board($fld='*') { // 게시판 스타일 테이블
    global $g5;
    $sql = " select $fld from {$g5['board_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$board = get_board();


// 게시판 기본 설정 ────────────────
if(!isset($board['bo_subject_hide'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_subject_hide` INT(11) NOT NULL DEFAULT '0',
					 ADD `bo_min_width` INT(11) NOT NULL DEFAULT '0',
					 ADD `bo_view_width` INT(11) NOT NULL DEFAULT '0',
					 ADD `bo_padding_top` INT(11) NOT NULL DEFAULT '100',
					 ADD `bo_padding_bottom` INT(11) NOT NULL DEFAULT '100',
					 ADD `bo_padding_left_right` INT(11) NOT NULL DEFAULT '100',
					 ADD `bo_mobile_padding` INT(11) NOT NULL DEFAULT '15',
					 ADD `bo_background` VARCHAR(90) NOT NULL DEFAULT '',
					 ADD `bo_hit` tinyint(4) NOT NULL DEFAULT '0',
					 ADD `bo_use_good_guest` tinyint(4) NOT NULL DEFAULT '0',
					 ADD `bo_btn_write_name` VARCHAR(20) NOT NULL DEFAULT ''
					 ", false);
}

// 게시판 권한 설정 ────────────────
if(!isset($board['bo_use_mobile_write'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_use_mobile_write` INT(11) NOT NULL DEFAULT '1' after `bo_btn_write_name`
					 ", false);
}


// 게시판 카테고리 ────────────────
if(!isset($board['bo_category_label'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_category_label` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `bo_cate_all_hidden` tinyint(4) NOT NULL DEFAULT '0',
					 ADD `bo_cate_skin` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `bo_cate_color` VARCHAR(50) NOT NULL DEFAULT '',
					 ADD `bo_tag_list` text NOT NULL DEFAULT '',
					 ADD `bo_use_tag` tinyint(4) NOT NULL DEFAULT '0'
					 ", false);
}
if(!isset($board['bo_cate_all_hidden'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_cate_all_hidden` tinyint(4) NOT NULL DEFAULT '0' after `bo_category_label`
					 ", false);
}

//목록페이지 설정 ────────────────
if(!isset($board['bo_list_writer'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_list_writer` tinyint(4) NOT NULL DEFAULT '1',
					 ADD `bo_list_date` tinyint(4) NOT NULL DEFAULT '1',
					 ADD `bo_search_skin` VARCHAR(255) NOT NULL DEFAULT ''
					 ", false);
}
if (!isset($board['bo_search_color'])) { //검색범위 & 검색바 컬러
    sql_query(" ALTER TABLE `{$g5['board_table']}` 					
					ADD `bo_search_color` varchar(30) NOT NULL DEFAULT '' AFTER `bo_search_skin`,
					ADD `bo_search_sfl` varchar(255) NOT NULL DEFAULT '' AFTER `bo_search_color`
	", false);
}
if(!isset($board['bo_gall_mobile_cols'])) { //갤러리 관련
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_gall_mobile_cols` INT(11) NOT NULL DEFAULT '1',
					 ADD `bo_max_screen` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `bo_gall_itemspace` INT(11) NOT NULL DEFAULT '60',
					 ADD `bo_gall_mobile_itemspace` INT(11) NOT NULL DEFAULT '10'
					 ", false);
}

//상세페이지 설정 ────────────────
if(!isset($board['bo_view_thumb'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_view_thumb` tinyint(4) NOT NULL DEFAULT '1',
					 ADD `bo_view_writer` tinyint(4) NOT NULL DEFAULT '1',
					 ADD `bo_view_date` tinyint(4) NOT NULL DEFAULT '1',
					 ADD `bo_layer_popup` VARCHAR(255) NOT NULL DEFAULT '',
					 ADD `bo_popup_padding` INT(11) NOT NULL DEFAULT '20',
					 ADD `bo_popup_min_size` INT(11) NOT NULL DEFAULT '400',
					 ADD `bo_popup_max_size` INT(11) NOT NULL DEFAULT '0'
					 ", false);
}

//쓰기페이지 설정 ────────────────
if(!isset($board['bo_editor_height'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_editor_height` INT(11) NOT NULL DEFAULT '300',
					 ADD `bo_use_html_tag` ENUM( 'html2', 'html', 'html1', '' ) NOT NULL DEFAULT 'html2'
					 ", false);
}

// 고급 설정 ────────────────
if(!isset($board['bo_top_img_type'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}` 			 
					 ADD `bo_top_img_type` tinyint(4) NOT NULL DEFAULT '0',
					 ADD `bo_top_img_height` INT(11) NOT NULL DEFAULT '0',
					 ADD `bo_top_img_height_mob` INT(11) NOT NULL DEFAULT '0'
					 ", false);
}
//게시판 옵션 ────────────────
if(!isset($board['bo_option'])) {
	sql_query(" ALTER TABLE `{$g5['board_table']}`
					 ADD `bo_option` VARCHAR(255) NOT NULL DEFAULT ''
					 ", false);
}


/*─────────────────────────────────────────────────────────────────────────────────
														테스트 게시글 콘텐츠 [tmp_content.php]
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['board_tmp_con_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['board_tmp_con_table']}` (
                  `tmp_subject1` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content1` text NOT NULL DEFAULT '',
				  `tmp_subject2` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content2` text NOT NULL DEFAULT '',
				  `tmp_subject3` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content3` text NOT NULL DEFAULT '',
				  `tmp_subject4` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content4` text NOT NULL DEFAULT '',
				  `tmp_subject5` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content5` text NOT NULL DEFAULT '',
				  `tmp_subject6` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content6` text NOT NULL DEFAULT '',
				  `tmp_subject7` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content7` text NOT NULL DEFAULT '',
				  `tmp_subject8` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content8` text NOT NULL DEFAULT '',
				  `tmp_subject9` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content9` text NOT NULL DEFAULT '',
				  `tmp_subject10` VARCHAR(255) NOT NULL DEFAULT '',
                  `tmp_content10` text NOT NULL DEFAULT ''
                  ) ENGINE=MYISAM, DEFAULT CHARSET=utf8", true);
}
if(empty($tmpCon)) sql_query(" insert into `{$g5['board_tmp_con_table']}`
			(tmp_subject1,tmp_subject2,tmp_subject3,tmp_subject4,tmp_subject5,tmp_subject6,tmp_subject7,tmp_subject8,tmp_subject9,tmp_subject10,tmp_content1,tmp_content2,tmp_content3,tmp_content4,tmp_content5,tmp_content6,tmp_content7,tmp_content8,tmp_content9,tmp_content10) 
			values 
			( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'Fusce dapibus, tellus ac cursus commodo.',
			'At vero eos et accusamus et iusto odio.',
			'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.',
			'Nullam dapibus blandit orci, viverra gravida dui lobortis eget.',
			'Vivamus luctus urna sed urna ultricies ac tempor dui sagittis.',
			'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet.',
			'Consectetuer adipiscing elit, sed diam nonummy nibh.',
			'Adipiscing elit, sed diam nonummy nibh.',
			'Duis mollis, est non commodo luctus, nisi erat porttitor ligula.',
			'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.\nQuisque volutpat mattis eros. Nullam malesuada erat ut turpis.\nSuspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.',
			'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet\nQuisque volutpat mattis eros. Nullam malesuada erat ut turpis.\nSuspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.',
			'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum.\nDuis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit.',
			'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.\nDonec odio. Quisque volutpat mattis eros.\nNullam malesuada erat ut turpis.\nSuspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.',
			'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio.\nQuisque volutpat mattis eros. Nullam malesuada erat ut turpis.\nSuspendisse urna nibh, viverra non, semper suscipit, posuere a, pede.',
			'Lorem ipsum dolor sit amet, consectetuer \nadipiscing elit, sed diam nonummy nibh.',
			'Lorem ipsum dolor sit amet, consectetuer adipiscing elit,\nsed diam nonummy.',
			'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua.',
			'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet\nconsectetur, adipisci velit, sed quia non numquam\nNullam dapibus blandit orci, viverra gravida dui lobortis eget.\nMaecenas fringilla urna eu nisl scelerisque.',
			'Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum. \nDuis mollis, est non commodo luctus, nisi erat porttitor ligula.\nLorem ipsum dolor sit amet,\nconsectetuer adipiscing elit, sed diam nonummy nibh.' )
");
//테스트용 이미지 img -> data로 복사
for($i=1; $i<=10; $i++) {
	if(!file_exists(G5_DATA_PATH.'/tmp/temp'.$i.'.jpg')) {
		copy(G5_PATH.'/img/temp/temp'.$i.'.jpg', G5_DATA_PATH.'/tmp/temp'.$i.'.jpg');
	}
}





/*─────────────────────────────────────────────────────────────────────────────────
														게시판 기본 스타일[board.style.php]
──────────────────────────────────────────────────────────────────────────────────*/
if(!sql_query(" DESCRIBE {$g5['board_style_table']} ", false)) {
    sql_query(" CREATE TABLE IF NOT EXISTS `{$g5['board_style_table']}` (
                  `use_bo_style` TINYINT NOT NULL DEFAULT '0',
                  `title_style` VARCHAR(255) NOT NULL DEFAULT '',
                  `btn_write_style` VARCHAR(255) NOT NULL DEFAULT '',
                  `btn_pager_style` VARCHAR(255) NOT NULL DEFAULT '',
				  `table_style` VARCHAR(255) NOT NULL DEFAULT ''				
                  ) ENGINE=MYISAM, DEFAULT CHARSET=utf8", true);
}
if(empty($board_style)) sql_query(" insert into `{$g5['board_style_table']}` ( use_bo_style ) values ( '0' ) ");






goto_url($_SERVER['HTTP_REFERER'], false);


/*
설치시 테이블 생성하기
/install/install_db.php 에서 -> fwrite($f, "\$g5['temp'] = G5_TABLE_PREFIX.'temp'; // 테이블설명\n");

- 수동으로 생성시 -
/data/dbconfig.php 에서 추가 -> $g5['temp'] = G5_TABLE_PREFIX.'temp';

/extend/user.config.php 에서 추가 --
function get_temp($fld='*') {
	global $g5;
	$sql = " select $fld from {$g5['temp']} ";
	$row = sql_fetch($sql);
	return $row;
}
$temp = get_temp();
*/
<?php
include_once('./_common.php');
if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

// 쇼핑몰 매장(지점) 관리 테이블 생성
if(!sql_query(" DESCRIBE {$g5['g5_shop_store_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['g5_shop_store_table']} (
				  `store_id` int(11) NOT NULL AUTO_INCREMENT,
				  `store_order` int(11) NOT NULL DEFAULT '0',
				  `store_use` int(11) NOT NULL DEFAULT '1',
				  `store_url` varchar(255) NOT NULL DEFAULT '',
				  `store_subject` varchar(255) NOT NULL DEFAULT '',
				  `store_basic` varchar(255) NOT NULL DEFAULT '',
				  `store_address` varchar(255) NOT NULL DEFAULT '',				  
				  `store_lat` varchar(255) NOT NULL DEFAULT '',
				  `store_lng` varchar(255) NOT NULL DEFAULT '',
				  `store_wr1` varchar(255) NOT NULL DEFAULT '',
				  `store_wr2` varchar(255) NOT NULL DEFAULT '',
				  `store_wr3` varchar(255) NOT NULL DEFAULT '',
				  `store_wr4` varchar(255) NOT NULL DEFAULT '',
				  `store_wr5` varchar(255) NOT NULL DEFAULT '',
				  `store_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
				  PRIMARY KEY (`store_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}

// 쇼핑몰 매장(지점) 상품 테이블 생성
if(!sql_query(" DESCRIBE {$g5['g5_shop_store_item_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['g5_shop_store_item_table']} (
				  `store_id` int(11) NOT NULL DEFAULT '0',
				  `it_id` varchar(20) NOT NULL DEFAULT '',
				  PRIMARY KEY (`store_id`,`it_id`),
				  KEY `it_id` (`it_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}


alert('매장 테이블이 생성되었습니다.', G5_ADMIN_URL.'/shop_admin/my/storelist.php');

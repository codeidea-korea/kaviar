<?php
include_once('./_common.php');
if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['membercode_table'] = G5_TABLE_PREFIX.'membercode';

// 기업코드 관리 테이블 생성
if(!sql_query(" DESCRIBE {$g5['membercode_table']} ", false)) {
	sql_query(" CREATE TABLE IF NOT EXISTS {$g5['membercode_table']} (
				  `code_num` int(11) NOT NULL AUTO_INCREMENT,
				  `code_use` int(11) NOT NULL DEFAULT '1',
				  `code_id` varchar(255) NOT NULL DEFAULT '',
				  `code_name` varchar(255) NOT NULL DEFAULT '',
				  `join_content` text NOT NULL DEFAULT ''
				  PRIMARY KEY (`code_num`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
}



alert('기업코드 관리 테이블이 생성되었습니다.', G5_ADMIN_URL.'/shop_admin/my/membercode.php');

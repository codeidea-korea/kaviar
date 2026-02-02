<?php
$sub_menu = "110600";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '에디터 URL 변경';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 구사이트도메인 http://www. 제외
$old = $_POST['previous_site'];

$old = trim($old); // 도메인주소 앞뒤 공백 제거
$old = rtrim($old, '/'); // 도메인주소 마지막에 / 문자 제거

// 새사이트도메인 http://www. 제외
$new= $_POST['now_site'];

$sql = sql_query("select * from {$g5['board_table']}");

while($data = sql_fetch_array($sql)){

	//기본 메뉴
	sql_query("update {$g5['menu_table']} set me_link=REPLACE(`me_link`,'$old','$new')");

	//상단메뉴
	sql_query("update {$g5['top_menu_table']} set top_menu_link=REPLACE(`top_menu_link`,'$old','$new')");

	//모든 게시물 링크, 에디터 내용
	sql_query("update g5_write_{$data[bo_table]} set
					 wr_content=REPLACE(`wr_content`,'$old','$new'),
					 wr_content_mobile=REPLACE(`wr_content_mobile`,'$old','$new'),
					 wr_link1=REPLACE(`wr_link1`,'$old','$new'),
					 wr_link2=REPLACE(`wr_link2`,'$old','$new'),
					 wr_btn1=REPLACE(wr_btn1,'$old','$new'),
					 wr_btn2=REPLACE(wr_btn2,'$old','$new'),
					 wr_btn3=REPLACE(wr_btn3,'$old','$new'),
					 wr_btn4=REPLACE(wr_btn4,'$old','$new'),
					 wr_btn5=REPLACE(wr_btn5,'$old','$new'),
					 wr_btn6=REPLACE(wr_btn6,'$old','$new'),
					 wr_1=REPLACE(wr_1,'$old','$new'),
					 wr_2=REPLACE(wr_2,'$old','$new'),
					 wr_3=REPLACE(wr_3,'$old','$new'),
					 wr_4=REPLACE(wr_4,'$old','$new'),
					 wr_5=REPLACE(wr_5,'$old','$new'),
					 wr_6=REPLACE(wr_6,'$old','$new'),
					 wr_7=REPLACE(wr_7,'$old','$new'),
					 wr_8=REPLACE(wr_7,'$old','$new'),
					 wr_9=REPLACE(wr_9,'$old','$new'),
					 wr_10=REPLACE(wr_10,'$old','$new'),
					 wr_sub1=REPLACE(wr_sub1,'$old','$new'),
					 wr_sub2=REPLACE(wr_sub2,'$old','$new'),
					 wr_sub3=REPLACE(wr_sub3,'$old','$new'),
					 wr_sub4=REPLACE(wr_sub4,'$old','$new'),
					 wr_sub5=REPLACE(wr_sub5,'$old','$new'),
					 wr_sub6=REPLACE(wr_sub6,'$old','$new'),
					 wr_sub7=REPLACE(wr_sub7,'$old','$new'),
					 wr_sub8=REPLACE(wr_sub7,'$old','$new'),
					 wr_sub9=REPLACE(wr_sub9,'$old','$new'),
					 wr_sub10=REPLACE(wr_sub10,'$old','$new')
					 ");

	//게시판 상,하단 내용
	sql_query("update {$g5['board_table']} set
					 bo_content_head=REPLACE(`bo_content_head`,'$old','$new'),
					 bo_mobile_content_head=REPLACE(`bo_mobile_content_head`,'$old','$new'),
					 bo_content_tail=REPLACE(`bo_content_tail`,'$old','$new'),
					 bo_mobile_content_tail=REPLACE(`bo_mobile_content_tail`,'$old','$new')
					 ");

	//카피라이트
	sql_query("update {$g5['footer_table']} set copyright=REPLACE(`copyright`,'$old','$new')");
	sql_query("update {$g5['footer_table']} set copyright=REPLACE(`copyright_mobile`,'$old','$new')");

}




//content 페이지
/*sql_query("update {$g5['content_table']} set co_content=REPLACE(`co_content`,'$old','$new')");
sql_query("update {$g5['content_table']} set co_mobile_content=REPLACE(`co_mobile_content`,'$old','$new')");

if($g5['g5_shop_item_table']){
	$sql = sql_query("select * from {$g5['g5_shop_item_table']}");
	sql_query("update {$g5['g5_shop_item_table']} set it_explan=REPLACE(`it_explan`,'$old','$new')");
	sql_query("update {$g5['g5_shop_item_table']} set it_mobile_explan=REPLACE(`it_mobile_explan`,'$old','$new')");
}*/

alert('에디터 URL 변경이 완료되었습니다.', './editor_reurl.php?'.$qstr);
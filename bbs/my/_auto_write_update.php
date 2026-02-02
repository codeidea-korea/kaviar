<?php
include_once('./_common.php');

// =================
//	게시물 10개 자동등록
// =================

$bo_table = $_GET['bo_table'];
$write_table = $g5['write_prefix'] . $bo_table;
$count = $_GET['count'];

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);


$tmp_wr_subject = array ("Lorem ipsum dolor sit amet, consectetur adipiscing elit.", "Aliquam rutrum viverra nulla, in mollis felis commodo at.", "Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.", "Sed interdum luctus enim, nec venenatis lacus lobortis ac.", "Curabitur id vehicula orci, rhoncus bibendum metus.", "Cras et cursus velit.", "Duis quis purus nec neque gravida egestas", "Vestibulum eu orci justo. Aenean in tortor at ante adipiscing luctus.", "Donec aliquet, leo at interdum viverra, magna magna sollicitudin velit, at eleifend ante libero ac quam.", "Ut consequat tempus ornare.", "Nunc ipsum quam, suscipit eget porttitor ac, placerat et dolor.");
$tmp_wr_content = "Cras et cursus velit. Etiam ac mattis est. Aenean cursus orci lectus, eu pretium velit tincidunt eu.
Nulla fermentum fringilla nunc, a facilisis tellus fringilla in. Morbi nunc massa, vehicula in malesuada sit amet, iaculis eget tellus.
Proin varius orci leo, sit amet vulputate lorem elementum eget.
Vestibulum vel erat laoreet, euismod nibh in, facilisis mi. Vivamus neque metus, posuere eu sem eu, porta faucibus orci.
Quisque ut sem accumsan, tempor mi eget, dignissim risus. Nam condimentum posuere quam.
Fusce et odio interdum, iaculis urna cursus, sodales neque. Donec aliquet, leo at interdum viverra,
magna magna sollicitudin velit, at eleifend ante libero ac quam.";

//////////////////////////////////////////////////////////////////////////////////////////////////
function auto_write($bo_table, $write_table, $wr_subject, $wr_content, $img_name) {
	global $g5, $board, $member;

	$mb_id = get_text($member['mb_id']);
	$mb_password = get_encrypt_string($member['mb_password']);
	$mb_name = get_text($member['mb_name']);
	$mb_email = get_text($member['mb_email']);
	$mb_homepage = get_text($member['mb_homepage']);

	$wr_num = get_next_num($write_table);
	$sql = " insert into $write_table
				set wr_num = '$wr_num',
					 wr_reply = '$wr_reply',
                     wr_comment = 0,
					 ca_name = '$ca_name',
					 wr_option = '$html,$secret,$mail',
                     wr_subject = '$wr_subject',
                     wr_content = '$wr_content',
                     wr_seo_title = '$wr_subject',
                     wr_link1 = '$wr_link1',
                     wr_link2 = '$wr_link2',
                     wr_link1_hit = 0,
                     wr_link2_hit = 0,
                     wr_hit = 0,
                     wr_good = 0,
                     wr_nogood = 0,
                     mb_id = '$mb_id',
                     wr_password = '$mb_password',
                     wr_name = '$mb_name',
                     wr_email = '$mb_email',
                     wr_homepage = '$mb_homepage',
                     wr_datetime = '".G5_TIME_YMDHIS."',
					 wr_file = 1,
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";
	sql_query($sql);

	$wr_id = sql_insert_id();
		
	sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");
	sql_query(" insert into $g5[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$wr_id', '$wr_id', '".G5_TIME_YMDHIS."', '$mb_id' ) ");
	sql_query(" update $g5[board_table] set bo_count_write = bo_count_write + 1 where bo_table = '$bo_table'");
	
	//임시 이미지 업로드
	shuffle($chars_array);
	$shuffle = implode('', $chars_array);
	$file_name = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($img_name);
	$img_path = G5_DATA_PATH.'/tmp/'.$img_name;
	$dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$file_name;
	
	//move_uploaded_file($file_path[$i], $dest_file[$i]);
	copy($img_path,$dest_file);

	$dest_file = run_replace('write_update_upload_file', $dest_file, $board, $wr_id, '');
	$upload = run_replace('write_update_upload_array', $upload, $dest_file, $board, $wr_id, '');

	$sql = " insert into {$g5['board_file_table']}
				set bo_table = '{$bo_table}',
					 wr_id = '{$wr_id}',
					 bf_no = 0,
					 bf_source = '{$img_name}',
					 bf_file = '{$file_name}',
					 bf_content = '',
					 bf_fileurl = '',
					 bf_thumburl = '',
					 bf_storage = '',
					 bf_download = 0,
					 bf_filesize = 1,
					 bf_width = 0,
					 bf_height = 0,
					 bf_type = 2,
					 bf_datetime = '".G5_TIME_YMDHIS."' ";
	sql_query($sql);

	run_event('write_update_file_insert', $bo_table, $wr_id, $upload, '');
}
//////////////////////////////////////////////////////////////////////////////////////////////////


for ($i=1; $i<=$count; $i++) {
	auto_write($bo_table, $write_table, $tmpCon['tmp_subject'.$i], $tmpCon['tmp_content'.$i], 'temp'.$i.'.jpg');
}

goto_url(G5_BBS_URL.'/board.php?bo_table='.$bo_table);
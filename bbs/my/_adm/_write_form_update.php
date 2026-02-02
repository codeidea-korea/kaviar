<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];
$wr_id = $_POST['wr_id'];
$write_table = $g5['write_prefix'] . $bo_table;


// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$ca_name = $board['bo_use_category'] ? trim($_POST['ca_name']) : '';

$wr_subject = '';
if (isset($_POST['wr_subject'])) {
    $wr_subject = substr(trim($_POST['wr_subject']),0,255);
    $wr_subject = preg_replace("#[\\\]+$#", "", $wr_subject);
}
$wr_content = '';
if (isset($_POST['wr_content'])) {
    $wr_content = substr(trim($_POST['wr_content']),0,65536);
    $wr_content = preg_replace("#[\\\]+$#", "", $wr_content);
}
if (isset($_POST['wr_content_mobile'])) {
	$wr_content_mobile = trim($_POST['wr_content_mobile']);
    $wr_content_mobile = preg_replace("#[\\\]+$#", "", $wr_content_mobile);
}

$wr_short_con = $_POST['wr_short_con'];

$upload_max_filesize = ini_get('upload_max_filesize');

$html = '';
if (isset($_POST['html']) && $_POST['html']) {
    if(preg_match('#html(1|2)#', strtolower($_POST['html']), $matches))
        $html = $matches[0];
} else {
	$html = 'html1';
}

/*for ($i=1; $i<=10; $i++) {
    $var = "wr_$i";
    $$var = "";
    if (isset($_POST['wr_'.$i]) && settype($_POST['wr_'.$i], 'string')) {
        $$var = trim($_POST['wr_'.$i]);
    }
}*/

for($i=0; $i<count($_FILES[bf_file][name]); $i++) { 
	if (!preg_match("/\.($config[cf_image_extension])$/i", $_FILES[bf_file][name][$i]) && $_FILES[bf_file][name][$i]) { 
		alert("이미지 파일만 업로드가 가능합니다!"); 
	}  
}

$wr_seo_title = exist_seo_title_recursive('bbs', generate_seo_title($wr_subject), $write_table, $wr_id);

//태그에서 #->, 치환후 첫글자가 ,로 시작할때 제거
if(substr($_POST['wr_tag'], 0, 1) === "#") $wr_tag = mb_substr($_POST['wr_tag'], 1);
$wr_tag = preg_replace("/[#]/i", ",", $wr_tag);

$mb_id = $member['mb_id'];
$mb_name = $member['mb_name'];
$mb_password = get_encrypt_string($member['mb_password']);
$mb_email = addslashes($member['mb_email']);
$mb_homepage = addslashes(clean_xss_tags($member['mb_homepage']));
$wr_num = get_next_num($write_table);

//추가된 필드 ─────────────────────────────────────────────────────────
$wr_btn1 = $_POST['wr_btn1'] ? implode("|", $_POST['wr_btn1']) : '';
$wr_btn2 = $_POST['wr_btn2'] ? implode("|", $_POST['wr_btn2']) : '';
$wr_btn3 = $_POST['wr_btn3'] ? implode("|", $_POST['wr_btn3']) : '';
$wr_btn4 = $_POST['wr_btn4'] ? implode("|", $_POST['wr_btn4']) : '';
$wr_btn5 = $_POST['wr_btn5'] ? implode("|", $_POST['wr_btn5']) : '';
$wr_btn6 = $_POST['wr_btn6'] ? implode("|", $_POST['wr_btn6']) : '';
$wr_btn1_color = $_POST['wr_btn1_color'] ? implode("|", $_POST['wr_btn1_color']) : '';
$wr_btn2_color = $_POST['wr_btn2_color'] ? implode("|", $_POST['wr_btn2_color']) : '';
$wr_btn3_color = $_POST['wr_btn3_color'] ? implode("|", $_POST['wr_btn3_color']) : '';
$wr_btn4_color = $_POST['wr_btn4_color'] ? implode("|", $_POST['wr_btn4_color']) : '';
$wr_btn5_color = $_POST['wr_btn5_color'] ? implode("|", $_POST['wr_btn5_color']) : '';
$wr_btn6_color = $_POST['wr_btn6_color'] ? implode("|", $_POST['wr_btn6_color']) : '';

if($w == '') {
	$sql = " insert into $write_table
					set wr_num = '$wr_num',
						 wr_reply = '$wr_reply',
						 wr_comment = 0,
						 ca_name = '$ca_name',
						 wr_option = '$html,$secret,$mail',
						 wr_subject = '$wr_subject',
						 wr_content = '$wr_content',
						 wr_content_mobile = '$wr_content_mobile',
						 wr_seo_title = '$wr_seo_title',
						 wr_short_con = '$wr_short_con',
						 wr_link1 = '$wr_link1',
						 wr_link2 = '$wr_link2',
						 wr_link1_hit = 0,
						 wr_link2_hit = 0,
						 wr_hit = 0,
						 wr_good = 0,
						 wr_nogood = 0,
						 mb_id = '$mb_id',
						 wr_password = '$wr_password',
						 wr_name = '$mb_name',
						 wr_email = '$mb_email',
						 wr_homepage = '$mb_homepage',
						 wr_datetime = '".G5_TIME_YMDHIS."',
						 wr_file = 2,
						 wr_last = '".G5_TIME_YMDHIS."',
						 wr_ip = '{$_SERVER['REMOTE_ADDR']}' ";
		sql_query($sql);

	$wr_id = sql_insert_id();

	sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");
	sql_query(" insert into $g5[board_new_table] ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '$bo_table', '$wr_id', '$wr_id', '".G5_TIME_YMDHIS."', '$mb_id' ) ");
	sql_query(" update $g5[board_table] set bo_count_write = bo_count_write + 1 where bo_table = '$bo_table'");

} else if($w == 'u') {
	$sql = " update {$write_table}
                set wr_subject = '{$wr_subject}',
                     wr_content = '{$wr_content}',
                     wr_seo_title = '$wr_seo_title',
					 wr_content_mobile = '{$wr_content_mobile}',
					 wr_video = '{$wr_video}',	
					 wr_video_src = '{$wr_video_src}',
					 wr_video_play = '{$wr_video_play}',
					 wr_btn1 = '$wr_btn1',
					 wr_btn1_color = '$wr_btn1_color',
					 wr_btn2 = '$wr_btn2',
					 wr_btn2_color = '$wr_btn2_color',
					 wr_btn3 = '$wr_btn3',
					 wr_btn3_color = '$wr_btn3_color',
					 wr_btn4 = '$wr_btn4',
					 wr_btn4_color = '$wr_btn4_color',
					 wr_btn5 = '$wr_btn5',
					 wr_btn5_color = '$wr_btn5_color',
					 wr_btn6 = '$wr_btn6',
					 wr_btn6_color = '$wr_btn6_color'
              where wr_id = '{$wr_id}' ";
    sql_query($sql);
}


if($pn) @include_once($board_pcskin_path.'/'.$pn.'_update.skin.php');


//동영상 소스 저장
if(strpos($wr_video_src, 'youtu') !== false) {
	preg_match('@https?://(?:www\.)?youtube\.com/(?:watch\?|\?)?v[/=]([a-zA-Z0-9-_]+)@', $wr_video_src, $matches);
	$wr_video = $matches[1];
    if(!$wr_video) {
        preg_match('@https?://(?:www\.)?youtu\.be/([a-zA-Z0-9-_]+)@', $wr_video_src, $matches);
        $wr_video = $matches[1];
    }
	if($wr_video) sql_query(" update {$write_table} set wr_video = '$wr_video' where wr_id = '$wr_id' ");
} else if(strpos($wr_video_src, 'vimeo') !== false) {
	preg_match('@https?://(?:www\.)?vimeo\.com/(?:watch\?|\?)?v[/=]([a-zA-Z0-9-_]+)@', $wr_video_src, $matches);
	$wr_video = $matches[1];
    if(!$wr_video) {
        preg_match('@https?://(?:www\.)?vimeo\.com/([a-zA-Z0-9-_]+)@', $wr_video_src, $matches);
        $wr_video = $matches[1];
    }
	if($wr_video) sql_query(" update {$write_table} set wr_video = '$wr_video' where wr_id = '$wr_id' ");
} else if($wr_video_src) {
	sql_query(" update {$write_table} set wr_video = '$wr_video_src' where wr_id = '$wr_id' ");
}


// 파일개수 체크
$file_count   = 0;
$upload_count = count($_FILES['bf_file']['name']);

for ($i=0; $i<$upload_count; $i++) {
    if($_FILES['bf_file']['name'][$i] && is_uploaded_file($_FILES['bf_file']['tmp_name'][$i]))
        $file_count++;
}

if($w == 'u') {
    $file = get_file($bo_table, $wr_id);
    //if($file_count && (int)$file['count'] > $board['bo_upload_count']) alert('기존 파일을 삭제하신 후 첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
} else {
    //if($file_count > $board['bo_upload_count']) alert('첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');
}

// 디렉토리가 없다면 생성합니다. (퍼미션도 변경하구요.)
@mkdir(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.'/file/'.$bo_table, G5_DIR_PERMISSION);

$chars_array = array_merge(range(0,9), range('a','z'), range('A','Z'));

// 가변 파일 업로드
$file_upload_msg = '';
$upload = array();
for ($i=0; $i<count($_FILES['bf_file']['name']); $i++) {
    $upload[$i]['file']     = '';
    $upload[$i]['source']   = '';
    $upload[$i]['filesize'] = 0;
    $upload[$i]['image']    = array();
    $upload[$i]['image'][0] = '';
    $upload[$i]['image'][1] = '';
    $upload[$i]['image'][2] = '';
    $upload[$i]['fileurl'] = '';
    $upload[$i]['thumburl'] = '';
    $upload[$i]['storage'] = '';

	// 삭제에 체크가 되어있다면 파일을 삭제합니다.
    if (isset($_POST['bf_file_del'][$i]) && $_POST['bf_file_del'][$i]) {
        $upload[$i]['del_check'] = true;

        $row = sql_fetch(" select * from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

        $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
        if( file_exists($delete_file) ){
            @unlink($delete_file);
        }
        // 썸네일삭제
        if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
            delete_board_thumbnail($bo_table, $row['bf_file']);
        }
    } else {
        $upload[$i]['del_check'] = false;
	}

    $tmp_file  = $_FILES['bf_file']['tmp_name'][$i];
    $filesize  = $_FILES['bf_file']['size'][$i];
    $filename  = $_FILES['bf_file']['name'][$i];
    $filename  = get_safe_filename($filename);

    if(is_uploaded_file($tmp_file)) {

        //=================================================================\
        // 090714
        // 이미지나 플래시 파일에 악성코드를 심어 업로드 하는 경우를 방지
        // 에러메세지는 출력하지 않는다.
        //-----------------------------------------------------------------
        $timg = @getimagesize($tmp_file);
        // image type
        if ( preg_match("/\.({$config['cf_image_extension']})$/i", $filename) ||
             preg_match("/\.({$config['cf_flash_extension']})$/i", $filename) ) {
            if ($timg['2'] < 1 || $timg['2'] > 16)
                continue;
        }
        //=================================================================

        $upload[$i]['image'] = $timg;

        // 4.00.11 - 글답변에서 파일 업로드시 원글의 파일이 삭제되는 오류를 수정
        if ($w == 'u') {
            // 존재하는 파일이 있다면 삭제합니다.
            $row = sql_fetch(" select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_no = '$i' ");

            $delete_file = run_replace('delete_file_path', G5_DATA_PATH.'/file/'.$bo_table.'/'.str_replace('../', '', $row['bf_file']), $row);
            if( file_exists($delete_file) ){
                @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$row['bf_file']);
            }
            // 이미지파일이면 썸네일삭제
            if(preg_match("/\.({$config['cf_image_extension']})$/i", $row['bf_file'])) {
                delete_board_thumbnail($bo_table, $row['bf_file']);
            }
        }

        // 프로그램 원래 파일명
        $upload[$i]['source'] = $filename;
        $upload[$i]['filesize'] = $filesize;

        // 아래의 문자열이 들어간 파일은 -x 를 붙여서 웹경로를 알더라도 실행을 하지 못하도록 함
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);

        shuffle($chars_array);
        $shuffle = implode('', $chars_array);

        // 첨부파일 첨부시 첨부파일명에 공백이 포함되어 있으면 일부 PC에서 보이지 않거나 다운로드 되지 않는 현상이 있습니다. (길상여의 님 090925)
        $upload[$i]['file'] = abs(ip2long($_SERVER['REMOTE_ADDR'])).'_'.substr($shuffle,0,8).'_'.replace_filename($filename);

        $dest_file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$upload[$i]['file'];
		
		///////////////////////////////////////////// 인태 - 2020.07
        // 이 부분부터는 세로사진 정상적으로 출력되도록 회전 수정하는 부분
        $exifData = exif_read_data($tmp_file);
        if($exifData['Orientation'] == 6) {
            // 시계방향으로 90도 돌려줘야 정상인데 270도 돌려야 정상적으로 출력됨
            $degree = 270;
        }
        else if($exifData['Orientation'] == 8) {
            // 반시계방향으로 90도 돌려줘야 정상
            $degree = 90;
        }
        else if($exifData['Orientation'] == 3) {
            $degree = 180;
        }
        if($degree) {
            if($exifData[FileType] == 1) {
                $source = imagecreatefromgif($tmp_file);
                $source = imagerotate ($source , $degree, 0);
                imagegif($source, $dest_file);
            }
            else if($exifData[FileType] == 2) {
                $source = imagecreatefromjpeg($tmp_file);
                $source = imagerotate ($source , $degree, 0);
                imagejpeg($source, $dest_file);
            }
            else if($exifData[FileType] == 3) {
                $source = imagecreatefrompng($tmp_file);
                $source = imagerotate ($source , $degree, 0);
                imagepng($source, $dest_file);
            }

            imagedestroy($source);
        }
        else {
            // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
            $error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);
        }
        // 세로사진 처리 끝 //////////////////////////////////////////

        // 업로드가 안된다면 에러메세지 출력하고 죽어버립니다.
        //$error_code = move_uploaded_file($tmp_file, $dest_file) or die($_FILES['bf_file']['error'][$i]);

        // 올라간 파일의 퍼미션을 변경합니다.
        chmod($dest_file, G5_FILE_PERMISSION);

        $dest_file = run_replace('write_update_upload_file', $dest_file, $board, $wr_id, $w);
        $upload[$i] = run_replace('write_update_upload_array', $upload[$i], $dest_file, $board, $wr_id, $w);
    }
}

// 나중에 테이블에 저장하는 이유는 $wr_id 값을 저장해야 하기 때문입니다.
for ($i=0; $i<count($upload); $i++)
{
    if (!get_magic_quotes_gpc()) {
        $upload[$i]['source'] = addslashes($upload[$i]['source']);
    }

    $row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
    if ($row['cnt'])
    {
        // 삭제에 체크가 있거나 파일이 있다면 업데이트를 합니다.
        // 그렇지 않다면 내용만 업데이트 합니다.
        if ($upload[$i]['del_check'] || $upload[$i]['file'])
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_source = '{$upload[$i]['source']}',
                             bf_file = '{$upload[$i]['file']}',
                             bf_content = '{$bf_content[$i]}',
                             bf_fileurl = '{$upload[$i]['fileurl']}',
                             bf_thumburl = '{$upload[$i]['thumburl']}',
                             bf_storage = '{$upload[$i]['storage']}',
                             bf_filesize = '{$upload[$i]['filesize']}',
                             bf_width = '{$upload[$i]['image']['0']}',
                             bf_height = '{$upload[$i]['image']['1']}',
                             bf_type = '{$upload[$i]['image']['2']}',
                             bf_datetime = '".G5_TIME_YMDHIS."'
                      where bo_table = '{$bo_table}'
                                and wr_id = '{$wr_id}'
                                and bf_no = '{$i}' ";
            sql_query($sql);
        }
        else
        {
            $sql = " update {$g5['board_file_table']}
                        set bf_content = '{$bf_content[$i]}'
                        where bo_table = '{$bo_table}'
                                  and wr_id = '{$wr_id}'
                                  and bf_no = '{$i}' ";
            sql_query($sql);
        }
    }
    else
    {
        $sql = " insert into {$g5['board_file_table']}
                    set bo_table = '{$bo_table}',
                         wr_id = '{$wr_id}',
                         bf_no = '{$i}',
                         bf_source = '{$upload[$i]['source']}',
                         bf_file = '{$upload[$i]['file']}',
                         bf_content = '{$bf_content[$i]}',
                         bf_fileurl = '{$upload[$i]['fileurl']}',
                         bf_thumburl = '{$upload[$i]['thumburl']}',
                         bf_storage = '{$upload[$i]['storage']}',
                         bf_download = 0,
                         bf_filesize = '{$upload[$i]['filesize']}',
                         bf_width = '{$upload[$i]['image']['0']}',
                         bf_height = '{$upload[$i]['image']['1']}',
                         bf_type = '{$upload[$i]['image']['2']}',
                         bf_datetime = '".G5_TIME_YMDHIS."' ";
        sql_query($sql);

        run_event('write_update_file_insert', $bo_table, $wr_id, $upload[$i], '');
    }
}

// 업로드된 파일 내용에서 가장 큰 번호를 얻어 거꾸로 확인해 가면서
// 파일 정보가 없다면 테이블의 내용을 삭제합니다.
$row = sql_fetch(" select max(bf_no) as max_bf_no from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
for ($i=(int)$row['max_bf_no']; $i>=0; $i--)
{
    $row2 = sql_fetch(" select bf_file from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");

    // 정보가 있다면 빠집니다.
    if ($row2['bf_file']) break;

    // 그렇지 않다면 정보를 삭제합니다.
    sql_query(" delete from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_no = '{$i}' ");
}

// 파일의 개수를 게시물에 업데이트 한다.
$row = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
sql_query(" update {$write_table} set wr_file = '{$row['cnt']}' where wr_id = '{$wr_id}' ");


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
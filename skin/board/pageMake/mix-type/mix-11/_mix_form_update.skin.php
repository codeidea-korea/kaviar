<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sql = " update {$write_table}
			set wr_video = '{$wr_video}',
				 wr_video_src = '{$wr_video_src}',
				 wr_video_play = '{$wr_video_play}',
				 wr_video_width = '{$wr_video_width}'
			 where wr_id = '{$wr_id}' ";
sql_query($sql);


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
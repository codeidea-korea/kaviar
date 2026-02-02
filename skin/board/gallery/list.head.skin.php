<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//스킨 설정
$autoThumb = true;
$autoSize = true; //auto, 'masonry'

//갤러리 스킨은 이미지업로드 2개로 고정
if($board['bo_upload_count'] != 2) sql_query(" update {$g5['board_table']} set bo_upload_count = 2 where bo_table = '{$bo_table}' ");
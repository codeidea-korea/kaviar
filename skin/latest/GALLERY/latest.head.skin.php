<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//스킨 설정
$autoThumb = true;
if($_masonry) $latestScript .= '$(window).ready(function(){ masonry_update("'.$blockID.' .masonry_wrap", '.$gutter.'); });'.PHP_EOL;


//pageMake에서 스킨설정시 할당
$skin_type = array ("_gall", "_gall_masonry", "_gall_slide", "_gall_webzine");
$skin_type_name = array ("기본 갤러리", "masonry 갤러리", "슬라이드 갤러리", "웹진 갤러리");
$skin_type_cols = array (4, 4, 3, 2);
$listStyle = true;
$gallCols = $latest_type == true;
$gallGutter = true;


//pageMake에서 최신글 수정시 옵션
$skin_option = array ("이미지만 보이기", "카테고리 표기", "작성자 표기", "날짜 표기", "조회수 표기", "댓글수 표기", "태그 표기", "게시물 버튼 표기", "<br>", "제목 한줄 자르기", "내용글자수", "모바일 내용글자수");
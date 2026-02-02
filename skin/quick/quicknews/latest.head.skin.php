<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


//퀵뉴스 오프너 사이즈만큼 콘텐츠영역 축소
$quickOpenerSize = 50;
if(!G5_IS_MOBILE) {
	$quickStyle .= '#wrapper, .boCover, .auto-fixed{width:calc(100% - '.$quickOpenerSize.'px) !important;}';
	$quickStyle .= '.inline-fixed{margin-right:'.$quickOpenerSize.'px !important;}';
	$quickStyle .= '#header .topSection{width:calc(100% - '.$quickOpenerSize.'px) !important;}';
}

if($quick_news['qn_background']) $quickStyle .= '.quickNews_opener{color:#fff;background:'.$quick_news['qn_background'].';border:0;box-shadow:none;}';
if($quick_news['qn_background']) $quickStyle .= '.qn_ul .qn_li.active .qnSubject{color:'.$quick_news['qn_background'].';}';

$qn_width = $quick_news['qn_width'] ? $quick_news['qn_width'] : '350';
$qn_subject_size = $quick_news['qn_subject_size'] ? $quick_news['qn_subject_size'] : '15';
$qn_con_size = $quick_news['qn_con_size'] ? $quick_news['qn_con_size'] : '12';

if(!G5_IS_MOBILE) {
	$quickStyle .= '#quickNews-container{width:'.$qn_width.'px;}';
	$quickStyle .= '.quickNews .qn_ul .qn_li .qnSubject{font-size:'.$qn_subject_size.'px;}';
	$quickStyle .= '.quickNews .qn_ul .qn_li .qnContent{font-size:'.$qn_con_size.'px;}';
}

//스킨 설정
$autoThumb = true;
$thumb_width = G5_IS_MOBILE ? $qn_width * 1.5 : $qn_width;
$thumb_height = 0;
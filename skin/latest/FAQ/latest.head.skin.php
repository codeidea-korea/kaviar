<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


if($_masonry) $latestScript .= '$(window).ready(function(){ masonry_update("'.$blockID.' .masonry_wrap", '.$gutter.'); });'.PHP_EOL;

//pageMake에서 스킨설정할때 로드
$skin_type = array ("_faq_list", "_faq_masonry");
$skin_type_name = array ("FAQ 리스트", "FAQ (masonry)");
$skin_type_cols = array ("", 3);

$gallCols = $gallGutter = $latest_type == '_faq_masonry' ? true : false;
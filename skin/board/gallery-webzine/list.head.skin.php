<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//스킨 설정
$autoThumb = true;
$autoSize = 'webzine';
$thumb_width = G5_IS_MOBILE ? $board['bo_mobile_gallery_width']*1.5 : $board['bo_gallery_width'];
$thumb_height = G5_IS_MOBILE ? $board['bo_mobile_gallery_height']*1.5 : $board['bo_gallery_height'];
$thumb_option = 'default'; //관리자 썸네일 미리보기 사이즈
?>
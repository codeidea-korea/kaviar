<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 게시판 관리의 상단 내용
if (G5_IS_MOBILE) {
    // 모바일의 경우 설정을 따르지 않는다.
    include_once(G5_BBS_PATH.'/_head.php');
	//echo html_purifier(stripslashes($board['bo_mobile_content_head']));
    if(!$bo_top_img) echo html_purifier(stripslashes($board['bo_mobile_content_head'])); //인태 - 상단이미지가 없을때만 출력 $bo_top_img
} else {

    // 상단 파일 경로를 입력하지 않았다면 기본 상단 파일도 include 하지 않음
    if (trim($board['bo_include_head'])) {
        if (is_include_path_check($board['bo_include_head'])) {  //파일경로 체크
            @include ($board['bo_include_head']);
        } else {    //파일경로가 올바르지 않으면 기본파일을 가져옴
            include_once(G5_BBS_PATH.'/_head.php');
        }
    }
	//echo html_purifier(stripslashes($board['bo_content_head']));
    if(!$bo_top_img) echo html_purifier(stripslashes($board['bo_content_head'])); //인태 - 상단이미지가 없을때만 출력 $bo_top_img
}

//게시판 관리(팝업)
if($boSetting) echo $boSetting;

if(empty($wr_id)) {
	include_once(G5_LIB_PATH.'/my/shop_block.lib.php');

	echo '<article id="shopIndex" class="relative">';	
		if($is_admin) echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate='.$bo_table.'_bl&title=게시판 블럭 관리" id="shopIndexSetting" class="btnSetting popWin" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopIndex">게시판 블럭 관리</a>';
		echo shop_block($bo_table.'_bl');
	echo '</article>';
}
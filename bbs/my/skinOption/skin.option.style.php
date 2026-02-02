<?php
if (!defined('_GNUBOARD_')) exit;// 개별 페이지 접근 불가


//목록페이지 전용
if($bo_listpage) {
	
	// 공통 -------------------------------------------
	if($textColor) $boStyle .= '#'.$bo_table.' .skinOption-text-color *{color:'.$textColor.';}';
	if($titleSize) $boStyle .= '#'.$bo_table.' .skinOption-subject{font-size:'.$titleSize.'px;}';
	if($titleSize && $titleSize < 14) $boStyle .= '#'.$bo_table.' .tbl_wrap{font-size:'.$titleSize.'px;}';
	if($titleEllipsis) $boStyle .= '#'.$bo_table.' .skinOption-subject:not(.td_subject){display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}';
	if($fontStyle) $boStyle .= '#'.$bo_table.' .skinOption-subject{'.$fontStyle.'}';
	if($title_hover_underline) $boStyle .= '#'.$bo_table.' .skinOption-subject a:hover{text-decoration:underline;}';
	if($subjectColor) $boStyle .= '#'.$bo_table.' .skinOption-subject, #'.$bo_table.' .skinOption-subject a{color:'.$subjectColor.' !important;}';
	if($conSize) $boStyle .= '#'.$bo_table.' .skinOption-con{font-size:'.$conSize.'px;}';
	if($conLine) {
		$con_h = $conLine * 1.6;
		$boStyle .= '#'.$bo_table.' .skinOption-con{overflow:hidden;line-height:1.6em;height:'.$con_h.'em;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:'.$conLine.';-webkit-box-orient:vertical;word-wrap:break-word;}';
	}
	if($conColor) $boStyle .= '#'.$bo_table.' .skinOption-con, #'.$bo_table.' .skinOption-con a{color:'.$conColor.' !important;}';
	if($txtAlign) $boStyle .= '#'.$bo_table.' .skinOption-text-align{text-align:'.$txtAlign.';}';
	if($txtPosition == 'top') {
		$boStyle .= '#'.$bo_table.' .skinOption-text-align{display:flex;flex-direction:column;justify-content:flex-start;}';
	} else if($txtPosition == 'center') {
		$boStyle .= '#'.$bo_table.' .skinOption-vertical-align{display:flex;flex-direction:column;justify-content:center;}';
	} else if($txtPosition == 'bottom') {
		$boStyle .= '#'.$bo_table.' .skinOption-vertical-align{display:flex;flex-direction:column;justify-content:flex-end;}';
	}
	
	// TABLE ---------------------------------------------
	if($tableColor) $boStyle .= '#'.$bo_table.' .tbl_wrap th{border-color:'.$tableColor.';}';
	if($tableColor == '#ffffff') $boStyle.' .tbl_wrap thead th{color:#000 !important;}';
	if($tableFilled) {
		if($tableColor) {
			$boStyle .= '#'.$bo_table.' .tbl_wrap th{color:#fff;background:'.$tableColor.';}';
		} else {
			$boStyle .= '#'.$bo_table.' .tbl_wrap th{color:#fff;background:#595959;border-top:0;border-bottom:0;}';			
		}
		$boStyle .= '#'.$bo_table.' .tbl_wrap th{border-top:0;border-bottom:0;}';
		$boStyle .= '#'.$bo_table.' .tbl_wrap thead tr th:first-child{border-top-left-radius:2px;border-bottom-left-radius:2px;}';
		$boStyle .= '#'.$bo_table.' .tbl_wrap thead tr th:last-child{border-top-right-radius:2px;border-bottom-right-radius:2px;}';
	}
	if($trHeight) $boStyle .= '#'.$bo_table.' .tbl_wrap td{padding-top:0;padding-bottom:0;height:'.$trHeight.'px;}';
	if($trOver) $boStyle .= '
	#'.$bo_table.' .tbl_wrap tr td{transition:all .2s ease-in-out;}
	#'.$bo_table.' .tbl_wrap tr:hover td{background:rgba(0,0,0,0.025);}';
	if($tableLine) $boStyle .= '
	#'.$bo_table.' .tbl_wrap th{text-align:center;letter-spacing:-0.1em}
	#'.$bo_table.' .tbl_wrap td{border:1px solid rgba(0,0,0,0.1);}
	#'.$bo_table.' .tbl_wrap tr td:first-child{border-left:0;}
	#'.$bo_table.' .tbl_wrap tr td.edit-mode:not(.on) + td{border-left:0;}
	#'.$bo_table.' .tbl_wrap tr td:last-child{border-right:0;}
	#'.$bo_table.' .tbl_wrap td.td_subject{padding-left:20px;padding-right:20px;}';
	
	

	// 갤러리 -------------------------------------------
	if(!$webzine && !$grid) {
		if($list_frame) {
			if($round) $boStyle .= '#'.$bo_table.' .gallContents{border-radius:'.$round.'px;overflow:hidden;}';
		} else {
			if($round) $boStyle .= '#'.$bo_table.' .gall_thumb{border-radius:'.$round.'px;}';
		}
	}
	if($round) $boStyle .= '#'.$bo_table.' .skinOption-round{border-radius:'.$round.'px;}';
	

	//webzine
	if($webzine) {
		if($list_frame) {
			$boStyle .= '.webzine .labelCheck{position:absolute;top:-5px;left:-5px;}';
			$boStyle .= '#'.$bo_table.' .webzine .gall_li{border:0;margin-bottom:'.$gutter.'px;}';			
			$boStyle .= '#'.$bo_table.' .webzine .gall_li:last-child{margin-bottom:0;}';
			$boStyle .= '#'.$bo_table.' .wzContents{background:rgba(255,255,255,0.4);border:1px solid rgba(0,0,0,0.15);padding:30px;}';
			if($shadow) $boStyle .= '#'.$bo_table.' .wzContents{box-shadow:0 5px 5px rgba(0,0,0,0.03);}';
			if($round) $boStyle .= '#'.$bo_table.' .wzContents{border-radius:'.$round.'px;overflow:hidden;}';
		} else {
			if($round) $boStyle .= '#'.$bo_table.' .wz_thumb, #'.$bo_table.' .wz_thumb .video{border-radius:'.$round.'px;overflow:hidden;}';
		}
		if($zigzag) {
			//$boStyle .= '#'.$bo_table.' .webzine .gall_li:nth-child(2n) .wzContents{}';
			$boStyle .= '#'.$bo_table.' .webzine .gall_li:nth-child(2n) .wz_thumb{order:2;}';
			$boStyle .= '#'.$bo_table.' .webzine .gall_li:nth-child(2n) .wzContents .wz_thumb + .wz_con{padding-left:0;padding-right:30px;}';
		}
	}

	if($grid) {
		if($list_frame) {
			$boStyle .= '#'.$bo_table.' .auto_li{padding:15px;background:#fff;border:1px solid rgba(0,0,0,0.1);}';
			$boStyle .= '#'.$bo_table.' .auto_li.grid_1x1 .con{padding:15px;}';
			if($shadow) $boStyle .= '#'.$bo_table.' .auto_li{box-shadow:0 5px 5px rgba(0,0,0,0.03);}';
			if($round) $boStyle .= '#'.$bo_table.' .auto_li{border-radius:'.$round.'px;}';
		}
		$img_round = round($round / 1.7, 1);
		if($round) $boStyle .= '#'.$bo_table.' .thumb{border-radius:'.$img_round.'px;overflow:hidden;}';
	}

	if($bubbleColor) $boStyle .= ':root{--blahblah-bubble-color:'.$bubbleColor.';}';

	if($marker_bubbleColor) $boStyle .= ':root{--map-bubble-color:'.$marker_bubbleColor.';}';
	
}


//뷰페이지 전용
if($bo_viewpage) {
	
	//PDF뷰어
	if($pdf_nav_width) $boStyle .= '#'.$bo_table.' #iv-navigation{width:'.$pdf_nav_width.'px}';
}


//쓰기이지 전용
if($bo_writepage) {

}
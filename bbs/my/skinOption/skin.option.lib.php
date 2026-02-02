<?php
// bbs/board_head.php에서 로드됨
$board = sql_fetch(" select * from {$g5['board_table']} where bo_table='".$bo_table."'");

$bo_skinOption = $board['bo_option'];

if($bo_skinOption){ //게시판 옵션
	$bo_skinOption = preg_replace("/,/", " ", $bo_skinOption); //,를&nbsp;로 변환
	//$bo_skinOption = preg_replace("/\([^()]+\)/", "", $bo_skinOption); //(컬러코드) 삭제
}

$notSubject = strpos($bo_skinOption, '제목사용안함') !== false ? true : false;

if(strpos($bo_skinOption, '텍스트컬러') !== false) {
	$textColor = strstr($bo_skinOption, '텍스트컬러');
	preg_match( '!\(([^\)]+)\)!', $textColor, $textColor );
	$textColor = $textColor[1];
}

if(!$notSubject) {
	if(strpos($bo_skinOption, '제목사이즈') !== false) { //제목사이즈 추출
		$titleSize = strstr($bo_skinOption, '제목사이즈');
		$titleSize = explode(' ', $titleSize);
		$titleSize = preg_replace("/[^0-9]*/s", "", $titleSize[0]); //숫자만 추출
	}
	$titleEllipsis = strpos($bo_skinOption, '제목한줄자르기') !== false ? true : false;
	//제목 폰트 변경
	if(strpos($bo_skinOption, '나눔고딕보통') !== false) {
		$fontStyle = "font-family:'Nanum Gothic', sans-serif;";
	} else if(strpos($bo_skinOption, '나눔고딕볼드') !== false) {
		$fontStyle = "font-family:'Nanum Gothic', sans-serif';font-weight:bold;";
	} else if(strpos($bo_skinOption, '본고딕100') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:100;";
	} else if(strpos($bo_skinOption, '본고딕200') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:200;";
	} else if(strpos($bo_skinOption, '본고딕300') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:300;";
	} else if(strpos($bo_skinOption, '본고딕400') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:400;";
	} else if(strpos($bo_skinOption, '본고딕500') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:500;";
	} else if(strpos($bo_skinOption, '본고딕600') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:600;";
	} else if(strpos($bo_skinOption, '본고딕700') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:700;";
	} else if(strpos($bo_skinOption, '나눔스퀘어라운드300') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:300;";
	} else if(strpos($bo_skinOption, '나눔스퀘어라운드400') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:400;";
	} else if(strpos($bo_skinOption, '나눔스퀘어라운드700') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:700;";
	} else if(strpos($bo_skinOption, '나눔스퀘어라운드800') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:800;";
	} else if(strpos($bo_skinOption, '검은고딕') !== false) {
		$fontStyle = "font-family:'Black Han Sans', sans-serif;font-weight:normal;";
	} else {
		$fontStyle = '';
	}
	$title_hover_underline = strpos($bo_skinOption, '제목링크밑줄') !== false ? true : false;
	if(strpos($bo_skinOption, '제목컬러') !== false) {
		$subjectColor = strstr($bo_skinOption, '제목컬러');
		preg_match( '!\(([^\)]+)\)!', $subjectColor, $subjectColor );
		$subjectColor = $subjectColor[1];
	}
}

if(strpos($bo_skinOption, '내용사이즈') !== false) { //내용사이즈 추출
	$conSize = strstr($bo_skinOption, '내용사이즈');
	$conSize = explode(' ', $conSize);
	$conSize = preg_replace("/[^0-9]*/s", "", $conSize[0]); //숫자만 추출
}
if(strpos($bo_skinOption, '최대폰트사이즈') !== false) {
	$maxFontSize = strstr($bo_skinOption, '최대폰트사이즈');
	$maxFontSize = explode(' ', $maxFontSize);
	$maxFontSize = preg_replace("/[^0-9]*/s", "", $maxFontSize[0]);
}
if(strpos($bo_skinOption, '내용줄수') !== false) { //내용줄수 추출
	$conLine = strstr($bo_skinOption, '내용줄수');
	$conLine = explode(' ', $conLine);
	$conLine = preg_replace("/[^0-9]*/s", "", $conLine[0]); //숫자만 추출
}
if(strpos($bo_skinOption, '내용글자수') !== false) { //내용글자수 추출
	$conLen = strstr($bo_skinOption, '내용글자수');
	$conLen = explode(' ', $conLen);
	$conLen = preg_replace("/[^0-9]*/s", "", $conLen[0]); //숫자만 추출
}
$contents_html = strpos($bo_skinOption, '내용HTML출력') !== false ? true : false;
if(strpos($bo_skinOption, '내용컬러') !== false) {
	$conColor = strstr($bo_skinOption, '내용컬러');
	preg_match( '!\(([^\)]+)\)!', $conColor, $conColor );
	$conColor = $conColor[1];
}
//text 정렬
if(strpos($bo_skinOption, '왼쪽정렬') !== false) $txtAlign = 'left';
if(strpos($bo_skinOption, '가운데정렬') !== false) $txtAlign = 'center';
if(strpos($bo_skinOption, '오른쪽정렬') !== false) $txtAlign = 'right';
//position 정렬
if(strpos($bo_skinOption, '상단정렬') !== false) $txtPosition = 'top';
if(strpos($bo_skinOption, '중앙정렬') !== false) $txtPosition = 'center';
if(strpos($bo_skinOption, '하단정렬') !== false) $txtPosition = 'bottom';


$frontCate = strpos($bo_skinOption, '카테고리명 앞으로') !== false ? true : false;
//$extraSelectShow = strpos($bo_skinOption, 'extraSelectShow') !== false ? true : false;
//$categoryAlign = strpos($bo_skinOption, 'categoryAlign') !== false ? true : false;
//$extraAlign = strpos($bo_skinOption, 'extraAlign') !== false ? true : false;



// 테이블 스킨
if(strpos($bo_skinOption, '테이블컬러') !== false) {
	$tableColor = strstr($bo_skinOption, '테이블컬러');
	preg_match( '!\(([^\)]+)\)!', $tableColor, $tableColor );
	$tableColor = $tableColor[1];
}
$tableFilled = strpos($bo_skinOption, '테이블 헤드 색채우기') !== false ? true : false;
$tableLine = strpos($bo_skinOption, '테이블 전체라인') !== false ? true : false;
if(strpos($bo_skinOption, '테이블 한줄높이') !== false) { //테이블 한줄높이 추출
	$trHeight = strstr($bo_skinOption, '한줄높이');
	$trHeight = explode(' ', $trHeight);
	$trHeight = preg_replace("/[^0-9]*/s", "", $trHeight[0]);
}
$trOver = strpos($bo_skinOption, '테이블 롤오버 효과') !== false ? true : false;


// 갤러리
$skinOption_frame = strpos($bo_skinOption, '외곽선') !== false ? 'skinOption-frame' : '';
$shadow = strpos($bo_skinOption, '그림자') !== false ? true : false;
$img_frame = strpos($bo_skinOption, '이미지여백') !== false ? true : false;
//$webzine_inline = strpos($bo_skinOption, '인라인스타일') !== false ? true : false;

if(strpos($bo_skinOption, '라운딩') !== false) { //round 추출
	$round = strstr($bo_skinOption, '라운딩');
	$round = explode(' ', $round);
	$round = preg_replace("/[^0-9]*/s", "", $round[0]); //숫자만 추출
}
$zigzag= strpos($bo_skinOption, '지그재그') !== false ? true : false;


// PDF 뷰어
$pdf_nav_right = strpos($bo_skinOption, '네비오른쪽') !== false ? true : false;
if(strpos($bo_skinOption, '네비가로사이즈') !== false) { //round 추출
	$pdf_nav_width = strstr($bo_skinOption, '네비가로사이즈');
	$pdf_nav_width = explode(' ', $pdf_nav_width);
	$pdf_nav_width = preg_replace("/[^0-9]*/s", "", $pdf_nav_width[0]); //숫자만 추출
}



// 블라블라, 인터뷰 및 ..
if(strpos($bo_skinOption, '라벨변경-인물정보-') !== false) {
	$label_new_info = strstr($bo_skinOption, '라벨변경-인물정보-');
	$label_new_info = explode(' ', $label_new_info);
	$label_new_info = preg_replace("/라벨변경-인물정보-/", " ", $label_new_info[0]);
}
$label_new_info = $label_new_info ? $label_new_info : '인물정보';

if(strpos($bo_skinOption, '말풍선컬러') !== false) {
	$bubbleColor = strstr($bo_skinOption, '말풍선컬러');
	preg_match( '!\(([^\)]+)\)!', $bubbleColor, $bubbleColor );
	$bubbleColor = $bubbleColor[1];
}




// 지도 스킨
$map_table = strpos($bo_skinOption, '테이블목록') !== false ? true : false;

$map_multy = strpos($bo_skinOption, '멀티지도') !== false ? true : false;

if(strpos($bo_skinOption, '초기위도-') !== false) {
	$start_lat = strstr($bo_skinOption, '초기위도-');
	$start_lat = explode(' ', $start_lat);
	$start_lat = preg_replace("/초기위도-/", " ", $start_lat[0]);
}
if(strpos($bo_skinOption, '초기경도-') !== false) {
	$start_lng = strstr($bo_skinOption, '초기경도-');
	$start_lng = explode(' ', $start_lng);
	$start_lng = preg_replace("/초기경도-/", " ", $start_lng[0]);
}
if(strpos($bo_skinOption, '초기줌-') !== false) {
	$start_zoom = strstr($bo_skinOption, '초기줌-');
	$start_zoom = explode(' ', $start_zoom);
	$start_zoom = preg_replace("/초기줌-/", " ", $start_zoom[0]);
}
if(strpos($bo_skinOption, '지도높이') !== false) {
	$map_height = strstr($bo_skinOption, '지도높이');
	$map_height = explode(' ', $map_height);
	$map_height = preg_replace("/[^0-9]*/s", "", $map_height[0]);
}
if(strpos($bo_skinOption, '라벨변경-센터명-') !== false) {
	$label_center = strstr($bo_skinOption, '라벨변경-센터명-');
	$label_center = explode(' ', $label_center);
	$label_center = preg_replace("/라벨변경-센터명-/", " ", $label_center[0]);
}
$label_center = $label_center ? $label_center : '센터명';
if(strpos($bo_skinOption, '마커말풍선컬러') !== false) {
	$marker_bubbleColor = strstr($bo_skinOption, '마커말풍선컬러');
	preg_match( '!\(([^\)]+)\)!', $marker_bubbleColor, $marker_bubbleColor );
	$marker_bubbleColor = $marker_bubbleColor[1];
}

//----------------------------------------------------------------------------------------------------------- 아직 작업전










$noListBar = strpos($bo_skinOption, 'noListBar') !== false ? true : false; //map_ajaxView - 목록바 사용안함





$man_to_man = strpos($bo_skinOption, 'man_to_man') !== false ? true : false; //inquiry - 1:1기능(자신이 쓴글만 보이기)

$replyState = strpos($bo_skinOption, 'replyState') !== false ? true : false; //inquiry - 답변상태 기능 사용













$showScrollMenu = strpos($bo_skinOption, 'showScrollMenu') !== false ? true : false; //pageMake에서 스크롤메뉴 출력







if($nonono) { //나중에 삭제 처리...
$is_bo_latestSkin = $board['bo_latest_skin'] && $board['bo_latest_board'] && $board['bo_latest_list'] && !$bo_writepage ? true : false; //별도게시판스킨||불러올게시판||목록수||쓰기페이지제외

//게시판내 최신글 스킨(이어붙인 게시판)
$bo_latest_skinOption = G5_IS_MOBILE ? $board['bo_latest_mobile_option'] : $board['bo_latest_option'];
$bo_latest_skinOption = $bo_latest_skinOption ? preg_replace("/,/", " ", $bo_latest_skinOption) : ''; //[,]를 [&nbsp;]로 변환

$bo_latest_order = 'bo';
if($board['bo_latest_skin'] == 'multyMap') $bo_latest_order = 'notice_up';
if(strpos($bo_latest_skinOption, 'random') !== false) $bo_latest_order = 'random';

$latestSkinStyle = 'width:100%;';
if(!G5_IS_MOBILE) {
	if($board['bo_latest_width'] == 'fullSize') { //가로 풀사이즈
		$bo_latestWidth = '2000';
	} else if($board['bo_latest_width'] == 'boardSize') { //게시판에 맞춤
		$latestSkinStyle .= 'max-width:'.$width.'; margin-left:auto; margin-right:auto;';
		$bo_latestWidth = $width;
	}
}
if(strpos($bo_latest_skinOption, 'paddingTop') !== false) { //paddingTop 추출
	$blpdnt = strpos($bo_latest_skinOption, 'paddingTop');
	$bo_latest_paddingTopNum = substr($bo_latest_skinOption, $blpdnt, 13);
	$bo_latest_paddingTopNum = preg_replace("/[^0-9]*/s", "", $bo_latest_paddingTopNum);
	$latestSkinStyle .= 'padding-top:'.$bo_latest_paddingTopNum.'px;';
}
if(strpos($bo_latest_skinOption, 'paddingBottom') !== false) { //paddingBottom 추출
	$blpdnb = strpos($bo_latest_skinOption, 'paddingBottom');
	$bo_latest_paddingBottomNum = substr($bo_latest_skinOption, $blpdnb, 16);
	$bo_latest_paddingBottomNum = preg_replace("/[^0-9]*/s", "", $bo_latest_paddingBottomNum);
	$latestSkinStyle .= 'padding-bottom:'.$bo_latest_paddingBottomNum.'px;';
}
if(strpos($bo_latest_skinOption, 'paddingLeftRight') !== false) { //paddingLeftRight 추출
	$blpdlrn = strpos($bo_latest_skinOption, 'paddingLeftRight');
	$bo_latest_paddingLeftRightNum = substr($bo_latest_skinOption, $blpdlrn, 19);
	$paddingLeftRightNum = preg_replace("/[^0-9]*/s", "", $bo_latest_paddingLeftRightNum);
	$latestSkinStyle .= 'padding-left:'.$bo_latest_paddingLeftRightNum.'px; padding-right:'.$bo_latest_paddingLeftRightNum.'px;';
}
$latestSkinStyle .= $board['bo_latest_background'] ? 'background:'.$board['bo_latest_background'].';' : '';

$bo_latestSkin .= '<div class="bo_latestWrap">';
$bo_latestSkin .= '<div class="bo_latest '.$bo_latest_skinOption.'" style="'.$latestSkinStyle.'">';
//$bo_latestSkin .= latest_multi($board['bo_latest_skin'], $board['bo_latest_board'], $board['bo_latest_list'], 100, 0, $bo_latest_order, $bo_latest_skinOption, $bo_latestWidth);
$bo_latestSkin .= '</div>';
$bo_latestSkin .= '</div>';

$bo_top_latestSkin = '';
$bo_bottom_latestSkin = '';
if($is_bo_latestSkin && $board['bo_latest_position'] == 'top') $bo_top_latestSkin = $bo_latestSkin;
if($is_bo_latestSkin && $board['bo_latest_position'] == 'bottom') $bo_bottom_latestSkin = $bo_latestSkin;

include_once($board_skin_path.'/skin.option.lib.php');
}
?>
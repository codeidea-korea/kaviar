<?php
$bo_table = $bo_table ? $bo_table : $latest_table; //관리자 옵션 설정할때 적용되어 있는 옵션 불러오기 위해서... (bbs/my/skinOption/latest.skin.option.php)에서 로드될때
$board = sql_fetch(" select * from {$g5['board_table']} where bo_table='".$bo_table."'"); //게시판 테이블

if($latestOption){ //최신글 옵션
	$latestOption = preg_replace("/,/", " ", $latestOption); //,를&nbsp;로 변환
}

//////////////////////////////////////////////
// 공통 ───────────────────────
//////////////////////////////////////////////

$is_SQUARE = strpos($latestOption, '스퀘어') !== false ? true : false;


$notSubject = strpos($latestOption, '제목사용안함') !== false ? true : false;

if(strpos($latestOption, '텍스트컬러') !== false) {
	$textColor = strstr($latestOption, '텍스트컬러');
	preg_match( '!\(([^\)]+)\)!', $textColor, $textColor );
	$textColor = $textColor[1];
}

if(!$notSubject) {
	if(strpos($latestOption, '제목사이즈') !== false) { //제목사이즈 추출
		$titleSize = strstr($latestOption, '제목사이즈');
		$titleSize = explode(' ', $titleSize);
		$titleSize = preg_replace("/[^0-9]*/s", "", $titleSize[0]); //숫자만 추출
	}
	$titleEllipsis = strpos($latestOption, '제목한줄자르기') !== false ? true : false;
	//제목 폰트 변경
	if(strpos($latestOption, '나눔고딕보통') !== false) {
		$fontStyle = "font-family:'Nanum Gothic', sans-serif;";
	} else if(strpos($latestOption, '나눔고딕볼드') !== false) {
		$fontStyle = "font-family:'Nanum Gothic', sans-serif';font-weight:bold;";
	} else if(strpos($latestOption, '본고딕100') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:100;";
	} else if(strpos($latestOption, '본고딕200') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:200;";
	} else if(strpos($latestOption, '본고딕300') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:300;";
	} else if(strpos($latestOption, '본고딕400') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:400;";
	} else if(strpos($latestOption, '본고딕500') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:500;";
	} else if(strpos($latestOption, '본고딕600') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:600;";
	} else if(strpos($latestOption, '본고딕700') !== false) {
		$fontStyle = "font-family:'Noto Sans KR', sans-serif;font-weight:700;";
	} else if(strpos($latestOption, '나눔스퀘어라운드300') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:300;";
	} else if(strpos($latestOption, '나눔스퀘어라운드400') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:400;";
	} else if(strpos($latestOption, '나눔스퀘어라운드700') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:700;";
	} else if(strpos($latestOption, '나눔스퀘어라운드800') !== false) {
		$fontStyle = "font-family:'NanumSquareRound', sans-serif;font-weight:800;";
	} else if(strpos($latestOption, '검은고딕') !== false) {
		$fontStyle = "font-family:'Black Han Sans', sans-serif;font-weight:normal;";
	} else {
		$fontStyle = '';
	}
	$title_hover_underline = strpos($latestOption, '제목링크밑줄') !== false ? true : false;
	if(strpos($latestOption, '제목컬러') !== false) {
		$subjectColor = strstr($latestOption, '제목컬러');
		preg_match( '!\(([^\)]+)\)!', $subjectColor, $subjectColor );
		$subjectColor = $subjectColor[1];
	}
}

if(strpos($latestOption, '내용사이즈') !== false) { //내용사이즈 추출
	$conSize = strstr($latestOption, '내용사이즈');
	$conSize = explode(' ', $conSize);
	$conSize = preg_replace("/[^0-9]*/s", "", $conSize[0]); //숫자만 추출
}
if(strpos($latestOption, '최대폰트사이즈') !== false) {
	$maxFontSize = strstr($latestOption, '최대폰트사이즈');
	$maxFontSize = explode(' ', $maxFontSize);
	$maxFontSize = preg_replace("/[^0-9]*/s", "", $maxFontSize[0]);
}
if(strpos($latestOption, '내용줄수') !== false) { //내용줄수 추출
	$conLine = strstr($latestOption, '내용줄수');
	$conLine = explode(' ', $conLine);
	$conLine = preg_replace("/[^0-9]*/s", "", $conLine[0]); //숫자만 추출
}
if(!G5_IS_MOBILE) {
	if(strpos($latestOption, '내용글자수') !== false) { //내용글자수 추출
		$conLen = strstr($latestOption, '내용글자수');
		$conLen = explode(' ', $conLen);
		$conLen = preg_replace("/[^0-9]*/s", "", $conLen[0]); //숫자만 추출
	}
	if(strpos($latestOption, '내용글자수0') !== false) {
		$noContent = true;
	}
} else {
	if(strpos($latestOption, '모바일글자수') !== false) { //모바일 내용글자수 추출
		$conLen = strstr($latestOption, '모바일글자수');
		$conLen = explode(' ', $conLen);
		$conLen = preg_replace("/[^0-9]*/s", "", $conLen[0]); //숫자만 추출
	}
	if(strpos($latestOption, '모바일글자수0') !== false) {
		$noContent = true;
	}
}

$contents_html = strpos($latestOption, '내용HTML출력') !== false ? true : false;
if(strpos($latestOption, '내용컬러') !== false) {
	$conColor = strstr($latestOption, '내용컬러');
	preg_match( '!\(([^\)]+)\)!', $conColor, $conColor );
	$conColor = $conColor[1];
}
//text 정렬
if(strpos($latestOption, '왼쪽정렬') !== false) $txtAlign = 'left';
if(strpos($latestOption, '가운데정렬') !== false) $txtAlign = 'center';
if(strpos($latestOption, '오른쪽정렬') !== false) $txtAlign = 'right';
//position 정렬
if(strpos($latestOption, '상단정렬') !== false) $txtPosition = 'top';
if(strpos($latestOption, '중앙정렬') !== false) $txtPosition = 'center';
if(strpos($latestOption, '하단정렬') !== false) $txtPosition = 'bottom';


//정보 출력 여부
$showCateMenu = strpos($latestOption, '카테고리메뉴사용') !== false ? true : false;
$use_category = $board['bo_use_category'] && strpos($latestOption, '카테고리표기') !== false ? true : false;
$use_writer = strpos($latestOption, '작성자표기') !== false ? true : false;
$use_date = strpos($latestOption, '날짜표기') !== false ? true : false;
$use_good = $board['bo_use_good'] && strpos($latestOption, '좋아요표기') !== false ? true : false;
$use_hit = strpos($latestOption, '조회수표기') !== false ? true : false;
$use_reply = strpos($latestOption, '댓글수표기') !== false ? true : false;
$use_tag = strpos($latestOption, '태그표기') !== false ? true : false;
$use_list_btn = strpos($latestOption, '게시물버튼표기') !== false ? true : false;



$popupOption = 'latest';
if($bo_writer) $popupOption .=' bo_writer';
if($bo_date) $popupOption .=' bo_date';
if($is_good) $popupOption .=' is_good';
if($bo_hit) $popupOption .=' bo_hit';
if($bo_reply) $popupOption .=' bo_reply';


if(strpos($latestOption, '높이변경') !== false) {
	$height = strstr($latestOption, '높이변경');
	$height = explode(' ', $height);
	$height = preg_replace("/[^0-9]*/s", "", $height[0]);
}
if(strpos($latestOption, '말풍선컬러') !== false) {
	$bubbleColor = strstr($latestOption, '말풍선컬러');
	preg_match( '!\(([^\)]+)\)!', $bubbleColor, $bubbleColor );
	$bubbleColor = $bubbleColor[1];
}


//////////////////////////////////////////////
// gallery 공통 ──────────────────
//////////////////////////////////////////////
$skinOption_frame = strpos($latestOption, '외곽선') !== false ? 'skinOption-frame' : '';
$shadow = strpos($latestOption, '그림자') !== false ? true : false;
//$webzine_inline = strpos($latestOption, '인라인스타일') !== false ? true : false;
if(strpos($latestOption, '라운딩') !== false) { //round 추출
	$round = strstr($latestOption, '라운딩');
	$round = explode(' ', $round);
	$round = preg_replace("/[^0-9]*/s", "", $round[0]);
}
if(strpos($latestOption, '리스트가로수') !== false) { 
	$colspan = strstr($latestOption, '리스트가로수');
	$colspan = explode(' ', $colspan);
	$colspan = preg_replace("/[^0-9|.]*/s", "", $colspan[0]); //소수점 포함 숫자만 추출
}
if(strpos($latestOption, '리스트간격') !== false) { 
	$distance = strstr($latestOption, '리스트간격');
	$distance = explode(' ', $distance);
	$distance = preg_replace("/[^0-9]*/s", "", $distance[0]);
}
if(strpos($latestOption, '썸네일가로') !== false) { 
	$latest_gall_width = strstr($latestOption, '썸네일가로');
	$latest_gall_width = explode(' ', $latest_gall_width);
	$latest_gall_width = preg_replace("/[^0-9]*/s", "", $latest_gall_width[0]);
}
if(strpos($latestOption, '썸네일세로') !== false) { 
	$latest_gall_height = strstr($latestOption, '썸네일세로');
	$latest_gall_height = explode(' ', $latest_gall_height);
	$latest_gall_height = preg_replace("/[^0-9]*/s", "", $latest_gall_height[0]);
}
$imgOnly = strpos($latestOption, '이미지만') !== false ? true : false;
if($imgOnly) $skinOption_frame .= ' imgOnly';


//////////////////////////////////////////////
// swiper 공통 ──────────────────
//////////////////////////////////////////////
$freeSize = strpos($latestOption, '프리사이즈') !== false ? true : false;

$layout_horizon = strpos($latestOption, '좌미디어레이아웃') !== false ? true : false;
if(strpos($latestOption, '슬라이드높이') !== false) {
	$itemHeight = strstr($latestOption, 'itemHeight');
	$itemHeight = explode(' ', $itemHeight);
	$itemHeight = preg_replace("/[^0-9]*/s", "", $itemHeight[0]);
}
if(strpos($latestOption, '슬라이드세로줄') !== false) {
	$perColumn = strstr($latestOption, 'perColumn');
	$perColumn = explode(' ', $perColumn);
	$perColumn = preg_replace("/[^0-9]*/s", "", $perColumn[0]);
}
$loop = strpos($latestOption, '슬라이드반복') !== false ? true : false;

$showPager = strpos($latestOption, '네비게이션사용') !== false ? true : false;
$pager_text = strpos($latestOption, '네비게이션-텍스트') !== false ? true : false;
$pager_faction = strpos($latestOption, '네비게이션-넘버링') !== false ? true : false;
if($pager_text) {
	$pager_type = 'text';
} else if($pager_faction) {
	$pager_type = 'faction';
} else {
	$pager_type = 'default';
}
if(strpos($latestOption, '네비게이션컬러') !== false) {
	$pagerColor = strstr($latestOption, '네비게이션컬러');
	preg_match( '!\(([^\)]+)\)!', $pagerColor, $pagerColor );
	$pagerColor = $pagerColor[1];
}

if(strpos($latestOption, '자동넘김') !== false) {
	$autoplay = strstr($latestOption, '자동넘김');
	$autoplay = explode(' ', $autoplay);
	$autoplay = preg_replace("/자동넘김/", "", $autoplay[0]); //숫자만 추출
} else {
	$autoplay = 0;
}



// bigBanner 스킨 ──────────────────────────────
$animation_zoom = strpos($latestOption, '줌 효과') !== false ? true : false;
$animation_rotate_zoom = strpos($latestOption, '줌+로테이션 효과') !== false ? true : false;

// notice 스킨 ──────────────────────────────
$linebox_type = strpos($latestOption, '라인박스타입') !== false ? ' lineBox_type ' : '';








// 지도 스킨 ──────────────────────────────
if(strpos($latestOption, '초기위도-') !== false) {
	$start_lat = strstr($latestOption, '초기위도-');
	$start_lat = explode(' ', $start_lat);
	$start_lat = preg_replace("/초기위도-/", " ", $start_lat[0]);
}
if(strpos($latestOption, '초기경도-') !== false) {
	$start_lng = strstr($latestOption, '초기경도-');
	$start_lng = explode(' ', $start_lng);
	$start_lng = preg_replace("/초기경도-/", " ", $start_lng[0]);
}
if(strpos($latestOption, '초기줌-') !== false) {
	$start_zoom = strstr($latestOption, '초기줌-');
	$start_zoom = explode(' ', $start_zoom);
	$start_zoom = preg_replace("/초기줌-/", " ", $start_zoom[0]);
}
if(strpos($latestOption, '지도높이') !== false) {
	$map_height = strstr($latestOption, '지도높이');
	$map_height = explode(' ', $map_height);
	$map_height = preg_replace("/[^0-9]*/s", "", $map_height[0]);
}
if(strpos($latestOption, '마커말풍선컬러') !== false) {
	$marker_bubbleColor = strstr($latestOption, '마커말풍선컬러');
	preg_match( '!\(([^\)]+)\)!', $marker_bubbleColor, $marker_bubbleColor );
	$marker_bubbleColor = $marker_bubbleColor[1];
}
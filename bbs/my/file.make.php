<?php
include_once('./_common.php');

// html 디렉토리 생성
@mkdir(G5_HTML_PATH, G5_DIR_PERMISSION);

$_type = $_POST['type'];
$_dir = $_POST['dir'];
$_html_path = $_dir ? G5_HTML_PATH.'/'.$_dir : G5_THIS_PATH;
$_file_path = $_POST['file_path'];


//생성할 폴더가 있다면 생성
@mkdir($_html_path, G5_DIR_PERMISSION);



// 파일생성
if (isset($_POST['file_path']) && !file_exists($_file_path)) {

	fopen($_file_path, 'w');
	$f = @fopen($_file_path, 'a');

	if($_type == 'board') {
		$bo_table = $_dir;
		if($bo_table) {
			$_style_path = $_html_path.'/style.css';
			$_style_mobile_path = $_html_path.'/mobile.css';
			$_skin = $_POST['skin'];
			$_file_id = $_POST['file_id'];
			@mkdir($_html_path.'/img', G5_DIR_PERMISSION);
		}
		if(!$_file_id) {
			fwrite($f, "<?php\n");
			if(strpos($_file_path, 'bo_top') !== false)
				fwrite($f, "//이곳에 작성한 HTML은 ".$bo_table." 게시판 상단에 출력합니다.\n");
			if(strpos($_file_path, 'bo_bottom') !== false)
				fwrite($f, "//이곳에 작성한 HTML은 ".$bo_table." 게시판 하단에 출력합니다.\n");				
			fwrite($f, "?>\n");
		} else {
			if(strpos($_skin, 'pageMake') !== false) {
				fwrite($f, "<?php\n");
				if(strpos($_file_path, '_top') !== false) {
					fwrite($f, "//이곳에 작성한 HTML은 ".$bo_table." 게시판 > (ID번호)".$_file_id."번 블럭의 콘텐츠 상단에 출력합니다.\n");
				} else {
					fwrite($f, "//이곳에 작성한 HTML은 ".$bo_table." 게시판 > (ID번호)".$_file_id."번 블럭에 출력합니다.\n");
				}
				fwrite($f, "?>\n");
				fwrite($f, "\n");
				if(strpos($_file_path, '_top') !== false) {
					fwrite($f, "<div class=\"sectionTopContainer\">\n");
				} else {
					fwrite($f, "<div class=\"sectionContainer\">\n");
				}
				fwrite($f, "</div>\n");
			} else {
				fwrite($f, "<?php\n");
				fwrite($f, "//이곳에 작성한 HTML은 ".$bo_table." 게시판 > (ID번호)".$_file_id."번 게시물의 상세페이지에 출력합니다.\n");
				fwrite($f, "?>\n");
				fwrite($f, "\n");
				fwrite($f, "<div class=\"incContainer\">\n");
				fwrite($f, "</div>\n");
			}
		}
	}
	
	if($_type == 'footer') {
		fwrite($f, "<?php\n");
		fwrite($f, "//이곳에 작성한 HTML은 사이트 하단(카피라이트)에 출력합니다.\n");
		fwrite($f, "?>\n");
		fwrite($f, "\n");
		fwrite($f, "<div id=\"_footerContainer\">\n");
		fwrite($f, "</div>\n");
	}
	



	// 쇼핑몰 사이트 ──────────────────────────────────────────────

	if($_type == 'shop_footer') {
		fwrite($f, "<?php\n");
		fwrite($f, "//이곳에 작성한 HTML은 쇼핑몰 사이트 하단(카피라이트)에 출력합니다.\n");
		fwrite($f, "?>\n");
		fwrite($f, "\n");
		fwrite($f, "<div id=\"_footerContainer\">\n");
		fwrite($f, "</div>\n");
	}
	
	if($_type == 'shop_block') {
		$_style_path = $_html_path.'/style.css';
		$_file_id = $_POST['file_id'];
		@mkdir($_html_path.'/img', G5_DIR_PERMISSION);
		
		fwrite($f, "<?php\n");
		fwrite($f, "//이곳에 작성한 HTML은 쇼핑몰 블럭 ID".$_file_id."에 출력합니다.\n");
		fwrite($f, "//이미지 경로 - \$html_img_url\n");
		fwrite($f, "?>\n");
		fwrite($f, "\n");
		if(strpos($_file_path, '_top') !== false) {
			fwrite($f, "<div id=\"bl_id_".$_file_id."_top\" class=\"_sectionContainer\">\n");
		} else {
			fwrite($f, "<div id=\"bl_id_".$_file_id."\" class=\"_sectionContainer\">\n");
		}
		fwrite($f, "</div>\n");
	}


	//스타일 파일 생성
	if($_style_path && !file_exists($_style_path)){
		fopen($_style_path, 'w');
		$fc = @fopen($_style_path, 'a');
	}
	if($_style_mobile_path && !file_exists($_style_mobile_path)){
		fopen($_style_mobile_path, 'w');
		$fc = @fopen($_style_mobile_path, 'a');
	}
}
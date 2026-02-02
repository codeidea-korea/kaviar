<?php
if (!defined('_GNUBOARD_')) exit;// 개별 페이지 접근 불가

//latest_multi_lib.php 에서 상속받음

// 공통 -------------------------------------------
if($textColor) $latestStyle .= $blockID.' .skinOption-text-color *{color:'.$textColor.';}'.PHP_EOL;
if($titleSize) $latestStyle .= $blockID.' .skinOption-subject{font-size:'.$titleSize.'px;}'.PHP_EOL;
if($titleSize && $titleSize < 14) $latestStyle .= $blockID.' .tbl_wrap{font-size:'.$titleSize.'px;}'.PHP_EOL;
if($titleEllipsis) $latestStyle .= $blockID.' .skinOption-subject{width:100%;display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;}'.PHP_EOL;
if($fontStyle) $latestStyle .= $blockID.' .skinOption-subject{'.$fontStyle.'}'.PHP_EOL;
if($title_hover_underline) $latestStyle .= $blockID.' .skinOption-subject a:hover{text-decoration:underline;}'.PHP_EOL;
if($subjectColor) $latestStyle .= $blockID.' .skinOption-subject{color:'.$subjectColor.';}'.PHP_EOL;
if($conSize) $latestStyle .= $blockID.' .skinOption-con{font-size:'.$conSize.'px;}'.PHP_EOL;

if($conLine) {
	$con_h = $conLine * 1.6;
	$latestStyle .= $blockID.' .skinOption-con{overflow:hidden;line-height:1.6em;height:'.$con_h.'em;text-overflow:ellipsis;display:-webkit-box;-webkit-line-clamp:'.$conLine.';-webkit-box-orient:vertical;word-wrap:break-word;}'.PHP_EOL;
}
if($conColor) $latestStyle .= $blockID.' .skinOption-con{color:'.$conColor.';}'.PHP_EOL;
if($txtAlign) $latestStyle .= $blockID.' .skinOption-text-align{text-align:'.$txtAlign.';}'.PHP_EOL;
if($txtPosition == 'top') {
	$latestStyle .= $blockID.' .skinOption-text-align{display:flex;flex-direction:column;justify-content:flex-start;}'.PHP_EOL;
} else if($txtPosition == 'center') {
	$latestStyle .= $blockID.' .skinOption-vertical-align{display:flex;flex-direction:column;justify-content:center;}'.PHP_EOL;
} else if($txtPosition == 'bottom') {
	$latestStyle .= $blockID.' .skinOption-vertical-align{display:flex;flex-direction:column;justify-content:flex-end;}'.PHP_EOL;
}

if($round) $latestStyle .= $blockID.' .skinOption-round{border-radius:'.$round.'px;}'.PHP_EOL;


//webzine
/*if($webzine) {
	if($outline) {
		$latestStyle .= $blockID.' .webzine .gall_li{border:0;margin-bottom:'.$gutter.'px;}'.PHP_EOL;			
		$latestStyle .= $blockID.' .webzine .gall_li:last-child{margin-bottom:0;}'.PHP_EOL;
		$latestStyle .= $blockID.' .wzContents{background:#fff;border:1px solid rgba(0,0,0,0.15);padding:30px;}'.PHP_EOL;
		if($shadow) $latestStyle .= $blockID.' .wzContents{box-shadow:0 5px 5px rgba(0,0,0,0.03);}'.PHP_EOL;
		if($round) $latestStyle .= $blockID.' .wzContents{border-radius:'.$round.'px;overflow:hidden;}'.PHP_EOL;
	} else {
		if($round) $latestStyle .= $blockID.' .wz_thumb, #'.$bo_table.' .wz_thumb .video{border-radius:'.$round.'px;overflow:hidden;}'.PHP_EOL;
	}
	if($zigzag) {
		$latestStyle .= $blockID.' .webzine .gall_li:nth-child(2n) .wz_thumb{order:2;}'.PHP_EOL;
		$latestStyle .= $blockID.' .webzine .gall_li:nth-child(2n) .wzContents .wz_thumb + .wz_con{padding-left:0;padding-right:30px;}'.PHP_EOL;
	}
}

if($bubbleColor) $latestStyle .= ':root{--blahblah-bubble-color:'.$bubbleColor.';}'.PHP_EOL;*/



// _slide -------------------------------------------
if($_slide) {

	if($pager_text) {
		$playtime = $autoplay * 1000 + 600;
		$latestStyle .= $blockID.' .pagination.text .swiper-pagination-bullet.swiper-pagination-bullet-active:before{animation-duration:'.$playtime.'ms;}'.PHP_EOL;
	}
	if($pagerColor) {
		if($pager_text) {
			$latestStyle .= $blockID.' .pagination.text .swiper-pagination-bullet{color:'.$pagerColor.';}'.PHP_EOL;
			$latestStyle .= $blockID.' .pagination.text .swiper-pagination-bullet:before{border-color:'.$pagerColor.';}'.PHP_EOL;
			$latestStyle .= $blockID.' .pagination.text .swiper-pagination-bullet:after{border-color:'.$pagerColor.';opacity:0.7;}'.PHP_EOL;
		} else if($pager_faction) {
			$latestStyle .= $blockID.' .pagination.faction{color:'.$pagerColor.';}'.PHP_EOL;
		} else {
			$latestStyle .= $blockID.' .pagination.default .swiper-pagination-bullet.swiper-pagination-bullet-active{background:'.$pagerColor.';}'.PHP_EOL;
		}
	}

}

/*if($_masonry && !G5_IS_MOBILE) {
	if($layout_rt || $layout_lt) $latestScript .= '$(document).ready(function() { var textCon = $("'.$blockID.' .textCon").html();';
	if($layout_rt) $latestScript .= '$("'.$blockID.' .gall_li:nth-child(1)").before("<li class=\"gall_li hide_li\">"+ textCon + "</li>");';
	if($layout_lt) $latestScript .= '$("'.$blockID.' .gall_li:nth-child(1)").after("<li class=\"gall_li hide_li\">"+ textCon + "</li>");';
	if($layout_rt || $layout_lt) $latestScript .= '$("'.$blockID.' .textCon").html(""); });'.PHP_EOL;
}*/


$latestScript .='
$(document).ready(function() {
	$(".'.$blockName.'_popup-view").magnificPopup({
		type:"ajax", fixedContentPos:true, fixedBgPos:true, closeOnContentClick:false,  closeOnBgClick:false, gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]}, overflowY:"auto", closeBtnInside:false, preloader:false, midClick:true, removalDelay:300, mainClass:"my-mfp-zoom-in"
	});
	$(".'.$blockName.'_popup-view-txt").magnificPopup({
		type:"ajax", fixedContentPos:true, fixedBgPos:true, closeOnContentClick:false,  closeOnBgClick:false, gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]}, overflowY:"auto", closeBtnInside:false, preloader:false, midClick:true, removalDelay:300, mainClass:"my-mfp-zoom-in"
	});
	$(".'.$blockName.'_popup-view-img").magnificPopup({
		type:"ajax", fixedContentPos:true, fixedBgPos:true, closeOnContentClick:false,  closeOnBgClick:false, gallery:{enabled:true,navigateByImgClick:true,preload:[0,1]}, overflowY:"auto", closeBtnInside:false, preloader:false, midClick:true, removalDelay:300, mainClass:"my-mfp-zoom-in"
	});
});'.PHP_EOL;

if($is_category && $showCateMenu) $latestScript .= '
$(document).ready(function(){
	$("'.$blockID.' .tab-cate").on("click", function () {
		$("'.$blockID.' .tab-cate").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			url: "'.G5_BBS_URL.'/my/ajax.latest.php",
			type: "get",
			dataType: "html",
			timeout: 10000,
			data:{
				rows : "'.count($list).'",
				latestOption : "'.$latestOption.'",
				sca : $(this).attr("data-cate"),
				bo_table : "'.$bo_table.'",
				blockID : "'.$blockID.'",
				blockName : "'.$blockName.'",
				latest_width : "'.$latest_width.'",
				latest_skin_path : "'.$latest_skin_path.'",
				latest_pcskin_path : "'.$latest_pcskin_path.'"
				},
			success: function(html){
				$("'.$blockID.' .latestContainer").html(html);
				get_magnificPopup_gallery(".'.$blockName.'_popup-view");
				get_magnificPopup_gallery(".'.$blockName.'_popup-view-txt");
				get_magnificPopup_gallery(".'.$blockName.'_popup-view-img");
				my_masonry("'.$blockID.' .masonry_wrap", '.$gutter.');
			}
		});
		
	});
});'.PHP_EOL;
?>

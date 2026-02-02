<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!G5_IS_MOBILE) {
	$latestStyle .= '
		.blockSet '.$blockID.'{padding:25px 30px;background:#fff;border-radius:5px;/*border:1px solid rgba(0,0,0,0.1);*/}
		.blockSet '.$blockID.' .blockInner{gap:10px;}
		.blockSet '.$blockID.' li{padding:12px 5px}
		.blockSet '.$blockID.' li:last-child{border:0;}
	'.PHP_EOL;
} else {
	$latestStyle .= '
		.blockSet '.$blockID.'{padding:20px 15px;background:#fff;border-radius:5px;}
		.blockSet '.$blockID.' .blockInner{gap:10px;}
		.blockSet '.$blockID.' li{padding:12px 5px}
		.blockSet '.$blockID.' li:last-child{border:0;}
	'.PHP_EOL;
}


//pageMake에서 최신글 수정시 옵션
$skin_option = array ("카테고리 표기");
<?php

$pageMakeStyle .= $blockID[$i].' .blockInner{padding-top:0;padding-left:0;padding-right:0;}'.PHP_EOL;
if($list[$i]['bl_width']) {
	$pageMakeStyle .= $blockID[$i].' .blockInner .mixWrap #map{border:1px solid rgba(0,0,0,0.15);}'.PHP_EOL;
} else if(!G5_IS_MOBILE) {
	$pageMakeStyle .= $blockID[$i].' .blockInner .mixWrap .textCon{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;
}
<?php

if($list[$i]['bl_font_color']) {
	$pageMakeStyle .= $blockID[$i].' .mix-03 ul.mix-ul li.mix-li{border-color:'.$list[$i]['bl_font_color'].';}';
	$pageMakeStyle .= $blockID[$i].' .mix-btn.type02{color:'.$list[$i]['bl_font_color'].';}';
	$pageMakeStyle .= $blockID[$i].' .mix-btn.type02{border-color:'.$list[$i]['bl_font_color'].'}';
	$pageMakeStyle .= $blockID[$i].' .mix-btn.type02:after{background:'.$list[$i]['bl_font_color'].';}';
	$pageMakeStyle .= $blockID[$i].' .mix-btn.type02:before{background:'.$list[$i]['bl_font_color'].';}';
}
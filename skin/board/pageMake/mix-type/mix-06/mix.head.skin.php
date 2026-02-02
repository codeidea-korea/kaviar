<?php

$pageMakeStyle .= $blockID[$i].' .blockInner{padding:0;}'.PHP_EOL;
if($list[$i]['bl_background']) {
	$pageMakeStyle .= $blockID[$i].'{background-color:transparent;}';
	$pageMakeStyle .= $blockID[$i].' .textCon{background-color:'.$list[$i]['bl_background'].' !important;}';
}
if(G5_IS_MOBILE){
	$pageMakeStyle .= '@media screen and (min-width:721px) {';
	$pageMakeStyle .= $blockID[$i].' + .blockContainer .blockInner{padding-top:80px;}'.PHP_EOL;
	$pageMakeStyle .= '}';
	$pageMakeStyle .= '@media screen and (max-width:721px) {';
	$pageMakeStyle .= $blockID[$i].' .blockInner{padding-bottom:0;}'.PHP_EOL;
	$pageMakeStyle .= '}';
}
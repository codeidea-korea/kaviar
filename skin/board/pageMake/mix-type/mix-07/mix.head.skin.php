<?php

$pageMakeStyle .= $blockID[$i].' .blockInner{padding-top:0;padding-bottom:0;}'.PHP_EOL;

if(G5_IS_MOBILE) {
	$pageMakeStyle .= '@media screen and (min-width:721px) {';
	$pageMakeStyle .= $blockID[$i].' + .blockContainer .blockInner{padding-top:200px;}'.PHP_EOL;
	$pageMakeStyle .= '}';
	$pageMakeStyle .= '@media screen and (max-width:721px) {';
	$pageMakeStyle .= $blockID[$i].' + .blockContainer .blockInner{padding-top:100px;}'.PHP_EOL;
	$pageMakeStyle .= '}';
}


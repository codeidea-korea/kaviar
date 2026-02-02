<?php 
function get_url( $url ) {
	$url .= "?ver=".date("Ymdhis",filemtime($url)); 
    return $url;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>NEWFONT</title>
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="<?=get_url('./style.css')?>">
	<link rel="stylesheet" href="<?=get_url('./css/bootstrap-select.css')?>">
	<link rel="stylesheet" href="<?=get_url('./index.css')?>">
    
    

	<link href="http://fonts.googleapis.com/earlyaccess/nanumgothic.css" rel="stylesheet" type="text/css">
	<link rel="shortcut icon" href="favorite.png">
  </head>
  <body>

<script src="js/clipboard/clipboard.min.js"></script>
<script>
var clipboard = new ClipboardJS('.all-icons span',{
	text: function(trigger) {
		return trigger.innerText;
    }
});
/*var clipboard = new ClipboardJS('.all-icons li',{
	text: function(trigger) {
		return trigger.getAttribute('.code').innerText;
    }
});*/
clipboard.on('success', function(e) { console.log(e); });
clipboard.on('error', function(e) { console.log(e); });
</script>


<section id="font_options_bar">
	<nav id="nav">
		<div class="container">
			<div class="size_select">
				<select class="selectpicker">
				<option>free</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="16">16</option>
				<option value="18">18</option>
				<option value="20">20</option>
				<option value="22">22</option>
				<option value="32">32</option>
				<option value="48">48</option>
				<option value="64">64</option>
				<option value="80">80</option>
				<option value="96">96</option>
				<option value="112">112</option>
				<option value="128">128</option>
				</select>
			</div>
		</ul>
		<span class="bg-switch pull-right">
			<input id="s1" type="checkbox" class="sw">
			<label for="s1" class="switch"><span class="bg_circle"></span></label>
		</span>
	</nav>
</section>


<div class="all-icons">

	<ul><!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
		
		<h2>방향</h2>
		<li><i class="newicon-left"></i><span class="code">e003</span></li>
		<li><i class="newicon-right"></i><span class="code">e004</span></li>
		<li><i class="newicon-down"></i><span class="code">e005</span></li>
		<li><i class="newicon-up"></i><span class="code">e006</span></li>
		<li><i class="newicon-left-large"></i><span class="code">e00f</span></li>
		<li><i class="newicon-right-large"></i><span class="code">e010</span></li>
		<li><i class="newicon-down-large"></i><span class="code">e011</span></li>
		<li><i class="newicon-up-large"></i><span class="code">e012</span></li>
		<li><i class="newicon-ios-arrow-left"></i><span class="code">e3a6</span></li>
		<li><i class="newicon-ios-arrow-right"></i><span class="code">e3a7</span></li>
		<li><i class="newicon-ios-arrow-down"></i><span class="code">e3a8</span></li>
		<li><i class="newicon-ios-arrow-up"></i><span class="code">e3a9</span></li>
		<li><i class="newicon-left-open-big"></i><span class="code">e2b1</span></li>
		<li><i class="newicon-right-open-big"></i><span class="code">e2b4</span></li>
		<br/>		
		<li><i class="newicon-left-open-mini"></i><span class="code">e2b2</span></li>
		<li><i class="newicon-right-open-mini"></i><span class="code">e2b5</span></li>
		<li><i class="newicon-angle-left"></i><span class="code">e04f</span></li>
		<li><i class="newicon-angle-right"></i><span class="code">e050</span></li>
		<li><i class="newicon-angle-up"></i><span class="code">e052</span></li>
		<li><i class="newicon-angle-down"></i><span class="code">e051</span></li>
		<li><i class="newicon-angle-double-left"></i><span class="code">e053</span></li>
		<li><i class="newicon-angle-double-right"></i><span class="code">e054</span></li>
		<li><i class="newicon-angle-double-down"></i><span class="code">e055</span></li>
		<li><i class="newicon-angle-double-up"></i><span class="code">e056</span></li>
		<li><i class="newicon-down-open"></i><span class="code">e4b8</span></li>
		<li><i class="newicon-left-open"></i><span class="code">e2b0</span></li>
		<li><i class="newicon-right-open"></i><span class="code">e2b3</span></li>	
		<br/>
		<li><i class="newicon-ios-arrow-back"></i><span class="code">e3a4</span></li>
		<li><i class="newicon-ios-arrow-forward"></i><span class="code">e3a5</span></li>
		<li><i class="newicon-left2"></i><span class="code">e022</span></li>
		<li><i class="newicon-right2"></i><span class="code">e023</span></li>
		<li><i class="newicon-down2"></i><span class="code">e024</span></li>
		<li><i class="newicon-up2"></i><span class="code">e025</span></li>		
		<li><i class="newicon-chevron-left"></i><span class="code">e02a</span></li>
		<li><i class="newicon-chevron-right"></i><span class="code">e02b</span></li>
		<li><i class="newicon-chevron-up"></i><span class="code">e02c</span></li>
		<li><i class="newicon-chevron-down"></i><span class="code">e029</span></li>
		<br/>		
		<li><i class="newicon-caret-left"></i><span class="code">e043</span></li>
		<li><i class="newicon-caret-right"></i><span class="code">e04c</span></li>
		<li><i class="newicon-caret-down"></i><span class="code">e04d</span></li>
		<li><i class="newicon-caret-up"></i><span class="code">e04e</span></li>
		<li><i class="newicon-left-filled"></i><span class="code">e016</span></li>
		<li><i class="newicon-right-filled"></i><span class="code">e017</span></li>
		<li><i class="newicon-down-filled"></i><span class="code">e018</span></li>
		<li><i class="newicon-up-filled"></i><span class="code">e019</span></li>		
		<li><i class="newicon-sort-asc"></i><span class="code">e388</span></li>
		<li><i class="newicon-sort-desc"></i><span class="code">e389</span></li>
		<br/>
		<li><i class="newicon-arrow-sans-down"></i><span class="code">e461</span></li>
		<li><i class="newicon-arrow-sans-left"></i><span class="code">e462</span></li>
		<li><i class="newicon-arrow-sans-lowerleft"></i><span class="code">e463</span></li>
		<li><i class="newicon-arrow-sans-lowerright"></i><span class="code">e464</span></li>
		<li><i class="newicon-arrow-sans-right"></i><span class="code">e465</span></li>
		<li><i class="newicon-arrow-sans-up"></i><span class="code">e466</span></li>
		<li><i class="newicon-arrow-sans-upperleft"></i><span class="code">e467</span></li>
		<li><i class="newicon-arrow-sans-upperright"></i><span class="code">e468</span></li>
		<br/>
		<li><i class="newicon-arrow-left"></i><span class="code">e00a</span></li>
		<li><i class="newicon-arrow-right"></i><span class="code">e00b</span></li>
		<li><i class="newicon-arrow-down"></i><span class="code">e00c</span></li>
		<li><i class="newicon-arrow-up"></i><span class="code">e00d</span></li>
		<li><i class="newicon-line-left"></i><span class="code">e416</span></li>
		<li><i class="newicon-line-right"></i><span class="code">e417</span></li>
		<li><i class="newicon-line-top"></i><span class="code">e418</span></li>
		<li><i class="newicon-line-bottom"></i><span class="code">e419</span></li>
		<li><i class="newicon-line-bottom-left"></i><span class="code">e41a</span></li>
		<li><i class="newicon-line-bottom-right"></i><span class="code">e41b</span></li>
		<li><i class="newicon-line-top-left"></i><span class="code">e41c</span></li>
		<li><i class="newicon-line-top-right"></i><span class="code">e41d</span></li>
		<br/>
		<li><i class="newicon-arrow-left-1"></i><span class="code">e2b6</span></li>
		<li><i class="newicon-arrow-right-1"></i><span class="code">e2b7</span></li>
		<li><i class="newicon-arrow-down-1"></i><span class="code">e2b8</span></li>
		<li><i class="newicon-arrow-up-1"></i><span class="code">e2b9</span></li>
		<li><i class="newicon-arrow-left-c"></i><span class="code">e39a</span></li>
		<li><i class="newicon-arrow-right-c"></i><span class="code">e39b</span></li>
		<li><i class="newicon-arrow-up-c"></i><span class="code">e398</span></li>
		<li><i class="newicon-arrow-down-c"></i><span class="code">e399</span></li>
		<li><i class="newicon-arrow-up-3"></i><span class="code">e3f3</span></li>
		<li><i class="newicon-arrow-down-3"></i><span class="code">e3f4</span></li>
		<li><i class="newicon-arrow-left-3"></i><span class="code">e3f5</span></li>
		<li><i class="newicon-arrow-right-3"></i><span class="code">e3f6</span></li>
		<br/>
		<li><i class="newicon-arrow-down-4"></i><span class="code">e496</span></li>
		<li><i class="newicon-arrow-left-4"></i><span class="code">e497</span></li>
		<li><i class="newicon-arrow-right-4"></i><span class="code">e498</span></li>
		<li><i class="newicon-arrow-up-4"></i><span class="code">e499</span></li>

		<h2>리플</h2>
		<li><i class="newicon-reply-filled"></i><span class="code">e0f5</span></li>
		<li><i class="newicon-back-filled"></i><span class="code">e0f6</span></li>
		<li><i class="newicon-reply-1"></i><span class="code">e253</span></li>
		<li><i class="newicon-reply-2"></i><span class="code">e333</span></li>
		<li><i class="newicon-share"></i><span class="code">e334</span></li>
		<li><i class="newicon-reply-3"></i><span class="code">e3b9</span></li>
		<li><i class="newicon-reply-all"></i><span class="code">e432</span></li>
		<li><i class="newicon-share-4"></i><span class="code">e433</span></li>
		<li><i class="newicon-level-down"></i><span class="code">e4be</span></li>
		<li><i class="newicon-curved-arrow"></i><span class="code">e4ca</span></li>

		<h2>홈</h2>
		<li><i class="newicon-home-2"></i><span class="code">e368</span></li>
		<li><i class="newicon-home"></i><span class="code">e057</span></li>
		<li><i class="newicon-home-filled"></i><span class="code">e058</span></li>
		<li><i class="newicon-home-bold"></i><span class="code">e059</span></li>
		<li><i class="newicon-home2-filled"></i><span class="code">e05a</span></li>
		<li><i class="newicon-home3"></i><span class="code">e05c</span></li>
		<li><i class="newicon-building-o"></i><span class="code">e05d</span></li>
		<li><i class="newicon-building"></i><span class="code">e05f</span></li>
		<li><i class="newicon-building-bold"></i><span class="code">e061</span></li>
		<li><i class="newicon-hospital-o"></i><span class="code">e067</span></li>
		<li><i class="newicon-home-4"></i><span class="code">e154</span></li>
		<li><i class="newicon-culture-filled"></i><span class="code">e22c</span></li>
		<li><i class="newicon-school"></i><span class="code">e454</span></li>
		<li><i class="newicon-home-1-1"></i><span class="code">e489</span></li>
		<li><i class="newicon-home-1"></i><span class="code">e291</span></li>
		<li><i class="newicon-shop"></i><span class="code">e1c7</span></li>

		<h2>목록</h2>
		<li><i class="newicon-list"></i><span class="code">e000</span></li>
		<li><i class="newicon-list2"></i><span class="code">e001</span></li>
		<li><i class="newicon-list3"></i><span class="code">e002</span></li>
		<li><i class="newicon-list-large"></i><span class="code">e00e</span></li>
		<li><i class="newicon-navicon-1"></i><span class="code">e43b</span></li>
		<li><i class="newicon-navicon-round"></i><span class="code">e43c</span></li>
		<li><i class="newicon-equals"></i><span class="code">e449</span></li>		
		<li><i class="newicon-menu"></i><span class="code">e4c1</span></li>
		<li><i class="newicon-reorder"></i><span class="code">e4e0</span></li>
		<li><i class="newicon-bars"></i><span class="code">e082</span></li>
		<li><i class="newicon-navicon"></i><span class="code">e151</span></li>
		<br/>
		<li><i class="newicon-list-ul"></i><span class="code">e44f</span></li>
		<li><i class="newicon-list-alt"></i><span class="code">e450</span></li>		
		<li><i class="newicon-tasks"></i><span class="code">e456</span></li>
		<li><i class="newicon-list-ol"></i><span class="code">e459</span></li>
		<li><i class="newicon-list-bullet"></i><span class="code">e4a2</span></li>
		<li><i class="newicon-list-number"></i><span class="code">e4a3</span></li>
		<li><i class="newicon-list-thumbnails"></i><span class="code">e4a4</span></li>
		<li><i class="newicon-list-1"></i><span class="code">e4bd</span></li>
		<li><i class="newicon-list-2"></i><span class="code">e4da</span></li>
		<li><i class="newicon-list-c"></i><span class="code">e198</span></li>		
		<br/>
		<li><i class="newicon-grid-1"></i><span class="code">e441</span></li>		
		<li><i class="newicon-thumbnails"></i><span class="code">e4ae</span></li>
		<li><i class="newicon-layout"></i><span class="code">e4bc</span></li>		
		<li><i class="newicon-keypad"></i><span class="code">e193</span></li>
		<li><i class="newicon-table"></i><span class="code">e4b1</span></li>
		<li><i class="newicon-grid"></i><span class="code">e308</span></li>
		<li><i class="newicon-th"></i><span class="code">e45e</span></li>
		<li><i class="newicon-th-large"></i><span class="code">e45f</span></li>
		<br/>		
		<li><i class="newicon-dot-2"></i><span class="code">e4b3</span></li>
		<li><i class="newicon-dot-3"></i><span class="code">e4b4</span></li>
		<li><i class="newicon-min-filled"></i><span class="code">e192</span></li>
		<li><i class="newicon-min"></i><span class="code">e191</span></li>
		<li><i class="newicon-more"></i><span class="code">e478</span></li>
		<li><i class="newicon-android-more-horizontal"></i><span class="code">e027</span></li>
		<li><i class="newicon-vertical"></i><span class="code">e1b1</span></li>
		<li><i class="newicon-braille"></i><span class="code">e49f</span></li>

		<h2>정렬</h2>
		<li><i class="newicon-align-center"></i><span class="code">e3cb</span></li>
		<li><i class="newicon-align-justify"></i><span class="code">e3cc</span></li>
		<li><i class="newicon-align-left-1"></i><span class="code">e3cd</span></li>
		<li><i class="newicon-align-right-1"></i><span class="code">e3ce</span></li>
		<li><i class="newicon-indent-decrease"></i><span class="code">e2cd</span></li>
		<li><i class="newicon-indent-increase"></i><span class="code">e2ce</span></li>
		<li><i class="newicon-line-spacing"></i><span class="code">e2d0</span></li>
		<li><i class="newicon-text-align-center"></i><span class="code">e2df</span></li>
		<li><i class="newicon-text-align-justify"></i><span class="code">e2e0</span></li>
		<li><i class="newicon-text-align-left"></i><span class="code">e2e1</span></li>
		<li><i class="newicon-text-align-right"></i><span class="code">e2e2</span></li>
		<li><i class="newicon-align-left"></i><span class="code">e303</span></li>
		<li><i class="newicon-align-middle"></i><span class="code">e304</span></li>
		<li><i class="newicon-align-right"></i><span class="code">e305</span></li>

		
		
		<h2>좋아요</h2>
		<li><i class="newicon-like-yes-vote"></i><span class="code">e48a</span></li>
		<li><i class="newicon-thumbs-down"></i><span class="code">e14d</span></li>
		<li><i class="newicon-thumbs-up"></i><span class="code">e14c</span></li>
		<li><i class="newicon-like-filled"></i><span class="code">e152</span></li>
		<li><i class="newicon-dislike"></i><span class="code">e153</span></li>
		<li><i class="newicon-thumbs-o-up"></i><span class="code">e1af</span></li>
		<li><i class="newicon-thumbs-o-down"></i><span class="code">e1b0</span></li>
		<li><i class="newicon-nc-like"></i><span class="code">e2f4</span></li>
		<li><i class="newicon-nc-dislike"></i><span class="code">e2ed</span></li>

		<h2>손</h2>
		<li><i class="newicon-hand-o-left"></i><span class="code">e457</span></li>
		<li><i class="newicon-hand-o-right"></i><span class="code">e458</span></li>
		<li><i class="newicon-hand-block"></i><span class="code">e473</span></li>	
		<li><i class="newicon-hand-hold"></i><span class="code">e488</span></li>	
		<li><i class="newicon-hands-helping"></i><span class="code">e01b</span></li>
		<li><i class="newicon-hand"></i><span class="code">e2c9</span></li>		
		<li><i class="newicon-pointer-down"></i><span class="code">e2d6</span></li>
		<li><i class="newicon-pointer-left"></i><span class="code">e2d7</span></li>
		<li><i class="newicon-pointer-right"></i><span class="code">e2d8</span></li>
		<li><i class="newicon-pointer-up"></i><span class="code">e2d9</span></li>	
		<li><i class="newicon-hand-stop"></i><span class="code">e357</span></li>
		<li><i class="newicon-hand-paper-o"></i><span class="code">e381</span></li>
		<li><i class="newicon-hand-rock-o"></i><span class="code">e382</span></li>	
		<li><i class="newicon-hand-clapping"></i><span class="code">e405</span></li>
		
		<h2>기호</h2>
		<li><i class="newicon-cross"></i><span class="code">e007</span></li>
		<li><i class="newicon-android-close"></i><span class="code">e337</span></li>
		<li><i class="newicon-remove-delete"></i><span class="code">e3c5</span></li>
		<li><i class="newicon-close"></i><span class="code">e472</span></li>
		<li><i class="newicon-check"></i><span class="code">e189</span></li>
		<li><i class="newicon-checkmark-round"></i><span class="code">e2a1</span></li>
		<li><i class="newicon-check-mark"></i><span class="code">e306</span></li>		
		<li><i class="newicon-android-done"></i><span class="code">e335</span></li>		
		<li><i class="newicon-ios-checkmark-empty"></i><span class="code">e33b</span></li>
		<li><i class="newicon-android-add"></i><span class="code">e336</span></li>
		<li><i class="newicon-plus"></i><span class="code">e008</span></li>
		<li><i class="newicon-plus-large"></i><span class="code">e014</span></li>
		<li><i class="newicon-plus-1"></i><span class="code">e452</span></li>
		<li><i class="newicon-minus"></i><span class="code">e009</span></li>	
		<li><i class="newicon-minus-large"></i><span class="code">e015</span></li>		
		<li><i class="newicon-minus-bold"></i><span class="code">e047</span></li>
		<li><i class="newicon-divide"></i><span class="code">e3b0</span></li>			
		<li><i class="newicon-information"></i><span class="code">e075</span></li>
		<li><i class="newicon-exclamation"></i><span class="code">e076</span></li>
		<li><i class="newicon-info"></i><span class="code">e07a</span></li>
		<li><i class="newicon-hashtag"></i><span class="code">e4d8</span></li>
		<li><i class="newicon-infinity"></i><span class="code">e3b4</span></li>	
		<li><i class="newicon-asterrisk"></i><span class="code">e18d</span></li>
		<li><i class="newicon-code"></i><span class="code">e190</span></li>
		<li><i class="newicon-at"></i><span class="code">e16c</span></li>
		<li><i class="newicon-air"></i><span class="code">e3e9</span></li>
		<li><i class="newicon-code-1"></i><span class="code">e3a2</span></li>
		<li><i class="newicon-mention"></i><span class="code">e342</span></li>
		<li><i class="newicon-bluetooth-1"></i><span class="code">e49e</span></li>
		<li><i class="newicon-power-1"></i><span class="code">e3d1</span></li>
		<li><i class="newicon-power-off"></i><span class="code">e01f</span></li>
		<li><i class="newicon-power"></i><span class="code">e0a2</span></li>
		<br/>
		<li><i class="newicon-quote"></i><span class="code">e343</span></li>
		<li><i class="newicon-left-quote"></i><span class="code">e350</span></li>
		<li><i class="newicon-right-quote"></i><span class="code">e351</span></li>
		<li><i class="newicon-left-quote-alt"></i><span class="code">e4cc</span></li>
		<li><i class="newicon-right-quote-alt"></i><span class="code">e4d4</span></li>
		<li><i class="newicon-quote-1"></i><span class="code">e3ed</span></li>
		<li><i class="newicon-quotes-1"></i><span class="code">e483</span></li>		
		<br/>
		<li><i class="newicon-sort"></i><span class="code">e2a0</span></li>
		<li><i class="newicon-play-1-1"></i><span class="code">e490</span></li>
		<li><i class="newicon-pause-1-1"></i><span class="code">e48f</span></li>
		<li><i class="newicon-next-1"></i><span class="code">e48d</span></li>
		<li><i class="newicon-previous-1"></i><span class="code">e48e</span></li>
		<li><i class="newicon-fast-backward"></i><span class="code">e44b</span></li>
		<li><i class="newicon-fast-forward"></i><span class="code">e44c</span></li>
		<li><i class="newicon-play-2"></i><span class="code">e2a9</span></li>
		<li><i class="newicon-play"></i><span class="code">e2aa</span></li>
		<li><i class="newicon-pause-2"></i><span class="code">e2ab</span></li>
		<li><i class="newicon-pause"></i><span class="code">e2ac</span></li>
		<li><i class="newicon-pause-outline"></i><span class="code">e2ad</span></li>		
		<li><i class="newicon-pause-1"></i><span class="code">e2af</span></li>
		<li><i class="newicon-forward-2"></i><span class="code">e2f9</span></li>
		<br/>
		<li><i class="newicon-arrows-h"></i><span class="code">e078</span></li>
		<li><i class="newicon-arrows-v"></i><span class="code">e079</span></li>		
		<li><i class="newicon-resize-down"></i><span class="code">e135</span></li>
		<li><i class="newicon-resize-expand"></i><span class="code">e136</span></li>
		<li><i class="newicon-arrows"></i><span class="code">e05e</span></li>
		<li><i class="newicon-arrows-alt"></i><span class="code">e077</span></li>		
		<li><i class="newicon-exchange-alt"></i><span class="code">e44a</span></li>
		<li><i class="newicon-arrow-swap"></i><span class="code">e28e</span></li>			
		<li><i class="newicon-arrows-compress"></i><span class="code">e49a</span></li>
		<li><i class="newicon-arrows-expand"></i><span class="code">e49b</span></li>
		<li><i class="newicon-arrows-in"></i><span class="code">e49c</span></li>
		<li><i class="newicon-arrows-out"></i><span class="code">e49d</span></li>		
		<li><i class="newicon-zoom-out"></i><span class="code">e132</span></li>
		<li><i class="newicon-zoom-out2"></i><span class="code">e133</span></li>
		<li><i class="newicon-zoom-out3"></i><span class="code">e134</span></li>	
		<li><i class="newicon-maximize"></i><span class="code">e30a</span></li>
		<li><i class="newicon-expand"></i><span class="code">e13a</span></li>
		<li><i class="newicon-refresh-1"></i><span class="code">e0f0</span></li>
		<li><i class="newicon-android-refresh"></i><span class="code">e394</span></li>
		<li><i class="newicon-redo"></i><span class="code">e2dc</span></li>
		<li><i class="newicon-refresh"></i><span class="code">e137</span></li>
		<li><i class="newicon-refresh2"></i><span class="code">e138</span></li>			
		<li><i class="newicon-frame-contract"></i><span class="code">e2c7</span></li>
		<li><i class="newicon-frame-expand"></i><span class="code">e2c8</span></li>
		<li><i class="newicon-selection"></i><span class="code">e30c</span></li>
		<li><i class="newicon-qr-scanner"></i><span class="code">e33c</span></li>	
		<li><i class="newicon-square-vector-1"></i><span class="code">e492</span></li>
		<li><i class="newicon-square-vector-2"></i><span class="code">e493</span></li>
		<li><i class="newicon-send-to-back"></i><span class="code">e494</span></li>
		<li><i class="newicon-send-to-front"></i><span class="code">e495</span></li>		
		<li><i class="newicon-regulator"></i><span class="code">e236</span></li>
		
		<h2>도형</h2>
		<li><i class="newicon-hart"></i><span class="code">e17b</span></li>
		<li><i class="newicon-hart-filled"></i><span class="code">e17c</span></li>		
		<li><i class="newicon-heart"></i><span class="code">e299</span></li>
		<li><i class="newicon-heart-o"></i><span class="code">e29a</span></li>
		<li><i class="newicon-heart-2"></i><span class="code">e34b</span></li>
		<li><i class="newicon-heart-empty"></i><span class="code">e34c</span></li>
		<li><i class="newicon-heart-3"></i><span class="code">e3c1</span></li>
		<li><i class="newicon-heart-small"></i><span class="code">e3c2</span></li>
		<li><i class="newicon-heart-small-outline"></i><span class="code">e3c3</span></li>
		<li><i class="newicon-heart-4"></i><span class="code">e47f</span></li>
		<li><i class="newicon-heart-fill"></i><span class="code">e4cd</span></li>
		<li><i class="newicon-heart-stroke"></i><span class="code">e4ce</span></li>
		<li><i class="newicon-heart-empty-1"></i><span class="code">e480</span></li>
		<li><i class="newicon-heart-5"></i><span class="code">e4d7</span></li>
		<li><i class="newicon-lovedsgn"></i><span class="code">e4eb</span></li>
		<li><i class="newicon-nc-test-outline-32px-heart"></i><span class="code">e360</span></li>
		<li><i class="newicon-star2-filled"></i><span class="code">e180</span></li>				
		<li><i class="newicon-star-2"></i><span class="code">e3f9</span></li>
		<li><i class="newicon-star"></i><span class="code">e374</span></li>
		<li><i class="newicon-label-important-24px"></i><span class="code">e036</span></li>
		<li><i class="newicon-db-shape"></i><span class="code">e296</span></li>
		<li><i class="newicon-sheriff-badge"></i><span class="code">e3d2</span></li>		
		<li><i class="newicon-certificate"></i><span class="code">e31e</span></li>		
		<li><i class="newicon-religious-jewish"></i><span class="code">e355</span></li>
		<li><i class="newicon-gear-setting"></i><span class="code">e3c0</span></li>
		<li><i class="newicon-setting-filled"></i><span class="code">e0a5</span></li>
		<li><i class="newicon-gear-setting-2"></i><span class="code">e0a6</span></li>
		<li><i class="newicon-widget"></i><span class="code">e0a7</span></li>
		<li><i class="newicon-settings"></i><span class="code">e353</span></li>
		<li><i class="newicon-mouse-pointer"></i><span class="code">e29f</span></li>
		<li><i class="newicon-toggle-off-1"></i><span class="code">e436</span></li>
		<li><i class="newicon-toggle-on-1"></i><span class="code">e437</span></li>	
		<li><i class="newicon-toggle-off"></i><span class="code">e27b</span></li>
		<li><i class="newicon-toggle-on"></i><span class="code">e27c</span></li>
		<li><i class="newicon-box"></i><span class="code">e233</span></li>
		<li><i class="newicon-object"></i><span class="code">e234</span></li>		

		<h2>캘린더</h2>
		<li><i class="newicon-calendar-full"></i><span class="code">e2be</span></li>
		<li><i class="newicon-calendar-3"></i><span class="code">e31f</span></li>
		<li><i class="newicon-calendar-o"></i><span class="code">e320</span></li>
		<li><i class="newicon-date"></i><span class="code">e3c8</span></li>
		<li><i class="newicon-calendar-4"></i><span class="code">e43e</span></li>
		<li><i class="newicon-calendar-5"></i><span class="code">e4a0</span></li>
		<li><i class="newicon-calendar-6"></i><span class="code">e4e7</span></li>
		<li><i class="newicon-calendar-2"></i><span class="code">e148</span></li>		
		<li><i class="newicon-calendar-check-o"></i><span class="code">e226</span></li>
		<li><i class="newicon-calendar-today-24px"></i><span class="code">e032</span></li>
		<li><i class="newicon-date-range-24px"></i><span class="code">e034</span></li>
		<li><i class="newicon-today-24px"></i><span class="code">e044</span></li>


		<h2>전화</h2>
		<li><i class="newicon-phone"></i><span class="code">e16f</span></li>
		<li><i class="newicon-phone-filled"></i><span class="code">e170</span></li>
		<li><i class="newicon-phone-ring"></i><span class="code">e171</span></li>
		<li><i class="newicon-phone24-filled"></i><span class="code">e177</span></li>
		<li><i class="newicon-tel"></i><span class="code">e179</span></li>
		<li><i class="newicon-whatsapp"></i><span class="code">e28d</span></li>
		<li><i class="newicon-phone-1"></i><span class="code">e3b8</span></li>
		<li><i class="newicon-phone-2"></i><span class="code">e438</span></li>
		<li><i class="newicon-phone-1-1"></i><span class="code">e442</span></li>
		<li><i class="newicon-phone-classic-on"></i><span class="code">e46a</span></li>
		<li><i class="newicon-phone-3"></i><span class="code">e481</span></li>
		<li><i class="newicon-phone-4"></i><span class="code">e4c4</span></li>

		<h2>기기 & 모드</h2>
		<li><i class="newicon-phone1"></i><span class="code">e157</span></li>
		<li><i class="newicon-phone2"></i><span class="code">e155</span></li>
		<li><i class="newicon-phone3"></i><span class="code">e156</span></li>		
		<li><i class="newicon-mobile-mode"></i><span class="code">e15c</span></li>
		<li><i class="newicon-smartphone"></i><span class="code">e444</span></li>
		<li><i class="newicon-mobile"></i><span class="code">e384</span></li>
		<li><i class="newicon-monitor"></i><span class="code">e158</span></li>
		<li><i class="newicon-reaction-type"></i><span class="code">e15a</span></li>
		<li><i class="newicon-desktop"></i><span class="code">e15b</span></li>
		<li><i class="newicon-line-monitor"></i><span class="code">e408</span></li>
		<li><i class="newicon-nc-laptop"></i><span class="code">e2f3</span></li>
		<li><i class="newicon-nc-pc"></i><span class="code">e2f6</span></li>
		<li><i class="newicon-mobile-screen-share-24px"></i><span class="code">e038</span></li>
		<li><i class="newicon-screen-share-24px"></i><span class="code">e03b</span></li>
		<li><i class="newicon-mouse"></i><span class="code">e15d</span></li>
		<li><i class="newicon-mouse2"></i><span class="code">e15e</span></li>
		<li><i class="newicon-keyboard"></i><span class="code">e15f</span></li>	
		<li><i class="newicon-remote-control"></i><span class="code">e1aa</span></li>
		<li><i class="newicon-mouse-1"></i><span class="code">e1b7</span></li>	
		<li><i class="newicon-keyboard-1"></i><span class="code">e312</span></li>	
		<li><i class="newicon-keyboard-o"></i><span class="code">e327</span></li>
		<li><i class="newicon-mouse-2"></i><span class="code">e372</span></li>
		<li><i class="newicon-calculator-2"></i><span class="code">e3be</span></li>	
		<li><i class="newicon-ipod"></i><span class="code">e48b</span></li>
		<li><i class="newicon-mouse-3"></i><span class="code">e4c2</span></li>
		<li><i class="newicon-keyboard-2"></i><span class="code">e01c</span></li>
		<li><i class="newicon-nc-mouse"></i><span class="code">e2f8</span></li>


		<h2>검색</h2>		
		<li><i class="newicon-search"></i><span class="code">e062</span></li>
		<li><i class="newicon-search-large"></i><span class="code">e063</span></li>
		<li><i class="newicon-search-bold"></i><span class="code">e066</span></li>
		<li><i class="newicon-search-bold2"></i><span class="code">e06a</span></li>
		<li><i class="newicon-search-1"></i><span class="code">e344</span></li>
		<li><i class="newicon-magnifying-glass"></i><span class="code">e36e</span></li>
		<li><i class="newicon-magnifying-glass-2"></i><span class="code">e36f</span></li>		
		<li><i class="newicon-magnifying-glass-1"></i><span class="code">e4a5</span></li>
		<li><i class="newicon-search-2"></i><span class="code">e45c</span></li>
		<li><i class="newicon-magnifying"></i><span class="code">e4db</span></li>
		<li><i class="newicon-magnifier"></i><span class="code">e377</span></li>

		<h2>갤러리</h2>	
		<li><i class="newicon-image-alt"></i><span class="code">e0f7</span></li>
		<li><i class="newicon-photo"></i><span class="code">e0f8</span></li>
		<li><i class="newicon-img"></i><span class="code">e0f9</span></li>
		<li><i class="newicon-photos"></i><span class="code">e0fa</span></li>
		<li><i class="newicon-picture"></i><span class="code">e0ff</span></li>
		<li><i class="newicon-pictures"></i><span class="code">e100</span></li>
		<li><i class="newicon-frame-picture"></i><span class="code">e101</span></li>
		<li><i class="newicon-nc-test-outline-32px-image"></i><span class="code">e4ef</span></li>
		<li><i class="newicon-photo-picture"></i><span class="code">e47b</span></li>
		<li><i class="newicon-mountains"></i><span class="code">e4a7</span></li>
		<li><i class="newicon-gallery"></i><span class="code">e0fb</span></li>
		<li><i class="newicon-gallery2"></i><span class="code">e0fc</span></li>
		<li><i class="newicon-gallery3"></i><span class="code">e0fd</span></li>
		<li><i class="newicon-gallery4"></i><span class="code">e0fe</span></li>
		<li><i class="newicon-layers"></i><span class="code">e2cf</span></li>
		<li><i class="newicon-minimize"></i><span class="code">e30b</span></li>
		<li><i class="newicon-layer-group"></i><span class="code">e01e</span></li>
		<li><i class="newicon-art-track-24px"></i><span class="code">e031</span></li>


		<h2>카메라</h2>
		<li><i class="newicon-camera"></i><span class="code">e091</span></li>
		<li><i class="newicon-camera2"></i><span class="code">e092</span></li>
		<li><i class="newicon-camera3"></i><span class="code">e093</span></li>
		<li><i class="newicon-camera4"></i><span class="code">e094</span></li>
		<li><i class="newicon-camera5"></i><span class="code">e095</span></li>
		<li><i class="newicon-camera-1"></i><span class="code">e09d</span></li>
		<li><i class="newicon-camera-filled"></i><span class="code">e096</span></li>
		<li><i class="newicon-camera2-filled"></i><span class="code">e097</span></li>
		<li><i class="newicon-camera3-filled"></i><span class="code">e098</span></li>
		<li><i class="newicon-camera-retro"></i><span class="code">e09c</span></li>
		<li><i class="newicon-camera-3"></i><span class="code">e3f7</span></li>
		<li><i class="newicon-polaroid"></i><span class="code">e206</span></li>
		<li><i class="newicon-nc-test-outline-32px-reflex"></i><span class="code">e364</span></li>
		<li><i class="newicon-camera-2"></i><span class="code">e36c</span></li>
		
		<h2>비디오</h2>
		<li><i class="newicon-movie"></i><span class="code">e09f</span></li>
		<li><i class="newicon-video-camera"></i><span class="code">e0a0</span></li>
		<li><i class="newicon-film"></i><span class="code">e0a8</span></li>
		<li><i class="newicon-nc-player"></i><span class="code">e2f7</span></li>
		
		

		<h2>말풍선</h2>
		<li><i class="newicon-comment2-filled"></i><span class="code">e144</span></li>
		<li><i class="newicon-comment3-filled"></i><span class="code">e145</span></li>
		<li><i class="newicon-comment-filled"></i><span class="code">e146</span></li>		
		<li><i class="newicon-talk-chat"></i><span class="code">e149</span></li>
		<li><i class="newicon-comment-alt2-fill"></i><span class="code">e14a</span></li>
		<li><i class="newicon-comment-fill"></i><span class="code">e14b</span></li>
		<li><i class="newicon-android-hangout"></i><span class="code">e338</span></li>
		<li><i class="newicon-chatbubble"></i><span class="code">e39d</span></li>
		<li><i class="newicon-message"></i><span class="code">e4dc</span></li>
		<li><i class="newicon-comment-alt"></i><span class="code">e01a</span></li>
		<li><i class="newicon-nc-test-outline-32px-chat"></i><span class="code">e35c</span></li>

		<h2>사용자</h2>
		<li><i class="newicon-user-filled"></i><span class="code">e0ab</span></li>
		<li><i class="newicon-user-circle"></i><span class="code">e0ba</span></li>
		<li><i class="newicon-male"></i><span class="code">e0b6</span></li>
		<li><i class="newicon-adult"></i><span class="code">e47c</span></li>
		<li><i class="newicon-results-demographics"></i><span class="code">e4aa</span></li>
		<li><i class="newicon-user-1"></i><span class="code">e4e2</span></li>
		<li><i class="newicon-user-male"></i><span class="code">e4e3</span></li>
		<li><i class="newicon-user-2"></i><span class="code">e4e9</span></li>
		<li><i class="newicon-slideshare"></i><span class="code">e4ea</span></li>
		<li><i class="newicon-nc-evil"></i><span class="code">e2ee</span></li>


		<h2>SNS</h2>
		<li><i class="newicon-kakao-story"></i><span class="code">e3ad</span></li>
		<li><i class="newicon-naver-blog"></i><span class="code">e3ae</span></li>
		<li><i class="newicon-naver-n"></i><span class="code">e3b5</span></li>
		<li><i class="newicon-naver"></i><span class="code">e3b6</span></li>
		<li><i class="newicon-twitter"></i><span class="code">e1b4</span></li>
		<li><i class="newicon-facebook"></i><span class="code">e1b5</span></li>
		<li><i class="newicon-kakao"></i><span class="code">e1b6</span></li>
		<li><i class="newicon-youtube-play"></i><span class="code">e1b8</span></li>
		<li><i class="newicon-youtube-square"></i><span class="code">e1b9</span></li>
		<li><i class="newicon-rss-square"></i><span class="code">e1ba</span></li>
		<li><i class="newicon-vimeo-square"></i><span class="code">e1bb</span></li>
		<li><i class="newicon-pinterest-p"></i><span class="code">e1bc</span></li>
		<li><i class="newicon-android"></i><span class="code">e1bd</span></li>
		<li><i class="newicon-apple"></i><span class="code">e1be</span></li>
		<li><i class="newicon-facebook-square"></i><span class="code">e1bf</span></li>
		<li><i class="newicon-vimeo-circled"></i><span class="code">e1c0</span></li>
		<li><i class="newicon-vkontakte"></i><span class="code">e1c1</span></li>
		<li><i class="newicon-twitter-1"></i><span class="code">e1c2</span></li>
		<li><i class="newicon-twitter-circled"></i><span class="code">e1c3</span></li>
		<li><i class="newicon-facebook-squared"></i><span class="code">e1c4</span></li>
		<li><i class="newicon-blogger"></i><span class="code">e1c5</span></li>
		<li><i class="newicon-instagram"></i><span class="code">e326</span></li>
		<li><i class="newicon-social-instagram-outline"></i><span class="code">e33f</span></li>
		<li><i class="newicon-instagrem"></i><span class="code">e4bb</span></li>
		<li><i class="newicon-google-plus"></i><span class="code">e325</span></li>
		<li><i class="newicon-internet-explorer"></i><span class="code">e1d6</span></li>
		<li><i class="newicon-opera"></i><span class="code">e1d7</span></li>
		<li><i class="newicon-share-2"></i><span class="code">e34e</span></li>
		<li><i class="newicon-share-3"></i><span class="code">e2ef</span></li>


		<h2>게시판 버튼</h2>
		<li><i class="newicon-pen"></i><span class="code">e0ce</span></li>
		<li><i class="newicon-pencil"></i><span class="code">e0d0</span></li>
		<li><i class="newicon-pen3"></i><span class="code">e0d1</span></li>
		<li><i class="newicon-pen4"></i><span class="code">e0d2</span></li>
		<li><i class="newicon-pen-3"></i><span class="code">e0d3</span></li>
		<li><i class="newicon-pencil-1"></i><span class="code">e0d5</span></li>
		<li><i class="newicon-pencil-2"></i><span class="code">e0d6</span></li>
		<li><i class="newicon-pen-1"></i><span class="code">e0d7</span></li>
		<li><i class="newicon-pen-alt-fill"></i><span class="code">e4d2</span></li>
		<li><i class="newicon-pen-alt-stroke"></i><span class="code">e4d3</span></li>
		<li><i class="newicon-pen-5"></i><span class="code">e4e5</span></li>
		<li><i class="newicon-pencil-3"></i><span class="code">e2d5</span></li>
		<li><i class="newicon-nc-sign"></i><span class="code">e2fd</span></li>
		<li><i class="newicon-highlight"></i><span class="code">e30f</span></li>
		<br/>
		<li><i class="newicon-crop"></i><span class="code">e0d8</span></li>
		<li><i class="newicon-crop-filled"></i><span class="code">e0d9</span></li>
		<li><i class="newicon-crop2"></i><span class="code">e0da</span></li>
		<li><i class="newicon-co-edit"></i><span class="code">e0dc</span></li>		
		<li><i class="newicon-trash"></i><span class="code">e0e1</span></li>
		<li><i class="newicon-trash2"></i><span class="code">e0e3</span></li>
		<li><i class="newicon-trash3"></i><span class="code">e0e4</span></li>
		<li><i class="newicon-eraser"></i><span class="code">e3b2</span></li>
		<li><i class="newicon-delete-forever-24px"></i><span class="code">e035</span></li>
		<li><i class="newicon-trash-1"></i><span class="code">e38a</span></li>
		<li><i class="newicon-trash-o"></i><span class="code">e38b</span></li>
		<li><i class="newicon-trash-bin"></i><span class="code">e3e8</span></li>

		<h2>교육</h2>
		<li><i class="newicon-study-1"></i><span class="code">e4e6</span></li>	
		<li><i class="newicon-graduation-cap"></i><span class="code">e443</span></li>
		<li><i class="newicon-graduation-hat"></i><span class="code">e311</span></li>
		<li><i class="newicon-target"></i><span class="code">e23d</span></li>	


		<h2>자물쇠</h2>		
		<li><i class="newicon-lock-filled"></i><span class="code">e0bf</span></li>
		<li><i class="newicon-openlock-filled"></i><span class="code">e0c0</span></li>
		<li><i class="newicon-lock-locker"></i><span class="code">e0c1</span></li>
		<li><i class="newicon-locker-unlock"></i><span class="code">e0c2</span></li>
		<li><i class="newicon-lock-1"></i><span class="code">e29e</span></li>
		<li><i class="newicon-lock-closed"></i><span class="code">e369</span></li>
		<li><i class="newicon-lock-open"></i><span class="code">e36a</span></li>
		<li><i class="newicon-unlock-alt"></i><span class="code">e439</span></li>
		<li><i class="newicon-unlock"></i><span class="code">e43a</span></li>				

		
		<h2>map</h2>
		<li><i class="newicon-direction"></i><span class="code">e083</span></li>
		<li><i class="newicon-compass-filled"></i><span class="code">e085</span></li>
		<li><i class="newicon-compass2-filled"></i><span class="code">e086</span></li>		
		<li><i class="newicon-android-pin"></i><span class="code">e08b</span></li>
		<li><i class="newicon-map-marker-1"></i><span class="code">e2d2</span></li>
		<li><i class="newicon-map-pin"></i><span class="code">e371</span></li>
		<li><i class="newicon-mark-map"></i><span class="code">e476</span></li>
		<li><i class="newicon-mark-map-1"></i><span class="code">e477</span></li>
		<li><i class="newicon-pin-location"></i><span class="code">e47a</span></li>
		<li><i class="newicon-pin-map"></i><span class="code">e482</span></li>
		<li><i class="newicon-placepin"></i><span class="code">e4df</span></li>		
		<li><i class="newicon-map-2"></i><span class="code">e08e</span></li>		
		<li><i class="newicon-map-3"></i><span class="code">e228</span></li>		
		<li><i class="newicon-map-o"></i><span class="code">e089</span></li>
		<li><i class="newicon-neuter"></i><span class="code">e088</span></li>
		<li><i class="newicon-global"></i><span class="code">e22f</span></li>
		<li><i class="newicon-line-map"></i><span class="code">e41e</span></li>		
		<li><i class="newicon-line-map-marker2"></i><span class="code">e42d</span></li>
		<li><i class="newicon-compass-2"></i><span class="code">e4b6</span></li>
		<li><i class="newicon-location-arrow"></i><span class="code">e44e</span></li>


		<h2>의료</h2>
		<li><i class="newicon-first-kit"></i><span class="code">e26b</span></li>
		<li><i class="newicon-first-kit-filled"></i><span class="code">e26c</span></li>
		<li><i class="newicon-medkit"></i><span class="code">e278</span></li>				
		<li><i class="newicon-consultion"></i><span class="code">e263</span></li>		
		<li><i class="newicon-stethoscope"></i><span class="code">e275</span></li>
		<li><i class="newicon-user-md"></i><span class="code">e276</span></li>
		<li><i class="newicon-ambulance"></i><span class="code">e277</span></li>		
		<li><i class="newicon-van"></i><span class="code">e27f</span></li>		
		<li><i class="newicon-heart-1"></i><span class="code">e2ca</span></li>
		<li><i class="newicon-heart-pulse"></i><span class="code">e2cb</span></li>			
		<li><i class="newicon-wheelchair-1"></i><span class="code">e37a</span></li>
		<li><i class="newicon-wheelchair"></i><span class="code">e274</span></li>
		<li><i class="newicon-handicap"></i><span class="code">e272</span></li>
		<li><i class="newicon-bouteille"></i><span class="code">e270</span></li>
		<li><i class="newicon-celule"></i><span class="code">e271</span></li>
		<li><i class="newicon-accessible-24px"></i><span class="code">e02e</span></li>

		<h2>파일</h2>	
		<li><i class="newicon-folder-1"></i><span class="code">e29b</span></li>
		<li><i class="newicon-folder-o"></i><span class="code">e29c</span></li>
		<li><i class="newicon-diskette"></i><span class="code">e0e8</span></li>
		<li><i class="newicon-document-box"></i><span class="code">e0e9</span></li>
		<li><i class="newicon-paperclip"></i><span class="code">e0e5</span></li>
		<li><i class="newicon-floppy-o"></i><span class="code">e0a1</span></li>
		<li><i class="newicon-android-attach"></i><span class="code">e392</span></li>
		<li><i class="newicon-paper-clip"></i><span class="code">e3c4</span></li>
		<li><i class="newicon-clip-paper-1"></i><span class="code">e3c7</span></li>
		<li><i class="newicon-archive"></i><span class="code">e3cf</span></li>
		<li><i class="newicon-paperclip-1"></i><span class="code">e3d0</span></li>
		<li><i class="newicon-save-disk"></i><span class="code">e3e6</span></li>
		<li><i class="newicon-paperclip-2"></i><span class="code">e3fc</span></li>
		<li><i class="newicon-attachment"></i><span class="code">e3fd</span></li>
		<li><i class="newicon-save"></i><span class="code">e455</span></li>
		<li><i class="newicon-floppy"></i><span class="code">e4ba</span></li>
		<li><i class="newicon-archive-24px"></i><span class="code">e030</span></li>
		<li><i class="newicon-source-24px"></i><span class="code">e03c</span></li>
		<li><i class="newicon-move-to-inbox-24px"></i><span class="code">e039</span></li>

		<h2>링크</h2>
		<li><i class="newicon-link-24px"></i><span class="code">e037</span></li>
		<li><i class="newicon-link-1"></i><span class="code">e2d1</span></li>
		<li><i class="newicon-link-2"></i><span class="code">e34f</span></li>
		<li><i class="newicon-link-3"></i><span class="code">e4bf</span></li>
		<li><i class="newicon-link"></i><span class="code">e0e6</span></li>
		<li><i class="newicon-hyperlink"></i><span class="code">e2f2</span></li>

		<h2>프린트</h2>	
		<li><i class="newicon-print2"></i><span class="code">e160</span></li>
		<li><i class="newicon-print3"></i><span class="code">e161</span></li>
		<li><i class="newicon-print4"></i><span class="code">e162</span></li>
		<li><i class="newicon-nc-test-outline-32px-print"></i><span class="code">e363</span></li>

		<h2>문서</h2>
		<li><i class="newicon-paper2"></i><span class="code">e105</span></li>
		<li><i class="newicon-document"></i><span class="code">e108</span></li>
		<li><i class="newicon-doc"></i><span class="code">e109</span></li>
		<li><i class="newicon-doc2"></i><span class="code">e10a</span></li>
		<li><i class="newicon-search-file"></i><span class="code">e069</span></li>
		<li><i class="newicon-news"></i><span class="code">e10d</span></li>
		<li><i class="newicon-news2"></i><span class="code">e10e</span></li>
		<li><i class="newicon-notice"></i><span class="code">e10f</span></li>
		<li><i class="newicon-notice2"></i><span class="code">e111</span></li>
		<li><i class="newicon-notice3"></i><span class="code">e112</span></li>
		<li><i class="newicon-notice-pen"></i><span class="code">e113</span></li>
		<li><i class="newicon-paper-pen"></i><span class="code">e114</span></li>
		<li><i class="newicon-note2"></i><span class="code">e116</span></li>
		<li><i class="newicon-note"></i><span class="code">e118</span></li>
		<li><i class="newicon-book5"></i><span class="code">e11e</span></li>
		<li><i class="newicon-book6"></i><span class="code">e11f</span></li>
		<li><i class="newicon-book-text"></i><span class="code">e12f</span></li>
		<li><i class="newicon-file-o"></i><span class="code">e37e</span></li>
		<li><i class="newicon-file-text-o"></i><span class="code">e37f</span></li>
		<li><i class="newicon-files-o"></i><span class="code">e380</span></li>
		<li><i class="newicon-email"></i><span class="code">e163</span></li>
		<li><i class="newicon-email-check"></i><span class="code">e164</span></li>		
		<li><i class="newicon-email2"></i><span class="code">e168</span></li>
		<li><i class="newicon-email3"></i><span class="code">e169</span></li>		
		<li><i class="newicon-carrybag"></i><span class="code">e16b</span></li>
		<li><i class="newicon-display"></i><span class="code">e24c</span></li>
		<li><i class="newicon-book-2"></i><span class="code">e2bb</span></li>
		<li><i class="newicon-briefcase"></i><span class="code">e2bd</span></li>
		<li><i class="newicon-page-break"></i><span class="code">e2d4</span></li>
		<li><i class="newicon-newspaper-o"></i><span class="code">e32c</span></li>
		<li><i class="newicon-nc-test-outline-32px-suitcase"></i><span class="code">e365</span></li>
		<li><i class="newicon-doc-text"></i><span class="code">e3eb</span></li>
		<li><i class="newicon-doc-text-inv"></i><span class="code">e3ec</span></li>
		<li><i class="newicon-vcard"></i><span class="code">e4c8</span></li>
		<li><i class="newicon-receipt"></i><span class="code">e020</span></li>
		<li><i class="newicon-mail-letter"></i><span class="code">e474</span></li>
		<li><i class="newicon-book-3"></i><span class="code">e47d</span></li>			
		

		<h2>TAG & PIN</h2>
		<li><i class="newicon-tag"></i><span class="code">e123</span></li>
		<li><i class="newicon-tag2"></i><span class="code">e124</span></li>
		<li><i class="newicon-tag3"></i><span class="code">e125</span></li>
		<li><i class="newicon-tag4-1"></i><span class="code">e129</span></li>
		<li><i class="newicon-tag4"></i><span class="code">e17a</span></li>				
		<li><i class="newicon-tag-1"></i><span class="code">e2de</span></li>
		<li><i class="newicon-tag-4"></i><span class="code">e484</span></li>
		<li><i class="newicon-label"></i><span class="code">e2f0</span></li>		
		<li><i class="newicon-bookmark-tag"></i><span class="code">e3c6</span></li>
		<li><i class="newicon-new-sign"></i><span class="code">e3c9</span></li>
		<li><i class="newicon-pushpin"></i><span class="code">e2da</span></li>		
		<li><i class="newicon-pin"></i><span class="code">e127</span></li>	
		
		<h2>타이머</h2>
		<li><i class="newicon-clock-3"></i><span class="code">e307</span></li>
		<li><i class="newicon-clock-2"></i><span class="code">e12a</span></li>
		<li><i class="newicon-clock"></i><span class="code">e12b</span></li>
		<li><i class="newicon-hourglass"></i><span class="code">e227</span></li>
		<li><i class="newicon-hourglass-1"></i><span class="code">e239</span></li>
		<li><i class="newicon-watch"></i><span class="code">e20a</span></li>
		<li><i class="newicon-clock-1"></i><span class="code">e2bf</span></li>
		<li><i class="newicon-hourglass-2"></i><span class="code">e2cc</span></li>
		<li><i class="newicon-hourglass-3"></i><span class="code">e4d9</span></li>
		<li><i class="newicon-access-alarm-24px"></i><span class="code">e028</span></li>
		<li><i class="newicon-timer-24px"></i><span class="code">e042</span></li>

		<h2>알림</h2>
		<li><i class="newicon-ringbell"></i><span class="code">e28c</span></li>
		<li><i class="newicon-bell-o"></i><span class="code">e298</span></li>
		<li><i class="newicon-bell"></i><span class="code">e293</span></li>
		<li><i class="newicon-bell-1"></i><span class="code">e297</span></li>
		<li><i class="newicon-sound"></i><span class="code">e34d</span></li>
		<li><i class="newicon-sound-1"></i><span class="code">e4ad</span></li>
		<li><i class="newicon-megaphone"></i><span class="code">e4c0</span></li>
		<li><i class="newicon-alarm"></i><span class="code">e2bc</span></li>	
		<li><i class="newicon-notifications-24px"></i><span class="code">e03a</span></li>
	</ul>
	

	<ul>
		<h2>SEND</h2>
		<li><i class="newicon-paper-plane2"></i><span class="code">e16e</span></li>			
		<li><i class="newicon-paper-plane-1"></i><span class="code">e451</span></li>			
		<li><i class="newicon-paper-plane-o"></i><span class="code">e45d</span></li>	
		<li><i class="newicon-mail-send"></i><span class="code">e475</span></li>
		<li><i class="newicon-paperplane"></i><span class="code">e4e4</span></li>	
		<li><i class="newicon-paper-plane-3"></i><span class="code">e4c3</span></li>
		<li><i class="newicon-paperplane-ico"></i><span class="code">e4de</span></li>
	</ul>

	<ul>
		<h2>기타</h2>
		<!---->
		<li><i class="newicon-card-giftcard-24px"></i><span class="code">e033</span></li>
		<li><i class="newicon-texture-24px"></i><span class="code">e041</span></li>
		<li><i class="newicon-crown"></i><span class="code">e445</span></li>
		<li><i class="newicon-crown-1"></i><span class="code">e4d6</span></li>
		<li><i class="newicon-cup"></i><span class="code">e19a</span></li>
		<li><i class="newicon-best-medal"></i><span class="code">e19d</span></li>
		<li><i class="newicon-trophy"></i><span class="code">e354</span></li>
		<li><i class="newicon-medal"></i><span class="code">e19e</span></li>
		<li><i class="newicon-seedling"></i><span class="code">e3b7</span></li>	
		
		
		
		<li><i class="newicon-nc-cake"></i><span class="code">e2ea</span></li>		
		<li><i class="newicon-key"></i><span class="code">e0a9</span></li>		
		<li><i class="newicon-microphone"></i><span class="code">e0c3</span></li>
		<li><i class="newicon-microphone2"></i><span class="code">e0c4</span></li>
		<li><i class="newicon-headphone"></i><span class="code">e0c5</span></li>		
		<li><i class="newicon-download"></i><span class="code">e0ec</span></li>
		<li><i class="newicon-upload"></i><span class="code">e0ed</span></li>			
		<li><i class="newicon-eye-1"></i><span class="code">e13f</span></li>		
		<li><i class="newicon-regulator2"></i><span class="code">e235</span></li>
		<li><i class="newicon-ribbon-1"></i><span class="code">e453</span></li>	
			
						
		<li><i class="newicon-calculator2"></i><span class="code">e195</span></li>		
		
		<li><i class="newicon-bulb"></i><span class="code">e1a2</span></li>
		
		<li><i class="newicon-stamp"></i><span class="code">e1ab</span></li>
		<li><i class="newicon-paint-bucket-1"></i><span class="code">e1ad</span></li>
		<li><i class="newicon-wifi-1"></i><span class="code">e03d</span></li>
		<li><i class="newicon-wifi-2"></i><span class="code">e03e</span></li>
		<li><i class="newicon-wifi-3"></i><span class="code">e03f</span></li>
		<li><i class="newicon-hierarchy"></i><span class="code">e040</span></li>
		<li><i class="newicon-hierarchy-2"></i><span class="code">e1ae</span></li>	
		<li><i class="newicon-flow-tree"></i><span class="code">e1d4</span></li>	
		<li><i class="newicon-magnet"></i><span class="code">e1b2</span></li>
		<li><i class="newicon-magnet-filled"></i><span class="code">e1b3</span></li>		
			
		
		<li><i class="newicon-ruler"></i><span class="code">e1f0</span></li>
		<li><i class="newicon-ruler-pen"></i><span class="code">e1f1</span></li>
		<li><i class="newicon-scissors"></i><span class="code">e1f2</span></li>		
		<li><i class="newicon-cards"></i><span class="code">e222</span></li>
		<li><i class="newicon-fork-knife"></i><span class="code">e223</span></li>	
		<li><i class="newicon-drop"></i><span class="code">e22e</span></li>

		
		<li><i class="newicon-hammer"></i><span class="code">e23a</span></li>
		<li><i class="newicon-magic"></i><span class="code">e23b</span></li>
		
		<li><i class="newicon-medecine-shield"></i><span class="code">e241</span></li>
		<li><i class="newicon-diving"></i><span class="code">e242</span></li>
		<li><i class="newicon-disk"></i><span class="code">e243</span></li>
		<li><i class="newicon-cam"></i><span class="code">e247</span></li>
		<li><i class="newicon-cctv"></i><span class="code">e248</span></li>		
		<li><i class="newicon-plug"></i><span class="code">e252</span></li>		
		<li><i class="newicon-brush"></i><span class="code">e25c</span></li>
		<li><i class="newicon-brush-filled"></i><span class="code">e25d</span></li>
		<li><i class="newicon-hard-hat"></i><span class="code">e25f</span></li>
		<li><i class="newicon-wagon"></i><span class="code">e262</span></li>		
		<li><i class="newicon-bus"></i><span class="code">e280</span></li>
		<li><i class="newicon-car"></i><span class="code">e281</span></li>
		<li><i class="newicon-bus2"></i><span class="code">e282</span></li>
		<li><i class="newicon-car2"></i><span class="code">e283</span></li>
		<li><i class="newicon-car-front"></i><span class="code">e284</span></li>
		<li><i class="newicon-bus-front"></i><span class="code">e287</span></li>
		<li><i class="newicon-electric-car"></i><span class="code">e286</span></li>
		<li><i class="newicon-airport"></i><span class="code">e28b</span></li>		
				
		
		<li><i class="newicon-tint"></i><span class="code">e26d</span></li>
				
			
		<li><i class="newicon-database"></i><span class="code">e2c1</span></li>
		<li><i class="newicon-drop-1"></i><span class="code">e2c2</span></li>
		<li><i class="newicon-enter"></i><span class="code">e2c4</span></li>
		<li><i class="newicon-enter-down"></i><span class="code">e2c5</span></li>
		<li><i class="newicon-exit-up"></i><span class="code">e2c6</span></li>		
			
		<li><i class="newicon-nc-air-baloon"></i><span class="code">e2e4</span></li>
		<li><i class="newicon-nc-banana"></i><span class="code">e2e5</span></li>
		<li><i class="newicon-nc-bear"></i><span class="code">e2e6</span></li>		
		<li><i class="newicon-nc-loud"></i><span class="code">e2eb</span></li>
		<li><i class="newicon-nc-diamond"></i><span class="code">e2ec</span></li>		
		<li><i class="newicon-nc-flight"></i><span class="code">e2f1</span></li>		
		<li><i class="newicon-nc-moon"></i><span class="code">e2f5</span></li>		
		<li><i class="newicon-nc-sun-cloud"></i><span class="code">e2ff</span></li>
		<li><i class="newicon-nc-vespa"></i><span class="code">e300</span></li>
		<li><i class="newicon-nc-sushi"></i><span class="code">e301</span></li>
		<li><i class="newicon-nc-album"></i><span class="code">e302</span></li>		
		<li><i class="newicon-launch"></i><span class="code">e309</span></li>		
		<li><i class="newicon-leaf-1"></i><span class="code">e30e</span></li>		
		
			
		
		
		<li><i class="newicon-linkedin"></i><span class="code">e329</span></li>		
		<li><i class="newicon-rss"></i><span class="code">e332</span></li>		
		<li><i class="newicon-waterdrop"></i><span class="code">e340</span></li>
			
		<li><i class="newicon-repo-forked"></i><span class="code">e345</span></li>
		<li><i class="newicon-buy"></i><span class="code">e346</span></li>		
			
		
		
		<li><i class="newicon-hearing-aid"></i><span class="code">e356</span></li>
		
		
		<li><i class="newicon-nc-test-outline-32px-eye"></i><span class="code">e35d</span></li>
		<li><i class="newicon-nc-test-outline-32px-eye-ban"></i><span class="code">e35e</span></li>
		<li><i class="newicon-nc-test-outline-32px-headphones"></i><span class="code">e35f</span></li>		
		<li><i class="newicon-nc-test-outline-32px-keyboard"></i><span class="code">e361</span></li>
		<li><i class="newicon-nc-test-outline-32px-money"></i><span class="code">e362</span></li>
		
			
			
		<li><i class="newicon-android-bulb"></i><span class="code">e393</span></li>
				
			
				
		<li><i class="newicon-address-book"></i><span class="code">e3ca</span></li>		
		
		
		<li><i class="newicon-shield"></i><span class="code">e3d3</span></li>		
		
		
		<li><i class="newicon-garden"></i><span class="code">e3ff</span></li>
		<li><i class="newicon-park"></i><span class="code">e402</span></li>
		
		<li><i class="newicon-line-cursor"></i><span class="code">e406</span></li>		
		<li><i class="newicon-line-gram2"></i><span class="code">e414</span></li>
		<li><i class="newicon-line-gram"></i><span class="code">e415</span></li>		
		<li><i class="newicon-dog"></i><span class="code">e3b1</span></li>		
		<li><i class="newicon-hamsa"></i><span class="code">e3b3</span></li>		
			
		<li><i class="newicon-suitcase-rolling"></i><span class="code">e435</span></li>
			
		<li><i class="newicon-git-commit"></i><span class="code">e43d</span></li>		
				
		<li><i class="newicon-crow"></i><span class="code">e0af</span></li>
		
		<li><i class="newicon-cut"></i><span class="code">e446</span></li>
		<li><i class="newicon-deaf"></i><span class="code">e447</span></li>
		<li><i class="newicon-dizzy"></i><span class="code">e448</span></li>		
		<li><i class="newicon-fingerprint"></i><span class="code">e44d</span></li>
				
		
		
		
			
			
			
		<li><i class="newicon-content-7"></i><span class="code">e485</span></li>
		<li><i class="newicon-content-1"></i><span class="code">e486</span></li>

			
		
		<li><i class="newicon-magnet-2"></i><span class="code">e48c</span></li>		
		<li><i class="newicon-scooter"></i><span class="code">e491</span></li>		
			
		<li><i class="newicon-guide-dog"></i><span class="code">e4a1</span></li>		
		<li><i class="newicon-key-1"></i><span class="code">e4a6</span></li>		
		<li><i class="newicon-music-1"></i><span class="code">e4a8</span></li>		
		<li><i class="newicon-droplet"></i><span class="code">e4b9</span></li>		
		
				
		<li><i class="newicon-music-2"></i><span class="code">e4c5</span></li>
		<li><i class="newicon-traffic-cone"></i><span class="code">e4c6</span></li>		
			
		<li><i class="newicon-measure"></i><span class="code">e4dd</span></li>
				
		<li><i class="newicon-ticket-1"></i><span class="code">e4e1</span></li>	
			
			
		<li><i class="newicon-spinner"></i><span class="code">e4e8</span></li>		
		<li><i class="newicon-nc-test-outline-32px-coffee"></i><span class="code">e4ed</span></li>
		<li><i class="newicon-nc-test-outline-32px-controller"></i><span class="code">e4ee</span></li>	
		
		
		<li><i class="newicon-leaf-2"></i><span class="code">e01d</span></li>		
				
		<li><i class="newicon-ruler-vertical"></i><span class="code">e021</span></li>
		<li><i class="newicon-shipping-fast"></i><span class="code">e026</span></li>		
	</ul>



	
	<ul>
		<h2>쇼핑</h2>
		<li><i class="newicon-won"></i><span class="code">e1da</span></li>
		<li><i class="newicon-ticket3"></i><span class="code">e1de</span></li>
		<li><i class="newicon-point"></i><span class="code">e1df</span></li>
		<li><i class="newicon-coin"></i><span class="code">e1e0</span></li>
		<li><i class="newicon-coin-filled"></i><span class="code">e1e1</span></li>
		<li><i class="newicon-coin-money"></i><span class="code">e1e2</span></li>
		<li><i class="newicon-cash"></i><span class="code">e1e3</span></li>
		<li><i class="newicon-card"></i><span class="code">e1e4</span></li>
		<li><i class="newicon-credit-card"></i><span class="code">e323</span></li>
		<li><i class="newicon-credit"></i><span class="code">e1e5</span></li>
		<li><i class="newicon-wallet"></i><span class="code">e1e6</span></li>		
		<li><i class="newicon-nc-test-outline-32px-wallet"></i><span class="code">e366</span></li>
		<li><i class="newicon-mobile-card"></i><span class="code">e1e8</span></li>
		<li><i class="newicon-cart2"></i><span class="code">e1ca</span></li>
		<li><i class="newicon-cart"></i><span class="code">e1cb</span></li>
		<li><i class="newicon-nc-test-outline-32px-cart"></i><span class="code">e35b</span></li>
		<li><i class="newicon-plane-1"></i><span class="code">e1d2</span></li>
		<li><i class="newicon-shopping-cart-1"></i><span class="code">e1d3</span></li>	
		<li><i class="newicon-truck"></i><span class="code">e1d5</span></li>
		<li><i class="newicon-gift2"></i><span class="code">e1e9</span></li>
		<li><i class="newicon-gift"></i><span class="code">e1ea</span></li>
		<li><i class="newicon-gift-filled"></i><span class="code">e1eb</span></li>
		<li><i class="newicon-shopbag"></i><span class="code">e1ed</span></li>
		<li><i class="newicon-shirts-i"></i><span class="code">e1f4</span></li>
		<li><i class="newicon-shirt"></i><span class="code">e1f5</span></li>
		<li><i class="newicon-bag-shopping"></i><span class="code">e202</span></li>
		<li><i class="newicon-backpack"></i><span class="code">e204</span></li>
		<li><i class="newicon-nc-shirt"></i><span class="code">e2fc</span></li>
		<li><i class="newicon-glases"></i><span class="code">e20c</span></li>
		<li><i class="newicon-dumbbell"></i><span class="code">e211</span></li>
		<li><i class="newicon-coffee2"></i><span class="code">e213</span></li>
		<li><i class="newicon-hotdog"></i><span class="code">e218</span></li>
		<li><i class="newicon-milk"></i><span class="code">e21b</span></li>
		<li><i class="newicon-bottle"></i><span class="code">e21c</span></li>
		<li><i class="newicon-bottle2"></i><span class="code">e21d</span></li>
		<li><i class="newicon-cooker"></i><span class="code">e21e</span></li>
		<li><i class="newicon-chef"></i><span class="code">e21f</span></li>
		<li><i class="newicon-nc-test-outline-32px-cart-add"></i><span class="code">e4ec</span></li>
		
	</ul>


	<p class="blue" style="padding:50px; font-size:13px; line-height:1.4em;">
		
		<span style="font-weight:700; font-size:16px; color:red; display:block;">사용법</span>
		css 폴더안에 intaefont폴더를 통채로 넣는다.

		<span style="font-weight:700; font-size:16px; color:red; display:block; margin-top:15px;">html</span>
		&lt;link rel="stylesheet" href="css/iconFont/newfont/styles.css"&gt;<br/>
		&lt;i class="newicon-add-user"&gt;&lt;/i&gt;

		<span style="font-weight:700; font-size:16px; color:red; display:block; margin-top:15px;">css</span>
		content: "\e688";<br/>
		font-family: 'newfont';
		<span style="font-weight:700; font-size:12px; display:block; margin-top:10px;">마지막 추가일 : 2017년 11월 04일</span>
	</p>

</div>


<!-- Scripts -->
<script type="text/javascript" src="js/lib/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/lib/bootstrap.min.js"></script>
<script type="text/javascript" src="js/lib/bootstrap-select.min.js"></script>
<script type="text/javascript" src="<?=get_url('js/lib/main.js')?>"></script>

<script>
$('li i').each(function() {
	var thisClass = $(this).attr('class');
	//var thisText = $(this).data('text');
	//$(this).after('<span class="name">' + thisClass + '</span>');
});
$('span.code').each(function() {
	var thisText = $(this).text();
	$(this).after('<span class="unicode">&amp;#x' + thisText + '</span>');
});
</script>
</body>
</html>
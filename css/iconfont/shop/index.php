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
    <title>shop 폰트</title>
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

	<ul style="margin-top:50px"><!--/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->


<li><i class="icon-shop-shoparrow-down"></i><span class="code">e900</span></li>
<li><i class="icon-shop-shoparrow-left"></i><span class="code">e901</span></li>
<li><i class="icon-shop-shoparrow-right"></i><span class="code">e902</span></li>
<li><i class="icon-shop-shoparrow-up"></i><span class="code">e903</span></li>
<li><i class="icon-shop-shopbook"></i><span class="code">e905</span></li>
<li><i class="icon-shop-shopbox"></i><span class="code">e909</span></li>
<li><i class="icon-shop-shopcalendar"></i><span class="code">e90c</span></li>
<li><i class="icon-shop-shopcamera"></i><span class="code">e90e</span></li>
<li><i class="icon-shop-shopclock"></i><span class="code">e90f</span></li>
<li><i class="icon-shop-shopdownload"></i><span class="code">e910</span></li>
<li><i class="icon-shop-shopgift"></i><span class="code">e911</span></li>
<li><i class="icon-shop-shopheart"></i><span class="code">e912</span></li>
<li><i class="icon-shop-shophelp-circle"></i><span class="code">e913</span></li>
<li><i class="icon-shop-shophexagon"></i><span class="code">e914</span></li>
<li><i class="icon-shop-shophome"></i><span class="code">e915</span></li>
<li><i class="icon-shop-shopimage"></i><span class="code">e916</span></li>
<li><i class="icon-shop-shopinfo"></i><span class="code">e917</span></li>
<li><i class="icon-shop-shoplink"></i><span class="code">e918</span></li>
<li><i class="icon-shop-shoplink-2"></i><span class="code">e919</span></li>
<li><i class="icon-shop-shopmenu"></i><span class="code">e91a</span></li>
<li><i class="icon-shop-shopmessage-circle"></i><span class="code">e91b</span></li>
<li><i class="icon-shop-shopmessage-square"></i><span class="code">e91c</span></li>
<li><i class="icon-shop-shopminus"></i><span class="code">e91d</span></li>
<li><i class="icon-shop-shopmore-horizontal"></i><span class="code">e91e</span></li>
<li><i class="icon-shop-shopmore-vertical"></i><span class="code">e91f</span></li>
<li><i class="icon-shop-shoppackage"></i><span class="code">e920</span></li>
<li><i class="icon-shop-shopphone"></i><span class="code">e921</span></li>
<li><i class="icon-shop-shopplus"></i><span class="code">e922</span></li>
<li><i class="icon-shop-shopsearch"></i><span class="code">e923</span></li>
<li><i class="icon-shop-shopshare"></i><span class="code">e924</span></li>
<li><i class="icon-shop-shopshare-2"></i><span class="code">e925</span></li>
<li><i class="icon-shop-shopshopping-bag"></i><span class="code">e926</span></li>
<li><i class="icon-shop-shopshopping-cart"></i><span class="code">e927</span></li>
<li><i class="icon-shop-shoptrash-2"></i><span class="code">e928</span></li>
<li><i class="icon-shop-shoptruck"></i><span class="code">e929</span></li>
<li><i class="icon-shop-shopuser"></i><span class="code">e92a</span></li>
<li><i class="icon-shop-shopuser-check"></i><span class="code">e92b</span></li>
<li><i class="icon-shop-shopusers"></i><span class="code">e92c</span></li>
<li><i class="icon-shop-shopx"></i><span class="code">e92d</span></li>
<li><i class="icon-shop-shop-1"></i><span class="code">e92e</span></li>
<li><i class="icon-shop-shop-2"></i><span class="code">e92f</span></li>
<li><i class="icon-shop-shop-3"></i><span class="code">e930</span></li>
<li><i class="icon-shop-shopic_1"></i><span class="code">e906</span></li>
<li><i class="icon-shop-shopic_2"></i><span class="code">e907</span></li>
<li><i class="icon-shop-shopic_3"></i><span class="code">e908</span></li>
<li><i class="icon-shop-shopkakao"></i><span class="code">e90a</span></li>
<li><i class="icon-shop-shopnaver"></i><span class="code">e90b</span></li>
<li><i class="icon-shop-shoptimer"></i><span class="code">e90d</span></li>
<li><i class="icon-shop-shopstar"></i><span class="code">e904</span></li>
<li><i class="icon-shop-shopstar-half"></i><span class="code">e931</span></li>
<li><i class="icon-shop-shopstar-half-l"></i><span class="code">e932</span></li>
<li><i class="icon-shop-shopstar-half-r"></i><span class="code">e933</span></li>
	
	</ul>

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
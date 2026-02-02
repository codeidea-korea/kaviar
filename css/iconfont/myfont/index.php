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
    <title>myfont</title>
    <link rel="stylesheet" href="styles.css">
	<link rel="stylesheet" href="<?=get_url('./style.css')?>">
	<link rel="stylesheet" href="<?=get_url('./css/bootstrap-select.css')?>">
	<link rel="stylesheet" href="<?=get_url('./css/index.css')?>">
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
	<ul class="small">
		
		<li><i class="myfont-line1-left"></i><span class="code">e900</span></li>
		<li><i class="myfont-line1-right"></i><span class="code">e901</span></li>
		<li><i class="myfont-line1-up"></i><span class="code">e902</span></li>
		<li><i class="myfont-line1-down"></i><span class="code">e903</span></li>
		<li><i class="myfont-line1-arrow-left"></i><span class="code">e904</span></li>
		<li><i class="myfont-line1-arrow-right"></i><span class="code">e905</span></li>
		<li><i class="myfont-line1-plus"></i><span class="code">e906</span></li>
		<li><i class="myfont-line1-x"></i><span class="code">e907</span></li>
		<li><i class="myfont-line1-check"></i><span class="code">e908</span></li>
		<li><i class="myfont-line1-menu"></i><span class="code">e909</span></li>
		<li><i class="myfont-line1-menu-left"></i><span class="code">e90a</span></li>
		<li><i class="myfont-line1-menu-right"></i><span class="code">e90b</span></li>
		<li><i class="myfont-line1-amenu-left"></i><span class="code">e90c</span></li>
		<li><i class="myfont-line1-amenu-right"></i><span class="code">e90d</span></li><br>

		<li><i class="myfont-line2-left"></i><span class="code">e90e</span></li>
		<li><i class="myfont-line2-right"></i><span class="code">e90f</span></li>
		<li><i class="myfont-line2-up"></i><span class="code">e910</span></li>
		<li><i class="myfont-line2-down"></i><span class="code">e911</span></li>
		<li><i class="myfont-line2-arrow-left"></i><span class="code">e912</span></li>
		<li><i class="myfont-line2-arrow-right"></i><span class="code">e913</span></li>
		<li><i class="myfont-line2-plus"></i><span class="code">e914</span></li>
		<li><i class="myfont-line2-x"></i><span class="code">e915</span></li>
		<li><i class="myfont-line2-check"></i><span class="code">e916</span></li>
		<li><i class="myfont-line2-menu"></i><span class="code">e917</span></li>
		<li><i class="myfont-line2-menu-left"></i><span class="code">e918</span></li>
		<li><i class="myfont-line2-menu-right"></i><span class="code">e919</span></li>
		<li><i class="myfont-line2-amenu-left"></i><span class="code">e91a</span></li>
		<li><i class="myfont-line2-amenu-right"></i><span class="code">e91b</span></li><br>

		<li><i class="myfont-line3-left"></i><span class="code">e91c</span></li>
		<li><i class="myfont-line3-right"></i><span class="code">e91d</span></li>
		<li><i class="myfont-line3-up"></i><span class="code">e91e</span></li>
		<li><i class="myfont-line3-down"></i><span class="code">e91f</span></li>
		<li><i class="myfont-line3-arrow-left"></i><span class="code">e920</span></li>
		<li><i class="myfont-line3-arrow-right"></i><span class="code">e921</span></li>
		<li><i class="myfont-line3-plus"></i><span class="code">e922</span></li>
		<li><i class="myfont-line3-x"></i><span class="code">e923</span></li>
		<li><i class="myfont-line3-check"></i><span class="code">e924</span></li>
		<li><i class="myfont-line3-menu"></i><span class="code">e925</span></li>
		<li><i class="myfont-line3-menu-left"></i><span class="code">e926</span></li>
		<li><i class="myfont-line3-menu-right"></i><span class="code">e927</span></li>
		<li><i class="myfont-line3-amenu-left"></i><span class="code">e928</span></li>
		<li><i class="myfont-line3-amenu-right"></i><span class="code">e929</span></li><br>

		<li><i class="myfont-line4-left"></i><span class="code">e92a</span></li>
		<li><i class="myfont-line4-right"></i><span class="code">e92b</span></li>
		<li><i class="myfont-line4-up"></i><span class="code">e92c</span></li>
		<li><i class="myfont-line4-down"></i><span class="code">e92d</span></li>
		<li><i class="myfont-line4-arrow-left"></i><span class="code">e92e</span></li>
		<li><i class="myfont-line4-arrow-right"></i><span class="code">e92f</span></li>
		<li><i class="myfont-line4-plus"></i><span class="code">e930</span></li>
		<li><i class="myfont-line4-x"></i><span class="code">e931</span></li>
		<li><i class="myfont-line4-check"></i><span class="code">e932</span></li>
		<li><i class="myfont-line4-menu"></i><span class="code">e933</span></li>
		<li><i class="myfont-line4-menu-left"></i><span class="code">e934</span></li>
		<li><i class="myfont-line4-menu-right"></i><span class="code">e935</span></li>
		<li><i class="myfont-line4-amenu-left"></i><span class="code">e936</span></li>
		<li><i class="myfont-line4-amenu-right"></i><span class="code">e937</span></li><br>

		<li><i class="myfont-line5-left"></i><span class="code">e938</span></li>
		<li><i class="myfont-line5-right"></i><span class="code">e939</span></li>
		<li><i class="myfont-line5-up"></i><span class="code">e93a</span></li>
		<li><i class="myfont-line5-down"></i><span class="code">e93b</span></li>
		<li><i class="myfont-line5-plus"></i><span class="code">e93c</span></li>
		<li><i class="myfont-line5-x"></i><span class="code">e93d</span></li>
		<li><i class="myfont-line5-check"></i><span class="code">e93e</span></li><br>

		<li><i class="myfont-line6-left"></i><span class="code">e93f</span></li>
		<li><i class="myfont-line6-right"></i><span class="code">e940</span></li>
		<li><i class="myfont-line6-up"></i><span class="code">e941</span></li>
		<li><i class="myfont-line6-down"></i><span class="code">e942</span></li>
		<li><i class="myfont-line6-plus"></i><span class="code">e943</span></li>
		<li><i class="myfont-line6-x"></i><span class="code">e944</span></li>
		<li><i class="myfont-line6-check"></i><span class="code">e945</span></li><br>

		<li><i class="myfont-line-left-slim" style="font-size:3em"></i><span class="code">e9ec</span></li>
		<li><i class="myfont-line-right-slim" style="font-size:3em"></i><span class="code">ea09</span></li>
		<li><i class="myfont-arrow-left-filled"></i><span class="code">e946</span></li>
		<li><i class="myfont-arrow-right-filled"></i><span class="code">e947</span></li>
		<li><i class="myfont-arrow-up-filled"></i><span class="code">e948</span></li>
		<li><i class="myfont-arrow-down-filled"></i><span class="code">e949</span></li>
		<li><i class="myfont-arrow-left-filled2"></i><span class="code">e94a</span></li>
		<li><i class="myfont-arrow-right-filled2"></i><span class="code">e94b</span></li>
		<li><i class="myfont-arrow-up-filled2"></i><span class="code">e94c</span></li>
		<li><i class="myfont-arrow-down-filled2"></i><span class="code">e94d</span></li><br>

		<li><i class="myfont-chevron-left"></i><span class="code">e94e</span></li>
		<li><i class="myfont-chevron-right"></i><span class="code">e94f</span></li>
		<li><i class="myfont-chevrons-left"></i><span class="code">e950</span></li>
		<li><i class="myfont-chevrons-right"></i><span class="code">e951</span></li>
		<li><i class="myfont-play-re"></i><span class="code">e953</span></li>
		<li><i class="myfont-play"></i><span class="code">e954</span></li>
		<li><i class="myfont-rewind1"></i><span class="code">e955</span></li>
		<li><i class="myfont-rewind"></i><span class="code">e956</span></li>
		<li><i class="myfont-skip-back"></i><span class="code">e957</span></li>
		<li><i class="myfont-skip-forward"></i><span class="code">e958</span></li>
		<li><i class="myfont-play-circle"></i><span class="code">e959</span></li>
		<li><i class="myfont-play-filled"></i><span class="code">e9b8</span></li>
		<li><i class="myfont-stop-filled"></i><span class="code">e9eb</span></li><br>

		<li><i class="myfont-plus"></i><span class="code">e95a</span></li>
		<li><i class="myfont-minus"></i><span class="code">e95b</span></li>
		<li><i class="myfont-x"></i><span class="code">e95c</span></li>
		<li><i class="myfont-x-bold"></i><span class="code">e9d1</span></li>
		<li><i class="myfont-check"></i><span class="code">e95d</span></li>
		<li><i class="myfont-plus-circle"></i><span class="code">e95e</span></li>
		<li><i class="myfont-minus-circle"></i><span class="code">e95f</span></li>
		<li><i class="myfont-x-circle"></i><span class="code">e960</span></li>
		<li><i class="myfont-plus-square"></i><span class="code">e961</span></li>
		<li><i class="myfont-x-square"></i><span class="code">e962</span></li>
		<li><i class="myfont-minus-square"></i><span class="code">e963</span></li>
		<li><i class="myfont-trash"></i><span class="code">e964</span></li>
		<li><i class="myfont-trash-2"></i><span class="code">e965</span></li>
		<li><i class="myfont-delete"></i><span class="code">e966</span></li><br>

		<li><i class="myfont-info"></i><span class="code">e967</span></li>
		<li><i class="myfont-alert-circle"></i><span class="code">e968</span></li>
		<li><i class="myfont-help-circle"></i><span class="code">e969</span></li>
		<li><i class="myfont-alert-triangle"></i><span class="code">e96a</span></li>
		<li><i class="myfont-info-bold"></i><span class="code">e9d7</span></li>
		<li><i class="myfont-alert-octagon"></i><span class="code">e96b</span></li><br>

		<li><i class="myfont-search"></i><span class="code">e952</span></li>
		<li><i class="myfont-zoom-in1"></i><span class="code">e992</span></li>
		<li><i class="myfont-zoom-out1"></i><span class="code">e993</span></li>
		<li><i class="myfont-line1-search"></i><span class="code">e96c</span></li>
		<li><i class="myfont-line2-search"></i><span class="code">e96d</span></li>
		<li><i class="myfont-line3-search"></i><span class="code">e96e</span></li>
		<li><i class="myfont-line4-search"></i><span class="code">e96f</span></li><br>

		<li><i class="myfont-line1-msearch" style="font-size:26px"></i><span class="code">e970</span></li>
		<li><i class="myfont-line2-msearch" style="font-size:26px"></i><span class="code">e971</span></li>
		<li><i class="myfont-line3-msearch" style="font-size:26px"></i><span class="code">e972</span></li>
		<li><i class="myfont-line1-dsearch"></i><span class="code">e973</span></li>
		<li><i class="myfont-line2-dsearch"></i><span class="code">e974</span></li>
		<li><i class="myfont-line3-dsearch"></i><span class="code">e975</span></li>
		<li><i class="myfont-line1-search2"></i><span class="code">e976</span></li>
		<li><i class="myfont-line2-search2"></i><span class="code">e977</span></li>
		<li><i class="myfont-line3-search2"></i><span class="code">e978</span></li>
		<li><i class="myfont-line4-search2"></i><span class="code">e979</span></li><br>

		<li><i class="myfont-file"></i><span class="code">e9c5</span></li>
		<li><i class="myfont-file-minus"></i><span class="code">e9c6</span></li>
		<li><i class="myfont-file-plus"></i><span class="code">e9c7</span></li>
		<li><i class="myfont-file-text"></i><span class="code">e9c8</span></li>
		<li><i class="myfont-file-text1"></i><span class="code">ea07</span></li>
		<li><i class="myfont-intaefont-icon144"></i><span class="code">e9a0</span></li>
		<li><i class="myfont-clipboard"></i><span class="code">e9c9</span></li>
		<li><i class="myfont-paper-check"></i><span class="code">eab5</span></li>
		<li><i class="myfont-paper-check2"></i><span class="code">eab6</span></li>
		<li><i class="myfont-paper-roll"></i><span class="code">eab7</span></li>
		<li><i class="myfont-board"></i><span class="code">e9a1</span></li>
		<li><i class="myfont-board-filled"></i><span class="code">e9a2</span></li><br>

		<li><i class="myfont-message-circle"></i><span class="code">e9ca</span></li>
		<li><i class="myfont-message-square"></i><span class="code">e9cb</span></li>
		<li><i class="myfont-msg"></i><span class="code">e9a3</span></li>
		<li><i class="myfont-msg-filled"></i><span class="code">e9a4</span></li>
		<li><i class="myfont-msg2"></i><span class="code">e9a5</span></li>
		<li><i class="myfont-msg2-filled"></i><span class="code">e9a6</span></li>
		<li><i class="myfont-msg3"></i><span class="code">e9a7</span></li>
		<li><i class="myfont-msg3-filled"></i><span class="code">e9a8</span></li><br>

		<li><i class="myfont-calendar"></i><span class="code">e9d0</span></li>
		<li><i class="myfont-calendar2"></i><span class="code">e9a9</span></li>
		<li><i class="myfont-calendar-filled"></i><span class="code">e9aa</span></li>
		<li><i class="myfont-calendar11"></i><span class="code">e9ab</span></li>
		<li><i class="myfont-calendar11-filled"></i><span class="code">e9ac</span></li><br>

		<li><i class="myfont-book"></i><span class="code">e9ad</span></li>
		<li><i class="myfont-book-open"></i><span class="code">e9d8</span></li>
		<li><i class="myfont-tag"></i><span class="code">e9d9</span></li>
		<li><i class="myfont-tag-filled"></i><span class="code">ea9a</span></li>
		<li><i class="myfont-bookmark"></i><span class="code">e9db</span></li>
		<li><i class="myfont-award"></i><span class="code">e9ce</span></li>
		<li><i class="myfont-folder"></i><span class="code">e9e1</span></li>
		<li><i class="myfont-folder-plus"></i><span class="code">e9e2</span></li>
		<li><i class="myfont-folder-minus"></i><span class="code">e9e3</span></li><br>

		<li><i class="myfont-hexagon"></i><span class="code">e9e4</span></li>
		<li><i class="myfont-check-circle"></i><span class="code">e9e5</span></li>
		<li><i class="myfont-check-square"></i><span class="code">e9e6</span></li><br>

		<li><i class="myfont-home"></i><span class="code">e9e7</span></li>
		<li><i class="myfont-home2"></i><span class="code">e99e</span></li>
		<li><i class="myfont-home2-filled"></i><span class="code">e99f</span></li><br>

		<li><i class="myfont-corner-down-right"></i><span class="code">e97a</span></li>
		<li><i class="myfont-corner-down-right-bold"></i><span class="code">e97b</span></li>
		<li><i class="myfont-corner-up-right-bold"></i><span class="code">ea99</span></li>
		<li><i class="myfont-corner-down-right-smbold"></i><span class="code">e97c</span></li>
		<li><i class="myfont-corner-down-right-exbold"></i><span class="code">e97d</span></li>
		<li><i class="myfont-corner-down-right-re"></i><span class="code">e97e</span></li><br>

		<li><i class="myfont-edit-square"></i><span class="code">e9e8</span></li>
		<li><i class="myfont-edit1"></i><span class="code">ea98</span></li>
		<li><i class="myfont-edit-filled"></i><span class="code">e980</span></li>
		<li><i class="myfont-edit"></i><span class="code">e9ea</span></li>
		<li><i class="myfont-edit-line"></i><span class="code">e995</span></li>
		<li><i class="myfont-edit-line2"></i><span class="code">e981</span></li>
		<li><i class="myfont-feather"></i><span class="code">e9e9</span></li>
		<li><i class="myfont-feather2"></i><span class="code">e982</span></li>
		<li><i class="myfont-crop"></i><span class="code">e9ed</span></li>
		<li><i class="myfont-pen-tool"></i><span class="code">e9ee</span></li>		
		<li><i class="myfont-pen-tool2"></i><span class="code">e983</span></li>
		<li><i class="myfont-text-marker"></i><span class="code">ea96</span></li><br>

		<li><i class="myfont-eye"></i><span class="code">e9ef</span></li>
		<li><i class="myfont-eye-off"></i><span class="code">e9f0</span></li>
		<li><i class="myfont-add-block"></i><span class="code">e984</span></li>
		<li><i class="myfont-add-block2"></i><span class="code">e985</span></li>
		<li><i class="myfont-scissors-small"></i><span class="code">e986</span></li>
		<li><i class="myfont-scissors"></i><span class="code">e9f1</span></li><br>

		<li><i class="myfont-download"></i><span class="code">e987</span></li>
		<li><i class="myfont-upload"></i><span class="code">e9f2</span></li>
		<li><i class="myfont-share"></i><span class="code">e9f3</span></li>
		<li><i class="myfont-log-in"></i><span class="code">e9f4</span></li>
		<li><i class="myfont-log-out"></i><span class="code">e9f5</span></li>
		<li><i class="myfont-door-in"></i><span class="code">e988</span></li>
		<li><i class="myfont-door-out"></i><span class="code">e989</span></li>
		<li><i class="myfont-login"></i><span class="code">e98a</span></li>
		<li><i class="myfont-logout"></i><span class="code">e98b</span></li>
		<li><i class="myfont-download2"></i><span class="code">e98c</span></li>
		<li><i class="myfont-save"></i><span class="code">e9f6</span></li>
		<li><i class="myfont-save-slim"></i><span class="code">ea9b</span></li><br>

		<li><i class="myfont-filebox"></i><span class="code">e98d</span></li>
		<li><i class="myfont-filebox-filled"></i><span class="code">e98e</span></li>
		<li><i class="myfont-inbox"></i><span class="code">e9f7</span></li>
		<li><i class="myfont-hard-drive"></i><span class="code">e9f8</span></li>
		<li><i class="myfont-server"></i><span class="code">e9f9</span></li>
		<li><i class="myfont-database"></i><span class="code">e9fa</span></li>
		<li><i class="myfont-cloud"></i><span class="code">e9fb</span></li>
		<li><i class="myfont-upload-cloud"></i><span class="code">e9fc</span></li>
		<li><i class="myfont-download-cloud"></i><span class="code">e9fd</span></li><br>

		<li><i class="myfont-paperclip"></i><span class="code">e9fe</span></li>
		<li><i class="myfont-href"></i><span class="code">e98f</span></li>
		<li><i class="myfont-link"></i><span class="code">ea14</span></li>
		<li><i class="myfont-line-bold8"></i><span class="code">e990</span></li><br>

		<li><i class="myfont-camera"></i><span class="code">e9ff</span></li>
		<li><i class="myfont-camera-off"></i><span class="code">ea00</span></li>
		<li><i class="myfont-instagram"></i><span class="code">ea01</span></li>
		<li><i class="myfont-image"></i><span class="code">ea02</span></li>
		<li><i class="myfont-image-slim"></i><span class="code">ea9c</span></li>
		<li><i class="myfont-images"></i><span class="code">e991</span></li>
		<li><i class="myfont-images-slim"></i><span class="code">ea9d</span></li>
		<li><i class="myfont-copy"></i><span class="code">ea03</span></li>
		<li><i class="myfont-layers"></i><span class="code">ea04</span></li>
		<li><i class="myfont-layers2"></i><span class="code">e996</span></li>
		<li><i class="myfont-sidebar"></i><span class="code">ea06</span></li>
		<li><i class="myfont-layout"></i><span class="code">ea0b</span></li>
		<li><i class="myfont-columns"></i><span class="code">ea08</span></li>
		<li><i class="myfont-credit-card"></i><span class="code">ea0a</span></li><br>

		<li><i class="myfont-video-box"></i><span class="code">e997</span></li>
		<li><i class="myfont-film"></i><span class="code">ea0e</span></li>
		<li><i class="myfont-video"></i><span class="code">ea0f</span></li>
		<li><i class="myfont-video-filled"></i><span class="code">e998</span></li><br>

		<li><i class="myfont-smartphone"></i><span class="code">ea11</span></li>
		<li><i class="myfont-tablet"></i><span class="code">ea15</span></li>
		<li><i class="myfont-smartphone2"></i><span class="code">e999</span></li>
		<li><i class="myfont-monitor"></i><span class="code">ea16</span></li>
		<li><i class="myfont-desktop"></i><span class="code">e99a</span></li>
		<li><i class="myfont-monitor2"></i><span class="code">e99b</span></li>
		<li><i class="myfont-speaker"></i><span class="code">ea18</span></li>
		<li><i class="myfont-mouse"></i><span class="code">e99c</span></li>
		<li><i class="myfont-mouse2"></i><span class="code">e99d</span></li>
		<li><i class="myfont-keyboard"></i><span class="code">e9ae</span></li>
		<li><i class="myfont-printer"></i><span class="code">ea1b</span></li>
		<li><i class="myfont-printer2"></i><span class="code">e9af</span></li><br>

		<li><i class="myfont-user"></i><span class="code">ea1c</span></li>
		<li><i class="myfont-users"></i><span class="code">ea1d</span></li>
		<li><i class="myfont-user-check"></i><span class="code">ea1e</span></li>
		<li><i class="myfont-user-plus"></i><span class="code">ea1f</span></li>
		<li><i class="myfont-user-minus"></i><span class="code">ea20</span></li>
		<li><i class="myfont-user-x"></i><span class="code">ea21</span></li>
		<li><i class="myfont-line1-user"></i><span class="code">e9b0</span></li>
		<li><i class="myfont-line2-user"></i><span class="code">e9b1</span></li><br>

		<li><i class="myfont-unlock"></i><span class="code">ea22</span></li>
		<li><i class="myfont-lock"></i><span class="code">ea23</span></li>
		<li><i class="myfont-lock2"></i><span class="code">e9b2</span></li>
		<li><i class="myfont-lock2-filled"></i><span class="code">e9b3</span></li>
		<li><i class="myfont-unlock2"></i><span class="code">e9b4</span></li>
		<li><i class="myfont-unlock2-filled"></i><span class="code">e9b5</span></li>
		<li><i class="myfont-settings"></i><span class="code">ea05</span></li>
		<li><i class="myfont-tool"></i><span class="code">ea24</span></li>
		<li><i class="myfont-sliders"></i><span class="code">ea25</span></li>
		<li><i class="myfont-sliders1"></i><span class="code">ea9e</span></li>
		<li><i class="myfont-filter1"></i><span class="code">ea9f</span></li>
		<li><i class="myfont-setting"></i><span class="code">e9b6</span></li><br>

		<li><i class="myfont-mouse-pointer"></i><span class="code">e9b7</span></li>
		<li><i class="myfont-slash"></i><span class="code">ea26</span></li>
		<li><i class="myfont-italic"></i><span class="code">ea27</span></li>
		<li><i class="myfont-refresh-ccw"></i><span class="code">ea28</span></li>
		<li><i class="myfont-rotate-ccw"></i><span class="code">ea29</span></li>
		<li><i class="myfont-rotate-cw"></i><span class="code">ea2a</span></li>
		<li><i class="myfont-repeat"></i><span class="code">ea2b</span></li>		
		<li><i class="myfont-type"></i><span class="code">ea2d</span></li><br>

		<li><i class="myfont-external-link"></i><span class="code">ea2e</span></li>
		<li><i class="myfont-maximize-2"></i><span class="code">ea2f</span></li>
		<li><i class="myfont-minimize-2"></i><span class="code">ea30</span></li>
		<li><i class="myfont-move"></i><span class="code">ea31</span></li>
		<li><i class="myfont-maximize"></i><span class="code">ea32</span></li>
		<li><i class="myfont-minimize"></i><span class="code">ea33</span></li>
		<li><i class="myfont-check-circle1"></i><span class="code">ea12</span></li>
		<li><i class="myfont-check-square1"></i><span class="code">ea13</span></li>
		<li><i class="myfont-arrow-right-circle"></i><span class="code">ea34</span></li>
		<li><i class="myfont-arrow-down-right"></i><span class="code">ea35</span></li>
		<li><i class="myfont-hash"></i><span class="code">ea36</span></li>
		<li><i class="myfont-percent"></i><span class="code">ea37</span></li>
		<li><i class="myfont-hashbold"></i><span class="code">e9d2</span></li>
		<li><i class="myfont-at-sign1"></i><span class="code">e9d3</span></li>
		<li><i class="myfont-at-sign2"></i><span class="code">ea38</span></li>
		<li><i class="myfont-at-sign-bold"></i><span class="code">e9d4</span></li>
		<li><i class="myfont-underline"></i><span class="code">ea39</span></li>
		<li><i class="myfont-command"></i><span class="code">ea3a</span></li>
		<li><i class="myfont-activity"></i><span class="code">ea3b</span></li>
		<li><i class="myfont-disc"></i><span class="code">ea3c</span></li>
		<li><i class="myfont-anchor"></i><span class="code">ea3d</span></li><br>

		<li><i class="myfont-clock"></i><span class="code">ea3e</span></li>
		<li><i class="myfont-bell"></i><span class="code">ea3f</span></li>
		<li><i class="myfont-bell-off"></i><span class="code">ea40</span></li>
		<li><i class="myfont-bell2"></i><span class="code">e9b9</span></li>
		<li><i class="myfont-bell3"></i><span class="code">e9ba</span></li>
		<li><i class="myfont-shield"></i><span class="code">ea41</span></li>
		<li><i class="myfont-pocket"></i><span class="code">ea42</span></li>
		<li><i class="myfont-shield2"></i><span class="code">e9da</span></li><br>

		<li><i class="myfont-heart"></i><span class="code">ea43</span></li>
		<li><i class="myfont-heart-bold"></i><span class="code">ea0c</span></li>
		<li><i class="myfont-heart-filled"></i><span class="code">ea53</span></li>
		<li><i class="myfont-star"></i><span class="code">ea44</span></li>
		<li><i class="myfont-star-half"></i><span class="code">ea45</span></li>
		<li><i class="myfont-star-filled"></i><span class="code">ea46</span></li>
		<li><i class="myfont-trophy"></i><span class="code">eab8</span></li>
		<li><i class="myfont-droplet"></i><span class="code">ea47</span></li><br>

		<li><i class="myfont-line1-map"></i><span class="code">e9bc</span></li>
		<li><i class="myfont-line2-map"></i><span class="code">ea48</span></li>
		<li><i class="myfont-map-filled"></i><span class="code">e9be</span></li>
		<li><i class="myfont-navigation"></i><span class="code">ea2c</span></li>
		<li><i class="myfont-navigation-filled"></i><span class="code">e9ec</span></li>
		<li><i class="myfont-map"></i><span class="code">ea49</span></li>
		<li><i class="myfont-compass"></i><span class="code">ea4a</span></li>
		<li><i class="myfont-crosshair"></i><span class="code">ea4b</span></li>
		<li><i class="myfont-pin"></i><span class="code">e9bf</span></li>
		<li><i class="myfont-flag"></i><span class="code">ea4c</span></li>
		<li><i class="myfont-flag2"></i><span class="code">e9c0</span></li>
		<li><i class="myfont-flag2-filled"></i><span class="code">e9c1</span></li><br>
		
		<li><i class="myfont-sitemap"></i><span class="code">eab9</span></li>
		<li><i class="myfont-git-commit"></i><span class="code">ea4d</span></li>
		<li><i class="myfont-git-pull-request"></i><span class="code">ea4e</span></li>
		<li><i class="myfont-pie-chart"></i><span class="code">ea4f</span></li>
		<li><i class="myfont-bar-chart"></i><span class="code">ea50</span></li>
		<li><i class="myfont-bar-chart2"></i><span class="code">ea51</span></li>
		<li><i class="myfont-more-horizontal"></i><span class="code">ea52</span></li>
		<li><i class="myfont-more-vertical"></i><span class="code">ea0d</span></li>
		<li><i class="myfont-more-vertical2"></i><span class="code">e9c2</span></li>
		<li><i class="myfont-more-vertical3"></i><span class="code">e9c3</span></li>
		<li><i class="myfont-list"></i><span class="code">ea54</span></li>
		<li><i class="myfont-gall-grid"></i><span class="code">e9c4</span></li>
		<li><i class="myfont-grid"></i><span class="code">ea55</span></li><br>

		<li><i class="myfont-mail"></i><span class="code">ea56</span></li>
		<li><i class="myfont-send"></i><span class="code">ea57</span></li>
		<li><i class="myfont-i-share"></i><span class="code">ea58</span></li>
		<li><i class="myfont-thumbs-up"></i><span class="code">ea59</span></li>
		<li><i class="myfont-thumbs-down"></i><span class="code">ea5a</span></li>
		<li><i class="myfont-filter"></i><span class="code">ea1a</span></li>
		<li><i class="myfont-filter-filled"></i><span class="code">ea19</span></li>
		<li><i class="myfont-globe"></i><span class="code">ea5b</span></li>
		<li><i class="myfont-toggle-left"></i><span class="code">ea5c</span></li>
		<li><i class="myfont-toggle-right"></i><span class="code">ea5d</span></li>
		<li><i class="myfont-toggle-left-off"></i><span class="code">e9cc</span></li>
		<li><i class="myfont-toggle-left-on"></i><span class="code">e9cd</span></li><br>

		<li><i class="myfont-power"></i><span class="code">e9d5</span></li>
		<li><i class="myfont-power2"></i><span class="code">e9d6</span></li>
		<li><i class="myfont-battery"></i><span class="code">ea5e</span></li>
		<li><i class="myfont-battery-charging"></i><span class="code">ea5f</span></li>
		<li><i class="myfont-trending-up"></i><span class="code">ea17</span></li>
		<li><i class="myfont-headphones"></i><span class="code">ea60</span></li>
		<li><i class="myfont-volume"></i><span class="code">ea61</span></li>
		<li><i class="myfont-rss"></i><span class="code">ea62</span></li>
		<li><i class="myfont-cast"></i><span class="code">ea63</span></li>
		<li><i class="myfont-passwod"></i><span class="code">eaba</span></li>
		<li><i class="myfont-qrcode"></i><span class="code">eabb</span></li>
		<li><i class="myfont-fingerprint"></i><span class="code">eabc</span></li>
		<li><i class="myfont-radio"></i><span class="code">ea64</span></li>
		<li><i class="myfont-bluetooth"></i><span class="code">ea65</span></li>
		<li><i class="myfont-smile"></i><span class="code">ea66</span></li>
		<li><i class="myfont-stop-circle"></i><span class="code">ea67</span></li>
		<li><i class="myfont-target"></i><span class="code">ea68</span></li>
		<li><i class="myfont-life-buoy"></i><span class="code">ea69</span></li>
		<li><i class="myfont-trello"></i><span class="code">ea6a</span></li>
		<li><i class="myfont-coffee"></i><span class="code">ea6b</span></li>
		<li><i class="myfont-loader"></i><span class="code">ea6c</span></li>
		<li><i class="myfont-terminal"></i><span class="code">ea6d</span></li>
		<li><i class="myfont-wind"></i><span class="code">ea6e</span></li>
		<li><i class="myfont-voicemail"></i><span class="code">ea6f</span></li>
		<li><i class="myfont-thermometer"></i><span class="code">ea70</span></li>
		<li><i class="myfont-music"></i><span class="code">ea71</span></li>
		<li><i class="myfont-intaefont-icon185"></i><span class="code">e9cf</span></li>
		<li><i class="myfont-figma"></i><span class="code">ea72</span></li><br>

		<li class="ex" style="width:100%;margin-top:40px"></li>
		<li><i class="myfont-line1-deco1" style="font-size:45px"></i><span class="code">ea73</span></li>
		<li><i class="myfont-line1-deco2" style="font-size:45px"></i><span class="code">ea74</span></li>
		<li><i class="myfont-line1-deco3" style="font-size:45px"></i><span class="code">ea75</span></li>
		<li><i class="myfont-line2-deco1" style="font-size:45px"></i><span class="code">ea76</span></li>
		<li><i class="myfont-line2-deco2" style="font-size:45px"></i><span class="code">ea77</span></li>
		<li><i class="myfont-line2-deco3" style="font-size:45px"></i><span class="code">ea78</span></li><br>

		<li><i class="myfont-square-filled" style="font-size:45px"></i><span class="code">ea79</span></li>
		<li><i class="myfont-circle-filled" style="font-size:45px"></i><span class="code">ea7a</span></li>
		<li><i class="myfont-triangle-filled" style="font-size:45px"></i><span class="code">ea7b</span></li>
		<li><i class="myfont-square-rt-filled" style="font-size:45px"></i><span class="code">ea7c</span></li>
		<li><i class="myfont-square-bold" style="font-size:45px"></i><span class="code">ea7d</span></li>
		<li><i class="myfont-circle-bold" style="font-size:45px"></i><span class="code">ea7e</span></li>
		<li><i class="myfont-triangle-bold" style="font-size:45px"></i><span class="code">ea7f</span></li>
		<li><i class="myfont-square-rt-bold" style="font-size:45px"></i><span class="code">ea80</span></li><br>

		<li><i class="myfont-deco-square" style="font-size:45px"></i><span class="code">ea81</span></li>
		<li><i class="myfont-deco-circle" style="font-size:45px"></i><span class="code">ea82</span></li>
		<li><i class="myfont-deco-triangle" style="font-size:45px"></i><span class="code">ea83</span></li>
		<li><i class="myfont-deco-square-rt" style="font-size:45px"></i><span class="code">ea84</span></li>
		<li><i class="myfont-deco2-rectangle" style="font-size:45px"></i><span class="code">ea85</span></li>
		<li><i class="myfont-deco2-square" style="font-size:45px"></i><span class="code">ea86</span></li><br>

		<li class="ex" style="width:100%;margin-top:40px"></li>
		<li><i class="myfont-codepen"></i><span class="code">ea87</span></li>
		<li><i class="myfont-shopping-cart1"></i><span class="code">ea10</span></li>
		<li><i class="myfont-shopping-bag"></i><span class="code">ea89</span></li>
		<li><i class="myfont-won"></i><span class="code">e9dc</span></li>
		<li><i class="myfont-won-filled"></i><span class="code">e9dd</span></li>
		<li><i class="myfont-dollar-sign"></i><span class="code">ea8a</span></li>
		<li><i class="myfont-truck"></i><span class="code">ea8b</span></li>
		<li><i class="myfont-package"></i><span class="code">ea8c</span></li>
		<li><i class="myfont-box"></i><span class="code">ea8d</span></li>
		<li><i class="myfont-gift"></i><span class="code">ea8e</span></li>
		<li><i class="myfont-archive"></i><span class="code">ea8f</span></li>
		<li><i class="myfont-phone"></i><span class="code">ea90</span></li>
		<li><i class="myfont-phone-call"></i><span class="code">ea91</span></li>
		<li><i class="myfont-phone2"></i><span class="code">e9bb</span></li>
		<li><i class="myfont-phone2-filled"></i><span class="code">e9bd</span></li>
		<li><i class="myfont-tv"></i><span class="code">ea92</span></li>
		<li><i class="myfont-briefcase"></i><span class="code">ea93</span></li>
		<li><i class="myfont-umbrella"></i><span class="code">ea94</span></li>
		<li><i class="myfont-cpu"></i><span class="code">ea95</span></li><br>

		<li class="ex" style="width:100%;margin-top:40px"></li>
		<li><i class="myfont-facebook"></i><span class="code">e9de</span></li>
		<li><i class="myfont-twitter"></i><span class="code">ea88</span></li>
		<li><i class="myfont-twitter-filled"></i><span class="code">e9df</span></li>
		<li><i class="myfont-youtube"></i><span class="code">e9e0</span></li>
		<li><i class="myfont-youtube-red" style="color: #f00"></i><span class="code">e97f</span></li>
		<li><i class="myfont-microsoftexcel" style="color: #217346"></i><span class="code">e994</span></li>

	</ul>




	<p class="blue" style="padding:50px; font-size:13px; line-height:1.4em;">
		<p class="iconCount" style="margin-bottom:10px;"></p>
		<span style="font-weight:700; font-size:16px; color:red; display:block;">사용법</span>
		css 폴더안에 myfont 폴더를 통채로 넣는다.

		<span style="font-weight:700; font-size:16px; color:red; display:block; margin-top:15px;">html</span>
		&lt;link rel="stylesheet" href="css/iconfont/myfont/style.css"&gt;

		<span style="font-weight:700; font-size:16px; color:red; display:block; margin-top:15px;">css</span>
		content: "\e688";<br/>
		font-family: 'myfont';
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
var iconCount = $('li:not(.ex)').length;
$('.iconCount').html('아이콘 총 개수 : <b>'+iconCount+'</b>개');
</script>

</body>
</html>
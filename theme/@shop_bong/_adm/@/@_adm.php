<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$title = '쇼핑몰 사이트 관리';
include_once(G5_BBS_PATH.'/my/_adm/_adm.head.php');

$_adm_url = G5_BBS_URL.'/my/_adm';
$_adm_inc_path = G5_BBS_PATH.'/_adm';
$_adm_update_url = G5_THEME_URL.'/_adm';
$callback_url = $_adm_url.'/_adm.php';
$callback_url .= $_SERVER[ "QUERY_STRING" ] ? '?'.$_SERVER[ "QUERY_STRING" ] : '';

if(!file_exists($_adm_inc_path.'/'.$pn)) { //인태 - 커스텀페이지로 대체
	$_adm_inc_path = G5_THEME_PATH.'/_adm';
}

// 파일체크
switch($pn) {
	default									: $adm_file = $_adm_inc_path.'/_shop_config.php'; break;
	case 'shop_header'					: $adm_file = $_adm_inc_path.'/_shop_header_setting.php'; break;
	case 'itemtype'						: $adm_file = $_adm_inc_path.'/_itemtype_setting.php'; break;
	//case 'mainpage'					: $adm_file = $_adm_inc_path.'/_adm_mainpage.php'; break;
	case 'shop_footer'					: $adm_file = $_adm_inc_path.'/_shop_footer_setting.php'; break;
	case 'shop_banner'					: $adm_file = $_adm_inc_path.'/shop_banner.php'; break;
	case 'defStyle'						: $adm_file = $_adm_inc_path.'/_adm_default_style.php'; break;
}
?>

<div class="_popup_form">
	<h1 id="form-title"><?=$title?></h1>
	<div class="box-tabs-container">
		<div class="tabs-group">
			<a href="<?=$_adm_url?>/_adm.php" class="tab <?=!$pn?'active':''?>">기본설정</a>
			<a href="<?=$_adm_url?>/_adm.php?pn=shop_header" class="tab <?=$pn=='shop_header'?'active':''?>">헤더 관리</a>
			<a href="<?=$_adm_url?>/_adm.php?pn=itemtype" class="tab <?=$pn=='itemtype'?'active':''?>">상품유형</a>			
			<!--<a href="<?=$_adm_url?>/_adm.php?pn=mainpage" class="tab <?=$pn=='mainpage'?'active':''?>">메인페이지</a>-->
			<a href="<?=$_adm_url?>/_adm.php?pn=shop_footer" class="tab <?=$pn=='shop_footer'?'active':''?>">카피라이트 관리</a>
		</div>
		<div class="tabs-group">
			<a href="<?=$_adm_url?>/_adm.php?pn=shop_banner" class="tab <?=$pn=='shop_banner'?'active':''?>">쇼핑몰 배너관리</a>
		</div>
		<div class="tabs-group">
			<a href="<?=$_adm_url?>/_adm.php?pn=defStyle" class="tab <?=$pn=='defStyle'?'active':''?>">사이트 기본스타일</a>
		</div>
	</div>
	<?php include_once($adm_file); ?>
</div>

<script>
function _adm_form_submit(f){
    return true;
}

$('.box-tabs-container a').click(function() {
	let menu = $(this).text();
	if(menu == '헤더관리(사이드)' || menu == '메인메뉴') {
		opener.$('.quickNews_closer').click();
		opener.$('.leftSecOpener').click();
	} else if(menu == '퀵뉴스') {
		opener.$('.sideSection .closer').click();
		opener.$('.quickNews_opener').click();
	} else {
		opener.$('.sideSection .closer').click();
		opener.$('.quickNews_closer').click();
	}
});


<?php if($pn == 'mainmenu') { ?>
	window.resizeTo(1450,850);
<?php } else if($pn == 'boStyle') { ?>
	window.resizeTo(1320,880);
<?php } else if($pn == 'quicknews') { ?>
	window.resizeTo(1120,900);
<?php } else { ?>
	window.resizeTo(1250,720);
<?php } ?>
</script>

</body>
</html>
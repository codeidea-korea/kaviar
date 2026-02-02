<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/shop_block.lib.php');

$pn_id = isset($_GET['pn_id']) ? $_GET['pn_id'] : '';
if(strpos($_SERVER[ "REQUEST_URI" ], 'shop/page/') !== false) {
	$pn_id = basename( $_SERVER[ "PHP_SELF" ] );
}

if(!$pn_id) {
	alert('페이지가 없습니다.', G5_SHOP_URL);
}

$shop_page = sql_fetch(" select * from {$g5['g5_shop_page_table']} where pn_id='".$pn_id."'");

if($shop_page['pn_subject']) {
	$topMenu_skip = true;
	$is_back = true;
	$head_title = $shop_page['pn_subject'];
}

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');



if ($shop_page['pn_id']) {

	if($is_shop_manager) {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate='.$pn_id.'&title=쇼핑몰 페이지 관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopIndexSetting" class="btnSetting popWin'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#container">쇼핑몰 페이지 관리</a>';
		if($pn=='_view_adm') echo '<div id="_view_adm_msg" class="mobile-max-width"><span class="msg">보고계신 페이지는<br>관리자 확인용 페이지입니다.</span></div>';
	}

	echo '<article id="shopIndex">';	
		echo shop_block($pn_id);
	echo '</article>';

} else {
	if($is_shop_manager) {

		echo '<div class="_adm_btnSet" style="position:absolute;top:0;left:0;width:100%;height:100%;min-height:300px;display:flex;align-items:center;justify-content:center;">';
		echo '<div class="_btn/md/black page_write" data-pn-id="'.$pn_id.'">페이지 등록</div>';
		echo '</div>';
		echo '
		<script>
		$(".page_write").click(function() {
			var pn_id = $(this).attr("data-pn-id");
			$.post("'.G5_SHOP_URL.'/page_update.php",{pn_id:pn_id}, function (response) {
				document.location.reload();
			});
		});
		</script>';
	} else {
		alert('페이지가 없습니다.', G5_SHOP_URL);
	}
}


include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
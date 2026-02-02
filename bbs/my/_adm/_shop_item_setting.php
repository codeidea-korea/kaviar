<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// 파일체크
$itempn = $itempn ? $itempn : 'item_img';
switch($itempn) {
	default									: $inc_file = $_adm_inc_path.'/_shop_'.$itempn.'.php'; break;
}
?>

<div class="box-tabs-container">

	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=상품 관리&it_id=<?=$it_id?>&itempn=item_img" class="tab <?=$itempn=='item_img'?'active':''?>" data-resize="810,600">상품 이미지 관리</a>
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=상품 관리&it_id=<?=$it_id?>&itempn=item_config" class="tab <?=$itempn=='item_config'?'active':''?>" data-resize="940,680">상품 기본정보 관리</a>
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=상품 관리&it_id=<?=$it_id?>&itempn=item_relation" class="tab <?=$itempn=='item_relation'?'active':''?>" data-resize="1450,900">관련상품</a>
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=상품 관리&it_id=<?=$it_id?>&itempn=item_content" class="tab <?=$itempn=='item_content'?'active':''?>" data-resize="755,900">상품상세 편집</a>		
	</div>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=관련 이벤트&it_id=<?=$it_id?>&itempn=item_event" class="tab <?=$itempn=='item_event'?'active':''?>" data-resize="1450,900">관련 이벤트</a>
	</div>
	<?php if(sql_query(" DESCRIBE {$g5['g5_shop_store_table']} ", false)) { ?>
	<div class="tabs-group">
		<a href="<?=$_adm_url?>/?pn=_shop_item_setting&title=상품 관리&it_id=<?=$it_id?>&itempn=item_store" class="tab <?=$itempn=='item_store'?'active':''?>" data-resize="1100,700">지점 선택</a>
	</div>
	<?php } ?>
</div>


<?php include_once($inc_file); ?>


<script>
$('.box-tabs-container a').click(function() {
	let resize = $(this).attr('data-resize').split(',');
	
	if(resize) {
		window.resizeTo(resize[0], resize[1]);
	}
});
</script>
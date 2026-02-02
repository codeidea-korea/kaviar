<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
//include_once('../../../_common.php');


$tabs_items_cate_arr = explode(",", $shopblock['tabs_items_cate']);
for ($j=0; $j<count($tabs_items_cate_arr); $j++) {
	$tabs_items_cate .= '<a onclick="get_bl_'.$bl_id.'_items_ajax(\''.$tabs_items_cate_arr[$j].'\')" class="tab'.($j==0?' active':'').'">'.get_shop_cate($tabs_items_cate_arr[$j]).'</a>';
}
$tabs_items_cate = $tabs_items_cate ? '<div class="tabs_items_cate">'.$tabs_items_cate.'</div>' : '';

echo $tabs_items_cate;
?>


<div class="_get_itemsContainer"></div>



<?php if($shopblock['tabs_items_cate']) { ?>
<script>
// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
//인태 - _get_items.php 에서 상품 진열 로드가 안되고 있음..
// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
function get_bl_<?=$bl_id?>_items_ajax(val){
	$.ajax({
		url: '<?=G5_SHOP_URL?>/_get_items.php',
		type: 'post',
		dataType: 'html',
		data:{
			"bl_id" : <?=$bl_id?>,
			"ca_id" : val,
			},
		success: function(res){
			$("#section-<?=$bl_id?> ._get_itemsContainer").html(res);
		}
	});
}
$('.tabs_items_cate .tab').click(function() {
	$(this).parent().find('.tab').removeClass('active');
	$(this).addClass('active');
});

$(document).ready(function(){
	get_bl_<?=$bl_id?>_items_ajax('<?=$tabs_items_cate_arr[0]?>');
});
</script>
<?php } ?>
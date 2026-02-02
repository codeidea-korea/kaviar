<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$it = get_shop_item($it_id);



function get_item_mini($it_id) {
	global $g5;
	$it = get_shop_item($it_id);

	$item_mini = '';

	$itemImg = get_it_image($it['it_id'], 100, 100);
	$ca_name1 = get_shopCate_name($it['ca_id']);
	$ca_name2 = get_shopCate_name($it['ca_id2']);
	$ca_name3 = get_shopCate_name($it['ca_id3']);
	$ca_name = '';
	$ca_name .= $ca_name1 ? '<span>'.$ca_name1.'</span>' : '';
	$ca_name .= $ca_name2 ? '<span>'.$ca_name2.'</span>' : '';
	$ca_name .= $ca_name3 ? '<span>'.$ca_name3.'</span>' : '';

	$item_mini .= '<div id="item_mini">';					
		$item_mini .= '<div class="wzContents gap10">';							
			if($itemImg) $item_mini .= '<div class="wz_thumb">'.$itemImg.'</div>';			
			$item_mini .= '<div class="wz_con gap5 column flex-top">';
				if($ca_name) $item_mini .= '<div class="ca_name_set">'.$ca_name.'</div>';
				$item_mini .= '<div class="fs12 bold">';
					$item_mini .= htmlspecialchars2(cut_str($it['it_name'],250, ""));
				$item_mini .= '</div>';
				$item_mini .= '<div class="flex flex-middle gap10">';
					$item_mini .= '<div class="middleline price">'.display_price($it['it_cust_price']).'</div>';
					$item_mini .= '<div class="color-red bold price">'.display_price(get_price($it)).'</div>';
				$item_mini .= '</div>';							
				for ($t=0; $t < count($itemtype); $t++) {
					$num = $t + 1;
					if($it['it_type'.$num]) {
						$_gettype .= '<sub class="tag-itemtype" style="font-size:10px;height:15px;padding:0 4px;border-radius:4px;background:rgba(71,78,103,0.4);color:#fff !important;display:inline-flex;align-items:center;justify-content:center;">'.$itemtype[$t].'</sub>';
					}
				}
				if($_gettype) $item_mini .= '<div class="inline-flex flex-middle gap5 mt-auto">'.$_gettype.'</div>';

			$item_mini .= '</div>';
		$item_mini .= '</div>';
	$item_mini .= '</div>';

	
	return $item_mini;
}




$item_info1_subject = explode("|", $it['item_info1_subject']);
$item_info1_value = explode("|", $it['item_info1_value']);

$item_info2_subject = explode("|", $it['item_info2_subject']);
$item_info2_value = explode("|", $it['item_info2_value']);

$item_info3_subject = explode("|", $it['item_info3_subject']);
$item_info3_value = explode("|", $it['item_info3_value']);
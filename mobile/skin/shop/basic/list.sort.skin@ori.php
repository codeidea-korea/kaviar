<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';

if($ca_id) {
	$shop_category_url = shop_category_url($ca_id);
    $sct_sort_href = (strpos($shop_category_url, '?') === false) ? $shop_category_url.'?1=1' : $shop_category_url;
} else if($ev_id) {
    $sct_sort_href .= 'ev_id='.$ev_id;
}

//if($skin) $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

$sort = $_GET['sort'];
$sortodr = $_GET['sortodr'];
?>

<section id="_itemsSort">
	<select class="select-link selectpicker">
		<option value="<?=$sct_sort_href?>"<?=$sort==''?' selected':''?>>상품정렬</option>
		<option value="<?=$sct_sort_href?>it_real_price&amp;sortodr=asc"<?=$sort=='it_real_price'&&$sortodr=='asc'?' selected':''?>>낮은가격순</option>
		<option value="<?=$sct_sort_href?>it_real_price&amp;sortodr=desc"<?=$sort=='it_real_price'&&$sortodr=='desc'?' selected':''?>>높은가격순</option>
		<option value="<?=$sct_sort_href?>it_name&amp;sortodr=asc"<?=$sort=='it_name'&&$sortodr=='asc'?' selected':''?>>상품명순</option>
		<option value="<?=$sct_sort_href?>it_hit&amp;sortodr=desc"<?=$sort=='it_hit'?' selected':''?>>조회수순</option>
		
	</select>
</section>
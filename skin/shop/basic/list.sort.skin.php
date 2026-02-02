<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';

if($ca_id) {
	$shop_category_url = shop_category_url($ca_id);
    $sct_sort_href = (strpos($shop_category_url, '?') === false) ? $shop_category_url.'?1=1' : $shop_category_url;
} else if($ev_id) {
    $sct_sort_href .= 'ev_id='.$ev_id;
}

if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);
?>

<section id="_sct_sort">
    <ul>
		<li><a href="<?php echo $sct_sort_href; ?>it_update_time&amp;sortodr=desc"<?=$_GET['sort']=='it_update_time'?' class="active"':''?>>신상품순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc"<?=$_GET['sort']=='it_sum_qty'?' class="active"':''?>>판매량순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc"<?=$_GET['sort']=='it_price'&&$_GET['sortodr']=='asc'?' class="active"':''?>>낮은가격순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc"<?=$_GET['sort']=='it_price'&&$_GET['sortodr']=='desc'?' class="active"':''?>>높은가격순</a></li>
    </ul>
</section>
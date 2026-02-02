<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$sql = " select * from {$g5['g5_shop_store_table']}
          where store_id = '$store_id'
            and store_use = 1 ";
$store = sql_fetch($sql);
if (! (isset($store['store_id']) && $store['store_id']))
    alert('등록된 '.$store_label.'이 없습니다.');
?>

<div id="_shopStore">
	<?php
	//상단에 상품 카테고리 출력
	echo '<div id="_store_topCate" class="scroll-fixed" style="top:var(--header-height);">';
		echo get_shopCate_list("slide|auto|12", $img=false, $all=true, $class="shopCate-tags", shop_short_url_my('shopStore','','store_id='.$store['store_id']));
	echo '</div>';

	include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
	echo '<div id="shopblock">';
		if($is_admin) {
			echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=store'.$store['store_id'].'&title=블럭관리" id="shopblockSetting" style="top:0;" class="btnSetting popWin" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">블럭관리</a>';
		}
		echo shop_block('store'.$store['store_id']);
	echo '</div>';
	?>
	<div class="_store_item_list">
		<?php
		if($is_admin) echo '<a href="'.$_adm_url.'/?pn=_shop_store_item&title=지점 상품 관리&store_id='.$store_id.'" id="storeItemSetting2" class="btnSetting popWin" style="top:50px;left:-40px" data-width="1250" data-height="900" data-top="60" data-left="0" data-area="#_shopStore ._store_item_list" title="지점 상품 관리">지점 상품 관리</a>';

		$skin = 'list.10.skin.php';
		$list_mod = $store['store_wr1'] ? $store['store_wr1'] : 3; //가로수
		$list_row = $store['store_wr2'] ? $store['store_wr2'] : 5; //줄수

		$items = $list_mod * $list_row;
		if ($page < 1) $page = 1;
		$from_record = ($page - 1) * $items;

		$list = new item_list(G5_MSHOP_SKIN_PATH.'/'.$skin, $list_mod, $list_row, 230, 230);
		$list->set_store($store['store_id']);	
		$list->set_is_page(true);
		$list->set_mobile(true);
		$list->set_category($ca_id, 1);
        $list->set_category($ca_id, 2);
        $list->set_category($ca_id, 3);
		$list->set_order_by($order_by);
		$list->set_from_record($from_record);
		$list->set_view('it_img', true);
		$list->set_view('it_id', false);
		$list->set_view('it_name', true);
		$list->set_view('it_cust_price', false);
		$list->set_view('it_price', true);
		$list->set_view('it_icon', true);
		$list->set_view('sns', true);
		echo $list->run();

		// where 된 전체 상품수
		$total_count = $list->total_count;
		// 전체 페이지 계산
		$total_page  = ceil($total_count / $items);

		$qstr .= 'skin='.$skin.'&amp;store_id='.$store['store_id'].'&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
		echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");
		?>
	</div>
	
	<div class="shop_btnSet p20 mt20">
		<a href="<?=shop_short_url_my('shopStore')?>" class="_btn/lg/line w-full"><?=$store_label?> 목록</a>
		<?php if($is_admin) echo '<a href="'.shop_short_url_my('shopStore_write','','w=u&amp;store_id='.$store['store_id']).'" class="_btn/lg/green w-full">수정</a>'; ?>
	</div>
</div>

<?php
include_once('./_common.php');
define("_WISHLIST_", true);

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL.'/wishlist.php'));

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/wishlist.php');
    return;
}

// 테마에 wishlist.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_wishlist_file = G5_THEME_SHOP_PATH.'/wishlist.php';
    if(is_file($theme_wishlist_file)) {
        include_once($theme_wishlist_file);
        return;
        unset($theme_wishlist_file);
    }
}

$g5['title'] = "위시리스트";
include_once('./_head.php');
?>

<!-- 위시리스트 시작 { -->
<div id="sod_ws">
	
	<?php include_once(G5_SHOP_PATH.'/_my_head.php'); ?>

	<div id="_myContainer" class="max-width">
		<?php include_once(G5_SHOP_PATH.'/_my_gnb.php'); ?>
		<div id="_myContainer_con">
			<div class="_myCon_title border-bottom/2">찜한상품<sub>최근 주문하신 3개월 이내의 내역만 보여집니다</sub></div>

			<form name="fwishlist" method="post" action="./cartupdate.php">
			<input type="hidden" name="act" value="multi">
			<input type="hidden" name="sw_direct" value="">
			<input type="hidden" name="prog" value="wish">

			<ul id="wish_li">
				<?php
				$sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
				$sql .= " where a.mb_id = '{$member['mb_id']}' order by a.wi_id desc ";
				$result = sql_query($sql);
				for ($i=0; $row = sql_fetch_array($result); $i++) {

					$out_cd = '';
					$sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
					$tmp = sql_fetch($sql);
					if(isset($tmp['cnt']) && $tmp['cnt'])
						$out_cd = 'no';

					$it_price = get_price($row);

					if ($row['it_tel_inq']) $out_cd = 'tel_inq';

					$image = get_it_image($row['it_id'], 80, get_it_height(80));
				?>
				<li>
					<div class="wish_chk">
						<?php if(is_soldout($row['it_id'])) { // 품절검사
							echo '<span class="sold_out">품절</span>';
						} else {
							echo '<div class="chk_box">';
								echo '<input type="checkbox" name="chk_it_id['.$i.']" value="1" id="chk_it_id_'.$i.'" onclick="out_cd_check(this, \''.$out_cd.'\');" class="selec_chk circle">';
							echo '</div>';
						} ?>
						<input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
						<input type="hidden" name="io_type[<?php echo $row['it_id']; ?>][0]" value="0">
						<input type="hidden" name="io_id[<?php echo $row['it_id']; ?>][0]" value="">
						<input type="hidden" name="io_value[<?php echo $row['it_id']; ?>][0]" value="<?php echo $row['it_name']; ?>">
						<input type="hidden" name="ct_qty[<?php echo $row['it_id']; ?>][0]" value="1">
					</div>
					<div class="wish_img"><a href="<?php echo shop_item_url($row['it_id']); ?>"><?php echo $image; ?></a></div>
					<div class="wish_info">
						<a href="<?php echo shop_item_url($row['it_id']); ?>" class="wish_prd"><?php echo stripslashes($row['it_name']); ?></a>
						<?php
						echo '<div class="priceInfo">';
							$discount_rate = round(($row['it_cust_price'] - get_price($row)) / $row['it_cust_price'] * 100);
							if($row['it_cust_price']) echo '<span class="rate">'.$discount_rate.'%</span>';				
							echo '<span class="price">'.display_price(get_price($row), $row['it_tel_inq']).'</span>';
							if($row['it_cust_price']) echo '<span class="price before">'.display_price($row['it_cust_price']).'</span>';
						echo '</div>';
						?>
						<span class="info_date"><?php echo substr($row['wi_time'], 2, 17); ?></span>                
					</div>
					<div class="wish_del">
						<a href="<?=G5_SHOP_URL?>/wishupdate.php?w=d&amp;wi_id=<?=$row['wi_id']?>" class="_btn/sm/line/transparent">삭제</a>
					</div>
				</li>
				<?php
				}

				if ($i == 0)
					echo '<li class="empty_table">찜한상품이 없습니다.</li>';
				?>
			</ul>

			<div id="sod_ws_act" class="mt50">
				<button type="submit" class="_btn/lg/rd5/line/mainColor/transparent w-200 btnCart" onclick="return fwishlist_check(document.fwishlist,'');">장바구니</button>
				<button type="submit" class="_btn/lg/rd5 w-200" onclick="return fwishlist_check(document.fwishlist,'direct_buy');">바로구매</button>				
			</div>

			</form>
		
		</div>
	</div>
</div>

<script>

    function out_cd_check(fld, out_cd)
    {
        if (out_cd == 'no'){
            alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel_inq'){
            alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    function fwishlist_check(f, act)
    {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0)
        {
            alert("상품을 하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy")
        {
            f.sw_direct.value = 1;
        }
        else
        {
            f.sw_direct.value = 0;
        }

        return true;
    }

</script>
<!-- } 위시리스트 끝 -->

<?php
include_once('./_tail.php');
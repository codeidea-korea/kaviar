<?php
include_once('./_common.php');
$naverpay_button_js = '';
include_once(G5_SHOP_PATH.'/settle_naverpay.inc.php');

//인태
if(file_exists(G5_THIS_PATH.'/shop/cart.php')) {
	require_once(G5_THIS_PATH.'/shop/cart.php');
	return;
}

// 보관기간이 지난 상품 삭제
cart_item_clean();

$sw_direct = isset($_REQUEST['sw_direct']) ? (int) $_REQUEST['sw_direct'] : 0;

// cart id 설정
set_cart_id($sw_direct);

$s_cart_id = get_session('ss_cart_id');
// 선택필드 초기화
$sql = " update {$g5['g5_shop_cart_table']} set ct_select = '0' where od_id = '$s_cart_id' ";
sql_query($sql);

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

if(function_exists('before_check_cart_price')) {
    before_check_cart_price($s_cart_id, true, true, true);
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/cart.php');
    return;
}

if(file_exists(G5_THIS_SHOP_PATH.'/cart.php')) {
	require_once(G5_THIS_SHOP_PATH.'/cart.php');
	return;
}

// 테마에 cart.php 있으면 include
if(defined('G5_THEME_SHOP_PATH')) {
    $theme_cart_file = G5_THEME_SHOP_PATH.'/cart.php';
    if(is_file($theme_cart_file)) {
        include_once($theme_cart_file);
        return;
        unset($theme_cart_file);
    }
}

$g5['title'] = '장바구니';
include_once('./_head.php');
?>

<!-- 장바구니 시작 { -->
<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>

<div id="sod_bsk" class="od_prd_list max-width">
	
	<h1 id="_page_title">장바구니</h1>
	
    <form name="frmcartlist" id="sod_bsk_list" class="2017_renewal_itemform" method="post" action="<?php echo $cart_action_url; ?>">

	<div id="_sod_bsk_inner">
		<div id="_sod_bsk_list">
			<div id="_bsk_head">
				<input type="checkbox" name="ct_all" value="1" id="ct_all" checked="checked" class="selec_chk circle" data-label="전체선택">				
				<button type="button" onclick="return form_check('seldelete');">선택삭제</button>
				<button type="button" onclick="return form_check('alldelete');">비우기</button>

			</div>
			<ul class="sod_list">
				<?php
				$tot_point = 0;
				$tot_sell_price = 0;
				$tot_sale_price = 0;
				$send_cost = 0;
				$tot_origin_price = 0;

				// $s_cart_id 로 현재 장바구니 자료 쿼리
				$sql = " select a.ct_id,
								a.it_id,
								a.it_name,
								a.ct_price,
								a.ct_point,
								a.ct_qty,
								a.ct_status,
								a.ct_send_cost,
								a.it_sc_type,
								b.ca_id,
								b.ca_id2,
								b.ca_id3,
								a.ct_time_price,
								a.ct_origin_price
						   from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
						  where a.od_id = '$s_cart_id' ";
				$sql .= " group by a.it_id ";
				$sql .= " order by a.ct_id ";
				$result = sql_query($sql);

				$it_send_cost = 0;
				

					echo '<li>';
						echo '<div class="li_chk" style="width:25px">';
						echo '</div>';
						echo '<div class="li_img sod_img" style="width:80px">';
						echo '</div>';
						echo '<div class="li_name sod_name" style="width:251px">';
						echo '</div>';
						echo '<div class="li_qty" style="width:117px">';
							echo "수량";
						echo '</div>';
						echo '<div class="li_ct_price">';
							echo "정상판매가";
						echo '</div>';
						echo '<div class="li_discount">';
							echo "할인금액";
						echo '</div>';
						echo '<div class="li_point">';
							echo "적립금";
						echo '</div>';
						echo '<div class="li_dvr">';
							echo "배송비";
						echo '</div>';
						echo '<div class="li_total">';
							echo '결제금액';
						echo '</div>';
					echo '</li>';
				for ($i=0; $row=sql_fetch_array($result); $i++) {
					// 합계금액 계산
					$sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
									SUM(ct_point) as point,
									SUM(ct_qty) as qty
								from {$g5['g5_shop_cart_table']}
								where it_id = '{$row['it_id']}'
								  and od_id = '$s_cart_id' ";
					$sum = sql_fetch($sql);

					if ($i==0) { // 계속쇼핑
						$continue_ca_id = $row['ca_id'];
					}

					$a1 = '<a href="'.shop_item_url($row['it_id']).'" class="prd_name">';
					$a2 = '</a>';
					$image = get_it_image($row['it_id'], 80, get_it_height(80));

					$it_name = $a1 . stripslashes($row['it_name']) . $a2;
					$it_options = print_item_options($row['it_id'], $s_cart_id);
					if($it_options) {
						$mod_options = '<div class="sod_option_btn"><button type="button" class="mod_options">옵션/수량 수정</button></div>';
						$it_name .= '<div class="sod_opt">'.$it_options.'</div>';
					}

					// 배송비
					switch($row['ct_send_cost']) {
						case 1:
							$ct_send_cost = '착불';
							break;
						case 2:
							$ct_send_cost = '무료';
							break;
						default:
							$ct_send_cost = '선불';
							break;
					}

					// 조건부무료
					if($row['it_sc_type'] == 2) {
						$sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $s_cart_id);

						if($sendcost == 0)
							$ct_send_cost = '무료';
					}

					$point      = $sum['point'];
					$sell_price = $sum['price'];


					echo '<li>';
						echo '<div class="li_chk">';
							echo '<input type="checkbox" name="ct_chk['.$i.']" value="1" id="ct_chk_'.$i.'" checked="checked" class="selec_chk circle">';
						echo '</div>';
						echo '<div class="li_img sod_img">';
							echo '<a href="'.shop_item_url($row['it_id']).'">'.$image.'</a>';
						echo '</div>';
						echo '<div class="li_name sod_name">';
							echo '<input type="hidden" name="it_id['.$i.']" value="'.$row['it_id'].'">';
							echo '<input type="hidden" name="it_name['.$i.']" value="'.get_text($row['it_name']).'">';
							//echo $it_name.$mod_options;
							echo $it_name;
						echo '</div>';
						echo '<div class="li_qty">';
						?>

					<input type="hidden" id="ct_id_<?=$i?>" name="ct_id[<?=$i?>]" value="<?php echo $row['ct_id']; ?>">
					<input type="hidden" id="it_id_<?=$i?>" name="it_id[<?=$i?>]" value="<?php echo $row['it_id']; ?>">







				
					


		
				
				<div class="count-wrap _count">
					<button type="button" class="minus" value="<?=$i?>" onclick="qtybt('minus',<?=$i?>)">-</button>
					<input type="text" class="inp" id="inp_<?=$i?>" name="inp[<?=$i?>]" value="<?=number_format($sum['qty'])?>" readonly/>
					<button type="button" class="plus" value="<?=$i?>"  onclick="qtybt('plus',<?=$i?>)">+</button>
				</div>
				

<style>
.count-wrap{border:1px solid #ddd;flex-wrap: nowrap;display:flex;justify-content: space-evenly;align-items: center;}
.count-wrap > button{border: 0;background: #ddd;color: #000;width:26px;height:38px;font-size:20px;font-weight:500;}
.count-wrap > button.minus {}
.count-wrap > button.plus {font-size:20px;font-weight:500}
.count-wrap .inp {flex:1;border:0;height:38px;text-align:center;width:50px;font-size:15px;}
</style>






						<?php
							
						echo '</div>';
						echo '<div class="li_ct_price">';
							echo number_format($row['ct_origin_price'] * $sum['qty']);
						echo '</div>';
						echo '<div class="li_ct_discount" style="font-size:14px;width:50px;text-align:center;">';
							$cnt = 0;
							$mem_p = 0;
							$time_p = 0;
							if($row['ct_time_price'] > 0){
								$time_p = $row['ct_origin_price'] - $row['ct_price'];
								echo "타임특가<br> -".number_format($time_p * $row['ct_qty']);
								$cnt = 1;
							}else if($member['mb_grade'] == 6){
								if($row['ct_price'] != $row['ct_origin_price']){
									$mem_p = $row['ct_origin_price'] - $row['ct_price'];
									echo "임직원할인<br> -".number_format($mem_p * $row['ct_qty']);
								}else{
									$mem_p = 0;
									echo "0";
								}
							}else if($row['ct_price'] != $row['ct_origin_price']){
								$mem_p = $row['ct_origin_price'] - $row['ct_price'];
								echo "할인<br> -".number_format($mem_p * $row['ct_qty']);
							}else{
								echo "0";
							}
						
							
							$sale_price = ($row['ct_origin_price'] - $row['ct_price']) * $row['ct_qty'];
							//echo number_format($sale_price);
						echo '</div>';
						echo '<div class="li_point">';
							echo number_format($point * $row['ct_qty'] );
							$tot_point_price = $point * $row['ct_qty'];
						echo '</div>';
						echo '<div class="li_dvr">';
							echo $ct_send_cost;
						echo '</div>';
						echo '<div class="li_total">';
							echo '<span id="sell_price_'.$i.'" class="total_prc">'.number_format($sell_price).'</span>';
						echo '</div>';
					echo '</li>';
					 
					$tot_point      += $tot_point_price;
					$tot_sell_price += $sell_price;
					$tot_sale_price += $sale_price;
					$tot_origin_price += ($row['ct_origin_price'] * $row['ct_qty']);
				} // for 끝

				if ($i == 0) {
					echo '<li class="empty_list">장바구니에 담긴 상품이 없습니다.</li>';
				} else {
					// 배송비 계산
					$send_cost = get_sendcost($s_cart_id, 0);
				}				
				?>
			</ul>			
		</div>
		
		<div id="_sod_bsk_right">
			<?php
			$tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
			if ($tot_price > 0 || $send_cost > 0) {
			?>
			<div id="sod_bsk_tot">
				<ul>
					<li class="sod_bsk_dvr">
						<span>상품금액</span>
						<strong><?php echo number_format($tot_origin_price); ?></strong> 원
					</li>
					<li class="sod_bsk_dvr">
						<span>할인금액</span>
						<strong><?php echo number_format($tot_sale_price); ?></strong> 원
					</li>
					<li class="sod_bsk_dvr">
						<span>배송비</span>
						<strong><?php echo number_format($send_cost); ?></strong> 원
					</li>
					<li class="sod_bsk_pt">
						<span>적립금</span>
						<strong><?php echo number_format($tot_point); ?></strong> 점
					</li>
					<li class="sod_bsk_cnt">
						<span>총 결제금액</span>
						<strong><?php echo number_format($tot_price); ?>원</strong>
					</li>
				</ul>
			</div>
			<?php } ?>

			<div id="sod_bsk_act">
				<?php if ($i == 0) { ?>
				<a href="<?php echo G5_SHOP_URL; ?>/" class="btn01">쇼핑 계속하기</a>
				<?php } else { ?>
				<input type="hidden" name="url" value="./orderform.php">
				<input type="hidden" name="records" value="<?php echo $i; ?>">
				<input type="hidden" name="act" value="">				
				<button type="button" onclick="return form_check('buy');" class="btn_submit">주문하기</button>
				<a href="<?php echo shop_category_url($continue_ca_id); ?>" class="btn01">쇼핑 계속하기</a>
				<?php if ($naverpay_button_js) { ?>
				<div class="cart-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
				<?php } ?>
				<?php } ?>
			</div>
		</div>
	</div>
    </form>
</div>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).closest("li").find("input[name^=it_id]").val();
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#mod_option_frm").remove();
                $this.after("<div id=\"mod_option_frm\"></div><div class=\"mod_option_bg\"></div>");
                $("#mod_option_frm").html(data);
                price_calculate();
            }
        );
    });

    // 모두선택
    $("input[name=ct_all]").click(function() {
        if($(this).is(":checked"))
            $("input[name^=ct_chk]").attr("checked", true);
        else
            $("input[name^=ct_chk]").attr("checked", false);
    });

    // 옵션수정 닫기
    $(document).on("click", "#mod_option_close", function() {
        $("#mod_option_frm, .mod_option_bg").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#mod_option_frm").remove();
        $(".mod_options").eq(close_btn_idx).focus();
    });

});

function fsubmit_check(f) {
    if($("input[name^=ct_chk]:checked").length < 1) {
        alert("구매하실 상품을 하나이상 선택해 주십시오.");
        return false;
    }

    return true;
}

function form_check(act) {
    var f = document.frmcartlist;
    var cnt = f.records.value;

    if (act == "buy")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("주문하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }
    else if (act == "alldelete")
    {
        f.act.value = act;
        f.submit();
    }
    else if (act == "seldelete")
    {
        if($("input[name^=ct_chk]:checked").length < 1) {
            alert("삭제하실 상품을 하나이상 선택해 주십시오.");
            return false;
        }

        f.act.value = act;
        f.submit();
    }

    return true;
}
</script>
<!-- } 장바구니 끝 -->


<script>
//수량 옵션
	function qtybt(btype,ii)
	{	
		var inp = $("#inp_"+ii).val()

		//alert(btype+ " / " + ii + " / " + inp);
       
        var now = parseInt(inp);

		
        var min = 1;
        var max = 999;
        var num = now;

		//alert(num)

        if(btype == 'minus'){
            var type = 'm';
        }else{
            var type = 'p';
        }
        if(type=='m'){
            if(now>min){
                num = now - 1;
            }
        }else{
            if(now<max){
                num = now + 1;
            }
        }
		
        if(num != now){       
			$("#inp_"+ii).val(num);			
        }
		
		
				

		$.ajax({
			  url:'cart_qty.php?ii='+ii,
			  type:'POST',
			  data:$("#sod_bsk_list").serialize(),

			  cache: false,
			  async: false,
			  dataType : 'json',
			  success: function(res) {
					//$('#Context').html(data);
					/*
					if(!res.error){
						alert("쿠폰이 등록되었습니다");
					}else{
						alert(res.error);
					}*/
					console.log(res);

					reload();
				}
			});


	}	

	function reload(){
		location.href=location.href;
	}
</script>
<?php
include_once('./_tail.php');

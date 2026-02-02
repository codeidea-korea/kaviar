<?php
include_once('./_common.php');

$cart_action_url = G5_SHOP_URL.'/cartupdate.php';

// 테마에 cart.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_cart_file = file_exists(G5_THEME_MSHOP_PATH.'/cart.php') ? G5_THEME_MSHOP_PATH.'/cart.php' : G5_THEME_SHOP_PATH.'/cart.php';
    if(is_file($theme_cart_file)) {
        include_once($theme_cart_file);
        return;
        unset($theme_cart_file);
    }
}

$g5['title'] = '장바구니';
$head_title = '장바구니';
$topMenu_skip = true;
include_once(G5_MSHOP_PATH.'/_head.php');

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
                b.ca_id
           from {$g5['g5_shop_cart_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
          where a.od_id = '$s_cart_id' ";
$sql .= " group by a.it_id ";
$sql .= " order by a.ct_id ";
$result = sql_query($sql);

$cart_count = sql_num_rows($result);
?>

<script src="<?php echo G5_JS_URL; ?>/shop.js"></script>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>

<div id="sod_bsk">

	<div id="mypage_banner" class="bottom relative">
		<?php echo shop_banner('장바구니', '_block_banner.skin.php'); ?>
		<?php if($is_shop_manager) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=장바구니&title=쇼핑몰 배너관리" class="btnSetting light popWin" style="top:5px;right:-25px;" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="#mypage_banner">쇼핑몰 배너관리</a>';?>
	</div>

    <form name="frmcartlist" id="sod_bsk_list" method="post" action="<?php echo $cart_action_url; ?>">

    <?php if($cart_count) { ?>
    <div id="sod_head" class="chk_box">
        <label class="checkbox-label"><input type="checkbox" name="ct_all" value="1" id="ct_all" class="selec_chk circle" checked><span></span>전체 선택</label>
		<div class="btn_del_wr">
			<button type="button" onclick="return form_check('seldelete');" class="">선택삭제</button>
			<button type="button" onclick="return form_check('alldelete');" class="">비우기</button>
		</div>
    </div>
    <?php } ?>

    <ul class="sod_list">
        <?php
        $tot_point = 0;
        $tot_sell_price = 0;
        $it_send_cost = 0;

        for ($i=0; $row=sql_fetch_array($result); $i++) {
            // 합계금액 계산
            $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price,
                            SUM(ct_point * ct_qty) as point,
                            SUM(ct_qty) as qty
                        from {$g5['g5_shop_cart_table']}
                        where it_id = '{$row['it_id']}'
                          and od_id = '$s_cart_id' ";
            $sum = sql_fetch($sql);

            if ($i==0) { // 계속쇼핑
                $continue_ca_id = $row['ca_id'];
            }

            $a1 = '<a href="'.shop_item_url($row['it_id']).'"><strong>';
            $a2 = '</strong></a>';
            $image_width = 90;
            $image_height = get_it_height(90);
            $image = get_it_image($row['it_id'], $image_width, $image_height);

            $it_name = $a1 . stripslashes($row['it_name']) . $a2;
            $it_options = print_item_options($row['it_id'], $s_cart_id);
            if($it_options) {
                $mod_options = '<button type="button" id="mod_opt_'.$row['it_id'].'" class="_btn/sm/line/gray/transparent px10 mod_options">옵션/수량 수정</button>';
               // $it_name .= ;
            }

            // 배송비
            switch($row['ct_send_cost'])
            {
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
        ?>

        <li class="sod_li">
            <input type="hidden" name="it_id[<?php echo $i; ?>]"    value="<?php echo $row['it_id']; ?>">
            <input type="hidden" name="it_name[<?php echo $i; ?>]"  value="<?php echo get_text($row['it_name']); ?>">

            <div class="li_op_wr">
				<div class="li_op_item">
					<label class="checkbox-label"><input type="checkbox" name="ct_chk[<?php echo $i; ?>]" value="1" id="ct_chk_<?php echo $i; ?>" class="selec_chk circle" checked><span></span><b class="sound_only">상품선택</b></label>
					<a href="<?php echo shop_item_url($row['it_id']); ?>" class="total_img"><?php echo $image; ?></a>
					<div class="itemCon">
						<a href="<?php echo shop_item_url($row['it_id']); ?>" class="li_name"><?php echo $row['it_name']; ?></a>
						<div class="li_mod">
                            <!-- 기존 주석처리 -->
                            <!-- <?php echo $mod_options; ?> -->
                            <!-- 수량추가 -->
                            <div class="count-wrap _count">
                                <button type="button" class="minus" value="<?=$i?>" onclick="qtybt('minus',<?=$i?>)">-</button>
                                <input type="text" class="inp" id="inp_<?=$i?>" name="inp[<?=$i?>]" value="<?=number_format($sum['qty'])?>" readonly="">
                                <button type="button" class="plus" value="<?=$i?>"  onclick="qtybt('plus',<?=$i?>)">+</button>
                            </div>
							<input type="hidden" id="ct_id_<?=$i?>" name="ct_id[<?=$i?>]" value="<?php echo $row['ct_id']; ?>">
							<input type="hidden" id="it_id_<?=$i?>" name="it_id[<?=$i?>]" value="<?php echo $row['it_id']; ?>">
					

                        </div>
						<!-- <div class="sod_opt"><?php echo $it_options; ?></div> -->
					</div>
				</div>
				<div class="li_prqty">
					<div class="divide">
						<span class="label">판매가</span><span class="val"><?php echo number_format($row['ct_price']); ?></span>
						<span class="label">배송비</span><span class="val"><?php echo $ct_send_cost; ?></span>						
					</div>
					<div class="divide">
						<span class="label">수량</span><span class="val"><?php echo number_format($sum['qty']); ?></span>
						<span class="label">적립포인트</span><span class="val"><?php echo number_format($sum['point']); ?></span>
					</div>
				</div>
				<div class="li_total">
					<span class="label">주문금액</span><span class="val"><?php echo number_format($sell_price); ?> 원</span>
				</div>
            </div>             
        </li>

        <?php
            $tot_point      += $point;
            $tot_sell_price += $sell_price;
        } // for 끝

        if ($i == 0) {
            echo '<li class="empty_list">장바구니에 담긴 상품이 없습니다.</li>';
        } else {
            // 배송비 계산
            $send_cost = get_sendcost($s_cart_id, 0);
        }
        ?>
    </ul>
	

    <?php if ($i == 0) { ?>
    <div class="form-btnSet p20"><a href="<?php echo G5_SHOP_URL; ?>/" class="_btn/large/line w-full">쇼핑 계속하기</a></div>
    <?php } else { ?>
    <div class="sod_ta_wr">
        <?php
        $tot_price = $tot_sell_price + $send_cost; // 총계 = 주문상품금액합계 + 배송비
        ?>
        <div id="sod_bsk_act">
            <div class="total">결제예정금액 <span class="total_cnt"><?php echo number_format($tot_price); ?>원</span></div>
            <input type="hidden" name="url" value="<?php echo G5_SHOP_URL; ?>/orderform.php">
            <input type="hidden" name="act" value="">
            <input type="hidden" name="records" value="<?php echo $i; ?>">
            <button type="button" onclick="return form_check('buy');" class="_btn/lg/mainColor">주문하기</button>
            <a href="<?php echo G5_SHOP_URL; ?>/" class="_btn/lg/line/mainColor">쇼핑 계속하기</a>
        </div>
    </div>
    <?php } ?>
	<?php if ($naverpay_button_js) { ?>
	<div class="naverpay-cart"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
	<?php } ?>
    </form>
</div>

<script>
$(function() {
    var close_btn_idx;

    // 선택사항수정
    $(".mod_options").click(function() {
        var it_id = $(this).attr("id").replace("mod_opt_", "");
        var $this = $(this);
        close_btn_idx = $(".mod_options").index($(this));

        $.post(
            "./cartoption.php",
            { it_id: it_id },
            function(data) {
                $("#purchaseOption").remove();
                //$this.after("<div id=\"purchaseOption\"></div><div class=\"mod_option_bg\"></div>");
				$this.closest('.sod_li').after("<div id=\"purchaseOption\"></div><div class=\"mod_option_bg\"></div>");
                $("#purchaseOption").html(data);
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
        $("#purchaseOption, .mod_option_bg").remove();
        $("#win_mask, .window").hide();
        $(".mod_options").eq(close_btn_idx).focus();
    });
    $("#win_mask").click(function () {
        $("#purchaseOption").remove();
        $("#win_mask").hide();
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
$is_bottomTabMenu = true;
$not_footer = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
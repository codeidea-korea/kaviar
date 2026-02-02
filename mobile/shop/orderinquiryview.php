<?php
include_once('./_common.php');

// 테마에 orderinquiryview.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_inquiryview_file = file_exists(G5_THEME_MSHOP_PATH.'/orderinquiryview.php') ? G5_THEME_MSHOP_PATH.'/orderinquiryview.php' : G5_THEME_SHOP_PATH.'/orderinquiryview.php';
    if(is_file($theme_inquiryview_file)) {
        include_once($theme_inquiryview_file);
        return;
        unset($theme_inquiryview_file);
    }
}

$g5['title'] = $default['shop_type'] ? '예약상세내역' : '주문상세내역';
$topMenu_skip = true;
$head_title = $default['shop_type'] ? '예약상세내역' : '주문상세내역';
include_once(G5_MSHOP_PATH.'/_head.php');

// LG 현금영수증 JS
if($od['od_pg'] == 'lg') {
    if($default['de_card_test']) {
    echo '<script language="JavaScript" src="'.SHOP_TOSSPAYMENTS_CASHRECEIPT_TEST_JS.'"></script>'.PHP_EOL;
    } else {
        echo '<script language="JavaScript" src="'.SHOP_TOSSPAYMENTS_CASHRECEIPT_REAL_JS.'"></script>'.PHP_EOL;
    }
}
?>

<div id="sod_fin">

    <div id="sod_fin_no">[<?=$default['shop_type']?'예약':'주문'?>번호 <?php echo $od_id; ?>]</div>

    <section class="sod_fin_list">
        <?php
        $st_count1 = $st_count2 = 0;
        $custom_cancel = false;

        $sql = " select it_id, it_name, cp_price, ct_send_cost, it_sc_type from {$g5['g5_shop_cart_table']} where od_id = '$od_id' group by it_id order by ct_id ";
        $result = sql_query($sql);
        ?>
        <ul id="sod_list_inq" class="sod_list">
            <?php
            for($i=0; $row=sql_fetch_array($result); $i++) {
                $image = get_it_image($row['it_id'], 120, get_it_height(120), '', '', $row['it_name']);

				//상품 타입 (배송상품, 예약상품)
				$it_type = get_it_type($row['it_id']);

                // 옵션항목
                $sql = " select ct_id, it_name, ct_option, ct_qty, ct_price, ct_point, ct_status, io_type, io_price from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and it_id = '{$row['it_id']}' order by io_type asc, ct_id asc ";
                $res = sql_query($sql);

                // 합계금액 계산
                $sql = " select SUM(IF(io_type = 1, (io_price * ct_qty), ((ct_price + io_price) * ct_qty))) as price, SUM(ct_qty) as qty from {$g5['g5_shop_cart_table']} where it_id = '{$row['it_id']}' and od_id = '$od_id' ";
                $sum = sql_fetch($sql);

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
                    $sendcost = get_item_sendcost($row['it_id'], $sum['price'], $sum['qty'], $od_id);

                    if($sendcost == 0)
                        $ct_send_cost = '무료';
                }

				echo '<li class="sod_li">';
				for($k=0; $opt=sql_fetch_array($res); $k++) {
					if($opt['io_type'])
						$opt_price = $opt['io_price'];
					else
						$opt_price = $opt['ct_price'] + $opt['io_price'];

					$sell_price = $opt_price * $opt['ct_qty'];
					$point = $opt['ct_point'] * $opt['ct_qty'];
                
					echo '<div class="li_op_wr">';
						echo '<div class="head">';
							echo '<a href="'.shop_item_url($row['it_id']).'" class="total_img">'.$image.'</a>';
							echo '<div class="headCon">';
								echo '<div class="li_name"><a href="'.shop_item_url($row['it_id']).'">'.$row['it_name'].'</a></div>';
								echo '<div class="sod_opt">'.get_text($opt['ct_option']).'</div>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="li_prqty">';
							echo '<div class="divide">';
								echo '<span class="label">판매가</span><span class="val">'.number_format($opt_price).'</span>';
								if(!$it_type) echo '<span class="label">배송비</span><span class="val">'.$ct_send_cost.'</span>';
							echo '</div>';
							echo '<div class="divide">';
								echo '<span class="label">수량 </span><span class="val">'.number_format($opt['ct_qty']).'</span>';					
								echo '<span class="label">적립포인트</span><span class="val">'.number_format($point).'</span>';
							echo '</div>';
						echo '</div>';
						echo '<div class="li_total">';
							echo '<span class="label">'.($it_type?'예약금액':'주문금액').'</span><span class="val">'.number_format($sell_price).' 원</span>';
						echo '</div>';
					echo '</div>';

					$tot_point += $point;

					$st_count1++;
					if($opt['ct_status'] == '주문' || $opt['ct_status'] == '입금') $st_count2++; //인태 - $opt['ct_status'] == '입금' 추가(240109) (shop/orderinquirycancel.php - 함께수정)
				}
				echo '</li>';
            }

            // 주문 상품의 상태가 모두 주문이면 고객 취소 가능
            if($st_count1 > 0 && $st_count1 == $st_count2)
                $custom_cancel = true;
            ?>
        </ul>

        <!--<div id="sod_sts_wrap">
            <span class="sound_only">상품 상태 설명</span>
			<button type="button" id="sod_sts_explan_open" class="btn_frmline">상태설명보기</button>
            <div id="sod_sts_explan" style="display:none;">
                <dl id="sod_fin_legend">
                    <dt>주문</dt>
                    <dd>주문이 접수되었습니다.</dd>
                    <dt>입금</dt>
                    <dd>입금(결제)이 완료 되었습니다.</dd>
                    <dt>준비</dt>
                    <dd>상품 준비 중입니다.</dd>
                    <dt>배송</dt>
                    <dd>상품 배송 중입니다.</dd>
                    <dt>완료</dt>
                    <dd>상품 배송이 완료 되었습니다.</dd>
                </dl>
            </div>
        </div>-->

        <?php
        // 총계 = 주문상품금액합계 + 배송비 - 상품할인 - 결제할인 - 배송비할인
        $tot_price = $od['od_cart_price'] + $od['od_send_cost'] + $od['od_send_cost2']
                        - $od['od_cart_coupon'] - $od['od_coupon'] - $od['od_send_coupon']
                        - $od['od_cancel_price'];
        ?>
        <div class="sod_fin_view p20 border-top">
			<ul class="_list_info line">
				<li>
					<div class="label"><?=$it_type?'예약총액':'주문총액'?></div>
					<div class="fw600"><?php echo number_format($od['od_cart_price']); ?> 원</div>
				</li>
				<?php if($od['od_cart_coupon'] > 0) { ?>
				<li>
					<div class="label">상품할인</div>
					<div class="color-slate-500">- <?php echo number_format($od['od_cart_coupon']); ?> 원</div>
				</li>
				<?php } ?>
				<?php if($od['od_coupon'] > 0) { ?>
				<li>
					<div class="label">결제할인</div>
					<div class="color-slate-500">- <?php echo number_format($od['od_coupon']); ?> 원</div>
				</li>
				<?php } ?>
				
				<?php if(!$it_type) { ?>
                <?php if ($od['od_send_cost'] > 0) { ?>
				<li>
					<div class="label">배송비</div>
					<div><?php echo number_format($od['od_send_cost']); ?> 원</div>
				</li>
				<?php } ?>
                <?php if($od['od_send_coupon'] > 0) { ?>
				<li>
					<div class="label">배송비할인</div>
					<div class="color-slate-500">- <?php echo number_format($od['od_send_coupon']); ?> 원</div>
				</li>
				<?php } ?>
				<?php if ($od['od_send_cost2'] > 0) { ?>
				<li>
					<div class="label">추가배송비</div>
					<div><?php echo number_format($od['od_send_cost2']); ?> 원</div>
				</li>
				<?php } ?>
				<?php } ?>
				
				<?php if ($od['od_cancel_price'] > 0) { ?>
				<li>
					<div class="label">취소금액</div>
					<div><?php echo number_format($od['od_cancel_price']); ?> 원</div>
				</li>
				<?php } ?>
				<li>
					<div class="label">적립포인트</div>
					<div><?php echo number_format($tot_point); ?> 점</div>
				</li>
				<li>
					<div class="label total">총계</div>
					<div class="total"><?php echo number_format($tot_price); ?> 원</div>
				</li>
			</ul>
        </div>
    </section>

	<?php
	$receipt_price = $od['od_receipt_price']
				   + $od['od_receipt_point'];
	$cancel_price = $od['od_cancel_price'];

	$misu = true;
	$misu_price = $tot_price - $receipt_price;

	if ($misu_price == 0 && ($od['od_cart_price'] > $od['od_cancel_price'])) {
		$wanbul = " (완불)";
		$misu = false; // 미수금 없음
	} else {
		$wanbul = display_price($receipt_price);
	}

	// 결제정보처리
	if($od['od_receipt_price'] > 0)
		$od_receipt_price = display_price($od['od_receipt_price']);
	else
		$od_receipt_price = '아직 입금되지 않았거나<br>입금정보를 입력하지 못하였습니다.';

	$app_no_subj = '';
	$disp_bank = true;
	$disp_receipt = false;
	if($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == 'KAKAOPAY' || is_inicis_order_pay($od['od_settle_case']) ) {
		$app_no_subj = '승인번호';
		$app_no = $od['od_app_no'];
		$disp_bank = false;
		$disp_receipt = true;
	} else if($od['od_settle_case'] == '간편결제') {
		$app_no_subj = '승인번호';
		$app_no = $od['od_app_no'];
		$disp_bank = false;
	} else if($od['od_settle_case'] == '휴대폰') {
		$app_no_subj = '휴대폰번호';
		$app_no = $od['od_bank_account'];
		$disp_bank = false;
		$disp_receipt = true;
	} else if($od['od_settle_case'] == '가상계좌' || $od['od_settle_case'] == '계좌이체') {
		$app_no_subj = '거래번호';
		$app_no = $od['od_tno'];

		if( function_exists('shop_is_taxsave') && $misu_price == 0 && shop_is_taxsave($od, true) === 2 ){
			$disp_receipt = true;
		}
	}
	?>
	<!-- 결제정보 -->
	<section id="sod_fin_pay" class="p20 border-top">
		<div class="fs14 fw600 pb15">결제 정보</div>

		<ul class="_list_info line">
			<li>
				<div class="label"><?=$it_type?'예약':'주문'?>번호</div>
				<div class=""><?php echo $od_id; ?></div>
			</li>
			<li>
				<div class="label">주문일시</div>
				<div class=""><?php echo $od['od_time']; ?></div>
			</li>
			<li>
				<div class="label">결제방식</div>
				<div class=""><?php echo check_pay_name_replace($od['od_settle_case'], $od, 1); ?></div>
			</li>
			<li>
				<div class="label">결제금액</div>
				<div class="tright"><?php echo $od_receipt_price; ?></div>
			</li>

			<?php
			if($od['od_receipt_price'] > 0) {
				echo '<li>';
					echo '<div class="label">결제일시</div>';
					echo '<div>'.$od['od_receipt_time'].'</div>';
				echo '</li>';
			}
			// 승인번호, 휴대폰번호, 거래번호
			if($app_no_subj && $app_no) {
				echo '<li>';
					echo '<div class="label">'.$app_no_subj.'</div>';
					echo '<div>'.$app_no.'</div>';
				echo '</li>';
			}
			
			// 계좌정보
			if($disp_bank) {
				echo '<li>';
					echo '<div class="label">입금자명</div>';
					echo '<div>'.get_text($od['od_deposit_name']).'</div>';
				echo '</li>';
				echo '<li>';
					echo '<div class="label">입금계좌</div>';
					echo '<div>'.get_text($od['od_bank_account']).'</div>';
				echo '</li>';
			}
			
			//영주증
			if($disp_receipt) {
				echo '<li>';
					echo '<div class="label">영수증</div>';
					echo '<div>';
						if($od['od_settle_case'] == '휴대폰') {
							if($od['od_pg'] == 'lg') {
								require_once G5_SHOP_PATH.'/settle_lg.inc.php';
								$LGD_TID      = $od['od_tno'];
								$LGD_MERTKEY  = $config['cf_lg_mert_key'];
								$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

								$hp_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
							} else if($od['od_pg'] == 'inicis') {
								$hp_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
							} else {
								$hp_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'mcash_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=500,height=690,scrollbars=yes,resizable=yes\');';
							}
							echo '<a href="javascript:;" onclick="'.$hp_receipt_script.'">영수증 출력</a>';
						}
					
					if($od['od_settle_case'] == '신용카드' || is_inicis_order_pay($od['od_settle_case']) || (shop_is_taxsave($od, true) && $misu_price == 0) ) {
							if($od['od_pg'] == 'lg') {
								require_once G5_SHOP_PATH.'/settle_lg.inc.php';
								$LGD_TID      = $od['od_tno'];
								$LGD_MERTKEY  = $config['cf_lg_mert_key'];
								$LGD_HASHDATA = md5($LGD_MID.$LGD_TID.$LGD_MERTKEY);

								$card_receipt_script = 'showReceiptByTID(\''.$LGD_MID.'\', \''.$LGD_TID.'\', \''.$LGD_HASHDATA.'\');';
							} else if($od['od_pg'] == 'inicis') {
								$card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
							} else {
								$card_receipt_script = 'window.open(\''.G5_BILL_RECEIPT_URL.'card_bill&tno='.$od['od_tno'].'&order_no='.$od['od_id'].'&trade_mony='.$od['od_receipt_price'].'\', \'winreceipt\', \'width=470,height=815,scrollbars=yes,resizable=yes\');';
							}
							
							echo '<a href="javascript:;" onclick="'.$card_receipt_script.'">영수증 출력</a>';
						}
						
						if($od['od_settle_case'] == 'KAKAOPAY') {
							//$card_receipt_script = 'window.open(\'https://mms.cnspay.co.kr/trans/retrieveIssueLoader.do?TID='.$od['od_tno'].'&type=0\', \'popupIssue\', \'toolbar=no,location=no,directories=no,status=yes,menubar=no,scrollbars=yes,resizable=yes,width=420,height=540\');';
							$card_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/mCmReceipt_head.jsp?noTid='.$od['od_tno'].'&noMethod=1\',\'receipt\',\'width=430,height=700\');';
							echo '<a href="javascript:;" onclick="'.$card_receipt_script.'">영수증 출력</a>';
						}
					echo '</div>';
				echo '</li>';
			}

			if ($od['od_receipt_point'] > 0) {
				echo '<li>';
					echo '<div class="label">포인트사용</div>';
					echo '<div>'.display_point($od['od_receipt_point']).'</div>';
				echo '</li>';
			}

			if ($od['od_refund_price'] > 0) {
				echo '<li>';
					echo '<div class="label">환불 금액</div>';
					echo '<div>'.display_price($od['od_refund_price']).'</div>';
				echo '</li>';
			}

			// 현금영수증 발급을 사용하는 경우에만
			if (function_exists('shop_is_taxsave') && shop_is_taxsave($od)) {
				// 미수금이 없고 현금일 경우에만 현금영수증을 발급 할 수 있습니다.
				if ($misu_price == 0 && $od['od_receipt_price'] && ($od['od_settle_case'] == '무통장' || $od['od_settle_case'] == '계좌이체' || $od['od_settle_case'] == '가상계좌')) {
					echo '<li>';
						echo '<div class="label">현금영수증</div>';
						echo '<div>';
							if ($od['od_cash']) {
								if($od['od_pg'] == 'lg') {
									require_once G5_SHOP_PATH.'/settle_lg.inc.php';

									switch($od['od_settle_case']) {
										case '계좌이체':
											$trade_type = 'BANK';
											break;
										case '가상계좌':
											$trade_type = 'CAS';
											break;
										default:
											$trade_type = 'CR';
											break;
									}
									$cash_receipt_script = 'javascript:showCashReceipts(\''.$LGD_MID.'\',\''.$od['od_id'].'\',\''.$od['od_casseqno'].'\',\''.$trade_type.'\',\''.$CST_PLATFORM.'\');';
								} else if($od['od_pg'] == 'inicis') {
									$cash = unserialize($od['od_cash_info']);
									$cash_receipt_script = 'window.open(\'https://iniweb.inicis.com/DefaultWebApp/mall/cr/cm/Cash_mCmReceipt.jsp?noTid='.$cash['TID'].'&clpaymethod=22\',\'showreceipt\',\'width=380,height=540,scrollbars=no,resizable=no\');';
								} else {
									require_once G5_SHOP_PATH.'/settle_kcp.inc.php';

									$cash = unserialize($od['od_cash_info']);
									$cash_receipt_script = 'window.open(\''.G5_CASH_RECEIPT_URL.$default['de_kcp_mid'].'&orderid='.$od_id.'&bill_yn=Y&authno='.$cash['receipt_no'].'\', \'taxsave_receipt\', \'width=360,height=647,scrollbars=0,menus=0\');';
								}
								echo '<a href="javascript:;" onclick="'.$cash_receipt_script.'">현금영수증 확인하기</a>';
							} else {
								echo '<a href="javascript:;" onclick="window.open(\''.G5_SHOP_URL.'/taxsave.php?od_id='.$od_id.'\', \'taxsave\', \'width=550,height=400,scrollbars=1,menus=0\');">현금영수증을 발급하시려면 클릭하십시오.</a>';
							}
						echo '</div>';
					echo '</li>';
				}
			}
			?>
		</ul>
	</section>
	<!-- //결제정보 -->
	
	<?php if(!$it_type) { ?>
	<!-- 배송지 -->	
	<section id="sod_fin_receiver" class="p20 border-top">
		<div class="fs14 fw600 pb15">배송지</div>
		<ul class="_list_info line">
			<li>
				<div class="label">이름</div>
				<div><?php echo get_text($od['od_b_name']); ?></div>
			</li>
			<li>
				<div class="label">연락처</div>
				<div><?php echo get_text($od['od_b_hp']); ?></div>
			</li>
			<li>
				<div class="label">주소</div>
				<div><?php echo get_text(sprintf("(%s%s)", $od['od_b_zip1'], $od['od_b_zip2']).' '.print_address($od['od_b_addr1'], $od['od_b_addr2'], $od['od_b_addr3'], $od['od_b_addr_jibeon'])); ?></div>
			</li>
			<?php if($od['od_memo']) { ?>
			<li>
				<div class="label">메세지</div>
				<div><?php echo conv_content($od['od_memo'], 0); ?></div>
			</li>
			<?php } ?>
		</ul>
	</section>
	<!-- //배송지 -->	
	
	<!-- 배송정보 -->
	<section id="sod_fin_dvr" class="p20 border-top">
		<div class="fs14 fw600 pb15">배송정보</div>
		<ul class="_list_info">
			<?php
			if ($od['od_invoice'] && $od['od_delivery_company']) {
				echo '<li>';
					echo '<div class="label">배송회사</div>';
					echo '<div>'.$od['od_delivery_company'].' '.get_delivery_inquiry($od['od_delivery_company'], $od['od_invoice'], 'dvr_link').'</div>';
				echo '</li>';
				echo '<li>';
					echo '<div class="label">운송장번호</div>';
					echo '<div>'.$od['od_invoice'].'</div>';
				echo '</li>';
				echo '<li>';
					echo '<div class="label">배송일시</div>';
					echo '<div>'.$od['od_invoice_time'].'</div>';
				echo '</li>';
			} else {
				echo '<li><div class="py30 w-full tcenter color-slate-500">아직 배송하지 않았거나 배송정보를 입력하지 못하였습니다.</div></li>';
			}
			?>
		</ul>
	</section>
	<!-- //배송정보 -->
	<?php } ?>

	<div class="p20 border-top10">
		<div class="fs14 fw600 pb15">결제합계</div>
		<ul class="_list_info">
			<li>
				<div class="label">총 구매액</div>
				<div class="fs15 bold"><?php echo display_price($tot_price); ?></div>
			</li>
			<?php			
			if ($misu_price > 0) {
				echo '<li>';
					echo '<div class="label">미결제액</div>';
					echo '<div class="fs15 bold">'.display_price($misu_price).'</div>';
				echo '</li>';
			}
			?>
			<li>
				<div class="label total">결제액</div>
				<div class="total color-red"><?=$wanbul?></div>
			</li>
		</ul>
		<ul id="alrdy" class="_list_info">			
			<?php
			//포인트로 결제한 내용이 있으면
			if($od['od_receipt_point'] ) {
				echo '<li>';
					echo '<div class="label">포인트 결제</div>';
					echo '<div>'.number_format($od['od_receipt_point']).' 점</div>';
				echo '</li>';
				echo '<li>';
					echo '<div class="label">실결제</div>';
					echo '<div>'.number_format($od['od_receipt_price']).' 원</div>';
				echo '</li>';
			}
			?>
		</ul>
	</div>

	<section id="sod_fin_cancel" class="p20 pt0 pb50">
        <?php
        // 취소한 내역이 없다면		
        if ($cancel_price == 0) {
            if ($custom_cancel) {
        ?>
        <button type="button" class="_btn/lg/line/transparent w-full orderCancel"><?=$it_type?'예약':'주문'?> 취소하기</button>

        <div id="sod_fin_cancelfrm">
            <form method="post" action="<?php echo G5_SHOP_URL; ?>/orderinquirycancel.php" onsubmit="return fcancel_check(this);">
            <input type="hidden" name="od_id"  value="<?php echo $od['od_id']; ?>">
            <input type="hidden" name="token"  value="<?php echo $token; ?>">
            <label for="cancel_memo" class="sound_only">취소사유</label>
            <input type="text" name="cancel_memo" id="cancel_memo" required class="frm_input lg w-full" maxlength="100" placeholder="취소사유">
            <input type="submit" value="주문 취소" class="btn_frmline _btn/md/gray/line/transparent w-full mt10">
            </form>
        </div>
        <?php
            }
        } else {
        ?>
        <p class="fs15 tcenter"><?=$it_type?'예약 취소':'주문 취소, 반품, 품절된'?> 내역이 있습니다.</p>
        <?php } ?>
    </section>
	

</div>

<script>
$(function() {
	//인태 - 주문취소	
	$(".orderCancel").on("click", function() {
		$(this).hide();
        $('#sod_fin_cancelfrm').show();
    });

    $("#sod_sts_explan_open").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        if($explan.is(":visible")) {
            $explan.slideUp(200);
            $("#sod_sts_explan_open").text("상태설명보기");
        } else {
            $explan.slideDown(200);
            $("#sod_sts_explan_open").text("상태설명닫기");
        }
    });

    $("#sod_sts_explan_close").on("click", function() {
        var $explan = $("#sod_sts_explan");
        if($explan.is(":animated"))
            return false;

        $explan.slideUp(200);
        $("#sod_sts_explan_open").text("상태설명보기");
    });
});

function fcancel_check(f)
{
    if(!confirm("주문을 정말 취소하시겠습니까?"))
        return false;

    var memo = f.cancel_memo.value;
    if(memo == "") {
        alert("취소사유를 입력해 주십시오.");
        return false;
    }

    return true;
}
</script>

<?php
$is_bottomTabMenu = true;
$not_footer = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
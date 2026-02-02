<?php
$sub_menu = '400400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '주문내역';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$where = array();

$doc = isset($_GET['doc']) ? clean_xss_tags($_GET['doc'], 1, 1) : '';
$sort1 = (isset($_GET['sort1']) && in_array($_GET['sort1'], array('od_id', 'od_cart_price', 'od_receipt_price', 'od_cancel_price', 'od_misu', 'od_cash'))) ? $_GET['sort1'] : '';
$sort2 = (isset($_GET['sort2']) && in_array($_GET['sort2'], array('desc', 'asc'))) ? $_GET['sort2'] : 'desc';
$sel_field = (isset($_GET['sel_field']) && in_array($_GET['sel_field'], array('od_id', 'mb_id', 'od_name', 'od_tel', 'od_hp', 'od_b_name', 'od_b_tel', 'od_b_hp', 'od_deposit_name', 'od_invoice')) ) ? $_GET['sel_field'] : ''; 
$od_status = isset($_GET['od_status']) ? get_search_string($_GET['od_status']) : '';
$search = isset($_GET['search']) ? get_search_string($_GET['search']) : '';

$fr_date = (isset($_GET['fr_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['fr_date'])) ? $_GET['fr_date'] : '';
$to_date = (isset($_GET['to_date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $_GET['to_date'])) ? $_GET['to_date'] : '';

$od_misu = isset($_GET['od_misu']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_misu']) : '';
$od_cancel_price = isset($_GET['od_cancel_price']) ? preg_replace('/[^0-9a-z]/', '', $_GET['od_cancel_price']) : '';
$od_refund_price = isset($_GET['od_refund_price']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_refund_price']) : '';
$od_receipt_point = isset($_GET['od_receipt_point']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_receipt_point']) : '';
$od_coupon = isset($_GET['od_coupon']) ? preg_replace('/[^0-9a-z]/i', '', $_GET['od_coupon']) : ''; 
$od_settle_case = isset($_GET['od_settle_case']) ? clean_xss_tags($_GET['od_settle_case'], 1, 1) : ''; 
$od_escrow = isset($_GET['od_escrow']) ? clean_xss_tags($_GET['od_escrow'], 1, 1) : ''; 

$tot_itemcount = $tot_orderprice = $tot_receiptprice = $tot_ordercancel = $tot_misu = $tot_couponprice = 0;
$sql_search = " where mb_id = '$mb_id' ";


if ($od_status) {
    switch($od_status) {
        case '전체취소':
            $where[] = " od_status = '취소' ";
            break;
        case '부분취소':
            $where[] = " od_status IN('주문', '입금', '준비', '배송', '완료') and od_cancel_price > 0 ";
            break;
        default:
            $where[] = " od_status = '$od_status' ";
            break;
    }

    switch ($od_status) {
        case '주문' :
            $sort1 = "od_id";
            $sort2 = "desc";
            break;
        case '입금' :   // 결제완료
            $sort1 = "od_receipt_time";
            $sort2 = "desc";
            break;
        case '배송' :   // 배송중
            $sort1 = "od_invoice_time";
            $sort2 = "desc";
            break;
    }
}

if ($od_settle_case) {
    if( $od_settle_case === '간편결제' ) {
        $where[] = " od_settle_case in ('간편결제', '삼성페이', 'lpay', 'inicis_kakaopay') ";
    } else {
        $where[] = " od_settle_case = '$od_settle_case' ";
    }
}

if ($od_misu) {
    $where[] = " od_misu != 0 ";
}

if ($od_cancel_price) {
    $where[] = " od_cancel_price != 0 ";
}

if ($od_refund_price) {
    $where[] = " od_refund_price != 0 ";
}

if ($od_receipt_point) {
    $where[] = " od_receipt_point != 0 ";
}

if ($od_coupon) {
    $where[] = " ( od_cart_coupon > 0 or od_coupon > 0 or od_send_coupon > 0 ) ";
}

if ($od_escrow) {
    $where[] = " od_escrow = 1 ";
}

if ($fr_date && $to_date) {
    $where[] = " od_time between '$fr_date 00:00:00' and '$to_date 23:59:59' ";
}

if ($where) {
    $sql_search = ' where '.implode(' and ', $where);
}

if ($sel_field == "")  $sel_field = "od_id";
if ($sort1 == "") $sort1 = "od_id";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_order_table']} $sql_search ";

$sql = " select count(od_id) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           $sql_common
           order by $sort1 $sort2
           limit $from_record, $rows ";
$result = sql_query($sql);

$qstr1 = "od_status=".urlencode($od_status)."&amp;od_settle_case=".urlencode($od_settle_case)."&amp;od_misu=$od_misu&amp;od_cancel_price=$od_cancel_price&amp;od_refund_price=$od_refund_price&amp;od_receipt_point=$od_receipt_point&amp;od_coupon=$od_coupon&amp;fr_date=$fr_date&amp;to_date=$to_date&amp;sel_field=$sel_field&amp;search=$search&amp;save_search=$search";
if($default['de_escrow_use'])
    $qstr1 .= "&amp;od_escrow=$od_escrow";
$qstr = "$qstr1&amp;sort1=$sort1&amp;sort2=$sort2&amp;page=$page";

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

// 주문삭제 히스토리 테이블 필드 추가
if(!sql_query(" select mb_id from {$g5['g5_shop_order_delete_table']} limit 1 ", false)) {
    sql_query(" ALTER TABLE `{$g5['g5_shop_order_delete_table']}`
                    ADD `mb_id` varchar(20) NOT NULL DEFAULT '' AFTER `de_data`,
                    ADD `de_ip` varchar(255) NOT NULL DEFAULT '' AFTER `mb_id`,
                    ADD `de_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `de_ip` ", true);
}

if( function_exists('pg_setting_check') ){
	pg_setting_check(true);
}

?>


<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt">전체 주문내역</span><span class="ov_num"> <?php echo number_format($total_count); ?>건</span></span>

</div>



<form name="forderlist" id="forderlist" onsubmit="return forderlist_submit(this);" method="post" autocomplete="off">
<input type="hidden" name="search_od_status" value="<?php echo $od_status; ?>">

<?php
$btn_qstr = '';
if($od_status) $btn_qstr .= '&od_status='.$od_status;
if($od_settle_case) $btn_qstr .= '&od_settle_case='.$od_settle_case;
if($od_misu) $btn_qstr .= '&od_misu='.$od_misu;
if($od_refund_price) $btn_qstr .= '&od_refund_price='.$od_refund_price;
if($od_receipt_point) $btn_qstr .= '&od_receipt_point='.$od_receipt_point;
if($od_coupon) $btn_qstr .= '&od_coupon='.$od_coupon;
if($fr_date) $btn_qstr .= '&fr_date='.$fr_date;
if($to_date) $btn_qstr .= '&to_date='.$to_date;
$btn_qstr = $btn_qstr ? '?'.$btn_qstr : '';
?>


<div class="tbl_head01 tbl_wrap">
    <table id="sodr_list">
    <caption>주문 내역 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="3">
            <label for="chkall" class="sound_only">주문 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" id="th_ordnum" rowspan="2" colspan="2"><a href="<?php echo title_sort("od_id", 1)."&amp;$qstr1"; ?>">주문번호</a></th>
        <th scope="col" rowspan="3">상품명 / 옵션</th>
		<th scope="col" id="th_odrer">주문자</th>
		<th scope="col" id="th_odrer">주문자등급</th>
        <th scope="col" id="th_odrertel">주문자전화</th>
        <th scope="col" id="th_recvr">받는분</th>
        <th scope="col" rowspan="3">주문합계<br>선불배송비포함</th>
        <th scope="col" rowspan="3">입금합계</th>
        <th scope="col" rowspan="3">주문취소</th>
        <th scope="col" rowspan="3">쿠폰</th>
        <th scope="col" rowspan="3">미수금</th>
        <th scope="col" rowspan="3">보기</th>
    </tr>
    <tr>
        <th scope="col" id="th_odrid">회원ID</th>
		<th scope="col" id="th_odrid">회원주문내역</th>
        <th scope="col" id="th_odrcnt">주문상품수</th>
        <th scope="col" id="th_odrall">누적주문수</th>
    </tr>
    <tr>
        <th scope="col" id="odrstat">주문상태</th>
        <th scope="col" id="odrpay">결제수단</th>
        <th scope="col" id="delino">운송장번호</th>
		<th scope="col" id="delino">출고지관리</th>
        <th scope="col" id="delicom">배송회사</th>
        <th scope="col" id="delidate">배송일시</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        // 결제 수단
        $s_receipt_way = $s_br = "";
        if ($row['od_settle_case'])
        {
            $s_receipt_way = check_pay_name_replace($row['od_settle_case'], $row);
            $s_br = '<br />';
        }
        else
        {
            $s_receipt_way = '결제수단없음';
            $s_br = '<br />';
        }

        if ($row['od_receipt_point'] > 0)
            $s_receipt_way .= $s_br."포인트";

        $mb_nick = get_sideview($row['mb_id'], get_text($row['od_name']), $row['od_email'], '');

        $od_cnt = 0;
        if ($row['mb_id'])
        {
            $sql2 = " select count(*) as cnt from {$g5['g5_shop_order_table']} where mb_id = '{$row['mb_id']}' ";
            $row2 = sql_fetch($sql2);
            $od_cnt = $row2['cnt'];
        }

        // 주문 번호에 device 표시
        $od_mobile = '';
        if($row['od_mobile'])
            $od_mobile = '(M)';

        // 주문번호에 - 추가
        switch(strlen($row['od_id'])) {
            case 16:
                $disp_od_id = substr($row['od_id'],0,8).'-'.substr($row['od_id'],8);
                break;
            default:
                $disp_od_id = substr($row['od_id'],0,6).'-'.substr($row['od_id'],6);
                break;
        }

        // 주문 번호에 에스크로 표시
        $od_paytype = '';
        if($row['od_test'])
            $od_paytype .= '<span class="list_test">테스트</span>';

        if($default['de_escrow_use'] && $row['od_escrow'])
            $od_paytype .= '<span class="list_escrow">에스크로</span>';

        $uid = md5($row['od_id'].$row['od_time'].$row['od_ip']);

        $invoice_time = is_null_time($row['od_invoice_time']) ? G5_TIME_YMDHIS : $row['od_invoice_time'];
        $delivery_company = $row['od_delivery_company'] ? $row['od_delivery_company'] : $default['de_delivery_company'];

        $bg = 'bg'.($i%2);
        $td_color = 0;
        if($row['od_cancel_price'] > 0) {
            $bg .= 'cancel';
            $td_color = 1;
        }

		// 상품목록
		$itemsql = " select it_id, it_name  from {$g5['g5_shop_cart_table']} where od_id = '{$row['od_id']}' group by it_id order by ct_id ";
		$itemresult = sql_query($itemsql);
    ?>
	<input type="hidden" name="list_mb_id[<?php echo $i ?>]" value="<?php echo $row['mb_id']; ?>">
	<input type="hidden" name="list_tot_price[<?php echo $i ?>]" value="<?php echo $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']; ?>">

    <tr class="orderlist<?php echo ' '.$bg; ?>">
        <td rowspan="3" class="td_chk">
            <input type="hidden" name="od_id[<?php echo $i ?>]" value="<?php echo $row['od_id'] ?>" id="od_id_<?php echo $i ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">주문번호 <?php echo $row['od_id']; ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">			
        </td>
        <td headers="th_ordnum" class="td_odrnum" rowspan="2" colspan="2">
            <a href="<?php echo G5_SHOP_URL; ?>/orderinquiryview.php?od_id=<?php echo $row['od_id']; ?>&amp;uid=<?php echo $uid; ?>" class="orderitem"><?php echo $disp_od_id; ?></a>
            <?php echo $od_mobile; ?>
            <?php echo $od_paytype; ?>
        </td>
		<td rowspan="3" class="tleft">
			(<?=$row['od_name']?>)
			<?php for($t=0; $itemrow=sql_fetch_array($itemresult); $t++) {
				echo $itemrow['it_name'];
				// 상품의 옵션정보
				$optionsql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
							from {$g5['g5_shop_cart_table']}
							where od_id = '{$row['od_id']}'
							  and it_id = '{$itemrow['it_id']}'
							order by io_type asc, ct_id asc ";
				$res = sql_query($optionsql);
				for($k=0; $opt=sql_fetch_array($res); $k++) {
					echo '<br><span class="color-gray">'.get_text($opt['ct_option']).'</span>';
				 }
			} ?>
		</td>
        <td headers="th_odrer" class="td_name"><?php echo $mb_nick; ?></td>
		<td headers="th_odrer" class="td_name">
			<?php 
				$grade = sql_fetch(" select g_name from `g5_member_grade` where idx = '".$member['mb_grade']."' ");
				echo $grade['g_name'];
			?>
		</td>
        <td headers="th_odrertel" class="td_tel"><?php echo get_text($row['od_hp']); ?></td>
        <td headers="th_recvr" class="td_name"><a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sort1=<?php echo $sort1; ?>&amp;sort2=<?php echo $sort2; ?>&amp;sel_field=od_b_name&amp;search=<?php echo get_text($row['od_b_name']); ?>"><?php echo get_text($row['od_b_name']); ?></a></td>
        <td rowspan="3" class="td_num td_numsum"><?php echo number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
        <td rowspan="3" class="td_num_right"><?php echo number_format($row['od_receipt_price']); ?></td>
        <td rowspan="3" class="td_numcancel<?php echo $td_color; ?> td_num"><?php echo number_format($row['od_cancel_price']); ?></td>
        <td rowspan="3" class="td_num_right"><?php echo number_format($row['couponprice']); ?></td>
        <td rowspan="3" class="td_num_right"><?php echo number_format($row['od_misu']); ?></td>
        <td rowspan="3" class="td_mng td_mng_s">
            <a href="./orderform.php?od_id=<?php echo $row['od_id']; ?>&amp;<?php echo $qstr; ?>" class="mng_mod btn btn_02" target="_blink" rel="noreferrer noopener"><span class="sound_only"><?php echo $row['od_id']; ?> </span>보기</a>
        </td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="th_odrid">
            <?php if ($row['mb_id']) { ?>
            <a href="<?PHP echo G5_ADMIN_URL; ?>/member_form.php?w=u&mb_id=<?php echo $row['mb_id']; ?>"  target='_blank'><?php echo $row['mb_id']; ?></a>
            <?php } else { ?>
            비회원
            <?php } ?>
        </td>
		<td headers="th_odrer" class="td_name">
			<?php if ($row['mb_id']) { ?>
            <a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?sort1=<?php echo $sort1; ?>&amp;sort2=<?php echo $sort2; ?>&amp;sel_field=mb_id&amp;search=<?php echo $row['mb_id']; ?>">주문내역</a>
            <?php } else { ?>
            비회원
            <?php } ?>
		</td>
        <td headers="th_odrcnt"><?php echo $row['od_cart_count']; ?>건</td>
        <td headers="th_odrall"><?php echo $od_cnt; ?>건</td>
    </tr>
    <tr class="<?php echo $bg; ?>">
        <td headers="odrstat" class="odrstat">
            <input type="hidden" name="current_status[<?php echo $i ?>]" value="<?php echo $row['od_status'] ?>">
            <?php echo $row['od_status']; ?>
        </td>
        <td headers="odrpay" class="odrpay">
            <input type="hidden" name="current_settle_case[<?php echo $i ?>]" value="<?php echo $row['od_settle_case'] ?>">
            <?php echo $s_receipt_way; ?>
        </td>
        <td headers="delino" class="delino">
            <?php if ($od_status == '준비') { ?>
                <input type="text" name="od_invoice[<?php echo $i; ?>]" value="<?php echo $row['od_invoice']; ?>" class="frm_input" size="10">
            <?php } else {
				$url = "https://trace.cjlogistics.com/next/tracking.html?wblNo=";
                echo "<a href='".$url."".$row['od_invoice']."' target='_blank'>".($row['od_invoice'] ? $row['od_invoice'] : '-')."</a>";
            } ?>
        </td>
		<td headers="th_odrer" class="td_name"><!--출고지관리--></td>
        <td headers="delicom">
            <?php if ($od_status == '준비') { ?>
                <select name="od_delivery_company[<?php echo $i; ?>]">
                    <?php echo get_delivery_company($delivery_company); ?>
                </select>
            <?php } else {
                echo ($row['od_delivery_company'] ? $row['od_delivery_company'] : '-');
            } ?>
        </td>
        <td headers="delidate">
            <?php if ($od_status == '준비') { ?>
                <input type="text" name="od_invoice_time[<?php echo $i; ?>]" value="<?php echo $invoice_time; ?>" class="frm_input" size="10" maxlength="19">
            <?php } else {
                echo (is_null_time($row['od_invoice_time']) ? '-' : substr($row['od_invoice_time'],2,14));
            } ?>
        </td>
    </tr>
    <?php
        $tot_itemcount     += $row['od_cart_count'];
        $tot_orderprice    += ($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']);
        $tot_ordercancel   += $row['od_cancel_price'];
        $tot_receiptprice  += $row['od_receipt_price'];
        $tot_couponprice   += $row['couponprice'];
        $tot_misu          += $row['od_misu'];
    }
    sql_free_result($result);
    if ($i == 0)
        echo '<tr><td colspan="12" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    <tfoot>
    <tr class="orderlist">
        <th scope="row" colspan="3">&nbsp;</th>
        <td>&nbsp;</td>
        <td><?php echo number_format($tot_itemcount); ?>건</td>
        <th scope="row">합 계</th>
        <td><?php echo number_format($tot_orderprice); ?></td>
        <td><?php echo number_format($tot_receiptprice); ?></td>
        <td><?php echo number_format($tot_ordercancel); ?></td>
        <td><?php echo number_format($tot_couponprice); ?></td>
        <td><?php echo number_format($tot_misu); ?></td>
        <td></td>
    </tr>
    </tfoot>
    </table>
</div>

<div class="local_cmd01 local_cmd">
<?php if (($od_status == '' || $od_status == '완료' || $od_status == '전체취소' || $od_status == '부분취소') == false) {
    // 검색된 주문상태가 '전체', '완료', '전체취소', '부분취소' 가 아니라면
?>
   <!-- <label for="od_status" class="cmd_tit">주문상태 변경</label>-->
    <?php
    $change_status = "";
    if ($od_status == '주문') $change_status = "입금";
    if ($od_status == '입금') $change_status = "준비";
    if ($od_status == '준비') $change_status = "배송";
    if ($od_status == '배송') $change_status = "완료";
    ?>
	<?php if($od_status != '준비') { ?>	
		<label><input type="checkbox" name="od_status" value="<?php echo $change_status; ?>"> '<?php echo $od_status ?>'상태에서 '<strong><?php echo $change_status ?></strong>'상태로 변경합니다.</label>
	<?}?>

    <?php if($od_status == '주문' || $od_status == '준비') { ?>
<!--
    <input type="checkbox" name="od_send_mail" value="1" id="od_send_mail" checked="checked">
    <label for="od_send_mail"><?php echo $change_status; ?>안내 메일</label>
    <input type="checkbox" name="send_sms" value="1" id="od_send_sms" checked="checked">
    <label for="od_send_sms"><?php echo $change_status; ?>안내 SMS</label>
-->
    <?php } ?>
    <?php if($od_status == '준비') { ?>
<!--
    <input type="checkbox" name="send_escrow" value="1" id="od_send_escrow">
    <label for="od_send_escrow">에스크로배송등록</label>
-->
    <?php } ?>
	<?php if($od_status != '준비') { ?>
	    <input type="submit" value="선택수정" class="btn_submit" onclick="document.pressed=this.value">
	<?}?>
<?php } ?>
    <?php if ($od_status == '주문') { ?> <span>주문상태에서만 삭제가 가능합니다.</span> <input type="submit" value="선택삭제" class="btn_submit" onclick="document.pressed=this.value"><?php } ?>
</div>



</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });

    // 주문상품보기
    $(".orderitem").on("click", function() {
        var $this = $(this);
        var od_id = $this.text().replace(/[^0-9]/g, "");

        if($this.next("#orderitemlist").length)
            return false;

        $("#orderitemlist").remove();

        $.post(
            "./ajax.orderitem.php",
            { od_id: od_id },
            function(data) {
                $this.after("<div id=\"orderitemlist\"><div class=\"itemlist\"></div></div>");
                $("#orderitemlist .itemlist")
                    .html(data)
                    .append("<div id=\"orderitemlist_close\"><button type=\"button\" id=\"orderitemlist-x\" class=\"btn_frmline\">닫기</button></div>");
            }
        );

        return false;
    });

    // 상품리스트 닫기
    $("#sodr_list").on("click", "#orderitemlist-x", function(e) {
        $("#orderitemlist").remove();
    });

    $("body").on("click", function(e) {
        if ($(e.target).closest("#orderitemlist").length === 0){
            $("#orderitemlist").remove();
        }
    });

    // 엑셀배송처리창
    $("#order_delivery").on("click", function() {
        var opt = "width=600,height=450,left=10,top=10";
        window.open(this.href, "win_excel", opt);
        return false;
    });
});

function set_date(today)
{
    <?php
    $date_term = date('w', G5_SERVER_TIME);
    $week_term = $date_term + 7;
    $last_term = strtotime(date('Y-m-01', G5_SERVER_TIME));
    ?>
    if (today == "오늘") {
        document.getElementById("fr_date").value = "<?php echo G5_TIME_YMD; ?>";
        document.getElementById("to_date").value = "<?php echo G5_TIME_YMD; ?>";
    } else if (today == "어제") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME - 86400); ?>";
    } else if (today == "이번주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$date_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "이번달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', G5_SERVER_TIME); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', G5_SERVER_TIME); ?>";
    } else if (today == "지난주") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-d', strtotime('-'.$week_term.' days', G5_SERVER_TIME)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-d', strtotime('-'.($week_term - 6).' days', G5_SERVER_TIME)); ?>";
    } else if (today == "지난달") {
        document.getElementById("fr_date").value = "<?php echo date('Y-m-01', strtotime('-1 Month', $last_term)); ?>";
        document.getElementById("to_date").value = "<?php echo date('Y-m-t', strtotime('-1 Month', $last_term)); ?>";
    } else if (today == "전체") {
        document.getElementById("fr_date").value = "";
        document.getElementById("to_date").value = "";
    }
}
</script>

<script>
function forderlist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    /*
    switch (f.od_status.value) {
        case "" :
            alert("변경하실 주문상태를 선택하세요.");
            return false;
        case '주문' :

        default :

    }
    */

    if(document.pressed == "선택삭제") {
        if(confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            f.action = "./orderlistdelete.php";
            return true;
        }
        return false;
    }

    var change_status = f.od_status.value;

    if (f.od_status.checked == false) {
        alert("주문상태 변경에 체크하세요.");
        return false;
    }

    var chk = document.getElementsByName("chk[]");

    for (var i=0; i<chk.length; i++)
    {
        if (chk[i].checked)
        {
            var k = chk[i].value;
            var current_settle_case = f.elements['current_settle_case['+k+']'].value;
            var current_status = f.elements['current_status['+k+']'].value;

            switch (change_status)
            {
                case "입금" :
                    if (!(current_status == "주문" && current_settle_case == "무통장")) {
                        alert("'주문' 상태의 '무통장'(결제수단)인 경우에만 '입금' 처리 가능합니다.");
                        return false;
                    }
                    break;

                case "준비" :
                    if (current_status != "입금") {
                        alert("'입금' 상태의 주문만 '준비'로 변경이 가능합니다.");
                        return false;
                    }
                    break;

                case "배송" :
                    if (current_status != "준비") {
                        alert("'준비' 상태의 주문만 '배송'으로 변경이 가능합니다.");
                        return false;
                    }

                    var invoice      = f.elements['od_invoice['+k+']'];
                    var invoice_time = f.elements['od_invoice_time['+k+']'];
                    var delivery_company = f.elements['od_delivery_company['+k+']'];

                    if ($.trim(invoice_time.value) == '') {
                        alert("배송일시를 입력하시기 바랍니다.");
                        invoice_time.focus();
                        return false;
                    }

                    if ($.trim(delivery_company.value) == '') {
                        alert("배송업체를 입력하시기 바랍니다.");
                        delivery_company.focus();
                        return false;
                    }

                    if ($.trim(invoice.value) == '') {
                        alert("운송장번호를 입력하시기 바랍니다.");
                        invoice.focus();
                        return false;
                    }

                    break;
            }
        }
    }

    if (!confirm("선택하신 주문서의 주문상태를 '"+change_status+"'상태로 변경하시겠습니까?"))
        return false;

    f.action = "./orderlistupdate.php";
    return true;
}
function f_auto_done(valus)
{
	var con_test = confirm("자동배송일자를 수정하겠습니까?");

	if(con_test == true){

	   $.ajax({
		  url:'ajax_auto_done.php',
		  type:'POST',
		  data : {valus : valus},
		  cache: false,
		  async: false,
		  dataType : 'json',
		  success: function(res) {
				alert("수정되었습니다.");
			}
		});
	}
}

</script>

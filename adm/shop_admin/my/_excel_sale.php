<?php
include_once('./_common.php');

//include_once (G5_ADMIN_PATH.'/admin.head.php');

auth_check_menu($auth, $sub_menu, 'r');

// 엑셀 다운로드 함수
function array_to_excel($data, $filename){
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
	header("Pragma: no-cache");
	header("Expires: 0");
    header('Cache-Control: max-age=0');
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF"); // UTF-8 with BOM
    fputcsv($out, array_keys($data[0]), "\t");
    foreach ($data as $row) {
        fputcsv($out, $row, "\t");
    }
    fclose($out);
}

function print_line2($save)
{
    $date = preg_replace("/-/", "", $save['od_date']);
?>
    <tr>
        <td class="td_alignc"><a href="./sale1today.php?date=<?php echo $date; ?>"><?php echo $save['od_date']; ?></a></td>
        <td class="td_num"><?php echo number_format($save['ordercount']); ?></td>
        <td class="td_numsum"><?php echo number_format($save['orderprice']); ?></td>
        <td class="td_numcoupon"><?php echo number_format($save['ordercoupon']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptvbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptiche']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptcard']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipteasy']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipthp']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptpoint']); ?></td>
		<td class="td_numsum"><?php echo number_format($save['ordercost']); ?></td>
        <td class="td_numcancel1"><?php echo number_format($save['ordercancel']); ?></td>
        <td class="td_numrdy"><?php echo number_format($save['misu']); ?></td>
		<td class="td_numrdy"><?php echo number_format($save['receipt_tot']); ?></td>
    </tr>
<?}



function print_line3($save)
{
    $date = preg_replace("/-/", "", $save['od_date']);

    ?>
    <tr>
        <td class="td_alignc" style="mso-number-format:yyyy-mm"><?php echo $save['od_date']; ?></td>
        <td class="td_num"><?php echo number_format($save['ordercount']); ?></td>
        <td class="td_numsum"><?php echo number_format($save['orderprice']); ?></td>
        <td class="td_numcoupon"><?php echo number_format($save['ordercoupon']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptvbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptiche']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptcard']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipteasy']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipthp']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptpoint']); ?></td>
		<td class="td_numsum"><?php echo number_format($save['ordercost']); ?></td>
        <td class="td_numcancel1"><?php echo number_format($save['ordercancel']); ?></td>
        <td class="td_numrdy"><?php echo number_format($save['misu']); ?></td>
		<td class="td_numrdy"><?php echo number_format($save['receipt_tot']); ?></td>
    </tr>
    <?php
}

function print_line4($save)
{
    ?>
    <tr>
        <td class="td_alignc"><?php echo $save['od_date']; ?></a></td>
        <td class="td_num"><?php echo number_format($save['ordercount']); ?></td>
        <td class="td_numsum"><?php echo number_format($save['orderprice']); ?></td>
        <td class="td_numcoupon"><?php echo number_format($save['ordercoupon']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptvbank']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptiche']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptcard']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipteasy']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receipthp']); ?></td>
        <td class="td_numincome"><?php echo number_format($save['receiptpoint']); ?></td>
		<td class="td_numsum"><?php echo number_format($save['ordercost']); ?></td>
        <td class="td_numcancel1"><?php echo number_format($save['ordercancel']); ?></td>
        <td class="td_numrdy"><?php echo number_format($save['misu']); ?></td>
		<td class="td_numrdy"><?php echo number_format($save['receipt_tot']); ?></td>
    </tr>
    <?php
}

print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

$type = isset($_GET['type']) ? clean_xss_tags($_GET['type'], 1, 1) : '';

if($type == 1){
	
	$date = isset($_GET['date']) ? preg_replace('/[^0-9]/i', '', $_GET['date']) : '';
	$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);

	$sql = " select od_id,
                mb_id,
                od_name,
                od_settle_case,
                od_cart_price,
                od_receipt_price,
                od_receipt_point,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
				(od_send_cost + od_send_cost2) as ordercost,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,10) = '$date'
          order by od_id desc ";
	$result = sql_query($sql);

	echo "<table border='1'>";
	echo "<tr>";

		echo "<th>주문번호</th>";
		echo "<th>주문자</th>";
		echo "<th>주문합계</th>";
		echo "<th>쿠폰</th>";
		echo "<th>무통장</th>";
		echo "<th>가상계좌</th>";

		echo "<th>계좌이체</th>";
		echo "<th>카드입금</th>";
		echo "<th>간편결제</th>";
		echo "<th>휴대폰</th>";
		echo "<th>포인트입금</th>";
		echo "<th>배송비</th>";
		echo "<th>주문취소</th>";
		echo "<th>미수금</th>";
		echo "<th>최종결제금액</th>";

	echo "</tr>";

	for ($i=0; $row=sql_fetch_array($result); $i++) {	
		
		if ($row['mb_id'] == '') { // 비회원일 경우는 주문자로 링크
            $href = '<a href="./orderlist.php?sel_field=od_name&amp;search='.$row['od_name'].'">';
        } else { // 회원일 경우는 회원아이디로 링크
            $href = '<a href="./orderlist.php?sel_field=mb_id&amp;search='.$row['mb_id'].'">';
        }

        $receipt_bank = $receipt_card = $receipt_vbank = $receipt_iche = $receipt_easy = $receipt_hp = 0;
        if($row['od_settle_case'] == '무통장')
            $receipt_bank = $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $receipt_vbank = $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $receipt_iche = $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $receipt_hp = $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $receipt_card = $row['od_receipt_price'];
        if(in_array($row['od_settle_case'], array('간편결제', 'KAKAOPAY', 'lpay', 'inicis_payco', 'inicis_kakaopay', '삼성페이'))) {
            $receipt_easy = $row['od_receipt_price'];
        }

		$receipt_money = $receipt_bank + $receipt_vbank + $receipt_iche + $receipt_card + $receipt_easy + $receipt_hp;
		if($receipt_money > 0){
			$receipt_tot = $receipt_bank + $receipt_vbank + $receipt_iche + $receipt_card + $receipt_easy + $receipt_hp - $row['od_cancel_price'];
		}else{
			$receipt_tot = $receipt_bank + $receipt_vbank + $receipt_iche + $receipt_card + $receipt_easy + $receipt_hp;
		}
?>

		<tr>
            <td class="td_numincome"><?php echo number_format($row['od_id']); ?></td>
            <td class="td_name"><?php echo $href; ?><?php echo $row['od_name']; ?></a></td>
            <td class="td_numsum"><?php echo number_format($row['orderprice']); ?></td>
            <td class="td_numincome"><?php echo number_format($row['couponprice']); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_bank); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_vbank); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_iche); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_card); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_easy); ?></td>
            <td class="td_numincome"><?php echo number_format($receipt_hp); ?></td>
            <td class="td_numincome"><?php echo number_format($row['od_receipt_point']); ?></td>
			<td class="td_numsum"><?php echo number_format($row['ordercost']); ?></td>
            <td class="td_numcancel1"><?php echo number_format($row['od_cancel_price']); ?></td>
            <td class="td_numrdy"><?php echo number_format($row['od_misu']); ?></td>
			<td class="td_numincome"><?php echo number_format($receipt_tot); ?></td>
        </tr>

<?	
	
		$tot['orderprice']    += $row['orderprice'];
		$tot['ordercost']    += $row['ordercost'];
		$tot['ordercancel']   += $row['od_cancel_price'];
		$tot['coupon']        += $row['couponprice'] ;
		$tot['receipt_bank']  += $receipt_bank;
		$tot['receipt_vbank'] += $receipt_vbank;
		$tot['receipt_iche']  += $receipt_iche;
		$tot['receipt_card']  += $receipt_card;
		$tot['receipt_easy']  += $receipt_easy;
		$tot['receipt_hp']    += $receipt_hp;
		$tot['receipt_point'] += $row['od_receipt_point'];
		$tot['misu']          += $row['od_misu'];
		$tot['tots']          += $receipt_tot;
	}

	if ($i == 0) {
		echo '<tr><td colspan="13" class="empty_table">자료가 없습니다</td></tr>';
	}
?>
	
	<tfoot>
    <tr>
        <td colspan="2">합 계</td>
        <td class="td_num_right"><?php echo number_format($tot['orderprice']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['coupon']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_bank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_vbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_iche']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_card']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_easy']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_hp']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipt_point']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['ordercost']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercancel']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['misu']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['tots']); ?></td>
    </tr>
    </tfoot>
	
<?
	echo "</table>";
	$excel_file_name = $date.'일일 매출현황';

}else if($type == 2) {
		
	$fr_date = isset($_GET['fr_date']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['fr_date']) : '';
	$to_date = isset($_GET['to_date']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['to_date']) : '';

	$fr_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $fr_date);
	$to_date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $to_date);

	$sql = " select od_id,
				SUBSTRING(od_time,1,10) as od_date,
				od_settle_case,
				od_receipt_price,
				od_receipt_point,
				od_cart_price,
				od_cancel_price,
				od_misu,
				(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
				(od_send_cost + od_send_cost2) as ordercost,
				(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
		   from {$g5['g5_shop_order_table']}
		  where SUBSTRING(od_time,1,10) between '$fr_date' and '$to_date'
		  order by od_time desc ";

	$result = sql_query($sql);
?>
	<table border='1'>
	<tr>
        <th scope="col">주문일</th>
        <th scope="col">주문수</th>
        <th scope="col">주문합계</th>
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">간편결제</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
		<th scope="col">배송비</th>
        <th scope="col">주문취소</th>
        <th scope="col">미수금</th>
		<th scope="col">최종결제금액</th>
    </tr>
<?

	$save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
    $tot = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($i == 0)
            $save['od_date'] = $row['od_date'];

        if ($save['od_date'] != $row['od_date']) {
            print_line2($save);
            $save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
            $save['od_date'] = $row['od_date'];
        }

        $save['ordercount']++;
        $save['orderprice']    += $row['orderprice'];
		$save['ordercost']    += $row['ordercost'];
        $save['ordercancel']   += $row['od_cancel_price'];
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장'){
            $save['receiptbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '가상계좌'){
            $save['receiptvbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '계좌이체'){
            $save['receiptiche']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '휴대폰'){
            $save['receipthp']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '신용카드'){
		    $save['receiptcard']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];
		
		
		if($receipt_money > 0){
			$show_money = $receipt_money - $row['od_cancel_price'] -  $row['od_receipt_point'] - $row['od_misu'];
		}else{
			$show_money = $receipt_money - $save['ordercancel'] -  $save['receiptpoint'] - $save['misu'];
		}
		$save['receipt_tot'] += $show_money;

        $tot['ordercount']++;
        $tot['orderprice']     += $row['orderprice'];
		$tot['ordercost']     += $row['ordercost'];
        $tot['ordercancel']    += $row['od_cancel_price'];
        $tot['ordercoupon']    += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']    += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']    += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']           += $row['od_misu'];
		$tot['tots']          += $show_money;
		$receipt_money = 0;
		$show_money = 0;

        if(in_array($row['od_settle_case'], array('간편결제', 'KAKAOPAY', 'lpay', 'inicis_payco', 'inicis_kakaopay', '삼성페이'))) {
            $save['receipteasy'] += $row['od_receipt_price'];
            $tot['receipteasy'] += $row['od_receipt_price'];
        }
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 없습니다.</td></tr>';
    } else {
        print_line2($save);
    }
?>

    <tr>
        <td>합계</td>
        <td class="td_num_right"><?php echo number_format($tot['ordercount']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['orderprice']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercoupon']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptvbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptiche']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptcard']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipteasy']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipthp']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptpoint']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['ordercost']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercancel']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['misu']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['tots']); ?></td>
    </tr>
    </table>

<?
	$excel_file_name = '일간 매출현황';
	if($fr_date) $excel_file_name .= '_'.$fr_date;
	if($to_date) $excel_file_name .= '_'.$to_date;

}else if($type == 3) {
	
	$fr_month = isset($_GET['fr_month']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['fr_month']) : '';
	$to_month = isset($_GET['to_month']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['to_month']) : '';

	$fr_month = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $fr_month);
	$to_month = preg_replace("/([0-9]{4})([0-9]{2})/", "\\1-\\2", $to_month);

	$sql = " select od_id,
				SUBSTRING(od_time,1,7) as od_date,
				od_send_cost,
				od_settle_case,
				od_receipt_price,
				od_receipt_point,
				od_cart_price,
				od_cancel_price,
				od_misu,
				(od_cart_price + od_send_cost + od_send_cost2) as orderprice,
				(od_send_cost + od_send_cost2) as ordercost,
				(od_cart_coupon + od_coupon + od_send_coupon) as couponprice
		   from {$g5['g5_shop_order_table']}
		  where SUBSTRING(od_time,1,7) between '$fr_month' and '$to_month'
		  order by od_time desc ";
	$result = sql_query($sql);	
	
?>
	
	<table border="1">
    <tr>
        <th scope="col">주문월</th>
        <th scope="col">주문수</th>
        <th scope="col">주문합계</th>
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">간편결제</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
		<th scope="col">배송비</th>
        <th scope="col">주문취소</th>
        <th scope="col">미수금</th>
		<th scope="col">최종결제금액</th>
    </tr>


<?php

    $save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
    $tot = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($i == 0)
            $save['od_date'] = get_text($row['od_date']);

        if ($save['od_date'] != $row['od_date']) {
            print_line3($save);
            $save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
            $save['od_date'] = get_text($row['od_date']);
        }

        $save['ordercount']++;
        $save['orderprice']    += $row['orderprice'];
		$save['ordercost']    += $row['ordercost'];
        $save['ordercancel']   += $row['od_cancel_price'];
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장'){
            $save['receiptbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '가상계좌'){
            $save['receiptvbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '계좌이체'){
            $save['receiptiche']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '휴대폰'){
            $save['receipthp']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '신용카드'){
		    $save['receiptcard']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}

        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];

		if($receipt_money > 0){
			$show_money = $receipt_money;
		}else{
			$show_money = $receipt_money;
		}
		$save['receipt_tot'] += $show_money;

        $tot['ordercount']++;
        $tot['orderprice']    += $row['orderprice'];
		$tot['ordercost']    += $row['ordercost'];
        $tot['ordercancel']   += $row['od_cancel_price'];
        $tot['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
		$tot['tots']          += $show_money;
		$receipt_money = 0;

        if(in_array($row['od_settle_case'], array('간편결제', 'KAKAOPAY', 'lpay', 'inicis_payco', 'inicis_kakaopay', '삼성페이'))) {
            $save['receipteasy'] += $row['od_receipt_price'];
            $tot['receipteasy'] += $row['od_receipt_price'];
        }
    }

    if ($i == 0) {
        echo '<tr><td colspan="13" class="empty_table">자료가 없습니다.</td></tr>';
    } else {
        print_line3($save);
    }
?>


	<tr>
        <td>합 계</td>
        <td class="td_num_right"><?php echo number_format($tot['ordercount']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['orderprice']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercoupon']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptvbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptiche']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptcard']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipteasy']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipthp']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptpoint']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['ordercost']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercancel']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['misu']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['tots']); ?></td>
    </tr>
    </table>

<?
	$excel_file_name = '월간 매출현황';
	if($fr_month) $excel_file_name .= '_'.$fr_month;
	if($to_month) $excel_file_name .= '_'.$to_month;

}else if($type == 4) {

	$fr_year = isset($_GET['fr_year']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['fr_year']) : '';
	$to_year = isset($_GET['to_year']) ? preg_replace('/[^0-9 :_\-]/i', '', $_GET['to_year']) : '';
	
	$sql = " select od_id,
                SUBSTRING(od_time,1,4) as od_date,
                od_send_cost,
                od_settle_case,
                od_receipt_price,
                od_receipt_point,
                od_cart_price,
                od_cancel_price,
                od_misu,
                (od_cart_price + od_send_cost + od_send_cost2) as orderprice,
				(od_send_cost + od_send_cost2) as ordercost,
                (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           from {$g5['g5_shop_order_table']}
          where SUBSTRING(od_time,1,4) between '$fr_year' and '$to_year'
          order by od_time desc ";
	$result = sql_query($sql);
?>

	<table border="1">
    <tr>
        <th scope="col">주문년도</th>
        <th scope="col">주문수</th>
        <th scope="col">주문합계</th>
        <th scope="col">쿠폰</th>
        <th scope="col">무통장</th>
        <th scope="col">가상계좌</th>
        <th scope="col">계좌이체</th>
        <th scope="col">카드입금</th>
        <th scope="col">간편결제</th>
        <th scope="col">휴대폰</th>
        <th scope="col">포인트입금</th>
		<th scope="col">배송비</th>
        <th scope="col">주문취소</th>
        <th scope="col">미수금</th>
		<th scope="col">최종결제금액</th>
    </tr>

<?
    $save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
    $tot = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);

    for ($i=0; $row=sql_fetch_array($result); $i++)
    {
        if ($i == 0)
            $save['od_date'] = $row['od_date'];

        if ($save['od_date'] != $row['od_date']) {
            print_line($save);
            $save = array('ordercount'=>0, 'orderprice'=>0, 'ordercost'=>0,'ordercancel'=>0, 'ordercoupon'=>0, 'receiptbank'=>0, 'receiptvbank'=>0, 'receiptiche'=>0, 'receipthp'=>0, 'receiptcard'=>0, 'receiptpoint'=>0, 'misu'=>0, 'receipteasy'=>0, 'receipt_tot'=>0);
            $save['od_date'] = $row['od_date'];
        }

        $save['ordercount']++;
        $save['orderprice']    += $row['orderprice'];
		$save['ordercost']    += $row['ordercost'];
        $save['ordercancel']   += $row['od_cancel_price'];
        $save['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장'){
            $save['receiptbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '가상계좌'){
            $save['receiptvbank']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '계좌이체'){
            $save['receiptiche']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '휴대폰'){
            $save['receipthp']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        if($row['od_settle_case'] == '신용카드'){
		    $save['receiptcard']   += $row['od_receipt_price'];
			$receipt_money		   += $row['od_receipt_price'];
		}
        $save['receiptpoint']  += $row['od_receipt_point'];
        $save['misu']          += $row['od_misu'];

		if($receipt_money > 0){
			$show_money = $receipt_money;
		}else{
			$show_money = $receipt_money;
		}
		$save['receipt_tot'] += $show_money;

        $tot['ordercount']++;
        $tot['orderprice']    += $row['orderprice'];
		 $tot['ordercost']    += $row['ordercost'];
        $tot['ordercancel']   += $row['od_cancel_price'];
        $tot['ordercoupon']   += $row['couponprice'];
        if($row['od_settle_case'] == '무통장')
            $tot['receiptbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '가상계좌')
            $tot['receiptvbank']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '계좌이체')
            $tot['receiptiche']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '휴대폰')
            $tot['receipthp']   += $row['od_receipt_price'];
        if($row['od_settle_case'] == '신용카드')
            $tot['receiptcard']   += $row['od_receipt_price'];
        $tot['receiptpoint']  += $row['od_receipt_point'];
        $tot['misu']          += $row['od_misu'];
		$tot['tots']          += $show_money;
		$receipt_money = 0;

        if(in_array($row['od_settle_case'], array('간편결제', 'KAKAOPAY', 'lpay', 'inicis_payco', 'inicis_kakaopay', '삼성페이'))) {
            $save['receipteasy'] += $row['od_receipt_price'];
            $tot['receipteasy'] += $row['od_receipt_price'];
        }
    }

    if ($i == 0) {
        echo '<tr><td colspan="12" class="empty_table">자료가 없습니다.</td></tr>';
    } else {
        print_line4($save);
    }
?>

	<tr>
        <td>합 계</td>
        <td class="td_num_right"><?php echo number_format($tot['ordercount']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['orderprice']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercoupon']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptvbank']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptiche']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptcard']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipteasy']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receipthp']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['receiptpoint']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['ordercost']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['ordercancel']); ?></td>
        <td class="td_num_right"><?php echo number_format($tot['misu']); ?></td>
		<td class="td_num_right"><?php echo number_format($tot['tots']); ?></td>
    </tr>
    </table>

<?

	echo "</table>";
	$excel_file_name = $date.'연간 매출현황';
	if($fr_year) $excel_file_name .= '_'.$fr_year;
	if($to_year) $excel_file_name .= '_'.$to_year;

}?>



<?php


// 엑셀 다운로드



array_to_excel($data, $excel_file_name);

?>
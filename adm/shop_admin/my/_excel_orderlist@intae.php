<?php
include_once('./_common.php');

//include_once (G5_ADMIN_PATH.'/admin.head.php');

auth_check_menu($auth, $sub_menu, 'r');

// 엑셀 다운로드 함수
function array_to_excel($data, $filename){
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
    header('Cache-Control: max-age=0');
    $out = fopen('php://output', 'w');
    fputs($out, "\xEF\xBB\xBF"); // UTF-8 with BOM
    fputcsv($out, array_keys($data[0]), "\t");
    foreach ($data as $row) {
        fputcsv($out, $row, "\t");
    }
    fclose($out);
}



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
$sql_search = "";
if ($search != "") {
    if ($sel_field != "") {
        $where[] = " $sel_field like '%$search%' ";
    }

    if ($save_search != $search) {
        $page = 1;
    }
}

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

$sql  = " select *,
            (od_cart_coupon + od_coupon + od_send_coupon) as couponprice
           $sql_common
           order by $sort1 $sort2 ";
$result = sql_query($sql);


echo "<table border='1'>";
	echo "<tr>";
		echo "<th>번호</th>";
		echo "<th>주문번호</th>";
		echo "<th>상품명</th>";
		echo "<th>주문상태</th>";
		echo "<th>결제수단</th>";		
		echo "<th>주문자 이름</th>";
		echo "<th>주문자 연락처</th>";
		echo "<th>받는분 이름</th>";
		echo "<th>받는분 연락처</th>";
		echo "<th>회원 ID</th>";
		echo "<th>주문상품 수</th>";
		echo "<th>누적주문수</th>";
		echo "<th>운송장번호</th>";
		echo "<th>배송회사</th>";
		echo "<th>배송일시</th>";
		echo "<th>주문합계(선불배송비포함)</th>";
		echo "<th>입금합계</th>";
		echo "<th>주문취소	</th>";
		echo "<th>쿠폰</th>";
		echo "<th>미수금</th>";
	echo "</tr>";

for ($i=0; $row=sql_fetch_array($result); $i++) {
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

	$mb_nick = $row['od_name'];

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
<tr>
	<td><?=($i+1)?></td>
	<td><?=$disp_od_id.$od_mobile.$od_paytype?></td>
	<td>
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
                echo '<br>'.get_text($opt['ct_option']);
			 }
		} ?>
	</td>
	<td><?=$row['od_status']?></td>
	<td><?=$s_receipt_way?></td>		
	<td><?php echo $mb_nick; ?></td>
	<td><?php echo get_text($row['od_hp']); ?></td>
	<td><?php echo get_text($row['od_b_name']); ?></td>
	<td><?php echo get_text($row['od_b_hp']); ?></td>
	<td><?=$row['mb_id']?$row['mb_id']:'비회원'?></td>
	<td><?php echo $row['od_cart_count']; ?>건</td>
	<td><?php echo $od_cnt; ?>건</td>
	<td><?=$row['od_invoice'] ? $row['od_invoice'] : '-'?></td>
	<td><?=$row['od_delivery_company'] ? $row['od_delivery_company'] : '-'?></td>
	<td><?=is_null_time($row['od_invoice_time']) ? '-' : substr($row['od_invoice_time'],2,14)?></td>
	<td><?php echo number_format($row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2']); ?></td>
	<td><?php echo number_format($row['od_receipt_price']); ?></td>
	<td><?php echo number_format($row['od_cancel_price']); ?></td>
	<td><?php echo number_format($row['couponprice']); ?></td>
	<td><?php echo number_format($row['od_misu']); ?></td>
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
?>
<tr>
	<th colspan="10"></th>
	<th><?php echo number_format($tot_itemcount); ?>건</th>
	<th colspan="3"></th>
	<th>합 계</th>
	<th><?php echo number_format($tot_orderprice); ?></th>
	<th><?php echo number_format($tot_receiptprice); ?></th>
	<th><?php echo number_format($tot_ordercancel); ?></th>
	<th><?php echo number_format($tot_couponprice); ?></th>
	<th><?php echo number_format($tot_misu); ?></th>
</tr>
<?php
echo "</table>";

// 엑셀 다운로드
$excel_file_name = '주문내역';
if($fr_date) $excel_file_name .= '_'.$fr_date;
if($to_date) $excel_file_name .= '_'.$to_date;

array_to_excel($data, $excel_file_name);

/*
// 테이블 출력을 위한 HTML 코드 추가
echo "<table border='1'>";
echo "<tr>";
echo "<th>번호</th>";
echo "<th>아이디</th>";
echo "<th>이름</th>";
echo "<th>닉네임</th>";
echo "<th>E-MAIL</th>";
echo "<th>전화번호</th>";
echo "<th>휴대폰번호</th>";
echo "<th>성별</th>";
echo "<th>생년월일</th>";
echo "<th>가입일</th>";
echo "<th>최종접속일</th>";
echo "<th>권한</th>";
echo "</tr>";

for ($i=0; $row=sql_fetch_array($result); $i++) {
    // 데이터 가공
    $mb_gender = '';
    if ($row['mb_gender'] == 'M') {
        $mb_gender = '남성';
    } else if ($row['mb_gender'] == 'F') {
        $mb_gender = '여성';
    }

    // 테이블 출력을 위한 HTML 코드 추가
    echo "<tr>";
    echo "<td>" . ($i+1) . "</td>";
    echo "<td>" . $row['mb_id'] . "</td>";
    echo "<td>" . $row['mb_name'] . "</td>";
    echo "<td>" . $row['mb_nick'] . "</td>";
    echo "<td>" . $row['mb_email'] . "</td>";
    echo "<td>" . $row['mb_tel'] . "</td>";
    echo "<td>" . $row['mb_hp'] . "</td>";
    echo "<td>" . $mb_gender . "</td>";
    echo "<td>" . $row['mb_birth'] . "</td>";
    echo "<td>" . $row['mb_datetime'] . "</td>";
    echo "<td>" . $row['mb_today_login'] . "</td>";
    echo "<td>" . $row['mb_level'] . "</td>";
    echo "</tr>";
}

// 테이블 출력을 위한 HTML 코드 추가
echo "</table>";

// 엑셀 다운로드
array_to_excel($data, '주문내역');
*/
?>
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

print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

$where = array();
$sql_search = '';

if ($sort1 == "") $sort1 = "mb_no";
if ($sort2 == "") $sort2 = "desc";
$sub_query = ",
(select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = g5_member.mb_id) AS od_price ";
$sql_common = " from `g5_member` $sql_search ";


$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql  = " select * {$sub_query} $sql_common order by $sort1 $sort2 ";
$result = sql_query($sql);

echo "<table border='1'>";
	echo "<tr style='height:30px;background:#BDBDBD;'>";
		echo "<th>번호</th>";
		echo "<th>이름</th>";
		echo "<th>아이디</th>";
		echo "<th>성별</th>";
		echo "<th>생년월일</th>";
		echo "<th>우편번호</th>";

		echo "<th>주소</th>";
		echo "<th>상세주소</th>";
		echo "<th>이메일</th>";
		echo "<th>휴대폰번호</th>";
		echo "<th>적립금</th>";
		echo "<th>메일수신</th>";
		
		echo "<th>SMS수신</th>";
		echo "<th>회원등급</th>";
		echo "<th>총구매액</th>";
		echo "<th>가입일</th>";
		echo "<th>최근접속일</th>";
		echo "<th>유입채널</th>";




	echo "</tr>";

for ($i=0; $row=sql_fetch_array($result); $i++) {

	$grade = sql_fetch("select g_name from `g5_member_grade` where idx = '".$row['mb_grade']."' ");
	
	$mb_sexs	 = ($row['mb_sexs'] == 1)?"남자":"여자";
	$mb_mailling = ($row['mb_mailling'] == 1)?"수신함":"수신안함";
	$mb_sms		 = ($row['mb_sms'] == 1)?"수신함":"수신안함";
?>
<tr style="height:30px">
	<td><?=($i+1)?></td>
	<td><?=get_text($row['mb_name'])?></td>
	<td><?=get_text($row['mb_id'])?></td>
	<td><?=get_text($mb_sexs)?></td>
	<td><?=get_text($row['mb_births'])?></td>
	<td><?=$row['mb_zip1']."-".$row['mb_zip2']?></td>
	<td><?=$row['mb_addr1']?></td>
	<td><?=$row['mb_addr2']." ".$row['mb_addr3']?></td>
	<td><?=$row['mb_email']?></td>
	<td><?=$row['mb_hp']?></td>
	<td><?=number_format($row['mb_point'])?></td>
	<td><?=get_text($mb_mailling)?></td>
	<td><?=get_text($mb_sms)?></td>
	<td><?=get_text($grade['g_name'])?></td>
	<td><?=number_format($row['od_price'])?></td>
	<td><?=is_null_time($row['mb_datetime']) ? '-' : substr($row['mb_datetime'],2,14)?></td>
	<td><?=is_null_time($row['mb_today_login']) ? '-' : substr($row['mb_today_login'],2,14)?></td>
	<td><?=get_text($row['mb_sns'])?></td>
</tr>

<?php

}

?>

<?php
echo "</table>";

// 엑셀 다운로드
$excel_file_name = '회원리스트';

array_to_excel($data, $excel_file_name);

?>
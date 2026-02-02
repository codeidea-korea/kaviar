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

if ($sort1 == "") $sort1 = "it_time";
if ($sort2 == "") $sort2 = "desc";

$sql_common = " from {$g5['g5_shop_item_table']} $sql_search ";


$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql  = " select *
           $sql_common
           order by $sort1 $sort2 ";
$result = sql_query($sql);

echo "<table border='1'>";
	echo "<tr>";
		echo "<th>번호</th>";
		echo "<th>상품명</th>";
		echo "<th>카테고리</th>";
		echo "<th>상품코드</th>";
		echo "<th>판매가</th>";
		echo "<th>적립금</th>";

		echo "<th>재고수량</th>";
		echo "<th>등록일</th>";
		echo "<th>상세설명(HTML 코드포함)</th>";
		echo "<th>모바일상세설명(HTML 코드포함)</th>";
	echo "</tr>";

for ($i=0; $row=sql_fetch_array($result); $i++) {

	$ca_id = sql_fetch("select ca_name from `g5_shop_category` where ca_id = '".$row['ca_id']."' ");
	$ca_id2 = sql_fetch("select ca_name from `g5_shop_category` where ca_id = '".$row['ca_id2']."' ");
	$ca_id3 = sql_fetch("select ca_name from `g5_shop_category` where ca_id = '".$row['ca_id3']."' ");

	$ca_name1 = $ca_id['ca_name']?$ca_id['ca_name']:"";
	$ca_name2 = $ca_id2['ca_name']?" > ".$ca_id2['ca_name']:"";
	$ca_name3 = $ca_id3['ca_name']?" > ".$ca_id3['ca_name']:"";
?>
<tr style="height:30px">
	<td><?=($i+1)?></td>
	<td><?=$row['it_name']?></td>
	<td><?php echo $ca_name1.$ca_name2.$ca_name3?></td>
	<td><?=get_text($row['it_id'])?></td>
	<td><?=number_format($row['it_price'])?></td>
	<td><?=number_format($row['it_point'])."%"?></td>
	<td><?=number_format($row['it_stock_qty'])?></td>
	<td><?=is_null_time($row['it_time']) ? '-' : substr($row['it_time'],2,14)?></td>
	<td><?=get_text($row['it_explan'])?></td>
	<td><?=get_text($row['it_explan2'])?></td>
</tr>

<?php

}

?>

<?php
echo "</table>";

// 엑셀 다운로드
$excel_file_name = '상품내역';
if($fr_date) $excel_file_name .= '_'.$fr_date;
if($to_date) $excel_file_name .= '_'.$to_date;

array_to_excel($data, $excel_file_name);

?>
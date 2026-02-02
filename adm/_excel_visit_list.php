<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
//include_once (G5_ADMIN_PATH.'/admin.head.php');

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
?>

<style>
.tbl_head01 table {border:1px solid #black};
</style>
<?
//접속자 엑셀
if($type == 1){

	//$date = isset($_GET['date']) ? preg_replace('/[^0-9]/i', '', $_GET['date']) : '';
	//$date = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})/", "\\1-\\2-\\3", $date);
	
	$fr_date = isset($_GET['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_GET['fr_date']) : G5_TIME_YMD;
	$to_date = isset($_GET['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_GET['to_date']) : G5_TIME_YMD;
	
	$sql_common = " from {$g5['visit_table']} ";
	$sql_search = " where vi_date between '{$fr_date}' and '{$to_date}' ";

	$sql = " select *
            {$sql_common}
            {$sql_search}
            order by vi_id desc ";
	$result = sql_query($sql);
	
	echo "<table border='1'>";
	echo "<tr>";

		echo "<th>IP</th>";
		echo "<th>접속경로</th>";
		echo "<th>브라우저</th>";
		echo "<th>OS</th>";
		echo "<th>접속기기</th>";
		echo "<th>일시</th>";

	echo "</tr>";

	
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		
        $brow = $row['vi_browser'];
        if(!$brow)
            $brow = get_brow($row['vi_agent']);

        $os = $row['vi_os'];
        if(!$os)
            $os = get_os($row['vi_agent']);

        $device = $row['vi_device'];

        $link = '';
        $link2 = '';
        $referer = '';
        $title = '';
        if ($row['vi_referer']) {

            $referer = get_text(cut_str($row['vi_referer'], 255, ''));
            $referer = urldecode($referer);

            if (!is_utf8($referer)) {
                $referer = iconv_utf8($referer);
            }

            $title = str_replace(array('<', '>', '&'), array("&lt;", "&gt;", "&amp;"), $referer);
            $link = '<a href="'.get_text($row['vi_referer']).'" target="_blank">';
            $link = str_replace('&', "&amp;", $link);
            $link2 = '</a>';
        }

        if ($is_admin == 'super')
            $ip = $row['vi_ip'];
        else
            $ip = preg_replace("/([0-9]+).([0-9]+).([0-9]+).([0-9]+)/", G5_IP_DISPLAY, $row['vi_ip']);

        if ($brow == '기타') { $brow = '<span title="'.get_text($row['vi_agent']).'">'.$brow.'</span>'; }
        if ($os == '기타') { $os = '<span title="'.get_text($row['vi_agent']).'">'.$os.'</span>'; }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><?php echo $ip ?></td>
        <td><?php echo $link ?><?php echo $title ?><?php echo $link2 ?></td>
        <td class="td_category td_category1"><?php echo $brow ?></td>
        <td class="td_category td_category3"><?php echo $os ?></td>
        <td class="td_category td_category2"><?php echo $device; ?></td>
        <td class="td_datetime"><?php echo $row['vi_date'] ?> <?php echo $row['vi_time'] ?></td>
    </tr>
<?
	}

	echo "</table>";
	$excel_file_name = '일일 접속현황';
	if($fr_date) $excel_file_name .= '_'.$fr_date;
	if($to_date) $excel_file_name .= '_'.$to_date;

}else if($type == 2){	//도메인

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
	$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

	$colspan = 5;

	$max = 0;
	$sum_count = 0;
	$arr = array();

	$sql = " select * from {$g5['visit_table']}
				where vi_date between '{$fr_date}' and '{$to_date}' ";
	$result = sql_query($sql);
	while ($row=sql_fetch_array($result)) {
		$str = $row['vi_referer'];
		preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $str, $match);
		$s = isset($match[1]) ? $match[1] : 0;
		$s = preg_replace("/^(www\.|search\.|dirsearch\.|dir\.search\.|dir\.|kr\.search\.|myhome\.)(.*)/", "\\2", $s);

		if( isset($arr[$s]) ){
			$arr[$s]++;
		} else {
			$arr[$s] = 1;
		}

		if ($arr[$s] > $max) $max = $arr[$s];

		$sum_count++;
	}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">
    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">접속 도메인</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="3">합계</td>
        <td><strong><?php echo $sum_count ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        arsort($arr);
        foreach ($arr as $key=>$value) {
            $count = $arr[$key];
            if ($save_count != $count) {
                $i++;
                $no = $i;
                $save_count = $count;
            } else {
                $no = '';
            }

            if (!$key) {
                $link = '';
                $link2 = '';
                $key = '직접';
            } else {
                $link = '<a href="./visit_list.php?'.$qstr.'&amp;domain='.$key.'">';
                $link2 = '</a>';
            }

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $no ?></td>
        <td class="td_category"><?php echo $link ?><?php echo $key ?><?php echo $link2 ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo $count ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '도메인 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>
<?
}else if($type == 3){	//브라우저

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;


$colspan = 5;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select * from {$g5['visit_table']}
            where vi_date between '{$fr_date}' and '{$to_date}' ";
$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $s = $row['vi_browser'];
    if(!$s)
        $s = get_brow($row['vi_agent']);

    if( isset($arr[$s]) ){
        $arr[$s]++;
    } else {
        $arr[$s] = 1;
    }

    if ($arr[$s] > $max) $max = $arr[$s];

    $sum_count++;
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">

    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">브라우저</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="3">합계</td>
        <td><strong><?php echo $sum_count ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        arsort($arr);
        foreach ($arr as $key=>$value) {
            $count = $arr[$key];
            if ($save_count != $count) {
                $i++;
                $no = $i;
                $save_count = $count;
            } else {
                $no = "";
            }

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $no ?></td>
        <td class="td_category td_category1"><?php echo $key ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo $count ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '브라우저 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>



<?
}else if($type == 4){	//운영체제

$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;


$colspan = 5;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select * from {$g5['visit_table']}
          where vi_date between '$fr_date' and '$to_date' ";
$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $s = $row['vi_os'];
    if(!$s)
        $s = get_os($row['vi_agent']);

    if( isset($arr[$s]) ){
        $arr[$s]++;
    } else {
        $arr[$s] = 1;
    }

    if ($arr[$s] > $max) $max = $arr[$s];

    $sum_count++;
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">
    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">OS</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="3">합계</td>
        <td><strong><?php echo $sum_count ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        arsort($arr);
        foreach ($arr as $key=>$value) {
            $count = $arr[$key];
            if ($save_count != $count) {
                $i++;
                $no = $i;
                $save_count = $count;
            } else {
                $no = '';
            }

            if (!$key) {
                $key = 'Unknown';
            }

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $no ?></td>
        <td class="td_category"><?php echo $key ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo $count ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '운영체제 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?
}else if($type == 5){	//접속기기

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;


$colspan = 5;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select * from {$g5['visit_table']}
          where vi_date between '$fr_date' and '$to_date' ";
$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $s = $row['vi_device'];
    if(!$s)
        $s = '기타';

    if( isset($arr[$s]) ){
        $arr[$s]++;
    } else {
        $arr[$s] = 1;
    }

    if ($arr[$s] > $max) $max = $arr[$s];

    $sum_count++;
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">

    <thead>
    <tr>
        <th scope="col">순위</th>
        <th scope="col">접속기기</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="3">합계</td>
        <td><strong><?php echo $sum_count ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        arsort($arr);
        foreach ($arr as $key=>$value) {
            $count = $arr[$key];
            if ($save_count != $count) {
                $i++;
                $no = $i;
                $save_count = $count;
            } else {
                $no = '';
            }

            if (!$key) {
                $key = '기타';
            }

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_num"><?php echo $no ?></td>
        <td class="td_category td_category1"><?php echo $key ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo $count ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '접속기기 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?
}else if($type == 6){	//시간

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;



$colspan = 4;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select SUBSTRING(vi_time,1,2) as vi_hour, count(vi_id) as cnt
            from {$g5['visit_table']}
            where vi_date between '{$fr_date}' and '{$to_date}'
            group by vi_hour
            order by vi_hour ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vi_hour']] = $row['cnt'];

    if ($row['cnt'] > $max) $max = $row['cnt'];

    $sum_count += $row['cnt'];
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">

    <thead>
    <tr>
        <th scope="col">시간</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="2">합계</td>
        <td><strong><?php echo number_format($sum_count) ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $k = 0;
    if ($i) {
        for ($i=0; $i<24; $i++) {
            $hour = sprintf("%02d", $i);
            $count = isset($arr[$hour]) ? (int) $arr[$hour] : 0;

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><?php echo $hour ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo number_format($count) ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>
    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '시간 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?
}else if($type == 7){	//요일

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

$colspan = 4;
$weekday = array ('월', '화', '수', '목', '금', '토', '일');

$sum_count = 0;
$arr = array();

$sql = " select WEEKDAY(vs_date) as weekday_date, SUM(vs_count) as cnt
            from {$g5['visit_sum_table']}
            where vs_date between '{$fr_date}' and '{$to_date}'
            group by weekday_date
            order by weekday_date ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['weekday_date']] = $row['cnt'];

    $sum_count += $row['cnt'];
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">
    <thead>
    <tr>
        <th scope="col">요일</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="2">합계</td>
        <td><strong><?php echo $sum_count ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $k = 0;
    if ($i) {
        for ($i=0; $i<7; $i++) {
            $count = isset($arr[$i]) ? (int) $arr[$i] : 0;

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><?php echo $weekday[$i] ?></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo $count ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '요일 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?
}else if($type == 8){	//일

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

$colspan = 4;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select vs_date, vs_count as cnt
            from {$g5['visit_sum_table']}
            where vs_date between '{$fr_date}' and '{$to_date}'
            order by vs_date desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vs_date']] = $row['cnt'];

    if ($row['cnt'] > $max) $max = $row['cnt'];

    $sum_count += $row['cnt'];
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">
    <thead>
    <tr>
        <th scope="col">년-월-일</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="2">합계</td>
        <td><strong><?php echo number_format($sum_count) ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        foreach ($arr as $key=>$value) {
            $count = $value;

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><a href="./visit_list.php?fr_date=<?php echo $key ?>&amp;to_date=<?php echo $key ?>"><?php echo $key ?></a></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo number_format($value) ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        $i++;
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '일 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?
}else if($type == 9){	//월

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;


$colspan = 4;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select SUBSTRING(vs_date,1,7) as vs_month, SUM(vs_count) as cnt
            from {$g5['visit_sum_table']}
            where vs_date between '{$fr_date}' and '{$to_date}'
            group by vs_month
            order by vs_month desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vs_month']] = $row['cnt'];

    if ($row['cnt'] > $max) $max = $row['cnt'];

    $sum_count += $row['cnt'];
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">

    <thead>
    <tr>
        <th scope="col">년-월</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="2">합계</td>
        <td><strong><?php echo number_format($sum_count) ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        foreach ($arr as $key=>$value) {
            $count = $value;

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><a href="./visit_date.php?fr_date=<?php echo $key ?>-01&amp;to_date=<?php echo $key ?>-31"><?php echo $key ?></a></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo number_format($value) ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        $i++;
        }


    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>

    </tbody>
    </table>
	
	<?
		$excel_file_name = '월 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>



<?
}else if($type == 10){	//년

	$fr_date = isset($_REQUEST['fr_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['fr_date']) : G5_TIME_YMD;
$to_date = isset($_REQUEST['to_date']) ? preg_replace('/[^0-9 :\-]/i', '', $_REQUEST['to_date']) : G5_TIME_YMD;

$colspan = 4;

$max = 0;
$sum_count = 0;
$arr = array();

$sql = " select SUBSTRING(vs_date,1,4) as vs_year, SUM(vs_count) as cnt
            from {$g5['visit_sum_table']}
            where vs_date between '{$fr_date}' and '{$to_date}'
            group by vs_year
            order by vs_year desc ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vs_year']] = $row['cnt'];

    if ($row['cnt'] > $max) $max = $row['cnt'];

    $sum_count += $row['cnt'];
}
?>

<div class="tbl_head01 tbl_wrap">
    <table border="1">
    <thead>
    <tr>
        <th scope="col">년</th>
        <th scope="col">그래프</th>
        <th scope="col">접속자수</th>
        <th scope="col">비율(%)</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <td colspan="2">합계</td>
        <td><strong><?php echo number_format($sum_count) ?></strong></td>
        <td>100%</td>
    </tr>
    </tfoot>
    <tbody>
    <?php
    $i = 0;
    $k = 0;
    $save_count = -1;
    $tot_count = 0;
    if (count($arr)) {
        foreach ($arr as $key=>$value) {
            $count = $value;

            $rate = ($count / $sum_count * 100);
            $s_rate = number_format($rate, 1);

            $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_category"><a href="./visit_month.php?fr_date=<?php echo $key ?>-01-01&amp;to_date=<?php echo $key ?>-12-31"><?php echo $key ?></a></td>
        <td>
            <div class="visit_bar">
                <span style="width:<?php echo $s_rate ?>%"></span>
            </div>
        </td>
        <td class="td_num_c3"><?php echo number_format($value) ?></td>
        <td class="td_num"><?php echo $s_rate ?></td>
    </tr>

    <?php
        }
    } else {
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
	
	<?
		$excel_file_name = '년 접속현황';
		if($fr_date) $excel_file_name .= '_'.$fr_date;
		if($to_date) $excel_file_name .= '_'.$to_date;
	?>


<?}?>


<?
array_to_excel("", $excel_file_name);

?>
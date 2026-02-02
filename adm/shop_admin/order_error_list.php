<?php
$sub_menu = '400402';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$sql_common = " from `g5_shop_order_post_log` ";


$fr_date = isset($_REQUEST['fr_date']) ? $_REQUEST['fr_date'] : '';
$to_date = isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date={$fr_date}&amp;to_date={$to_date}";
$sql_date = " and ol_datetime between date('{$fr_date}') AND DATE_ADD(DATE('{$to_date}'), INTERVAL 1 DAY) ";


$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and cz_subject like '%$stx%' ";
}

$sql_search .= " $sql_date ";
if (!$sst) {
    $sst  = "ol_datetime";
    $sod = "desc";
}
$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt
            {$sql_common}
            {$sql_search} {$sql_date}
            {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
            {$sql_common}
            {$sql_search}
            {$sql_order}
            limit {$from_record}, {$rows} ";
$result = sql_query($sql);

$g5['title'] = '주문 에러 리스트';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$colspan = 9;
?>

<div class="local_ov">
    <span class="btn_ov01"><span class="ov_txt">전체 </span><span class="ov_num"> <?php echo number_format($total_count) ?> 개</span></span>
</div>


<script>
$(function(){
    // 현재 날짜 가져오기
    var today = new Date();
    var threeDaysAgo = new Date(today);
    threeDaysAgo.setDate(today.getDate() - 3);
    
    // datepicker 설정
    $("#fr_date, #to_date").datepicker({ 
        changeMonth: true, 
        changeYear: true, 
        dateFormat: "yy-mm-dd", 
        showButtonPanel: true, 
        yearRange: "c-10:c+10",  // 년도 범위를 현재 ±10년으로 제한 
        maxDate: "+0d",
        defaultDate: today,      // 기본 날짜를 오늘로 설정
        beforeShow: function() {
            // datepicker가 표시되기 전에 현재 연도로 강제 설정
            $(this).datepicker("option", "defaultDate", new Date());
        }
    });
    
    // 시작일에 3일 전 날짜 설정
    var year = threeDaysAgo.getFullYear();
    var month = ('0' + (threeDaysAgo.getMonth() + 1)).slice(-2);
    var day = ('0' + threeDaysAgo.getDate()).slice(-2);
    var formattedDate = year + '-' + month + '-' + day;
    
    if($("#fr_date").val() == "" || $("#fr_date").val() == today.toISOString().split('T')[0]) {
        $("#fr_date").val(formattedDate);
    }
});
</script>
<?php include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');	?>
<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">


	<input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
	<label for="fr_date" class="sound_only">시작일</label>
	~
	<input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
	<label for="to_date" class="sound_only">종료일</label>


<input type="submit" value="검색" class="btn_submit">

</form>
<form name="fcouponlist" id="fcouponzonelist" method="post" action="./couponzonelist_delete.php" onsubmit="return fcouponzonelist_submit(this);">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="token" value="">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">쿠폰 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">주문번호</th>
		<th scope="col">회원아이디</th>
        <th scope="col">에러메시지</th>
        <th scope="col">등록일자</th>
        <th scope="col">등록아이피</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
       

        $bg = 'bg'.($i%2);

		
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <input type="hidden" id="cz_id_<?php echo $i; ?>" name="cz_id[<?php echo $i; ?>]" value="<?php echo $row['cz_id']; ?>">
            <input type="checkbox" id="chk_<?php echo $i; ?>" name="chk[]" value="<?php echo $i; ?>" title="내역선택">
        </td>
        <td class="td_type"><?php echo get_text($row['oid']); ?></td>
		<td class="td_type"><?php echo get_text($row['mb_id']); ?></td>
        <td class="td_type"><?php echo $row['ol_msg']; ?></td>
        <td class="td_type"><?php echo $row['ol_datetime']; ?></td>
        <td class="td_odrnum2"><?php echo $row['ol_ip']; ?></td>

    </tr>

    <?php
    }

    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>



</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fcouponzonelist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
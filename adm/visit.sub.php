<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_LIB_PATH.'/visit.lib.php');
include_once('./admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date=".$fr_date."&amp;to_date=".$to_date;
$query_string = $qstr ? '?'.$qstr : '';
?>

<form name="fvisit" id="fvisit" class="local_sch03 local_sch" method="get">
<div class="sch_last">
    <strong>기간별검색</strong>
    <input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
    <label for="fr_date" class="sound_only">시작일</label>
    ~
    <input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
    <label for="to_date" class="sound_only">종료일</label>
    <input type="submit" value="검색" class="btn_submit">
	<span><a href="#" onclick="goExcel(<?=$type?>)" class="btn_excel_download" target="_blank"></a></span>
</div>
</form>

<script>

function goExcel(type){

	//if(type == 1){
		var fr_date = $('input[name=fr_date]').val();
		var to_date = $('input[name=to_date]').val();
		location.href='<?=G5_ADMIN_URL?>/_excel_visit_list.php?type='+type+'&fr_date='+fr_date+'&to_date='+to_date;


	//}
}
</script>

<ul class="anchor">
    <li><a href="./visit_list.php<?php echo $query_string ?>&type=1">접속자</a></li>
    <li><a href="./visit_domain.php<?php echo $query_string ?>&type=2">도메인</a></li>
    <li><a href="./visit_browser.php<?php echo $query_string ?>&type=3">브라우저</a></li>
    <li><a href="./visit_os.php<?php echo $query_string ?>&type=4">운영체제</a></li>
    <?php if(version_compare(phpversion(), '5.3.0', '>=') && defined('G5_BROWSCAP_USE') && G5_BROWSCAP_USE) { ?>
    <li><a href="./visit_device.php<?php echo $query_string ?>&type=5">접속기기</a></li>
    <?php } ?>
    <li><a href="./visit_hour.php<?php echo $query_string ?>&type=6">시간</a></li>
    <li><a href="./visit_week.php<?php echo $query_string ?>&type=7">요일</a></li>
    <li><a href="./visit_date.php<?php echo $query_string ?>&type=8">일</a></li>
    <li><a href="./visit_month.php<?php echo $query_string ?>&type=9">월</a></li>
    <li><a href="./visit_year.php<?php echo $query_string ?>&type=10">년</a></li>
</ul>

<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});

function fvisit_submit(act)
{
    var f = document.fvisit;
    f.action = act;
    f.submit();
}
</script>

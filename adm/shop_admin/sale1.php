<?php
$sub_menu = '500110';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '매출현황';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>
<script>

function goExcel(type){

	if(type == 1){
		var date = $('input[name=date]').val();
		location.href='<?=G5_ADMIN_URL?>/shop_admin/my/_excel_sale.php?type=1&date='+date;

	}else if(type == 2){
		var fr_date = $('input[name=fr_date]').val();
		var to_date = $('input[name=to_date]').val();
		location.href='<?=G5_ADMIN_URL?>/shop_admin/my/_excel_sale.php?type=2&fr_date='+fr_date+'&to_date='+to_date; 

	}else if(type == 3){
		var fr_month = $('input[name=fr_month]').val();
		var to_month = $('input[name=to_month]').val();
		location.href='<?=G5_ADMIN_URL?>/shop_admin/my/_excel_sale.php?type=3&fr_month='+fr_month+'&to_month='+to_month;
		
	}else if(type == 4){
		var fr_year = $('input[name=fr_year]').val();
		var to_year = $('input[name=to_year]').val();
		location.href='<?=G5_ADMIN_URL?>/shop_admin/my/_excel_sale.php?type=4&fr_year='+fr_year+'&to_year='+to_year;
		
	}
}
</script>

<div class="local_sch03 local_sch">

    <div>
        <form name="frm_sale_today" action="./sale1today.php" method="get">
        <strong>일일 매출</strong>
        <input type="text" name="date" value="<?php echo date("Ymd", G5_SERVER_TIME); ?>" id="date" required class="required frm_input" size="8" maxlength="8">
        <label for="date">일 하루</label>
        <input type="submit" value="확인" class="btn_submit">
		<a href="#" onclick="goExcel(1)" class="btn_excel_download" target="_blank"></a>
        </form>
    </div>

    <div>
        <form name="frm_sale_date" action="./sale1date.php" method="get">
        <strong>일간 매출</strong>
        <input type="text" name="fr_date" value="<?php echo date("Ym01", G5_SERVER_TIME); ?>" id="fr_date" required class="required frm_input" size="8" maxlength="8">
        <label for="fr_date">일 ~</label>
        <input type="text" name="to_date" value="<?php echo date("Ymd", G5_SERVER_TIME); ?>" id="to_date" required class="required frm_input" size="8" maxlength="8">
        <label for="to_date">일</label>
        <input type="submit" value="확인" class="btn_submit">
		<a href="#" onclick="goExcel(2)" class="btn_excel_download" target="_blank"></a>
        </form>
    </div>

    <div>
        <form name="frm_sale_month" action="./sale1month.php" method="get">
        <strong>월간 매출</strong>
        <input type="text" name="fr_month" value="<?php echo date("Y01", G5_SERVER_TIME); ?>" id="fr_month" required class="required frm_input" size="6" maxlength="6">
        <label for="fr_month">월 ~</label>
        <input type="text" name="to_month" value="<?php echo date("Ym", G5_SERVER_TIME); ?>" id="to_month" required class="required frm_input" size="6" maxlength="6">
        <label for="to_month">월</label>
        <input type="submit" value="확인" class="btn_submit">
		<a href="#" onclick="goExcel(3)" class="btn_excel_download" target="_blank"></a>
        </form>
    </div>

    <div class="sch_last">
        <form name="frm_sale_year" action="./sale1year.php" method="get">
        <strong>연간 매출</strong>
        <input type="text" name="fr_year" value="<?php echo date("Y", G5_SERVER_TIME)-1; ?>" id="fr_year" required class="required frm_input" size="4" maxlength="4">
        <label for="fr_year">년 ~</label>
        <input type="text" name="to_year" value="<?php echo date("Y", G5_SERVER_TIME); ?>" id="to_year" required class="required frm_input" size="4" maxlength="4">
        <label for="to_year">년</label>
        <input type="submit" value="확인" class="btn_submit">
		<a href="#" onclick="goExcel(4)" class="btn_excel_download" target="_blank"></a>
        </form>
    </div>

</div>

<script>
$(function() {
    $("#date, #fr_date, #to_date").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yymmdd",
        showButtonPanel: true,
        yearRange: "c-99:c+99",
        maxDate: "+0d"
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!defined('_SEARCH_')) define('_SEARCH_', true);


//인기검색어 (기준은 30일전부터 오늘까지 검색어중 랭킹을 얻는다..)
$to_date = date("Y-m-d");
$fr_date = date('Y-m-d',strtotime($to_date."-30 day"));
if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;
/*
$popular_sql_common = " from {$g5['popular_table']} a ";
$popular_sql_search = " where trim(pp_word) <> '' and pp_date between '{$fr_date}' and '{$to_date}' ";
$popular_sql_group = " group by pp_word ";
$popular_sql_order = " order by cnt desc ";
$popular_sql = " select pp_word, count(*) as cnt {$popular_sql_common} {$popular_sql_search} {$popular_sql_group} {$popular_sql_order} limit 0, 10 ";
$popular_result = sql_query($popular_sql);*/

?>



<!-- 검색 시작 { -->
<div id="_shopSearch">

    <div id="_search_form" class="">
        <form name="frmdetailsearch">
        <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
        <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
        <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
        <div class="sch_wr">
            <div class="title">어떤 상품을 찾아드릴까요?</div>
			<div class="inputContainer">
				<input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="" maxlength="30" placeholder="검색어를 입력해 주세요">
				<button type="submit" class="sch_submit"><span class="sound_only">검색</span></button>
			</div>
        </div>         
        </form>
		
		
		<div class="popular_sch_wr">
			<div class="title">인기검색어</div>
			<ul>
				<?php for ($g=1; $g <= 10; $g++) {
					if($default['de_popular_'.$g]){
						echo '<li><a href="'.shop_short_url_my('search','','q='.$default['de_popular_'.$g]).'"><span class="rank" 
						style="width:10px">'.$g.'</span>'.$default['de_popular_'.$g].'</a></li>';
					}
				} ?>
			</ul>
		</div>
		
    </div>
		
	<?php if($q) { ?>
	<div class="sch_result">
		
		<?php if($q && $total_count > 0) { //검색어가 있을때...?>
		<div id="ssch_sort">
			<select class="select_sort selectpicker">
				<?php
				echo option_selected("",  $qsort, "상품정렬");
				echo option_selected("it_sum_qty",  $qsort, "판매많은순");
				echo option_selected("it_price_asc",  $qsort, "낮은가격순");
				echo option_selected("it_price_desc",  $qsort, "높은가격순");
				echo option_selected("it_use_avg",  $qsort, "평점높은순");
				echo option_selected("it_use_cnt",  $qsort, "후기많은순");
				echo option_selected("it_update_time",  $qsort, "최근등록순");
				?>
			</select>
		</div>
		<?php } ?>

		<?php
		// 리스트 유형별로 출력
		if (isset($list) && is_object($list) && method_exists($list, 'run')) {
			$list->set_is_page(true);
			$list->set_mobile(true);
			$list->set_view('it_img', true);
			$list->set_view('it_id', false);
			$list->set_view('it_name', true);
			$list->set_view('it_basic', true);
			$list->set_view('it_cust_price', false);
			$list->set_view('it_price', true);
			$list->set_view('it_icon', true);
			$list->set_view('sns', true);
			echo $list->run();
		} else {
			$i = 0;
			$error = '<p class="sct_nofile">'.$list_file.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
		}

		if ($i==0) echo '<div>'.$error.'</div>';

		$query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid.'&amp;qbasic='.$qbasic;
		if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
		$query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
		$query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
		echo get_paging($config['cf_mobile_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
		?>
	</div>
	<?php } ?>
	
	
	<?php if(!$q || $total_count == 0) { //검색어가 없거나, 검색결과가 없을때
		include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
		echo '<div id="shopblock">';
		if($is_admin == 'super') {
			echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=search&title=블럭관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">블럭관리</a>';
		}
		echo shop_block('search');
		echo '</div>';
	} ?>
	

</div>
<!-- } 검색 끝 -->

<script>
$("select.select_sort").change(function() {
	var val = $(this).val();
	if(val == '') set_sort('', '');
	if(val == 'it_sum_qty') set_sort('it_sum_qty', 'desc'); //판매많은순
	if(val == 'it_price_asc') set_sort('it_price', 'asc'); //낮은가격순
	if(val == 'it_price_desc') set_sort('it_price', 'desc'); //높은가격순
	if(val == 'it_use_avg') set_sort('it_use_avg', 'desc'); //평점높은순
	if(val == 'it_use_cnt') set_sort('it_use_cnt', 'desc'); //후기많은순
	if(val == 'it_update_time') set_sort('it_update_time', 'desc'); //최근등록순
});


function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}


/*$(".btn_sort").click(function(){
    $("#ssch_sort ul").show();
});
$(document).mouseup(function (e){
    var container = $("#ssch_sort ul");
    if( container.has(e.target).length === 0)
		container.hide();
});*/

</script>
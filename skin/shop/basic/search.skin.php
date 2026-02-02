<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
if (!defined('_SEARCH_')) define('_SEARCH_', true);

?>
<?php if ($is_admin) {
	//echo '<div class="sit_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/configform.php#anc_scf_etc" class="btn_admin btn">dfgdfg<span class="sound_only">검색 설정</span></a></div>';
} ?>

<div id="_shopSearch" class="max-width">

    <div id="_search_form" class="">
        <form name="frmdetailsearch">
        <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
        <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
        <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
        <div class="sch_wr">
            <div class="title">어떤 상품을 찾아드릴까요?</div>
			<div class="inputContainer">
				<input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="frm_input" maxlength="30" placeholder="검색어를 입력해 주세요">
				<button type="submit" class="sch_submit"><span class="sound_only">검색</span></button>
			</div>
        </div>         
        </form>
		


	
	<div class="sch_result">
		
	<?php
	//if($_SERVER["REMOTE_ADDR"] == "125.246.29.210"){
		if(strlen($q) > 3){
			echo '<ul class="gall_ul" style="padding-top:40px;padding-bottom:30px">';

			$b_result = sql_query(" select * from `g5_write_partners` where wr_subject like '%".$q."%' ");
			//echo " select * from `g5_write_partners` where wr_subject like '%".$q."%' ";
			for ($b=0; $rowb=sql_fetch_array($b_result); $b++) {

				$thum = sql_fetch(" select bf_file from `g5_board_file` where wr_id = '".$rowb['wr_id']."' and bo_table = 'partners' ");

				echo '<li class="gall_li"><div class="gallContents">';
				echo '<div class="gall_thumb"><a href="'.G5_BBS_URL.'/board.php?bo_table=partners&amp;wr_id='.$rowb['wr_id'].'" alt="SM BEACON HOLDINGS 상세보기"><img style="width:'.($rowb['ca_name']=='셰프관'?'210px;':'285px;').'" src="'.G5_URL.'/data/file/partners/'.$thum['bf_file'].'" class="" alt="SM BEACON HOLDINGS" title=""></a></div>';
				
				echo '</div></li>';
			}	

			echo '</ul>';
		}
	//}
	
	?>

	</div>
<!--
		<ul class="gall_ul">
			<li class="gall_li"><div class="gallContents">	
					<div class="gall_thumb"><a href="<?php echo G5_BBS_URL?>/board.php?bo_table=partners&amp;wr_id=<?=$rowb['wr_id']?>" alt="SM BEACON HOLDINGS 상세보기"><img src="https://kaviar.testlink.or.kr/data/file/partners/thumb-d3847141f20b0413e289a794433aa9d0_AP6b8fq2_953cf4d2b3c06d135b6be6c0a1456d613aed8636_285x105.png" class="" alt="SM BEACON HOLDINGS" title=""></a></div>				
			</div></li>
			
		</ul>
-->


		<?php if(!$q) { //검색어가 없을때...?>
		<div class="popular_sch_wr">
			<div class="title">인기검색어</div>
			<ul>
				<?php
				//인기검색어 (기준은 30일전부터 오늘까지 검색어중 랭킹을 얻는다..)
				$to_date = date("Y-m-d");
				$fr_date = date('Y-m-d',strtotime($to_date."-30 day"));
				if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
				if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

				$popular_hot_sql_common = " from {$g5['popular_table']} a ";
				$popular_hot_sql_search = " where trim(pp_word) <> '' and pp_date between '{$fr_date}' and '{$to_date}' ";
				$popular_hot_sql_group = " group by pp_word ";
				$popular_hot_sql_order = " order by cnt desc ";
				$popular_hot_sql = " select pp_word, count(*) as cnt {$popular_hot_sql_common} {$popular_hot_sql_search} {$popular_hot_sql_group} {$popular_hot_sql_order} limit 0, 10 ";
				$popular_hot_result = sql_query($popular_hot_sql);

				for ($i=0; $row=sql_fetch_array($popular_hot_result); $i++) {
					$word = get_text($row['pp_word']);
					$rank = $i + 1;
					echo '<li><a href="'.shop_short_url_my('search','','q='.$word).'"><span class="rank">'.$rank.'</span>'.$word.'</a></li>';
				}
				?>
			</ul>
		</div>
		<?php } ?>
    </div>
		
	<?php if($q) { ?>
	<div class="sch_result">

	<?php

		$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';
	?>



		<?php if($q && $total_count > 0) { //검색어가 있을때...?>
		<div id="ssch_sort">
			<section id="_sct_sort">
			<ul>
				<li><a href="<?php echo $sct_sort_href; ?>qsort=it_update_time&amp;qorder=desc&q=<?=$q?>"<?=$_GET['qsort']=='it_update_time'?' class="active"':''?>>신상품순</a></li>
				<li><a href="<?php echo $sct_sort_href; ?>qsort=it_sum_qty&amp;qorder=desc&q=<?=$q?>"<?=$_GET['qsort']=='it_sum_qty'?' class="active"':''?>>판매량순</a></li>
				<li><a href="<?php echo $sct_sort_href; ?>qsort=it_price&amp;qorder=asc&q=<?=$q?>" <?=$_GET['qsort']=='it_price'&&$_GET['qorder']=='asc'?' class="active"':''?>>낮은가격순</li>
				<li><a href="<?php echo $sct_sort_href; ?>qsort=it_price&amp;qorder=desc&q=<?=$q?>" <?=$_GET['qsort']=='it_price'&&$_GET['qorder']=='desc'?' class="active"':''?>>높은가격순</a></li>
			</ul>
		</section>
		<!--
			<ul id="ssch_sort_all">
				<li><a href="#" onclick="set_sort('it_sum_qty', 'desc'); return false;">판매많은순</a></li>
				<li><a href="#" onclick="set_sort('it_price', 'asc'); return false;">낮은가격순</a></li>
				<li><a href="#" onclick="set_sort('it_price', 'desc'); return false;">높은가격순</a></li>
				<li><a href="#" onclick="set_sort('it_use_avg', 'desc'); return false;">평점높은순</a></li>
				<li><a href="#" onclick="set_sort('it_use_cnt', 'desc'); return false;">후기많은순</a></li>
				<li><a href="#" onclick="set_sort('it_update_time', 'desc'); return false;">최근등록순</a></li>
			</ul>
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
			</select>-->
		</div>
		<?php } ?>

		<?php
		$order_by = " 123123 ";
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






<div id="ssch" class="none">
	<h2><strong><?php echo $q; ?></strong> 검색 결과<span class="ssch_result_total">총 <?php echo $total_count; ?>건</span></h2>
    <!-- 상세검색 항목 시작 { -->
    <div id="ssch_frm">
		<div class="ssch_frm_inner">
	        <form name="frmdetailsearch">
	        <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
	        <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
	        <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
	        <div class="ssch_scharea">
	            <label for="ssch_q" class="sound_only" >검색어</label>
	            <input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="ssch_input" size="40" maxlength="30" placeholder="검색어">
	            <button type="submit" class="btn_submit"><i class="fa fa-search" aria-hidden="true"></i> 검색</button>
	            <button type="button" class="tooltip_icon"><i class="fa fa-question-circle-o" aria-hidden="true"></i><span class="sound_only">설명보기</span></button>
	            <span class="tooltip">
		            상세검색을 선택하지 않거나, 상품가격을 입력하지 않으면 전체에서 검색합니다.<br>
		            검색어는 최대 30글자까지, 여러개의 검색어를 공백으로 구분하여 입력 할수 있습니다.
		        </span>
	        </div>
	        <div class="ssch_option chk_box">
	            <strong class="sound_only">검색범위</strong>
	            <input type="checkbox" name="qname" id="ssch_qname" value="1" <?php echo $qname_check?'checked="checked"':'';?>> <label for="ssch_qname"><span></span>상품명</label>
	            <input type="checkbox" name="qexplan" id="ssch_qexplan" value="1" <?php echo $qexplan_check?'checked="checked"':'';?>> <label for="ssch_qexplan"><span></span>상품설명</label>
	            <input type="checkbox" name="qbasic" id="ssch_qbasic" value="1" <?php echo $qbasic_check?'checked="checked"':'';?>> <label for="ssch_qbasic"><span></span>기본설명</label>
	            <input type="checkbox" name="qid" id="ssch_qid" value="1" <?php echo $qid_check?'checked="checked"':'';?>> <label for="ssch_qid"><span></span>상품코드</label>
	            <strong class="sound_only">상품가격 (원)</strong>
	            <label for="ssch_qfrom" class="sound_only">최소 가격</label>
	            <input type="text" name="qfrom" value="<?php echo $qfrom; ?>" id="ssch_qfrom" class="ssch_input" size="10"> 원 ~
	            <label for="ssch_qto" class="sound_only">최대 가격</label>
	            <input type="text" name="qto" value="<?php echo $qto; ?>" id="ssch_qto" class="ssch_input" size="10"> 원
	        </div>
        	</form>
		</div>
		<!-- 검색된 분류 시작 { -->
	    <div id="ssch_cate">
	        <ul>
	        <?php
	        echo '<li><a href="#" onclick="set_ca_id(\'\'); return false;">전체분류 <span>('.$total_count.')</span></a></li>'.PHP_EOL;
            $total_cnt = 0;
	        foreach((array) $categorys as $row){
                if( empty($row) ) continue;
	            echo "<li><a href=\"#\" onclick=\"set_ca_id('{$row['ca_id']}'); return false;\">{$row['ca_name']} (".$row['cnt'].")</a></li>\n";
	            $total_cnt += $row['cnt'];
	        }
	        ?>
	        </ul>
	    </div>
	    <!-- } 검색된 분류 끝 -->

        <ul id="ssch_sort_all">
            <li><a href="#" onclick="set_sort('it_sum_qty', 'desc'); return false;">판매많은순</a></li>
            <li><a href="#" onclick="set_sort('it_price', 'asc'); return false;">낮은가격순</a></li>
            <li><a href="#" onclick="set_sort('it_price', 'desc'); return false;">높은가격순</a></li>
            <li><a href="#" onclick="set_sort('it_use_avg', 'desc'); return false;">평점높은순</a></li>
            <li><a href="#" onclick="set_sort('it_use_cnt', 'desc'); return false;">후기많은순</a></li>
            <li><a href="#" onclick="set_sort('it_update_time', 'desc'); return false;">최근등록순</a></li>
        </ul>
	    <!-- } 상세검색 항목 끝 -->
	</div>	
    <!-- 검색결과 시작 { -->
    <div>
        <?php
        // 리스트 유형별로 출력
        if (isset($list) && is_object($list) && method_exists($list, 'run')) {
            $list->set_is_page(true);
            $list->set_view('it_img', true);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', true);
            $list->set_view('star', true);
            echo $list->run();
        }
        else
        {
            $i = 0;
            $error = '<p class="sct_nofile">'.$list_file.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
        }

        if ($i==0)
        {
            echo '<div>'.$error.'</div>';
        }

		

        $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid;
        if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
        $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
        $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
        echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
        ?>
    </div>
    <!-- } 검색결과 끝 -->
</div>
<!-- } 검색 끝 -->

<script>
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

$(function(){
	//tooltip
    $(".tooltip_icon").click(function(){
        $(this).next(".tooltip").fadeIn(400);
    }).mouseout(function(){
        $(this).next(".tooltip").fadeOut();
    });
});

// 검색옵션
$("#ssch_sort_all li a").click(function() {
    $(this).parent().addClass('active');
});
</script>
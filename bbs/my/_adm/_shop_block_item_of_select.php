<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//상품 목록 불러오기

// 분류
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);

$_get_url = explode('&sca=', $callback_url);
$shop_item_category_str .= '<li><a href="'.$_get_url[0].'&sca=" class="tab'.(!$sca?' active':'').'">전체상품</a></li>';
for ($i=0; $row=sql_fetch_array($result); $i++) {
	$shop_item_category_str .= '<li><a href="'.$_get_url[0].'&sca='.$row['ca_id'].'" class="tab'.($row['ca_id']==$sca?' active':'').'">'.$row['ca_name'].'</a></li>';
}
if($shop_item_category_str) $shop_item_category_str = '<ul>'.$shop_item_category_str.'</ul>';


$where = " and ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " $where (a.ca_id like '$sca%' or a.ca_id2 like '$sca%' or a.ca_id3 like '$sca%') ";
}

if ($type != "") {
    $sql_search .= " $where (a.it_type1 like '$type%' or a.it_type2 like '$type%' or a.it_type3 like '$type%' or a.it_type4 like '$type%' or a.it_type5 like '$type%') ";
}

if ($sfl == "")  $sfl = "it_name";

$sql_common = " from {$g5['g5_shop_item_table']} a ,
                     {$g5['g5_shop_category_table']} b
               where (a.ca_id = b.ca_id";
if ($is_admin != 'super')
    $sql_common .= " and b.ca_mb_id = '{$member['mb_id']}'";
$sql_common .= ") ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 100;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst) {
    $sst  = "it_id";
    $sod = "desc";
}
$sql_order = "order by $sst $sod";

$sql  = " select *
           $sql_common
           $sql_order
           limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page;
$qstr  = $qstr.'&amp;sca='.$sca.'&amp;page='.$page.'&amp;save_stx='.$stx;

echo '<script src="'.G5_JS_URL.'/my/countdown/jquery.plugin.js"></script>';
echo '<script src="'.G5_JS_URL.'/my/countdown/jquery.countdown.js"></script>';
?>


<div id="shop_item_tabs">
	<?=$shop_item_category_str?>
</div>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_block_list_of_select_push.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="input_id" value="<?=$input_id?>">
<div class="_list_of_select_form">
	<div class="list_form_ul n2">
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$itemImg[$i] = get_it_image($row['it_id'], 100, 100);
			$ca_name1[$i] = get_shopCate_name($row['ca_id']);
			$ca_name2[$i] = get_shopCate_name($row['ca_id2']);
			$ca_name3[$i] = get_shopCate_name($row['ca_id3']);
			$ca_name[$i] = '';
			$ca_name[$i] .= $ca_name1[$i] ? '<sub>'.$ca_name1[$i].'</sub>' : '';
			$ca_name[$i] .= $ca_name2[$i] ? '<sub>'.$ca_name2[$i].'</sub>' : '';
			$ca_name[$i] .= $ca_name3[$i] ? '<sub>'.$ca_name3[$i].'</sub>' : '';

			$it_timer_arr[$i] = explode('|', $row['it_timer']);

			echo '<div class="list_form_li">';	
				echo '<label class="labelContainer">';
					echo '<input type="'.$check_type.'" name="chk_li_id[]" value="'.$row['it_id'].'" id="chk_li_id_'.$i.'" '.(in_array($row['it_id'], $sel_li_id)?'checked':'').'><span class="chkSpan"></span>';						
					echo '<div class="wzContents flex-stretch">';							
						if($itemImg) echo '<div class="wz_thumb">'.$itemImg[$i].'</div>';			
						echo '<div class="wz_con gap5 column flex-top">';
							if($ca_name[$i]) echo '<div class="ca_name_set">'.$ca_name[$i].'</div>';
							
							if($it_timer_arr[$i][0]) echo get_buy_timer($row['it_id']);
							echo '<div class="fs13 bold">';
								echo htmlspecialchars2(cut_str($row['it_name'],250, ""));
							echo '</div>';
							echo '<div class="flex flex-middle gap10">';
								echo '<div class="middleline price">'.display_price($row['it_cust_price']).'</div>';
								echo '<div class="color-red bold price">'.display_price($row['it_price']).'</div>';
							echo '</div>';							
							for ($t=0; $t < count($itemtype); $t++) {
								$num = $t + 1;
								if($row['it_type'.$num]) {
									$_gettype[$i] .= '<sub class="tag-itemtype" style="font-size:11px;height:15px;padding:0 4px;border-radius:4px;background:rgba(71,78,103,0.4);color:#fff !important;display:inline-flex;align-items:center;justify-content:center;">'.$itemtype[$t].'</sub>';
								}
							}
							if($_gettype[$i]) echo '<div class="inline-flex flex-middle gap5 mt-auto">'.$_gettype[$i].'</div>';

						echo '</div>';
					echo '</div>';
				echo '</label>';
			echo '</div>';
		}
		if($i == 0) echo '<div class="empty_li">등록된 배너가 없습니다.</div>';
		?>
	</div>

	<?=get_paging(10, $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?pn=".$pn."&$qstr&amp;page=")?>

	<div class="bo_btnSet">
		<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
    </div>

</div>
</form>

<script>
var beforeChecked = -1;
$(function(){
	$(document).on("click", "input[type=radio]", function(e) {
		var index = $(this).parent().index("label");
		if(beforeChecked == index) {
			beforeChecked = -1;
			$(this).prop("checked", false);
		} else {
			beforeChecked = index;
		}
	});
});
</script>
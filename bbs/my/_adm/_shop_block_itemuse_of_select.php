<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가



$where = " where ";
$sql_search = "";

$save_stx = isset($_REQUEST['save_stx']) ? clean_xss_tags($_REQUEST['save_stx'], 1, 1) : '';

if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " and ca_id like '$sca%' ";
}

if ($sfl == "")  $sfl = "a.it_name";
if (!$sst) {
    $sst = "is_id";
    $sod = "desc";
}

$sql_common = "  from {$g5['g5_shop_item_use_table']} a
                 left join {$g5['g5_shop_item_table']} b on (a.it_id = b.it_id)
                 left join {$g5['member_table']} c on (a.mb_id = c.mb_id) ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 150;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select * $sql_common order by $sst $sod, is_id desc
          limit $from_record, $rows ";
$result = sql_query($sql);
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_block_list_of_select_push.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">

<div class="_list_of_select_form">
	<div class="list_form_ul n2">
		<?php
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$href = shop_item_url($row['it_id']);
			$name = get_sideview($row['mb_id'], get_text($row['is_name']), $row['mb_email'], $row['mb_homepage']);
			$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), 300);
			$star = get_star($row['is_score']);

			echo '<div class="list_form_li">';	
				echo '<label class="labelContainer">';
					echo '<input type="checkbox" name="chk_li_id[]" value="'.$row['is_id'].'" id="chk_li_id_'.$i.'" '.(in_array($row['is_id'], $sel_li_id)?'checked':'').'><span class="chkSpan"></span>';						
					echo '<div class="wzContents">';
							
						echo '<div class="wz_con gap5">';
							echo '<div class="inline-flex flex-middle gap10" style="padding-bottom:10px;border-bottom:1px solid rgba(0,0,0,0.07);">';
								echo '<a href="'.$href.'" target="_blank">'.get_it_image($row['it_id'], 36, 36).'</a>';	
								echo '<div class="color-gray">'.cut_str($row['it_name'],30).'</div>';
							echo '</div>';
							echo '<div class="mt5">';
								echo '<div class="inline-flex gap10 color-gray">';
									echo '<div>'.get_text($row['is_name']).'</div>';
									echo '<div>'.substr($row['is_time'],0,10).'</div>';
								echo '</div>';
								echo '<div class="grade mt5" data-score="'.$star.'"><div class="star"></div></div>';
								echo '<div class=" mt10">'.$is_content.'</div>';
							echo '</div>';							

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
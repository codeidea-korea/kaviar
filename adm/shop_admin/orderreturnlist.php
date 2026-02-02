<?php
$sub_menu = '400401';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '교환/반품/환불';
include_once (G5_ADMIN_PATH.'/admin.head.php');

//$where = " where ";
$sql_search = "where (1) ";
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

if($returno!=""){
	$sql_search .= " and ";
	$sql_search .= " (a.return_order = '$returno') ";

	$qstr .= "&returno=".$returno;
}


if ($sfl == "")  $sfl = "a.return_date";
if (!$sst) {
    $sst = "return_date";
    $sod = "desc";
}

$sql_common = "  from `g5_shop_order_return` a left join {$g5['member_table']} b on (a.return_mb_id = b.mb_id) ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
          $sql_common
          order by $sst $sod 
          limit $from_record, $rows ";
$result = sql_query($sql);


//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';
?>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get" action="?<?=$qstr?>">
	
	<select name="returno" id="returno" class="selectbox">
		<option value="">-요청내역-</option>
		
		<option value="반품" <?=("반품"==$returno?"selected":"")?>>반품</option>
		<option value="취소" <?=("취소"==$returno?"selected":"")?>>취소</option>
		<option value="교환" <?=("교환"==$returno?"selected":"")?>>교환</option>
		<option value="환불" <?=("환불"==$returno?"selected":"")?>>환불</option>
	
	</select>

</form>


<script type="text/javascript">


<? if($mbgrade!="") { ?>
	$("#returno").val("<?=$returno?>");
<? } ?>


$(function(){	
	$("#returno").change(function(){
        document.fsearch.submit();
    });
});


</script>


<form name="fitemuselist" method="post" action="./itemuselistupdate.php" onsubmit="return fitemuselist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap" id="itemuselist">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">사용후기 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col">종류</a></th>
        <th scope="col">상품명</a></th>
        <th scope="col">요청타입</a></th>
        <th scope="col">요청내용</a></th>
        <th scope="col">금액</a></th>
        <th scope="col">확인</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $href = shop_item_url($row['it_id']);
        //$name = get_sideview($row['mb_id'], get_text($row['is_name']), $row['mb_email'], $row['mb_homepage']);
		$name = get_text($row['is_name']);
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), 300);

        $bg = 'bg'.($i%2);

	// 상품목록
	$itemsql = " select it_id, it_name  from {$g5['g5_shop_cart_table']} where od_id = '{$row['return_od_id']}' group by it_id order by ct_id ";
	$itemresult = sql_query($itemsql);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['is_subject']) ?> 사용후기</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="is_id[<?php echo $i; ?>]" value="<?php echo $row['is_id']; ?>">
            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
        </td>
		<td class="td_name"><?php echo $row['return_order']; ?></td>
        <td class="td_left">
			
			<?php 
			for($t=0; $itemrow=sql_fetch_array($itemresult); $t++) {
				echo $itemrow['it_name'];
				// 상품의 옵션정보
				$optionsql = " select ct_id, it_id, ct_price, ct_point, ct_qty, ct_option, ct_status, cp_price, ct_stock_use, ct_point_use, ct_send_cost, io_type, io_price
							from {$g5['g5_shop_cart_table']}
							where od_id = '{$row['return_od_id']}'
							  and it_id = '{$itemrow['it_id']}'
							order by io_type asc, ct_id asc ";
				$res = sql_query($optionsql);
				for($k=0; $opt=sql_fetch_array($res); $k++) {
					if($k == 0){
						echo '<br>->'.get_text($opt['ct_option']).'<br>';
					}else{
						echo '->'.get_text($opt['ct_option']);
					}
				 }
			} ?>

        </td>
        <td class="td_name"><?php echo $row['return_type']; ?></td>
        <td class="sit_use_subject td_left">
            <?php echo $row['return_memo']; ?>
        </td>
        <td class="td_select">
            <?php echo number_format($row['return_price']); ?>
        </td>

        <td class="td_mng td_mng_s">
            <a href="./orderform.php?od_id=<?php echo $row['return_od_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03"><span class="sound_only"><?php echo get_text($row['is_subject']); ?> </span>반품</a>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="7" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>
<!--
<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
</div>
-->
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemuselist_submit(f)
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

$(function(){
    $(".use_href").click(function(){
        var $content = $("#use_div"+$(this).attr("target"));
        $(".use_div").each(function(index, value){
            if ($(this).get(0) == $content.get(0)) { // 객체의 비교시 .get(0) 를 사용한다.
                $(this).is(":hidden") ? $(this).show() : $(this).hide();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
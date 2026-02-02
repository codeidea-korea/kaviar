<?php
$sub_menu = '400651';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '1:1문의';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$fr_date = isset($_REQUEST['fr_date']) ? $_REQUEST['fr_date'] : '';
$to_date = isset($_REQUEST['to_date']) ? $_REQUEST['to_date'] : '';

if (empty($fr_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $fr_date) ) $fr_date = G5_TIME_YMD;
if (empty($to_date) || ! preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $to_date) ) $to_date = G5_TIME_YMD;

$qstr = "fr_date={$fr_date}&amp;to_date={$to_date}";
$sql_date = " and wr_datetime between date('{$fr_date}') AND DATE_ADD(DATE('{$to_date}'), INTERVAL 1 DAY) ";

//$where = " where a.wr_is_comment = 0 ";
$sql_search = " where a.wr_is_comment = 0 and wr_del = 'N' {$sql_date} ";
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

if ($sfl == "")  $sfl = "it_name";
if (!$sst) {
    $sst = "wr_id";
    $sod = "desc";
}

$sql_common = "  from `g5_write_11_inquiry` a left join {$g5['member_table']} c on (a.mb_id = c.mb_id) ";
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




<div class="local_ov01 local_ov">
    <?php echo $listall; ?>
    <span class="btn_ov01"><span class="ov_txt"> 전체 문의내역</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
</div>
<?php include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');	?>
<script>
$(function(){
    $("#fr_date, #to_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99", maxDate: "+0d" });
});
</script>
<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">

	<input type="text" name="fr_date" value="<?php echo $fr_date ?>" id="fr_date" class="frm_input" size="11" maxlength="10">
	<label for="fr_date" class="sound_only">시작일</label>
	~
	<input type="text" name="to_date" value="<?php echo $to_date ?>" id="to_date" class="frm_input" size="11" maxlength="10">
	<label for="to_date" class="sound_only">종료일</label>
	<input type="submit" class="btn_sch2" value="검색">

</form>

<form name="fitemqalist" method="post" action="./itemonelistupdate.php" onsubmit="return fitemqalist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap" id="itemqalist">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">상품문의 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
		<th scope="col"><?php echo subject_sort_link('mb_id'); ?>구분</a></th>
		<th scope="col"><?php echo subject_sort_link('wr_hp'); ?>연락처</a></th>
        <th scope="col"><?php echo subject_sort_link('wr_subject'); ?>제목</a></th>
        <th scope="col"><?php echo subject_sort_link('wr_content'); ?>질문</a></th>
		<th scope="col"><?php echo subject_sort_link('wr_datetime'); ?>등록일자</a></th>
        <th scope="col"><?php echo subject_sort_link('mb_name'); ?>이름</a></th>
        <th scope="col"><?php echo subject_sort_link('iq_answer'); ?>답변</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$iq_question = $row['wr_content'];
        $row['wr_content'] = cut_str($row['wr_content'], 30, "...");
        $href = shop_item_url($row['it_id']);
        $name = $row['wr_name'];
        
  
        $bg = 'bg'.($i%2);

		$ans = sql_fetch(" select * from `g5_write_11_inquiry` where wr_parent = '".$row['wr_id']."' and wr_is_comment = 1 ");

		$answer = $ans['wr_id'] ? 'Y' : '&nbsp;';
		$iq_answer = $ans['wr_content'] ? get_view_thumbnail(conv_content($ans['wr_content'], 1), 300) : "답변이 등록되지 않았습니다.";
     ?>
    <tr class="<?php echo $bg; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['wr_content']) ?> 상품문의</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $row['wr_id']; ?>">
        </td>
		<td class="td_mng td_mng_s"><?php echo $row['md_id'] ? '회원' : '비회원'; ?></td>
		<td class="td_mng td_mng_s"><?php echo $row['wr_email']."<br>".$row['wr_hp']; ?></td>
        <td class="td_left"><a href="<?php echo $href; ?>"><?php echo cut_str($row['wr_subject'],30); ?></td>
        <td class="td_left">
            <a href="#" class="qa_href" onclick="return false;" target="<?php echo $i; ?>"><?php echo get_text($row['wr_content']); ?> <span class="tit_op">열기</span></a>
            <div id="qa_div<?php echo $i; ?>" class="qa_div" style="display:none;">
                <div class="qa_q">
                    <strong>문의내용</strong>
                    
                    <?php echo $iq_question; ?>
                </div>
                <div class="qa_a">
                <strong>답변</strong>
                <?php echo $iq_answer; ?>
                </div>
            </div>
        </td>
		<td style="width:100px;text-align:center"><?php echo $row['wr_datetime']; ?></td>
        <td class="td_name" style="text-align:center !important"><?php echo $name; ?></td>
        <td class="td_boolean"><?php echo $answer; ?></td>
        <td class="td_mng td_mng_s">
            <a href="./itemoneform.php?w=u&amp;wr_id=<?php echo $row['wr_id']; ?>&amp;<?php echo $qstr; ?>" class="btn btn_03" target="_blink" rel="noreferrer noopener"><span class="sound_only"><?php echo get_text($row['wr_content']); ?> </span>수정</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        echo '<tr><td colspan="6" class="empty_table"><span>자료가 없습니다.</span></td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemqalist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed  == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

$(function(){
    $(".qa_href").click(function(){
        var $content = $("#qa_div"+$(this).attr("target"));
        $(".qa_div").each(function(index, value){
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
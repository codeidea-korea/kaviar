<?php
if (!defined('_GNUBOARD_')) exit;

$colspan = 15;
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">생성된 게시판수</span><span class="ov_num"> <?php echo number_format($total_count) ?>개</span></span>
</div>

<form name="fsearch" id="fsearch" class="local_sch01 local_sch" method="get">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="bo_table"<?php echo get_selected($sfl, "bo_table", true); ?>>TABLE</option>
    <option value="bo_subject"<?php echo get_selected($sfl, "bo_subject"); ?>>제목</option>
    <option value="a.gr_id"<?php echo get_selected($sfl, "a.gr_id"); ?>>그룹ID</option>
</select>
<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>



<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="<?php echo isset($token) ? $token : ''; ?>">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
	<colgroup>
		<col width="40"><!-- 채크박스 -->
		<col width="200"><!-- 그룹 -->
		<col width="30"><!-- 출력순서 -->
		<col width=""><!-- TABLE -->
		<col width="40"><!-- 검색 -->
		<col width=""><!-- 제목 -->
		<col width="210"><!-- 스킨 -->
		<col width="210"><!-- 모바일스킨 -->
		<?php if($config['cf_use_point']) { //인태 - 포인트 사용일때만?>
		<col width="40"><!-- 읽기P -->
		<col width="40"><!-- 쓰기P -->
		<col width="40"><!-- 댓글P -->
		<col width="40"><!-- 다운P -->
		<?php } ?>
		<col width="40"><!-- SNS -->		
		<col width="80"><!-- 접속기기 -->
		<col width="80"><!-- 관리 -->
	</colgroup>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">게시판 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('a.gr_id') ?>그룹</a></th>
		<th scope="col"><?php echo subject_sort_link('bo_order') ?>출력<br>순서</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_table') ?>TABLE</a></th>
		<th scope="col"><?php echo subject_sort_link('bo_use_search') ?>검색<br>사용</a></th>   
		<th scope="col"><?php echo subject_sort_link('bo_subject') ?>제목</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_skin', '', 'desc') ?>스킨</a></th>
        <th scope="col"><?php echo subject_sort_link('bo_mobile_skin', '', 'desc') ?>모바일<br>스킨</a></th>        
		<?php if($config['cf_use_point']) { //인태 - 포인트 사용일때만?>
        <th scope="col">읽기P<span class="sound_only">포인트</span></th>
        <th scope="col">쓰기P<span class="sound_only">포인트</span></th>
        <th scope="col">댓글P<span class="sound_only">포인트</span></th>
        <th scope="col">다운P<span class="sound_only">포인트</span></th>
		<?php } ?>
        <th scope="col"><?php echo subject_sort_link('bo_use_sns') ?>SNS<br>사용</a></th>
             
        <th scope="col">접속기기</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $one_update = '<a href="./board_form.php?w=u&amp;bo_table='.$row['bo_table'].'&amp;'.$qstr.'" class="btn btn_03" target="_blink" rel="noreferrer noopener">수정</a>';
        $one_copy = '<a href="./board_copy.php?bo_table='.$row['bo_table'].'" class="board_copy btn btn_02" target="win_board_copy">복사</a>';

        $bg = 'bg'.($i%2);
		$gr_label[$i] = get_gr_1($row['gr_id']);
    ?>

    <tr style="<?php if($gr_label[$i]) echo 'background:'.$gr_label[$i]; ?>">
        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['bo_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td>
            <?php if ($is_admin == 'super'){ ?>
                <?php echo get_group_select("gr_id[$i]", $row['gr_id'], 'class="span"') ?>
            <?php }else{ ?>
                <input type="hidden" name="gr_id[<?php echo $i ?>]" value="<?php echo $row['gr_id'] ?>"><?php echo $row['gr_subject'] ?>
            <?php } ?>
        </td>
		 <td class="td_numsmall">
            <label for="bo_order_<?php echo $i; ?>" class="sound_only">출력<br>순서</label>
            <input type="text" name="bo_order[<?php echo $i ?>]" value="<?php echo $row['bo_order'] ?>" id="bo_order_<?php echo $i ?>" class="tbl_input" size="2">
        </td>
        <td class="tleft">
            <input type="hidden" name="board_table[<?php echo $i ?>]" value="<?php echo $row['bo_table'] ?>">
			<?php
			$table_label = '';
			if($row['bo_table']==$config['cf_main_table']) $table_label = '<span class="table_label">메인페이지</span>';
			if($row['bo_table']==$quick_news['qn_table1']) $table_label = '<span class="table_label">퀵뉴스(1)</span>';
			if($row['bo_table']==$quick_news['qn_table2']) $table_label = '<span class="table_label">퀵뉴스(2)</span>';		
			$tmp_gr = get_group($row['gr_id']);
			if($row['bo_table']==$tmp_gr['gr_main_table']) $table_label = '<span class="table_label gr">그룹메인</span>';
			?>
            <a href="<?php echo get_pretty_url($row['bo_table']) ?>"><?=$table_label?><?php echo $row['bo_table'] ?></a>
        </td>
		<td class="td_numsmall">
            <label for="bo_use_search_<?php echo $i; ?>" class="sound_only">검색<br>사용</label>
            <input type="checkbox" name="bo_use_search[<?php echo $i ?>]" value="1" id="bo_use_search_<?php echo $i ?>" <?php echo $row['bo_use_search']?"checked":"" ?>>
        </td>
		<td>
            <label for="bo_subject_<?php echo $i; ?>" class="sound_only">게시판 제목<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="bo_subject[<?php echo $i ?>]" value="<?php echo get_text($row['bo_subject']) ?>" id="bo_subject_<?php echo $i ?>" required class="required tbl_input bo_subject full_input" size="10">
        </td>
        <td>
            <label for="bo_skin_<?php echo $i; ?>" class="sound_only">스킨</label>
            <?php echo get_skin_select_my('board', 'bo_skin_'.$i, "bo_skin[$i]", $row['bo_skin'], 'class="span"'); ?>
        </td>
        <td>
            <label for="bo_mobile_skin_<?php echo $i; ?>" class="sound_only">모바일 스킨</label>
            <?php echo get_mobile_skin_select('board', 'bo_mobile_skin_'.$i, "bo_mobile_skin[$i]", $row['bo_mobile_skin'], 'class="span"'); ?>
        </td>        
		<?php if($config['cf_use_point']) { //인태 - 포인트 사용일때만?>
        <td class="td_numsmall">
            <label for="bo_read_point_<?php echo $i; ?>" class="sound_only">읽기 포인트</label>
            <input type="text" name="bo_read_point[<?php echo $i ?>]" value="<?php echo $row['bo_read_point'] ?>" id="bo_read_point_<?php echo $i; ?>" class="tbl_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_write_point_<?php echo $i; ?>" class="sound_only">쓰기 포인트</label>
            <input type="text" name="bo_write_point[<?php echo $i ?>]" value="<?php echo $row['bo_write_point'] ?>" id="bo_write_point_<?php echo $i; ?>" class="tbl_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_comment_point_<?php echo $i; ?>" class="sound_only">댓글 포인트</label>
            <input type="text" name="bo_comment_point[<?php echo $i ?>]" value="<?php echo $row['bo_comment_point'] ?>" id="bo_comment_point_<?php echo $i; ?>" class="tbl_input" size="2">
        </td>
        <td class="td_numsmall">
            <label for="bo_download_point_<?php echo $i; ?>" class="sound_only">다운<br>포인트</label>
            <input type="text" name="bo_download_point[<?php echo $i ?>]" value="<?php echo $row['bo_download_point'] ?>" id="bo_download_point_<?php echo $i; ?>" class="tbl_input" size="2">
        </td>
		<?php } ?>
        <td class="td_numsmall">
            <label for="bo_use_sns_<?php echo $i; ?>" class="sound_only">SNS<br>사용</label>
            <input type="checkbox" name="bo_use_sns[<?php echo $i ?>]" value="1" id="bo_use_sns_<?php echo $i ?>" <?php echo $row['bo_use_sns']?"checked":"" ?>>
        </td>            
        <td class="td_mngsmall">
            <label for="bo_device_<?php echo $i; ?>" class="sound_only">접속기기</label>
            <select name="bo_device[<?php echo $i ?>]" id="bo_device_<?php echo $i ?>">
                <option value="both"<?php echo get_selected($row['bo_device'], 'both', true); ?>>모두</option>
                <option value="pc"<?php echo get_selected($row['bo_device'], 'pc'); ?>>PC</option>
                <option value="mobile"<?php echo get_selected($row['bo_device'], 'mobile'); ?>>모바일</option>
            </select>
        </td>
        <td class="td_mng td_mng_m">
            <?php echo $one_update ?>
            <?php echo $one_copy ?>
        </td>
    </tr>
    <?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn_02 btn">
    <?php if ($is_admin == 'super') { ?>
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_02 btn">
    <?php } ?>
    <?php if ($is_admin == 'super') { ?>
    <a href="./board_form.php" id="bo_add" class="btn_01 btn">게시판 추가</a>
    <?php } ?>
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<script>
function fboardlist_submit(f)
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
    $(".board_copy").click(function(){
        window.open(this.href, "win_board_copy", "left=100,top=100,width=600,height=380");
        return false;
    });
});
</script>

<?php
include_once('./admin.tail.php');
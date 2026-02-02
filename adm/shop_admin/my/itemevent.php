<?php
if (!defined('_GNUBOARD_')) exit;
?>

<div class="local_ov01 local_ov">
       <span class="btn_ov01"><span class="ov_txt">전체 이벤트</span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>  
</div>




<form name="feventlist" method="post" action="./my/itemeventlistupdate.php" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="btn_fixed_top">
	<input type="submit" value="일괄수정" class="btn_02 btn">
    <a href="./itemeventform.php" class="btn btn_01">이벤트 추가</a>
</div>


<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">순서</th>
		<th scope="col">이벤트번호</th>
        <th scope="col">이미지</th>
		<th scope="col">제목</th>
		<th scope="col">기간</th>
        <th scope="col">연결상품</th>
        <th scope="col">사용</th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $href = '';
        $href_close = '';
        $sql = " select count(ev_id) as cnt from {$g5['g5_shop_event_item_table']} where ev_id = '{$row['ev_id']}' ";
        $ev = sql_fetch($sql);
        if ($ev['cnt']) {
            $href = '<a href="javascript:;" onclick="itemeventwin('.$row['ev_id'].');">';
            $href_close = '</a>';
        }
        if ($row['ev_subject_strong']) $subject = '<strong>'.$row['ev_subject'].'</strong>';
        else $subject = $row['ev_subject'];

		$ev_banner_link[$i] = explode('|', $row['ev_banner_link']);
		$is_event_link[$i] = $ev_banner_link[$i][1] ? true : false;
    ?>

    <tr>
        <td class="td_num">
			<input type="hidden" name="ev_id[<?php echo $i; ?>]" value="<?php echo $row['ev_id']; ?>">
			<input type="text" name="ev_order[<?php echo $i; ?>]" value="<?=$row['ev_order']?$row['ev_order']:''?>" class="w-50 tcenter" size="5">
		</td>
		<td class="td_num"><?php echo $row['ev_id']; ?></td>
		<td class="td_mng">
			<?php
			$mimg = G5_DATA_PATH.'/event/'.$row['ev_id'].'_m';
			if (file_exists($mimg)) echo '<img src="'.G5_DATA_URL.'/event/'.$row['ev_id'].'_m" style="max-width:180px">';
			?>
		</td>
        <td class="td_left"><?php echo $subject; ?><?=$is_event_link[$i]?'<span class="tag ml10 mont" style="font-size:11px;color:#fff;height:18px;padding:05px;border-radius:4px;background:var(--blue);display:inline-flex;align-items:center;justify-content:center;">LINK</span>':''?></td>
        <td class="w-280">
			<?=$row['ev_begin_time']!='0000-00-00 00:00:00'?$row['ev_begin_time']:''?> <?=$row['ev_begin_time']!='0000-00-00 00:00:00' || $row['ev_end_time']!='0000-00-00 00:00:00'?' ~ ':''?><?=$row['ev_end_time']!='0000-00-00 00:00:00'?$row['ev_end_time']:''?>
        </td>
		<td class="td_num"><?php echo $href; ?><?php echo $ev['cnt']; ?><?php echo $href_close; ?></td>
        <td class="td_boolean"><?php echo $row['ev_use'] ? '<span class="txt_true">예</span>' : '<span class="txt_false">아니오</span>'; ?></td>
        <td class="td_mng td_mng_l">
            <a href="./itemeventform.php?w=u&amp;ev_id=<?php echo $row['ev_id']; ?>" class="btn btn_03" target="_blink" rel="noreferrer noopener">수정</a>
            <a href="<?php echo G5_SHOP_URL; ?>/event.php?ev_id=<?php echo $row['ev_id']; ?>" class="btn btn_02">보기</a>
            <a href="./itemeventformupdate.php?w=d&amp;ev_id=<?php echo $row['ev_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>
        </td>
    </tr>

    <?php
    }

    if ($i == 0) {
        echo '<tr><td colspan="5" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>
</form>


<script>
function itemeventwin(ev_id)
{
    window.open("./itemeventwin.php?ev_id="+ev_id, "itemeventwin", "left=10,top=10,width=500,height=600,scrollbars=1");
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
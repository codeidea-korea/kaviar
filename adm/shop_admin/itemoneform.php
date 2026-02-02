<?php
$sub_menu = '400651';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, "w");

$wr_id = isset($_REQUEST['wr_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['wr_id']) : 0;

$sql = " select *
           from `g5_write_11_inquiry`a left join {$g5['member_table']} c on (a.mb_id = c.mb_id)
          where a.wr_id = '$wr_id' ";
		  //echo $sql;
$iq = sql_fetch($sql);
if (! (isset($iq['wr_id']) && $iq['wr_id'])) alert('등록된 자료가 없습니다.');

$name = get_text($iq['wr_name']);

$g5['title'] = '1:1문의';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;
?>

<form name="fitemqaform" method="post" action="./itemoneformupdate.php" onsubmit="return fitemqaform_submit(this);">
<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="local_desc01 local_desc">
    <p>상품에 대한 문의에 답변하실 수 있습니다. 상품 문의 내용의 수정도 가능합니다.</p>
</div>

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 수정</caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row">이름</th>
        <td><?php echo $name; ?></td>
    </tr>
	<tr>
        <th scope="row">연락처</th>
        <td>
			<?php echo $iq['wr_hp'] ? $iq['wr_hp'] : ""; ?>
			<?php echo $iq['wr_hp'] ? " / ".$iq['wr_email'] : $iq['wr_email']; ?>
		</td>
    </tr>
   
    <tr>
        <th scope="row"><label for="iq_subject">제목</label></th>
        <td><input type="text" name="iq_subject" value="<?php echo conv_subject($iq['wr_subject'],120); ?>" id="iq_subject" required class="frm_input required" size="95"></td>
    </tr>
    <tr>
        <th scope="row"><label for="iq_question">질문</label></th>
        <td><?php echo editor_html('iq_question', get_text(html_purifier($iq['wr_content']), 0)); ?></td>
    </tr>
	<tr>
        <th scope="row">이미지</th>
        <td>
			<div style="display:flex;align-items: center;">
			<?
				$img_chk = sql_fetch(" select group_concat(bf_file) as bf_file from `g5_board_file` where bo_table = '11_inquiry' and  wr_id= '".$wr_id."' ");
				$files = explode(",",$img_chk['bf_file']);
				$dirfile = G5_URL.'/data/file/11_inquiry/';
				for($i=0; $i< count($files); $i++) {
					
					$f_ex = explode('.',$files[$i]);

					if($f_ex[1] == "mp4"){
						// 비디오 플레이어 출력
						echo "<video style='width:15%;padding-top:5px;padding-bottom:5px' controls>
								<source src='".$dirfile.$files[$i]."' type='video/mp4'>
							  </video>";
					} else {
						// 이미지 출력
						echo "<img src='".$dirfile.$files[$i]."' style='width:15%;padding-top:5px;padding-bottom:5px'>";
					}
				}
			
			?>
			</div>
        </td>
    </tr>
<?php

	$ans = sql_fetch(" select * from `g5_write_11_inquiry` where wr_parent = '".$iq['wr_id']."' and wr_is_comment = 1 ");

	$iq_answer = get_view_thumbnail(conv_content($ans['wr_content'], 1), 300);

?>
    <tr>
        <th scope="row"><label for="iq_answer">답변</label></th>
        <td><?php echo editor_html('iq_answer', get_text(html_purifier($iq_answer), 0)); ?></td>
        <!-- <td><textarea name="iq_answer" id="iq_answer" rows="7"><?php echo get_text($iq['iq_answer']); ?></textarea></td> -->
    </tr>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./itemonelist.php?<?php echo $qstr; ?>" class="btn btn_02">목록</a>
    <input type="submit" accesskey='s' value="확인" class="btn_submit btn">
</div>
</form>

<script>
function fitemqaform_submit(f)
{
    <?php echo get_editor_js('iq_question'); ?>
    <?php echo get_editor_js('iq_answer'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
<?php
include_once('./_common.php');
//include_once(G5_LIB_PATH.'/thumbnail.lib.php');
//include_once(G5_BBS_PATH.'/ajax.board.php');

$popWidth = G5_IS_MOBILE ? 'width:100%;' : 'width:900px;';
$bo_comment_popup = G5_IS_MOBILE ? true : false;
?>


<?php if($is_comment_write) {
	if($w == '') 
		$w = 'c';
?>	
<aside id="bo_vc_w" class="<?=$bo_comment_popup?'zoom-anim-dialog mfp-hide':'inline'?>" style="<?php if($bo_comment_popup) echo $popWidth; ?>">
	<?php if($bo_comment_popup) echo '<div class="popCon_head"></div>'; ?>

	<form name="fviewcomment" id="fviewcomment" action="<?=G5_BBS_URL?>/write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="<?php echo $w ?>" id="w">
	<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
	<input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
	<input type="hidden" name="sca" value="<?php echo $sca ?>">
	<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
	<input type="hidden" name="stx" value="<?php echo $stx ?>">
	<input type="hidden" name="spt" value="<?php echo $spt ?>">
	<input type="hidden" name="page" value="<?php echo $page ?>">
	<input type="hidden" name="is_good" value="">			
	
	<div class="_comment_form">
		<?php if($is_guest) {
			echo '<div class="form-list guest">';
			echo '<input type="text" name="wr_name" value="'.get_cookie("ck_sns_name").'" id="wr_name" required class="required" size="5" maxLength="20" placeholder="이름" data-class="id" data-label="이름">';
			if(!G5_IS_MOBILE) echo '<label class="myTip top mini" data-tip="※ 비밀번호는 답변 수정 시 사용됩니다.">';
			echo '<input type="password" name="wr_password" id="wr_password" required class="required" size="10" maxLength="20" placeholder="비밀번호" data-class="pw" data-label="비밀번호">';
			if(!G5_IS_MOBILE) echo '</label>';
			echo '</div>';
		} ?>

		<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {
			echo '<div class="form-list">';
			echo '<label class="groupLabel">SNS 동시등록</label>';
			echo '<p id="bo_vc_send_sns"></p>';
			echo '</div>';
		} ?>

		<div class="form-list wr_content">
			<?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
			<textarea id="wr_content" name="wr_content" maxlength="10000" required class="required autosize" placeholder="댓글입력" 
			<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content; ?></textarea>
			<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
			<script>
			$(document).on("keyup change", "textarea#wr_content[maxlength]", function() {
				var str = $(this).val()
				var mx = parseInt($(this).attr("maxlength"))
				if (str.length > mx) {
					$(this).val(str.substr(0, mx));
					return false;
				}
			});
			</script>
			<?php if(!$bo_comment_popup) echo '<input type="submit" id="btn_submit" value="등록" class="btnComment">'; ?>
		</div>

		<div class="reform_btnSet"></div>
	</div>

	</form>
</aside>
<?php } ?>
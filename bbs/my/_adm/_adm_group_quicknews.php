
<form name="_adm_form" method="post" action="<?=G5_SKIN_URL?>/quick/quickNews/_group_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="gr_id" value="<?=$gr_id?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">


<section class="mybox blue">
	<div class="wr-wrap label120">	
		<div class="wr-list">
			<div class="wr-list-label"><label>퀵뉴스 게시판 선택</label></div>
			<div class="wr-list-con">
				<?php
				echo help("퀵뉴스와 연동할 게시판을 선택해주세요.");
				echo get_board_select('gr_qn_table', $group['gr_qn_table'], 'class="selectpicker"', '', 'table', $group['gr_id']);
				if($group['gr_qn_table']) echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$group['gr_qn_table'].'" class="btn_frmline ml10" target="_blank">게시판 바로가기</a>';
				?>
			</div>
		</div>
		<div class="wr-list">
			<div class="wr-list-label"><label>불러올 목록수</label></div>
			<div class="wr-list-con">
				<label><input type="text" name="gr_qn_list" value="<?=$group['gr_qn_list']?>" id="gr_qn_list" class="span60" placeholder="10"></label>
			</div>
		</div>		
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>
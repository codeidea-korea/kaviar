<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_adm_mainpage_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label160">
		<div class="form-list">
			<div class="form-label"><label>메인페이지에 적용 게시판</span></div>
			<div class="formCon">
				<p class="help-block mb5">* 선택가능 게시판이 없다면 <span class="black bold">[관리자 > 게시판 관리]</span>에서 게시판(pageMake스킨)을 추가 해주세요.</p>
				<div class="flex flex-middle">
					<?php echo get_board_select_my('cf_main_table', $config['cf_main_table'], 'class="selectpicker w-300"', 'pageMake', 'subject'); ?>
					<?php if($config['cf_main_table']) echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$config['cf_main_table'].'" target="_blank" class="btn_frmline" style="">게시판 바로가기</a>';?>
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>메인페이지 URL</span></div>
			<div class="formCon">
				<p class="help-block mb5">URL입력시, <b>기존 적용한 게시판은 사용하지 않고,</b> 입력한 URL페이지를 메인으로 사용합니다.</p>
				<input type="text" name="cf_main_url" value="<?=$config['cf_main_url']?>" id="cf_main_url" class="frm_input" size="130" maxlength="120" placeholder="http://">
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>
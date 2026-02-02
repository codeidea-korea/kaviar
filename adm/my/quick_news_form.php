<?php
if (!defined('_GNUBOARD_')) exit;
?>

<section class="mybox blue">	
	<h2 class="mybox-title">퀵뉴스 기본 설정</h2>

	<div class="formContainer label190">	
		<div class="form-list">
			<div class="form-label"><label>퀵뉴스 사용여부</label></div>
			<div class="formCon">
				<?php echo help("퀵뉴스 사용여부를 선택해주세요."); ?>
				<select id="qn_use" name="qn_use">
					<?php echo option_selected('0', $quick_news['qn_use'], "사용안함"); ?>
					<?php echo option_selected('1', $quick_news['qn_use'], "pc, mobile 모두 사용"); ?>
					<?php echo option_selected('2', $quick_news['qn_use'], "pc만 사용"); ?>
					<?php echo option_selected('3', $quick_news['qn_use'], "mobile만 사용"); ?>
				</select>
				<input type="checkbox" name="qn_use_admin" value="1" <?php echo $quick_news['qn_use_admin']?'checked':''; ?> id="qn_use_admin" data-class="ml20" data-label="최고관리자만 확인">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>시작 옵션</label></div>
			<div class="formCon">
				<select id="qn_use" name="qn_start_option" class="selectpicker">
					<?php echo option_selected('0', $quick_news['qn_start_option'], "닫힘 시작"); ?>
					<?php echo option_selected('1', $quick_news['qn_start_option'], "pc, mobile 모두 열림시작"); ?>
					<?php echo option_selected('2', $quick_news['qn_start_option'], "pc만 열림시작"); ?>
					<?php echo option_selected('3', $quick_news['qn_start_option'], "mobile만 열림시작"); ?>
					<?php echo option_selected('4', $quick_news['qn_start_option'], "무조건 열림시작(쿠키 사용안함)"); ?>
				</select>
			</div>
		</div>
		<?php if(!G5_IS_MOBILE) { ?>
		<div class="form-list">
			<div class="form-label"><label>퀵뉴스 오프너 제목</label></div>
			<div class="formCon">
				<label><input type="text" name="qn_title" value="<?=$quick_news['qn_title']?>" id="qn_title" class="span200" placeholder=""></label>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>퀵뉴스 오프너 배경</label></div>
			<div class="formCon">
				<input type="text" name="qn_background" value="<?=get_text($quick_news['qn_background'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>열림시 가로사이즈</label></div>
			<div class="formCon">
				<input type="text" name="qn_width" value="<?php if($quick_news['qn_width']) echo $quick_news['qn_width'];?>" id="qn_width" class="span60" placeholder="350" data-label-inline="PX">
			</div>
		</div>
		<?php } else { ?>
		<input type="hidden" name="qn_title" value="<?=$quick_news['qn_title']?>">
		<input type="hidden" name="qn_background" value="<?=get_text($quick_news['qn_background'])?>">
		<input type="hidden" name="qn_width" value="<?php if($quick_news['qn_width']) echo $quick_news['qn_width'];?>">
		<?php } ?>
	</div>
</section>

<section class="mybox blue">
	<h2 class="mybox-title">퀵뉴스 상세 옵션</h2>
	<div class="formContainer label140">	
		<div class="form-list">
			<div class="form-label"><label>최신글 상세 옵션</label></div>			
			<div class="formCon">
				<div class="flex flex-wrap gap25">
					<input type="checkbox" name="qn_option[]" value="카테고리표기" <?=checked_my($quick_news['qn_option'], '카테고리표기')?> data-label="카테고리 표기">
					<input type="checkbox" name="qn_option[]" value="작성자표기" <?=checked_my($quick_news['qn_option'], '작성자표기')?> data-label="작성자 표기">
					<input type="checkbox" name="qn_option[]" value="날짜표기" <?=checked_my($quick_news['qn_option'], '날짜표기')?> data-label="날짜 표기">
					<input type="checkbox" name="qn_option[]" value="조회수표기" <?=checked_my($quick_news['qn_option'], '조회수표기')?> data-label="조회수 표기">
					<input type="checkbox" name="qn_option[]" value="댓글수표기" <?=checked_my($quick_news['qn_option'], '댓글수표기')?> data-label="댓글수 표기">
					<input type="checkbox" name="qn_option[]" value="태그표기" <?=checked_my($quick_news['qn_option'], '태그표기')?> data-label="태그 표기">
					<input type="checkbox" name="qn_option[]" value="게시물버튼표기" <?=checked_my($quick_news['qn_option'], '게시물버튼표기')?> data-label="게시물버튼 표기">
				</div>
			</div>
		</div>
	</div>
</section>

<section class="mybox blue">	
	<h2 class="mybox-title">퀵뉴스 게시판(1) 연동</h2>
	<div class="formContainer label190">	
		<div class="form-list">
			<div class="form-label"><label>퀵뉴스 게시판 선택</label></div>
			<div class="formCon">
				<?php
				echo help("퀵뉴스와 연동할 게시판을 선택해주세요.");
				echo get_board_select_my('qn_table1', $quick_news['qn_table1'], 'class="span300"', '', 'subject');
				if($quick_news['qn_table1']) echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$quick_news['qn_table1'].'" class="btn_frmline ml10" target="_blank">게시판 바로가기</a>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>불러올 목록수</label></div>
			<div class="formCon">
				<label><input type="text" name="qn_list1" value="<?php if($quick_news['qn_list1']) echo $quick_news['qn_list1'];?>" id="qn_list" class="span60" placeholder="10"></label>
			</div>
		</div>		
	</div>
</section>

<section class="mybox blue">	
	<h2 class="mybox-title">퀵뉴스 게시판(2) 연동</h2>
	<div class="formContainer label190">	
		<div class="form-list">
			<div class="form-label"><label>퀵뉴스 게시판 선택</label></div>
			<div class="formCon">
				<?php
				echo help("퀵뉴스와 연동할 게시판을 선택해주세요.");
				echo get_board_select_my('qn_table2', $quick_news['qn_table2'], 'class="span300"', '', 'subject');
				if($quick_news['qn_table2'])  echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$quick_news['qn_table2'].'" class="btn_frmline ml10" target="_blank">게시판 바로가기</a>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>불러올 목록수</label></div>
			<div class="formCon">
				<label><input type="text" name="qn_list2" value="<?php if($quick_news['qn_list2']) echo $quick_news['qn_list2'];?>" id="qn_list" class="span60" placeholder="10"></label>
			</div>
		</div>		
	</div>
</section>

<div class="mt100"></div>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>


<div id="pop-bo-search-set" class="layer-popup">
	<span class="pop-closer">팝업닫기</span>
	<div class="popContainer">
		<div class="pop-inner" style="">
			<!--<span class="pop-closer">팝업닫기</span>-->
			<form name="fsearch" method="get">
			<input type="hidden" name="bo_table" value="<?=$bo_table?>">
			<input type="hidden" name="sca" value="<?=$sca?>">
			<input type="hidden" name="sop" value="and">
			<label for="sfl" class="sound_only">검색대상</label>	
			<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
			<div class="searchContainer">
				<?=$search_sfl?>
				<input type="text" name="stx" value="<?=stripslashes($stx)?>" required id="stx" size="15" maxlength="20" placeholder="<?=$search_holder?>">
				<label class="iconSearch"><input type="submit" value="검색" class="btn_submit"></label>
			</div>
			</form>
		</div>
	</div>
	<div class="pop-bg"></div>
</div>
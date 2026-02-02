<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($bo_search_skin_url.'/'.$css).'">', 4);

if($board['bo_search_color']) $searchbarStyle .= '#bo_sch{--searchColor:'.$board['bo_search_color'].'}';
?>

<div id="floatingSearch" class="<?=$stx?'open':''?>">
	<?=$boSearchSettting?>
	<form name="fsearch" method="get">
	<input type="hidden" name="bo_table" value="<?=$bo_table?>">
	<input type="hidden" name="sca" value="<?=$sca?>">
	<input type="hidden" name="sop" value="and">
	<label for="sfl" class="sound_only">검색대상</label>
	<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
	<span class="searchOpener"></span>
	<div class="seachContainer">	
		
		<?=$search_sfl?>
		<input type="text" name="stx" value="<?=stripslashes($stx)?>" required id="stx" class="schArea" size="15" maxlength="20" placeholder="<?=$search_holder?>">
		<label class="iconSearch"><input type="submit" value="검색" class="btn_submit"></label>
	</div>
	</form>
</div>


<script>
$('#floatingSearch .searchOpener').click(function() {
	$(this).parent().parent().toggleClass('open');
});
</script>
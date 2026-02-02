<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
@include_once($latest_skin_path.'/latest.head.skin.php');
?>

<?=$list_inc_info?>

<form name="fwrite" id="fwrite" action="<?=G5_BBS_URL?>/my/_adm/_write_form_update.php?pn=<?=$pn?>" onsubmit="return fwrite_form_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="w" value="u">
<input type="hidden" name="wr_subject" value="<?=$write['wr_subject']?>">
<input type="hidden" name="ca_name" value="<?=$write['ca_name']?>">
<input type="hidden" name="latest_sel_li_id" value="<?=$write['latest_sel_li_id']?>" id="latest_sel_li_id">
<input type="hidden" name="latest_count" value="<?=$write['latest_count']?>">
<input type="hidden" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?>">	
<input type="hidden" name="latest_option" value="<?=$write['latest_option']?>">
<input type="hidden" name="latest_mobile_option" value="<?=$write['latest_mobile_option']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue" style="position:relative;margin-top:30px;padding-top:20px;">
	<label id="bl_name"><b>블럭명</b><input type="text" name="bl_name" value="<?=get_text($write['bl_name'])?>" class="w-280" placeholder="블럭이름"></label>	

	<div class="formContainer label120">
		<div class="form-list">
			<div class="form-label"><img src="<?=get_url($board_skin_url."/img/layout-bigBanner.gif")?>" class="w-80"></div>
			<div class="formCon flex">					
				<span id="bl-height">
					<input type="text" name="bl_height" value="<?=$write['bl_height']?get_text($write['bl_height']):''?>" class="w-70" placeholder="" data-label="블럭 높이" data-label-inline="PX" maxlength="4">
					<input type="text" name="bl_height_mobile" value="<?=$write['bl_height_mobile']?get_text($write['bl_height_mobile']):''?>" class="w-70" placeholder="" data-class="ml5" data-label="모바일 블럭 높이" data-label-inline="PX" maxlength="4">
				</span>
				<label id="check-parallax" class="ml20 bold"><input type="checkbox" id="bl_parallax" name="bl_parallax" value="1" <?php if($write['bl_parallax']) echo 'checked'; ?> data-label="스크롤 모션효과 적용"></label>
				<input type="text" name="bl_background" value="<?=get_text($write['bl_background'])?>" class="colorpicker w-175" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="블럭 배경색" data-class="ml20">					
			</div>
		</div>

		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']!='list_of_select'&&$write['latest_skin'] != 'SQUARE') { ?>
		<div class="form-list">
			<div class="form-label"><label>목록 수</label></div>
			<div class="formCon">
				<input type="text" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>" id="latest_count" class="w-45" size="2" placeholder="" data-class="mr10" data-label="목록수">
				<input type="text" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?$write['latest_mobile_count']:''?>" id="latest_mobile_count" class="w-45" size="2" placeholder="<?php if(!$write['latest_mobile_count']) echo $write['latest_count'] ?>" data-label="모바일">
			</div>
		</div>
		<?php } ?>
		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']=='list_of_select'&&$write['latest_skin'] != 'SQUARE') { ?>
		<div class="form-list">
			<div class="form-label"><label>게시물 불러오기</label></div>
			<div class="formCon">
				<a href="<?=G5_BBS_URL?>/my/_adm/?pn=_list_of_select&title=<?=$write['latest_table']?> 게시물 선택&bo_table=<?=$write['latest_table']?>&sel_li_id=<?=$write['latest_sel_li_id']?>" id="btn_list_of_select" class="<?=$write['latest_sel_li_id']?'active':''?> popWin"data-width="1450" data-height="860" data-top="60" data-left="0"><?=$write['latest_sel_li_id']?'<span class="count">'.count($sel_li_id).'개</span>':''?></a>
			</div>
		</div>
		<?php } ?>

	</div>

	<?php if($write['latest_table'] && $write['latest_skin'] && file_exists($latest_pcskin_path.'/_skin.option.php')) {
		if($write['latest_option']) $order = 'flex-start';
		echo '<div id="form_latest_option" class="formOption '.$order.'">';
		echo '<div class="inner">';
		echo '<div class="inp-tag-wrap">';
		echo '<label class="input-label " data-tip="latest_option"><i class="my-icon-pc"></i></label>';
		echo '<input type="text" name="latest_option" value="'.get_text($write['latest_option']).'" id="latest_option" class="w-full inputTag" placeholder="불러온 게시물 옵션">';
		echo '</div>';
		//$option_open = $write['latest_option'] ? true : false;
		echo get_skinOption('latest', $write['latest_skin'], 'latest_option', 'latest_mobile_option', $option_open, $write['latest_table']);		
		echo '<div class="inp-tag-wrap blueTag mt5">';
		echo '<label class="input-label " data-tip="latest_mobile_option"><i class="my-icon-mobile"></i></label>';
		echo '<input type="text" name="latest_mobile_option" value="'.$write['latest_mobile_option'].'" id="latest_mobile_option" class="w-full inputTag" placeholder="불러온 게시물 옵션(모바일)">';
		echo '</div>';		
		echo '</div>';
		echo '<div id="skinOptionAfterCover"></div>';
		echo '</div>';
	} ?>
</section>


<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s" data-wr-id="<?=$wr_id?>">
</div>
</form>	

<!-- 여기부터는 저장되지 않음 -->
<input type="hidden" name="latest_table" value="<?=$write['latest_table']?>" id="latest_table">
<input type="hidden" name="latest_skin" value="<?=$write['latest_skin']?>" id="latest_skin">

<script>
opener.$('#section-<?=$wr_id?>').removeClass('hover-marker');
$('._adm_btnSet .btn_submit').hover(function() {
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).addClass('hover-marker');
}, function(){
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).removeClass('hover-marker');
});
function fwrite_form_submit(f){
	<?=get_editor_js("wr_content")?>
    <?=get_editor_js("wr_content_mobile")?>	
    return true;
}
</script>
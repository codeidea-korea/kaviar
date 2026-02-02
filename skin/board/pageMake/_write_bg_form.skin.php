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
<input type="hidden" name="latest_gall_cols" value="<?=$write['latest_gall_cols']?>">
<input type="hidden" name="latest_gall_mobile_cols" value="<?=$write['latest_gall_mobile_cols']?>">
<input type="hidden" name="latest_sel_li_id" value="<?=$write['latest_sel_li_id']?>" id="latest_sel_li_id">
<input type="hidden" name="latest_count" value="<?=$write['latest_count']?>">
<input type="hidden" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?>">	
<input type="hidden" name="wr_video_src" value="<?=$write['wr_video_src']?>">
<input type="hidden" name="latest_option" value="<?=$write['latest_option']?>">
<input type="hidden" name="latest_mobile_option" value="<?=$write['latest_mobile_option']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
<?php for($i=2; $i<10; $i++) {
	echo '<input type="hidden" name="bf_file_del['.$i.']" value="1">';
} ?>

<section class="mybox blue" style="position:relative;margin-top:30px;padding-top:20px;">
	<label id="bl_name"><b>블럭명</b><input type="text" name="bl_name" value="<?=get_text($write['bl_name'])?>" class="span280" placeholder="블럭이름"></label>
	<?php if($write['latest_table']) echo '<div class="form-msg">게시판&nbsp;-&nbsp;<span class="color-blue-light javascript_link text-hover" data-url="'.get_pretty_url($write['latest_table']).'">'.$write['latest_table'].'</span>&nbsp;에서 최신글을 불러오고 있습니다.</div>';?>

	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><img src="<?=get_url($board_skin_url."/img/layout-bg.gif")?>" class="span80"></div>
			<div class="formCon flex">							
				<span id="bl-height">
					<?php if(!G5_IS_MOBILE) { ?>
					<input type="text" name="bl_height" value="<?=$write['bl_height']?get_text($write['bl_height']):''?>" class="span70" placeholder="" data-label="블럭 높이" data-label-inline="PX" maxlength="4">
					<?php } else { ?>
					<input type="hidden" name="bl_height" value="<?=$write['bl_height']?get_text($write['bl_height']):''?>">
					<?php } ?>
					<input type="text" name="bl_height_mobile" value="<?=$write['bl_height_mobile']?get_text($write['bl_height_mobile']):''?>" class="span70" placeholder="" data-class="ml5" data-label="모바일 블럭 높이" data-label-inline="PX" maxlength="4">
				</span>
				<label id="check-parallax" class="ml20 bold"><input type="checkbox" id="bl_parallax" name="bl_parallax" value="1" <?php if($write['bl_parallax']) echo 'checked'; ?>>스크롤 모션효과 적용</label>
				<input type="text" name="bl_background" value="<?=get_text($write['bl_background'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="블럭 배경색" data-class="ml20">				
			</div>
		</div>
		
		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']!='list_of_select'&&$write['latest_skin'] != 'SQUARE') { ?>
		<div class="form-list">
			<div class="form-label"><label>목록 수</label></div>
			<div class="formCon">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>" id="latest_count" class="span45" size="2" placeholder="" data-class="mr10" data-label="목록수">
				<?php } else { ?>
				<input type="hidden" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>">
				<?php } ?>
				<input type="text" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?$write['latest_mobile_count']:''?>" id="latest_mobile_count" class="span45" size="2" placeholder="<?php if(!$write['latest_mobile_count']) echo $write['latest_count'] ?>" data-label="모바일 목록수">
			</div>
		</div>
		<?php } ?>
		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']=='list_of_select'&&$write['latest_skin'] != 'SQUARE') { ?>
		<div class="form-list">
			<div class="form-label"><label>게시물 불러오기</label></div>
			<div class="formCon">
				<a href="<?=G5_BBS_URL?>/my/_list_of_select.php?bo_table=<?=$write['latest_table']?>&sel_li_id=<?=$write['latest_sel_li_id']?>" id="btn_list_of_select" class="<?=$write['latest_sel_li_id']?'active':''?> popWin"data-width="1450" data-height="860" data-top="60" data-left="0"><?=$write['latest_sel_li_id']?'<span class="count">'.count($sel_li_id).'개</span>':''?></a>
			</div>
		</div>
		<?php } ?>
		<?php if($write['latest_table']&&$write['latest_skin']&&$skin_option) { ?>
		<div id="form-latest-option" class="form-list">
			<div class="form-label"><label>최신글 상세 옵션</label></div>			
			<div class="formCon">
				<div class="flex gap20">					
					<?php for ($i=0; $i<count($skin_option); $i++) {
						$option_value[$i] = str_replace(" ", "", $skin_option[$i]);
						echo '<input type="checkbox" name="latest_option[]" value="'.$option_value[$i].'" '.checked_my($write['latest_option'], $option_value[$i]).' data-label="'.$skin_option[$i].'">';
					}?>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</section>

<section class="mybox blue blue-bg">
	<div class="formContainer label130">
		<?php
		echo $form_gall_file;
		echo $form_video;
		?>
	</div>
</section>

<section class="mt20" style="padding-left:20px">		
	<div class="mb10" style="position:relative;">
		<?php $minHeight =  $write['bl_title_size'] < 30 ? 70 : $write['bl_title_size'] + 40; ?>
		<textarea name="bl_title" id="bl_title" class="bl_title span autosize label<?=$bl_font?' '.$bl_font:''?>" style="<?=$write['bl_title_size']?'font-size:'.$write['bl_title_size'].'px;min-height:'.$minHeight.'px;':'min-height:70px;'?>" placeholder="제목 &lt;sub&gt;보조문구&lt;/sub&gt;" data-label="블럭 제목"><?=$write['bl_title']?></textarea>			
		<label class="labelColor-hidden small" title="텍스트 컬러" style="position:absolute;bottom:1px;left:-20px;z-index:13;">
			<input type="text" name="bl_title_color" value="<?=get_text($write['bl_title_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
		</label>
		<input type="text" name="bl_title_size" id="bl_title_size" value="<?=$write['bl_title_size']?$write['bl_title_size']:''?>">
		<div class="fontSizeControl" data-target="#bl_title" data-target-input="#bl_title_size">
			<span class="up" title="폰트 확대"></span>
			<span class="down" title="폰트 축소"></span>
		</div>
	</div>
	<div class="wrConBox">
		<ul class="wrConTabs">
			<li class="active icon_pc" data-target="pcCon" title="PC">내용</li>
			<li class="icon_mobile" data-target="mobileCon" title="모바일">모바일 내용</li>
		</ul>
		<div class="tabEditor pcCon active"><?=$editor_html?></div>
		<div class="tabEditor mobileCon"><?=$editor_mobile_html?></div>
		<label class="labelColor-hidden small" title="텍스트 컬러" style="position:absolute;bottom:1px;left:-20px;z-index:13;">
			<input type="text" name="wr_content_color" value="<?=get_text($write['wr_content_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
		</label>			
	</div>

	<?=$form_btn?>

	<div class="formContainer label100 mt20">
		<div class="form-list">
			<div class="form-label"><label>콘텐츠 정렬</label></div>
			<div class="formCon">
				<?php
				$bl_text_align = explode("|", $write['bl_text_align']);
				echo '<select name="bl_text_align[0]" value="'.$bl_text_align[0].'" id="bl_text_align">';
				echo option_selected_my("",  $bl_text_align[0], "기본값", "data-content='기본 <small>(왼쪽정렬)</small>'");
				echo option_selected("center",  $bl_text_align[0], "가운데 정렬");
				echo option_selected("right",  $bl_text_align[0], "오른쪽 정렬");
				echo '</select>';

				echo '<span id="con_flex_align" class="ml15"><select name="bl_text_align[1]" value="'.$bl_text_align[1].'" class="select-img">';
				echo option_selected_my("",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-start.gif")."'>\"");
				echo option_selected_my("flex-center",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-center.gif")."'>\"");
				echo option_selected_my("flex-end",  $bl_text_align[1], "", "data-content=\"<img src='".get_url($board_skin_url."/img/flex-end.gif")."'>\"");
				echo '</select></span>';
				?>	
			</div>
		</div>
	</div>
</section>	

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s" data-wr-id="<?=$wr_id?>">
</div>
</form>

<!-- 여기부터는 저장되지 않음 -->
<input type="hidden" name="latest_table" value="<?=$write['latest_table']?>" id="latest_table">
<input type="hidden" name="latest_skin" value="<?=$write['latest_skin']?>" id="latest_skin">

<div id="addScript"></div>
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
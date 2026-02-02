<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
@include_once($latest_skin_path.'/latest.head.skin.php');
if($callback) $callback_url = $_SERVER["HTTP_REFERER"];
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
<input type="hidden" name="gall_cols_default" value="<?=$write['gall_cols_default']?>" id="gall_cols_default">
<input type="hidden" name="latest_sel_li_id" value="<?=$write['latest_sel_li_id']?>" id="latest_sel_li_id">
<input type="hidden" name="latest_count" value="<?=$write['latest_count']?>">
<input type="hidden" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?>">	
<input type="hidden" name="wr_video_src" value="<?=$write['wr_video_src']?>">
<input type="hidden" name="latest_order_cate" value="<?=$write['latest_order_cate']?>">
<input type="hidden" name="latest_option" value="<?=$write['latest_option']?>">
<input type="hidden" name="latest_mobile_option" value="<?=$write['latest_mobile_option']?>">
<input type="hidden" name="callback" value="<?=$callback?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>"><?=$callback_url?>
<?php for($i=2; $i<10; $i++) {
	echo '<input type="hidden" name="bf_file_del['.$i.']" value="1">';
} ?>

<section class="mybox blue" style="position:relative;margin-top:30px;padding-top:20px;">
	<label id="bl_name"><b>블럭명</b><input type="text" name="bl_name" value="<?=get_text($write['bl_name'])?>" class="w-280" placeholder="블럭이름"></label>
	<?php if($write['latest_table']) echo '<div class="form-msg">게시판&nbsp;-&nbsp;<span class="color-blue-light javascript_link text-hover" data-url="'.get_pretty_url($write['latest_table']).'">'.$write['latest_table'].'</span>&nbsp;에서 최신글을 불러오고 있습니다.</div>';?>

	<div class="formContainer label170">	

		<div class="form-list">
			<div class="form-label">
				<select name="wr_subject" value="<?php echo $write['wr_subject'] ?>" id="wr_subject" class="selectpicker select-img n2 w-130">
					<?php
					echo option_selected_my("layout-basic",  $write['wr_subject'], "layout-basic", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-basic.gif")."' alt='기본형'><span class='skin_name'>기본형</span>\"");
					echo option_selected_my("layout-top",  $write['wr_subject'], "layout-top", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-top.gif")."' alt='상단미디어형'><span class='skin_name'>상단미디어형</span>\"");
					echo option_selected_my("layout-rt",  $write['wr_subject'], "layout-rt", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-rt.gif")."' alt='우미디어형'><span class='skin_name'>우미디어형</span>\"");
					echo option_selected_my("layout-lt",  $write['wr_subject'], "layout-lt", "data-content=\"<img src='".get_url($board_skin_url."/img/layout-lt.gif")."' alt='좌미디어형'><span class='skin_name'>좌미디어형</span>\"");						
					?>
				</select>	
				<!--<label>블럭 설정</label>-->
			</div>
			<div class="formCon flex lg:column lg:flex-center lg:flex-start gap20">
				<div class="flex gap20">
					<?php if(!G5_IS_MOBILE) { ?>
					<input type="text" name="bl_width" value="<?=$write['bl_width']?get_text($write['bl_width']):''?>" id="bl_width" class="w-70 per100" size="2" placeholder="" data-id="label_bl_width" data-class="mr20" data-label="블럭 가로사이즈" data-label-inline="PX" maxlength="4">
					<?php } else { ?>
					<input type="hidden" name="bl_width" value="<?=$write['bl_width']?get_text($write['bl_width']):''?>">
					<?php } ?>
					<?php
					$bl_padding_top_arr = explode("|", $write['bl_padding_top']);
					$bl_padding_top = $bl_padding_top_arr[0];
					$bl_padding_top_mobile = $bl_padding_top_arr[1];
					$bl_padding_bottom_arr = explode("|", $write['bl_padding_bottom']);
					$bl_padding_bottom = $bl_padding_bottom_arr[0];
					$bl_padding_bottom_mobile = $bl_padding_bottom_arr[1];
					?>	
					<?php if(!G5_IS_MOBILE) { ?>
					<div class="sizeControl-updown" data-label="블럭 여백조절(상·하)">
						<input type="text" name="bl_padding_top[]" value="<?=$bl_padding_top?$bl_padding_top:''?>" class="w-60" data-label-inline="PX" placeholder="<?=$board['bo_padding_top']?$board['bo_padding_top']:''?>">
						<input type="text" name="bl_padding_bottom[]" value="<?=$bl_padding_bottom?$bl_padding_bottom:''?>" class="w-60" data-label-inline="PX" placeholder="<?=$board['bo_padding_bottom']?$board['bo_padding_bottom']:''?>">
					</div>
					<?php } else { ?>
					<input type="hidden" name="bl_padding_top[]" value="<?=$bl_padding_top?$bl_padding_top:''?>">
					<input type="hidden" name="bl_padding_bottom[]" value="<?=$bl_padding_bottom?$bl_padding_bottom:''?>">
					<?php } ?>
					<div class="sizeControl-updown" data-label="블럭(모바일) 여백조절(상·하)">
						<input type="text" name="bl_padding_top[]" value="<?=$bl_padding_top_mobile?$bl_padding_top_mobile:''?>" class="w-60" data-label-inline="PX" placeholder="<?=$board['bo_mobile_padding']?$board['bo_mobile_padding']:''?>">
						<input type="text" name="bl_padding_bottom[]" value="<?=$bl_padding_bottom_mobile?$bl_padding_bottom_mobile:''?>" class="w-60" data-label-inline="PX" placeholder="<?=$board['bo_mobile_padding']?$board['bo_mobile_padding']:''?>">
					</div>
				</div>
				<div class="flex gap30 sm:ml20">
					<input type="text" name="bl_background" value="<?=get_text($write['bl_background'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="블럭 배경색">
					<input type="text" name="bl_font_color" value="<?=get_text($write['bl_font_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="폰트 색상">
				</div>
			</div>
		</div>		

		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_skin']!='basic') {?>
		<div class="form-list">
			<div class="form-label"><label>블럭 스킨 타입 설정</label></div>
			<div class="formCon">
				<span id="latestTypeContainer"></span>
				<span id="gallCols" class="ml10" style="<?=!$write['latest_table']||!$write['latest_skin']||strpos($write['latest_type'], '_grid') !== false?'display:none':''?>">
					<?php
					if(!G5_IS_MOBILE) {
						echo '<label class="labelInput mr10"><b class="label">가로 수 <small>(한줄)</small></b>';
						echo '<select name="latest_gall_cols" value="'.$write['latest_gall_cols'].'" id="latest_gall_cols">';
						echo option_selected_my("",  $write['latest_gall_cols'], "기본값", "data-content='기본값 <small>(".$write['gall_cols_default'].")</small>'");
						echo option_selected_my("1",  $write['latest_gall_cols'], "1", "data-content='1 <small>개씩</small>'");
						if($write['latest_type']=="_gall_slide") echo option_selected_my("1.5",  $write['latest_gall_cols'], "1.5", "data-content='1.5 <small>개씩</small>'");
						echo option_selected_my("2",  $write['latest_gall_cols'], "2", "data-content='2 <small>개씩</small>'");
						if($write['latest_type']=="_gall_slide") echo option_selected_my("2.5",  $write['latest_gall_cols'], "2.5", "data-content='2.5 <small>개씩</small>'");
						echo option_selected_my("3",  $write['latest_gall_cols'], "3", "data-content='3 <small>개씩</small>'");
						if($write['latest_type']=="_gall_slide") echo option_selected_my("3.5",  $write['latest_gall_cols'], "3.5", "data-content='3.5 <small>개씩</small>'");
						echo option_selected_my("4",  $write['latest_gall_cols'], "4", "data-content='4 <small>개씩</small>'");
						if($write['latest_type']=="_gall_slide") echo option_selected_my("4.5",  $write['latest_gall_cols'], "4.5", "data-content='4.5 <small>개씩</small>'");
						echo option_selected_my("5",  $write['latest_gall_cols'], "5", "data-content='5 <small>개씩</small>'");
						if($write['latest_type']=="_gall_slide") echo option_selected_my("5.5",  $write['latest_gall_cols'], "5.5", "data-content='5.5 <small>개씩</small>'");
						echo '</select>';
						echo '</label>';
					} else {
						echo '<input type="hidden" name="latest_gall_cols" value="'.$write['latest_gall_cols'].'">';
					}
					echo '<label class="labelInput mr30"><b class="label">모바일 가로 수</b>';
					echo '<select name="latest_gall_mobile_cols" value="'.$write['latest_gall_mobile_cols'].'" id="latest_gall_mobile_cols">';
					echo option_selected_my("",  $write['latest_gall_mobile_cols'], "기본값", "data-content='기본값 <small>(2)</small>'");
					echo option_selected_my("1",  $write['latest_gall_mobile_cols'], "1", "data-content='1 <small>개씩</small>'");
					if($write['latest_type']=="_gall_slide") echo option_selected_my("1.5",  $write['latest_gall_mobile_cols'], "1.5", "data-content='1.5 <small>개씩</small>'");
					echo option_selected_my("2",  $write['latest_gall_mobile_cols'], "2", "data-content='2 <small>개씩</small>'");
					echo option_selected_my("2.5",  $write['latest_gall_mobile_cols'], "2.5", "data-content='2.5 <small>개씩</small>'");
					echo option_selected_my("3",  $write['latest_gall_mobile_cols'], "3", "data-content='3 <small>개씩</small>'");
					echo option_selected_my("3.5",  $write['latest_gall_mobile_cols'], "3.5", "data-content='3.5 <small>개씩</small>'");
					echo '</select>';
					echo '</label>';
					?>	
				</span>
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="latest_gall_itemspace" value="<?=$write['latest_gall_itemspace']?>" id="latest_gall_itemspace" class="w-60" size="2" placeholder="" data-label="간격" data-label-inline="PX">
				<?php } else { ?>
				<input type="hidden" name="latest_gall_itemspace" value="<?=$write['latest_gall_itemspace']?>">
				<?php } ?>
			</div>
		</div>
		<?php } ?>
		
		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']!='list_of_select') { ?>
		<div class="form-list">
			<div class="form-label"><label>목록 수</label></div>
			<div class="formCon">
				<?php if(!G5_IS_MOBILE) { ?>
				<input type="text" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>" id="latest_count" class="w-55" size="2" placeholder="" data-class="mr10" data-label-inline="개">
				<?php } else { ?>
				<input type="hidden" name="latest_count" value="<?=$write['latest_count']?$write['latest_count']:''?>">
				<?php } ?>
				<input type="text" name="latest_mobile_count" value="<?=$write['latest_mobile_count']?$write['latest_mobile_count']:''?>" id="latest_mobile_count" class="w-45" size="2" placeholder="<?php if(!$write['latest_mobile_count']) echo $write['latest_count'] ?>" data-label="모바일" data-label-inline="개">
			</div>
		</div>
		<?php } ?>
		<?php if($write['latest_table']&&$write['latest_skin']&&$write['latest_order_option']=='list_of_select') { ?>
		<div class="form-list">
			<div class="form-label"><label>게시물 불러오기</label></div>
			<div class="formCon">
				<span id="btn_list_of_select" class="<?=$write['latest_sel_li_id']?'active':''?>" style="cursor:pointer;<?=$write['latest_order_option']!='list_of_select'?'display:none':''?>"><?=$write['latest_sel_li_id']?'<span class="count">'.count($sel_li_id).'개</span>':''?></span>
			</div>
		</div>
		<?php } ?>
		
		<?php if($write['latest_table']&&$write['latest_skin']&&$skin_option) { ?>
		<div id="form-latest-option" class="form-list">
			<div class="form-label"><label>최신글 상세 옵션</label></div>			
			<div class="formCon flex column gap15">
				<div class="flex gap15">					
					<?php for ($i=0; $i<count($skin_option); $i++) {
						$option_value[$i] = str_replace(" ", "", $skin_option[$i]);
						if($skin_option[$i] == '<br>') {
							echo '</div><div class="flex flex-middle gap15">';
						} else if($skin_option[$i] == '내용글자수') {
							if(!G5_IS_MOBILE) {
								echo '<input type="text" name="option_con_length" value="'.get_option_num('내용글자수', $write['latest_option']).'" class="w-75 textlength" data-label="내용글자수" data-label-inline="글자">';
							} else {
								echo '<input type="hidden" name="option_con_length" value="'.get_option_num('내용글자수', $write['latest_option']).'">';
							}
						} else if($skin_option[$i] == '모바일 내용글자수') {
							echo '<input type="text" name="option_mobile_con_length" value="'.get_option_num('모바일글자수', $write['latest_option']).'" class="w-75 textlength" data-label="모바일 내용글자수" data-label-inline="글자">';
						} else {
							echo '<input type="checkbox" name="latest_option[]" value="'.$option_value[$i].'" '.checked_my($write['latest_option'], $option_value[$i]).' class="button" data-label="'.$skin_option[$i].'">';
						}
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
		<textarea name="bl_title" id="bl_title" class="bl_title w-full autosize label<?=$bl_font?' '.$bl_font:''?>" style="<?=$write['bl_title_size']?'font-size:'.$write['bl_title_size'].'px;min-height:'.$minHeight.'px;':'min-height:70px;'?>" placeholder="제목 &lt;sub&gt;보조문구&lt;/sub&gt;" data-label="블럭 제목"><?=$write['bl_title']?></textarea>			
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

//부모창에 새창열기
$('.javascript_link').click(function(event){
	var url = $(this).attr('data-url');
	var openNewWindow = window.open("about:blank");
	openNewWindow.location.href = url;
});

function latestSkinChange(latestSkin) {	
	let table = latestSkin == 'SQUARE' ? $('#latest_table').val() : '',
		skinName = latestSkin.replace('theme/', '').replace('seperate/', '');
	<?=$write['latest_type'] ? 'let latest_type = "'.$write['latest_type'].'";' : 'let latest_type = $("#latest_type").val();'?>
	$.post("<?=$board_skin_url?>/_ajax_latest_type.php",{push:'push', table:table, skin:skinName, board_skin_url:"<?=$board_skin_url?>", latest_type:latest_type, latest_list_style:"<?=$write['latest_list_style']?>"}, function(data) {
		$("#latestTypeContainer").html(data);
		$('#latestTypeContainer select, #latest_gall_cols').selectpicker('refresh');
		$("#latest_type").change(function (){
			latestTypeChange($(this).val(), $("#latest_table").val());
		});
	});
}

function latestTypeChange(latestTypeVal, latest_table) {
	var skin = "<?=$write['latest_skin']?>";
	$.post("<?=$board_skin_url?>/_ajax_latest_type.php",{push:'', skin:skin, latest_type:latestTypeVal}, function(data) {
		$("#addScript").html(data);
		$('#latest_gall_cols').selectpicker('refresh');
	});
}

$(document).ready(function(){
	latestSkinChange($('#latest_skin').val());
	//불러오기조건 - 직접선택시 팝업링크
	$('#btn_list_of_select').click(function() {
		var table= $('#latest_table').val(),
			sel_li_id = $('#latest_sel_li_id').val(),
			href = '<?=G5_BBS_URL?>/my/_adm/?pn=_list_of_select&title=' + table + ' 게시물 선택&bo_table=' + table + '&sel_li_id=' + sel_li_id;
		window.open(href,'','width=1450,height=860,top=60,left=30,scrollbars=yes,toolbar=no,menubar=no,location=no,statusbar=no,status=no,resizable=yes');
		event.preventDefault();
	});
});

function fwrite_form_submit(f){
	<?=get_editor_js("wr_content")?>
    <?=get_editor_js("wr_content_mobile")?>
    return true;
}
</script>
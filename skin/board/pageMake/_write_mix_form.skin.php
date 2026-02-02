<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
echo '<link rel="stylesheet" href="'.get_url($board_skin_url.'/mix-type/mix-style.css').'">';

for($i=0; $i<10; $i++) {
	$thumb[$i] = get_list_thumbnail($bo_table, $wr_id, 500, 0, false, true, 'center', false, '80/0.5/3', $i, false);
}

function get_mix_type_select($id, $name, $selected=''){
    global $config, $board_skin_url, $board_skin_path;
    $types = array();
    $types = array_merge($types, get_mix_type_dir());
    $str = "<select id=\"$id\" name=\"$name\" class=\"select-img n4 span160 mr15\">\n";
    for ($i=0; $i<count($types); $i++) {
		$text = $types[$i];
		$dataSubject = '';
		$type_img_url = $board_skin_url.'/mix-type/'.$types[$i].'/thumb.gif';
		$type_img_path = $board_skin_path.'/mix-type/'.$types[$i].'/thumb.gif';
		$str .= option_selected_my($types[$i], $selected, $text, 'data-content=\'<img src="'.get_url($type_img_url).'" alt="'.$text.'"><span class="skin_name">'.$text.'</span>\'');
    }
    $str .= "</select>";
    return $str;
}
function get_mix_type_dir(){
    global $g5, $board_skin_path;
    $result_array = array();
    $dirname = $board_skin_path.'/mix-type/';
    if(!is_dir($dirname))
        return;
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;
        if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
    //sort($result_array);
	usort($result_array, 'strcasecmp'); //대,소문자 구분없이

    return $result_array;
}
?>


<form name="fwrite" id="fwrite" action="<?=G5_BBS_URL?>/my/_adm/_write_form_update.php?pn=<?=$pn?>" onsubmit="return fwrite_form_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="w" value="u">
<input type="hidden" name="wr_subject" value="<?=$write['wr_subject']?>">
<input type="hidden" name="ca_name" value="<?=$write['ca_name']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue mb10" style="position:relative;margin-top:30px;padding-top:20px;">
	<label id="bl_name"><b>블럭명</b><input type="text" name="bl_name" value="<?=get_text($write['bl_name'])?>" class="span280" placeholder="블럭이름"></label>
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>MIX 타입</label></div>
			<div class="formCon flex lg:column lg:flex-center lg:flex-start gap20">
				<?php echo get_mix_type_select('mix_type', 'mix_type', $write['mix_type']); ?>			
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
	</div>
</section>	


<div id="mix-from-wrap" data-type="<?=$write['mix_type']?$write['mix_type']:'mix-01';?>">
	<section id="wrConBox" class="mybox blue mb15 <?=$write['bl_title']||($write['wr_content']&&$write['wr_content']!='&nbsp;')?'':'hide visible'?>">
		<h2 class="mybox-title toggle">제목&내용</h2>
		<div class="inner" style="padding-left:20px">
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
			<div class="mt10">
				<?php
				$bl_text_align = explode("|", $write['bl_text_align']);
				echo '<select name="bl_text_align[0]" value="'.$bl_text_align[0].'" id="bl_text_align">';
				echo option_selected_my("",  $bl_text_align[0], "기본값", "data-content='기본 <small>(왼쪽정렬)</small>'");
				echo option_selected("center",  $bl_text_align[0], "가운데 정렬");
				echo option_selected("right",  $bl_text_align[0], "오른쪽 정렬");
				echo '</select>';
				?>	
			</div>
			<?=$form_btn?>
		</div>
	</section>	

	<section id="mix-form"></section>
</div>



<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s" data-wr-id="<?=$wr_id?>">
</div>
</form>

<script type="text/javascript" src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<?php if($board['bo_app_key']) echo '<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey='.$board['bo_app_key'].'&libraries=services"></script>'; ?>
<script>
opener.$('#section-<?=$wr_id?>').removeClass('hover-marker');
$('._adm_btnSet .btn_submit').hover(function() {
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).addClass('hover-marker');
}, function(){
	var bl_id = $(this).attr('data-wr-id');
	opener.$('#section-'+bl_id).removeClass('hover-marker');
});

function mixTypeChange(val) {
	$.post("<?=$board_skin_url?>/mix-type/" + val + "/_ajax_mix_form.php",{bo_table:'<?=$bo_table?>', wr_id:'<?=$wr_id?>'}, function(data) {
		$("#mix-form").html(data);
		$("#mix-form select").selectpicker('refresh');	
	});
}

$(document).ready(function(){

	mixTypeChange($('#mix_type').val());

	$('#mix_type').change(function (){
		var val = $(this).val();
		mixTypeChange(val);

		$('#mix-from-wrap').attr('data-type', val);
	});
});

function fwrite_form_submit(f){
	<?=get_editor_js("wr_content")?>
    <?=get_editor_js("wr_content_mobile")?>
    return true;
}
</script>
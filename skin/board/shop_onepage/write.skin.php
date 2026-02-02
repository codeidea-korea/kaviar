<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/'.$css).'">', 3);
?>

<?php if($is_bo_title) echo $bo_title; ?>

<section id="bo_w" style="<?=$bo_width?>">

    <form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
	<?php if($is_admin == 'super') echo '<input type="hidden" name="update_redirect_url" value="list">'; ?>
	<input type="hidden" name="wr_subject" value="단페이지">

	<?=$option_hidden?>
	
	<div class="wr-wrap" style="--label-width:140px;">
        <?=$wr_guest?>
		
		<?php if($wr_include) echo '<div class="wr-group sm:flex sm:gap10">'.$wr_include.'</div>'; ?>

		<?=$wr_myContent?>

		<div class="mb10">
			<label><input type="checkbox" name="editor_img_slide" value="1" class=""<?=$write['editor_img_slide']?' checked':''?>><span></span>에디터 이미지로 슬라이드 만들기</label>
		</div>

		<?=$wr_video?>

		<?=$wr_file?>	
		
		<?=$wr_link?>

		<?=$wr_btn?>

		<?=$wr_captcha?>
	</div>

    <div class="bo_btnSet">
		<?php if($is_delete) echo $deleteCode; ?>
        <button type="submit" accesskey="s" class="btn_submit">등록하기</button>
        <a href="<?=get_pretty_url($bo_table)?>" class="btn_cancel">취소</a>
    </div>

    </form>

</section>
	
<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?php echo $write_min; ?>); // 최소
var char_max = parseInt(<?php echo $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});

<?php } ?>
function html_auto_br(obj)
{
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f) {

	<?php if($is_admin){ ?>
	var wr_content_editor_data = oEditors.getById['wr_content'].getIR(); 
	oEditors.getById['wr_content'].exec('UPDATE_CONTENTS_FIELD', []);  
	if(jQuery.inArray(document.getElementById('wr_content').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){ 
		document.getElementById('wr_content').value='&nbsp;'; 
		wr_content_editor_data = '&nbsp;' 
	} 
	if (!wr_content_editor_data || jQuery.inArray(wr_content_editor_data.toLowerCase(), ['<p><br></p>','<p></p>','<br>']) != -1) { 
		alert("내용을 입력해 주십시오."); 
		oEditors.getById['wr_content'].exec('FOCUS'); 
		return false; 
	}

	//echo $editor_mobile_html;
	var wr_content_mobile_editor_data = oEditors.getById['wr_content_mobile'].getIR(); 
	oEditors.getById['wr_content_mobile'].exec('UPDATE_CONTENTS_FIELD', []);  
	if(jQuery.inArray(document.getElementById('wr_content_mobile').value.toLowerCase().replace(/^\s*|\s*$/g, ''), ['&nbsp;','<p>&nbsp;</p>','<p><br></p>','<div><br></div>','<p></p>','<br>','']) != -1){ 
		document.getElementById('wr_content_mobile').value='&nbsp;'; 
		wr_content_mobile_editor_data = '&nbsp;' 
	} 
	if (!wr_content_mobile_editor_data || jQuery.inArray(wr_content_mobile_editor_data.toLowerCase(), ['<p><br></p>','<p></p>','<br>']) != -1) { 
		alert("내용을 입력해 주십시오."); 
		oEditors.getById['wr_content_mobile'].exec('FOCUS'); 
		return false; 
	}

	<?php } else { echo $editor_js; } // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
			"content": f.wr_content.value
		},
		dataType: "json",
		async: false,
		cache: false,
		success: function(data, textStatus) {
			subject = data.subject;
			content = data.content;
		}
	});

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>
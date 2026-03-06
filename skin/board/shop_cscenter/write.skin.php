<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/style.css').'">', 3);
?>

<?php if($is_bo_title) echo $bo_title; ?>

<section id="bo_w" style="">

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

	<?=$option_hidden?>
	
	<div class="wr-wrap label140">
        <?=$wr_guest?>

		<?php// if($wr_include || $wr_option) echo '<div class="wr-group">'.$wr_include.$wr_option.'</div>'; ?>

		<?php if($is_member) { ?>
		<div class="wr-list wr_subject" id="wrSubject">
			<div class="wr-list-label"><label>이메일</label></div>
			<div class="wr-list-con">
				<input type="text" name="wr_email" value="<?=$write['wr_email']?>" id="wr_email" required class="<?=G5_IS_MOBILE?'w-full':'w-230'?> required" maxlength="255" placeholder="연락받으실 이메일을 입력해주세요.">
			</div>
		</div>
		<?php } ?>
		
		<div class="wr-list wr_subject" id="wrSubject">
			<div class="wr-list-label"><label>연락처</label></div>
			<div class="wr-list-con">
				<input type="text" name="wr_hp" value="<?=$write['wr_hp']?>" id="wr_hp" required class="<?=G5_IS_MOBILE?'w-full':'w-230'?> phone" maxlength="255" placeholder="연락받으실 연락처를 입력해주세요.">
			</div>
		</div>
        
<?php /* 
관리자 메일발송 설정 기능 사용으로 인해 주석 by ein1 260116
		<div class="wr-list wr_subject" id="wrSubject">
			<div class="wr-list-label"><label>이메일</label></div>
			<div class="wr-list-con">
				<input type="email" name="wr_email" value="<?=$write['wr_email']?>" id="wr_email" required class="<?=G5_IS_MOBILE?'w-full':'w-300'?>" maxlength="255" placeholder="연락받으실 이메일을 입력해주세요.">
			</div>
		</div>
*/ ?>

		<div class="flex sm:column sm:gap0">
			<?=$wr_category?>
			<?=$wr_subject?>
		</div>

		<?=$wr_myContent?>

		<?=$wr_tag?>
		
		<?if($is_mobile){?>
			<?if($member['mb_id']){?>
				해당 메일은 발신 전용으로 회신이 불가합니다.
			<?}else{?>
				사진 첨부는 회원가입 및 로그인 후 첨부 가능합니다.
			<?}?>
		<?}else{?>
			<?if($member['mb_id']){?>
				<div style="padding-left:120px">해당 메일은 발신 전용으로 회신이 불가합니다.</div>
			<?}else{?>
				<div style="padding-left:120px">사진 첨부는 회원가입 및 로그인 후 첨부 가능합니다.</div>
				
			<?}?>
			
		<?}?>
		
		<?=$wr_file?>

		<?=$wr_captcha?>
	</div>

    <div class="bo_btnSet">
		<?php if($is_delete) echo $deleteCode; ?>
        <button type="submit" accesskey="s" class="btn_submit">등록하기</button>
        <!--<a href="<?=get_pretty_url($bo_table)?>" class="btn_cancel">취소</a>-->
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
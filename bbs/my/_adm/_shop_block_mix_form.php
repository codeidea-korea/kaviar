<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//믹스 스킨 경로
$this_mix_path = G5_THIS_PATH.'/skin/shop/basic/mix_type/';
$theme_mix_path = G5_THEME_PATH.'/skin/shop/basic/mix_type/';
$_mix_path = G5_PATH.'/skin/shop/basic/mix_type/';
if(is_dir($this_mix_path)) {
	$_mix_path =  $this_mix_path;
} else if(is_dir($theme_mix_path)){
	$_mix_path =  $theme_mix_path;
} else {
	$_mix_path =  $_mix_path;
}
$_mix_url = str_replace(G5_PATH, G5_URL, $_mix_path);

echo '<link rel="stylesheet" href="'.get_url($_mix_url.'/_mix_style.css').'">';

$bl_cate = $_GET['bl_cate'] ? $_GET['bl_cate'] : 'index';


$sql = " select * from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
$shopblock = sql_fetch($sql);
$bl_id = isset($_REQUEST['bl_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['bl_id']) : 0;
if (!$shopblock['bl_id'])
	alert('등록된 자료가 없습니다.');
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_url?>/_shop_block_mix_form_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="bl_id" value="<?=$bl_id?>">
<input type="hidden" name="mix_skin_path" value="<?=$_mix_path.$shopblock['mix_type']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?true:false?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue mt30">

	<div class="mb25">
		<img src="<?=G5_THEME_URL?>/skin/shop/basic/mix_type/<?=$shopblock['mix_type']?>/thumb.gif" style="border:1px solid rgba(0,0,0,0.1);padding:5px;border-radius:3px;max-width:190px;">
	</div>

	<?php
	echo '<div class="mixContainer" data-mix-type="'.$shopblock['mix_type'].'">';
	include_once($_mix_path.$shopblock['mix_type'].'/_mix_form.php');
	echo '</div>';
	?>

</section>

<div class="_adm_btnSet">
	<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>

//불러오기조건 - 직접선택시 팝업링크
function _btn_list_of_select_click() {
	$('.btn_list_of_select').click(function() {
		var bl_type = $(this).attr('data-bl-type'),
			check_type = $(this).attr('data-check-type') == 'radio' ? 'radio' : 'checkbox',
			input_id = $(this).find('input').attr('id'),
			sel_li_id = $(this).find('input').val(),
			href = "<?=$_adm_url?>?pn=_shop_block_list_of_select&title=불러오기 선택&bl_type=" + bl_type + "&check_type=" + check_type + "&sel_li_id=" + sel_li_id + "&input_id=" + input_id,
			pop_width = bl_type == 'itemuse' ? 800 : 1350;
		window.open(href,'','width='+pop_width+',height=860,top=40,left=20,scrollbars=yes,toolbar=no,menubar=no,location=no,statusbar=no,status=no,resizable=yes');
		event.preventDefault();
	});
}

/*function mixTypeChange(val) {
	$.post("<?=$_mix_url?>" + val + "/_mix_form.php",{
		mix_li_1:"<?=$shopblock['mix_li_1']?>",
		mix_li_2:"<?=$shopblock['mix_li_2']?>",
		mix_li_3:"<?=$shopblock['mix_li_3']?>",
		mix_li_4:"<?=$shopblock['mix_li_4']?>",
		mix_li_5:"<?=$shopblock['mix_li_5']?>",
		mix_li_6:"<?=$shopblock['mix_li_6']?>"
	}, function(data) {
		$("#mix-form").html(data);
		_btn_list_of_select_click();
	});
}*/


$(document).ready(function(){
	_btn_list_of_select_click();	
});

/*$('#mix_type').change(function (){
	var val = $(this).val();
	mixTypeChange(val);
});*/

///////////////////////////////////////////////////////////////////////////////////////////////////
</script>
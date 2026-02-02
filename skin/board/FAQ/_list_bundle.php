<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<form name="_adm_form" id="_adm_form" action="<?=G5_BBS_URL?>/my/_adm/_list_bundle_update.php" onsubmit="return _adm_form_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type='hidden' name='chk' value='<?=count($list)?>'>
<input type='hidden' name='sca' value='<?=urlencode($sca)?>'>
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<label class="checkbox-label"><input type="checkbox" name="all_order_reset" value="1" id="all_order_reset">모든 순서 초기화</label>
<?=$bo_cate?>	

<ul class="frm_gall_ul n1 <?=$board['bo_skin']?>" id="sortable">        
	<?php for ($i=0; $i<count($list); $i++) {
		echo '<li';
		if($sca && $i==0) echo ' class="list_main"';
		echo '>';
		echo '<div class="list_inner flex flex-middle column">';
		echo '<input type="hidden" name="wr_id_up['.$i.']" value="'.$list[$i]['wr_id'].'">';
		echo '<input type="hidden" name="wr_order['.$i.']" value="'.$list[$i]['wr_order'].'" id="wr_order['.$i.']" class="wr_order">';

		if ($board['bo_use_category']) {
			$category_option = get_category_option($bo_table, $list[$i]['ca_name']);
			echo '<div class="item-right" style="">';
			echo '<select name="ca_name['.$i.']" id="ca_name['.$i.']" class="ca_name selectpicker" data-wr-id="'.$list[$i]['wr_id'].'">';
			echo option_selected("",  $list[$i]['ca_name'], "- 분류 없음 -");
			echo $category_option;
			echo '</select>';
			echo '</div>';
		}
		echo '<div class="con"><b>'.$list[$i]['wr_subject'].'</b></div>';
		echo '</div>';
		echo '</li>';
	} ?>
</ul>

 <div class="_adm_btnSet">
	<input type="submit" value="순서 변경하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$('.ca_name').change(function (){
	var ca_name = $(this).val(),
		wr_id = $(this).attr('data-wr-id');
	$.post("<?=G5_BBS_URL?>/my/_adm/_list_cate_update.php",{bo_table:'<?=$bo_table?>', ca_name:ca_name, wr_id:wr_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
</script>




</body>
</html>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($bo_cate_skin_url.'/'.$css).'">', 3);

if($board['bo_cate_color']) $cateStyle .= '#bo_cate .boCateContainer{--color:'.$board['bo_cate_color'].'}';
?>

<div class="boCateContainer <?=$skin_dir?> <?php if($stx) echo 'stxOn'; ?>">
	<?=$boCateSettting?>
	<form name="fcategory" method="get">
	<input type="hidden" name="bo_table" value="<?=$bo_table?>">
	<?php if($stx) { ?>
	<input type="hidden" name="sfl" value="wr_content">
	<input type="hidden" name="stx" value="<?=$stx?>">
	<input type="hidden" name="sop" value="and">
	<?php }  ?>
	<select name="sca" onchange="this.form.submit();" id="cate-select" class="cate-select selectpicker">
		<?php if($all) echo '<option value="">'.$board['bo_subject'].'</option>'; ?>
		<?php for ($i=0; $i<count($bo_category_list); $i++) {  ?>
		<option value="<?=$ca_name[$i]?>" <?=$ca_name[$i]==$sca?'selected':''?> data-content='<?=$adminCate_mark[$i]?'<span class="adminCate_mark">'.$ca_name[$i].'</span>':$ca_name[$i]?>'><?=$ca_name[$i]?></option>
		<?php } ?>
	</select>
	</form>
</div>
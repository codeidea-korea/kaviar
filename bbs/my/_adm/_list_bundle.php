<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 원글만 구한다.
$bo_table = $_GET['bo_table'];
$write_table = $g5['write_prefix'] . $bo_table;

$list = array();
$board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$bo_table}' ");
$bo_subject = get_text($board['bo_subject']);
$rows = 200;
$sca = $_GET['sca'];
if($sca) $where = ' and ca_name = "'.$sca.'" ';
if($sca=='none') $where = ' and ca_name = "" ';
$bo_sort_field = $board['bo_sort_field'] ? $board['bo_sort_field'].',' : '';
$sql = " select * from {$write_table} where wr_is_comment = 0 {$where} order by wr_order < 0, wr_order = 0, wr_order, {$bo_sort_field} wr_num limit 0, {$rows}";

$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = get_list($row, $board, '', 60);
}

/* 카테고리 */
$is_bo_cate = false;
$bo_cate = '';
if ($board['bo_use_category']) {
    $is_bo_cate = true;
    $bo_cate_href = G5_BBS_URL.'/my/_adm/?pn=_list_bundle&bo_table='.$bo_table.'&title='.$title;
	$bo_cate .= '<div class="boCate">';
	$bo_cate .= '<ul>';
    $bo_categories = explode('|', $board['bo_category_list']);
	$bo_cate .= '<li><a href="'.$bo_cate_href.'" class="'.($sca==''?'active':'').'">전체보기</a></li>';
    for ($i=0; $i<count($bo_categories); $i++) {
        $bo_category = trim($bo_categories[$i]);
        if ($bo_category=='') continue;
        $bo_cate .= '<li><a href="'.$bo_cate_href.'&sca='.urlencode($bo_category).'"';
        if ($bo_category==$sca) {
            $bo_cate .= ' class="active"';
        }
        $bo_cate .= '>'.$bo_category.'</a></li>';
    }	
	$bo_cate .= '</ul>';
	$bo_cate .= '</div>';
}
?>
<!--<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>-->
<script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>
<script type="text/javascript">
//<![CDATA[
$(function() {
    $("#sortable").sortable({
        start: function(event, ui) {
        },
        stop: function(event, ui) {
			reorder();
        }
    });    
    //$( "#sortable" ).sortable({});
    $( "#sortable" ).disableSelection();
});
function reorder() {
    $(".frm_gall_ul > li, .frm_bl_ul > li").each(function(i) {
		$(this).find(".wr_order").val(i + 1);
    });
}
//]]>
</script>

<?php if(file_exists($board_skin_path.'/_list_bundle.php')) {
	require_once($board_skin_path.'/_list_bundle.php');
    return;
} ?>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_list_bundle_update.php" onsubmit="return _adm_form_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?=$bo_table?>">
<input type='hidden' name='chk' value='<?=count($list)?>'>
<input type='hidden' name='sca' value='<?=urlencode($sca)?>'>
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<label class="checkbox-label"><input type="checkbox" name="all_order_reset" value="1" id="all_order_reset">모든 순서 초기화</label>
<?=$bo_cate?>

<ul class="frm_gall_ul <?=$board['bo_skin']?>" id="sortable">        
	<?php for ($i=0; $i<count($list); $i++) {
		$small_thumb[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 140, 0, false, true);		
		echo '<li data-wr-id="'.$list[$i]['wr_id'].'">';
		echo '<div class="list_inner">';
		echo '<input type="hidden" name="wr_id_up['.$i.']" value="'.$list[$i]['wr_id'].'">';
		echo '<input type="hidden" name="wr_order['.$i.']" value="'.$list[$i]['wr_order'].'" id="wr_order['.$i.']" class="wr_order">';
		if ($board['bo_use_category']) {
			$category_option = get_category_option($bo_table, $list[$i]['ca_name']);
			echo '<div class="mb5">';
			echo '<select name="ca_name['.$i.']" id="ca_name['.$i.']" class="ca_name selectpicker" data-wr-id="'.$list[$i]['wr_id'].'">';
			echo option_selected("",  $list[$i]['ca_name'], "- 분류 없음 -");
			echo $category_option;
			echo '</select>';
			echo '</div>';
		}
		if($small_thumb[$i]['src']) echo '<div class="thumb"><img src="'.$small_thumb[$i]['src'].'"></div>';
		echo '<div class="con">'.$list[$i]['wr_subject'].'</div>';
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
	$.post("<?=$_adm_update_url?>/_list_cate_update.php",{bo_table:'<?=$bo_table?>', ca_name:ca_name, wr_id:wr_id}, function (response) {
		document.location.reload();
		opener.document.location.reload();
	});
});
</script>
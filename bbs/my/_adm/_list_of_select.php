<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 원글만 구한다.
$bo_table = $_GET['bo_table'];
$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
$sel_li_id = explode(",",$_GET['sel_li_id']);

$list = array();
$board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '{$bo_table}' ");
$bo_subject = get_text($board['bo_subject']);

$board['bo_sort_field'] = $board['bo_sort_field'] ? $board['bo_sort_field'] : 'wr_num, wr_reply';
$bo_field = 'wr_order < 0, wr_order = 0, wr_order, '.$board['bo_sort_field'];
$bo_sort_field = $board['bo_sort_field'] ? $board['bo_sort_field'].',' : '';
$sql = " select * from {$tmp_write_table} where {$my_order} wr_is_comment = 0 order by wr_order < 0, wr_order = 0, wr_order, {$bo_sort_field} wr_num limit 0, 200";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
	$list[$i]['wr_content'] = preg_replace("/<img[^>]+\>/i", "", $list[$i]['wr_content']);
	$wr_content[$i] = preg_replace("/<(.*?)\>/"," ",$list[$i]['wr_content']); 
	$wr_content[$i] = preg_replace("/&nbsp;/"," ",$wr_content[$i]); 
	$wr_content[$i] = str_replace("//##", " ", $wr_content[$i]);
	$wr_content[$i] = cut_str($wr_content[$i], 200, '…');
}
?>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_list_of_select_push.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<div class="_list_of_select_form">
	<div class="list_form_ul">
		<?php for($i=0; $i<count($list); $i++) {
			$small_thumb[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 140, 0, false, true);	
			

			echo '<div class="list_form_li">';			
				echo '<label class="labelContainer">';
					echo '<input type="checkbox" name="chk_wr_id[]" value="'.$list[$i]['wr_id'].'" id="chk_wr_id_'.$i.'" '.(in_array($list[$i]['wr_id'], $sel_li_id)?'checked':'').'><span class="chkSpan"></span>';
					echo '<div class="wzContents">';
						if($small_thumb[$i]['src']) echo '<div class="wz_thumb"><img src="'.$small_thumb[$i]['src'].'"></div>';			
						echo '<div class="wz_con">';
							if($list[$i]['wr_subject']) echo '<div class="textSubject">'.$list[$i]['subject'].'</div>';							
							if($wr_content[$i]) echo '<div class="textContent">'.$wr_content[$i].'</div>';
							if($is_category && $list[$i]['ca_name']) echo '<p class="category mt10">'.$list[$i]['ca_name'].'</p>';
						echo '</div>';
					echo '</div>';
				echo '</label>';
				echo '<a href="'.$list[$i]['href'].'" class="detail-view" target="_blank">게시물 확인</a>';
			echo '</div>';
		}
		if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>';
		?>
	</div>

	<div class="bo_btnSet">
		<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
    </div>

</div>
</form>
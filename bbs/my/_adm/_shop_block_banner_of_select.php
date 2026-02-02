<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//배너 목록 불러오기
$shop_banner_category = explode('|', $default['shop_banner_category']);
$shop_banner_category_str = '';
$qstr = '';
if($_GET['check_type']) $qstr .= '&check_type='.$_GET['check_type'];
if($_GET['input_id']) $qstr .= '&input_id='.$_GET['input_id'];
$shop_banner_category_str .= '<li><a href="'.$_adm_url.'/?'.($tab?'tab=1&':'').'pn=_shop_block_list_of_select&title=불러오기 선택&bl_type=banner&sel_li_id='.$_GET['sel_li_id'].'&bn_cate='.$qstr.'" class="tab'.(!$bn_cate?' active':'').'">전체</a></li>';
for($i=0; $i<count($shop_banner_category); $i++) {
	if($shop_banner_category[$i]) $shop_banner_category_str .= '<li><a href="'.$_adm_url.'/?'.($tab?'tab=1&':'').'pn=_shop_block_list_of_select&title=불러오기 선택&bl_type=banner&sel_li_id='.$_GET['sel_li_id'].'&bn_cate='.$shop_banner_category[$i].$qstr.'" class="tab'.($bn_cate==$shop_banner_category[$i]?' active':'').'">'.$shop_banner_category[$i].'</a></li>';
}
if($shop_banner_category_str) $shop_banner_category_str = '<ul>'.$shop_banner_category_str.'</ul>';

$where = ' where ';
$sql_search = '';

$sql_search .= " $where bn_position = '' ";
$where = ' and ';
$qstr = "pn=".$pn;
$qstr .= "&title=불러오기 선택&bl_type=banner&sel_li_id=".$_GET['sel_li_id'];

if ( $bn_cate ){
	$sql_search .= " and bn_cate = '$bn_cate' ";
	$qstr .= "&amp;bn_cate=$bn_cate";
}

$sql_common = " from {$g5['g5_shop_banner_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 100; //로드시 부하가 있을수 있어서 일단 100개 까지만 불러온다......
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_block_list_of_select_push.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="input_id" value="<?=$input_id?>">
<div id="shop_banner_tabs">
	<?=$shop_banner_category_str?>
</div>

<div class="_list_of_select_form">
	<div class="list_form_ul n3">
		<?php		
		$sql = " select * from {$g5['g5_shop_banner_table']} $sql_search order by bn_order, bn_id desc limit $from_record, $rows  ";
		$result = sql_query($sql);
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
			$bn_img = "";
			if(file_exists($bimg)) {
				$banner_thumb = thumbnail($row['bn_id'], G5_DATA_PATH.'/banner/', G5_DATA_PATH.'/banner/', 180, '', 1, 1, 'center');								
				$bn_img .= '<img src="'.G5_DATA_URL.'/banner/'.$banner_thumb.'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'"'.($row['bn_alt']?' title="'.$row['bn_alt'].'"':'').'>';
			}
			$bn_begin_time = substr($row['bn_begin_time'], 2, 14);
			$bn_end_time = substr($row['bn_end_time'], 2, 14);				

			echo '<div class="list_form_li">';	
				echo get_live_msg($bn_begin_time, $bn_end_time);
				echo '<label class="labelContainer">';
					echo '<input type="'.$check_type.'" name="chk_li_id[]" value="'.$row['bn_id'].'" id="chk_li_id_'.$i.'" '.(in_array($row['bn_id'], $sel_li_id)?'checked':'').'><span class="chkSpan"></span>';						
					echo '<div class="wzContents">';							
						if($bn_img) echo '<div class="wz_thumb">'.$bn_img.'</div>';			
						echo '<div class="wz_con gap5">';
							echo '<div class="bold">';
							echo $row['bn_position'] ? $row['bn_position'] : '기본배너';
							if(!$row['bn_position'] && $default['shop_banner_category'] && $row['bn_cate']) echo ' - '.$row['bn_cate'];
							echo '</div>';
							echo '<div class="color-gray mt5">게시일 : <b class="color-black">'.($bn_begin_time=='00-00-00 00:00'?'없음':$bn_begin_time).'</b></div>';
							echo '<div class="color-gray">종료일 : <b class="color-black">'.($bn_end_time=='00-00-00 00:00'?'없음':$bn_end_time).'</b></div>';
						echo '</div>';
					echo '</div>';
				echo '</label>';
			echo '</div>';
		}
		if($i == 0) echo '<div class="empty_li">등록된 배너가 없습니다.</div>';
		?>
	</div>

	<?=get_paging(10, $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?pn=".$pn."&$qstr&amp;page=")?>

	<div class="bo_btnSet">
		<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
    </div>

</div>
</form>


<script>
var beforeChecked = -1;
$(function(){
	$(document).on("click", "input[type=radio]", function(e) {
		var index = $(this).parent().index("label");
		if(beforeChecked == index) {
			beforeChecked = -1;
			$(this).prop("checked", false);
		} else {
			beforeChecked = index;
		}
	});
});
</script>
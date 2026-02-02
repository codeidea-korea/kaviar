<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists($board_pcskin_path.'/list.head.skin.php')) {
	include_once($board_pcskin_path.'/list.head.skin.php');
}

// 파일체크
switch($ps) {
	default						: $board_form_file = $_adm_inc_path.'/_board_form_listpage.php'; break;
	case 'view'					: $board_form_file = $_adm_inc_path.'/_board_form_viewpage.php'; break;
	case 'write'				: $board_form_file = $_adm_inc_path.'/_board_form_writepage.php'; break;
}

if(file_exists($board_pcskin_path.'/_board_form.php')) {
	include_once($board_pcskin_path.'/_board_form.php');
} else {
	echo '<div class="box-tabs-container">';
	echo '<div class="tabs-group">';
	echo '<a href="'.$_adm_url.'/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'" class="tab '.(!$ps?'active':'').'">목록페이지</a>';	
	echo '<a href="'.$_adm_url.'/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=view" class="tab '.($ps=='view'?'active':'').'">상세페이지</a>';
	echo '<a href="'.$_adm_url.'/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=write" class="tab '.($ps=='write'?'active':'').'">등록페이지</a>';
	echo '</div>';
	echo '</div>';
}

include_once($board_form_file);
?>

<script>
<?php if($ps == 'view') { ?>
	window.resizeTo(1250, 560);
<?php } else if($ps == 'write') { ?>
	window.resizeTo(1250, 560);
<?php } else { ?>	
	window.resizeTo(1250,750);
<?php } ?>
</script>
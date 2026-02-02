<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/get_my.lib.php');

$is_push = $_POST['push'] == 'push' ? true : false;
$table = $_POST['table'];
$skin = $_POST['skin'];
$board_skin_url = $_POST['board_skin_url'];
$write['latest_type'] = $_POST['latest_type'];
$write['latest_list_style'] = $_POST['latest_list_style'];

$skin_type = $listStyle = $gallCols = $gallGutter = '';
$latest_skin_path = G5_PATH.'/skin/latest/'.$skin;
$latest_skin_url = G5_URL.'/skin/latest/'.$skin;
if(file_exists($latest_skin_path.'/latest.head.skin.php')) {
	include_once($latest_skin_path.'/latest.head.skin.php');
}

$write['latest_type'] = $write['latest_type'] ? $write['latest_type'] : $skin_type[0];
$write['latest_list_style'] = $write['latest_list_style'] ? $write['latest_list_style'] : $listStyle[0];

if($is_push) {
	if($skin_type) { //$skin_type = latest.head.skin.php 에서 불러온 배열
		echo '<select name="latest_type" value="'.$write['latest_type'].'" id="latest_type" class="selectpicker select-img '.$skin.' n2 span170 mr10" data-id="latestType" data-label="">';
		for ($i=0; $i<count($skin_type); $i++) {
			echo option_selected_my($skin_type[$i],  $write['latest_type'], $skin_type[$i], "data-content=\"<img src='".get_url($latest_skin_url."/img/".$skin_type[$i].".gif")."' alt='".$skin_type_name[$i]."'><span class='skin_name'>".$skin_type_name[$i]."</span>\"");
		}
		echo '</select>';
	}
	if($listStyle) {
		echo '<select name="latest_list_style" value="'.$write['latest_list_style'].'" id="latest_list_style" class="selectpicker select-img n2 span170 mr10" data-id="listStyle" data-label="">';
		echo option_selected_my("list-style1",  $write['latest_list_style'], "list-style1", "data-content=\"<img src='".get_url($board_skin_url."/img/list-style1.gif")."' alt='기본 스타일'><span class='skin_name'>기본 스타일</span>\"");
		echo option_selected_my("list-style2",  $write['latest_list_style'], "list-style2", "data-content=\"<img src='".get_url($board_skin_url."/img/list-style2.gif")."' alt='라인 스타일'><span class='skin_name'>라인 스타일</span>\"");
		echo '</select>';
	}
}

//현재 스킨과, 스킨타입을 value를 전달받고, 각 latest스킨의 latest.head.skin.php에서 지정된 타입별 설정에 따라 가로수,간격 등 사용여부를 반대로 전달한다.
if($skin_type && $skin_type_cols) {
	for ($i=0; $i<count($skin_type); $i++) {
		if($skin_type[$i] == $write['latest_type']) $cols = $skin_type_cols[$i];
	}
}
echo '<script>'.PHP_EOL;
if($gallCols) {
	echo '$(\'#gallCols\').show();'.PHP_EOL;
} else {
	echo '$(\'#gallCols\').hide();'.PHP_EOL;
}
if($gallGutter) {
	echo '$(\'#gallGutter\').show();'.PHP_EOL;
} else {
	echo '$(\'#gallGutter\').hide();'.PHP_EOL;
}

if($cols) {
	echo '$("#latest_gall_cols option:first-child").data("content", "기본값 <small>('.$cols.')</small>");'.PHP_EOL;	
	echo '$("#gall_cols_default").val('.$cols.');'.PHP_EOL;
} else {
	echo '$("#latest_gall_cols option:first-child").data("content", "기본값 <small>(불러올 게시판에서 상속)</small>");'.PHP_EOL;
}
//echo '$("#latest_gall_cols").selectpicker("refresh");'.PHP_EOL;
/*
echo 'latestTypeChange($(\'#latest_type\').val(), $(\'#latest_table\').val());
	$(\'#latest_type\').change(function (){
		latestTypeChange($(this).val(), $(\'#latest_table\').val());
	});
*/
echo '</script>';

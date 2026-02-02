<?php
include_once('./_common.php');

$count = $_REQUEST['count'] ? preg_replace('/[^0-9a-zA-Z]/', '', strip_tags($_REQUEST['count'])) : '';
$itemtype = explode("|", $default['itemtype']); //상품유형

echo '<li class="shop_top_menu_list shopmenu_'.$count.'">';
echo '<input type="text" name="shopmenu_order[]" value="" class="shopmenu_order w-50" size="5" placeholder="순서">';
echo '<select name="shopmenu[]" class="menuChoice selectpicker min160">';
echo option_selected('', '', "메뉴선택 (직접입력)", "");
for ($t=0; $t < 5; $t++) {
	$num = $t + 1;
	if($itemtype[$t]) echo option_selected_my($itemtype[$t], $list[$i]['shopmenu_name'], $itemtype[$t], "data-content='<b class=\"op5\">".$itemtype[$t]."</b> <small>(상품유형)</small>'");
}
echo option_selected_my('_event', '', "이벤트", "data-content='<b>이벤트</b>'");
echo option_selected_my('_all', '', "전체상품", "data-content='<b>전체상품</b>'");
echo option_selected_my('_page', '', "블럭 페이지", "data-content='<b>블럭 페이지</b>'");
echo option_selected_my('_board', '', "게시판", "data-content='<b>게시판</b>'");
echo '</select>';
echo '<div class="_shopMenuBoard" style="display:none;"><select name="shopmenu_link[]" value="" class="selectpicker" data-live-search="true">';
	echo get_board_select_option_my('', 'shop_');
echo '</select></div>';
echo '<label class="labelInput _shopMenuName"><span class="label">메뉴명</span><input type="text" name="shopmenu_name[]" value="" class="w-150" placeholder="필수" required></label>';
echo '<label class="labelInput flex1 _shopMenuLink"><span class="label">링크</span><input type="text" name="shopmenu_link[]" value="" class="w-full"></label>';

echo '<div class="_shopMenuLinkOption">';
	echo '<select name="shopmenu_link_option[]" class="selectpicker">';
		echo option_selected("", '', "바로가기");
		echo option_selected("_blank", '', "새창열기");
	echo '</select>';
echo '</div>';
echo '<button type="button" class="btn_del_menu _btn/sm/h-29/gray">삭제</button>';
echo '</li>';


function option_selected_my($value, $selected, $text='', $event='') {
    if (!$text) $text = $value;
    if ($value == $selected)
        return "<option value=\"$value\" selected=\"selected\" $event>$text</option>\n";
    else
        return "<option value=\"$value\" $event>$text</option>\n";
}

function get_board_select_option_my($selected='', $strpos='') {
    global $g5, $board;
    $sql = " select bo_table, bo_subject, bo_skin from {$g5['board_table']} order by bo_order ";
    $result = sql_query($sql);
	
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$optionText = $row['bo_subject'].' <small>('.$row['bo_table'].')</small>';
		if(strpos($row['bo_skin'], 'pageMake') !== false)
			continue;
		
		if($strpos) {
			$str .= strpos($row['bo_skin'], $strpos) !== false ? option_selected_my($row['bo_table'], $selected, $row['bo_subject'], "data-content='".$optionText."'") : '';
		} else {
			$str .= option_selected_my($row['bo_table'], $selected, $row['bo_subject'], "data-content='".$optionText."'");
		}
		
    }

    return $str;
}
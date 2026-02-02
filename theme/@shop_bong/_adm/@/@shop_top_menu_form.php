<?php
include_once('./_common.php');

$count = $_REQUEST['count'] ? preg_replace('/[^0-9a-zA-Z]/', '', strip_tags($_REQUEST['count'])) : '';
$itemtype = explode("|", $default['itemtype']); //상품유형

echo '<li class="shop_top_menu_list shopmenu_'.$count.'">';
echo '<input type="text" name="shopmenu_order[]" value="" class="shopmenu_order w-50" size="5" placeholder="순서">';
echo '<select name="shopmenu[]" class="menuChoice selectpicker min160">';
echo option_selected('', $list[$i]['shopmenu_name'], "메뉴선택 (직접입력)", "");
for ($t=0; $t < 5; $t++) {
	$num = $t + 1;
	if($itemtype[$t]) echo option_selected_my($itemtype[$t], $list[$i]['shopmenu_name'], $itemtype[$t], "data-content='<b class=\"op5\">".$itemtype[$t]."</b> <small>(상품유형)</small>'");
}
echo option_selected_my('전체상품', $list[$i]['shopmenu_name'], "전체상품", "data-content='<b>전체상품</b>'");
echo '</select>';
echo '<div class="menuform">';
echo '<label class="labelInput"><span class="label">메뉴명</span><input type="text" name="shopmenu_name[]" value="" class="w-120"></label>';
echo '<label class="labelInput flex1"><span class="label">링크</span><input type="text" name="shopmenu_link[]" value="" class="w-full"></label>';
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
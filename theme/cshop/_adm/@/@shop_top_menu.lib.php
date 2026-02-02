<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function get_shop_top_menu_list($code="",$cha=1,$gr_id='') {
    global $g5 , $default;
	
	//상품유형
	$itemtype = explode("|", $default['itemtype']);

    $where = "";
	
    $sql = " SELECT * FROM ".$g5['g5_shop_top_menu_table']." WHERE (1) ".$where." ORDER BY shopmenu_order, shopmenu_id ";
    $result = sql_query($sql);

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $list[$i] = $row;
        $list['cnt']++;
        $search  = array('"', "'");
        $replace = array('&#034;', '&#039;');
        $shopmenu_name = str_replace($search, $replace, $list[$i]['shopmenu_name']);
		
		echo '<li class="shop_top_menu_list shopmenu_'.$list['cnt'].'">';
		echo '<input type="text" name="shopmenu_order[]" value="'.$list[$i]['shopmenu_order'].'" class="shopmenu_order w-50" size="5" placeholder="순서">';
		echo '<select name="shopmenu[]" class="menuChoice selectpicker min160">';
		echo option_selected('', $list[$i]['shopmenu'], "메뉴선택 (직접입력)", "");
		for ($t=0; $t < 5; $t++) {
			$num = $t + 1;
			if($itemtype[$t]) echo option_selected_my($itemtype[$t], $list[$i]['shopmenu'], $itemtype[$t], "data-content='<b class=\"op5\">".$itemtype[$t]."</b> <small>(상품유형)</small>'");
		}
		echo option_selected_my('전체상품', $list[$i]['shopmenu'], "전체상품", "data-content='<b>전체상품</b>'");
		echo '</select>';
		echo '<div class="menuform"'.($list[$i]['shopmenu']?' style="display:none"':'').'>';
		echo '<label class="labelInput"><span class="label">메뉴명</span><input type="text" name="shopmenu_name[]" value="'.$list[$i]['shopmenu_name'].'" class="w-120"></label>';
		echo '<label class="labelInput flex1"><span class="label">링크</span><input type="text" name="shopmenu_link[]" value="'.$list[$i]['shopmenu_link'].'" class="w-full"></label>';
		echo '</div>';
		echo '<button type="button" class="btn_del_menu _btn/sm/h-29/gray">삭제</button>';
		echo '</li>';	
    }
}

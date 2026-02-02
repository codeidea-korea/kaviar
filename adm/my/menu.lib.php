<?php
if (!defined('_GNUBOARD_')) exit;

function get_navi_menu($code="",$cha=1) {
    global $g5 , $config;

    $cha2 = $cha*2;
    $where = "";
    $where = " AND LENGTH(me_code) = '".$cha2."' ";
    if($cha != 1)
        $where .= " AND me_code LIKE '".$code."%' ";

    $sql = " SELECT * FROM ".$g5['menu_table']." WHERE (1) ".$where." ORDER BY me_order ";
    $result = sql_query($sql);
    $cha3 = $cha+1;

    for($i=0; $row=sql_fetch_array($result); $i++) {
        $list[$i] = $row; //1차분류
        $list['cnt']++;
        $meCode = $list[$i]['me_code'];
        $chaMenu = strlen($list[$i]['me_code'])/2; //메뉴단계
        $sub_menu_class = '';
        if(strlen($list[$i]['me_code']) > 2) { //if(strlen($list[$i]['me_code']) == 4) {
            $sub_menu_class = ' sub_menu_class'.$chaMenu;
            $sub_menu_info = '<span class="sound_only">'.$list[$i]['me_name'].'의 서브</span>';
            $sub_menu_ico = '<span class="sub_menu_ico"></span>';
        }

        $search  = array('"', "'");
        $replace = array('&#034;', '&#039;');
        $me_name = str_replace($search, $replace, $list[$i]['me_name']);
?>
    <tr class="menu_list menu_group_<?=substr($list[$i]['me_code'], 0, 2)?> <?=strlen($list[$i]['me_code'])>2?'menu_group_'.$chaMenu.'_'.$list[$i]['me_code']:'menu_group_1_'.substr($list[$i]['me_code'],0,2)?> <?=!$list[$i]['me_use']?'no-use':''?>">
		<td class="tright">
            <label for="me_use_<?=$i?>" class="sound_only">사용여부</label>
            <select name="me_use[]" id="me_use_<?=$i?>" class="selectpicker">
                <option value="1"<?=get_selected($list[$i]['me_use'], '1', true)?>>모두사용</option>
				<option value="2"<?=get_selected($list[$i]['me_use'], '2', true)?>>PC만 사용</option>
				<option value="3"<?=get_selected($list[$i]['me_use'], '3', true)?>>모바일만 사용</option>
                <option value="0"<?=get_selected($list[$i]['me_use'], '0', true)?>>사용안함</option>
            </select>
        </td>
		<td class="td_tmp <?=$sub_menu_class?>">
			<div class="flex gap5">
				<input type="text" name="me_order[]" value="<?=$list[$i]['me_order']?>" id="me_order_<?=$i?>" class="me_order w-40" size="5">
				<input type="hidden" name="code[]" value="<?=substr($list[$i]['me_code'], 0, 2)?>">
				<input type="hidden" name="code2[]" value="<?php echo $list[$i]['me_code'];?>">
				<input type="hidden" name="chaMenu[]" value="<?php echo $chaMenu;?>">
				<label for="me_name_<?=$i?>" class="sound_only"><?=$sub_menu_info?> 카테고리</label>
				<input type="text" name="me_name[]" value="<?=$me_name?>" id="me_name_<?=$i?>" class="me_name flex1" placeholder="<?=$chaMenu?>차 메뉴">
			</div>
        </td>
		<td>
            <label for="me_link_<?=$i?>" class="sound_only">링크</label>
			<input type="text" name="me_link[]" value="<?=$list[$i]['me_link']?>" id="me_link_<?=$i?>" class="w-full">
        </td>
		<td>
            <label for="me_target_<?=$i?>" class="sound_only">링크옵션</label>
            <select name="me_target[]" id="me_target_<?=$i?>" class="selectpicker w-full me_target">
                <option value="" <?=get_selected($list[$i]['me_target'], '', true)?>>바로이동</option>
                <option value="blank" <?=get_selected($list[$i]['me_target'], 'blank', true)?>>새창 열기</option>
				<option value="popup" <?=get_selected($list[$i]['me_target'], 'popup', true)?>>팝업(새창 팝업)</option>	
				<option value="alert" <?=get_selected($list[$i]['me_target'], 'alert', true)?>>← 엘럿 메시지</option>				
            </select>
        </td>
		<td>
			<label for="me_level[<?=$i?>]" class="sound_only">노출권한<strong class="sound_only"> 필수</strong></label>
			<select name="me_level[]" id="me_level[<?=$i?>]" class="me_level w-full selectpicker" data-style="<?=$list[$i]['me_level']>4?'selectColor-black':'selectColor-lightGray'?>">
				<option value="1"<?=get_selected($list[$i]['me_level'], '1', true)?>>1</option>
				<option value="2"<?=get_selected($list[$i]['me_level'], '2', true)?>>2</option>
				<option value="3"<?=get_selected($list[$i]['me_level'], '3', true)?>>3</option>
				<option value="4"<?=get_selected($list[$i]['me_level'], '4', true)?>>4</option>
				<option value="5"<?=get_selected($list[$i]['me_level'], '5', true)?>>5</option>
				<option value="6"<?=get_selected($list[$i]['me_level'], '6', true)?>>6</option>
				<option value="7"<?=get_selected($list[$i]['me_level'], '7', true)?>>7</option>
				<option value="8"<?=get_selected($list[$i]['me_level'], '8', true)?>>8</option>
				<option value="9"<?=get_selected($list[$i]['me_level'], '9', true)?>>9</option>
				<option value="10"<?=get_selected($list[$i]['me_level'], '10', true)?>>10</option>
			</select>
        </td>       
        <td class="td_mng">
			<?php if($chaMenu < 3) {
				$addBtnName = $chaMenu == 1 ? '(2차)':'(3차)';
				echo '<button type="button" class="btn_add_submenu btn_03"><small>추가 <span class="color-yellow">'.$addBtnName.'</span></small></button>';
			} ?>
            <button type="button" class="btn_del_menu btn_02">삭제</button>
        </td>
    </tr>
<?php
        echo get_navi_menu($meCode,$cha3);		
    }
	//if ($i==0) echo '<tr id="empty_menu_list"><td colspan="6" class="empty_table">자료가 없습니다.</td></tr>';
}
?>
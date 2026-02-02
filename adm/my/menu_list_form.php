<?php
include_once('./_common.php');

$newitem = $_POST['newitem'];
$code = $_REQUEST['code'] ? preg_replace('/[^0-9a-zA-Z]/', '', strip_tags($_REQUEST['code'])) : '';
$code2 = $_REQUEST['code2'] ? preg_replace('/[^0-9a-zA-Z]/', '', strip_tags($_REQUEST['code2'])) : '';
$chaMenu = $_REQUEST['chaMenu'] ? preg_replace('/[^0-9]/', '', strip_tags($_REQUEST['chaMenu'])) : '';


// 코드
if($newitem == 'new' || !$code) {
    $code = base_convert(substr($code,0, 2), 36, 10);
    $code += 36;
    $code = base_convert($code, 10, 36);
    $chaMenu = 1;
    $code2 = '';
    $me_code = $code;
	$sub_menu_class = '';
} else {
    $chaMenu = $chaMenu+1;

    if($chaMenu) {
        $chaMenuLen = ($chaMenu*2);
        $sqlChaLen = ($chaMenuLen-1); //차시에 따른 me_code 길이
        switch($chaMenu) { //차시에 따른 me_code 길이( 2자리는 계산하고 나머지는 그냥 불러오기 )
            case "2" : $chaLen = "2"; break;
            case "3" : $chaLen = "4"; break;
            case "4" : $chaLen = "6"; break;
            case "5" : $chaLen = "8"; break;
            case "6" : $chaLen = "10"; break;
        }
    }
    $inCode = $code2?$code2:$code;
    $pCode = substr($inCode,0,$chaLen);
    $sql = " SELECT MAX(SUBSTRING(me_code,".$sqlChaLen.",2)) AS max_me_code FROM ".$g5['menu_table']." WHERE SUBSTRING(me_code,1,".$chaLen.") = '".$pCode."' ";
    $row = sql_fetch($sql);

    $sub_code = base_convert($row['max_me_code'], 36, 10);
    $sub_code += 36;
    $sub_code = base_convert($sub_code, 10, 36);
    $me_code = substr($inCode, 0, $chaLen).$sub_code;
	$sub_menu_class = 'sub_menu_class'.$chaMenu;
}
//echo $newitem;

echo '<tr class="menu_list tmp_list menu_group_'.substr($code,0,2).' menu_group_'.$chaMenu.'_'.$me_code.'">';
echo '<td>';
echo '<select name="me_use[]" id="me_use_'.$i.'" class="selectpicker span">';
echo '<option value="1">모두사용</option>';
echo '<option value="2">PC만 사용</option>';
echo '<option value="3">모바일만 사용</option>';
echo '<option value="0">사용안함</option>';
echo '</select>';
echo '</td>';
echo '<td class="td_tmp '.$sub_menu_class.'">';
echo '<div class="flex gap5">';
echo '<input type="text" name="me_order[]" value="0" class="me_order span40" size="5">';
echo '<input type="hidden" name="code[]" value="'.$code.'">';
echo '<input type="hidden" name="code2[]" value="'.$me_code.'">';
echo '<input type="hidden" name="chaMenu[]" value="'.$chaMenu.'">';
echo '<input type="text" name="me_name[]" value="" class="me_name flex1" placeholder="'.$chaMenu.'차 메뉴">';
echo '</div>';
echo '</td>';
echo '<td>';
echo '<input type="text" name="me_link[]" value="" class="w-full">';
echo '</td>';
echo '<td>';
echo '<select name="me_target[]" id="me_target_'.$i.'" class="selectpicker span">';
echo '<option value="">바로이동</option>';
echo '<option value="blank">새창 열기</option>';
echo '<option value="popup">팝업(새창 팝업)</option>';	
echo '<option value="alert">← 엘럿 메시지</option>';				
echo '</select>';
echo '</td>';
echo '<td>';
echo '<select name="me_level[]" id="me_level['.$i.']" class="me_level span selectpicker" data-style="selectColor-lightGray">';
echo '<option value="1">1</option>';
echo '<option value="2">2</option>';
echo '<option value="3">3</option>';
echo '<option value="4">4</option>';
echo '<option value="5">5</option>';
echo '<option value="6">6</option>';
echo '<option value="7">7</option>';
echo '<option value="8">8</option>';
echo '<option value="9">9</option>';
echo '<option value="10">10</option>';
echo '</select>';
echo '</td>';
echo '<td class="td_mng">';
echo '<button type="button" class="btn_del_menu btn">삭제</button>';
echo '</td>';
echo '</tr>';



<?php
$sub_menu = "100290";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

// 이전 메뉴정보 삭제
$sql = " delete from {$g5['menu_table']} ";
sql_query($sql);

$group_code = null;
$primary_code = null;
$count = isset($_POST['code']) ? count($_POST['code']) : 0;

echo $count;

for ($i=0; $i<$count; $i++) {
    $_POST = array_map_deep('trim', $_POST);
    
    $_POST['me_link'][$i] = is_array($_POST['me_link']) ? clean_xss_tags(clean_xss_attributes($_POST['me_link'][$i], 1)) : '';

    $code = is_array($_POST['code']) ? strip_tags($_POST['code'][$i]) : '';
	$code2 = $_POST['code2'][$i]; //해당 메뉴의 원래 코드
    $chaMenu = $_POST['chaMenu'][$i];
    $me_name = is_array($_POST['me_name']) ? strip_tags($_POST['me_name'][$i]) : '';
    $me_link = (preg_match('/^javascript/i', $_POST['me_link'][$i]) || preg_match('/script:/i', $_POST['me_link'][$i])) ? G5_URL : strip_tags(clean_xss_attributes($_POST['me_link'][$i]));
	$me_link = $me_link ? $me_link : '#';
	$me_level = strip_tags($_POST['me_level'][$i]);

    if(!$code) // || !$me_name || !$me_link - 메뉴명,링크없이 일단 저장 가능하도록 수정
        continue;

	if($chaMenu) {
        $chaMenuLen = ($chaMenu*2);
        $sqlChaLen = ($chaMenuLen-1); //차시에 따른 sub_code 길이
        switch($chaMenu) { //차시에 따른 sub_code 길이( 2자리는 계산하고 나머지는 그냥 불러오기 )
            case "2" : $chaLen = "2"; break;
            case "3" : $chaLen = "4"; break;
            case "4" : $chaLen = "6"; break;
            case "5" : $chaLen = "8"; break;
            case "6" : $chaLen = "10"; break;
        }
    } else {
		$chaMenu = 1;
	}

    $sub_code = '';	
	if($chaMenu >= 2) {
        $code21 = substr($code2,2,$chaLen);
        $code20 = $primary_code.$code21;
        $pCode = substr($code20,0,$chaLen);
        $sql = " select MAX(SUBSTRING(me_code,".$sqlChaLen.",2)) as max_me_code
                    from {$g5['menu_table']}
                    where SUBSTRING(me_code,1,".$chaLen.") = '".$pCode."' ";
        $row = sql_fetch($sql);

        $sub_code = base_convert($row['max_me_code'], 36, 10);
        $sub_code += 36;
        $sub_code = base_convert($sub_code, 10, 36);
        $me_code = substr($code20, 0, $chaLen).$sub_code;
    } else {
        $sql = " select MAX(SUBSTRING(me_code,1,2)) as max_me_code
                    from {$g5['menu_table']}
                    where LENGTH(me_code) = '2' ";
        $row = sql_fetch($sql);

        $me_code = base_convert($row['max_me_code'], 36, 10);
        $me_code += 36;
        $me_code = base_convert($me_code, 10, 36);

        $group_code = $code;
        $primary_code = $me_code;
    }

    // 메뉴 등록
    $sql = " insert into {$g5['menu_table']}
                set me_code			= '".$me_code."',
					 me_use			= '".sql_real_escape_string(strip_tags($_POST['me_use'][$i]))."',
					 me_order			= '".sql_real_escape_string(strip_tags($_POST['me_order'][$i]))."',
					 me_name			= '".$me_name."',
                     me_link			= '".$me_link."',
					 me_target			= '".sql_real_escape_string(strip_tags($_POST['me_target'][$i]))."',
					 me_level			= '".$me_level."'
					 ";
    sql_query($sql);
}

run_event('admin_menu_list_update');

goto_url(G5_ADMIN_URL.'/menu_list.php');
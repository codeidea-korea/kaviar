<?php
$sub_menu = '400651';
include_once('./_common.php');

check_demo();

check_admin_token();

$count_post_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;

if (! $count_post_chk) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check_menu($auth, $sub_menu, 'd');

    for ($i=0; $i<$count_post_chk; $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
        $iiq_id = isset($_POST['wr_id'][$i]) ? (int) $_POST['wr_id'][$k] : 0;

        $sql = "update `g5_write_11_inquiry` set wr_del = 'Y' where wr_id = '{$iiq_id}' ";
        sql_query($sql);
    }
}

goto_url("./itemonelist.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page");
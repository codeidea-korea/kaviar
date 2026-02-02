<?php
$sub_menu = '500300';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$post_ev_id_count = (isset($_POST['ev_id']) && is_array($_POST['ev_id'])) ? count($_POST['ev_id']) : 0;

for ($i=0; $i<$post_ev_id_count; $i++) {
     
    //$p_ca_name = is_array($_POST['ca_name']) ? strip_tags(clean_xss_attributes($_POST['ca_name'][$i])) : '';
    
    $posts = array();

    $check_keys = array('ev_order', 'ev_id');

    foreach($check_keys as $key){
        $posts[$key] = (isset($_POST[$key]) && isset($_POST[$key][$i])) ? $_POST[$key][$i] : '';
    }
    
    $sql = " update {$g5['g5_shop_event_table']}
                set ev_order        = '".sql_real_escape_string(strip_tags($posts['ev_order']))."'
              where ev_id = '".sql_real_escape_string($posts['ev_id'])."' ";

    sql_query($sql);

}

goto_url(G5_ADMIN_URL."/shop_admin/itemevent.php?$qstr");
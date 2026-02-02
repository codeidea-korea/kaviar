<?php
$sub_menu = '400900';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();


$item_ratio = implode("|", $_POST['item_ratio']);

$sql = " update {$g5['g5_shop_default_table']}
            set shop_type									= '{$shop_type}',
				de_review_guide							= '{$de_review_guide}',
                shop_use_closure							= '{$shop_use_closure}',
				item_ratio										= '{$item_ratio}',
				shop_use_it_avg							= '{$shop_use_it_avg}',
				use_item_discount_rate_decimal		= '{$use_item_discount_rate_decimal}',
				use_item_price_deco						= '{$use_item_price_deco}'
                ";
sql_query($sql);

run_event('shop_admin_configformupdate');

goto_url("./config_form.php");
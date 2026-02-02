<?php
include_once('./_common.php');


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



echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";
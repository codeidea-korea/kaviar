<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_BBS_PATH.'/my/_adm/_shop_item.lib.php');

$sql_common = " from {$g5['g5_shop_store_table']} where store_use = '1' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$shop_sql = "select * $sql_common order by store_order < 0, store_order = 0, store_order, store_id";
$shop_result = sql_query($shop_sql);
?>

<style>
.store_chk_list{display:flex;align-items:center;flex-wrap:wrap;gap:10px 18px;}
.store_chk_list > *{padding:5px;border:1px solid rgba(0,0,0,0.1);border-radius:4px;}
.store_chk_list > *:hover{box-shadow:0 4px 5px rgba(0,0,0,0.05);}
</style>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_store_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<?=get_item_mini($it_id)?>
<section class="mybox blue mt15">	
	<div class="formContainer label110">
		<div class="form-list">
			<div class="form-label"><label>지점 선택</label></div>
			<div class="formCon">
				<?php
				/*echo '<div class="store_chk_list">';
				for ($i=0; $row=sql_fetch_array($shop_result); $i++) {
					echo '<input type="checkbox" name="item_store[]" value="'.$row['store_subject'].'"'.(strpos($it['item_store'], $row['store_subject']) !== false ? " checked" : "").' data-label="'.$row['store_subject'].'">';
				}
				echo '</div>';*/
				?>
			</div>
		</div>
	</div>
</section>

<div class="mt10">
	<a href="<?=shop_short_url_my('shopStore')?>" class="_btn/black rd5" target="_blank">지점 관리 -></a>
</div>


<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$(function() {
	$(document).on("click", "#add_item_info", function() {
		add_item_info();
	});

	$(document).on("click", ".del-info", function() {
		var $li = $(this).closest("li");
		$li.remove();        
	});
});	

function add_item_info() {
	var $option_list = $("#item_info");
	var list = '<li>';
	list += '<input type="text" name="item_info_subject[]" value="" id="it_name" class="w-180" placeholder="라벨명">';
	list += '<input type="text" name="item_info_value[]" value="" id="it_name" class="flex1" placeholder="설명">';
	list += '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
	list += '</li>';
	var $list_last = null;
	var $list_last = $option_list.find("li:last");
	$list_last.after(list);
}

$(function() {
<?php
switch($it['it_sc_type']) {
	case 1:
		echo '$("#sc_con_method").hide();'.PHP_EOL;
		echo '$("#sc_con_basic").hide();'.PHP_EOL;
		echo '$("#sc_con_minimum").hide();'.PHP_EOL;
		echo '$("#sc_con_qty").hide();'.PHP_EOL;
		echo '$("#sc_grp").attr("rowspan","1");'.PHP_EOL;
		break;
	case 2:
		echo '$("#sc_con_method").show();'.PHP_EOL;
		echo '$("#sc_con_basic").show();'.PHP_EOL;
		echo '$("#sc_con_minimum").show();'.PHP_EOL;
		echo '$("#sc_con_qty").hide();'.PHP_EOL;
		echo '$("#sc_grp").attr("rowspan","4");'.PHP_EOL;
		break;
	case 3:
		echo '$("#sc_con_method").show();'.PHP_EOL;
		echo '$("#sc_con_basic").show();'.PHP_EOL;
		echo '$("#sc_con_minimum").hide();'.PHP_EOL;
		echo '$("#sc_con_qty").hide();'.PHP_EOL;
		echo '$("#sc_grp").attr("rowspan","3");'.PHP_EOL;
		break;
	case 4:
		echo '$("#sc_con_method").show();'.PHP_EOL;
		echo '$("#sc_con_basic").show();'.PHP_EOL;
		echo '$("#sc_con_minimum").hide();'.PHP_EOL;
		echo '$("#sc_con_qty").show();'.PHP_EOL;
		echo '$("#sc_grp").attr("rowspan","4");'.PHP_EOL;
		break;
	default:
		echo '$("#sc_con_method").hide();'.PHP_EOL;
		echo '$("#sc_con_basic").hide();'.PHP_EOL;
		echo '$("#sc_con_minimum").hide();'.PHP_EOL;
		echo '$("#sc_con_qty").hide();'.PHP_EOL;
		echo '$("#sc_grp").attr("rowspan","2");'.PHP_EOL;
		break;
}
?>
$("#it_sc_type").change(function() {
	var type = $(this).val();

	switch(type) {
		case "1":
			$("#sc_con_method").hide();
			$("#sc_con_basic").hide();
			$("#sc_con_minimum").hide();
			$("#sc_con_qty").hide();
			$("#sc_grp").attr("rowspan","1");
			break;
		case "2":
			$("#sc_con_method").show();
			$("#sc_con_basic").show();
			$("#sc_con_minimum").show();
			$("#sc_con_qty").hide();
			$("#sc_grp").attr("rowspan","4");
			break;
		case "3":
			$("#sc_con_method").show();
			$("#sc_con_basic").show();
			$("#sc_con_minimum").hide();
			$("#sc_con_qty").hide();
			$("#sc_grp").attr("rowspan","3");
			break;
		case "4":
			$("#sc_con_method").show();
			$("#sc_con_basic").show();
			$("#sc_con_minimum").hide();
			$("#sc_con_qty").show();
			$("#sc_grp").attr("rowspan","4");
			break;
		default:
			$("#sc_con_method").hide();
			$("#sc_con_basic").hide();
			$("#sc_con_minimum").hide();
			$("#sc_con_qty").hide();
			$("#sc_grp").attr("rowspan","1");
			break;
	}
});
});
</script>
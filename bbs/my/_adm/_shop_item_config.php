<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_BBS_PATH.'/my/_adm/_shop_item.lib.php');

// 분류리스트
$category_select = '';
$script = '';
$sql = " select * from {$g5['g5_shop_category_table']} ";
if ($is_admin != 'super')
    $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
$sql .= " order by ca_order, ca_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $len = strlen($row['ca_id']) / 2 - 1;
    $nbsp = "";
    for ($i=0; $i<$len; $i++)
        $nbsp .= "&nbsp;&nbsp;&nbsp;";

    $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";

    $script .= "ca_use['{$row['ca_id']}'] = {$row['ca_use']};\n";
    $script .= "ca_stock_qty['{$row['ca_id']}'] = {$row['ca_stock_qty']};\n";
    $script .= "ca_sell_email['{$row['ca_id']}'] = '{$row['ca_sell_email']}';\n";
}
?>

<!-- datetimepicker3 -->
<script src="<?=G5_JS_URL?>/my/form/datetimepicker/moment-with-locales.min.js"></script>
<script src="<?=G5_JS_URL?>/my/form/datetimepicker/bootstrap-datetimepicker.js"></script>
<link href="<?=get_url(G5_JS_URL.'/my/form/datetimepicker/my.css')?>" rel="stylesheet">
<script>
$(function() {
	$("#it_timer").datetimepicker({ 
		locale: "ko",
		format: "YYYY-MM-DD HH:mm",
		//inline: true,
		defaultDate: moment()
	});			
});
</script>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_config_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label110">
		<div class="form-list">
			<div class="form-label"><label>상품 타입</label></div>
			<div class="formCon column">
				<select name="it_type" id="it_type" class="w-150">
                    <option value="0" <?php echo get_selected($it['it_type'], 0); ?>>배송 상품</option>
                    <option value="1" <?php echo get_selected($it['it_type'], 1); ?>>예약 상품</option>
                </select>
			</div>
		</div>
		<script>matchOnOff('#it_type', '0', '#delivery-info', '', '');</script>
		<div class="form-list">
			<div class="form-label"><label>상품 분류</label></div>
			<div class="formCon flex flex-middle gap10">
				<select name="ca_id" id="ca_id">
                    <option value="">선택하세요</option>
                    <?php echo conv_selected_option($category_select, $it['ca_id']); ?>
                </select>
				<select name="ca_id2" id="ca_id2">
                    <option value="">선택하세요</option>
                    <?php echo conv_selected_option($category_select, $it['ca_id2']); ?>
                </select>
				<select name="ca_id3" id="ca_id3">
                    <option value="">선택하세요</option>
                    <?php echo conv_selected_option($category_select, $it['ca_id3']); ?>
                </select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>상품명</label></div>
			<div class="formCon">
				<input type="text" name="it_name" value="<?php echo get_text(cut_str($it['it_name'], 250, "")); ?>" id="it_name" required class="frm_input required" size="95">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>판매가격</label></div>
			<div class="formCon">
				<input type="text" name="it_price" value="<?php echo $it['it_price']; ?>" id="it_price" class="frm_input sit_amt color-red" size="8" data-label-right="원">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>시중가격</label></div>
			<div class="formCon">
				<input type="text" name="it_cust_price" value="<?php echo $it['it_cust_price']; ?>" id="it_cust_price" class="frm_input tright color-gray" size="8" data-label-right="원">
			</div>
		</div>
		<?php
		$startdate = date("Y-m-d H:i:s", time());
		$enddate = $it['it_timer'] ? $it['it_timer'].':00' : '';
		$timediffer = strtotime($enddate) - strtotime($startdate);
		$is_item_timer = $it['it_time_price'] && $it['it_timer'] && $timediffer > 0 ? true : false;
		//실판매가격 업데이트
		update_real_price($it['it_id']);
		?>
		<div class="form-list" style="<?=$is_item_timer?'background:rgba(255,58,58,0.02);':''?>">
			<div class="form-label"><label>타임특가<?=$is_item_timer?' <span class="color-red">(적용중)</span>':''?></label></div>
            <div class="formCon">
                <input type="text" name="it_time_price" value="<?=$it['it_time_price']?$it['it_time_price']:''?>" id="it_time_price" class="frm_input tright<?=$is_item_timer?' color-red bold':' color-slate-400'?>" size="8" data-label-right="원">
				<label class="labelDatetime ml20">
					<span class="label">마감날짜</span>
                    <input type="text" name="it_timer" value="<?=$it['it_timer']?>" size="9" id="it_timer" class="w-150<?=$timediffer > 0?'':' color-slate-400'?>" placeholder="0000-00-00 00:00">
                </label>
				<p class="mt10 color-slate-400">
					특가 타이머가 진행되는 동안 적용할 가격과 특가타임 날짜.<br>특가와 마감일 둘다 입력해야 타임특가가 적용됩니다.<br>타이머가 완료되면 기본 판매가로 돌아갑니다.
				</p>
            </div>
        </div>
		<div class="form-list">
			<div class="form-label"><label>상품유형</label></div>
			<div class="formCon">
				<?php
				$itemtype = explode("|", $default['itemtype']);
				echo '<div class="flex flex-middle gap20 flex-wrap">';
				for ($t=0; $t < count($itemtype); $t++) {
					$num = $t + 1;
					if($itemtype[$t]) echo '<input type="checkbox" name="it_type'.$num.'" value="1" '.($it['it_type'.$num] ? "checked" : "").' id="it_type'.$num.'" data-label="'.$itemtype[$t].'">';
				}
				echo '</div>';
				?>
			</div>
		</div>
	</div>
</section>

<section class="mybox blue">
	<div class="flex flex-middle p10">
		<div class="fs14 bold color-blue"><input type="text" name="item_info1_label" value="<?=$it['item_info1_label']?>" id="item_info1_label" class="w-150 fs14 color-blue" placeholder="상품정보"></div>
		<span id="add_item_info1" class="_btn/mini/blue/line/rd5">추가</span>
	</div>
	<div class="formContainer label110">
		<div class="form-list">
			<div class="formCon">				
				<ul id="item_info1" class="item_info">
					<?php for ($i=0; $i < count($item_info1_subject); $i++) {
						echo '<li>';
							echo '<input type="text" name="item_info1_subject[]" value="'.$item_info1_subject[$i].'" id="item_info1_subject" class="w-180" placeholder="라벨명">';
							echo '<input type="text" name="item_info1_value[]" value="'.$item_info1_value[$i].'" id="item_info1_value" class="flex1" placeholder="설명">';
							echo '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
						echo '</li>';
					} ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="mybox blue">
	<div class="flex flex-middle p10">
		<div class="fs14 bold color-blue"><input type="text" name="item_info2_label" value="<?=$it['item_info2_label']?>" id="item_info2_label" class="w-150 fs14 color-blue" placeholder="상품정보"></div>
		<span id="add_item_info2" class="_btn/mini/blue/line/rd5">추가</span>
	</div>
	<div class="formContainer label110">
		<div class="form-list">
			<div class="formCon">				
				<ul id="item_info2" class="item_info">
					<?php for ($i=0; $i < count($item_info2_subject); $i++) {
						echo '<li>';
							echo '<input type="text" name="item_info2_subject[]" value="'.$item_info2_subject[$i].'" id="item_info2_subject" class="w-180" placeholder="라벨명">';
							echo '<input type="text" name="item_info2_value[]" value="'.$item_info2_value[$i].'" id="item_info2_value" class="flex1" placeholder="설명">';
							echo '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
						echo '</li>';
					} ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="mybox blue">
	<div class="flex flex-middle p10">
		<div class="fs14 bold color-blue"><input type="text" name="item_info3_label" value="<?=$it['item_info3_label']?>" id="item_info3_label" class="w-150 fs14 color-blue" placeholder="상품정보"></div>
		<span id="add_item_info3" class="_btn/mini/blue/line/rd5">추가</span>
	</div>
	<div class="formContainer label110">
		<div class="form-list">
			<div class="formCon">				
				<ul id="item_info3" class="item_info">
					<?php for ($i=0; $i < count($item_info3_subject); $i++) {
						echo '<li>';
							echo '<input type="text" name="item_info3_subject[]" value="'.$item_info3_subject[$i].'" id="item_info3_subject" class="w-180" placeholder="라벨명">';
							echo '<input type="text" name="item_info3_value[]" value="'.$item_info3_value[$i].'" id="item_info3_value" class="flex1" placeholder="설명">';
							echo '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
						echo '</li>';
					} ?>
				</ul>
			</div>
		</div>
	</div>
</section>

<section id="delivery-info" class="mybox blue">	
	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><label>배송안내<span class="color-slate ml5">(공통)</span></label></div>
			<div class="formCon">
				<?=$default['de_baesong_content']?>
				<a href="<?=G5_ADMIN_URL?>/shop_admin/configform.php?#de_baesong_content_set" target="_blank" class="_btn/mini/blue/rd5">수정</a>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>배송비 유형</label></div>
			<div class="formCon">
				<select name="it_sc_type" id="it_sc_type">
					<option value="0"<?php echo get_selected('0', $it['it_sc_type']); ?>>쇼핑몰 기본설정 사용</option>
					<option value="1"<?php echo get_selected('1', $it['it_sc_type']); ?>>무료배송</option>
					<option value="2"<?php echo get_selected('2', $it['it_sc_type']); ?>>조건부 무료배송</option>
					<option value="3"<?php echo get_selected('3', $it['it_sc_type']); ?>>유료배송</option>
					<option value="4"<?php echo get_selected('4', $it['it_sc_type']); ?>>수량별 부과</option>
				</select>
			</div>
		</div>
		<div class="form-list" id="sc_con_method">
			<div class="form-label"><label>배송비 결제</label></div>
			<div class="formCon">
				<select name="it_sc_method" id="it_sc_method">
				<option value="0"<?php echo get_selected('0', $it['it_sc_method']); ?>>선불</option>
				<option value="1"<?php echo get_selected('1', $it['it_sc_method']); ?>>착불</option>
				<option value="2"<?php echo get_selected('2', $it['it_sc_method']); ?>>사용자선택</option>
				</select>
			</div>
		</div>
		<div class="form-list" id="sc_con_basic">
			<div class="form-label"><label>기본배송비</label></div>
			<div class="formCon">
				<?php echo help("무료배송 이외의 설정에 적용되는 배송비 금액입니다."); ?>
				<input type="text" name="it_sc_price" value="<?php echo $it['it_sc_price']; ?>" id="it_sc_price" class="frm_input" size="8" data-label-inline="원">
			</div>
		</div>
		<div class="form-list" id="sc_con_minimum">
			<div class="form-label"><label>배송비 상세조건</label></div>
			<div class="formCon">
				<input type="text" name="it_sc_minimum" value="<?php echo $it['it_sc_minimum']; ?>" id="it_sc_minimum" class="frm_input" size="8" data-label="주문금액"> 이상 무료 배송
			</div>
		</div>
		<div class="form-list" id="sc_con_qty">
			<div class="form-label"><label>배송비 상세조건</label></div>
			<div class="formCon">
				<?php echo help("상품의 주문 수량에 따라 배송비가 부과됩니다. 예를 들어 기본배송비가 3,000원 수량을 3으로 설정했을 경우 상품의 주문수량이 5개이면 6,000원 배송비가 부과됩니다."); ?>
				<input type="text" name="it_sc_qty" value="<?php echo $it['it_sc_qty']; ?>" id="it_sc_qty" class="frm_input" size="8" data-label="주문수량"> 마다 배송비 부과
			</div>
		</div>		
		<div class="form-list">
			<div class="form-label"><label>택배사<span class="color-slate ml5">(공통)</span></label></div>
			<div class="formCon">
				<?=$default['de_delivery_company']?$default['de_delivery_company']:'없음'?>
				<a href="<?=G5_ADMIN_URL?>/shop_admin/configform.php?#anc_scf_delivery" target="_blank" class="_btn/mini/blue/rd5 ml10">수정</a>
			</div>
		</div>
	</div>
</section>



<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
$(function() {
	$(document).on("click", "#add_item_info1", function() {
		add_item_info1();
	});
	$(document).on("click", "#add_item_info2", function() {
		add_item_info2();
	});
	$(document).on("click", "#add_item_info3", function() {
		add_item_info3();
	});

	$(document).on("click", ".del-info", function() {
		var $li = $(this).closest("li");
		$li.remove();        
	});
});	

function add_item_info1() {
	var $option_list = $("#item_info1");
	var list = '<li>';
	list += '<input type="text" name="item_info1_subject[]" value="" id="item_info1_subject" class="w-180" placeholder="라벨명">';
	list += '<input type="text" name="item_info1_value[]" value="" id="item_info1_value" class="flex1" placeholder="설명">';
	list += '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
	list += '</li>';
	var $list_last = null;
	var $list_last = $option_list.find("li:last");
	$list_last.after(list);
}
function add_item_info2() {
	var $option_list = $("#item_info2");
	var list = '<li>';
	list += '<input type="text" name="item_info2_subject[]" value="" id="item_info2_subject" class="w-180" placeholder="라벨명">';
	list += '<input type="text" name="item_info2_value[]" value="" id="item_info2_subject" class="flex1" placeholder="설명">';
	list += '<span class="del-info _btn/mini/red/line/rd5">삭제</span>';
	list += '</li>';
	var $list_last = null;
	var $list_last = $option_list.find("li:last");
	$list_last.after(list);
}
function add_item_info3() {
	var $option_list = $("#item_info3");
	var list = '<li>';
	list += '<input type="text" name="item_info3_subject[]" value="" id="item_info3_subject" class="w-180" placeholder="라벨명">';
	list += '<input type="text" name="item_info3_value[]" value="" id="item_info3_value" class="flex1" placeholder="설명">';
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
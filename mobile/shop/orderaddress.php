<?php
include_once('./_common.php');

$order_action_url = G5_HTTPS_SHOP_URL.'/orderaddressupdate.php';

// 테마에 orderaddress.php 있으면 include
if(defined('G5_THEME_MSHOP_PATH')) {
    $theme_orderaddress_file = file_exists(G5_THEME_MSHOP_PATH.'/orderaddress.php') ? G5_THEME_MSHOP_PATH.'/orderaddress.php' : G5_THEME_SHOP_PATH.'/orderaddress.php';
    if(is_file($theme_orderaddress_file)) {
        include_once($theme_orderaddress_file);
        return;
        unset($theme_orderaddress_file);
    }
}

$g5['title'] = '배송지 목록';
//include_once(G5_PATH.'/head.sub.php');

$back_skip = $home_skip = $search_skip = $store_skip = $cart_skip = true;
$topMenu_skip = true;
$head_title = '배송지 목록';
include_once(G5_MSHOP_PATH.'/_head.php');
?>

<form name="forderaddress" method="post" action="<?php echo $order_action_url; ?>" autocomplete="off">
<div id="sod_addr" style="min-height:calc(100vh - <?=$header_top_height?>px)">
	
	<div class="layer-head">
		<button type="button" onclick="self.close();" class="top_close_button">닫기</button>
	</div>

	<ul>
		<?php
		$sep = chr(30);
		for($i=0; $row=sql_fetch_array($result); $i++) {
			$addr = $row['ad_name'].$sep.$row['ad_tel'].$sep.$row['ad_hp'].$sep.$row['ad_zip1'].$sep.$row['ad_zip2'].$sep.$row['ad_addr1'].$sep.$row['ad_addr2'].$sep.$row['ad_addr3'].$sep.$row['ad_jibeon'].$sep.$row['ad_subject'];
			$addr = get_text($addr);
		?>
		<li>
			<input type="hidden" name="ad_id[<?php echo $i; ?>]" value="<?php echo $row['ad_id'];?>">
			<label class="checkbox-label"><input type="checkbox" name="chk[]" value="<?php echo $i;?>" id="chk_<?php echo $i;?>" class="ad_chk selec_chk"><span></span></label>
			<div class="addr_title">
				<input type="text" name="ad_subject[<?php echo $i; ?>]" value="<?php echo $row['ad_subject']; ?>" class="ad_subject w-full" maxlength="20" placeholder="배송지명 입력">
			</div>
			<div class="addr_info">
				<div class="addr_name fw600"><?php echo get_text($row['ad_name']); ?></div>
				<div class="addr_addr"><?php echo print_address($row['ad_addr1'], $row['ad_addr2'], $row['ad_addr3'], $row['ad_jibeon']); ?></div>
				<!--<div class="addr_tel"><?php echo $row['ad_tel']; ?> / <?php echo $row['ad_hp']; ?></div>-->
				<div class="addr_tel"><?php echo $row['ad_hp']; ?></div>
			</div>
			<div class="addr_btnSet">
				<input type="hidden" value="<?php echo $addr; ?>">
				<button type="button" class="sel_address _btn/sm">선택</button>
				<a href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?w=d&amp;ad_id=<?php echo $row['ad_id']; ?>" id="btn_del" class="del_address _btn/sm/red/line">삭제</a>
				<label class="radio-label ml10"><input type="radio" name="ad_default" value="<?php echo $row['ad_id'];?>" id="ad_default<?php echo $i;?>" <?php if($row['ad_default']) echo 'checked="checked"';?>><span></span>기본배송지</label>
			</div>
		</li>
		<?php
		}
		?>
	</ul>

    <div class="p20 flex flex-middle gap15 mt-auto">
        <!--<input type="submit" name="act_button" value="선택수정" class="btn_submit">-->
		<button type="submit" class="btn_submit _btn/lg flex1">선택수정</button>
		<button type="button" onclick="self.close();" class="btn_close _btn/lg/gray flex1">닫기</button>
    </div>
</div>
</form>

<?php echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
$(function() {
    $(".sel_address").on("click", function() {
        var addr = $(this).siblings("input").val().split(String.fromCharCode(30));

        var f = window.opener.forderform;
        f.od_b_name.value        = addr[0];
        f.od_b_tel.value         = addr[1];
        f.od_b_hp.value          = addr[2];
        f.od_b_zip.value         = addr[3] + addr[4];
        f.od_b_addr1.value       = addr[5];
        f.od_b_addr2.value       = addr[6];
        f.od_b_addr3.value       = addr[7];
        f.od_b_addr_jibeon.value = addr[8];
        f.ad_subject.value       = addr[9];

        var zip1 = addr[3].replace(/[^0-9]/g, "");
        var zip2 = addr[4].replace(/[^0-9]/g, "");

        if(zip1 != "" && zip2 != "") {
            var code = String(zip1) + String(zip2);

            if(window.opener.zipcode != code) {
                window.opener.zipcode = code;
                window.opener.calculate_sendcost(code);
            }
        }

        window.close();
    });

    $(".del_address").on("click", function() {
        return confirm("배송지 목록을 삭제하시겠습니까?");
    });

    // 전체선택 부분
    $("#chk_all").on("click", function() {
        if($(this).is(":checked")) {
            $("input[name^='chk[']").attr("checked", true);
        } else {
            $("input[name^='chk[']").attr("checked", false);
        }
    });

    $(".btn_submit").on("click", function() {
        if($("input[name^='chk[']:checked").length==0 ){
            alert("수정하실 항목을 하나 이상 선택하세요.");
            return false;
        }
    });

});
</script>

<?php
//include_once(G5_PATH.'/tail.sub.php');
$bottomTabMenu_skip = true;
$footer_skip = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
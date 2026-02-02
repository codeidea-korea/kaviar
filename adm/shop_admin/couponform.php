<?php
$sub_menu = '400800';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

$cp_id = isset($_REQUEST['cp_id']) ? clean_xss_tags($_REQUEST['cp_id'], 1, 1) : '';
$cp = array(
'cp_method'=>'',
'cp_subject'=>'',
'cp_target'=>'',
'mb_id'=>'',
'cp_type'=>'',
'cp_price'=>'',
'cp_trunc'=>'',
'cp_minimum'=>'',
'cp_maximum'=>'',
);

$g5['title'] = '쿠폰관리';

if ($w == 'u') {
    $html_title = '쿠폰 수정';

    $sql = " select * from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
    $cp = sql_fetch($sql);
    if (!$cp['cp_id']) alert('등록된 자료가 없습니다.');
}
else
{
    $html_title = '쿠폰 입력';
    $cp['cp_start'] = G5_TIME_YMD;
    $cp['cp_end'] = date('Y-m-d', (G5_SERVER_TIME + 86400 * 7));
}

if($cp['cp_method'] == 1) {
    $cp_target_label = '적용분류';
    $cp_target_btn = '분류검색';
} else {
    $cp_target_label = '적용상품';
    $cp_target_btn = '상품검색';
}

include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>

<form name="fcouponform" method="post" action="./couponformupdate.php" onsubmit="return form_check(this);" enctype="MULTIPART/FORM-DATA" autocomplete="off">
<input type="hidden" name="w" id="w" value="<?php echo $w; ?>">
<input type="hidden" name="cp_id" value="<?php echo $cp_id; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page;?>">
<input type="hidden" name="cp_ctype" id="cp_ctype" value="<?php echo $cp['cp_ctype'];?>">

<div class="tbl_frm01 tbl_wrap">
	<div>
		
	</div>
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row"><label for="cp_subject">쿠폰이름</label></th>
        <td>
            <input type="text" name="cp_subject" value="<?php echo get_sanitize_input($cp['cp_subject']); ?>" id="cp_subject" required class="required frm_input" size="50">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_method">쿠폰종류</label></th>
        <td>
           <?php echo help("쿠폰 종류를 변경하시면 입력 서식도 일부 변경됩니다."); ?>
           <select name="cp_method" id="cp_method">
                <option value="0"<?php echo get_selected('0', $cp['cp_method']); ?>>개별상품할인</option>
                <option value="1"<?php echo get_selected('1', $cp['cp_method']); ?>>카테고리할인</option>
                <option value="2"<?php echo get_selected('2', $cp['cp_method']); ?>>주문금액할인</option>
                <option value="3"<?php echo get_selected('3', $cp['cp_method']); ?>>배송비할인</option>
           </select>
        </td>
    </tr>
    <tr id="tr_cp_target">
        <th scope="row"><label for="cp_target"><?php echo $cp_target_label; ?></label></th>
        <td>
           <input type="text" name="cp_target" value="<?php echo stripslashes($cp['cp_target']); ?>" id="cp_target" required class="required frm_input">
           <button type="button" id="sch_target" class="btn_frmline"><?php echo $cp_target_btn; ?></button>
        </td>
    </tr>
	<tr id="tr_cp_target">
        <th scope="row">쿠폰 발급 타입</th>
        <td>
			<select id="ctype" name="ctype" onchange="select_coupon(this.value)">
				<option value="1">회원선택 발급</option>
				<option value="2">회원 엑셀 업로드 발급</option>
			</select>
        </td>
    </tr>
    <tr id="total1">
        <th scope="row"><label for="mb_id">회원아이디</label></th>
        <td>
            <input type="text" name="mb_id" value="<?php echo stripslashes($cp['mb_id']); ?>" id="mb_id" class="frm_input" style="width:40%">
            <button type="button" id="sch_member" class="btn_frmline">회원검색</button>
            <input type="checkbox" name="chk_all_mb" id="chk_all_mb" value="1" onclick="toggleCheckboxes(this)">
            <label for="chk_all_mb">전체회원</label>
		
			&nbsp&nbsp/&nbsp&nbsp
			<input type="checkbox" name="all_mb2" id="all_mb2" class="member-checkbox" value="2" onclick="toggleMainCheckbox(this)">
            <label for="all_mb2">캐비아</label>
			<input type="checkbox" name="all_mb3" id="all_mb3" class="member-checkbox" value="3" onclick="toggleMainCheckbox(this)">
            <label for="all_mb3">실버</label>
			<input type="checkbox" name="all_mb4" id="all_mb4" class="member-checkbox" value="4" onclick="toggleMainCheckbox(this)">
            <label for="all_mb4">골드</label>
			<input type="checkbox" name="all_mb5" id="all_mb5" class="member-checkbox" value="5" onclick="toggleMainCheckbox(this)">
            <label for="all_mb5">프리미엄</label>
			<input type="checkbox" name="all_mb6" id="all_mb6" class="member-checkbox" value="6" onclick="toggleMainCheckbox(this)">
            <label for="all_mb6">임직원</label>
			<input type="checkbox" name="all_mb7" id="all_mb7" class="member-checkbox" value="7" onclick="toggleMainCheckbox(this)">
            <label for="all_mb7">큐커플랜</label>
			<input type="checkbox" name="all_mb8" id="all_mb8" class="member-checkbox" value="8" onclick="toggleMainCheckbox(this)">
            <label for="all_mb8">QVIP</label>
        </td>
    </tr>

	<tr id="total2">
        <th scope="row"><label for="mb_mcoupon">회원리스트</label></th>
        <td colspan="3">            
            <?php
            $mb_dir = "coupone";
            $imb_img_file = G5_DATA_PATH.'/file/'.$mb_dir.'/'.get_mb_icon_name($mb['mb_id']).'.gif';
			$upImg = file_exists($imb_img_file) ? get_member_profile_img($mb['mb_id']).'<label><input type="checkbox" name="del_mb_img" value="1">삭제</label>' : '';
			echo '<input type="file" name="mb_mcoupon" id="mb_mcoupon" class="myfile">';
            ?>
			<a href="./coupon_member.xls" download="coupon_member.xls">양식다운로드</a>
        </td>
    </tr>
<!--
	<tr id="total3">
        <th scope="row"><label for="mb_mcoupon">회원리스트</label></th>
        <td colspan="3">            
           <input type="text" name="mb_id" value="<?php echo stripslashes($cp['mb_id']); ?>" id="mb_id" class="frm_input" style="width:100%">
        </td>
    </tr>
-->
<script>

	 function toggleCheckboxes(mainCheckbox) {
            const checkboxes = document.querySelectorAll('input[type="checkbox"].member-checkbox');
            if (mainCheckbox.checked) {
                checkboxes.forEach(checkbox => checkbox.checked = false);
            }
        }

        function toggleMainCheckbox(memberCheckbox) {
            const mainCheckbox = document.getElementById('chk_all_mb');
            if (mainCheckbox.checked) {
                mainCheckbox.checked = false;
            }
        }

</script>
    <tr>
        <th scope="row"><label for="cp_start">사용시작일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="cp_start" value="<?php echo stripslashes($cp['cp_start']); ?>" id="cp_start" required class="frm_input required">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_end">사용종료일</label></th>
        <td>
            <?php echo help('입력 예: '.date('Y-m-d')); ?>
            <input type="text" name="cp_end" value="<?php echo stripslashes($cp['cp_end']); ?>" id="cp_end" required class="frm_input required">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_type">쿠폰타입</label></th>
        <td>
           <?php echo help("쿠폰 타입을 변경하시면 입력 서식도 일부 변경됩니다."); ?>
           <select name="cp_type" id="cp_type">
                <option value="0"<?php echo get_selected('0', $cp['cp_type']); ?>>정액할인(원)</option>
                <option value="1"<?php echo get_selected('1', $cp['cp_type']); ?>>정률할인(%)</option>
           </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_price"><?php echo $cp['cp_type'] ? '할인비율' : '할인금액'; ?></label></th>
        <td>
            <input type="text" name="cp_price" value="<?php echo stripslashes($cp['cp_price']); ?>" id="cp_price" required class="frm_input required"> <span id="cp_price_unit"><?php echo $cp['cp_type'] ? '%' : '원'; ?></span>
        </td>
    </tr>
    <tr id="tr_cp_trunc">
        <th scope="row"><label for="cp_trunc">절사금액</label></th>
        <td>
            <select name="cp_trunc" id="cp_trunc">
            <option value="1"<?php echo get_selected('1', $cp['cp_trunc']); ?>>1원단위</option>
            <option value="10"<?php echo get_selected('10', $cp['cp_trunc']); ?>>10원단위</option>
            <option value="100"<?php echo get_selected('100', $cp['cp_trunc']); ?>>100원단위</option>
            <option value="1000"<?php echo get_selected('1000', $cp['cp_trunc']); ?>>1,000원단위</option>
           </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="cp_minimum">최소주문금액</label></th>
        <td>
            <input type="text" name="cp_minimum" value="<?php echo stripslashes($cp['cp_minimum']); ?>" id="cp_minimum" class="frm_input"> 원
        </td>
    </tr>
    <tr id="tr_cp_maximum">
        <th scope="row"><label for="cp_maximum">최대할인금액</label></th>
        <td>
            <input type="text" name="cp_maximum" value="<?php echo stripslashes($cp['cp_maximum']); ?>" id="cp_maximum" class="frm_input"> 원
        </td>
    </tr>
    <?php if($w == '') { ?>
	
	
	<!--
    <tr>
        <th scope="row">쿠폰발행알림</th>
        <td>
            <label for="cp_sms_send">SMS발송</label>
            <input type="checkbox" name="cp_sms_send" value="1" id="cp_sms_send" checked>
            <label for="cp_email_send">이메일발송</label>
            <input type="checkbox" name="cp_email_send" value="1" id="cp_email_send"  checked>
        </td>
    </tr>
	-->
    <?php } ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./couponlist.php" class="btn btn_02">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
$(function() {
    <?php if($cp['cp_method'] == 2 || $cp['cp_method'] == 3) { ?>
    $("#tr_cp_target").hide();
    $("#tr_cp_target").find("input").attr("required", false).removeClass("required");
    <?php } ?>
    <?php if($cp['cp_type'] != 1) { ?>
    $("#tr_cp_maximum").hide();
    $("#tr_cp_trunc").hide();
    <?php } ?>
    $("#cp_method").change(function() {
        var cp_method = $(this).val();
        change_method(cp_method);
    });

    $("#cp_type").change(function() {
        var cp_type = $(this).val();
        change_type(cp_type);
    });

    $("#sch_target").click(function() {
        var cp_method = $("#cp_method").val();
        var opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var url = "./coupontarget.php?sch_target=";

        if(cp_method == "0") {
            window.open(url+"0", "win_target", opt);
        } else if(cp_method == "1") {
            window.open(url+"1", "win_target", opt);
        } else {
            return false;
        }
    });

    $("#sch_member").click(function() {
        if($("#chk_all_mb").is(":checked")) {
            alert("전체회원 체크를 해제 후 이용해 주십시오.");
            return false;
        }

        var opt = "left=50,top=50,width=520,height=600,scrollbars=1";
        var url = "./couponmember.php";
        window.open(url, "win_member", opt);
    });

    $("#cp_start, #cp_end").datepicker(
        { changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99" }
    );
});

function change_method(cp_method)
{
    if(cp_method == "0") {
        $("#sch_target").text("상품검색");
        $("#tr_cp_target").find("label").text("적용상품");
        $("#tr_cp_target").find("input").attr("required", true).addClass("required");
        $("#tr_cp_target").show();
    } else if(cp_method == "1") {
        $("#sch_target").text("분류검색");
        $("#tr_cp_target").find("label").text("적용분류");
        $("#tr_cp_target").find("input").attr("required", true).addClass("required");
        $("#tr_cp_target").show();
    } else {
        $("#tr_cp_target").hide();
        $("#tr_cp_target").find("input").attr("required", false).removeClass("required");
    }
}

function change_type(cp_type)
{
    if(cp_type == "0") {
        $("#cp_price_unit").text("원");
        $("#cp_price_unit").closest("tr").find("label").text("할인금액");
        $("#tr_cp_maximum").hide();
        $("#tr_cp_trunc").hide();
    } else {
        $("#cp_price_unit").text("%");
        $("#cp_price_unit").closest("tr").find("label").text("할인비율");
        $("#tr_cp_maximum").show();
        $("#tr_cp_trunc").show();
    }
}

function form_check(f)
{
    var sel_type = f.cp_type;
    var cp_type = sel_type.options[sel_type.selectedIndex].value;
    var cp_price = f.cp_price.value;
    var ctype = f.ctype.value;
	var mcoupon = f.mb_mcoupon.value;
	var cp_ctype = f.cp_ctype.value;
	
	if(ctype == 1){
			 if(!f.chk_all_mb.checked && !f.all_mb2.checked &&  !f.all_mb3.checked && !f.all_mb4.checked &&  !f.all_mb5.checked  && !f.all_mb6.checked && !f.all_mb7.checked &&  !f.all_mb8.checked && f.mb_id.value == "") {
			alert("회원아이디를 입력해 주십시오.");
			return false;
		}
	}else if(ctype == 2){
		if(!mcoupon) {
			if(cp_ctype != 2){
				alert("엑셀을 등록해주세요.");
				return false;
			}
		}
	}
   

    if(isNaN(cp_price)) {
        if(cp_type == "1")
            alert("할인비율을 숫자로 입력해 주십시오.");
        else
            alert("할인금액을 숫자로 입력해 주십시오.");

        return false;
    }

    cp_price = parseInt(cp_price);

    if(cp_type == "1" && (cp_price < 1 || cp_price > 101)) {
        alert("할인비율을 1과 100 사이의 숫자로 입력해 주십시오.");
        return false;
    }

    // 전체회원일 때 쿠폰알림 체크되어 있으면 확인창
    if(f.chk_all_mb.checked && (f.cp_sms_send.checked || f.cp_email_send.checked)) {
        if(!confirm("전체회원에게 쿠폰발행알림을 발송하시겠습니까?"))
            return false;
    }

    return true;
}
</script>


<script>

if($("#w").val() == 'u' && $("#cp_ctype").val() == 2){
	$("#total1").hide();
	$("#total2").hide();
	$("#total3").show();
	$("#ctype option:eq(1)").prop("selected", true);
}else if($("#w").val() == 'u' && $("#cp_ctype").val() == 1){

	$("#total1").show();
	$("#total2").hide();
	$("#total3").hide();

}else{

	$("#total1").show();
	$("#total2").hide();
	$("#total3").hide();
}
function select_coupon(vals) {

	if(vals == 1){
		$("#total1").show();
		$("#total2").hide();
		$("#total3").hide();
	}else{
		$("#total1").hide();
		$("#total2").show();
		$("#total3").hide();
	}
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
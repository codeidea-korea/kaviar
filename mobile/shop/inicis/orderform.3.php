<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가;
?>

<div id="display_pay_button" class="btn_confirm">
    <input type="button" name="submitChecked" onClick="pay_approval();" value="결제하기" class="btn_submit" id="show_req_btn">
    <input type="button" onClick="forderform_check();" value="주문하기" class="btn_submit" style="display:none;" id="show_pay_btn">
    <!-- a href="<?php echo G5_SHOP_URL; ?>" class="btn01">취소</a //-->
    <a href="javascript:history.go(-1);" class="btn01">취소</a>
</div>

<div id="show_progress" style="display:none">
    <img src="<?php echo G5_URL; ?>/shop/img/loading.gif" alt="">
    <span>주문완료 중입니다. 잠시만 기다려 주십시오.</span>
</div>
<?php
$sub_menu = "900801";
include_once("./_common.php");

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = "APP PUSH 설정";

$app_confing = sql_fetch(" select * from `g5_config_apppush` ");
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>


<form name="fconfig" method="post" action="./config_app_update.php" enctype="multipart/form-data" >

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>

    <tr>
        <th scope="row"><label for="app_push1">상품발송</label></th>
        <td>
            <input type="text" name="app_push1" value="<?php echo isset($app_confing['app_push1']) ? get_sanitize_input($app_confing['app_push1']) : ''; ?>" id="app_push1" required class="frm_input required" size="140">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="app_push2">상품문의 답변등록</label></th>
        <td>
            <input type="text" name="app_push2" value="<?php echo isset($app_confing['app_push2']) ? get_sanitize_input($app_confing['app_push2']) : ''; ?>" id="app_push2" required class="frm_input required" size="140">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="app_push3">상품후기 등록승인</label></th>
        <td>
            <input type="text" name="app_push3" value="<?php echo isset($app_confing['app_push3']) ? get_sanitize_input($app_confing['app_push3']) : ''; ?>" id="app_push3" required class="frm_input required" size="140">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="app_push4">후기 등록 유도</label></th>
        <td>
            <input type="text" name="app_push4" value="<?php echo isset($app_confing['app_push4']) ? get_sanitize_input($app_confing['app_push4']) : ''; ?>" id="app_push4" required class="frm_input required" size="140">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="app_push5">장바구니 구매 유도</label></th>
        <td>
            <input type="text" name="app_push5" value="<?php echo isset($app_confing['app_push5']) ? get_sanitize_input($app_confing['app_push5']) : ''; ?>" id="app_push5" required class="frm_input required" size="140">
        </td>
    </tr>

	<tr>
        <th scope="row"><label for="app_push6">재구매 유도</label></th>
        <td>
            <input type="text" name="app_push6" value="<?php echo isset($app_confing['app_push6']) ? get_sanitize_input($app_confing['app_push6']) : ''; ?>" id="app_push6" required class="frm_input required" size="140">
        </td>
    </tr>


    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>
</form>



<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
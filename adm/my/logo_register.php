<?php
$sub_menu = "110300";
include_once('./_common.php');

auth_check($auth[$sub_menu], "r");

$g5['title'] = '로고 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

if(file_exists(G5_THEME_PATH.'/adm/_logo_register.php')) {
	require_once(G5_THEME_PATH.'/adm/_logo_register.php');
    return;
}
?>

<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);" autocomplete="off" action="./logo_register_update.php" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
	<h2 class="mybox-title">사이트 로고 등록 및 관리</h2>
    <div class="formContainer label200">

		<div class="form-group">
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_c.png">상단 로고 (컬러)</label></div>
				<div class="formCon">
					<?php
					$logo_c_path = G5_DATA_PATH.'/logo/logo_c.png';
					$logo_c_url = G5_DATA_URL.'/logo/logo_c.png';
					$upImg_logo_c = file_exists($logo_c_path) ? '<img src="'.get_url($logo_c_url).'"><label><input type="checkbox" name="del_logo_c" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_c" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_c.'</div>';
					?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_w.png">상단 로고 (흰색)</label></div>
				<div class="formCon" style="background:rgba(0,0,0,0.1);">
					<?php
					$logo_w_path = G5_DATA_PATH.'/logo/logo_w.png';
					$logo_w_url = G5_DATA_URL.'/logo/logo_w.png';
					$upImg_logo_w = file_exists($logo_w_path) ? '<img src="'.get_url($logo_w_url).'"><label><input type="checkbox" name="del_logo_w" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_w" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_w.'</div>';
					?>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_mobile_c.png">모바일 로고 등록</label></div>
				<div class="formCon">
					<?php
					$logo_mobile_c_path = G5_DATA_PATH.'/logo/logo_mobile_c.png';
					$logo_mobile_c_url = G5_DATA_URL.'/logo/logo_mobile_c.png';
					$upImg_logo_mobile_c = file_exists($logo_mobile_c_path) ? '<img src="'.get_url($logo_mobile_c_url).'"><label><input type="checkbox" name="del_logo_mobile_c" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_mobile_c" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_mobile_c.'</div>';
					?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_mobile_w.png">모바일 로고 등록(흰색)</label></div>
				<div class="formCon" style="background:rgba(0,0,0,0.1);">
					<?php
					$logo_mobile_w_path = G5_DATA_PATH.'/logo/logo_mobile_w.png';
					$logo_mobile_w_url = G5_DATA_URL.'/logo/logo_mobile_w.png';
					$upImg_logo_mobile_w = file_exists($logo_mobile_w_path) ? '<img src="'.get_url($logo_mobile_w_url).'"><label><input type="checkbox" name="del_logo_mobile_w" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_mobile_w" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_mobile_w.'</div>';
					?>
				</div>
			</div>
		</div>
		
		<div class="form-group">
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/favorite.ico">북마크 아이콘(pc)</label></div>
				<div class="formCon">
					<p class="help-block mb5">ico 확장자 또는 png 확장자가 업로드 가능합니다. <span class="color-red">(권장사이즈 : 48x48)</span></p>
					<?php
					$favorite_path = G5_DATA_PATH.'/logo/favorite.ico';
					$favorite_url = G5_DATA_URL.'/logo/favorite.ico';
					$upImg_favorite = file_exists($favorite_path) ? '<img src="'.get_url($favorite_url).'"><label><input type="checkbox" name="del_favorite" value="1">삭제</label>' : '';
					echo '<input type="file" name="favorite" class="myfile">';
					echo '<div class="upImg">'.$upImg_favorite.'</div>';
					?>
				</div>
			</div>
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/favorite_mobile.png">모바일 앱이미지</label></div>
				<div class="formCon">
					<?php
					$favorite_mobile_path = G5_DATA_PATH.'/logo/favorite_mobile.png';
					$favorite_mobile_url = G5_DATA_URL.'/logo/favorite_mobile.png';
					$upImg_favorite_mobile = file_exists($favorite_mobile_path) ? '<img src="'.get_url($favorite_mobile_url).'"><label><input type="checkbox" name="del_favorite_mobile" value="1">삭제</label>' : '';
					echo '<input type="file" name="favorite_mobile" class="myfile">';
					echo '<div class="upImg">'.$upImg_favorite_mobile.'</div>';
					?>
				</div>
			</div>
		</div>

    </div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f) {
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>
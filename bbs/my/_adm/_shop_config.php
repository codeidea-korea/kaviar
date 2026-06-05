<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$de_listtype_card_width = isset($default['de_listtype_card_width']) ? (int)$default['de_listtype_card_width'] : 0;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_config_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label160">
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 제목</label></div>
			<div class="formCon">
				<input type="text" name="cf_title" value="<?php echo get_sanitize_input($config['cf_title']); ?>" id="cf_title" required class="required frm_input" size="40">
			</div>
		</div>		
		<div class="form-list">
			<div class="form-label"><label>신제품 카드 최대폭</label></div>
			<div class="formCon">
				<input type="text" name="de_listtype_card_width" value="<?php echo $de_listtype_card_width; ?>" id="de_listtype_card_width" class="frm_input" size="5"> px
				<p class="help-block mt5">신제품(/shop/listtype.php?type=1) 페이지에만 적용됩니다. 0 또는 빈 값이면 기존처럼 1줄 4개 슬롯을 꽉 채웁니다.</p>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 로고</label></div>
			<div class="formCon">
				<?php
				$shop_logo_c_path = G5_DATA_PATH.'/logo/shop_logo_c.png';
				$shop_logo_c_url = G5_DATA_URL.'/logo/shop_logo_c.png';
				$upImg_shop_logo_c = file_exists($shop_logo_c_path) ? '<img src="'.get_url($shop_logo_c_url).'"><label><input type="checkbox" name="del_shop_logo_c" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_logo_c" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_logo_c.'</div>';
				?>
			</div>
		</div>
		<div class="form-group">
			<div class="form-list">
				<div class="form-label"><label>쇼핑몰 로고(흰색)</label></div>
				<div class="formCon">
					<?php
					$shop_logo_w_path = G5_DATA_PATH.'/logo/shop_logo_w.png';
					$shop_logo_w_url = G5_DATA_URL.'/logo/shop_logo_w.png';
					$upImg_shop_logo_w = file_exists($shop_logo_w_path) ? '<img src="'.get_url($shop_logo_w_url).'"><label><input type="checkbox" name="del_shop_logo_w" value="1">삭제</label>' : '';
					echo '<input type="file" name="shop_logo_w" class="myfile">';
					echo '<div class="upImg">'.$upImg_shop_logo_w.'</div>';
					?>
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 대표이미지</label></div>
			<div class="formCon">
				<?php
				$shopmain_img_path = G5_DATA_PATH.'/file/shop_main.png';
				$shopmain_img_url = G5_DATA_URL.'/file/shop_main.png';
				$upImg_shopmain_img = file_exists($shopmain_img_path) ? '<img src="'.get_url($shopmain_img_url).'"><label class="del_file"><input type="checkbox" name="del_sitemain_img" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_main" class="myfile">';
				echo '<div class="upImg">'.$upImg_shopmain_img.'</div>';
				if(file_exists($shopmain_img_path)) {
					echo '<p class="help-block mt10">카카오링크 이미지 적용이 안될때 <a href="https://developers.kakao.com/tool/clear/og" class="ml20 btn_frmline">카카오톡 캐쉬삭제</a></p>';
				} ?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 북마크 아이콘</label></div>
			<div class="formCon">
				<p class="help-block mb5">ico 확장자 또는 png 확장자가 업로드 가능합니다. <span class="color-red">(권장사이즈 : 48x48)</span></p>
				<?php
				$shop_favorite_path = G5_DATA_PATH.'/logo/shop_favorite.ico';
				$shop_favorite_url = G5_DATA_URL.'/logo/shop_favorite.ico';
				$upImg_shop_favorite = file_exists($shop_favorite_path) ? '<img src="'.get_url($shop_favorite_url).'"><label><input type="checkbox" name="del_shop_favorite" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_favorite" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_favorite.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 모바일 앱이미지</label></div>
			<div class="formCon">
				<?php
				$shop_favorite_mobile_path = G5_DATA_PATH.'/logo/shop_favorite_mobile.png';
				$shop_favorite_mobile_url = G5_DATA_URL.'/logo/shop_favorite_mobile.png';
				$upImg_shop_favorite_mobile = file_exists($shop_favorite_mobile_path) ? '<img src="'.get_url($shop_favorite_mobile_url).'"><label><input type="checkbox" name="del_shop_favorite_mobile" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_favorite_mobile" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_favorite_mobile.'</div>';
				?>
			</div>
		</div>
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>

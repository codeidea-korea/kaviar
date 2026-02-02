<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//$cf_search_keyword = explode(",",$config['cf_search_keyword']);
//사이트 추천 검색어 추가
if(!isset($config['cf_search_keyword'])) {
    sql_query(" ALTER TABLE `{$g5['config_table']}`
                    ADD `cf_search_keyword` VARCHAR(255) NOT NULL
					", true);
}
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_adm_config_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label160">
		<div class="form-list">
			<div class="form-label"><label>홈페이지 제목</label></div>
			<div class="formCon">
				<input type="text" name="cf_title" value="<?php echo get_sanitize_input($config['cf_title']); ?>" id="cf_title" required class="required frm_input" size="40">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label">로그인 사용</label></div>
            <div class="formCon flex flex-middle gap25">
				<select id="cf_use_login" name="cf_use_login" class="selectpicker">
					<option value="0" <?=get_selected($config['cf_use_login'], '0')?>>사용안함</option>
					<option value="1" <?=get_selected($config['cf_use_login'], '1')?>>pc, 모바일 둘다 사용</option>
					<option value="2" <?=get_selected($config['cf_use_login'], '2')?>>pc만 사용</option>
					<option value="3" <?=get_selected($config['cf_use_login'], '3')?>>모바일만 사용</option>
				</select>
				<input type="checkbox" name="cf_use_join" value="1" id="cf_use_join" class="" <?=$config['cf_use_join']?'checked':''?> data-label="회원가입 사용">
            </div>
        </div>
		<div class="form-list">
			<div class="form-label"><label>사이트 대표이미지</label></div>
			<div class="formCon">
				<?php
				$sitemain_img_path = G5_DATA_PATH.'/file/site_main.png';
				$sitemain_img_url = G5_DATA_URL.'/file/site_main.png';
				$upImg_sitemain_img = file_exists($sitemain_img_path) ? '<img src="'.get_url($sitemain_img_url).'"><label class="del_file"><input type="checkbox" name="del_sitemain_img" value="1">삭제</label>' : '';
				echo '<input type="file" name="site_main" class="myfile">';
				echo '<div class="upImg">'.$upImg_sitemain_img.'</div>';
				if(file_exists($sitemain_img_path)) {
					//echo '<p class="help-block mt10">카카오링크 이미지 적용이 안될때 <a href="https://developers.kakao.com/tool/clear/og" class="ml20 btn_frmline">카카오톡 캐쉬삭제</a></p>';
				} ?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>사이트 추천 검색어</label></div>
			<div class="formCon">
				<input type="text" name="cf_search_keyword" value="<?=$config['cf_search_keyword']?>" class="span" size="255" placeholder="예시) 공지사항, 갤러리">
			</div>
		</div>
		<div class="form-group">
			<?php if(G5_IS_MOBILE) { ?>
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
			<?php } ?>
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
		</div>
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>

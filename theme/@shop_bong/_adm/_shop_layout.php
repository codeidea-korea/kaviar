<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>


<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_layout_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label190">
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰(pc)<br>기본 레이아웃</label></div>
			<div class="formCon">
				<select name="shop_layout" value="<?=$default['shop_layout']?>" id="shop_layout" class="selectpicker select-img n2 w-170">
					<?php
					echo option_selected_my("outside-right", $default['shop_layout'], "outside-right", "data-content=\"<img src='".get_url($_adm_url."/img/shop/shop_layout_right.png")."'>\"");
					echo option_selected_my("outside-left", $default['shop_layout'], "outside-left", "data-content=\"<img src='".get_url($_adm_url."/img/shop/shop_layout_left.png")."'>\"");
					?>
				</select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 슬로건</label></div>
			<div class="formCon">
				<input type="text" name="shop_slogan" value="<?=$default['shop_slogan']?>" class="w-full" size="255" placeholder="">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 추천 검색어</label></div>
			<div class="formCon flex gap10">
				<input type="text" name="cf_search_keyword" value="<?=$config['cf_search_keyword']?>" class="w-full" size="255" placeholder="예시) 공지사항, 갤러리"<?=$config['cf_use_search_keyword']?'':' style="color:rgba(0,0,0,0.4);background:rgba(0,0,0,0.02);"'?>>
				<div style="--toggle-light-width:78px;--toggle-light-height:24px;--toggle-light-font-size:11px;">
					<input type="checkbox" name="cf_use_search_keyword" value="1" class="toggle-light"<?=$config['cf_use_search_keyword']?' checked':''?> data-on="사용" data-off="사용안함">
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>배경 이미지</label></div>
			<div class="formCon">
				<?php
				$shopmain_bg_path = G5_DATA_PATH.'/shop/shop_main_bg.png';
				$shopmain_bg_url = G5_DATA_URL.'/shop/shop_main_bg.png';
				$upImg_shopmain_bg = file_exists($shopmain_bg_path) ? '<img src="'.get_url($shopmain_bg_url).'"><label class="del_file"><input type="checkbox" name="del_sitemain_bg" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_main_bg" class="myfile">';
				echo '<div class="upImg">'.$upImg_shopmain_bg.'</div>';
				?>
			</div>
		</div>
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>
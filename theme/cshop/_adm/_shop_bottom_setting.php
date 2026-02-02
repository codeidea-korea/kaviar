<?php
if (!defined('_GNUBOARD_')) exit;

$shop_bottom_color = explode("|", $default['shop_bottom_color']);
$shop_bottom_tabs_name = explode("|", $default['shop_bottom_tabs_name']);
?>

<style>
.upImg img{max-width:22px;max-height:22px;}
</style>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_bottom_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label160">
		<div class="form-list">
			<div class="form-label"><label>스크롤시 숨김처리</label></div>
			<div class="formCon" style="--toggle-light-width:90px;--toggle-light-height:26px;">
				<input type="checkbox"name="shop_bottom_tabs_scrollhidden" value="1" class="toggle-light" <?=$default['shop_bottom_tabs_scrollhidden']?'checked':'';?> data-on="숨김사용" data-off="사용안함">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>하단 컬러</label></div>
			<div class="formCon flex flex-middle gap20">
				<input type="text" name="shop_bottom_color[0]" value="<?=$shop_bottom_color[0]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="배경 컬러">
				<input type="text" name="shop_bottom_color[1]" value="<?=$shop_bottom_color[1]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="아이콘+폰트 컬러">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>텝메뉴명</label></div>
			<div class="formCon column flex-top">
				<input type="text" name="shop_bottom_tabs_name[0]" value="<?=$shop_bottom_tabs_name[0]?>" class="w-200" placeholder="홈" data-label="메뉴명" data-class="ic_home">
				<input type="text" name="shop_bottom_tabs_name[1]" value="<?=$shop_bottom_tabs_name[1]?>" class="w-200" placeholder="카테고리" data-label="메뉴명" data-class="ic_gnb">
				<input type="text" name="shop_bottom_tabs_name[2]" value="<?=$shop_bottom_tabs_name[2]?>" class="w-200" placeholder="검색" data-label="메뉴명" data-class="ic_search">
				<input type="text" name="shop_bottom_tabs_name[3]" value="<?=$shop_bottom_tabs_name[3]?>" class="w-200" placeholder="로그인/마이페이지" data-label="메뉴명" data-class="ic_my">
				<p class="help-block">* 로그인 전,후의 메뉴명이 다른경우 (/)로 구분해서 입력해 주세요.</p>
			</div>
		</div>
	</div>	
</section>

<section class="mybox blue">
	<div class="mybox-title fw600">아이콘 교체 <span class="fs12 color-red">(svg 파일만 업로드 가능합니다.)</span></div>
	<div class="formContainer label100" style="--toggle-light-width:36px;	--toggle-light-height:18px;--toggle-light-font-size:10px;">
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_home"></span></div>
			<div class="formCon flex flex-middle">
				<?php
				$shop_bottom_home_path = G5_DATA_PATH.'/shop_icon/shop_bottom_home.svg';
				$shop_bottom_home_url = G5_DATA_URL.'/shop_icon/shop_bottom_home.svg';
				$upImg_shop_bottom_home = file_exists($shop_bottom_home_path) ? '<img src="'.get_url($shop_bottom_home_url).'"><label><input type="checkbox" name="del_shop_bottom_home" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_home" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_home.'</div>';
				?>
				<input type="checkbox" name="shop_bottom_use_home" value="1" class="toggle-light"<?=$default['shop_bottom_use_home']?' checked':''?>>
			</div>			
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_gnb"></span></div>
			<div class="formCon flex flex-middle">
				<?php
				$shop_bottom_gnb_path = G5_DATA_PATH.'/shop_icon/shop_bottom_gnb.svg';
				$shop_bottom_gnb_url = G5_DATA_URL.'/shop_icon/shop_bottom_gnb.svg';
				$upImg_shop_bottom_gnb = file_exists($shop_bottom_gnb_path) ? '<img src="'.get_url($shop_bottom_gnb_url).'"><label><input type="checkbox" name="del_shop_bottom_gnb" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_gnb" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_gnb.'</div>';
				?>
				<input type="checkbox" name="shop_bottom_use_gnb" value="1" class="toggle-light"<?=$default['shop_bottom_use_gnb']?' checked':''?>>
			</div>			
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_search"></span></div>
			<div class="formCon flex flex-middle">
				<?php
				$shop_bottom_search_path = G5_DATA_PATH.'/shop_icon/shop_bottom_search.svg';
				$shop_bottom_search_url = G5_DATA_URL.'/shop_icon/shop_bottom_search.svg';
				$upImg_shop_bottom_search = file_exists($shop_bottom_search_path) ? '<img src="'.get_url($shop_bottom_search_url).'"><label><input type="checkbox" name="del_shop_bottom_search" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_search" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_search.'</div>';
				?>
				<input type="checkbox" name="shop_bottom_use_search" value="1" class="toggle-light"<?=$default['shop_bottom_use_search']?' checked':''?>>
			</div>			
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_store"></span></div>
			<div class="formCon flex flex-middle">
				<?php
				$shop_bottom_store_path = G5_DATA_PATH.'/shop_icon/shop_bottom_store.svg';
				$shop_bottom_store_url = G5_DATA_URL.'/shop_icon/shop_bottom_store.svg';
				$upImg_shop_bottom_store = file_exists($shop_bottom_store_path) ? '<img src="'.get_url($shop_bottom_store_url).'"><label><input type="checkbox" name="del_shop_bottom_store" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_store" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_store.'</div>';
				?>
				<input type="checkbox" name="shop_bottom_use_store" value="1" class="toggle-light"<?=$default['shop_bottom_use_store']?' checked':''?>>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_my"></span></div>
			<div class="formCon flex flex-middle">
				<?php
				$shop_bottom_member_path = G5_DATA_PATH.'/shop_icon/shop_bottom_member.svg';
				$shop_bottom_member_url = G5_DATA_URL.'/shop_icon/shop_bottom_member.svg';
				$upImg_shop_bottom_member = file_exists($shop_bottom_member_path) ? '<img src="'.get_url($shop_bottom_member_url).'"><label><input type="checkbox" name="del_shop_bottom_member" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_member" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_member.'</div>';
				?>
				<input type="checkbox" name="shop_bottom_use_member" value="1" class="toggle-light"<?=$default['shop_bottom_use_member']?' checked':''?>>
			</div>
		</div>		
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>

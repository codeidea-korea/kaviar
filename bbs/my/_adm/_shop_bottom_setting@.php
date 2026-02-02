<?php
if (!defined('_GNUBOARD_')) exit;

$shop_bottom_color = explode("|", $default['shop_bottom_color']);
$shop_bottom_tabs_name = explode("|", $default['shop_bottom_tabs_name']);
?>

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
				<input type="text" name="shop_bottom_tabs_name[1]" value="<?=$shop_bottom_tabs_name[1]?>" class="w-200" placeholder="카테고리" data-label="메뉴명" data-class="ic_cate">
				<input type="text" name="shop_bottom_tabs_name[2]" value="<?=$shop_bottom_tabs_name[2]?>" class="w-200" placeholder="검색" data-label="메뉴명" data-class="ic_search">
				<input type="text" name="shop_bottom_tabs_name[3]" value="<?=$shop_bottom_tabs_name[3]?>" class="w-200" placeholder="로그인/마이페이지" data-label="메뉴명" data-class="ic_my">
				<p class="help-block">* 로그인 전,후의 메뉴명이 다른경우 (/)로 구분해서 입력해 주세요.</p>
			</div>
		</div>
	</div>	
</section>

<section class="mybox blue">
	<div class="mybox-title fw600">아이콘 교체</div>
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_home"></span></div>
			<div class="formCon">
				<?php
				$shop_bottom_tab1_path = G5_DATA_PATH.'/shop_icon/shop_bottom_tab1.png';
				$shop_bottom_tab1_url = G5_DATA_URL.'/shop_icon/shop_bottom_tab1.png';
				$upImg_shop_bottom_tab1 = file_exists($shop_bottom_tab1_path) ? '<img src="'.get_url($shop_bottom_tab1_url).'"><label><input type="checkbox" name="del_shop_bottom_tab1" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_tab1" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_tab1.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_cate"></span></div>
			<div class="formCon">
				<?php
				$shop_bottom_tab2_path = G5_DATA_PATH.'/shop_icon/shop_bottom_tab2.png';
				$shop_bottom_tab2_url = G5_DATA_URL.'/shop_icon/shop_bottom_tab2.png';
				$upImg_shop_bottom_tab2 = file_exists($shop_bottom_tab2_path) ? '<img src="'.get_url($shop_bottom_tab2_url).'"><label><input type="checkbox" name="del_shop_bottom_tab2" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_tab2" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_tab2.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_search"></span></div>
			<div class="formCon">
				<?php
				$shop_bottom_tab3_path = G5_DATA_PATH.'/shop_icon/shop_bottom_tab3.png';
				$shop_bottom_tab3_url = G5_DATA_URL.'/shop_icon/shop_bottom_tab3.png';
				$upImg_shop_bottom_tab3 = file_exists($shop_bottom_tab3_path) ? '<img src="'.get_url($shop_bottom_tab3_url).'"><label><input type="checkbox" name="del_shop_bottom_tab3" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_tab3" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_tab3.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="ic_my"></span></div>
			<div class="formCon">
				<?php
				$shop_bottom_tab4_path = G5_DATA_PATH.'/shop_icon/shop_bottom_tab4.png';
				$shop_bottom_tab4_url = G5_DATA_URL.'/shop_icon/shop_bottom_tab4.png';
				$upImg_shop_bottom_tab4 = file_exists($shop_bottom_tab4_path) ? '<img src="'.get_url($shop_bottom_tab4_url).'"><label><input type="checkbox" name="del_shop_bottom_tab4" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_bottom_tab4" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_bottom_tab4.'</div>';
				?>
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>

<?php
if (!defined('_GNUBOARD_')) exit;

$shop_header_ui = explode("|", $default['shop_header_ui']);

$shop_header_color = explode("|", $default['shop_header_color']);

//상품유형
$itemtype = explode("|", $default['itemtype']);
if(!$itemtype[0] && !$itemtype[1] && !$itemtype[2] && !$itemtype[3] && !$itemtype[4]) $itemtype = false;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_header_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label150">	
		<div class="form-list">
			<div class="form-label"><label>header UI</label></div>
			<div class="formCon flex gap15">
				<select name="shop_header_ui[0]" value="<?=$shop_header_ui[0]?>" id="shop_header_ui" class="selectpicker select-img n2 w-220">
					<?php
					echo option_selected_my("", $shop_header_ui[0], "type_left_01", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_left_01.gif")."'>\"");
					echo option_selected_my("type_left_02_search", $shop_header_ui[0], "type_left_02_search", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_left_02_search.gif")."'>\"");
					echo option_selected_my("type_left_03_gnb", $shop_header_ui[0], "type_left_03_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_left_03_gnb.gif")."'>\"");
					echo option_selected_my("type_left_04_search_gnb", $shop_header_ui[0], "type_left_04_search_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_left_04_search_gnb.gif")."'>\"");

					echo option_selected_my("type_center_01", $shop_header_ui[0], "type_center_01", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_01.gif")."'>\"");
					echo option_selected_my("type_center_02_search", $shop_header_ui[0], "type_center_02_search", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_02_search.gif")."'>\"");
					echo option_selected_my("type_center_03_gnb", $shop_header_ui[0], "type_center_03_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_03_gnb.gif")."'>\"");
					echo option_selected_my("type_center_04_gnb", $shop_header_ui[0], "type_center_04_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_04_gnb.gif")."'>\"");
					echo option_selected_my("type_center_05_gnb_search", $shop_header_ui[0], "type_center_05_gnb_search", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_05_gnb_search.gif")."'>\"");
					echo option_selected_my("type_center_06_search_gnb", $shop_header_ui[0], "type_center_06_search_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_center_06_search_gnb.gif")."'>\"");

					echo option_selected_my("type_right_01", $shop_header_ui[0], "type_right_01", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_right_01.gif")."'>\"");
					echo option_selected_my("type_right_02_search", $shop_header_ui[0], "type_right_02_search", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_right_02_search.gif")."'>\"");
					echo option_selected_my("type_right_03_gnb", $shop_header_ui[0], "type_right_03_gnb", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_right_03_gnb.gif")."'>\"");
					echo option_selected_my("type_right_04_gnb_search", $shop_header_ui[0], "type_right_04_gnb_search", "data-content=\"<img src='".get_url($_adm_inc_url."/img/type_right_04_gnb_search.gif")."'>\"");
					?>
				</select>
				<input type="checkbox" name="shop_header_ui[1]" value="1" class="" id="check_use_menu" data-label="header에 Shop메뉴 출력"<?=$shop_header_ui[1]?' checked':''?>>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>스크롤시 숨김처리</label></div>
			<div class="formCon flex gap15" style="--toggle-light-width:90px;--toggle-light-height:26px;">
				<select name="shop_header_scrollhidden" value="<?=$default['shop_header_scrollhidden']?>" id="shop_header_scrollhidden" class="selectpicker">
					<?php
					echo option_selected("",  $default['shop_header_scrollhidden'], "사용안함");
					echo option_selected("1", $default['shop_header_scrollhidden'], "숨김처리");						
					echo option_selected("2", $default['shop_header_scrollhidden'], "숨김처리 (메뉴고정)");
					?>
				</select>
			</div>
		</div>
	</div>
</section>

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label100">			
		<div class="form-list">
			<div class="form-label"><label>Shop 로고</label></div>
			<div class="formCon">
				<?php
				$shop_logo_path = G5_DATA_PATH.'/logo/shop_logo.png';
				$shop_logo_url = G5_DATA_URL.'/logo/shop_logo.png';
				$upImg_shop_logo = file_exists($shop_logo_path) ? '<img src="'.get_url($shop_logo_url).'"><label><input type="checkbox" name="del_shop_logo" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_logo" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_logo.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>북마크 아이콘</label></div>
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
	</div>
</section>

<section class="mybox blue" style="/*background:rgba(0,0,0,0.015);*/">
	<div class="mybox-title fw600">아이콘 교체 <span class="fs12 color-red">(svg 파일만 업로드 가능합니다.)</span></div>
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="hdIcon_home"><i class="myIcon"></i></span></div>
			<div class="formCon">
				<?php
				$shop_hdIcon_home_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_home.svg';
				$shop_hdIcon_home_url = G5_DATA_URL.'/shop_icon/shop_hdIcon_home.svg';
				$upImg_shop_hdIcon_home = file_exists($shop_hdIcon_home_path) ? '<img src="'.get_url($shop_hdIcon_home_url).'"><label><input type="checkbox" name="del_shop_hdIcon_home" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_hdIcon_home" class="myfile" accept=".svg">';
				echo '<div class="upImg" style="width:24px;">'.$upImg_shop_hdIcon_home.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400" id="gnbOpener"><span class="hdIcon_gnb"><?=$_gnbOpener?></span></div>
			<div class="formCon">
				<?php
				$shop_hdIcon_gnb_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_gnb.svg';
				$shop_hdIcon_gnb_url = G5_DATA_URL.'/shop_icon/shop_hdIcon_gnb.svg';
				$upImg_shop_hdIcon_gnb = file_exists($shop_hdIcon_gnb_path) ? '<img src="'.get_url($shop_hdIcon_gnb_url).'"><label><input type="checkbox" name="del_shop_hdIcon_gnb" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_hdIcon_gnb" class="myfile" accept=".svg">';
				echo '<div class="upImg" style="width:24px;">'.$upImg_shop_hdIcon_gnb.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="hdIcon_search"><i class="myIcon"></i></div>
			<div class="formCon">
				<?php
				$shop_hdIcon_search_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_search.svg';
				$shop_hdIcon_search_url = G5_DATA_URL.'/shop_icon/shop_hdIcon_search.svg';
				$upImg_shop_hdIcon_search = file_exists($shop_hdIcon_search_path) ? '<img src="'.get_url($shop_hdIcon_search_url).'"><label><input type="checkbox" name="del_shop_hdIcon_search" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_hdIcon_search" class="myfile" accept=".svg">';
				echo '<div class="upImg" style="width:24px;">'.$upImg_shop_hdIcon_search.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="hdIcon_cart"><i class="myIcon"></i></div>
			<div class="formCon">
				<?php
				$shop_hdIcon_cart_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_cart.svg';
				$shop_hdIcon_cart_url = G5_DATA_URL.'/shop_icon/shop_hdIcon_cart.svg';
				$upImg_shop_hdIcon_cart = file_exists($shop_hdIcon_cart_path) ? '<img src="'.get_url($shop_hdIcon_cart_url).'"><label><input type="checkbox" name="del_shop_hdIcon_cart" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_hdIcon_cart" class="myfile" accept=".svg">';
				echo '<div class="upImg" style="width:24px;">'.$upImg_shop_hdIcon_cart.'</div>';
				?>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-center fw400"><span class="hdIcon_store"><i class="myIcon"></i></div>
			<div class="formCon flex flex-middle" style="--toggle-light-width:36px;	--toggle-light-height:18px;--toggle-light-font-size:10px;">
				<?php
				$shop_hdIcon_store_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_store.svg';
				$shop_hdIcon_store_url = G5_DATA_URL.'/shop_icon/shop_hdIcon_store.svg';
				$upImg_shop_hdIcon_store = file_exists($shop_hdIcon_store_path) ? '<img src="'.get_url($shop_hdIcon_store_url).'"><label><input type="checkbox" name="del_shop_hdIcon_store" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_hdIcon_store" class="myfile" accept=".svg">';
				echo '<div class="upImg" style="width:24px;">'.$upImg_shop_hdIcon_store.'</div>';
				?>
				<input type="checkbox" name="shop_header_use_store" value="1" class="toggle-light"<?=$default['shop_header_use_store']?' checked':''?>>
			</div>
		</div>
		
		
	</div>	
</section>

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>header 컬러</label></div>
			<div class="formCon flex flex-middle gap20">
				<input type="text" name="shop_header_color[0]" value="<?=$shop_header_color[0]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="배경 컬러">
				<input type="text" name="shop_header_color[1]" value="<?=$shop_header_color[1]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="아이콘&폰트 컬러">
			</div>
		</div>	
	</div>
</section>

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="formCon column gap0">
				<div class="flex flex-middle gap20">
					<b>Shop메뉴 관리</b>
					<button type="button" onclick="return add_menu();" class="_btn/mini/green/rd5 fw500">메뉴추가</button>
					<?php if(!$tab) echo '<a href="'.$_adm_url.'/?pn=_shop_itemtype_setting" class="popWin _btn/mini/gray/rd5 fw500" data-width="1000" data-height="500" data-top="60" data-left="0">상품유형 관리</a>'; ?>
					<?php if(!$itemtype) echo '<span class="help-block color-red ml10">※ 선택가능 메뉴가 없다면 <b>[상품유형]</b>을 먼저 설정해 주세요.</span>'; ?>
				</div>
				<p class="help-block">메뉴명 단어사이에 /를 삽입하면 롤링 텍스트로 출력합니다. 예시) 할인특가/EVENT</p>
				<ul id="shop_top_menu">
					<?php
					include_once($_adm_path.'/shop_top_menu.lib.php');
					echo $list = get_shop_top_menu_list();
					?>
				</ul>
			</div>
		</div>	
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
matchOnOff_checkbox('#check_use_menu', '.radio_menu_scroll_fixed', '', '');


function menuChoice(el) {
	$(el).on("change", function(){
		var val = $(this).find("option:selected").val(),
			menuName = $(this).closest('li').find('._shopMenuName'),
			menuLink = $(this).closest('li').find('._shopMenuLink'),
			menuLinkOption = $(this).closest('li').find('._shopMenuLinkOption'),			
			select = $(this).closest('li').find('._shopMenuBoard'),
			menuLink_label = menuLink.find('.label');
		if(val) {
			if(val == '_page') {
				select.hide();
				menuLink_label.html('페이지ID');
				menuLink.show();
				menuLinkOption.hide();
				menuName.find('input').attr("placeholder" , '필수');
				menuName.find('input').attr("required" , true);
			} else if(val == '_board') {
				select.show();
				menuLink.hide();
				menuLinkOption.hide();
				menuName.find('input').attr("placeholder" , '생략가능');
				menuName.find('input').attr("required" , false);	
			} else {				
				select.hide();
				menuLink.hide();
				menuLinkOption.hide();
				menuName.find('input').attr("placeholder" , '생략가능');
				menuName.find('input').attr("required" , false);	
			}
		} else {
			select.hide();
			menuLink_label.html('링크');
			menuLink.show();
			menuLinkOption.show();
			menuName.find('input').attr("placeholder" , '필수');
			menuName.find('input').attr("required" , true);
		}
	});
}


$('.menuChoice').each(function() {
	menuChoice($(this));
});


$(function() {
    $(document).on("click", ".btn_del_menu", function() {
        var $li = $(this).closest("li");
        $li.remove();
    });
});


function add_menu() {	
    var max_code = base_convert(0, 10, 36);
    var count = $("#shop_top_menu .shop_top_menu_list").length + 1;
	$.post("<?=$_adm_url?>/shop_top_menu_form.php",{count:count}, function(data) {
		var $menulist = $("#shop_top_menu");
		var $menu_last = null;
		$menu_last = $menulist.find(".shop_top_menu_list:last");
		$menulist.append(data);
		$('select').selectpicker('refresh');
		menuChoice('.shopmenu_'+ count +' .menuChoice');
	});
	
}
function base_convert(number, frombase, tobase) { 
  return parseInt(number + '', frombase | 0)
    .toString(tobase | 0);
}
</script>
<?php
if (!defined('_GNUBOARD_')) exit;

if(G5_IS_MOBILE) {
	require_once(G5_THEME_PATH.'/_adm/_shop_header_mobile_setting.php');
    return;
}

$shop_header_color = explode("|", $default['shop_header_color']);

//상품유형
$itemtype = explode("|", $default['itemtype']);
if(!$itemtype[0] && !$itemtype[1] && !$itemtype[2] && !$itemtype[3] && !$itemtype[4]) $itemtype = false;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_header_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label160">
		<div class="form-list">
			<div class="form-label"><label>헤더 가로 사이즈</label></div>
			<div class="formCon flex flex-middle gap20">
				<input type="text" name="shop_header_width" value="<?=$default['shop_header_width']?$default['shop_header_width']:''?>" class="w-100" placeholder="" data-label-inline="PX">
			</div>
		</div>
	</div>	
</section>

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label150">			
		<div class="form-list">
			<div class="form-label"><label>Shop 로고</label></div>
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
		<div class="form-list" style="background:rgba(0,0,0,0.05);">
			<div class="form-label"><label>Shop 로고(흰색)</label></div>
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
		<div class="form-list">
			<div class="form-label"><label>Shop 로고(모바일)</label></div>
			<div class="formCon">
				<?php
				$shop_logo_mobile_path = G5_DATA_PATH.'/logo/shop_logo_mobile.png';
				$shop_logo_mobile_url = G5_DATA_URL.'/logo/shop_logo_mobile.png';
				$upImg_shop_logo_mobile = file_exists($shop_logo_mobile_path) ? '<img src="'.get_url($shop_logo_mobile_url).'"><label><input type="checkbox" name="del_shop_logo_mobile" value="1">삭제</label>' : '';
				echo '<input type="file" name="shop_logo_mobile" class="myfile">';
				echo '<div class="upImg">'.$upImg_shop_logo_mobile.'</div>';
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
				menuLink_label.html('페이지명');
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
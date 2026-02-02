<?php
if (!defined('_GNUBOARD_')) exit;

include_once($_adm_path.'/shop_top_menu.lib.php');

$shop_header_color = explode("|", $default['shop_header_color']);

//상품유형
$itemtype = explode("|", $default['itemtype']);
if(!$itemtype[0] && !$itemtype[1] && !$itemtype[2] && !$itemtype[3] && !$itemtype[4]) $itemtype = false;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_header_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label100">			
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 로고</label></div>
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
	</div>
</section>

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>헤더 컬러</label></div>
			<div class="formCon flex flex-middle gap20">
				<input type="text" name="shop_header_color[0]" value="<?=$shop_header_color[0]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="배경 컬러">
				<input type="text" name="shop_header_color[1]" value="<?=$shop_header_color[1]?>" class="colorpicker btnColor" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="폰트 컬러">
			</div>
		</div>	
	</div>
</section>

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="formCon column gap0">
				<div class="flex flex-middle gap20">
					<b>상단 메뉴관리</b>
					<button type="button" onclick="return add_menu();" class="_btn/mini/green/rd5 fw500">메뉴추가</button>
					<?php if(!$tab) echo '<a href="'.$_adm_url.'/?pn=_shop_itemtype_setting" class="popWin _btn/mini/gray/rd5 fw500" data-width="1000" data-height="500" data-top="60" data-left="0">상품유형 관리</a>'; ?>
					<?php if(!$itemtype) echo '<span class="help-block color-red ml10">※ 선택가능 메뉴가 없다면 <b>[상품유형]</b>을 먼저 설정해 주세요.</span>'; ?>
				</div>
				<ul id="shop_top_menu">
					<?php					
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
function menuChoice(el) {
	$(el).on("change", function(){
		var val = $(this).find("option:selected").val(),
			menuName = $(this).closest('li').find('._shopMenuName'),
			menuLink = $(this).closest('li').find('._shopMenuLink'),
			menuLink_label = menuLink.find('.label');
		if(val) {
			if(val == '_page') {
				menuLink_label.html('페이지명');
				menuLink.show();
				menuName.find('input').attr("placeholder" , '필수');
				menuName.find('input').attr("required" , true);
			} else {
				menuLink.hide();
				menuName.find('input').attr("placeholder" , '생략가능');
				menuName.find('input').attr("required" , false);	
			}					
		} else {
			menuLink_label.html('링크');
			menuLink.show();
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
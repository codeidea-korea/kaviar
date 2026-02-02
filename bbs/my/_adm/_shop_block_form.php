<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);
@include_once(G5_THEME_PATH.'/_shop_block_config.php'); //블럭 기본 설정값

//믹스 스킨 경로
$this_mix_path = G5_THIS_PATH.'/skin/shop/basic/mix_type/';
$theme_mix_path = G5_THEME_PATH.'/skin/shop/basic/mix_type/';
$_mix_path = G5_PATH.'/skin/shop/basic/mix_type/';
if(is_dir($this_mix_path)) {
	$_mix_path =  $this_mix_path;
} else if(is_dir($theme_mix_path)){
	$_mix_path =  $theme_mix_path;
} else {
	$_mix_path =  $_mix_path;
}
$_mix_url = str_replace(G5_PATH, G5_URL, $_mix_path);


$bl_cate = $_GET['bl_cate'] ? $_GET['bl_cate'] : 'index';

//저장후 목록페이지로..
$callback_url = $_adm_url.'/?pn=_shop_block&bl_cate='.$bl_cate.'&title=쇼핑몰 메인페이지'.($_GET['bl_use']?'&bl_use='.$_GET['bl_use']:'');

if ($w == "u") {
    $html_title .= " 수정";
    $readonly = " readonly";

    $sql = " select * from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
    $shopblock = sql_fetch($sql);
	$bl_id = isset($_REQUEST['bl_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['bl_id']) : 0;
    if (!$shopblock['bl_id'])
        alert('등록된 자료가 없습니다.');

} else {
    $html_title .= ' 추가';
    $shopblock = array(
        'bl_id' => '',
        'bl_subject' => '',
        'bl_content' => '',
		'items_count' => '',
        'bl_skin' => 'basic'
        );
	
	if($_GET['bl_use']) $shopblock['bl_use'] = $_GET['bl_use'];
	
	if($_GET['bl_cate'] == 'search') $shopblock['bl_type'] = 'item';
	if($_GET['bl_cate'] == 'mypage' || $_GET['bl_cate'] == 'customer' || $_GET['bl_cate'] == 'login_intro') {
		$shopblock['bl_type'] = 'link';
	}
}

$bl_use_selectColor = '';
if($shopblock['bl_use'] == 'none') $bl_use_selectColor = 'selectColor-gray-light';
if($shopblock['bl_use'] == 'admin') $bl_use_selectColor = 'selectColor-black';

$bl_padding = explode("|", $shopblock['bl_padding']);
$bl_padding_mobile = explode("|", $shopblock['bl_padding_mobile']);
$bl_background = explode("|",$shopblock['bl_background']);
$bl_link = explode("|", $shopblock['bl_link']);
$items_skin = explode("|",$shopblock['items_skin']);
$items_order_option = explode("|",$shopblock['items_order_option']);
$shop_banner_category = explode('|', $default['shop_banner_category']);
$itemtype = explode("|", $default['itemtype']);
$sel_li_id = explode(",",$shopblock['items_sel_li_id']);


// 목록수
$_push_items_count = '<div id="listCount" class="labelGroup"><label class="labelInput ml25"><span class="label">목록 수</span><input type="text" name="items_count" value="'.($shopblock['items_count']?$shopblock['items_count']:'').'" class="w-50" placeholder="2"><span class="label label-inline">개</span></label><label class="labelInput"><span class="icon-mobile"></span><input type="text" name="items_count_mobile" value="'.($shopblock['items_count_mobile']?$shopblock['items_count_mobile']:'').'" class="w-65" placeholder="2" data-icon="mobile"><span class="label label-inline">개</span></label></div>';

//직접선택 값
$_push_btn_list_of_select = '<div id="btn_list_of_select" class="'.($shopblock['items_sel_li_id']?'active':'').'" style="'.(strpos($shopblock['items_order_option'], 'list_of_select') !== false?'':'display:none').'" data-width="1350" data-height="760" data-top="60" data-left="0">'.($shopblock['items_sel_li_id']?'<span class="count">'.count($sel_li_id).'개</span>':'').'</div>';

//가로 수
$_push_items_cols = '<div class="labelGroup itemsCols-label"><label id="label_items_cols" class="labelInput"><span class="label">가로 수</span><input type="text" name="items_cols" value="'.($shopblock['items_cols']?$shopblock['items_cols']:'').'" class="w-75" placeholder="1"><span class="label label-inline">개씩</span></label><label id="label_items_cols_mobile" class="labelInput"><span class="icon-mobile"></span><input type="text" name="items_cols_mobile" value="'.($shopblock['items_cols_mobile']?$shopblock['items_cols_mobile']:'').'" class="w-85" data-icon="mobile" placeholder="1"><span class="label label-inline">개씩</span></label></div>';

//아이템 간격
$_push_items_gap = '<div class="labelGroup"><label class="labelInput"><span class="label">아이템 간격</span><input type="text" name="items_gap" value="'.($shopblock['items_gap']?$shopblock['items_gap']:'').'" class="w-65" placeholder="15"><span class="label label-inline">PX</span></label><label class="labelInput"><span class="icon-mobile"></span><input type="text" name="items_gap_mobile" value="'.($shopblock['items_gap_mobile']?$shopblock['items_gap_mobile']:'').'" class="w-75" data-icon="mobile" placeholder="15"><span class="label label-inline">PX</span></label></div>';

//썸네일 라운딩처리
$_push_items_radius = '<div class="labelGroup"><label class="labelInput"><span class="label">썸네일 라운딩처리</span><input type="text" name="items_radius" value="'.($shopblock['items_radius']?$shopblock['items_radius']:'').'" class="w-65" placeholder="'.$_items_radius.'"><span class="label label-inline">PX</span></label><label class="labelInput"><span class="icon-mobile"></span><input type="text" name="items_radius_mobile" value="'.($shopblock['items_radius_mobile']?$shopblock['items_radius_mobile']:'').'" class="w-75" placeholder="'.$_items_radius_mobile.'" data-icon="mobile"><span class="label label-inline">PX</span></label></div>';

//카테고리 텝메뉴
//$_push_tabs_items_cate = '<label class="labelInput"><span class="label">상품분류 텝메뉴</span><input type="text" name="tabs_items_cate" value="'.$shopblock['tabs_items_cate'].'" class="w-full" placeholder="텝메뉴의 분류와 분류사이는 |로 구분"></label>';
$_push_tabs_items_cate = '<label class="labelInput itemsOrderOption-label"><span class="label">상품분류</span><select name="tabs_items_cate[]" value="'.$shopblock['tabs_items_cate'].'" id="tabs_items_cate" class="selectpicker flex1" multiple>';
$_push_tabs_items_cate .= get_shopCate_option($shopblock['tabs_items_cate'], 'multiple');
$_push_tabs_items_cate .= '</select></label>';


//블럭타입 - 배너출력 선택시 옵션
$_push_banner_orderOption = '<label class="labelInput itemsOrderOption-label"><span class="label">배너분류</span><select name="items_order_option[]" value="'.$items_order_option[0].'" id="items_order_option" class="items_order_option selectpicker">';
$_push_banner_orderOption .= option_selected("", $items_order_option[0], "분류 없음");
for($i=0; $i<count($shop_banner_category); $i++) {
	if($shop_banner_category[$i]) $_push_banner_orderOption .= option_selected($shop_banner_category[$i], $items_order_option[0], $shop_banner_category[$i]);
}
$_push_banner_orderOption .= option_selected("list_of_select",  $items_order_option[0], "직접선택");
$_push_banner_orderOption .= '</select></label>';
$_push_banner_orderOption2 .= '<label class="labelInput ml25"><span class="label">목록표시</span><select name="items_order_option[]" value="'.$items_order_option[1].'" id="items_order_option2" class="items_order_option selectpicker">';
$_push_banner_orderOption2 .= option_selected("", $items_order_option[1], "숫자로 표기");
$_push_banner_orderOption2 .= option_selected("basic",  $items_order_option[1], "점으로 표기");
$_push_banner_orderOption2 .= '</select></label>';
$_push_banner_orderOption = '<div class="flex flex-middle gap0">'.$_push_banner_orderOption.$_push_items_count.$_push_btn_list_of_select.$_push_banner_orderOption2.'</div><div class="flex flex-middle gap25">'.$_push_items_cols.$_push_items_gap.$_push_items_radius.'</div>';
$_push_banner_orderOption = preg_replace('/\r\n|\r|\n/','',$_push_banner_orderOption);


//블럭타입 - 상품출력 선택시 옵션
$_push_item_orderOption = '<label class="labelInput itemsOrderOption-label"><span class="label">상품분류</span><select name="items_order_option[0]" value="'.$items_order_option[0].'" id="items_order_option" class="selectpicker">';
$_push_item_orderOption .= option_selected("", $items_order_option[0], "분류 없음");
$_push_item_orderOption .= get_shopCate_option($items_order_option[0]);
$_push_item_orderOption .= option_selected("list_of_select",  $items_order_option[0], "직접선택");
$_push_item_orderOption .= '</select></label>';
$_push_item_orderOption .= '<label class="labelInput itemsOrderOption-label2"><span class="label">상품유형</span><select name="items_order_option[1]" value="'.$items_order_option[1].'" id="items_order_option2" class="selectpicker">';
$_push_item_orderOption .= option_selected("", $items_order_option[1], "유형 없음");
for ($i=0; $i<10; $i++) {
	$num = $i+1;
	if($itemtype[$i]) $_push_item_orderOption .= option_selected($num, $items_order_option[1], $itemtype[$i]);
}
$_push_item_orderOption .= option_selected("list_of_select",  $items_order_option[1], "직접선택");
$_push_item_orderOption .= '</select></label>';
$_push_item_orderOption = $_push_tabs_items_cate.'<div class="flex flex-middle gap10">'.$_push_item_orderOption.$_push_items_count.$_push_btn_list_of_select.'</div><div class="flex flex-middle gap25">'.$_push_items_cols.$_push_items_gap.$_push_items_radius.'</div>';
$_push_item_orderOption = preg_replace('/\r\n|\r|\n/','',$_push_item_orderOption);


//블럭타입 - 상품카테고리 출력 선택시 옵션
$_push_shopCate_orderOption = '<label class="checkbox-wrap"><input type="checkbox" name="items_order_option[]" value="썸네일 출력"'.($items_order_option[0]?' checked':'').'><span></span>썸네일 출력</label>';
$_push_shopCate_orderOption = $_push_shopCate_orderOption.'<div class="flex flex-middle gap15">'.$_push_items_cols.$_push_items_gap.$_push_items_radius.'</div>';
$_push_shopCate_orderOption = preg_replace('/\r\n|\r|\n/','',$_push_shopCate_orderOption);

//블럭타입 - 상품후기 출력 선택시 옵션
$_push_itemuse_orderOption = '<label class="labelInput itemsOrderOption-label"><span class="label">출력순서</span><select name="items_order_option[0]" value="'.$items_order_option[0].'" id="items_order_option" class="selectpicker">';
$_push_itemuse_orderOption .= option_selected("", $items_order_option[0], "최신후기순");
$_push_itemuse_orderOption .= option_selected("best", $items_order_option[0], "배스트후기순");
$_push_itemuse_orderOption .= option_selected("list_of_select",  $items_order_option[0], "직접선택");
$_push_itemuse_orderOption .= '</select></label>';
$_push_itemuse_orderOption = '<div class="flex flex-middle gap10">'.$_push_itemuse_orderOption.$_push_items_count.$_push_btn_list_of_select.'</div><div class="flex flex-middle gap25">'.$_push_items_cols.$_push_items_gap.$_push_items_radius.'</div>';
$_push_itemuse_orderOption = preg_replace('/\r\n|\r|\n/','',$_push_itemuse_orderOption);


//블럭타입 - 바로가기 링크 선택시 옵션
$_push_linkOption = '<div class="flex flex-middle gap25">'.$_push_items_cols.'</div>';
$_push_linkOption = preg_replace('/\r\n|\r|\n/','',$_push_linkOption);


//블럭타입 - 믹스형 선택시 옵션
function get_mix_type_select($id, $name, $selected=''){
    global $config, $_mix_path;

    $types = array();
    $types = array_merge($types, get_mix_type_dir($_mix_path));
    $str = '<select id="'.$id.'" name="'.$name.'" class="select-img w-300 mixtype">';
    for ($i=0; $i<count($types); $i++) {
		$text = $types[$i];
		$dataSubject = '';
		$mix_img_path = G5_THEME_PATH.'/skin/shop/basic/mix_type/'.$types[$i].'/thumb.gif';
		$mix_img_url = str_replace(G5_PATH, G5_URL, $mix_img_path);
		$str .= option_selected_my($types[$i], $selected, $text, 'data-content=\'<img src="'.get_url($mix_img_url).'" alt="'.$text.'"><span class="skin_name">'.$text.'</span>\'');
    }
    $str .= '</select>';
    return $str;
}
function get_mix_type_dir($_mix_path){
    global $g5;
    $result_array = array();
    $dirname = $_mix_path;
    if(!is_dir($dirname))
        return;
    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if($file == '.'||$file == '..') continue;
        if (is_dir($dirname.$file)) $result_array[] = $file;
    }
    closedir($handle);
    //sort($result_array);
	usort($result_array, 'strcasecmp'); //대,소문자 구분없이

    return $result_array;
}
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_url?>/_shop_block_form_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?=$w?>">
<input type="hidden" name="bl_id" value="<?=$bl_id?>">
<input type="hidden" name="bl_cate" value="<?=$bl_cate?>">
<input type="hidden" name="items_sel_li_id" value="<?=$shopblock['items_sel_li_id']?>" id="items_sel_li_id">
<input type="hidden" name="items_sel_li_count" value="<?=$shopblock['items_sel_li_id']?count($sel_li_id):''?>" id="items_sel_li_count">
<input type="hidden" name="bl_video" value="<?=$shopblock['bl_video']?>" id="bl_video">
<input type="hidden" name="close" value="<?=$_GET['close']?true:false?>">
<input type="hidden" name="callback" value="<?=$_GET['callback']?true:false?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue mt30">
	<div style="position:absolute;top:-15px;left:-1px;z-index:9;">
		<input type="text" name="bl_name" value="<?=$shopblock['bl_name']?>" class="w-220" data-label="블럭 이름" data-class="/blue/h-26">
	</div>
	<div class="formContainer label130 mt20">
		<!-- 폼 목록 시작 -->
		<div class="form-list">
			<div class="form-label">블럭 옵션</div>
			<div class="formCon flex column gap15">
				<div class="flex gap25">
					<input type="text" name="bl_order" value="<?=get_text($shopblock['bl_order'])?>" class="w-40" data-label="순서">
					<?php				
					$bl_use = '';
					$bl_use .= '<select name="bl_use" value="'.$shopblock['bl_use'].'" id="bl_use" class="selectpicker" data-style="'.$bl_use_selectColor.'" data-label="사용여부">';
					$bl_use .= option_selected_my("",  $shopblock['bl_use'], "전체 공개", "data-content='<span class=\"icon_check\">전체 공개</span>'");
					$bl_use .= option_selected_my("pc",  $shopblock['bl_use'], "pc", "data-content='<span class=\"icon_check\">pc</span>'");
					$bl_use .= option_selected_my("mobile",  $shopblock['bl_use'], "mobile", "data-content='<span class=\"icon_check\">모바일</span>'");
					$bl_use .= option_selected_my("none",  $shopblock['bl_use'], "비공개", "data-content='<span class=\"icon_none\">비공개</span>'");
					$bl_use .= option_selected_my("admin",  $shopblock['bl_use'], "관리자 확인용", "data-content='<span class=\"icon_admin\">관리자 확인용</span>'");
					$bl_use .= '</select>'.PHP_EOL;
					echo $bl_use;
					?>	
					<input type="text" name="bl_background[]" value="<?=$bl_background[0]?>" class="colorpicker" id="bl_background" data-class="ml50" data-label="블럭 배경색" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
					<label class="checkbox-label"><input type="checkbox" name="bl_background[]" value="1"<?=$bl_background[1]?' checked':''?>>구분선 넣기</label>
				</div>
				<div class="flex flex-middle gap25">
					<input type="text" name="bl_width" value="<?=$shopblock['bl_width']?$shopblock['bl_width']:''?>" id="bl_width" class="w-70 per100" data-label="가로사이즈" data-label-inline="<?=$shopblock['bl_width']&&$shopblock['bl_width']<=100?'%':'PX'?>" maxlength="4" placeholder="">					
					<div class="labelGroup">
						<input type="text" name="bl_padding[]" value="<?=$bl_padding[0]?>" id="bl_padding_t" class="w-55" data-label="위 여백" data-label-inline="PX" maxlength="3" placeholder="0">
						<input type="text" name="bl_padding_mobile[]" value="<?=$bl_padding_mobile[0]?>" id="bl_padding_mobile_t" class="w-70" data-icon="mobile" data-label-inline="PX" maxlength="3" placeholder="0">
					</div>
					<div class="labelGroup">
						<input type="text" name="bl_padding[]" value="<?=$bl_padding[1]?>" id="bl_padding_b" class="w-55" data-label="아래 여백" data-label-inline="PX" maxlength="3" placeholder="0">
						<input type="text" name="bl_padding_mobile[]" value="<?=$bl_padding_mobile[1]?>" id="bl_padding_mobile_b" class="w-70" data-icon="mobile" data-label-inline="PX" maxlength="3" placeholder="0">
					</div>
					<div class="labelGroup">
						<input type="text" name="bl_padding[]" value="<?=$bl_padding[2]?>" id="bl_padding_lr" class="w-55" data-label="좌·우 여백" data-label-inline="PX" maxlength="3" placeholder="0">
						<input type="text" name="bl_padding_mobile[]" value="<?=$bl_padding_mobile[2]?>" id="bl_padding_mobile_lr" class="w-70" data-icon="mobile" data-label-inline="PX" maxlength="3" placeholder="0">
					</div>									
				</div>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label">블럭 타이틀</div>
			<div class="formCon">
				<div id="bl_title_set">
					<label class="labelColor-hidden small" title="텍스트 컬러" style="position:absolute;top:0;left:-20px;z-index:13;">
						<input type="text" name="bl_title_color" value="<?=get_text($shopblock['bl_title_color'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
					</label>
					<div class="flex flex-top gap10">
						<textarea name="bl_title" id="bl_title" class="bl_title w-full autosize<?=$bl_font?' '.$bl_font:''?>" style="<?=$shopblock['bl_title_align']?'text-align:'.$shopblock['bl_title_align'].';':''?>min-height:94px;" placeholder=""><?=$shopblock['bl_title']?></textarea>
						<select name="bl_title_align" value="<?=$shopblock['bl_title_align']?>" id="bl_title_align" class="selectpicker" data-style="selectColor-gray">
							<?php
							echo option_selected("",  $shopblock['bl_title_align'], "←좌정렬");
							echo option_selected("center", $shopblock['bl_title_align'], "가운데정렬");						
							echo option_selected("right", $shopblock['bl_title_align'], "우정렬→");
							?>
						</select>
					</div>
					<div class="flex flex-top gap10 mt10">
						<textarea name="bl_title_mobile" id="bl_title_mobile" class="bl_title_mobile w-full autosize<?=$bl_font?' '.$bl_font:''?>" style="<?=$shopblock['bl_title_mobile_align']?'text-align:'.$shopblock['bl_title_mobile_align'].';':''?>min-height:82px;" data-icon="mobile" placeholder=""><?=$shopblock['bl_title_mobile']?></textarea>
						<select name="bl_title_mobile_align" value="<?=$shopblock['bl_title_mobile_align']?>" id="bl_title_mobile_align" class="selectpicker" data-style="selectColor-gray">
							<?php
							echo option_selected("",  $shopblock['bl_title_mobile_align'], "←좌정렬");
							echo option_selected("center", $shopblock['bl_title_mobile_align'], "가운데정렬");						
							echo option_selected("right", $shopblock['bl_title_mobile_align'], "우정렬→");
							?>
						</select>
					</div>
				</div>
				<div class="flex flex-middle gap10 mt10">
					<div class="btnColor-set">
						<input type="text" name="bl_link[0]" value="<?=$bl_link[0]?>" class="w-110" placeholder="전체보기">
						<div class="labelColor-hiddenSet">
							<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="bl_link_color" value="<?=$shopblock['bl_link_color']?>" class="colorpicker" data-position="right" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
						</div>
					</div>
					<input type="text" name="bl_link[1]" value="<?=$bl_link[1]?>" class="flex1" placeholder="https://">
					<select name="bl_link[2]" value="<?=$bl_link[2]?>" id="bl_link_option" class="selectpicker">
						<?php
						echo option_selected("", $bl_link[2], "바로가기");
						echo option_selected("_blank", $bl_link[2], "새창열기");
						?>
					</select>
				</div>
			</div>
		</div>

		<div class="form-group mt10 mb20 bg-gray-light">
			<div class="form-list">
				<div class="form-label">블럭 타입</div>
				<div class="formCon flex gap20">
					<select name="bl_type" value="<?=$shopblock['bl_type']?>" id="bl_type" class="selectpicker" data-style="selectColor-gray">
						<?php
						echo option_selected("",  $shopblock['bl_type'], "타입 없음");
						echo option_selected("banner", $shopblock['bl_type'], "배너 출력");						
						echo option_selected("item", $shopblock['bl_type'], "상품 출력");
						echo option_selected("shopCate", $shopblock['bl_type'], "상품 카테고리 출력");
						echo option_selected("itemuse", $shopblock['bl_type'], "상품후기 출력");
						echo option_selected("link", $shopblock['bl_type'], "바로가기(아이콘) 링크");
						echo option_selected("mix", $shopblock['bl_type'], "믹스형");
						?>
					</select>
					<div id="shop_banner_adm_btn">
						<a href="<?=$_adm_url?>/?&pn=_shop_banner&bn_position=basic&title=쇼핑몰 배너관리" class="_btn/sm/rd3 popWin" data-width="1250" data-height="600" data-top="60" data-left="0">쇼핑몰 배너관리</a>
					</div>
					<div id="blSkinContainer">						
						<select name="items_skin[]" value="<?=$items_skin[0]?>" id="items_skin" class="selectpicker select-img n3 w-130">
							<?php
							echo option_selected_my("_slide", $items_skin[0], "_slide", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_slide.gif")."'><span class='skin_name'>슬라이드형</span>\"");
							echo option_selected_my("_wz", $items_skin[0], "_wz", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_wz.gif")."'><span class='skin_name'>웹진형</span>\"");
							echo option_selected_my("_gall", $items_skin[0], "_gall", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_gall.gif")."'><span class='skin_name'>갤러리형</span>\"");
							?>
						</select>
						<select name="items_skin[]" value="<?=$items_skin[1]?>" id="items_skin_mobile" class="selectpicker select-img n2 w-130" data-icon="mobile">
							<?php
							echo option_selected_my("", $items_skin[1], "pc와 동일", "");
							echo option_selected_my("_slide", $items_skin[1], "_slide", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_slide.gif")."'><span class='skin_name'>슬라이드형</span>\"");
							echo option_selected_my("_wz", $items_skin[1], "_wz", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_wz.gif")."'><span class='skin_name'>웹진형</span>\"");
							echo option_selected_my("_gall", $items_skin[1], "_gall", "data-content=\"<img src='".get_url($_adm_url."/img/shop/_gall.gif")."'><span class='skin_name'>갤러리형</span>\"");
							?>
						</select>
						<label id="label-item-outline" class="checkbox-label"><input type="checkbox" name="items_skin[]" value="외곽선"<?=strpos($shopblock['items_skin'], '외곽선') !== false?' checked':''?>>외곽선</label>
						<label id="label-item-shadow" class="checkbox-label"><input type="checkbox" name="items_skin[]" value="그림자"<?=strpos($shopblock['items_skin'], '그림자') !== false?' checked':''?>>그림자</label>
					</div>
				</div>
			</div>
			<div id="list-itemsOrderOptionSet" class="form-list">
				<div class="form-label">불러오기 옵션</div>
				<div class="formCon flex gap20">
					<div id="itemsOrderOptionSet" class="w-full"></div>
				</div>
			</div>
			<div id="blMixSet">
				<div class="form-list">
					<div class="form-label"><label>믹스형 타입</label></div>
					<div class="formCon">
						<?=get_mix_type_select('mix_type', 'mix_type', $shopblock['mix_type'])?>
					</div>
				</div>
				<article id="mix-form"></article>
			</div>
		</div>
		
		<div id="blImgSet" class="form-list">
			<div class="form-label"><label>이미지</label></div>
			<div class="formCon flex flex-top gap60">
				<div class="banner_img">
					<input type="file" name="bl_img1" class="myfile">
					<div class="upImg">
						<?php
						$bl_img1 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_1';
						if (file_exists($bl_img1)) {
							$bl_img1_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_1">';
							$bl_img1_str .= '<label><input type="checkbox" name="del_bl_img1" value="1">삭제</label>';
						}
						if ($bl_img1_str) echo $bl_img1_str;
						?>
					</div>
				</div>
			</div>
			<div class="form-label"><label>모바일</label></div>
			<div class="formCon flex flex-top gap60">
				<div class="banner_img">
					<input type="file" name="bl_img2" class="myfile">
					<div class="upImg">
					<?php
					$bl_img2 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_2';
					if (file_exists($bl_img2)) {
						$bl_img2_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_2">';
						$bl_img2_str .= '<label><input type="checkbox" name="del_bl_img2" value="1">삭제</label>';
					}
					if ($bl_img2_str) echo $bl_img2_str;
					?>
					</div>
				</div>
			</div>
		</div>

		<div id="blVideoSet" class="form-list">
			<div class="form-label"><label>동영상</label></div>
			<div class="formCon">
				<input type="text" name="bl_video_src" id="bl_video_src" value="<?=$shopblock['bl_video_src']?$shopblock['bl_video_src']:''?>" data-label="<i class='icon_video'></i>" data-class="w-full <?=$shopblock['bl_video_src']?'/red':'labelColor-lightGray'?>" placeholder="mp4경로,&nbsp;&nbsp;&nbsp;(유투브) https://youtu.be/AbCdefGhiJK...,&nbsp;&nbsp;&nbsp;(비메오) https://vimeo.com/01234567...">
			</div>
		</div>

		<div id="blLinkSet" class="form-list"<?=$shopblock['bl_type']!='link'?' style="display:none"':''?>>
			<div class="form-label"><label>바로가기 링크</label></div>
			<div class="formCon">
				<div id="linkOptionSet"></div>
				<ul class="flex column gap10">
					<?php for($i=1; $i<=10; $i++) {
						$bl_link_set[$i] = explode("|", $shopblock['bl_link'.$i]);
						echo '<li class="flex flex-middle">';
							echo '<span class="_btn/sm/'.($bl_link_set[$i][0]||$bl_link_set[$i][1]?'blue':'gray').'/rd5 h-20 w-20 p0 mont">'.$i.'</span>';

							echo '<div class="fileImgSet" style="--img-size:80px">';
								echo '<div class="img_li">';
									echo '<input type="file" name="bl_icon'.$i.'" class="myfile">';
									echo '<div class="upImg">';
										$bl_icon_path[$i] = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_icon'.$i;		
										if (file_exists($bl_icon_path[$i])) echo '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_icon'.$i.'">';								
									echo '</div>';
									if (file_exists($bl_icon_path[$i])) echo  '<label><input type="checkbox" name="del_bl_icon'.$i.'" value="1">삭제</label>';
								echo '</div>';
							echo '</div>';

							echo '<select name="bl_link'.$i.'[]" value="'.$bl_link_set[$i][0].'" id="bl_link'.$i.'" class="bl_link_type selectpicker" data-live-search="true">';
								echo option_selected("",  $bl_link_set[$i][0], "직접 입력");
								echo get_board_select_option_my($bl_link_set[$i][0], 'shop_');
							echo '</select>';
							echo '<div class="linkformSet flex1"'.($bl_link_set[$i][0]?' style="display:none;"':'').'>';
								echo '<input type="text" name="bl_link'.$i.'[]" value="'.$bl_link_set[$i][1].'" class="w-150" placeholder="바로가기">';
								echo '<input type="text" name="bl_link'.$i.'[]" value="'.$bl_link_set[$i][2].'" class="flex1" placeholder="https://">';
								echo '<select name="bl_link'.$i.'[]" value="'.$bl_link_set[$i][3].'" id="bl_link'.$i.'_option" class="selectpicker">';
									echo option_selected("", $bl_link_set[$i][3], "바로가기");
									echo option_selected("_blank", $bl_link_set[$i][3], "새창열기");
								echo '</select>';
							echo '</div>';
						echo '</li>';
					} ?>					
				</ul>
			</div>
		</div>		
		
		<?php if ($w == "u") { ?>
		<div class="form-list">
			<div class="form-label"><label>HTML</label></div>
			<div class="formCon">
				<?php
				$inc_top_file_name = '_section_'.$shopblock['bl_id'].'_top.php';
				$inc_top_shop_block_path = G5_HTML_PATH.'/_shop_block';
				$inc_top_shop_block = $inc_top_shop_block_path.'/'.$inc_top_file_name;
				$_get_inc_top_shop_block_class = file_exists($inc_top_shop_block) ? 'active' : 'bin';
				$inc_file_name = '_section_'.$shopblock['bl_id'].'.php';
				$inc_shop_block_path = G5_HTML_PATH.'/_shop_block';
				$inc_shop_block = $inc_shop_block_path.'/'.$inc_file_name;
				$_get_inc_shop_block_class = file_exists($inc_shop_block) ? 'active' : 'bin';
				?>
				<div class="layout-box column gap5 w-85">
					<div class="itemContainer">
						<span class="item h-22 fileMake <?=$_get_inc_top_shop_block_class?>" data-filepath="<?=$inc_top_shop_block?>">HTML</span>
						<span class="fileDelete" data-filepath="<?=$inc_top_shop_block?>">삭제</span>
						<p class="text">html/_shop_block/<span><?=$inc_top_file_name?></span></p>
					</div>
					<span class="item h-20">블럭 콘텐츠</span>
					<div class="itemContainer">
						<span class="item h-22 fileMake <?=$_get_inc_shop_block_class?>" data-filepath="<?=$inc_shop_block?>">HTML</span>
						<span class="fileDelete" data-filepath="<?=$inc_shop_block?>">삭제</span>
						<p class="text">html/_shop_block/<span><?=$inc_file_name?></span></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
		<?php
		for ($i=1; $i<=4; $i++) {
			$ex_btn[$i] = explode("|", $shopblock['bl_btn'.$i]);
			$bl_btn_color[$i] = explode("|", $shopblock['bl_btn'.$i.'_color']);
		}
		$form_btn = '<div class="form-btn-set">';
		$form_btn .= '<span class="add-list">추가</span>';
		$form_btn .= '<input type="text" name="bl_btn_radius" value="'.$shopblock['bl_btn_radius'].'" maxlength="2" class="number" data-class="input-btn-radius" data-label="라운딩" data-label-inline="px">';
		$form_btn .= '<div class="option-list">';
		for($i=1; $i<=4; $i++) {
			if($i==1 || $ex_btn[$i][0]) {
				$form_btn .= '<div class="form-btn-list">'.PHP_EOL;
					$form_btn .= '<div class="btnColor-set">'.PHP_EOL;
						$form_btn .= '<input type="text" name="bl_btn'.$i.'[0]" value="'.$ex_btn[$i][0].'" class="btn-name w-200 fs11" size="50" placeholder="바로가기" data-label="버튼명'.$i.'">'.PHP_EOL;
						$form_btn .= '<div class="labelColor-hiddenSet">'.PHP_EOL;
							$form_btn .= '<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="bl_btn'.$i.'_color[0]" value="'.get_text($bl_btn_color[$i][0]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
							$form_btn .= '<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="bl_btn'.$i.'_color[1]" value="'.get_text($bl_btn_color[$i][1]).'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
						$form_btn .= '</div>'.PHP_EOL;
					$form_btn .= '</div>'.PHP_EOL;
					$form_btn .= '<div class="btnlink-set">'.PHP_EOL;
						$form_btn .= '<input type="text" name="bl_btn'.$i.'[1]" value="'.$ex_btn[$i][1].'" id="bl_btn'.$i.'_link" class="btn-link flex1" placeholder="http://">'.PHP_EOL;
						$form_btn .= '<select name="bl_btn'.$i.'[2]" value="'.$ex_btn[$i][2].'" id="bl_btn'.$i.'_target" class="selectpicker w-130 btn-target">'.PHP_EOL;
							$form_btn .= option_selected("_self",  $ex_btn[$i][2], "바로 이동");
							$form_btn .= option_selected("_blank",  $ex_btn[$i][2], "새창 열기");				
							//$form_btn .= option_selected("popup",  $ex_btn[$i][2], "팝업");
							//$form_btn .= option_selected("alert",  $ex_btn[$i][2], "←엘럿");
							//$form_btn .= option_selected("layerpopup",  $ex_btn[$i][2], "레이어 팝업");
							//$form_btn .= option_selected("down",  $ex_btn[$i][2], "다운로드 링크");
						$form_btn .= '</select>'.PHP_EOL;
						$form_btn .= '<span class="btnPopupOption">'.PHP_EOL;
							$form_btn .= '<input type="text" name="bl_btn'.$i.'[3]" value="'.$ex_btn[$i][3].'" class="w-70" size="50" placeholder="가로" data-label-inline="W">'.PHP_EOL;
							$form_btn .= '<input type="text" name="bl_btn'.$i.'[4]" value="'.$ex_btn[$i][4].'" class="w-70" size="50" placeholder="세로" data-label-inline="H">'.PHP_EOL;
						$form_btn .= '</span>'.PHP_EOL;
					$form_btn .= '</div>'.PHP_EOL;
				$form_btn .= '</div>'.PHP_EOL;
			}
		}
		$form_btn .= '</div>'.PHP_EOL;
		$form_btn .= '</div>'.PHP_EOL;
		echo $form_btn;
		?>
	</div>

</section>

<div class="_adm_btnSet">
	<?=$_GET['close']?'<span onclick="winClose();" class="btn gray w-70 cursor-pointer">취소</span>':'<a href="'.$callback_url.'" class="btn gray w-70">취소</a>';//이전페이지-$_SERVER["HTTP_REFERER"]?>
	<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<?php
$_filemake_type = 'shop_block';
$_filemake_dir = '_shop_block';
$_filemake_id = $shopblock['bl_id'];
include_once(G5_BBS_PATH.'/my/filemake_script.php');
?>

<script>
$(function() {
	$(document).on("click", ".add-list", function() {
		add_list();
	});
	$(document).on("click", ".del-list", function() {
		var $li = $(this).closest(".form-btn-list");
		$li.remove();        
	});
});
function add_list() {
	var $option_list = $(".option-list");
	var count = $(".option-list .form-btn-list").length + 1;
	if(count <= 4) {
		var list = '<div class="form-btn-list">';
		list += '<div class="btnColor-set">';
		list += '<label class="labelInput left-label"><span class="label">버튼명'+count+'</span><input type="text" name="bl_btn'+count+'[0]" value="" class="btn-name w-140" size="50" placeholder="바로가기" data-label="버튼명'+count+'"></label>';
		list += '<div class="labelColor-hiddenSet">';
		list += '<label class="labelColor-hidden" title="버튼 컬러"><input type="text" name="bl_btn'+count+'_color[0]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>';
		list += '<label class="labelColor-hidden" title="롤오버 컬러"><input type="text" name="bl_btn'+count+'_color[1]" value="" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>';
		list += '</div>';
		list += '</div>';
		list += '<div class="btnlink-set">';
		list += '<input type="text" name="bl_btn'+count+'[1]" value="" id="bl_btn'+count+'_link" class="btn-link flex1" placeholder="http://">';
		list += '<select name="bl_btn'+count+'[2]" value="" id="bl_btn'+count+'_target" class="selectpicker w-130 btn-target">';
		list += '<option value="_self">바로 이동</option>';
		list += '<option value="_blank">새창 열기</option>';
		//list += '<option value="popup">팝업</option>';
		//list += '<option value="alert">←엘럿</option>';
		//list += '<option value="layerpopup">레이어 팝업</option>';
		//list += '<option value="down">다운로드 링크</option>';
		list += '</select>';
		list += '<span class="btnPopupOption">';
		list += '<label class="labelInput"><input type="text" name="bl_btn'+count+'[3]" value="" class="w-70" size="50" placeholder="가로" data-label-inline="W" style="padding-right:17px;"><span class="label-inline">W</span></label>';
		list += '<label class="labelInput"><input type="text" name="bl_btn'+count+'[4]" value="" class="w-70" size="50" placeholder="세로" data-label-inline="H" style="padding-right:17px;"><span class="label-inline">H</span></label>';
		list += '</span>';
		list += '</div>';
		list += '</div>';
		var $list_last = null;
		var $list_last = $option_list.find(".form-btn-list:last");
		$list_last.after(list);
		$(".selectpicker").selectpicker("refresh");
		btn_target("select.btn-target");
		colorpicker(".colorpicker");
	} else {
		alert("버튼은 4개 까지 추가 가능합니다.");
	}
}
</script>

<script>
opener.$("#section-<?=$shopblock['bl_id']?>").removeClass('hover-marker');

function winClose() {
	window.open('','_self').close();
}

//디폴트 값 (여백)
function _bl_padding_placeholder(type) {
	var bl_title_val = $('#bl_title').val(),
		bl_width = $('#bl_width').val(),
		bl_title_mobile_val = $('#bl_title_mobile').val(),
		bl_video_src_val = $('#bl_video_src').val();

	if(type == 'banner') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_banner_padding_t?$_banner_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_banner_padding_b?$_banner_padding_b:0?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_banner_padding_lr?$__banner_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_banner_padding?$_banner_padding:0?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_banner_padding_mobile_t?$_banner_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_banner_padding_mobile_b?$_banner_padding_mobile_b:0?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_banner_padding_mobile_lr?$_banner_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_banner_padding_mobile?$_banner_padding_mobile:0?>');
		}
	} else if(type == 'item') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_items_padding_t?$_items_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_items_padding_b?$_items_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_items_padding_lr?$_items_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_items_padding?$_items_padding:30?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_items_padding_mobile_t?$_items_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_items_padding_mobile_b?$_items_padding_mobile_b:15?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_items_padding_mobile_lr?$_items_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_items_padding_mobile?$_items_padding_mobile:15?>');
		}
	} else if(type == 'shopCate') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_shopCate_padding_t?$_shopCate_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_shopCate_padding_b?$_shopCate_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_shopCate_padding_lr?$_shopCate_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_shopCate_padding?$_shopCate_padding:30?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_shopCate_padding_mobile_t?$_shopCate_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_shopCate_padding_mobile_b?$_shopCate_padding_mobile_b:15?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_shopCate_padding_mobile_lr?$_shopCate_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_shopCate_padding_mobile?$_shopCate_padding_mobile:15?>');
		}
	} else if(type == 'itemuse') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_itemuse_padding_t?$_itemuse_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_itemuse_padding_b?$_itemuse_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_itemuse_padding_lr?$_itemuse_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_itemuse_padding?$_itemuse_padding:30?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_itemuse_padding_mobile_t?$_itemuse_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_itemuse_padding_mobile_b?$_itemuse_padding_mobile_b:15?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_itemuse_padding_mobile_lr?$_itemuse_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_itemuse_padding_mobile?$_itemuse_padding_mobile:15?>');
		}
	} else if(type == 'link') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_link_padding_t?$_link_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_link_padding_b?$_link_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_link_padding_lr?$_link_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_link_padding?$_link_padding:30?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_link_padding_mobile_t?$_link_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_link_padding_mobile_b?$_link_padding_mobile_b:20?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_link_padding_mobile_lr?$_link_padding_mobile_lr:20?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_link_padding_mobile?$_link_padding_mobile:20?>');
		}
	} else if(type == 'mix') {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_mix_padding_t?$_mix_padding_t:50?>');
			$('#bl_padding_b').attr('placeholder','<?=$_mix_padding_b?$_mix_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_mix_padding_lr?$_mix_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_mix_padding?$_mix_padding:30?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_mix_padding_mobile_t?$_mix_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_mix_padding_mobile_b?$_mix_padding_mobile_b:15?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_mix_padding_mobile_lr?$_mix_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_mix_padding_mobile?$_mix_padding_mobile:15?>');
		}
	} else {
		if(bl_title_val) {
			$('#bl_padding_t').attr('placeholder','<?=$_padding_t?$_padding_t:45?>');
			$('#bl_padding_b').attr('placeholder','<?=$_padding_b?$_padding_b:35?>');
			$('#bl_padding_lr').attr('placeholder','<?=$_padding_lr?$_padding_lr:30?>');
		} else {
			$('#bl_padding_t, #bl_padding_b, #bl_padding_lr').attr('placeholder','<?=$_padding?$_padding:0?>');
		}
		if(bl_title_val || bl_title_mobile_val) {
			$('#bl_padding_mobile_t').attr('placeholder','<?=$_padding_mobile_t?$_padding_mobile_t:25?>');
			$('#bl_padding_mobile_b').attr('placeholder','<?=$_padding_mobile_b?$_padding_mobile_b:15?>');
			$('#bl_padding_mobile_lr').attr('placeholder','<?=$_padding_mobile_lr?$_padding_mobile_lr:15?>');
		} else {
			$('#bl_padding_mobile_t, #bl_padding_mobile_b, #bl_padding_mobile_lr').attr('placeholder','<?=$_padding_mobile?$_padding_mobile:0?>');
		}
		if(bl_video_src_val) $('#bl_padding_mobile_b').attr('placeholder','0');		
	}
	if(bl_width) $('#bl_padding_lr').attr('placeholder','0');
}
//디폴트 값 (가로수)
function _items_cols_placeholder(type, items_skin, items_skin_mobile) {
	if(type == 'banner') {
		$('input[name=items_cols]').attr('placeholder','1');
		$('input[name=items_cols_mobile]').attr('placeholder','1');
	} else if(type == 'item') {
		if(items_skin == items_skin_mobile || !items_skin_mobile) {
			if(items_skin == '_slide') {
				$('input[name=items_cols]').attr('placeholder','<?=$_items_cols_slide?$_items_cols_slide:4?>');
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_items_cols_slide_mobile?$_items_cols_slide_mobile:1.25?>');
				$('.itemsCols-label').show();
				$('.itemsCols-label input').removeAttr("disabled"); 
			} else if(items_skin == '_gall') {
				$('input[name=items_cols]').attr('placeholder','<?=$_items_cols_gall?$_items_cols_gall:4?>');
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_items_cols_gall_mobile?$_items_cols_gall_mobile:2?>');
				$('.itemsCols-label').show();
				$('.itemsCols-label input').removeAttr("disabled"); 
			}
		} else {
			if(items_skin == '_slide') {
				$('input[name=items_cols]').attr('placeholder','<?=$_items_cols_slide?$_items_cols_slide:4?>');
			} else if(items_skin == '_gall') {
				$('input[name=items_cols]').attr('placeholder','<?=$_items_cols_gall?$_items_cols_gall:4?>');
			} else if(items_skin == '_wz') {
				$('input[name=items_cols]').attr('placeholder','1');
			}
			if(items_skin_mobile == '_slide') {
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_items_cols_slide_mobile?$_items_cols_slide_mobile:1.25?>');
			} else if(items_skin_mobile == '_gall') {
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_items_cols_gall_mobile?$_items_cols_gall_mobile:2?>');
			} else if(items_skin_mobile == '_wz') {
				$('input[name=items_cols_mobile]').attr('placeholder','1');
			}
			if(items_skin == '_wz' && items_skin_mobile == '_wz') {
				$('.itemsCols-label').hide();
			} else {
				$('.itemsCols-label').show();
				if(items_skin == '_wz') {
					$('input[name=items_cols]').attr("disabled",true);
				} else {
					$('input[name=items_cols]').removeAttr("disabled");					
				}
				if(items_skin_mobile == '_wz') {
					$('input[name=items_cols_mobile]').attr("disabled",true);
				} else {
					$('input[name=items_cols_mobile]').removeAttr("disabled"); 
				}
			}
		}
	} else if(type == 'itemuse') {
		if(items_skin == items_skin_mobile || !items_skin_mobile) {
			if(items_skin == '_slide') {
				$('input[name=items_cols]').attr('placeholder','<?=$_itemuse_cols_slide?$_itemuse_cols_slide:5?>');
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_itemuse_cols_slide_mobile?$_itemuse_cols_slide_mobile:2.25?>');
			} else if(items_skin == '_gall') {
				$('input[name=items_cols]').attr('placeholder','<?=$_itemuse_cols_gall?$_itemuse_cols_gall:4?>');
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_itemuse_cols_gall_mobile?$_itemuse_cols_gall_mobile:2?>');
			}
		} else {
			if(items_skin == '_slide') {
				$('input[name=items_cols]').attr('placeholder','<?=$_itemuse_cols_slide?$_itemuse_cols_slide:5?>');
			} else if(items_skin == '_gall') {
				$('input[name=items_cols]').attr('placeholder','<?=$_itemuse_cols_gall?$_itemuse_cols_gall:4?>');
			}
			if(items_skin_mobile == '_slide') {
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_itemuse_cols_slide_mobile?$_itemuse_cols_slide_mobile:2.25?>');
			} else if(items_skin_mobile == '_gall') {
				$('input[name=items_cols_mobile]').attr('placeholder','<?=$_itemuse_cols_gall_mobile?$_itemuse_cols_gall_mobile:2?>');
			}
		}
	}
}
//디폴트 값 (아이템 간격)
function _items_gap_placeholder(type) {
	if(type == 'banner') {
		$('input[name=items_gap]').attr('placeholder','<?=$_banner_gap?$_banner_gap:0?>');
		$('input[name=items_gap_mobile]').attr('placeholder','<?=$_banner_gap_mobile?$_banner_gap_mobile:0?>');
	} else if(type == 'item') {
		$('input[name=items_gap]').attr('placeholder','<?=$_items_gap?$_items_gap:30?>');
		$('input[name=items_gap_mobile]').attr('placeholder','<?=$_items_gap_mobile?$_items_gap_mobile:15?>');
	} else if(type == 'itemuse') {
		$('input[name=items_gap]').attr('placeholder','<?=$_itemuse_gap?$_itemuse_gap:30?>');
		$('input[name=items_gap_mobile]').attr('placeholder','<?=$_itemuse_gap_mobile?$_itemuse_gap_mobile:15?>');
	}
}



//타입 - 배너일때 옵션 출력
function _select_banner_option_push() {
	var optionContainer = $('#itemsOrderOptionSet'),
		pushOption = $('<?=$_push_banner_orderOption?>');
	
	optionContainer.empty();
	optionContainer.append(pushOption);
	_onoff('#items_order_option', 'list_of_select', '#btn_list_of_select', '#listCount');
	_btn_list_of_select_click();
	optionContainer.find('select').selectpicker('refresh');
	colorpicker(optionContainer.find('.colorpicker'));
	_items_cols_placeholder('banner');
	_items_gap_placeholder('banner');	
}

//타입 - 상품일때 옵션 출력
function _select_item_option_push() {
	var optionContainer = $('#itemsOrderOptionSet'),
		pushOption = $('<?=$_push_item_orderOption?>');

	optionContainer.empty();
	optionContainer.append(pushOption);
	_onoff('#items_order_option', 'list_of_select', '#btn_list_of_select', '#listCount', <?=$items_order_option[1]=='list_of_select'?'true':''?>);
	_onoff('#items_order_option2', 'list_of_select', '#btn_list_of_select', '#listCount', <?=$items_order_option[0]=='list_of_select'?'true':''?>);
	_btn_list_of_select_click();
	_sel_item_option_list_of_();
	optionContainer.find('select').selectpicker('refresh');
	_items_cols_placeholder('item', $('#items_skin').val(), $('#items_skin_mobile').val());
	_items_gap_placeholder('item');
	//matchOnOff('#items_skin', '_wz', '.itemsCols-label', 'hide');
	$('#label-item-outline, #label-item-shadow').show();
	$("#items_skin option[value='_wz'], #items_skin_mobile option[value='_wz']").prop('disabled',false);
	$('#items_skin, #items_skin_mobile').selectpicker('refresh');
}

//타입 - 상품카테고리일때 옵션 출력
function _select_shopCate_option_push() {
	var optionContainer = $('#itemsOrderOptionSet'),
		pushOption = $('<?=$_push_shopCate_orderOption?>');
	
	optionContainer.empty();
	optionContainer.append(pushOption);
}

//타입 - 상품후기일때 옵션 출력
function _select_itemuse_option_push() {
	var optionContainer = $('#itemsOrderOptionSet'),
		pushOption = $('<?=$_push_itemuse_orderOption?>');

	optionContainer.empty();
	optionContainer.append(pushOption);
	_onoff('#items_order_option', 'list_of_select', '#btn_list_of_select', '#listCount');
	_btn_list_of_select_click();
	//_sel_item_option_list_of_();
	optionContainer.find('select').selectpicker('refresh');
	_items_cols_placeholder('itemuse', $('#items_skin').val(), $('#items_skin_mobile').val());
	_items_gap_placeholder('itemuse');
	//matchOnOff('#items_skin', '_wz', '.itemsCols-label', 'hide');
	$('#label-item-outline, #label-item-shadow').hide();
	$("#items_skin option[value='_wz'], #items_skin_mobile option[value='_wz']").prop('disabled',true);
	$('#items_skin, #items_skin_mobile').selectpicker('refresh');
}

//타입 - 바로가기링크일때 옵션 출력
function _select_link_option_push() {
	var optionContainer = $('#linkOptionSet'),
		pushOption = $('<?=$_push_linkOption?>');
	
	optionContainer.empty();
	optionContainer.append(pushOption);
}

//타입 - 믹스형일때 옵션 출력
/*function _select_mix_option_push() {
	var optionContainer = $('#mixOptionSet'),
		pushOption = $('<?=$_push_mixOption?>');
	
	optionContainer.empty();
	optionContainer.append(pushOption);
}*/


function _sel_item_option_list_of_(el) {
	var item_orderOption_select = $('#items_order_option'),
		item_orderOption_select2 = $('#items_order_option2');
	
	if(item_orderOption_select.val() == 'list_of_select') {
		$('#items_order_option2 option:not(:selected)').attr('disabled', true);
		$('#items_order_option2').selectpicker('refresh');
		$('.dropdown-toggle[data-id="items_order_option2"] .filter-option').addClass('middleline');
	}
	if(item_orderOption_select2.val() == 'list_of_select') {
		$('#items_order_option option:not(:selected)').attr('disabled', true);
		$('#items_order_option').selectpicker('refresh');
		$('.dropdown-toggle[data-id="items_order_option"] .filter-option').addClass('middleline');
	}

	item_orderOption_select.change(function (){
		if($(this).val() == 'list_of_select') {
			$('#items_order_option2 option:not(:selected)').attr('disabled', true);			
			$('#items_order_option2').selectpicker('refresh');
			$('.dropdown-toggle[data-id="items_order_option2"] .filter-option').addClass('middleline');
		} else {
			$('#items_order_option2 option:not(:selected)').attr('disabled',false);			
			$('#items_order_option2').selectpicker('refresh');
			$('.dropdown-toggle[data-id="items_order_option2"] .filter-option').removeClass('middleline');
		}
	});
	item_orderOption_select2.change(function (){
		if($(this).val() == 'list_of_select') {
			$('#items_order_option option:not(:selected)').attr('disabled', true);			
			$('#items_order_option').selectpicker('refresh');
			$('.dropdown-toggle[data-id="items_order_option"] .filter-option').addClass('middleline');
		} else {
			$('#items_order_option option:not(:selected)').attr('disabled',false);			
			$('#items_order_option').selectpicker('refresh');
			$('.dropdown-toggle[data-id="items_order_option"] .filter-option').removeClass('middleline');
		}
	});
}

function _onoff(el, match, target, target2, has_show) {
	$(document).ready(function(){
		var val = $(el).val(),
			arrMatch = match.split(","),
			is_show = has_show ? true : false;
		for(var i in arrMatch) {
			if(val == arrMatch[i]) {				
				is_show = true;				
			}
		}
		if(is_show) {
			$(target).show();
			if(target2) $(target2).hide();			
		} else {
			$(target).hide();
			if(target2) $(target2).show();			
		}
		if(val == 'banner') 
			_select_banner_option_push();
		else if(val == 'item')
			_select_item_option_push();
		else if(val == 'shopCate')
			_select_shopCate_option_push();
		else if(val == 'itemuse')
			_select_itemuse_option_push();
		else if(val == 'link')
			_select_link_option_push();
		//else if(val == 'mix')
			//_select_mix_option_push();
	});

	$(el).change(function (){
		var val = $(this).val(),
			arrMatch = match.split(","),
			is_show = false;
		for(var i in arrMatch) {
			if(val == arrMatch[i]) {
				is_show = true;				
			}
		}
		if(is_show) {
			$(target).show();
			if(target2) $(target2).hide();
		} else {
			$(target).hide();
			if(target2) $(target2).show();			
		}
		if(val == 'banner') 
			_select_banner_option_push();
		else if(val == 'item')
			_select_item_option_push();
		else if(val == 'shopCate')
			_select_shopCate_option_push();
		else if(val == 'itemuse')
			_select_itemuse_option_push();
		else if(val == 'link')
			_select_link_option_push();
		//else if(val == 'mix')
			//_select_mix_option_push();
	});
}


//불러오기조건 - 직접선택시 팝업링크
function _btn_list_of_select_click() {
	var sel_li_count = $('#items_sel_li_count').val();
	if(sel_li_count) $('#btn_list_of_select').empty().append('<span class="count">' + sel_li_count + '개</span>').addClass('active');

	$('#btn_list_of_select').click(function() {
		var bl_type = $('#bl_type').val(),
			sel_li_id = $('#items_sel_li_id').val(),
			href = "<?=$_adm_url?>?pn=_shop_block_list_of_select&title=불러오기 선택&bl_type=" + bl_type + "&sel_li_id=" + sel_li_id,
			pop_width = bl_type == 'itemuse' ? 800 : 1350;
		window.open(href,'','width='+pop_width+',height=860,top=40,left=20,scrollbars=yes,toolbar=no,menubar=no,location=no,statusbar=no,status=no,resizable=yes');
		event.preventDefault();
	});
}


function mixTypeChange(val) {
	$.post("<?=$_mix_url?>" + val + "/_mix_form.php",{bl_cate:'<?=$bl_cate?>', bl_id:'<?=$bl_id?>'}, function(data) {
		$("#mix-form").html(data);
		//$("#mix-form select").selectpicker('refresh');	
	});
}


$(document).ready(function(){	
	let bl_type = $('#bl_type'),
		itemsOrderOption = $('#list-itemsOrderOptionSet'),
		blBanner_adm = $('#shop_banner_adm_btn'),
		blSkinContainer = $('#blSkinContainer'),
		blLinkSet = $('#blLinkSet'),
		blMixSet = $('#blMixSet');

	_onoff(bl_type, 'banner,item,itemuse,shopCate', itemsOrderOption);
	
	matchOnOff(bl_type, 'banner', blBanner_adm);
	matchOnOff(bl_type, 'mix', '#blImgSet, #blVideoSet', 'hide');
	matchOnOff(bl_type, 'item,itemuse', blSkinContainer);
	matchOnOff(bl_type, 'link', blLinkSet);
	matchOnOff(bl_type, 'mix', blMixSet);
		
	//디폴트값 변경
	_bl_padding_placeholder(bl_type.val());
	$(bl_type).change(function (){
		_bl_padding_placeholder($(this).val());
	});
	$("#bl_title, #bl_title_mobile").bind("keyup", function(event) {
		_bl_padding_placeholder(bl_type.val());
	});
	$("#bl_width").bind("keyup", function(event) {
		_bl_padding_placeholder(bl_type.val());
	});
	$("#bl_video_src").bind("keyup", function(event) {
		_bl_padding_placeholder(bl_type.val());
	});
	$('#items_skin').change(function (){
		_items_cols_placeholder(bl_type.val(), $(this).val(), $('#items_skin_mobile').val());
	});
	$('#items_skin_mobile').change(function (){
		_items_cols_placeholder(bl_type.val(), $('#items_skin').val(), $(this).val());
	});
	

	$('select.bl_link_type').change(function (){
		var val = $(this).val(),
			tg = $(this).closest('li').find('.linkformSet');
		if(val) {
			$(tg).hide();
		} else {
			$(tg).show();
		}
	});

	$('#bl_title_align, #bl_title_mobile_align').change(function (){
		var val = $(this).val(),
			tg = $(this).parent().parent().find('textarea');
		$(tg).css({'text-align':val});
	});

	mixTypeChange($('#mix_type').val());
	
});

$('#mix_type').change(function (){
	var val = $(this).val();
	mixTypeChange(val);
});

///////////////////////////////////////////////////////////////////////////////////////////////////



var captcha_chk = false;

function use_captcha_check(){
    $.ajax({
        type: "POST",
        url: g5_admin_url+"/ajax.use_captcha.php",
        data: { admin_use_captcha: "1" },
        cache: false,
        async: false,
        dataType: "json",
        success: function(data) {
        }
    });
}

function frm_check_file(){
    var bl_include_head = "<?php echo $shopblock['bl_include_head']; ?>";
    var bl_include_tail = "<?php echo $shopblock['bl_include_tail']; ?>";
    var head = jQuery.trim(jQuery("#bl_include_head").val());
    var tail = jQuery.trim(jQuery("#bl_include_tail").val());

    if(bl_include_head !== head || bl_include_tail !== tail){
        // 캡챠를 사용합니다.
        jQuery("#admin_captcha_box").show();
        captcha_chk = true;

        use_captcha_check();

        return false;
    } else {
        jQuery("#admin_captcha_box").hide();
    }

    return true;
}

jQuery(function($){
    if( window.self !== window.top ){   // frame 또는 iframe을 사용할 경우 체크
        $("#bl_include_head, #bl_include_tail").on("change paste keyup", function(e) {
            frm_check_file();
        });

        use_captcha_check();
    }
});

function frmcontentform_check(f)
{
    errmsg = "";
    errfld = "";

    <?php echo get_editor_js('bl_content'); ?>
    <?php echo chk_editor_js('bl_content'); ?>
    <?php echo get_editor_js('bl_mobile_content'); ?>

    check_field(f.bl_id, "ID를 입력하세요.");
    check_field(f.bl_subject, "제목을 입력하세요.");
    check_field(f.bl_content, "내용을 입력하세요.");

    if (errmsg != "") {
        alert(errmsg);
        errfld.focus();
        return false;
    }
    
    if( captcha_chk ) {
        <?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>
    }

    return true;
}
</script>
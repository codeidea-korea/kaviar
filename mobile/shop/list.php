<?php
include_once('./_common.php');

// 상품 리스트에서 다른 필드로 정렬을 하려면 아래의 배열 코드에서 해당 필드를 추가하세요.
/*if( isset($sort) && ! in_array($sort, array('it_name', 'it_sum_qty', 'it_price', 'it_use_avg', 'it_use_cnt', 'it_update_time', 'it_real_price')) ){
    $sort='';
}*/

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
$ca = sql_fetch($sql);
if (!$ca['ca_id'] && $ca_id != 'all') alert('등록된 분류가 없습니다.', G5_SHOP_URL);

// 테마미리보기 스킨 등의 변수 재설정
if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    $ca['ca_mobile_skin']       = (isset($tconfig['ca_mobile_skin']) && $tconfig['ca_mobile_skin']) ? $tconfig['ca_mobile_skin'] : $ca['ca_mobile_skin'];
    $ca['ca_mobile_img_width']  = (isset($tconfig['ca_mobile_img_width']) && $tconfig['ca_mobile_img_width']) ? $tconfig['ca_mobile_img_width'] : $ca['ca_mobile_img_width'];
    $ca['ca_mobile_img_height'] = (isset($tconfig['ca_mobile_img_height']) && $tconfig['ca_mobile_img_height']) ? $tconfig['ca_mobile_img_height'] : $ca['ca_mobile_img_height'];
    $ca['ca_mobile_list_mod']   = (isset($tconfig['ca_mobile_list_mod']) && $tconfig['ca_mobile_list_mod']) ? $tconfig['ca_mobile_list_mod'] : $ca['ca_mobile_list_mod'];
    $ca['ca_mobile_list_row']   = (isset($tconfig['ca_mobile_list_row']) && $tconfig['ca_mobile_list_row']) ? $tconfig['ca_mobile_list_row'] : $ca['ca_mobile_list_row'];
}

// 본인인증, 성인인증체크
if(!$is_admin) {
    $msg = shop_member_cert_check($ca_id, 'list');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

$g5['title'] = $ca_id == 'all' ? '전체 상품리스트' : $ca['ca_name'].' 상품리스트';

include_once(G5_MSHOP_PATH.'/_head.php');

//상단에 상품 카테고리 출력
echo get_shopCate_list("slide|auto|12", $img=false, $all=true, $class="shopCate-tags p15 pb0");

// 스킨경로
$skin_dir = G5_MSHOP_SKIN_PATH;

if($ca['ca_mobile_skin_dir']) {
    if(preg_match('#^theme/(.+)$#', $ca['ca_mobile_skin_dir'], $match))
        $skin_dir = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_mobile_skin_dir'];

    if(is_dir($skin_dir)) {
        $skin_file = $skin_dir.'/'.$ca['ca_mobile_skin'];

        if(!is_file($skin_file))
            $skin_dir = G5_MSHOP_SKIN_PATH;
    } else {
        $skin_dir = G5_MSHOP_SKIN_PATH;
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

echo '<script>var g5_shop_url = "'.G5_SHOP_URL.'";</script>';
echo '<script src="'.G5_JS_URL.'/shop.mobile.list.js"></script>';


// 상품 목록 시작 ─────────────────────────────────────────────────────────────────────────────────────────────────
echo '<div id="sct">';

    // 상단 HTML
    if($ca['ca_mobile_head_html']) echo '<div id="sct_hhtml" class="_hhtml">'.conv_content($ca['ca_mobile_head_html'], 1).'</div>';

    /*
	$cate_skin = $skin_dir.'/listcategory.skin.php';
    if(!is_file($cate_skin)) $cate_skin = G5_MSHOP_SKIN_PATH.'/listcategory.skin.php';
    include $cate_skin;
	*/

    // 테마미리보기 베스트상품 재설정
    if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
        if(isset($theme_config['ca_mobile_list_best_mod']))
            $theme_config['ca_mobile_list_best_mod'] = (isset($tconfig['ca_mobile_list_best_mod']) && $tconfig['ca_mobile_list_best_mod']) ? $tconfig['ca_mobile_list_best_mod'] : 0;
        if(isset($theme_config['ca_mobile_list_best_row']))
            $theme_config['ca_mobile_list_best_row'] = (isset($tconfig['ca_mobile_list_best_row']) && $tconfig['ca_mobile_list_best_row']) ? $tconfig['ca_mobile_list_best_row'] : 0;
    }

    // 분류 Best Item
    /*$list_mod = (isset($theme_config['ca_mobile_list_best_mod']) && $theme_config['ca_mobile_list_best_mod']) ? (int)$theme_config['ca_mobile_list_best_mod'] : $ca['ca_mobile_list_mod'];
    $list_row = (isset($theme_config['ca_mobile_list_best_row']) && $theme_config['ca_mobile_list_best_row']) ? (int)$theme_config['ca_mobile_list_best_row'] : $ca['ca_mobile_list_row'];
    $limit = $list_mod * $list_row;
    $best_skin = G5_MSHOP_SKIN_PATH.'/list.best.10.skin.php';
	
    $sql = " select *
                from {$g5['g5_shop_item_table']}
                where ( ca_id like '$ca_id%' or ca_id2 like '$ca_id%' or ca_id3 like '$ca_id%' )
                  and it_use = '1'
                  and it_type4 = '1'
                order by it_order, it_id desc
                limit 0, $limit ";

    $list = new item_list($best_skin, $list_mod, $list_row, $ca['ca_mobile_img_width'], $ca['ca_mobile_img_height']);
    $list->set_query($sql);
    $list->set_mobile(true);
    $list->set_view('it_img', true);
    $list->set_view('it_id', false);
    $list->set_view('it_name', true);
    $list->set_view('it_price', true);
    echo $list->run();*/

    // 상품 출력순서가 있다면
    if ($sort != "")
        $order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
    else
        $order_by = 'it_order, it_id desc';

    $error = '<p class="sct_noitem">등록된 상품이 없습니다.</p>';

    // 리스트 스킨
	$ca['ca_mobile_skin'] = $ca['ca_mobile_skin'] ? $ca['ca_mobile_skin'] : 'list.10.skin.php';
    $skin_file = is_include_path_check($skin_dir.'/'.$ca['ca_mobile_skin']) ? $skin_dir.'/'.$ca['ca_mobile_skin'] : $skin_dir.'/list.10.skin.php';

    if (file_exists($skin_file)) {
        echo '<div id="_itemSort">';
			$sort_skin = $skin_dir.'/list.sort.skin.php';
			if(!is_file($sort_skin)) $sort_skin = G5_MSHOP_SKIN_PATH.'/list.sort.skin.php';
			include $sort_skin;    
			 // 상품 보기 타입 변경 버튼
			/*$sub_skin = $skin_dir.'/list.sub.skin.php';
			if(!is_file($sub_skin)) $sub_skin = G5_MSHOP_SKIN_PATH.'/list.sub.skin.php';
			if(is_file($sub_skin)) include $sub_skin;*/
        echo '</div>';

		// 한페이지에 출력하는 이미지수 = $list_mod * $list_row
		$ca['ca_mobile_list_mod'] = $ca_id == 'all' ? 2 : $ca['ca_mobile_list_mod'];
		$ca['ca_mobile_list_row'] = $ca_id == 'all' ? 10 : $ca['ca_mobile_list_row'];
		$ca['ca_mobile_img_width'] = $ca_id == 'all' ? 320 : $ca['ca_mobile_img_width'];
		$ca['ca_mobile_img_height'] = $ca_id == 'all' ? 320 : $ca['ca_mobile_img_height'];

        // 총몇개
        $items = $ca['ca_mobile_list_mod'] * $ca['ca_mobile_list_row'];
        // 페이지가 없으면 첫 페이지 (1 페이지)
        if ($page < 1) $page = 1;
        // 시작 레코드 구함
        $from_record = ($page - 1) * $items;

        $list = new item_list($skin_file, $ca['ca_mobile_list_mod'], $ca['ca_mobile_list_row'], $ca['ca_mobile_img_width'], $ca['ca_mobile_img_height']);
		if($ca_id != 'all') {
			$list->set_category($ca['ca_id'], 1);
			$list->set_category($ca['ca_id'], 2);
			$list->set_category($ca['ca_id'], 3);
		}
        $list->set_is_page(true);
        $list->set_mobile(true);
		$list->set_list_mod($ca['ca_mobile_list_mod']);
		$list->set_list_row($ca['ca_mobile_list_row']);
        $list->set_order_by($order_by);
		$list->set_is_page(true);
        $list->set_from_record($from_record);
        $list->set_view('it_img', true);
        $list->set_view('it_id', false);
        $list->set_view('it_name', true);
        $list->set_view('it_price', true);
        $list->set_view('sns', true);
        $list->set_view('it_icon', true);
		$list->set_view('it_star_score', true);
        echo $list->run();

        // where 된 전체 상품수
        $total_count = $list->total_count;
		// 전체 페이지 계산
		$total_page  = ceil($total_count / $items);
    } else {
        echo '<div class="sct_nofile">'.str_replace(G5_PATH.'/', '', $skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
    }
	
	$qstr .= '&amp;ca_id='.$ca_id.'&amp;sort='.$sort.($sortodr?'&amp;sortodr='.$sortodr:'');
	echo get_paging($config['cf_mobile_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");

    /*$qstr1 = '';
    if($i > 0 && $total_count > $items) {
        $qstr1 .= 'ca_id='.$ca_id;
        $qstr1 .='&sort='.$sort.'&sortodr='.$sortodr;
        $ajax_url = G5_SHOP_URL.'/ajax.list.php?'.$qstr1.'&use_sns=1';
		echo '<div class="li_more">';
        echo '<p id="item_load_msg"><img src="'.G5_SHOP_CSS_URL.'/img/loading.gif" alt="로딩이미지" ><br>잠시만 기다려주세요.</p>';
        echo '<div class="li_more_btn">';
        echo '<button type="button" id="btn_more_item" data-url="'.$ajax_url.'" data-page="'.page.'">더보기 +</button>';
        echo '</div>';
		echo '</div>';
    }*/

    // 하단 HTML
    if($ca['ca_mobile_tail_html']) echo '<div id="sct_thtml" class="_thtml">'.conv_content($ca['ca_mobile_tail_html'], 1).'</div>';

echo '</div>';

include_once(G5_MSHOP_PATH.'/_tail.php');

echo "\n<!-- {$ca['ca_mobile_skin']} -->\n";
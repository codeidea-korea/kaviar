<?php
include_once('./_common.php');

$sql = " select * from {$g5['g5_shop_category_table']} where ca_id = '$ca_id' and ca_use = '1'  ";
$ca = sql_fetch($sql);
//if (!$ca['ca_id'] && $ca_id != 'all') alert('등록된 분류가 없습니다.', G5_SHOP_URL);

// 테마미리보기 스킨 등의 변수 재설정
if(defined('_THEME_PREVIEW_') && _THEME_PREVIEW_ === true) {
    $ca['ca_skin']       = (isset($tconfig['ca_skin']) && $tconfig['ca_skin']) ? $tconfig['ca_skin'] : $ca['ca_skin'];
    $ca['ca_img_width']  = (isset($tconfig['ca_img_width']) && $tconfig['ca_img_width']) ? $tconfig['ca_img_width'] : $ca['ca_img_width'];
    $ca['ca_img_height'] = (isset($tconfig['ca_img_height']) && $tconfig['ca_img_height']) ? $tconfig['ca_img_height'] : $ca['ca_img_height'];
    $ca['ca_list_mod']   = (isset($tconfig['ca_list_mod']) && $tconfig['ca_list_mod']) ? $tconfig['ca_list_mod'] : $ca['ca_list_mod'];
    $ca['ca_list_row']   = (isset($tconfig['ca_list_row']) && $tconfig['ca_list_row']) ? $tconfig['ca_list_row'] : $ca['ca_list_row'];
}

// 본인인증, 성인인증체크
if(!$is_admin && $config['cf_cert_use']) {
    $msg = shop_member_cert_check($ca_id, 'list');
    if($msg)
        alert($msg, G5_SHOP_URL);
}

$g5['title'] = $ca_id == 'all' || !$ca_id ? '전체 상품리스트' : $ca['ca_name'].' 상품리스트';

if ($ca['ca_include_head'] && is_include_path_check($ca['ca_include_head']))
    @include_once($ca['ca_include_head']);
else
    include_once(G5_SHOP_PATH.'/_head.php');

// 스킨경로
$skin_dir = G5_SHOP_SKIN_PATH;

if($ca['ca_skin_dir']) {
    if(preg_match('#^theme/(.+)$#', $ca['ca_skin_dir'], $match))
        $skin_dir = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/shop/'.$match[1];
    else
        $skin_dir = G5_PATH.'/'.G5_SKIN_DIR.'/shop/'.$ca['ca_skin_dir'];

    if(is_dir($skin_dir)) {
        $skin_file = $skin_dir.'/'.$ca['ca_skin'];

        if(!is_file($skin_file))
            $skin_dir = G5_SHOP_SKIN_PATH;
    } else {
        $skin_dir = G5_SHOP_SKIN_PATH;
    }
}

define('G5_SHOP_CSS_URL', str_replace(G5_PATH, G5_URL, $skin_dir));

if ($is_admin)
    echo '<div class="sct_admin2"><a href="'.G5_ADMIN_URL.'/shop_admin/categoryform.php?w=u&amp;ca_id='.$ca_id.'" class="btnSetting" style="position:absolute;bottom:15px;left:15px;z-index:99999" data-area="#sct">분류관리</a></div>';
?>

<script>
var itemlist_ca_id = "<?php echo $ca_id; ?>";
</script>
<script src="<?php echo G5_JS_URL; ?>/shop.list.js"></script>


<div id="_sct" class="max-width">
	
	<?php include_once(G5_LIB_PATH.'/my/shop_block.lib.php'); ?>
	<article id="shopblock">
		<?php if($is_shop_manager) {
			echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=_list&title=쇼핑몰 페이지 관리" id="shopIndexSetting" class="btnSetting popWin" style="margin-left:-50px;" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">쇼핑몰 페이지 관리</a>';
		} ?>
		<?=shop_block('_list')?>
	</article>
	
	<div id="_sct_header" class="">
		<?php if(!G5_IS_MOBILE) echo '<div class="title">전체상품</div>'; ?>
		<?php		
		if(G5_IS_MOBILE) {
			echo '<div class="mtop">';
				$sort_skin = G5_MSHOP_SKIN_PATH.'/list.sort.skin.php';
				include $sort_skin;
				echo '<span id="_item_filter_opner">필터</span>';
			echo '</div>';
		}


		$str = '';
		$exists = false;

		$ca_id_len = strlen(20);
		$len2 = $ca_id_len + 2;
		$len4 = $ca_id_len + 4;

		$sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '10%' and length(ca_id) = $len2 and ca_use = '1' order by ca_order, ca_id ";


		
		$result = sql_query($sql);
		while ($row=sql_fetch_array($result)) {

			$row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");

			//$str .= '<li><a href="'.shop_category_url($row['ca_id']).'" class="'.($ca_id==$row['ca_id']?'active':'').'">'.$row['ca_name'].'<span class="count">'.$row2['cnt'].'</span></a></li>';

			$str .= '<li class="swiper-slide"><a href="'.shop_category_url($row['ca_id'],"ca_id2=".$ca_id2."&price=".$price."&tags=".$tags).'" class="'.($ca_id==$row['ca_id']?'active':'').'">'.$row['ca_name'].'</a></li>';

			//$str .= '<li class="swiper-slide"><a href="#" onclick="top_filter(\''.$row['ca_id'].'\','.$row['ca_id'].',\''.$ca_id.'\',\''.$price.'\',\''.$tags.'\')" class="'.($ca_id==$row['ca_id']?'active':'').'">'.$row['ca_name'].'</a></li>';
			$exists = true;
		}

		if ($exists) {
			if(!G5_IS_MOBILE) {
				echo '<div id="_sct_sortContainer">';
					echo '<ul id="_sct_cate">';
						echo '<li class="swiper-slide"><a href="'.shop_category_url('all',"ca_id2=".$ca_id2."&price=".$price."&tags=".$tags).'" class="'.(!$ca_id || $ca_id=='all'?'active':'').'">전체보기</a></li>';
						echo $str;
					echo '</ul>';					
					$filter_reset_url = shop_category_url($ca_id);
					include_once(G5_THEME_SHOP_PATH.'/_items_filter.php');
				echo '</div>';
			} else {
				echo '<div id="_sct_cate" class="mySwiper" data-per="auto" data-gap="10" data-loop="false">';
					echo '<div class="swiper-container">';
						echo '<ul class="swiper-wrapper">';
							echo '<li class="swiper-slide"><a href="'.shop_category_url('all').'" class="'.(!$ca_id || $ca_id=='all'?'active':'').'">전체보기</a></li>';
							echo $str;
						echo '</ul>';
					echo '</div>';
				echo '</div>';
			}
		}		
		?>
	</div>
<script>
function top_filter(ca1,ca2,ca2_ori,number,tags){
	
	var cat;
	var arrValues = new Array();
	var set1;
	
	if(number === undefined ) {
		number = "";
	}

	if(tags === undefined ) {
		tags = "";
	}

	if (ca2_ori.match(ca2)) {

		var arr = ca2_ori.split("_");
		//arr.push(''+ca2+'');

		//자른걸 배열에 담는다.
		let filtered = arr.filter((element) => element !== ''+ca2+'');

		if(filtered.length > 1){
			
			for(var i=0; i<filtered.length; i++) {
				if(i==0){
					cat = filtered[i];
				}else{
					cat = cat + "_" + filtered[i];
				}
			}

		}else{
			cat = filtered[0];
		}

	}else{
		
		if(ca2_ori){
		
			cat = ca2_ori+"_"+ca2;
		}else{
			
			cat = ca2;
		}

	}

	if(cat === undefined ) {
		cat = "";
	}


	
	const urlParams = new URLSearchParams(window.location.search);

	if(urlParams.has('price')) {

		urlParams.delete('price');
			
					
		$.ajax({
		  url:"./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number+"&tags="+tags,
		  type:'get',
		  
		  cache: false,
		  async: false,
		  dataType : 'html',
		  success: function(res) {
				//$('#Context').html(data);
				/*
				if(!res.error){
					alert("쿠폰이 등록되었습니다");
				}else{
					alert(res.error);
				}*/
				console.log(res);
				$("#root").html(res);
			}
		});

		//location.href="./list.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number+"&tags="+tags;
	}else{
		
		
		$.ajax({
		  url:"./list.php?ca_id="+ca1+"&ca_id2=&price="+number+"&tags="+tags,
		  type:'get',
		  
		  cache: false,
		  async: false,
		  dataType : 'html',
		  success: function(res) {
				//$('#Context').html(data);
				/*
				if(!res.error){
					alert("쿠폰이 등록되었습니다");
				}else{
					alert(res.error);
				}*/
				console.log(res);
				//$("#root").html(res);
				location.href="./list.php?ca_id="+ca1+"&ca_id2=&price="+number+"&tags="+tags;
			}
		});

	}

}
</script>
	<div id="_sct_inner">
		
		<?php		
		if(!G5_IS_MOBILE) {
			//$filter_reset_url = shop_category_url($ca_id);
			//include(G5_THEME_SHOP_PATH.'/_items_filter.php');
		} else {
			$filter_reset_url = shop_category_url($ca_id);
			include_once(G5_THEME_SHOP_PATH.'/_items_filter_mobile.php');
		}
		?>
	
		<div id="_sctCon">
			<?php
			/*$nav_skin = $skin_dir.'/navigation.skin.php';
			if(!is_file($nav_skin))
				$nav_skin = G5_SHOP_SKIN_PATH.'/navigation.skin.php';
			include $nav_skin;*/

			// 상단 HTML
			echo '<div id="sct_hhtml">'.conv_content($ca['ca_head_html'], 1).'</div>';

			
			/*$cate_skin = $skin_dir.'/listcategory.skin.php';
			if(!is_file($cate_skin))
				$cate_skin = G5_SHOP_SKIN_PATH.'/listcategory.skin.php';
			include $cate_skin;*/

			// 상품 출력순서가 있다면
			if ($sort != "")
				$order_by = $sort.' '.$sortodr.' , it_order, it_id desc';
			else
				$order_by = 'it_soldout asc, it_order desc, it_update_time desc';

			$error = '<p class="sct_noitem">등록된 상품이 없습니다.</p>';

			// 리스트 스킨
			$ca['ca_skin'] = $ca['ca_skin'] ? $ca['ca_skin'] : 'list.10.skin.php';
			$skin_file = is_include_path_check($skin_dir.'/'.$ca['ca_skin']) ? $skin_dir.'/'.$ca['ca_skin'] : $skin_dir.'/list.10.skin.php';

			if (file_exists($skin_file)) {
				
				if(!G5_IS_MOBILE) {
					$sort_skin = $skin_dir.'/list.sort.skin.php';
					if(!is_file($sort_skin))
						$sort_skin = G5_SHOP_SKIN_PATH.'/list.sort.skin.php';
					include $sort_skin;
				}

				// 한페이지에 출력하는 이미지수 = $list_mod * $list_row
				if(!G5_IS_MOBILE) {
					$ca_list_mod = !$ca_id || $ca_id == 'all' ? 5 : $ca['ca_list_mod'];
					$ca_list_row = !$ca_id || $ca_id == 'all' ? 10 : $ca['ca_list_row'];
					$ca_img_width = !$ca_id || $ca_id == 'all' ? 340 : $ca['ca_img_width'];
					$ca_img_height = !$ca_id || $ca_id == 'all' ? 340 : $ca['ca_img_height'];
				} else {
					
					$ca_list_mod = $ca_id == 'all' ? 2 : $ca['ca_mobile_list_mod'];
					$ca_list_row = $ca_id == 'all' ? 10 : $ca['ca_mobile_list_row'];
					$ca_img_width = $ca_id == 'all' ? 340 : $ca['ca_mobile_img_width'];
					$ca_img_height = $ca_id == 'all' ? 340 : $ca['ca_mobile_img_height'];
				}

				// 총몇개 = 한줄에 몇개 * 몇줄
				//$items = $ca['ca_list_mod'] * $ca['ca_list_row'];
				if(G5_IS_MOBILE){
					$items = 20;
				}else{
					$items = 40;
					//$items = $ca_list_mod * $ca_list_row;
				}
				//$items = 40;
			
				// 페이지가 없으면 첫 페이지 (1 페이지)
				if ($page < 1) $page = 1;
				// 시작 레코드 구함
				$from_record = ($page - 1) * $items;

/*
				if($_SERVER['REMOTE_ADDR'] == "125.246.29.210"){
					echo "<br> items ".$items;
					echo "<br>".$ca_list_mod." ".$ca_list_row."<br>";
					echo "page ".$page."<br>";
					echo "items ".$items."<br>";
					echo "<br>from_record ".$from_record."<br>";
			}*/	

				$list = new item_list($skin_file, $ca_list_mod, $ca_list_row, $ca_img_width, $ca_img_height);
				if($ca_id != 'all') {
					$list->set_category($ca['ca_id'], 1);
					$list->set_category($ca_id2, 2);
					$list->set_category($ca['ca_id'], 3);
				}
				/*$ca_id_arr = $ca['ca_id']!='all' && $ca['ca_id'] ? $ca['ca_id'] : '';
				$ca_id_arr .= $ca_id_arr && $ca_id2 ? ','.$ca_id2 : '';
				
				$list->set_category($ca['ca_id'].','.$ca_id2, 2);
				$list->set_category($ca['ca_id'].','.$ca_id2, 3);
				$list->set_category($ca['ca_id2'].','.$ca_id2, 1);*/
				$list->set_is_page(true);
				$list->set_order_by($order_by);
				$list->set_from_record($from_record);
				$list->set_view('it_img', true);
				$list->set_view('it_id', false);
				$list->set_view('it_name', true);
				$list->set_view('it_basic', true);
				$list->set_view('it_cust_price', true);
				$list->set_view('it_price', true);
				$list->set_view('it_icon', true);
				$list->set_view('popular', true);
				$list->set_view('sns', true);
				$list->set_view('it_star_score', true);

				
				echo $list->run();

				// where 된 전체 상품수
				
				$total_count = $list->total_count;
				// 전체 페이지 계산
				$total_page  = ceil($total_count / $items);
			} else {
				echo '<div class="sct_nofile">'.str_replace(G5_PATH.'/', '', $skin_file).' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
			}

			$qstr1 = 'ca_id='.$ca_id;
			$qstr1 .='&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
			
			//echo $config['cf_write_pages']." / ".$total_count." / ".$page." / ".$total_page." / ".$_SERVER['SCRIPT_NAME'];
			echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr1.'&amp;page=');
			
			

			
			// 하단 HTML
			echo '<div id="sct_thtml">'.conv_content($ca['ca_tail_html'], 1).'</div>';

			?>
		</div>

</div>


<?php
if ($ca['ca_include_tail'] && is_include_path_check($ca['ca_include_tail']))
    @include_once($ca['ca_include_tail']);
else
    include_once(G5_SHOP_PATH.'/_tail.php');
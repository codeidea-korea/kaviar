<?php
include_once('./_common.php');

$sql = " select * from {$g5['g5_shop_event_table']}
          where ev_id = '$ev_id'
            and ev_use = 1 ";
$ev = sql_fetch($sql);
/*if (! (isset($ev['ev_id']) && $ev['ev_id']))
    alert('등록된 이벤트가 없습니다.');*/

$g5['title'] = $ev['ev_subject'];
include_once('./_head.php');

if ($is_admin)
    echo '<div class="sev_admin"><a href="'.G5_ADMIN_URL.'/shop_admin/itemeventform.php?w=u&amp;ev_id='.$ev['ev_id'].'" class="btnSetting" target="_blank" style="position:absolute;bottom:15px;left:15px;z-index:99999" data-area="#sct">이벤트 관리</a></div>';
?>

<script>
var itemlist_ca_id = "<?php echo $ev_id; ?>";
</script>
<script src="<?php echo G5_JS_URL; ?>/shop.list.js"></script>


<div id="_ev" class="max-width">
	
	<?php include_once(G5_LIB_PATH.'/my/shop_block.lib.php'); ?>
	<article id="shopblock">
		<?php if($is_shop_manager) {
			echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=_event&title=쇼핑몰 페이지 관리" id="shopIndexSetting" class="btnSetting popWin" style="margin-left:-50px;" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">쇼핑몰 페이지 관리</a>';
		} ?>
		<?=shop_block('_event')?>
	</article>
	
	<div id="_sct_header" class="none">
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
				  url:"./event.php?ca_id="+ca1+"&ca_id2="+cat+"&price="+number+"&tags="+tags,
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
				  url:"./event.php?ca_id="+ca1+"&ca_id2=&price="+number+"&tags="+tags,
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
						location.href="./event.php?ca_id="+ca1+"&ca_id2=&price="+number+"&tags="+tags;
					}
				});

			}

		}
	</script>
<?if(G5_IS_MOBILE){?>
	<style>
		.title {font-size:22px;font-weight:bold;text-align:center}
		#_ev_inner { padding-left: 15px; padding-right: 15px; }
	</style>
<?}?>
	<div id="_ev_title" style="padding-bottom:25px;">
		<div class="title" ><?=$ev['ev_subject']?></div>
	</div>
	
	<div id="_ev_inner">
		
		<?php
		$filter_reset_url = shop_category_url($ca_id);
		if(!G5_IS_MOBILE) {
			//include_once(G5_THEME_SHOP_PATH.'/_items_filter.php');
		} else {
			//include_once(G5_THEME_SHOP_PATH.'/_items_filter_mobile.php');
		}
		?>
		
		
		
		<div id="_evCon">
			<?php

			// 상품 출력순서가 있다면
			if ($sort != "")
				$order_by = $sort.' '.$sortodr.' , b.it_order, b.it_id desc';
			else
				$order_by = 'b.it_order, b.it_id desc';

			if ($skin) {
				$skin = preg_replace('#\.+(\/|\\\)#', '', $skin);
				$ev['ev_skin'] = $skin;
			}

			define('G5_SHOP_CSS_URL', G5_SHOP_SKIN_URL);

			// 리스트 유형별로 출력
			$list_file = G5_SHOP_SKIN_PATH."/{$ev['ev_skin']}";
			if (file_exists($list_file)) {
				
				if(!G5_IS_MOBILE) {
					include G5_SHOP_SKIN_PATH.'/list.sort.skin.php';
				}

				// 총몇개 = 한줄에 몇개 * 몇줄
				$items = $ev['ev_list_mod'] * $ev['ev_list_row'];
				// 페이지가 없으면 첫 페이지 (1 페이지)
				if ($page < 1) $page = 1;
				// 시작 레코드 구함
				$from_record = ($page - 1) * $items;
				if(G5_IS_MOBILE){
					$list_mod = $ev['ev_mobile_list_mod'];
					$list_row = $ev['ev_mobile_list_row'];
					$list_width = $ev['ev_mobile_img_width'];
					$list_height = $ev['ev_mobile_img_height'];
				}else{
					$list_row = $ev['ev_list_row'];
					$list_mod = $ev['ev_list_mod'];
					$list_width = $ev['ev_img_width'];
					$list_height = $ev['ev_img_height'];
				}
				$list = new item_list(G5_SHOP_SKIN_PATH.'/'.$ev['ev_skin'], $list_mod, $list_row, $list_width, $list_height);
				if($ca_id != 'all') {
					$list->set_category($ev['ca_id'], 1);
					$list->set_category($ca_id2, 2);
					$list->set_category($ev['ca_id'], 3);
				}
				$list->set_event($ev['ev_id']);
				$list->set_is_page(true);
				$list->set_order_by($order_by);
				$list->set_from_record($from_record);
				$list->set_view('it_img', true);
				$list->set_view('it_id', false);
				$list->set_view('it_name', true);
				$list->set_view('it_cust_price', false);
				$list->set_view('it_price', true);
				$list->set_view('it_icon', true);
				$list->set_view('sns', true);
				echo $list->run();

				// where 된 전체 상품수
				$total_count = $list->total_count;
				// 전체 페이지 계산
				$total_page  = ceil($total_count / $items);
			} else {
				echo '<div align="center">'.$ev['ev_skin'].' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</div>';
			}

			$qstr .= 'skin='.$skin.'&amp;ev_id='.$ev_id.'&amp;sort='.$sort.'&amp;sortodr='.$sortodr;
			echo get_paging($config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");
			
			// 하단 HTML
			echo '<div id="sev_thtml">'.conv_content($ev['ev_tail_html'], 1).'</div>';

			$timg = G5_DATA_PATH.'/event/'.$ev_id.'_t';
			if (file_exists($timg))
				echo '<div id="sev_timg" class="sev_img"><img src="'.G5_DATA_URL.'/event/'.$ev_id.'_t" alt=""></div>';
			?>
		</div>

	</div>

</div>

<?php
include_once('./_tail.php');
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
	
	<?php
	$himg = G5_DATA_PATH.'/event/'.$ev_id.'_h';
	if (file_exists($himg))
		echo '<div id="sev_himg" class="sev_img"><img src="'.G5_DATA_URL.'/event/'.$ev_id.'_h" alt=""></div>';

	// 상단 HTML
	echo '<div id="sev_hhtml">'.conv_content($ev['ev_head_html'], 1).'</div>';
	?>

	<?php		
	if(G5_IS_MOBILE) {
		echo '<div class="mtop">';
			$sort_skin = G5_MSHOP_SKIN_PATH.'/list.sort.skin.php';
			include $sort_skin;
			echo '<span id="_item_filter_opner">필터</span>';
		echo '</div>';
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
			$str .= '<li class="swiper-slide"><a href="'.shop_short_url_my('event', $ev_id, 'ca_id='.$row['ca_id']).'" class="'.($ca_id==$row['ca_id']?'active':'').'">'.$row['ca_name'].'</a></li>';
			$exists = true;
		}

		if ($exists) {
			echo '<div id="_sct_cate" class="mySwiper" data-per="auto" data-gap="10" data-loop="false">';
				echo '<div class="swiper-container">';
					echo '<ul class="swiper-wrapper">';
						echo '<li class="swiper-slide"><a href="'.shop_short_url_my('event', $ev_id, 'ca_id=all').'" class="'.(!$ca_id || $ca_id=='all'?'active':'').'">전체보기</a></li>';
						echo $str;
					echo '</ul>';
				echo '</div>';
			echo '</div>';
		}
	}
	?>

	<div id="_ev_inner">
		
		<?php
		$filter_reset_url = shop_category_url($ca_id);
		if(!G5_IS_MOBILE) {
			include_once(G5_THEME_SHOP_PATH.'/_items_filter.php');
		} else {
			include_once(G5_THEME_SHOP_PATH.'/_items_filter_mobile.php');
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

				$list = new item_list(G5_SHOP_SKIN_PATH.'/'.$ev['ev_skin'], $ev['ev_list_mod'], $ev['ev_list_row'], $ev['ev_img_width'], $ev['ev_img_height']);
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
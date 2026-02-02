<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');
if (!defined('_SHOP_COMMON_')) exit; // 모바일 페이지로 직접 접근하는 것을 막음

$g5['title'] = $ev['ev_subject'];
include_once('./_head.php');


$sql_common = " from {$g5['g5_shop_event_table']} where ev_use = 1";
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$sql = "select * {$sql_common} order by ev_order < 0, ev_order = 0, ev_order, ev_id desc ";
$result = sql_query($sql);

echo '<div id="_event_main" class="max-width">';
	if($is_admin) echo '<a href="'.G5_ADMIN_URL.'/shop_admin/itemevent.php" class="btnSetting _blank" target="_blank" data-area="#_event_main">이벤트 관리</a>';
	echo '<ul id="_event_main_ul">';
		for ($i=0; $row=sql_fetch_array($result); $i++) {
			$list_str = '';
			$mimg = G5_DATA_PATH.'/event/'.$row['ev_id'].'_m';
			if (file_exists($mimg)) {
				$list_str = '<img src="'.G5_DATA_URL.'/event/'.$row['ev_id'].'_m" alt="'.$row['ev_subject'].'">';
			} else {
				$list_str = '<p class="ev_title">'.$row['ev_subject'].'</p>';
			}
			//echo '<li><a href="'.G5_SHOP_URL.'/event.php?ev_id='.$row['ev_id'].'">'.$list_str.'</a></li>';
			//echo '<li><a href="'.shop_event_url($row['ev_id']).'">'.$list_str.'</a></li>';
			echo '<li>';
				$ev_banner_link[$i] = explode("|", $row['ev_banner_link']);
				if($ev_banner_link[$i][1]) {
					if($ev_banner_link[$i][0]=='_page') {
						echo '<a href="'.shop_short_url_my('page', $ev_banner_link[$i][1]).'">'.$list_str.'</a>';
					} else {
						echo '<a href="'.$ev_banner_link[$i][1].'" target="'.$ev_banner_link[$i][2].'">'.$list_str.'</a>';
					}
				} else {
					echo '<a href="'.shop_short_url_my('event', $row['ev_id']).'">'.$list_str.'</a>';
				}
				/*echo '<div class="flex flex-middle '.(!G5_IS_MOBILE?'p10':'p5').'">';
					$ev_begin_time[$i] = substr($row['ev_begin_time'], 2, 14);
					$ev_end_time[$i] = substr($row['ev_end_time'], 2, 14);	
					
					echo get_event_live($ev_begin_time[$i], $ev_end_time[$i]);
					
					echo '<div class="ml-auto color-gray">'.($row['ev_begin_time']!='0000-00-00 00:00:00'?date("y/m/d", strtotime($row['ev_begin_time'])):'').($row['ev_begin_time']!='0000-00-00 00:00:00' || $row['ev_end_time']!='0000-00-00 00:00:00'?' ~ ':'').($row['ev_end_time']!='0000-00-00 00:00:00'?date("y/m/d", strtotime($row['ev_end_time'])):'').'</div>';
				echo '</div>';*/
			echo '</li>';
		}
	echo '</ul>';
echo '</div>';


include_once('./_tail.php');
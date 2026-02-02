<?php
include_once('./_common.php');
define('_ITEMREVIEW_', true); //인태 - 추가


$photos = sql_query("select * from `g5_shop_item_use` where is_file != '' and is_confirm = '1' order by is_id ");
$dirfile = G5_URL.'/data/member_review/';


if(is_file(G5_THIS_SHOP_PATH.'/itemreview.php')) {
	include_once(G5_THIS_SHOP_PATH.'/itemreview.php');
	return;
} else if(is_file(G5_THEME_SHOP_PATH.'/itemreview.php')) {
	include_once(G5_THEME_SHOP_PATH.'/itemreview.php');
	return;
}
if (G5_IS_MOBILE) {
    //include_once(G5_MSHOP_PATH.'/itemreview.php');
	//return;
}


$g5['title'] = '상품후기';
include_once('./_head.php');

if(!$default['itemreview_skin']) {
	echo '<div id="_itemreview" class="_gall">';
		echo '<ul class="_itemreview_ul" style="'.(G5_IS_MOBILE?'--gall-cols:2;--gall-gap:10px;':'--gall-cols:3;--gall-gap:10px;').'">';
			for($i=0; $rowp=sql_fetch_array($photos); $i++) {
				$photolist = explode(",",$rowp['is_file']);
				if($rowp['is_file']){
					$chks = $rowp['is_file'];
					echo '<li>';
						echo '<div class="reviewThumb"><a href="'.G5_SHOP_URL.'/item.php?it_id='.$rowp['it_id'].'#sit_use_list"><img src="'.$dirfile.$photolist[0].'" style=""></a></div>';
						echo '<div class="reviewCon">';
							echo '<div class="subject">'.$rowp['is_subject'].'</div>';
							//if($default['shop_use_it_avg']) echo '<div class="grade" data-score="'.get_star($rowp['is_score']).'"><span class="star"></span></div>';
							echo '<div class="info">';							
								echo '<span class="name">'.($is_admin2 ? get_text($rowp['is_name']) : mb_substr($rowp['is_name'],0,-2)."**").'</span>';
								echo '<span class="date">'.date("Y/m/d", strtotime($rowp['is_time'])).'</span>';
							echo '</div>';
						echo '</div>';
					echo '</li>';
				}
			}
		echo '</ul>';
	echo '</div>';
}


if($default['itemreview_skin'] == '_wz') {
	echo '<div id="_itemreview" class="_wz">';
		echo '<ul class="_itemreview_ul">';
			for($i=0; $rowp=sql_fetch_array($photos); $i++) {
				$photolist = explode(",",$rowp['is_file']);
				if($rowp['is_file']){
					$chks = $rowp['is_file'];
					echo '<li>';						
						echo '<div class="reviewCon">';
							echo '<span class="name">'.($is_admin2 ? get_text($rowp['is_name']) : mb_substr($rowp['is_name'],0,-2)."**").'</span>';
							echo '<div class="subject">'.$rowp['is_subject'].'</div>';							
							echo '<div class="info">';
								if($default['shop_use_it_avg']) echo '<div class="grade" data-score="'.get_star($rowp['is_score']).'"><span class="star"></span></div>';
								echo '<span class="date">'.date("Y/m/d", strtotime($rowp['is_time'])).'</span>';
							echo '</div>';
						echo '</div>';
						echo '<div class="reviewThumb"><a href="'.G5_SHOP_URL.'/item.php?it_id='.$rowp['it_id'].'#sit_use_list"><img src="'.$dirfile.$photolist[0].'" style=""></a></div>';
					echo '</li>';
				}
			}
		echo '</ul>';
	echo '</div>';
}

include_once('./_tail.php');
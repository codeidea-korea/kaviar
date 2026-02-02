<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$_this_block_itemuse_skin_path = G5_THIS_PATH.'/skin/shop/_block_itemuse.skin.php';
if(file_exists($_this_block_itemuse_skin_path)) {
	require($_this_block_itemuse_skin_path);
	return;
}
$_theme_block_itemuse_skin_path = G5_THEME_PATH.'/skin/shop/basic/_block_itemuse.skin.php';
if(file_exists($_theme_block_itemuse_skin_path)) {
	require($_theme_block_itemuse_skin_path);
	return;
}

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$num = $total_count - ($page - 1) * $rows - $i;
	$star = get_star($row['is_score']);

	$row2 = get_shop_item($row['it_id'], true);
	$it_href = shop_item_url($row['it_id']);
	//$row2['it_name'] - 상품명
	//get_itemuse_thumb($row['is_content'], 60, 60) - 후기 이미지 썸네일

	if($i==0) {
		if($itemuse_skin == '_slide') {
			echo '<div class="itemuseContainer '.$itemuse_skin.' mySwiper" data-per="'.$itemuse_cols.'" data-gap="'.$itemuse_gap.'" data-loop="false"'.($itemuse_radius?' style="--itemuse-radius:'.$itemuse_radius.'px;"':'').'>';
				echo '<div class="swiper-container">';
					echo '<div class="swiper-wrapper">';
		} else {
			echo '<ul class="itemuseContainer '.$itemuse_skin.'" style="--itemuse-cols:'.$itemuse_cols.';--itemuse-gap:'.$itemuse_gap.'px;--itemuse-radius:'.$itemuse_radius.'px;">';
		}
	}

	echo $itemuse_skin == '_slide' ? '<div class="swiper-slide itemuse-list">' : '<li class="itemuse-list">';

		echo '<div class="itemCon">';
			echo '<a href="'.$it_href.'">'.get_it_image($row['it_id'], 40, 40).'</a>';
			echo '<div class="it_name"><a href="'.$it_href.'">'.$row2['it_name'].'</a></div>';
		echo '</div>';
		echo '<div class="itemuseCon">';
			echo '<div class="inline-flex gap10 color-gray">';
				echo '<div class="name">'.get_text($row['is_name']).'</div>';
				echo '<div class="date">'.substr($row['is_time'],0,10).'</div>';
			echo '</div>';			
			echo '<div class="subject">'.get_text($row['is_subject']).'</div>';
			echo '<div class="grade" data-score="'.$star.'"><span class="star"></span></div>';
		echo '</div>';
	
	echo $itemuse_skin == '_slide' ? '</div>' : '</li>';

	$i++;
}

if($i > 0) {
	if($itemuse_skin == '_slide') {
				echo '</div>';
			echo '</div>';
		echo '</div>';
	} else {
		echo '</ul>';
	}
}

if($i == 0) echo "<p class=\"sct_noitem\">등록된 후기가 없습니다.</p>\n";
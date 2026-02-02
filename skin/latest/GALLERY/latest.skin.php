<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($latest_skin_url.'/'.$css).'">', 3);


// gallContents
for ($i=0; $i<count($list); $i++) {
	$gallContents[$i] = $_webzine ? '<div class="wzContents'.($webzine_inline?' webzine-inline':'').'">' : '<div class="gallContents">';
	if($img[$i]) {
		$gallContents[$i] .= $_webzine ? '<div class="wz_thumb">' : '<div class="gall_thumb">';
		$gallContents[$i] .= $a_link_img[$i];
		$gallContents[$i] .= $img[$i];
		if($a_link_img[$i]) $gallContents[$i] .= '</a>';
		$gallContents[$i] .= '</div>';
	}
	if($gall_con[$i]) {
		$gallContents[$i] .= $_webzine ? '<div class="wz_con">' : '<div class="gall_con">';
		if($gr_id_bo_table[$i]) $gallContents[$i] .= $gr_id_bo_table[$i];

		if($isSubject[$i]) {
			$gallContents[$i] .= '<div class="textSubject skinOption-subject skinOption-text-align">';
			if(isset($list[$i]['icon_hot']) && $list[$i]['icon_hot']) $gallContents[$i] .= '<i class="boIcon_hot"></i>';
			$gallContents[$i] .= $a_link_txt[$i];
			$gallContents[$i] .= $list[$i]['subject'];
			if($a_link_txt[$i]) $gallContents[$i] .= '</a>';
			if($bo_comment && $list[$i]['comment_cnt']) $gallContents[$i] .= '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';
			//if(isset($list[$i]['icon_new']) && $list[$i]['icon_new']) $gallContents[$i] .= '<i class="boIcon_new"></i>';
			$gallContents[$i] .= '</div>';
		}

		if($isContent[$i]) $gallContents[$i] .= '<div class="textContent skinOption-con skinOption-text-align">'.$wr_content[$i].'</div>';

		$gallContents[$i] .= $category[$i];

		$gallContents[$i] .= $list_tag_set[$i];

		$gallContents[$i] .= $gall_list_infoSet[$i];

		if($_webzine || $_slide) $gallContents[$i] .= $list_btn_set[$i];

		$gallContents[$i] .= '</div>';
	}

	if(!$_webzine && !$_slide) $gallContents[$i] .= $list_btn_set[$i];

	$gallContents[$i] .= '</div>';
}


if($latest_type) {
	require($latest_skin_path.'/'.$latest_type.'.php');
    return;
} else {
	require($latest_skin_path.'/_gall_masonry.php');
    return;
}
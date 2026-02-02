<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($bo_top_img) { //게시판관리 - 상단,하단 내용을 끌어다 출력한다.
	if(G5_IS_MOBILE) { 	
		
		$board['bo_mobile_content_head'] = $board['bo_mobile_content_head'] ? $board['bo_mobile_content_head'] : $board['bo_content_head'];
		$board['bo_mobile_content_tail'] = $board['bo_mobile_content_tail'] ? $board['bo_mobile_content_tail'] : $board['bo_content_tail'];

		if ($board['bo_top_img_type'] == '1') { //기본형
			echo '<div class="bo_top_img"><img src="'.$top_img_mob_url.'" class="bgImg" alt="상단이미지">';
			echo '	<div class="bgSlogan">';
			echo stripslashes($board['bo_mobile_content_head']);
			echo '	</div>';
			echo '</div>';

		} else if ($board['bo_top_img_type'] == '2') { //커버형
			echo '<div class="bo_top_img boCover">';
			echo '	<div class="coverBg" style="background-image:url('.$top_img_mob_url.');">';
			echo '		<div class="mainSlogan tcenter">';
			echo stripslashes($board['bo_mobile_content_head']);
			echo '		</div>';
			echo '	</div>';
			echo '</div>';
			echo '<span class="boCoverSpacer" style="display:block;"></span>';
			echo '<div class="coverSlogan">';
			echo '	<div class="tcenter" style="width:100%;">';
			echo stripslashes($board['bo_mobile_content_tail']);
			echo '	</div>';
			echo '</div>';		
		} else if ($board['bo_10_subj'] == '3'){ //모션형
			//echo '<script src="//code.jquery.com/jquery-latest.min.js"></script>';
			echo '<div class="parallax" style="background-image:url('.$bo_12_subj.');">';
			echo '	<div class="tcenter" style="width:100%;">';
			echo stripslashes($board['bo_mobile_content_head']);
			echo '	</div>';
			echo '</div>';
		}

	} else { //상단이미지 출력(쓰기페이지 제외) - *하단내용을 끌어다 쓴다.		

		if ($board['bo_top_img_type'] == '1') { //기본형
			echo '<div class="bo_top_img"><img src="'.$top_img_url.'" class="bgImg" alt="상단이미지">';
			echo '	<div class="bgSlogan">';
			echo stripslashes($board['bo_content_head']);
			echo '	</div>';
			echo '</div>';

		} else if ($board['bo_top_img_type'] == '2') { //커버형
			echo '<div class="bo_top_img boCover">';
			echo '	<div class="coverBg" style="background-image:url('.$top_img_url.');">';
			echo '		<div class="mainSlogan tcenter" style="padding-top:50px;">';
			echo stripslashes($board['bo_content_head']);
			echo '		</div>';
			echo '	</div>';
			echo '</div>';
			echo '<span class="boCoverSpacer" style="display:block;margin-top:-'.$header['header_height'].'px;"></span>';
			if($board['bo_content_tail'] || $boCon_bottom_upImg) {
				echo '<div class="coverSlogan">';
				echo stripslashes($board['bo_content_tail']);
				echo '</div>';
			}
			$myStyle .= '#footer{z-index:10}';

		} else if($board['bo_top_img_type'] == '3') { //모션형
			$parallax_height = $board['bo_top_img_height'] ? 'height:'.$board['bo_top_img_height'].'px;' : 'height:500px;';
			echo '<div class="bo_top_img parallax" style="background-image:url('.$top_img_url.');'.$parallax_height.'">';
			echo stripslashes($board['bo_content_head']);
			echo '</div>';
		}
	}
}
?>
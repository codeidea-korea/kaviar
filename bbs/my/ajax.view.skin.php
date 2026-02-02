<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_BBS_PATH.'/my/ajax.view.php');
?>

<div class="magnific-popup pop-view-wrap zoom-anim-dialog <?=$boSkin?>" style="<?=G5_IS_MOBILE?'':$popSize?>">
	<?php	
	$pop_top_img = '';
	if($view['wr_video']) { //저장된 동영상 코드가 있다면
		$pop_top_img .= '<section id="pop-video">';
		if($video_type == 'mp4') {
			if( !preg_match('/http(s?)\:\/\//i', $view['wr_video']) ) $view['wr_video'] = G5_URL.$view['wr_video'];
			$pop_top_img .= '<div class="video-container"><video src="'.$view['wr_video'].'" controls class="video"></video></div>';
		} else if($video_type == 'youtube') {
			$pop_top_img .= '<iframe src="https://www.youtube.com/embed/'.$view['wr_video'].'?rel=0&amp;controls=1&amp;showinfo=1&autoplay=0" frameborder="0" class="video" allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
		} else if($video_type == 'vimeo') {
			$pop_top_img .= '<iframe src="https://player.vimeo.com/video/'.$view['wr_video'].'?autoplay=0" frameborder="0" class="video" webkitallowfullscreen mozallowfullscreen allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
		}
		$pop_top_img .= '</section>';
	} else if($board['bo_view_thumb']) { //뷰페이지 이미지 사용
		$v_img_count_pc = $view['file'][0]['view'];
		$v_img_count_mob = $view['file'][1]['view'];
		$v_img = G5_IS_MOBILE && $v_img_count_mob ? $v_img_count_mob : $v_img_count_pc;
		if($v_img) $pop_top_img .= '<div id="pop-img">'.get_view_thumbnail($v_img).'</div>';
	}
	
	echo $pop_top_img;

	$popContainer =  $isSubject || $isContent || $bo_v_linkSet || $bo_v_info || $bo_comment || $include ? true : false;
	
	if($popContainer) {
		echo '<section class="popContainer" style="'.$pop_padding.'">';

		if(!G5_IS_MOBILE) echo $fileDownload; //첨부파일

		if($category_name) echo '<div class="ca_name">'.$view['ca_name'].'</div>';

		if($isSubject) echo '<div class="popSubject">'.get_text($view['wr_subject']).'</div>';
		
		if($include) include_once($include_path);

		if($isContent) {
			echo '<div id="bo_v_con" class="popContents">';
			echo get_view_thumbnail($view['content']);
			echo '</div>';
		}
		
		echo $bo_v_linkSet; //첨부된 링크		

		echo $bo_v_info; //작성자 및 게시물 정보
		
		include_once(G5_SNS_PATH."/view.sns.skin.php"); //SNS		

		if($bo_comment) include_once(G5_BBS_PATH.'/view_comment.php');

		if($update_href || $delete_href || G5_IS_MOBILE) {
			echo '<div class="pop_btnSet">';		
			if(G5_IS_MOBILE) echo '<span class="popClose btn gray">닫기</span>';
			if($delete_href) echo '<a href="'.$delete_href.'" class="btn_del" onclick="del(this.href); return false;" alt="삭제"></a>';
			if($update_href) echo '<a href="'.$update_href.'" class="btnEdit" alt="수정">수정</a>';
			echo '</div>';
		}

		echo '</section>';
	}

	
	?>
</div>
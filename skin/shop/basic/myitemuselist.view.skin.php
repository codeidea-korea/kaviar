<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<div id="myitemuse_view">
	<?php for ($i=0; $row=sql_fetch_array($result); $i++) {
		$star = get_star($row['is_score']);
		//$is_content = get_view_thumbnail(conv_content($row['is_content'], 1), 600);
		/*$is_content[$i] = preg_replace("/<(.*?)\>/"," ",$row['is_content']); 
		$is_content[$i] = preg_replace("/&nbsp;/"," ",$is_content[$i]); 
		$is_content[$i] = str_replace("//##", " ", $is_content[$i]);*/
		$is_content[$i] = strip_tags($row['is_content'],"<p>");
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $row['is_content'], $match);
		$content_thumb[$i] = '<p>'.$match[0].'</p>';

		$row2 = get_shop_item($row['it_id'], true);
		$it_href = shop_item_url($row['it_id']);

		if($row['is_reply_subject'] || $row['is_reply_content']) {
			//$is_reply_content = get_view_thumbnail(conv_content($row['is_reply_content'], 1), 600); //답변내용
			/*$is_reply_content[$i] = preg_replace("/<(.*?)\>/"," ",$row['is_reply_content']); 
			$is_reply_content[$i] = preg_replace("/&nbsp;/"," ",$is_reply_content[$i]); 
			$is_reply_content[$i] = str_replace("//##", " ", $is_reply_content[$i]);*/
			$is_reply_content[$i] = strip_tags($row['is_reply_content'],"<p>");
			preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $row['is_reply_content'], $match);
			$reply_content_thumb[$i] = '<p>'.$match[0].'</p>';
		}
		//get_itemuse_thumb($row['is_content'], 60, 60) - 후기 이미지 썸네일
	?>
	<div class="re_v_head">
		<div class="subject"><?=get_text($row['is_subject'])?></div>
		<div class="date"><?=substr($row['is_time'],0,10)?></div>
	</div>
	<div class="re_v_item_li">
		<div class="inner">
			<div class="thumb">
				<a href="<?=$it_href?>"><?=get_it_image($row['it_id'], 70, get_it_height(70))?></a>
			</div>
			<div class="con">
				<div class="it_name"><a href="<?=$it_href?>"><?=$row2['it_name']?></a></div>		
				<div class="subject"><?=get_text($row['is_subject'])?></div>
				<div class="grade" data-score="<?=$star?>"><span class="star"></span></div>
			</div>
		</div>
	</div>

	<div class="re_v_con">

	<?
		$mb_dir = substr($row['mb_id'],0,2);
		$img_chk = explode(",",$row['is_file']);
		$dirfile = G5_URL.'/data/member_review/';
		for($u=0; $u<count($img_chk); $u++){
			$f_ex = explode('.',$img_chk[$u]);

			if($f_ex[1] == "mp4"){
				// 비디오 플레이어 출력
				echo "<br><video style='width:35%' controls>
						<source src='".$dirfile.$img_chk[$u]."' type='video/mp4'>
					  </video>";
			} else {
				// 이미지 출력
				echo "<br><img src='".$dirfile.$img_chk[$u]."' style='width:15%'>";
			}
		}
	?>
		
	</div>

	<div class="re_v_con">
		<?=$is_content[$i]?>
		<?=$content_thumb[$i]?>
	</div>
	
	<?php if($is_reply_content) {
		echo '<div class="re_v_con_re">';
			echo '<div class="re-head">';
				echo '<span class="name">'.$row['is_reply_name'].'</span>';
			echo '</div>';
			echo '<div class="re-con">';
				if($row['is_reply_subject']) echo '<div class="subject">'.get_text($row['is_reply_subject']).'</div>';
				echo '<div class="con">'.$is_reply_content[$i].$reply_content_thumb[$i].'</div>';
			echo '</div>';
		echo '</div>';
	} ?>
	<?php } ?>
	

	<div class="mt50 tcenter">
		<a href="<?=$href_myitemuselist?>" class="_btn/lg/line/transparent historyback">뒤로가기</a>
	</div>

</div>
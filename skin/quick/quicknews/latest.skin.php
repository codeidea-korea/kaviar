<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($latest_pcskin_url.'/'.$css).'">', 4);
$is_qn_page = $board['bo_table'] == $_GET['bo_table'] ? true : false;
$bo_subject = $is_qn_page ? '<span class="qn_page_active">'.$board['bo_subject'].'</span>' : $board['bo_subject'];
$now_wr_id = $_GET['wr_id'];
$now_table = $_GET['bo_table'];
$qn_open = $now_table == $board['bo_table'] ? 'open' : false;		
?>

<div id="qn_<?=$board['bo_table']?>" class="quickNews <?=$qn_open?>">
	<?php if($quickStyle) echo '<style name="quickStyle">'.$quickStyle.'</style>';	?>
	<ul class="qn_ul">
		<?php for ($i=0; $i<count($list); $i++) { ?>
		<li id="li_<?=$list[$i]['wr_id']?>" class="qn_li <?=$is_qn_page&&$list[$i]['wr_id']==$now_wr_id?'active':''?>" style="">
			<div class="qnContents">
				<?php
				if($img[$i]) {
					echo '<div class="qnCon_thumb">';
					echo $a_link_img[$i];
					echo $img[$i];
					if($a_link_img[$i]) echo '</a>';
					echo '</div>';
				}
				
				if($gall_con[$i] || $list_btn_set[$i]) {
					echo '<div class="qnCon_text">';
					if($gr_id_bo_table[$i]) echo $gr_id_bo_table[$i];
					if($isSubject[$i]) {
						echo '<div class="qnSubject">';
						echo $a_link_txt[$i];
						echo $list[$i]['subject'];
						if($a_link_txt[$i]) echo '</a>';
						if($bo_reply && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><b class="bold red">'.$list[$i]['comment_cnt'].'</b><span class="sound_only">개</span>';
						echo '</div>';
					}

					if($isContent[$i]) echo '<div class="qnContent">'.$wr_content[$i].'</div>';

					echo $category[$i];

					echo $list_tag_set[$i];

					echo $list_btn_set[$i];

					echo $gall_list_infoSet[$i];								

					echo '</div>';
				} //is_qnCon_text
				?>
			</div>
		</li>
		<?php } ?>
		<?php if(count($list) == 0) echo "<li class=\"empty_list\" data-text='게시물이 없습니다.'></li>"; ?>
	</ul>
	<?php
	//그룹전용 페이지에서 메인용 퀵뉴스는 레이어팝업으로 처리	
	//if($group['gr_use_layout']) {
		if($board['bo_table'] == $quick_news['qn_table1'] || $board['bo_table'] == $quick_news['qn_table2']) {
			if($latestScript) $content .= '<script data-name="'.$blockName.'">'.$latestScript.'</script>'.PHP_EOL;
		}
	//}
	?>
</div>

<iframe class="cover" src="about:blank" style="border:0;"></iframe>
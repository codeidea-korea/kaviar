<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($latest_skin_url.'/'.$css).'">', 3);
?>
<div class="latest_basic <?=$bo_table?>">
	<div class="latest_basic_head">
		<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>" class="bo_table_subject <?=$bl_font?>"><?=$bo_subject?></a>
		<a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>" class="more">더보기</a>
	</div>
	<ul class="latest_basic_ul">
		<?php for ($i=0; $i<count($list); $i++) {
			echo '<li class="skinOption-subject">'.PHP_EOL;
			if($gr_id_bo_table[$i]) echo $gr_id_bo_table[$i];
			echo $a_link_txt[$i];
			echo $list[$i]['subject'];
			if($a_link_txt[$i]) echo '</a>';			
			if($bo_reply && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><b class="bold red">'.$list[$i]['comment_cnt'].'</b><span class="sound_only">개</span>';
			echo $category[$i];
			if($is_file[$i]) echo '<i class="boIcon_file"></i>';
			if($is_file_img[$i]) echo '<i class="boIcon_img"></i>';
			if(isset($list[$i]['icon_new']) && $list[$i]['icon_new']) echo '<i class="boIcon_new"></i>';	
			echo passing_time($list[$i]['wr_datetime']);
			echo '</li>'.PHP_EOL;
		} ?>
	</ul>
</div>
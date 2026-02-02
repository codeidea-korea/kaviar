<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_URL.'/skin/board/gallery-grid/style.css').'">', 2);
?>

<div class="bo_gall block_auto_gall">
	<ul class="auto_ul">
		<?php for ($i=0; $i<count($list); $i++) { ?>

		<li class="auto_li <?=$list[$i]['wr_grid']?$list[$i]['wr_grid']:'grid_1x1'?>">

			<div class="gallContents">
				
				<?php if($img[$i]) {
					echo $a_link_img[$i];
					echo '<div class="thumb" style="background-image:url('.$img_thumb[$i]['src'].');"></div>';
					if($a_link_img[$i]) echo '</a>';
				} ?>
				
				<?php if($gall_con[$i]) { ?>
				<div class="con">
					<?php if($gr_id_bo_table[$i]) echo $gr_id_bo_table[$i]; ?>
					<?=$cate_link_front[$i]?>
					<?php if($isSubject[$i]) { ?>
					<div class="textSubject skinOption-subject skinOption-text-align">
						<?php
						if($list[$i]['is_notice']) echo '<span class="gall_notice"></span>';
						if(isset($list[$i]['icon_hot']) && !$list[$i]['is_notice']) echo $list[$i]['icon_hot'];
						echo $a_link_txt[$i];
						echo $list[$i]['subject'];
						if($a_link_txt[$i]) echo '</a>';
						if($bo_reply && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><b class="bold red">'.$list[$i]['comment_cnt'].'</b><span class="sound_only">개</span>';
						?>
					</div>
					<?php } ?>
					<?php
					if( (!$list[$i]['wr_grid'] || $list[$i]['wr_grid'] == 'grid_1x1'|| $list[$i]['wr_grid'] == 'grid_1x2'|| $list[$i]['wr_grid'] == 'grid_1x3'|| $list[$i]['wr_grid'] == 'grid_1x4') && $outline) $isContent[$i] = false;
					if($isContent[$i] && $list[$i]['wr_grid'] && $list[$i]['wr_grid'] != 'grid_1x1') echo '<div class="textContent skinOption-con skinOption-text-align">'.$wr_content[$i].'</div>';
					?>
					<?=$cate_link_back[$i]?>
					<?=$list_btn[$i]?>
					<?php if($list_infoSet && $list[$i]['wr_grid'] && $list[$i]['wr_grid'] != 'grid_1x1') {
						echo '<div class="list_infoSet">';
						echo $writeInfo[$i];
						echo $iconSet[$i];
						echo '</div>';
					} ?>
					<?=$list_tag_set[$i]?>
				</div>
				<?php } ?>

				<?=$list_btn_set[$i]?>

			</div>

			<?php if($edit_href[$i]) {
				echo '<div class="layerBtn">';
				echo '	<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i][wr_id].'"><span class="btnEdit">수정</span></a>';
				echo '</div>';
			} ?>
		</li>
		<?php } ?>
	</ul>
	<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>';?>
</div>



<!-- //그리드 지정값이 없을때 랜덤하게.... 나중에 확인
<?php if(strpos($board['bo_skin'], 'grid') === false) { ?>
<script>
$(document).ready(function(){
    var classes = ["grid_1x1", "grid_1x2", "grid_1x3", "grid_1x4", "grid_2x2", "grid_2x3", "grid_2x4", "grid_3x1", "grid_3x2", "grid_3x3", "grid_3x4", "grid_4x2"];
    $(".auto_li").each(function(){
		$(this).removeClass('grid_1x1');
        $(this).addClass(classes[~~(Math.random()*classes.length)]);
    });
});
</script>
<?php }?>
-->




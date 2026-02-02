<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/'.$css).'">', 2);
?>

<?php// if($is_bo_title) echo $bo_title; ?>

<?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div class="bo_gall boContainer" style="<?=$bo_width?>">

	<?=$list_bundle_form?>

	<?=$tagsGroup?>

	<?php// if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

	<form name="fboardlist"  id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

	<ul class="gall_ul">
		<?php for ($i=0; $i<count($list); $i++) { ?>

		<li class="gall_li <?=$skinOption_frame?> <?php if($list[$i]['wr_use']) echo ' use_'.$list[$i]['wr_use'];?> <?=$is_now[$i]?>">
			<?=$bo_current[$i]?>
			<?=$gall_li_checkbox[$i]?>
			<?=$icon_use[$i]?>

			<div class="gallContents">	
			
				<?php
				echo $a_link_img[$i];
					echo '<div class="gall_thumb'.(!$img[$i]?' no-img2':'').'">';
						$img[$i] = $img[$i] ? $img[$i] : '<div class="thumb-noimg"></div>';
						echo $img[$i];
						if($isSubject[$i]) {
							echo '<div class="layerCon">';
								if($list[$i]['ca_name']) echo '<div class="ca_name">'.$list[$i]['ca_name'].'</div>';
								echo '<div class="textSubject">'.$list[$i]['subject'].'</div>';
								if($bo_comment && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';
							echo '</div>';
						}
					echo '</div>';
				if($a_link_img[$i]) echo '</a>';
				?>
				
			</div>

			<?php if($edit_href[$i]) {
				echo '<div class="layerBtn">';
				echo '	<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i]['wr_id'].'"><span class="btnEdit '.$btnEdit_class[$i].'">수정</span></a>';
				echo '</div>';
			} ?>
		</li>
		<?php } ?>
		<?php if(count($list) == 0) echo '<li class="empty_list" data-text="게시물이 없습니다."></li>'; ?>
	</ul>

	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

	</form>

	<?=$write_pages?>

</div>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>
<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/style.css').'">', 2);
add_javascript('<script src="'.G5_JS_URL.'/my/masonry/masonry.pkgd.min.js"></script>', 2);
?>

<?php if($is_bo_title) echo $bo_title; ?>

<?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div class="bo_gall boContainer" style="<?=$bo_width?>">
	
	<?=$list_bundle_form?>

	<?=$tagsGroup?>

	<?php if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

	<form name="fboardlist"  id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

	<div class="masonry_wrap" data-masonry='{"itemSelector":".gall_li", "columnWidth":".gall_li", "gutter":<?=$gutter?>, "percentPosition":true,"horizontalOrder":true}'>
		
		<ul class="gall_ul">
			<?php for ($i=0; $i<count($list); $i++) { ?>
			
			<li id="gall_li_<?=$i?>" class="gall_li <?=$skinOption_frame?> <?=$is_now[$i]?>">
				<?=$bo_current[$i]?>
				<?=$gall_li_checkbox[$i]?>
				<?=$icon_use[$i]?>

				<div class="gallContents">

					<?php if($img[$i]) {
						echo '<div class="gall_thumb">';
						echo $a_link_img[$i];
						echo $img[$i];
						if($a_link_img[$i]) echo '</a>';
						echo '</div>';
					} ?>
					
					<?php if($gall_con[$i]) { ?>
					<div class="gall_con">
						<?php if($isSubject[$i]) { ?>
						<div class="textSubject skinOption-subject skinOption-text-align">
							<?php
							if(isset($list[$i]['icon_hot']) && $list[$i]['icon_hot']) echo '<i class="boIcon_hot"></i>';
							echo $a_link_txt[$i];
							echo $list[$i]['subject'];
							if($a_link_txt[$i]) echo '</a>';
							if($bo_comment && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';
							if(isset($list[$i]['icon_new']) && $list[$i]['icon_new']) echo '<i class="boIcon_new"></i>';
							?>
						</div>
						<?php } ?>

						<?php if($isContent[$i]) echo '<div class="textContent skinOption-con skinOption-text-align">'.$wr_content[$i].'</div>'; ?>

						<?=$cate_link[$i]?>

						<?=$list_tag_set[$i]?>

						<?=$gall_list_infoSet[$i]?>
					</div>
					<?php } ?>

					<?=$list_btn_set[$i]?>
					
				</div>

				<?php if($edit_href[$i] && !G5_IS_MOBILE) {
					echo '<div class="layerBtn">';
					echo '	<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i]['wr_id'].'"><span class="btnEdit '.$btnEdit_class[$i].'">수정</span></a>';
					echo '</div>';
				} ?>
			</li>
			<?php } ?>
		</ul>
	</div>

	<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>'; ?>

	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

	</form>

	<?=$write_pages?>

</div>

<script>
$(document).ready(function(){
	masonry_update('.masonry_wrap', <?=$gutter?>);
});
</script>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>
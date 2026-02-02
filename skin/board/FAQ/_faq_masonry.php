<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_JS_URL.'/my/masonry/masonry.pkgd.min.js"></script>', 2);
?>

<?php if($is_bo_title) echo $bo_title; ?>

<?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div id="_faq_masonry" class="bo_gall boContainer" style="<?=$bo_width?>">
	
	<?=$list_bundle_form?> 
	
	<?=$tagsGroup?>

	<?php if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table, '궁금사항은 먼저 검색해 보세요.'); ?>

    <form name="fboardlist"  id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

	<div class="masonry_wrap" data-masonry='{ "itemSelector":".gall_li", "columnWidth":".gall_li", "gutter":<?=$gutter?>, "horizontalOrder":true}'>

    <ul class="gall_ul">
        <?php for ($i=0; $i<count($list); $i++) { ?>
        <li class="gall_li <?=$is_now[$i]?>">
			<?=$bo_current[$i]?>
			<?=$gall_li_checkbox[$i] ?>
			<?=$icon_use[$i]?>

            <div class="faqContents skinOption-text-align">
				<?php				
				if($isSubject[$i]) {
					echo '<div class="textSubject skinOption-subject">';
					if($list[$i]['is_notice']) echo '<span class="gall_notice"></span>';
					if(isset($list[$i]['icon_hot']) && $list[$i]['icon_hot']) echo '<i class="boIcon_hot"></i>';
					echo $a_link_txt[$i];
					echo $list[$i]['wr_subject'];
					if($a_link_txt[$i]) echo '</a>';					
					echo '</div>';
				}
				if($isContent[$i]) {
					echo '<div class="con skinOption-con">';
					echo $a_link_txt[$i];
					echo $wr_content[$i];
					if($a_link_txt[$i]) echo '</a>';
					if($bo_comment && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';
					if(isset($list[$i]['icon_new']) && $list[$i]['icon_new']) echo '<i class="boIcon_new ml10"></i>';
					echo '</div>';
				}				
				?>
				
				<?=$cate_link[$i]?>

				<?=$list_tag_set[$i]?>

				<?php if($a_link[$i]) echo $a_link[$i].'<span class="more">더보기</span></a>'; ?>
				
				<?=$gall_list_infoSet[$i]?>
            </div>
        </li>
        <?php } ?>
    </ul>
	</div>

	<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>'; ?>

    <?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

    </form>

	<?=$write_pages?>

</div>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>
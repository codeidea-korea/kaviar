<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/style.css').'">', 3);
?>

<?php// if($is_bo_title) echo $bo_title; ?>

<?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div class="bo_list">
	
	<?=$tagsGroup?>

	<?php// if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <ul class="_shop_bo_list_ul">
        <?php for ($i=0; $i<count($list); $i++) { ?>
        <li class="list_li<?=$list[$i]['is_notice']?' bo_notice':''?>">
			<?php $wr_id == $list[$i]['wr_id'] ? '<span class="sound_only"><span class=\'bo_current\'>열람중</span></span>' : ''; ?>
			<div class="listCon">
				<?php
				if($list[$i]['is_notice']) echo '<span class="boIcon_notice">공지</span>';
				echo $boIcon_hot[$i];
				echo $boIcon_secret[$i];
				
				echo '<span class="listSubject skinOption-subject">';

				echo $a_link_txt[$i].$list[$i]['subject'].($a_link_txt[$i]?'</a>':'');				

				//if($bo_comment && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';

				echo $boIcon_file[$i]; //첨부파일
				//echo $boIcon_img[$i]; //이미지
				//echo $boIcon_video[$i]; //동영상
				//echo $boIcon_attach[$i]; //첨부링크
				//echo $boIcon_new[$i]; //새글

				echo '</span>';
				?>
				<?php echo '<div class="div_state">'.(!$list[$i]['comment_cnt']?'<span class="state_tag ready">답변대기</span>':'<span class="state_tag complete">답변완료</span>').'</div>'; ?>
			</div>

			<?php if(!$list[$i]['icon_secret']) echo $cate_link[$i]?>
			
			<?=$list_tag_set[$i]?>

			<?=$list_infoSet[$i]?>

			<?php if($edit_href[$i]) {
				echo '<div class="layerBtn" style="top:10px;right:10px;">';
				echo '	<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i]['wr_id'].'"><span class="btnEdit '.$btnEdit_class[$i].'">수정</span></a>';
				echo '</div>';
			} ?>
        </li>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<li class="empty_list" data-text="게시물이 없습니다."></li>'; } ?>
    </ul>
    </form>

	<?=$write_pages?>
	
	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

</div>
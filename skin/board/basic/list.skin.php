<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/'.$css).'">', 3);

if(G5_IS_MOBILE) {
	require_once($board_pcskin_path.'/_list_mobile.skin.php');
	return;
}

$colspan = 3;
if($is_checkbox) $colspan++;
if($is_category && $frontCate) $colspan++;
if($bo_writer) $colspan++;
if($bo_hit) $colspan++;
if($is_good) $colspan++;
if($is_admin) $colspan++;
?>

<?php if($is_bo_title) echo $bo_title; ?>

<?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?>

<div class="bo_list" style="<?=$bo_width?>">

	<?=$tagsGroup?>

	<?php if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

    <form name="fboardlist" id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="tableContainer">
		<?php if($_GET['sst']) echo '<a href="'.G5_URL.'/bbs/board.php?bo_table='.$bo_table.'" class="reflesh"></a>'; ?>
        <table>
        <caption><?=$board['bo_subject']?> 목록</caption>
        <thead>
        <tr>
			<?php if($is_checkbox) echo '<th scope="col" class="edit-mode"><span class="sound_only">개별선택</span></th>'; ?>
            <th scope="col">번호</th>
			<?php if($frontCate && $is_category) echo '<th scope="col">'.$bo_cate_label.'</th>'; ?>
			<th scope="col">제목</th>			
			<?php if ($bo_writer) echo '<th scope="col">작성자</th>'; ?>
			<?php if ($bo_date) echo '<th scope="col">'.subject_sort_link('wr_datetime', $qstr2, 1).'날짜</a></th>'; ?>
            <?php if ($is_good) echo '<th scope="col">'.subject_sort_link('wr_good', $qstr2, 1).'좋아요</a></th>'; ?>
			<?php if ($bo_hit) echo '<th scope="col">'.subject_sort_link('wr_hit', $qstr2, 1).'조회</a></th>'; ?>
			<?php if ($is_admin) echo '<th scope="col">관리</th>'; ?>
        </tr>
        </thead>
        <tbody>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <tr class="<?php if($list[$i]['is_notice']) echo "bo_notice"; ?>">
			<?=$table_td_checkbox[$i]?>
            <td class="td_num">
            <?php
            if($list[$i]['is_notice']) echo '<span class="boIcon_notice">공지</span>';
			else if($wr_id == $list[$i]['wr_id']) echo '<span class="bo_current">열람중</span>';
            else echo $list[$i]['num'];
            ?>
            </td>
            <td class="td_subject">
				<div class="skinOption-subject <?php if($list[$i]['wr_use']) echo 'use_'.$list[$i]['wr_use'];?>">
					<?php
					echo $icon_use[$i];					
					echo $boIcon_hot[$i];
					echo $boIcon_secret[$i];

					echo $a_link_txt[$i];
					echo $list[$i]['subject'];
					if($a_link_txt[$i]) echo '</a>';

					if(!$list[$i]['icon_secret']) echo $cate_link[$i];

					if($bo_comment && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span><span class="coCnt">'.$list[$i]['comment_cnt'].'</span><span class="sound_only">개</span>';

					echo $boIcon_file[$i]; //첨부파일
					echo $boIcon_img[$i]; //이미지
					echo $boIcon_video[$i]; //동영상
					echo $boIcon_attach[$i]; //첨부링크
					echo $boIcon_new[$i]; //새글	
					?>
				</div>
            </td>
            <?php if($bo_writer) echo '<td class="td_name">'.$list[$i]['writer'].'</td>'; ?>
			<?php if($bo_date) echo '<td class="td_date">'.registration_day($list[$i]['wr_datetime']).'</td>'; //passing_time($list[$i]['wr_datetime'])?>
			<?php if($is_good) echo '<td class="td_num">'.$list[$i]['wr_good'].'</td>'; ?>
            <?php if($bo_hit) echo '<td class="td_hit">'.$list_hit[$i].'</td>'; ?>
			<?php if($edit_href[$i]){
				echo '<td class="td_admin">';
				echo '	<a href="'.$edit_href[$i].'" class="myTip mini '.$includeOn[$i].'" data-tip="section_'.$list[$i]['wr_id'].'"><span class="btnEdit '.$btnEdit_class[$i].' '.$includeOn[$i].'">수정</span></a>';
				echo '</td>';
			}?>
        </tr>
        <?php } ?>
        <?php if(count($list) == 0) echo '<tr><td colspan="'.$colspan.'" class="empty_table" data-text="게시물이 없습니다."></td></tr>'; ?>
        </tbody>
        </table>
    </div>
	
	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

    </form>

	<?=$write_pages?>

</div>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>
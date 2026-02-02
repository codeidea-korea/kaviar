<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH .'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($search_skin_url.'/'.$css).'">', 4);
?>

<div id="Search-page-header">
	<fieldset id="sch_res_detail">			
	<form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
	<input type="hidden" name="srows" value="<?php echo $srows ?>">
	<input type="hidden" name="sfl" value="wr_subject||wr_content||mb_id||wr_name||wr_tag">
	<input type="hidden" name="sop" value="and">
	<?php if($group['gr_use_layout']) echo '<input type="hidden" name="gr_id" value="'.$group['gr_id'].'">'; ?>
		<span class="sch_wr">
			<input type="text" name="stx" value="<?=$text_stx?>" id="stx" required size="40" placeholder="검색어를 입력하세요">
			<button type="submit" class="btnSubmit">검색</button>
		</span>
		<script>
		function fsearch_submit(f) {
			if (f.stx.value.length < 2) {
				alert("검색어는 두글자 이상 입력하십시오.");
				f.stx.select();
				f.stx.focus();
				return false;
			}
			var cnt = 0;
			for (var i=0; i<f.stx.value.length; i++) {
				if (f.stx.value.charAt(i) == ' ')
					cnt++;
			}
			if (cnt > 1) {
				alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
				f.stx.select();
				f.stx.focus();
				return false;
			}
			f.action = "";
			return true;
		}
		</script>
	</form>	
	</fieldset>

	<?php if($stx && $board_count) {
		//$board_count <- 게시판수
		//number_format($total_page) <- 현재 페이지
		echo '<div id="sch_res_ov">';
		echo '<span class="stx">'.$stx.'</span> 관련 검색결과가 <span class="num">'.number_format($total_count).'건</span> 있습니다.';
		echo '</div>';

		echo '<ul id="sch_res_board">';
        echo '<li><a href="?'.$search_query.'&amp;gr_id='.$gr_id.'" '.$sch_all.'>전체게시판</a></li>';
        echo $str_board_list;
		echo '</ul>';
	} else {
		echo '<div class="empty_list" data-text="검색된 자료가 없습니다."></div>';
	} ?>
</div>


<div id="Search-page-result">
    <?php
	if($stx && $board_count) echo '<section class="sch_res_list">';
    $k=0;
    for($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
		echo '<div class="search_board_result">';
		echo '<div class="sbr-head">';
		echo '<span class="tableSubject"><a href="'.get_pretty_url($search_table[$idx], '', $search_query).'" title="게시판으로 이동">'.$bo_subject[$idx].'</a><sub>게시판 내 결과</sub></span>';
		echo '<a href="'.get_pretty_url($search_table[$idx], '', $search_query).'" class="sch_more">더보기</a>';
		echo '</div>';

		echo '<ul>';
		for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
			$thumb_info = get_list_thumbnail($search_table[$idx], $list[$idx][$i]['wr_id'], 140, 100);
			$search_thums = $thumb_info['src'];
			$file_img['file'] = get_file($search_table[$idx], $list[$idx][$i]['wr_id']);
			$search_file = $file_img['file']['0']['source'];
			$img = $search_file ? '<img src="'. $search_thums .'">' : '';

			if($list[$idx][$i]['wr_is_comment']) {
				$comment_def = '<span class="cmt_def"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">댓글</span></span> ';
				$comment_href = '#c_'.$list[$idx][$i]['wr_id'];
			} else {
				$comment_def = '';
				$comment_href = '';
			}
            echo '<li>';
			if($img) echo '<div class="sch-li-thumb"><a href="'.$list[$idx][$i]['href'].$comment_href.'">'.$img.'</a></div>';
			echo '<div class="sch-li-con">';
			echo '<div class="sch_tit">';
			echo '<a href="'.$list[$idx][$i]['href'].$comment_href.'" class="subject">'.$comment_def.$list[$idx][$i]['subject'].'</a>';
			echo '<a href="'.$list[$idx][$i]['href'].$comment_href.'" target="_blank" class="pop_a"><span class="sound_only">새창</span></a>';
			echo '</div>';
			echo '<p>'.$list[$idx][$i]['content'].'</p>';
			if($list[$idx][$i]['wr_tag']) {
				$list_tag[$idx][$i] = explode(",", $list[$idx][$i]['wr_tag']);
				echo '<div class="tagSet">';
				for ($t=0; $t<count($list_tag[$idx][$i]); $t++) {
					$tag_name = trim($list_tag[$idx][$i][$t]);
					if($tag_name=='') continue;			
					echo '<span class="tag'.($tag == $tag_name?' active':'').'">'.$tag_name.'</span>';
				}
				echo '</div>';
			}
			echo '<div class="sch_info">';
			echo $list[$idx][$i]['name'];
			echo '<span class="sch_datetime">'.$list[$idx][$i]['wr_datetime'].'</span>';
			echo '</div>';
			echo '</div>';
			echo '</li>';
		}
        echo '</ul>';
		echo '</div>';
	}//end for
	if($stx && $board_count) echo '</section>';
	
	echo $write_pages;
	?>
</div>
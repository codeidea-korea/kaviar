<?php
$prev_href = $listMove_skip ? '' : $prev_href;
$next_href = $listMove_skip ? '' : $next_href;
if(G5_IS_MOBILE) {
	if(!$board['bo_use_mobile_write']) $write_href = $update_href = false;
	$list_href = $search_href ? $search_href : $list_href;
	echo '<div class="bo_btnSet">';
	if($list_href || $prev_href || $next_href) {
		echo '<div class="moveList">';
			//if($prev_href) echo '<a href="'.$prev_href.'" class="btnMovePrev" alt="이전글">이전글</a>';
			echo '<a href="'.$list_href.'" class="_btn/lg/line w-full" alt="목록">목록으로</a>';
			//if($next_href) echo '<a href="'.$next_href.'" class="btnMoveNext" alt="다음글">다음글</a>';
		echo '</div>';
	}
	if($delete_href) echo '<a href="'.$delete_href.'" class="_btn/md/red" onclick="del(this.href); return false;" alt="삭제">삭제</a>';
	if($update_href) echo '<a href="'.$update_href.'" class="_btn/md/blue" alt="수정">수정</a>';
	if($reply_href && $board['bo_reply_level']) echo '<a href="'.$reply_href.'" class="btn_reply" alt="답글">답글</a>';	
	echo '</div>';

} else {
	//bo_btnSet
	$list_href = $search_href ? $search_href : $list_href;
	echo '<div class="bo_btnSet">';
	if($list_href || $prev_href || $next_href) {
		echo '<div class="moveList">';
		//if($prev_href) echo '<a href="'.$prev_href.'" class="btnMovePrev" alt="이전글"><span class="sort_subject">'.cut_str($prev_wr_subject, 18, "…").'</span></a>';
		echo '<a href="'.$list_href.'" class="btnMoveList" alt="목록">목록</a>';
		//if($next_href) echo '<a href="'.$next_href.'" class="btnMoveNext" alt="다음글"><span class="sort_subject">'.cut_str($next_wr_subject, 18, "…").'</span></a>';
		echo '</div>';
	}
	echo '<ul>';
	if($delete_href) echo '<li class="fleft"><a href="'.$delete_href.'" class="btn_del" onclick="del(this.href); return false;" alt="삭제">삭제</a></li>';
	if($update_href) echo '<li'.($is_admin?' class="myTip top mini '.$htmlOn.'" data-tip="section_'.$view['wr_id'].'"':'').'><a href="'.$update_href.'" class="btn_modify" alt="수정">수정</a></li>';
	if($copy_href) echo '<li><a href="'.$copy_href.'&boSkin='.$boSkin.'" class="btn_copy" onclick="board_move(this.href); return false;" alt="복사">복사</a></li>';
	//if($move_href) echo '<li><a href="'.$move_href.'" class="btn_move" onclick="board_move(this.href); return false;">이동</a></li>';
	if($reply_href && $board['bo_reply_level']) echo '<li><a href="'.$reply_href.'" class="btn_reply" alt="답글">답글</a></li>';
	//if($write_href) echo '<li><a href="'.$write_href.'" class="btn_write '.$bo_skin.'">'.$bo_btn_write_name.'</a></li>';
	echo '</ul>';
	echo '</div>';

}
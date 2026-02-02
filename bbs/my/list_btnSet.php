<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


//게시판 관리자 버튼
$tipInclude = '';
if($is_boTop || $is_boBottom) $tipInclude .= '(';
if($is_boTop) $tipInclude .= '&nbsp;bo_top&nbsp;';
if($is_boBottom) $tipInclude .= '&nbsp;bo_bottom&nbsp;';
if($is_boTop || $is_boBottom) $tipInclude .= ')';
$adminBtn = '<a href="'.$admin_href.'" class="myTip mini" data-tip="전체 게시물 '.number_format($total_count).'건 '.$tipInclude.'" alt="게시판 관리자"><span class="btn_admin">ADMIN</span></a>';

//글쓰기 버튼명
$bo_btn_write_name = $board['bo_btn_write_name'] ? $board['bo_btn_write_name'] : '글쓰기';

if($firstpage) $list_href = false;

if($board['bo_category_list'] && $board['bo_use_category'] && $_GET['sca']) $write_href = $write_href = short_url_clean(G5_BBS_URL.'/write.php?bo_table='.$bo_table.'&sca='.urlencode($sca));

if(G5_IS_MOBILE) {
	if(!$board['bo_use_mobile_write']) $write_href = false;
	if($list_href || $write_href) {
		echo '<div class="bo_btnSet listPage">';
		if($list_href) echo '<a href="'.$list_href.'" class="btn_list" alt="전체목록 보기">전체목록</a>';
		$writeIcon = $writeIcon ? $writeIcon : '';
		if($write_href) echo '<a href="'.$write_href.'" class="btn_write '.$writeIcon.'" alt="'.$bo_btn_write_name.'">'.$bo_btn_write_name.'</a>';
		echo '</div>';
	}
} else {
	if($list_href || $is_checkbox || $write_href) {
		echo '<div class="bo_btnSet"'.($bo_btnSet_root?' style="'.$bo_btnSet_root.'"':'').'>';
		if($is_checkbox) {
			echo '<div class="bo_adm_set">';
			if($admin_href) echo $adminBtn;
			echo '<span class="btnEditMode">EDIT-MODE</span>';
			//if(number_format($total_count) > 0) {
				echo '<ul class="ul-edit-mode">';				
					echo '<li class="edit-mode"><label class="btnChkall"><input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);"><span>전체선택</span></label></li>';
					echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택삭제" class="del" onclick="document.pressed=this.value"></li>';
					echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value"></li>';
					echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value"></li>';
					if($is_category)  echo '<li class="edit-mode"><input type="submit" name="btn_submit" value="선택분류" onclick="document.pressed=this.value"></li>';				
					if($is_admin == 'super') {
						echo '<li class="relative">';
						//echo '<a href="'.G5_ADMIN_URL.'/my/tmpCon.php" target="_blank" class="_adm_icon">테스트용 콘텐츠 관리</a>';
						echo '<a href="'.G5_BBS_URL.'/my/_auto_write_update.php?bo_table='.$bo_table.'&count=10" class="btn_tmpCon">테스트용 자동등록 X 10</a>';
						echo '</li>';
					}
				echo '</ul>';
			//}
			echo '</div>';
		}		
		if($list_href || $write_href) {
			$list_href_name = $bo_table == $config['cf_member_write_table'] ? '전체 회원':'전체목록';
			if($list_href) echo '<a href="'.$list_href.'" class="btn_list" alt="'.$list_href_name.' 보기">'.$list_href_name.'</a>';
			$writeIcon = $writeIcon ? $writeIcon : '';
			if($write_href && $bo_table != $config['cf_member_write_table']) {
				echo '<a href="'.$write_href.'" class="btn_write '.$writeIcon.'" alt="'.$bo_btn_write_name.'">'.$bo_btn_write_name.'</a>';
				if(file_exists($board_pcskin_path.'/_write_form.skin.php') && $is_admin == 'super') {
					echo '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_write_form&bo_table='.$bo_table.'&title=관리자 간편등록" class="pop_write popWin" data-width="1650" data-height="700" data-top="0" data-left="0">관리자 간편등록</a>';
				}
			}
		}
		echo '</div>';
	}
}
?>

<?php if($is_checkbox && !G5_IS_MOBILE) { ?>
<script>
$('.btnEditMode').click(function() {
	$(this).toggleClass('on');
	$('.ul-edit-mode, .edit-mode').toggleClass('on');
});
$(window).scroll(function() {
	let winHeight = $(window).height(),
		ypos = $('.btnEditMode').offset().top - winHeight,
		xpos = $('.btnEditMode').offset().left + 76;
	if( $(this).scrollTop() < ypos ) {
		$(".ul-edit-mode").addClass('fixed').css({'left':xpos});
	} else {
		$(".ul-edit-mode").removeClass('fixed').css({'left':''});
	}
});
</script>
<?php } ?>
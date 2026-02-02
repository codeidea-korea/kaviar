<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_javascript('<script src="'.G5_JS_URL.'/my/masonry/masonry.pkgd.min.js"></script>', 2);
?>

<div id="_faq_masonry" class="bo_gall">

	<div class="masonry_wrap" data-masonry='{"itemSelector":"<?=$blockID?> .gall_li", "columnWidth":"<?=$blockID?> .gall_li:not(.hide_li)", "gutter":<?=$gutter?>, "percentPosition":true,"horizontalOrder":true}'>

    <ul class="gall_ul">
        <?php for ($i=0; $i<count($list); $i++) { ?>
        <li class="gall_li">
            <div class="faqContents skinOption-text-align">
				<?php
				echo $a_link_txt[$i];
				if($isSubject[$i]) {
					echo '<div class="title skinOption-subject">';
					if($list[$i]['is_notice']) echo '<span class="gall_notice"></span>';
					if(isset($list[$i]['icon_hot']) && !$list[$i]['is_notice']) echo $list[$i]['icon_hot'];
					echo $list[$i]['wr_subject'];
					echo '</div>';
				}
				if($isContent[$i]) {
					echo '<div class="con skinOption-con">';
					echo $wr_content[$i];
					if($bo_reply && $list[$i]['comment_cnt']) echo '<span class="sound_only">댓글</span>'.$list[$i]['comment_cnt'].' <span class="sound_only">개</span>';
					if(isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
					echo '</div>';
				}
				if($a_link_txt[$i]) echo '</a>';
				
				echo $category_back[$i];
				echo $list_btn[$i];

				if($a_link[$i]) echo $a_link[$i].'<span class="more">더보기</span></a>';
				
				if($list_infoSet) {
					echo '<div class="list_infoSet">';
					echo $writeInfo[$i];
					echo $iconSet[$i];
					echo '</div>';
				}
				?>
            </div>
        </li>
        <?php } ?>
    </ul>
	</div>

	<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>'; ?>

</div>
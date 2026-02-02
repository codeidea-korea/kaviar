<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_MSHOP_SKIN_URL.'/style.css').'">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="v_header px15">
	<div class="title">상품후기 <span class="count">(<?=$total_count?>)</span></div>
	<a href="<?=$itemuse_form?>" class="pop-modal-review _btn/rd5/sm ic-arrow-right ml-auto">후기 작성하기</a>
</div>

<!--<div id="sit_use_wbtn">
    <a href="<?php echo $itemuse_form; ?>" class="qa_wr itemuse_form " onclick="return false;">사용후기 쓰기<span class="sound_only"> 새 창</span></a>
    <a href="<?php echo $itemuse_list; ?>" id="itemuse_list" class="btn01">더보기</a>
</div>-->

<div id="v_review_list">
	
	<!--
	상품 후기 대표 이미지?????????????????????????????????????
	<div id="review_latest_thumb" class="px15">
		<div class="swiper-container">
			<div class="swiper-wrapper">
				<div class="swiper-slide">
					<div class="thumb"><a href="#"><img src="<?=G5_THEME_IMG_URL?>/temp/thumb_182_182/img01.png"></a></div>					
				</div>
				<div class="swiper-slide">
					<div class="thumb"><a href="#"><img src="<?=G5_THEME_IMG_URL?>/temp/thumb_182_182/img02.png"></a></div>					
				</div>
				<div class="swiper-slide">
					<div class="thumb"><a href="#"><img src="<?=G5_THEME_IMG_URL?>/temp/thumb_182_182/img03.png"></a></div>					
				</div>
				<div class="swiper-slide">
					<div class="thumb"><a href="#"><img src="<?=G5_THEME_IMG_URL?>/temp/thumb_182_182/img04.png"></a></div>					
				</div>
			</div>
		</div>
	</div>
	-->

	<div class="flex flex-middle px15">
		<select class="selectpicker ml-auto rounded sort-grade">
			<option data-content="<div class='grade' data-score='1'><span class='score'>1.0</span><span class='star'></span></div>">1</option>
			<option data-content="<div class='grade' data-score='2'><span class='score'>2.0</span><span class='star'></span></div>">2</option>
			<option data-content="<div class='grade' data-score='3'><span class='score'>3.0</span><span class='star'></span></div>">3</option>
			<option data-content="<div class='grade' data-score='4'><span class='score'>4.0</span><span class='star'></span></div>">4</option>
			<option data-content="<div class='grade' data-score='5'><span class='score'>5.0</span><span class='star'></span></div>">5</option>
		</select>
	</div>
	

    <?php
    $thumbnail_width = 500;
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $is_num     = $total_count - ($page - 1) * $rows - $i;
        $is_star    = get_star($row['is_score']);
        $is_name    = get_text($row['is_name']);
        $is_subject = conv_subject($row['is_subject'],50,"…");
        $is_content = get_view_thumbnail(conv_content($row['is_content'], 1), $thumbnail_width);
		
        $is_reply_name = !empty($row['is_reply_name']) ? get_text($row['is_reply_name']) : '';
        $is_reply_subject = !empty($row['is_reply_subject']) ? conv_subject($row['is_reply_subject'],50,"…") : '';
        $is_reply_content = !empty($row['is_reply_content']) ? get_view_thumbnail(conv_content($row['is_reply_content'], 1), $thumbnail_width) : '';
        $is_time    = substr($row['is_time'], 2, 8);

        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);		

		//황팀 임시 추가.. ------------------------------------------
		$reviewCon[$i] = preg_replace("/<(.*?)\>/"," ",$is_content); 
		$reviewCon[$i] = preg_replace("/&nbsp;/"," ",$reviewCon[$i]); 
		$reviewCon[$i] = str_replace("//##", " ", $reviewCon[$i]);
		$reviewCon[$i] = cut_str($reviewCon[$i], 80, '…');
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $is_content, $match);
		$review_thumb[$i] = $match[0];
		// --------------------------------------------------------

        if ($i == 0) echo '<ul>';
    ?>

        <li id="re_li_<?=$is_num?>" class="re_list">			
			<div class="review_list_header review-toggle" data-target="#re_li_<?=$is_num?>">
				<span class="tag">BEST</span>
				<div class="grade" data-score="<?=$is_star?>"><span class="star"></span></div>
				<div class="writer"><?=$is_admin ? $is_name : mb_substr($is_name,0,-2)."**"?></div>
				<div class="date"><?=$is_time?></div>
			</div>				
			<div class="review_list_con">
				<div class="summary review-toggle" data-target="#re_li_<?=$is_num?>">
					<div class="con">
						<div class="option">[옵션] 양념 중하 새우장 360g</div>
						<?=$reviewCon[$i]?>
					</div>
					<?php if($review_thumb[$i]) echo '<div class="thumb">'.$review_thumb[$i].'</div>'; ?>
				</div>
				<div class="detail">
					<div class="con">
						<div class="option">[옵션] 양념 중하 새우장 360g</div>
						<?=$is_content?>
					</div>
					<?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
					<div class="btnSet">
						<a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="pop-modal _btn/sm/rd5" onclick="return false;">수정</a>
						<a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete _btn/sm/rd5/red">삭제</a>
					</div>
					<?php } ?>
				</div>
			</div>
        </li>

    <?php }

    if ($i > 0) echo '</ul>';

    if (!$i) echo '<p class="sit_empty">사용후기가 없습니다.</p>';
    ?>
</div>

<?php
echo itemuse_page($config['cf_mobile_pages'], $page, $total_page, G5_SHOP_URL."/itemuse.php?it_id=$it_id&amp;page=", "");
?>

<script>
//magnific-popup
$('.pop-modal-review').magnificPopup({
	type: 'ajax',
	fixedContentPos: true,
	fixedBgPos: true,
	closeOnContentClick: false, 
	closeOnBgClick: false,
	overflowY: 'auto',
	closeBtnInside: true,
});
$(document).on('click', '.modalClose', function (e) {
	e.preventDefault();
	$.magnificPopup.close();
});

//리뷰 토글
$(".review-toggle").click(function() {
	var target = $(this).attr('data-target');
	$(target).toggleClass('open');
});

//Swiper
var swiper =  new Swiper( '#review_latest_thumb .swiper-container', {
	spaceBetween: 15,
	slidesPerView: 3.5,
	centeredSlides: false,
	autoplay: false,
	loop: false
});



$(function(){
   $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.")) {
            return true;
        } else {
            return false;
        }
    });

    $(".pg_page").click(function(){
        //$("#itemuse").load($(this).attr("href"));
		$("#v_review").load($(this).attr("href"));		
        return false;
    });

    $("a#itemuse_list").on("click", function() {
        window.opener.location.href = this.href;
        self.close();
        return false;
    });

});
</script>
<!-- } 상품 사용후기 끝 -->
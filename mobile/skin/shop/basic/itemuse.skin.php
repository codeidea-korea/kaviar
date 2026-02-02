<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_MSHOP_SKIN_URL.'/style.css').'">', 0);
$itemuse_photolist = G5_SHOP_URL.'/itemusephotolist.php';
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="v_header px15">
	<div class="title">상품후기 <span class="count">(<?=$total_count?>)</span></div>
	<a href="<?=$itemuse_form?>" class="pop-modal-review _btn/rd5/sm/mainColor ic-arrow-right ml-auto">후기 작성하기</a>
</div>

<div id="v_review_list">
	
	<!-- 사진후기 썸네일 출력 8개 -->
	<ul id="review_latest_thumb">
		<?
		$review = explode ("-", $it_id);
		$photos = sql_query("select is_file,is_id,it_id from `g5_shop_item_use` where is_file != '' and is_confirm ='1' and it_id like '".$review[0]."%' order by is_id desc limit 6");
		$dirfile = G5_URL.'/data/member_review/';
		$chks;
		
		for ($a=0; $rowp=sql_fetch_array($photos); $a++) { 
			$photolist = explode(",",$rowp['is_file']);
			
			if($a==0){
				$chks = $photolist[0];
			}
			
			if($rowp['is_file']){
			
				if(count($photolist) > 1){

					for ($u=0; $u<count($photolist); $u++) { 
						$f_ex = explode('.',$photolist[$u]);
		
						if($f_ex[1] != "mp4"){
							echo '<li><a href="'.$itemuse_photolist.'?it_id='.$rowp['it_id'].'&is_id='.$rowp['is_id'].'"><img src="'.$dirfile.$photolist[$u].'"></a></li>';
						}
					}
				}else{
					
					echo '<li><a href="'.$itemuse_photolist.'?it_id='.$rowp['it_id'].'&is_id='.$rowp['is_id'].'"><img src="'.$dirfile.$photolist[0].'"></a></li>';
				}			
			}
			
		}
		
		if($chks) {
			echo '<li><a href="'.$itemuse_photolist.'?it_id='.$it['it_id'].'" class="more"><img src="'.$dirfile.$chks.'"></a></li>';
		}
		?>
	</ul>
	
	<div class="v_review_list_head">
		<?php
		if($default['shop_use_it_avg']) {
			if($it['it_use_avg'] > 0) {
				$it_use_avg = rtrim($it['it_use_avg'], ".0");
				if($it_use_avg > 0 && $it_use_avg < 1) $it_use_avg = 0.5;
				if($it_use_avg > 1 && $it_use_avg < 2) $it_use_avg = 1.5;
				if($it_use_avg > 2 && $it_use_avg < 3) $it_use_avg = 2.5;
				if($it_use_avg > 3 && $it_use_avg < 4) $it_use_avg = 3.5;
				if($it_use_avg > 4 && $it_use_avg < 5) $it_use_avg = 4.5;
				echo '<div class="grade fs17" data-score="'.$it_use_avg.'">';
					echo '<span class="score">'.$it['it_use_avg'].'</span><span class="star"></span>';
				echo '</div>';
			}
		}
		?>
		<div class="ml-auto">
			<select class="selectpicker">
				<option>최근 등록순</option>
				<option>평점 높은순</option>
				<option>평점 낮은순</option>
			</select>
		</div>
	</div>

	<?php if($default['shop_use_it_avg']) { ?>
	<!--<div class="flex flex-middle px15">
		<select class="selectpicker ml-auto rounded sort-grade">
			<option data-content="<div class='grade' data-score='1'><span class='score'>1.0</span><span class='star'></span></div>">1</option>
			<option data-content="<div class='grade' data-score='2'><span class='score'>2.0</span><span class='star'></span></div>">2</option>
			<option data-content="<div class='grade' data-score='3'><span class='score'>3.0</span><span class='star'></span></div>">3</option>
			<option data-content="<div class='grade' data-score='4'><span class='score'>4.0</span><span class='star'></span></div>">4</option>
			<option data-content="<div class='grade' data-score='5'><span class='score'>5.0</span><span class='star'></span></div>">5</option>
		</select>
	</div>-->
	<?php } ?>
	

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
		$reviewCon[$i] = cut_str($reviewCon[$i], 200, '…');
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $is_content, $match);
		$review_thumb[$i] = $match[0];
		// --------------------------------------------------------

        if ($i == 0) echo '<ul>';
    ?>

        <li id="re_li_<?=$is_num?>" class="re_list">			
			<div class="review_list_header review-toggle" data-target="#re_li_<?=$is_num?>">
				<!--<span class="tag">BEST</span>-->
				<?php if($default['shop_use_it_avg']) echo '<div class="grade" data-score="'.$is_star.'"><span class="star"></span></div>'; ?>
				<div class="writer"><?=$is_admin ? $is_name : mb_substr($is_name,0,-2)."**"?></div>
				<div class="date"><?=$is_time?></div>
			</div>				
			<div class="review_list_con">
				<div class="summary review-toggle" data-target="#re_li_<?=$is_num?>">
					<div class="con">
						<div class="subject"><?=$is_subject?></div>
						<?//=$reviewCon[$i]?>
					</div>
					<?php if($review_thumb[$i]) echo '<div class="thumb">'.$review_thumb[$i].'</div>'; ?>
				</div>
				<div class="detail">
					<div class="con" style="display:flex;flex-direction: column;">
						<!--<div class="subject"><?=$is_subject?></div>-->
						<?//=$is_content?>
						<?=$reviewCon[$i]?>
						<?php if($review_thumb[$i]) echo '<div class="thumb">'.$review_thumb[$i].'</div>'; ?>
							
						<?
						$mb_dir = substr($row['mb_id'],0,2);
						$img_chk = explode(",",$row['is_file']);
						$dirfile = G5_URL.'/data/member_review/';
						for($i=0; $i<count($img_chk); $i++){
							$f_ex = explode('.',$img_chk[$i]);

							if($f_ex[1] == "mp4"){
								// 비디오 플레이어 출력
								echo "<video style='width:30%;padding-top:2px;padding-bottom:2px' controls>
										<source src='".$dirfile.$img_chk[$i]."' type='video/mp4'>
									  </video>";
							} else {
								// 이미지 출력
								echo "<img src='".$dirfile.$img_chk[$i]."' style='width:15%;padding-top:2px;padding-bottom:2px'>";
							}
						
							/*<img src="<? echo $dirfile.$img_chk[$i]?>" style="width:15%">&nbsp;&nbsp;*/
						}
						?>
					</div>
					
					
					<div class="con" style="margin-top:20px;border-top:1px solid #e7e7e7;display:flex;">
						<div style="font-weight:bold;padding-top:10px;">
							답변 : 
						</div>
						<div style="pading-left:10xp;padding-top:10px;">
							<?=$is_reply_content?>
						</div>
					</div>
				
					<?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
					<div class="btnSet">
						<a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="pop-modal _btn/sm/rd5/gray" onclick="return false;">수정</a>
						<a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete _btn/sm/rd5/gray/line/transparent">삭제</a>
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
	closeBtnInside: true
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

	$("#review_latest_thumb a").click(function(){
        window.open(this.href, "itemuse_photolist", "width=600,height=680,scrollbars=1");
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

	// 20230919 상품평점별 소팅 추가
	var currentTitle = $(".sort-grade > .btn-default").attr("title");

	
	$(document).on('change',$(".sort-grade > .btn-default"), function (event) {
		var $sortEle = $(".sort-grade > .btn-default");
		
		
	// 자식 요소의 변화를 감지하고자 하는 동작을 여기에 작성합니다.
		
		if(currentTitle != $sortEle.attr("title") ){
			var is_score = parseInt($sortEle.attr("title"));
			var it_id = '<?= $it_id?>';
				$.ajax({
				type: "POST",
				url: "/shop/itemuse.php",
				data: {
					"is_score" : is_score,
					"it_id" : it_id
				},
				cache: false,
				async: false,
				success: function(data) {
				
					$("#v_review").children().remove();
					$("#v_review").append(data);
					$(".selectpicker").selectpicker();

					var desiredContent = "<div class='grade' data-score='"+is_score+"'><span class='score'>"+is_score+".0</span><span class='star'></span></div>";
					
					// .selectpicker 요소 내에서 해당 텍스트와 일치하는 옵션을 찾아 선택합니다.
					$(".selectpicker option").each(function() {
					if ($(this).data('content') === desiredContent) {
						$(this).prop('selected', true);
					}
					});

					// .selectpicker 요소를 업데이트하여 선택된 옵션을 표시합니다.
					$(".selectpicker").selectpicker('refresh');
				
					currentTitle = $sortEle.attr("title");
					
				}
			});
		}
		currentTitle =  $sortEle.attr("title");
	
	});
});
</script>
<!-- } 상품 사용후기 끝 -->
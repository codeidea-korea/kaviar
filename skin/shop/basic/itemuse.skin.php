<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_SHOP_SKIN_URL.'/skin.css').'">', 0);

$itemuse_photolist = G5_SHOP_URL.'/itemusephotolist.php';
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 상품 사용후기 시작 { -->
<section id="sit_use_list">
    <h3>등록된 사용후기</h3>

    <div class="sit_use_top">
		<h4>상품후기 (<?=$total_count?>)</h4>
        <div id="sit_use_wbtn">
            <a href="<?php echo $itemuse_form; ?>" class="itemuse_form">후기 작성하기<span class="sound_only"> 새 창</span></a>
			<!--<a href="<?php echo $itemuse_list; ?>" class="btn01 itemuse_list">더보기</a>-->
        </div>
    </div>
	
	<!-- 사진후기 썸네일 출력 7개 -->
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
	
		<!--
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>&is_id=1"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		<li><a href="<?=$itemuse_photolist?>?it_id=<?=$it['it_id']?>" class="more"><?=get_it_thumbnail($it['it_img1'], 115, 115)?></a></li>
		-->
	</ul>
	
	<div class="sit_use_list_head">
		<?php
		if($default['shop_use_it_avg']) {
			if($it['it_use_avg'] > 0) {
				$it_use_avg = rtrim($it['it_use_avg'], ".0");
				if($it_use_avg > 0 && $it_use_avg < 1) $it_use_avg = 0.5;
				if($it_use_avg > 1 && $it_use_avg < 2) $it_use_avg = 1.5;
				if($it_use_avg > 2 && $it_use_avg < 3) $it_use_avg = 2.5;
				if($it_use_avg > 3 && $it_use_avg < 4) $it_use_avg = 3.5;
				if($it_use_avg > 4 && $it_use_avg < 5) $it_use_avg = 4.5;
				echo '<div class="grade fs20" data-score="'.$it_use_avg.'">';
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
		$img_chk = explode(",",$row['is_file']);
        $hash = md5($row['is_id'].$row['is_time'].$row['is_ip']);

		//황팀 임시 추가.. ------------------------------------------
		$is_content_tmp = get_view_thumbnail(conv_content($row['is_content'], 1), 100);
		$reviewCon[$i] = preg_replace("/<(.*?)\>/"," ",$is_content_tmp); 
		$reviewCon[$i] = preg_replace("/&nbsp;/"," ",$reviewCon[$i]); 
		$reviewCon[$i] = str_replace("//##", " ", $reviewCon[$i]);
		$reviewCon[$i] = cut_str($reviewCon[$i], 200, '…');
		preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $is_content_tmp, $match);
		$review_thumb[$i] = $match[0];
		// --------------------------------------------------------

        if ($i == 0) echo '<ol id="sit_use_ol">';
    ?>

        <li id="sit_use_li_id_<?=$row['is_id']?>" class="sit_use_li">
			<div class="writer"><?=$is_admin ? $is_name : mb_substr($is_name,0,-2)."**"?></div>
			<?php if($default['shop_use_it_avg']) echo '<div class="grade" data-score="'.$is_star.'"><span class="star"></span></div>'; ?>
			
			<div class="sit_reCon">
				<div class="sit_re_subject">
					<div class="txt"><?=$is_subject?></div>
					<?php
					$img_chk = explode(",",$row['is_file']);
					if($img_chk[0]){
						$dirfile = G5_URL.'/data/member_review/';
						for($u=0; $u<1; $u++){
							echo '<div class="thumb"><img src="'.$dirfile.$img_chk[$u].'"></div>';
						}
					}
					?>
				</div>
				
				<div id="sit_use_con_<?php echo $i; ?>" class="sit_use_con">
					<?php echo $is_content."<br><br>"; // 사용후기 내용 ?>
					<div class="sit_use_p" style="display:flex;align-items: center;">
						

						<?
						
						for($u=0; $u<count($img_chk); $u++){
							
							$f_ex = explode('.',$img_chk[$u]);
							
							if($f_ex[1] == "mp4"){
								// 비디오 플레이어 출력
								echo "<video style='padding-left:5px;padding-right:5px;max-width:25% !important;' controls>
										<source src='".$dirfile.$img_chk[$u]."' type='video/mp4'>
									  </video>";
							} else {
								// 이미지 출력
								echo "<img src='".$dirfile.$img_chk[$u]."' style='padding-left:5px;padding-right:5px;max-width:25% !important;'>";
							}
						}
						?>
					</div>

					<?php if ($is_admin || $row['mb_id'] == $member['mb_id']) { ?>
					<div class="sit_use_cmd">
						<a href="<?php echo $itemuse_form."&amp;is_id={$row['is_id']}&amp;w=u"; ?>" class="itemuse_form _btn/small/gray" onclick="return false;">수정</a>
						<a href="<?php echo $itemuse_formupdate."&amp;is_id={$row['is_id']}&amp;w=d&amp;hash={$hash}"; ?>" class="itemuse_delete _btn/small/gray/line/transparent">삭제</a>
					</div>
					<?php } ?>

					<?php if( $is_reply_content ){  //  사용후기 답변 내용이 있다면 ?>
					<div class="sit_use_reply" style="display:flex;justify-content: space-between;align-items: center;">
						<div class="use_reply_p" style="width:80%"><?=$is_reply_content?></div>
						<div>
							<div class="use_reply_name"><?=$is_reply_name?></div>
							<!--<div class="use_reply_tit"><?=$is_reply_subject?></div>-->
						</div>	
					</div>
					<?php } //end if ?>
				</div>
			</div>
			
			
			<div class="right" style="">				
				<?php// if($review_thumb[$i]) echo '<div class="thumb">'.$review_thumb[$i].'</div>'; ?>
				<div class="date"><?=$is_time?></div>
			</div>
        </li>

    <?php }

    if ($i > 0) echo '</ol>';

    if (!$i) echo '<p class="sit_empty">사용후기가 없습니다.</p>';
    ?>
</section>

<?php
echo itemuse_page($config['cf_write_pages'], $page, $total_page, G5_SHOP_URL."/itemuse.php?it_id=$it_id&amp;page=", "");
?>

<script>
$(function(){
    $(".itemuse_form").click(function(){
        window.open(this.href, "itemuse_form", "width=810,height=680,scrollbars=1");
        return false;
    });

	$("#review_latest_thumb a").click(function(){
        window.open(this.href, "itemuse_photolist", "width=810,height=680,scrollbars=1");
        return false;
    });

    $(".itemuse_delete").click(function(){
        if (confirm("정말 삭제 하시겠습니까?\n\n삭제후에는 되돌릴수 없습니다.")) {
            return true;
        } else {
            return false;
        }
    });

	$(".sit_re_subject").click(function(){
        var $li = $(this).parent().parent(".sit_use_li");
		var $con = $(this).siblings(".sit_use_con");
        if($con.is(":visible")) {			
			$li.removeClass('open');
            $con.slideUp();
        } else {
			$li.addClass('open');
            $(".sit_use_con:visible").hide();
            $con.slideDown(
                function() {
                    // 이미지 리사이즈
                    $con.viewimageresize2();
                }
            );
        }
    });

    $(".pg_page").click(function(){
        $("#itemuse").load($(this).attr("href"));
        return false;
    });
});
</script>
<!-- } 상품 사용후기 끝 -->